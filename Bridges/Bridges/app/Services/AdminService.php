<?php

namespace App\Services;

use App\Models\HRAdmin;
use App\Models\Application;

class AdminService
{
    public function __construct(
        private HRAdminRepository $adminRepository,
        private ApplicationRepository $applicationRepository
    ) {
    }

    public function overrideStage(string $adminId, string $applicationId, string $toStage, string $reason): void
    {
        $admin = $this->adminRepository->find($adminId);

        if (!$this->validateAdminAction($adminId, 'override_stage')) {
            throw new \Exception("Admin does not have permission to override stages");
        }

        $application = $this->applicationRepository->find($applicationId);
        $application->update([
            'status' => $toStage,
            'override_by' => $adminId,
            'override_reason' => $reason,
        ]);
    }

    public function getAdminPermissions(string $adminId): array
    {
        $admin = $this->adminRepository->find($adminId);

        $permissions = match ($admin->role) {
            'super_admin' => [
                'override_stage',
                'approve_requisition',
                'publish_job',
                'manage_admins',
                'view_analytics',
            ],
            'admin' => [
                'override_stage',
                'approve_requisition',
                'publish_job',
                'view_analytics',
            ],
            'moderator' => [
                'override_stage',
                'view_analytics',
            ],
            default => [],
        };

        return $permissions;
    }

    public function validateAdminAction(string $adminId, string $action): bool
    {
        $permissions = $this->getAdminPermissions($adminId);
        return in_array($action, $permissions);
    }

    public function getBackupAdmin(string $adminId): ?HRAdmin
    {
        $admin = $this->adminRepository->find($adminId);
        return $admin->backupAdmin;
    }
}
