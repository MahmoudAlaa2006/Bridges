<?php

namespace App\Http\Controllers;

use App\Models\JobRequisition;
use App\Repositories\JobRequisitionRepository;
use App\Services\RequisitionApprovalService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RequisitionController extends Controller
{
    public function __construct(
        private JobRequisitionRepository $requisitionRepository,
        private RequisitionApprovalService $approvalService
    ) {
    }

    public function index(): JsonResponse
    {
        $requisitions = $this->requisitionRepository->all();
        return response()->json($requisitions);
    }

    public function show(string $id): JsonResponse
    {
        $requisition = $this->requisitionRepository->find($id);

        if (!$requisition) {
            return response()->json(['error' => 'Requisition not found'], 404);
        }

        return response()->json($requisition);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'creator_id' => 'required|string',
            'salary' => 'required|integer',
            'skills' => 'array',
        ]);

        $validated['approval_status'] = 'pending';
        $validated['revision_count'] = 0;

        $requisition = $this->requisitionRepository->create($validated);
        return response()->json($requisition, 201);
    }

    public function approve(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'approver_id' => 'required|string',
            'tier' => 'required|integer',
        ]);

        try {
            $this->approvalService->approveRequisition(
                $id,
                $validated['approver_id'],
                $validated['tier']
            );
            return response()->json(['message' => 'Requisition approved']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function reject(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'approver_id' => 'required|string',
            'reason' => 'required|string',
        ]);

        try {
            $this->approvalService->rejectRequisition(
                $id,
                $validated['approver_id'],
                $validated['reason']
            );
            return response()->json(['message' => 'Requisition rejected']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getStatus(string $id): JsonResponse
    {
        $status = $this->approvalService->getApprovalStatus($id);
        return response()->json(['status' => $status]);
    }

    public function getPending(string $approverId): JsonResponse
    {
        $pending = $this->approvalService->getPendingApprovals($approverId);
        return response()->json($pending);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'string',
            'salary' => 'integer',
            'skills' => 'array',
        ]);

        $requisition = $this->requisitionRepository->update($id, $validated);
        return response()->json($requisition);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->requisitionRepository->delete($id);
        return response()->json(['message' => 'Requisition deleted successfully']);
    }
}
