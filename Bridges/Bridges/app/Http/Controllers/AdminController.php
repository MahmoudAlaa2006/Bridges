<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    
    public function __construct(
        private AdminService $adminService
    ) {
    }
    public function overrideStage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'admin_id'       => 'required|string',
            'application_id' => 'required|string',
            'to_stage'       => 'required|string',
            'reason'         => 'required|string',
        ]);

        try {
            $this->adminService->overrideStage(
                $validated['admin_id'],
                $validated['application_id'],
                $validated['to_stage'],
                $validated['reason']
            );
            return response()->json(['message' => 'Stage overridden successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function getPermissions(string $adminId): JsonResponse
    {
        $permissions = $this->adminService->getAdminPermissions($adminId);
        return response()->json(['permissions' => $permissions]);
    }

    public function validateAction(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'admin_id' => 'required|string',
            'action'   => 'required|string',
        ]);

        $isValid = $this->adminService->validateAdminAction(
            $validated['admin_id'],
            $validated['action']
        );

        return response()->json(['is_valid' => $isValid]);
    }
}
