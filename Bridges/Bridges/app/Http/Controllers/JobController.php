<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Repositories\JobRepository;
use App\Services\JobPublicationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    public function __construct(
        private JobRepository $jobRepository,
        private JobPublicationService $publicationService
    ) {
    }

    public function index(): JsonResponse
    {
        $jobs = $this->jobRepository->all();
        return response()->json($jobs);
    }

    public function show(string $id): JsonResponse
    {
        $job = $this->jobRepository->find($id);

        if (!$job) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        return response()->json($job);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'department' => 'required|string',
            'salary_range' => 'required|array',
            'status' => 'required|string',
            'keywords' => 'array',
        ]);

        $job = $this->jobRepository->create($validated);
        return response()->json($job, 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'string',
            'department' => 'string',
            'salary_range' => 'array',
            'status' => 'string',
            'keywords' => 'array',
        ]);

        $job = $this->jobRepository->update($id, $validated);
        return response()->json($job);
    }

    public function publish(string $id): JsonResponse
    {
        $this->publicationService->publishJob($id);
        return response()->json(['message' => 'Job published successfully']);
    }

    public function unpublish(string $id): JsonResponse
    {
        $this->publicationService->unpublishJob($id);
        return response()->json(['message' => 'Job unpublished successfully']);
    }

    public function close(string $id): JsonResponse
    {
        $this->jobRepository->update($id, ['status' => 'closed', 'closed_at' => now()]);
        return response()->json(['message' => 'Job closed successfully']);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->jobRepository->delete($id);
        return response()->json(['message' => 'Job deleted successfully']);
    }

    public function search(Request $request): JsonResponse
    {
        $criteria = $request->query();
        $results = $this->jobRepository->search($criteria);
        return response()->json($results);
    }
}
