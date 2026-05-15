<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Repositories\CandidateRepository;
use App\Services\CandidateService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CandidateController extends Controller
{
    
    public function __construct(
        private CandidateRepository $candidateRepository,
        private CandidateService $candidateService
    ) {
    }

    public function index(): JsonResponse
    {
        $candidates = $this->candidateRepository->all();
        return response()->json($candidates);
    }

    public function show(string $id): JsonResponse
    {
        $candidate = $this->candidateRepository->find($id);

        if (!$candidate) {
            return response()->json(['error' => 'Candidate not found'], 404);
        }

        return response()->json($candidate->getProfile());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'            => 'required|email|unique:candidates',
            'phone'            => 'required|string',
            'name'             => 'required|string',
            'years_experience' => 'sometimes|integer|min:0',
        ]);

        $candidate = $this->candidateRepository->create($validated);
        return response()->json($candidate, 201);
    }

    public function updateProfile(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'phone'            => 'sometimes|string',
            'name'             => 'sometimes|string',
            'years_experience' => 'sometimes|integer',
        ]);

        $this->candidateService->updateProfile($id, $validated);
        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function updateSkills(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'skills' => 'required|array',
        ]);

        $this->candidateService->updateSkills($id, $validated['skills']);
        return response()->json(['message' => 'Skills updated successfully']);
    }

    public function getApplications(string $id): JsonResponse
    {
        $applications = $this->candidateService->getCandidateApplications($id);
        return response()->json($applications);
    }

    public function getExperienceLevel(string $id): JsonResponse
    {
        $level = $this->candidateService->calculateExperienceLevel($id);
        return response()->json(['experience_level' => $level]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->candidateRepository->delete($id);
        return response()->json(['message' => 'Candidate deleted successfully']);
    }
}
