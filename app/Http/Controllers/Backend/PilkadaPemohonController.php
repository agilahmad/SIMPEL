<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\PilkadaPemohon;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\PilkadaKuasaPemohon;
use App\Http\Controllers\Controller;
use App\Models\PilkadaBerkasPemohon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PilkadaPemohonController extends Controller
{
    public function store(Request $request): JsonResponse {

        $user = Auth::user();

        $existingDraft = PilkadaPemohon::where('user_id', Auth::id())
        ->where('status', 'draft')
        ->exists();

        if($existingDraft){
            return response()->json([
                'success' => false,
                'message' => 'Mohon anda isi kelengkapan permohonan yang telah anda ajukan',
            ]);
        }

        $isPilkadaTk2 = in_array($request->jenis_pemilihan, ['walikota', 'bupati']);

        $validated = request()->validate([
            
            'jenis_pemilihan' => 'required|string|in:gubernur, walikota, bupati',
            'nama_provinsi' => 'required|string',
            'nama_daerah' => [Rule::requiredIf($isPilkadaTk2), 'nullable', 'string'],
            'no_urut' => 'required|string',
            'pokok_permohonan' => 'nullable|string',
        ]);

        try{

            $php = PilkadaPemohon::create([
                'user_id' => Auth::id(),
                'jenis_pemilihan' => $validated['jenis_pemilihan'],
                'nama_provinsi' => $validated['nama_provinsi'],
                'nama_daerah' => $isPilkadaTk2 ? $validated['nama_daerah'] : null,
                'no_urut' => $validated['no_urut'],
                'pokok_permohonan' => $validated['pokok_permohonan'],
                'status' => 'draft',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil ditambahkan',
                'data' => $php,
                'redirect_url' => route('php.edit', $php->id),
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Permohonan gagal diubah karena : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function storeKuasa(Request $request): JsonResponse {

        $rules =[
            'pilkada_pemohon_id' => 'required|exists:pilkada_pemohon,id',
            'is_advokat' => 'required|boolean',
            'nik' => 'required|digit:16',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'nullable|numeric',
            'handphone' => 'required|numeric',
            'file_ktp' => 'required|file|mimes:jpg,jpeg,png',
            'tanggal_surat' => 'required|date',
        ];

        if ($request->boolean('is_advokat')) {
            $rules['nomor_anggota_advokat']   = 'required|string';
            $rules['nama_organisasi_advokat'] = 'required|string';
            $rules['file_kta']            = 'required|file|mimes:pdf,jpg|max:2048';
        }

        $validated = $request->validate($rules);

        if($request->boolean('is_advokat')) {
            $validated['file_kta'] = $request->file('file_kta')->store('upload/pilkada-pemohon/kuasa/kta');
        }

        $kuasa = PilkadaKuasaPemohon::create($validated);

        return response()->json([
            'success' => 'success',
            'message' => 'Data berhasil disimpan',
            'data' => $kuasa
        ]);
    }

    public function storeBerkas(Request $request): JsonResponse{

        $request->validate([
            'pilkada_pemohon_id' => 'required|exists:pilkada_pemohon,id',
            'nama_berkas' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $permohonan = PilkadaPemohon::findOrFail($request->pilkada_pemohon_id);

        if($permohonan->user_id !== Auth::id() || $permohonan->status !== 'draft'){
            return response()->json(['message' => 'tidak dapat menambahkan berkas pada permohonan ini'], 403);
        }

        if($request->hasFile('file_berkas')) {
            $file = $request->file('file_berkas');
            $path = $file->storeAs(
                'upload/pilkada-pemohon/berkas/' . $permohonan->id,
                time() . '_' . $file->getClientOriginalName(),
                'public');
        }

        $save = PilkadaBerkasPemohon::create([
            'pilkada_pemohon_id' => $request->pilkada_pemohon_id,
            'nama_berkas' => $request->nama_berkas,
            'file_path' => $path,
            'tipe_file' => $file->getClientOriginalExtension(),
            'ukuran_file' => $file->getSize(),
        ]);

        return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil diunggah',
                'data'    => $save
            ], 201);
    }

    // public function editPemohon($id): JsonResponse {

    //     try{
    //         $pemohon = PilkadaPemohon::findOrFail($id);

    //         return response()->json([
    //             'success' => true,
    //             'data' => $pemohon
    //         ]);
    //     }catch(\Exception $e){
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Permohonan gagal diubah karena : ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function update(Request $request, $id): JsonResponse{

        $pemohon = PilkadaPemohon::findOrFail($id);

        $validated = $request->validate([
            'nik' => 'required|digit:16',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'nullable|numeric',
            'handphone' => 'required|numeric',
            'file_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        if($request->hasFile('file_ktp')){

            if($pemohon->path_ktp){
                Storage::delete($pemohon->path_ktp);
            }
            $validated['path_ktp'] = $request->file('file_ktp')->store('upload/pilkada-pemohon/ktp');
        }

        $pemohon->update($validated);

        return response()->json([
            'success' => 'success',
            'message' => 'Permohonan berhasil diubah',
            'data' => $pemohon
        ], 200);
    }

    public function submit($id): JsonResponse {

        $pemohon = PilkadaPemohon::with(['dataPemohon', 'kuasaPemohon', 'berkasPemohon'])->findOrFail($id);

        if($pemohon->user_id !== Auth::id()){
            return response()->json(['message' => 'Tidak dapat mengirim permohonan ini'], 403);
        }

        $pemohonLengkap = $pemohon->dataPemohon->every(function($p){
            return !empty($p->nik) && !empty($p->file_ktp);
        });

        if(!$pemohonLengkap){
            return response()->json([
                'success' => false,
                'message' => 'Data pemohon belum lengkap. Mohon lengkapi data pemohon sebelum mengirim permohonan.',
            ]);
        }

        $pemohon->update([
            'status' => 'submitted',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permohonan berhasil dikirim',
        ]);
    }

    public function draft($id): JsonResponse {

        $pemohon = PilkadaPemohon::findOrFail($id);

        if($pemohon->user_id !== Auth::id()){
            return response()->json(['message' => 'Tidak dapat menyimpan permohonan ini'], 403);
        }

        $pemohon->update([
            'status' => 'draft',
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permohonan berhasil disimpan sebagai draft',
        ]);
    }

    public function destroy($id): JsonResponse{

        $pemohon = PilkadaPemohon::with(['dataPemohon', 'kuasaPemohon', 'berkasPemohon'])->findOrFail($id);

        if($pemohon->user_id !== Auth::id()){
            return response()->json(['message' => 'Tidak dapat menghapus permohonan ini'], 403);
        }

        DB::transaction(function () use ($pemohon){
            foreach($pemohon->dataPemohon as $data){
                if($data->file_ktp && Storage::disk('public')->exists($data->file_ktp)){
                    Storage::disk('public')->delete($data->file_ktp);
                }
            }

            foreach($pemohon->kuasaPemohon as $kuasa){
                $files = [$kuasa->file_ktp, $kuasa->file_kta];
                foreach($files as $file){
                    if($file && Storage::disk('public')->exists($file)){
                        Storage::disk('public')->delete($file);
                    }
                }
            }

            foreach($pemohon->berkasPemohon as $berkas){
                if($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)){
                    Storage::disk('public')->delete($berkas->file_path);
                }
            }

            $pemohon->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Permohonan berhasil dihapus',
        ]);
    }

}
