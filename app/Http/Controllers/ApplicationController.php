<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\Application\StoreApplicationRequest;
use App\Http\Requests\Application\UpdateApplicationRequest;
use App\Models\Application;
use App\Models\User;


class ApplicationController extends Controller
{
    public function index() {
        $this->authorize('viewAny', Application::class);
        $applications = Application::with('programmer')->latest()->paginate(10);
        return view('applications.index', compact('applications'));
    }

    public function create(){
        $this->authorize('create', Application::class);
        $programmers = User::where('role', Role::Programmer->value)->orderBy('name')->get();
        return view('applications.create', compact('programmers'));
    }

    public function store(StoreApplicationRequest $request) {
        Application::create($request->validated());
        return redirect()->route('applications.index')->with('success', 'Aplikasi berhasil ditambahkan');
    }

    public function show(Application $application){
        $this->authorize('view', $application);
        $application->load(['programmer', 'vulnerabilities', 'incidents']);
        return view('applications.show', compact('application'));
    }

    public function edit(Application $application){
        $this->authorize('update', $application);
        $programmers = User::where('role', Role::Programmer)->get();
        return view('applications.edit', compact('application', 'programmers'));
    }

    public function update(UpdateApplicationRequest $request, Application $application){
        $application->update($request->validated());
        return redirect()->route('applications.index')->with('success', 'Aplikasi berhasil diupdate');
    }

    public function destroy(Application $application){
        $this->authorize('delete', $application);
        $application->delete();
        return redirect()->route('applications.index')->with('success', 'Aplikasi berhasil dihapus');
    }
}
