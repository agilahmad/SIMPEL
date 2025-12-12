<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PilkadaPemohon;
use App\Models\PilkadaKuasaPemohon;

class PilkadaPemohonController extends Controller
{
    public function index()
        {
            return view('backend.pilkada-pemohon.index');
        }

    public function store(Request $request) {

        $existingDraft = PilkadaPemohon::where('user_id', Auth::id())
        ->where('status', 'draft')
        ->first();

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

            $php = PilkadaPemohon::updateOrCreate([
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

    public function storeKuasa(Request $request){

        $validated = $request->validate([
            'is_advokat' => 'sometimes|boolean',
            'nik' => 'required|digit:16',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'nullable|numeric',
            'handphone' => 'required|numeric',
            'file_ktp' => 'required|file|mimes:jpg,jpeg,png',
            'tanggal_surat' => 'required|date',
            'nomor_anggota' => [Rule::requiredIf($request->is_advokat), 'nullable', 'string'],
            'nama_organisasi' => [Rule::requiredIf($request->is_advokat), 'nullable', 'string'],
            'file_kta' => [Rule::requiredIf($request->is_advokat), 'nullable', 'string'],
        ]);

        if($request->hasFile('file_ktp')){
            $validated['file_ktp'] = $request->file('file_ktp')->store('uploads/pilkada-kuasa/ktp', 'public');
        }

        if($request->hasFile('file_kta')){
            $validated['file_kta'] = $request->file('file_kta')->store('uploads/pilkada-kuasa/kta', 'public');
        }

        $kuasa = PilkadaKuasaPemohon::create($validated);

        return response()->json([
            'success' => 'success',
            'message' => 'Data berhasil disimpan',
            'data' => $kuasa
        ]);
    }

    public function editPemohon($id): JsonResponse {

        try{
            $pemohon = PilkadaPemohon::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $pemohon
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Permohonan gagal diubah karena : ' . $e->getMessage(),
            ], 500);
        }
    }

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

}
