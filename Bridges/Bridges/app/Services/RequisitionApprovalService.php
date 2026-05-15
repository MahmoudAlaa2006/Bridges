<?php

namespace App\Services;

use App\Models\JobRequisition;
use App\Models\Approval;

class RequisitionApprovalService
{
    public function __construct(
        private JobRequisitionRepository $requisitionRepository,
        private JobRepository $jobRepository
    ) {
    }

    public function approveRequisition(string $requisitionId, string $approverId, int $tier): void
    {
        $requisition = $this->requisitionRepository->find($requisitionId);

        $approval = Approval::create([
            'entity_id' => $requisitionId,
            'entity_type' => 'JobRequisition',
            'tier' => $tier,
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $this->updateRequisitionStatus($requisition);
    }

    public function rejectRequisition(string $requisitionId, string $approverId, string $reason): void
    {
        $requisition = $this->requisitionRepository->find($requisitionId);

        Approval::create([
            'entity_id' => $requisitionId,
            'entity_type' => 'JobRequisition',
            'status' => 'rejected',
            'comments' => $reason,
        ]);

        $requisition->update(['approval_status' => 'rejected']);
    }

    public function getApprovalStatus(string $requisitionId): string
    {
        $requisition = $this->requisitionRepository->find($requisitionId);
        return $requisition->approval_status;
    }

    public function getPendingApprovals(string $approverId): array
    {
        $approvals = Approval::where('entity_type', 'JobRequisition')
            ->where('status', 'pending')
            ->get();

        return $approvals->map(fn($approval) => 
            $this->requisitionRepository->find($approval->entity_id)
        )->toArray();
    }

    private function updateRequisitionStatus(JobRequisition $requisition): void
    {
        $approvals = $requisition->approvals;
        $allApproved = $approvals->every(fn($approval) => $approval->isApproved());

        if ($allApproved) {
            $requisition->update(['approval_status' => 'approved']);
        }
    }
}
