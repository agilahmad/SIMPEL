<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\Incident\IncidentApiRequest;
use App\Models\Application;
use App\Models\CommunityReportStaging;
use App\Models\User;
use App\Notifications\IncidentCreatedNotification;
use Illuminate\Support\Facades\Notification;

class IncidentApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Application::orderBy('application_name')
                ->get(['id', 'application_name'])
        );
    }

    public function store(IncidentApiRequest $request)
    {
        $validated = $request->validated();

        $applicationName = $validated['application_name'];
        unset($validated['application_name'], $validated['evidence']);

        $staging = CommunityReportStaging::create([
            'application_name'   => $applicationName,
            'reporter_name'      => $validated['reporter_name'],
            'vulnerability_name' => $validated['vulnerability_name'],
            'severity'           => $validated['severity'],
            'reporting_date'     => $validated['reporting_date'],
            'status'             => 'pending',
        ]);

        if ($request->hasFile('evidence')) {
            $file     = $request->file('evidence');
            $extension = $file->getClientOriginalExtension();
            $fileName  = 'laporan_user_' . $staging->id . '.' . $extension;
            $path     = $file->storeAs('evidences/community', $fileName, 'public');

            $staging->update([
                'file_path' => $path,
                'file_name' => $fileName,
            ]);
        }

        $admins = User::where('role', Role::Admin->value)->get();
        Notification::send($admins, new IncidentCreatedNotification($staging));

        return response()->json([
            'message' => 'Laporan berhasil diterima.',
            'data'    => ['id' => $staging->id],
        ], 201);
    }
}
