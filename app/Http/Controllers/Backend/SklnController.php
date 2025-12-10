<?php

namespace App\Http\Controllers;

use App\Models\Skln;
use App\Models\SklnBerkas;
use App\Models\SklnKuasa;
use App\Models\SklnPemohon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class SklnController extends Controller
{
    public function store(): JsonResponse{


        $validated = request()->validate([
            'pokok_permohonan' => 'nullable|string|max:255',
        ], [
            'pokok_permohonan.required' => 'Pokok permohonan wajib diisi',
        ]);
        try{
            $permohonan = Skln::updateOrCreate([
                'user_id' => Auth::id(),
                'status' => 'draft',

            ], [
                'pokok_permohonan' => $validated['pokok_permohonan'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil ditambahkan',
                'data' => $permohonan,
            ], 201);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Permohonan gagal diajukan karena : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function storePemohon(Request $request, $id): JsonResponse {

        $validated = $request->validate([
            'nik' => 'required|string|size:16',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'handphone' => 'required|string|max:20',
            'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nama.required' => 'Nama wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'email.required' => 'Email wajib diisi',
            'handphone.required' => 'Handphone wajib diisi',
            'file_ktp.required' => 'Ukuran file maksimal 2MB',
        ]);
        try{
            $skln = Skln::findOrFail($id);

            $pathKtp = null;
            if($request->hasFile('file_ktp')){
                $fileKtp = $request->file('file_ktp');
                $filename = time() . '_' . $fileKtp->getClientOriginalName();
                $pathKtp = $fileKtp->storeAs("uploads/skln/{$id}/ktp", $filename, 'public');
            }

            $pemohon = $skln->skln_pemohon()->create([
                'nik' => $validated['nik'],
                'nama' => $validated['nama'],
                'alamat' => $validated['alamat'],
                'email' => $validated['email'],
                'telepon' => $validated['telepon'],
                'handphone' => $validated['handphone'],
                'file_ktp' => $pathKtp,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data pemohon berhasil ditambahkan',
                'data' => $pemohon,
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Data pemohon gagal ditambahkan karena : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function storeKuasa(Request $request, $id): JsonResponse {

        $isAdvokat = $request->boolean('is_advokat');

        $validated = $request->validate([
            'nik' => 'required|string|size:16',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'nullable|numeric',
            'handphone' => 'required|numeric',
            'file_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'tanggal_surat' => 'required|date',
            'is_advokat' => 'nullable',
            'nomor_anggota' => [Rule::requiredIf($request->is_advokat), 'nullable', 'string'],
            'nama_organisasi' => [Rule::requiredIf($request->is_advokat), 'nullable', 'string'],
            'file_kta' => [Rule::requiredIf($request->is_advokat), 'nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'file_kta.required' => 'File KTA/BAS wajib diunggah untuk advokat',
            'nomor_anggota.required' => 'Nomor anggota wajib diisi untuk advokat',
        ]);
        try{
            $skln = Skln::findOrFail($id);

            $pathKtp = null;
            if($request->hasFile('file_ktp')){
                $fileKtp = $request->file('file_ktp');
                $filename = time() . '_' . $fileKtp->getClientOriginalName();
                $pathKtp = $fileKtp->storeAs("uploads/skln/{$id}/ktp", $filename, 'public');
            }

            $pathKta = null;
            if($isAdvokat && $request->hasFile('file_kta')){
                $fileKta = $request->file('file_kta');
                $filenameKta = time() . '_' . $fileKta->getClientOriginalName();
                $pathKta = $fileKta->storeAs("uploads/skln/{$id}/kta", $filenameKta, 'public');
            }

            $kuasa = $skln->kuasa()->create([
                'is_advokat' => $isAdvokat,
                'nik' => $validated['nik'],
                'nama' => $validated['nama'],
                'alamat' => $validated['alamat'],
                'email' => $validated['email'],
                'telepon' => $validated['telepon'],
                'handphone' => $validated['handphone'],
                'tanggal_surat' => $validated['tanggal_surat'],
                'file_ktp' => $pathKtp,
                'nomor_anggota' => $isAdvokat ? $request->nomor_anggota : null,
                'nama_organisasi' => $isAdvokat ? $request->nama_organisasi : null,
                'file_kta' => $pathKta,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data kuasa berhasil ditambahkan',
                'data' => $kuasa,
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Data kuasa gagal ditambahkan karena : ' . $e->getMessage(),
            ], 500);
        }
    }
    public function storeBerkas(Request $request, $id) {

        $request->validate([
            'jenis_berkas' => 'required|string',
            // 'nama_berkas' => 'required|string',
            'path_berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $skln = Skln::findOrFail($id);
        $file = $request->file('path_berkas');
        $nameFile = $file->getClientOriginalName();
        $path = $file->storeAs(
            "upload/skln/{$id}/" . $request->jenis_berkas,
            time() . '_' . $nameFile,
            'public'
        );

        $singleFile = ["permohonan_pdf", "permohonan_doc", "daftar_bukti_pdf", "daftar_bukti_doc", "alat_bukti"];

        if(in_array($request->jenis_berkas, $singleFile)){
            $existing = SklnBerkas::where('skln_id', $id)
                ->where('jenis_berkas', $request->jenis_berkas)
                ->first();

                if($existing){
                Storage::disk('public')->delete($existing->path_berkas);
                }
                $berkas = SklnBerkas::updateOrCreate([
                    'skln_id' => $id,
                    'jenis_berkas' => $request->jenis_berkas,
                ], [
                    'path_berkas' => $path,
                    'nama_berkas' => $nameFile,
                ]);
        }else{
            $berkas = SklnBerkas::create([
                'skln_id' => $id,
                'jenis_berkas' => $request->jenis_berkas,
                'nama_berkas' => $nameFile,
                'path_berkas' => $path,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil diunggah',
                'data' => $berkas,
            ]);
        }
    }

    public function storeBerkasTambahan(Request $request, $id): JsonResponse{

        $validated = $request->validate([

            'nama_berkas' => 'required|string',
            'path_berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'nama_berkas.required' => 'Nama berkas wajib diisi',
            'path_berkas.required' => 'Ukuran file maksimal 5MB',
        ]);

        try{
            $skln = Skln::findOrFail($id);
            $file = $request->file('path_berkas');
            $nameFile = $file->getClientOriginalName();
            $path = $file->storeAs(
                "upload/skln/{$id}/alat_bukti",
                time() . '_' . $nameFile,
                'public'
            );

            $berkas = $skln->berkas()->create([
                'jenis_berkas' => 'alat_bukti',
                'path_berkas' => $path,
                'nama_berkas' => $nameFile
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil diunggah',
                'data' => $berkas
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Berkas gagal diunggah karena : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id){

        $skln = Skln::with([
            'pemohon',
            'kuasa',
            'berkas',
        ])->findOrFail($id);

        if($skln->user_id !== Auth::id()){

            return response()->json(['massage' => 'Unauthorized'], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $skln
        ]);
    }

    public function update(Request $request, $id): JsonResponse{

        $validated = $request->validate([
            'pokok_permohonan' => 'required|string',
        ], [
            'pokok_permohonan.required' => 'Pokok permohonan wajib diisi',
        ]);

        try{
            $skln = Skln::findOrFail($id);

            $skln->update([
                'pokok_permohonan' => $validated['pokok_permohonan'],
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil diubah',
                'data' => $skln
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Permohonan gagal diubah karena : ' . $e->getMessage(),
            ], 500);
        }
    }

    public function submit($id): JsonResponse{

        $skln = Skln::with(['skln_pemohon', 'skln_kuasa', 'skln_berkas'])->findOrFail($id);

        if(empty($skln->pokok_permohonan)){
            return response()->json([
                'success' => false,
                'message' => 'Pokok permohonan wajib diisi',
            ], 422);
        }

        if($skln->pemohon->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'Pemohon wajib diisi',
            ]);
        }

        $uploadFile = $skln->berkas->pluck('jenis_berkas')->toArray();

        $wajib = ['permohonan_pdf', 'permohonan_doc'];

        foreach($wajib as $jenis){
            if(!in_array($jenis, $uploadFile)){
                return response()->json([
                    'success' => false,
                    'message' => 'Berkas wajib diunggah',
                ], 422);
            }
        }
        $skln->update([
            'status' => 'SUBMITTED',
            'tanggal_pengajuan' => now(),
        ]);

        return response()->json([
           'success' => true,
           'message' => 'Permohonan berhasil disubmit',
           'redirect' => route('/dashboard')
        ]);
    }

    public function sementara($id): JsonResponse{

        return response()->json([
            'success' => true,
            'message' => 'Permohonan berhasil disimpan sementara',
            'redirect' => route('/dashboard')
        ]);
    }

    public function destroy($id): JsonResponse{

        try{

            $skln = Skln::findOrFail($id);

            $skln->delete();

            return response()->json([
               'success' => true,
               'message' => 'Permohonan berhasil dihapus',
               'redirect' => route('/dashboard')
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Permohonan gagal dihapus karena : ' . $e->getMessage(),
            ], 500);
        }
    }
}
