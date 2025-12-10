<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'nama' => $user->nama,
            'email' => $user->email,
            'noTelp' => $user->noTelp,
            'nik' => $user->nik,
            'alamat' => $user->alamat,
            'fotoKtp' => $user->fotoKtp,
            'role' => $user->role,
            'createdAt' => $user->createdAt,
            'updatedAt' => $user->updatedAt,
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|string|min:3|max:255',
            'noTelp' => 'sometimes|string|min:10',
            'nik' => 'sometimes|string|size:16',
            'alamat' => 'sometimes|string|min:10',
            'fotoKtp' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = [];

        if ($request->has('nama')) {
            $updateData['nama'] = $request->nama;
        }

        if ($request->has('noTelp')) {
            $updateData['noTelp'] = $request->noTelp;
        }

        if ($request->has('nik')) {
            $updateData['nik'] = $request->nik;
        }

        if ($request->has('alamat')) {
            $updateData['alamat'] = $request->alamat;
        }

        if ($request->has('fotoKtp')) {
            $updateData['fotoKtp'] = $request->fotoKtp;
        }

        $user->update($updateData);

        return response()->json([
            'message' => 'Profile updated successfully',
            'id' => $user->id,
            'nama' => $user->nama,
            'email' => $user->email,
            'noTelp' => $user->noTelp,
            'nik' => $user->nik,
            'alamat' => $user->alamat,
            'fotoKtp' => $user->fotoKtp,
            'role' => $user->role,
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'passwordLama' => 'required|string',
            'passwordBaru' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Hash::check($request->passwordLama, $user->password)) {
            throw ValidationException::withMessages([
                'passwordLama' => ['Password lama tidak sesuai'],
            ]);
        }

        $user->update([
            'password' => Hash::make($request->passwordBaru)
        ]);

        return response()->json([
            'message' => 'Password changed successfully'
        ], 200);
    }
}