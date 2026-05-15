<?php

namespace App\Services;

class DuplicateDetectionService
{
    public function __construct(
        private ApplicationRepository $applicationRepository,
        private CandidateRepository $candidateRepository
    ) {
    }

    public function detectDuplicates(string $applicationId): array
    {
        $application = $this->applicationRepository->find($applicationId);
        $candidate = $application->candidate;

        $duplicates = $this->applicationRepository->findByCandidateAndJob(
            $candidate->candidate_id,
            $application->job_id
        );

        return array_filter($duplicates, fn($dup) => $dup->application_id !== $applicationId);
    }

    public function markAsDuplicate(string $applicationId, string $originalApplicationId): void
    {
        $duplicate = $this->applicationRepository->find($applicationId);
        $duplicate->update([
            'status' => 'duplicate',
            'duplicate_of' => $originalApplicationId,
        ]);
    }

    public function mergeDuplicates(array $applicationIds): string
    {
        if (empty($applicationIds)) {
            throw new \Exception("No applications to merge");
        }

        $primary = $this->applicationRepository->find($applicationIds[0]);

        foreach (array_slice($applicationIds, 1) as $dupId) {
            $this->markAsDuplicate($dupId, $primary->application_id);
        }

        return $primary->application_id;
    }

    public function getDuplicateGroup(string $applicationId): array
    {
        $application = $this->applicationRepository->find($applicationId);

        if ($application->duplicate_of) {
            return $this->getDuplicateGroupByOriginal($application->duplicate_of);
        }

        return [$application->application_id, ...array_map(
            fn($dup) => $dup->application_id,
            $this->applicationRepository->findDuplicatesOf($application->application_id)
        )];
    }

    private function getDuplicateGroupByOriginal(string $originalId): array
    {
        $applications = $this->applicationRepository->findDuplicatesOf($originalId);
        return [$originalId, ...array_map(fn($app) => $app->application_id, $applications)];
    }
}
