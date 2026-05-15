<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Repositories\ApplicationRepository;
use App\Services\ApplicationWorkflowService;
use App\Services\ApplicationScoringService;
use App\Services\DuplicateDetectionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApplicationController extends Controller
{
    
    public function __construct(
        private ApplicationRepository $applicationRepository,
        private ApplicationWorkflowService $workflowService,
        private ApplicationScoringService $scoringService,
        private DuplicateDetectionService $duplicateService
    ) {
    }

    public function index(): JsonResponse
    {
        $applications = $this->applicationRepository->all();
        return response()->json($applications);
    }

    public function show(string $id): JsonResponse
    {
        $application = $this->applicationRepository->find($id);

        if (!$application) {
            return response()->json(['error' => 'Application not found'], 404);
        }

        return response()->json($application);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'candidate_id' => 'required|string',
            'job_id'       => 'required|string',
            'status'       => 'sometimes|string',
        ]);

        $duplicates = $this->duplicateService->detectDuplicates($validated['candidate_id']);
        if (!empty($duplicates)) {
            return response()->json([
                'warning'    => 'Duplicate applications detected',
                'duplicates' => $duplicates,
            ], 409);
        }

        $application = $this->applicationRepository->create($validated);

        $matchScore = $this->scoringService->calculateMatchScore($application->application_id);

        return response()->json([
            'application' => $application,
            'match_score' => $matchScore,
        ], 201);
    }

    public function updateStatus(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        try {
            $this->workflowService->advanceStage($id, $validated['status']);
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function reject(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'reason' => 'required|string',
        ]);

        $this->workflowService->rejectApplication($id, $validated['reason']);
        return response()->json(['message' => 'Application rejected']);
    }

    public function detectDuplicates(string $id): JsonResponse
    {
        $duplicates = $this->duplicateService->detectDuplicates($id);
        return response()->json(['duplicates' => $duplicates]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'sometimes|string',
            'score'  => 'sometimes|integer',
        ]);

        $application = $this->applicationRepository->update($id, $validated);
        return response()->json($application);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->applicationRepository->delete($id);
        return response()->json(['message' => 'Application deleted successfully']);
    }
}
