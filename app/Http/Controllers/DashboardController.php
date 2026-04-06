<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $service,
    ) {}

    public function index()
    {
        $user = auth()->user();

        return match(true) {
            $user->isAdmin()      => $this->adminDashboard(),
            $user->isProgrammer() => $this->programmerDashboard(),
            $user->isUser()       => $this->userDashboard(),
            default               => abort(403, 'Tidak Bisa Diakses'),
        };
    }

    // ==================== PRIVATE ====================

    private function adminDashboard()
    {
        return view('dashboard.admin', $this->service->getAdminDashboardData());
    }

    private function programmerDashboard()
    {
        $userId = auth()->id();
        abort_if(is_null($userId), 403, 'Unauthorize');

        return view('dashboard.programmer', $this->service->getProgrammerDashboardData($userId));
    }

    private function userDashboard()
    {
        $userId = auth()->id();
        abort_if(is_null($userId), 403, 'Unauthorize');

        return view('dashboard.user', $this->service->getUserDashboardData($userId));
    }
}
