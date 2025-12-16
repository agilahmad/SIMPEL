<?php

namespace App\Http\Controllers\Backend;

use App\Models\Paslon;
use Illuminate\Http\Request;
use App\Models\PilkadaPemohon;
use App\Models\PilkadaTerkait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\PilkadaTerkaitKuasa;
use App\Http\Controllers\Controller;
use App\Models\PilkadaTerkaitBerkas;
use App\Models\PilkadaTerkaitDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PilkadaTerkaitController extends Controller
{
    public function getDaftar(): JsonResponse {

        $data = PilkadaPemohon::where('status', 'submitted')->latest()->get();

        return response()->json($data);
    }

    public function getPaslon($pilkadaPemohonId): JsonResponse {

        $data = PilkadaPemohon::findOrFail($pilkadaPemohonId);
        $query = Paslon::query();

        if($data->jenis_pemilihan == 'gubernur'){
            $query->where('id_provinsi', $data->id_provinsi);
        } else {
            $query->whereIn('id_daerah', $data->id_daerah);
        }

        $query->where('id', '!=', $data->no_urut);

        return response()->json($query->get());
    }
    public function store(Request $request): JsonResponse {

        $request->validate([
            'pilkada_pemohon_id' => 'required|exists:pilkada_pemohon,id',
            'paslon_id' => 'required|exists:paslon,id',
        ]);
        $data = PilkadaPemohon::find($request->pilkada_pemohon_id);
        if($data->no_urut == $request->paslon_id){
            return response()->json(['message' => 'Paslon terkait tidak boleh sama dengan pemohon'], 422);
        }

        $paslon = Paslon::with('kandidats')->findOrFail($request->paslon_id);

        return DB::transaction(function () use ($request, $paslon){
            $permohonan = PilkadaTerkait::create([
                'user_id' => Auth::id(),
                'pilkada_pemohon_id' => $request->pilkada_pemohon_id,
                'paslon_id' => $request->paslon_id,
                'status' => 'draft',
            ]);

            foreach($paslon->kandidat as $kandidat){
                $permohonan->pilkadaterkait()->create([
                    'nama' =>$kandidat->nama,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data pemohon terkait berhasil ditambahkan',
                'data' => $permohonan->load('pilkadaterkait'),
            ], 201);
        });
    }
    public function storeKuasa(Request $request): JsonResponse {

        $request->validate([
            'pilkada_terkait_id' => 'required|exists:pilkada_terkait,id',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'nullable|string|nullable',
            'handphone' => 'required|string',
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg',
            'tanggal_surat' => 'required|date',
            'nomor_anggota' => 'required|string|nullable',
            'nama_organisasi' => 'required|string|nullable',
            'file_kta' => 'nullable|file|mimes:pdf,jpg|nullable',
        ]);

        $data = $request->all();
        if($request->hasFile('file_ktp')){
            $data['file_ktp'] = $request->file('file_ktp')->store('upload/pilkada-terkait/kuasa/ktp');
        }
        if($request->hasFile('file_kta')){
            $data['file_kta'] = $request->file('file_kta')->store('upload/pilkada-terkait/kuasa/kta');
        }

        $kuasa = PilkadaTerkaitKuasa::create($data);
        return response()->json([
            'message' => 'Data kuasa berhasil disimpan',
            'data' => $kuasa
        ]);
    }
    public function storeBerkas(Request $request): JsonResponse {

        $request->validate([
            'pilkada_terkait_id' => 'required|exists:pilkada_terkait,id',
            'nama_berkas' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $path = $request->file('file_berkas')->store('upload/pilkada-terkait/berkas');

        $berkas = PilkadaTerkaitBerkas::create([
            'pilkada_terkait_id' => $request->pilkada_terkait_id,
            'nama_berkas' => $request->nama_berkas,
            'file_path' => $path,
        ]);

        return response()->json([
            'message' => 'Berkas berhasil diunggah',
            'data' => $berkas
        ]);
    }
    public function update(Request $request, $id): JsonResponse {

        $pemohon = PilkadaTerkaitDetail::findOrFail($id);

        $request->validate([
            'nik' => 'required|digits:16',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'nullable|string|nullable',
            'handphone' => 'required|string',
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg',
        ]);

        $data = $request->except(['file_ktp']);

        if($request->hasFile('file_ktp')){
            $data['file_ktp'] = $request->file('file_ktp')->store('upload/pilkada-terkait/kandidat/ktp');
        }

        $pemohon->update($data);

        return response()->json([
            'message' => 'Data kandidat berhasil diupdate',
            'data' => $pemohon,
        ]);
    }
    public function destroy($id): JsonResponse {

        $data = PilkadaTerkait::with(['pilkadaterkait', 'pilkadaterkaitkuasa', 'pilkadaterkaitberkas'])->findOrFail($id);

        if($data->user_id !== Auth::id() || $data->status !== 'draft'){
            return response()->json(['message' => 'Tidak dapat menghapus data permohonan ini'], 403);
        }

        DB::transaction(function () use ($data) {
            foreach($data->pilkadaterkait as $detail){
                if($detail->file_ktp) Storage::disk('public')->delete($detail->file_ktp);
            }
            foreach($data->pilkadaterkaitkuasa as $kuasa){
                if($kuasa->file_ktp) Storage::disk('public')->delete($kuasa->file_ktp);
                if($kuasa->file_kta) Storage::disk('public')->delete($kuasa->file_kta);
            }
            foreach($data->pilkadaterkaitberkas as $berkas){
                if($berkas->file_path) Storage::disk('public')->delete($berkas->file_path);
            }
            $data->delete();
        });

        return response()->json([
            'message' => 'Data permohonan berhasil dihapus',
        ]);
    }
}
