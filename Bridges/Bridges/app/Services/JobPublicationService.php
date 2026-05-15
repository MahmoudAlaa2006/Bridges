<?php

namespace App\Services;

class JobPublicationService
{
    public function __construct(
        private JobRepository $jobRepository
    ) {
    }

    public function publishJob(string $jobId): void
    {
        $job = $this->jobRepository->find($jobId);
        $job->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function unpublishJob(string $jobId): void
    {
        $job = $this->jobRepository->find($jobId);
        $job->update([
            'status' => 'unpublished',
        ]);
    }

    public function isPublished(string $jobId): bool
    {
        $job = $this->jobRepository->find($jobId);
        return $job->status === 'published';
    }

    public function schedulePublication(string $jobId, \DateTime $date): void
    {
        $job = $this->jobRepository->find($jobId);
        $job->update([
            'status' => 'scheduled',
            'scheduled_publication_date' => $date,
        ]);
    }
}
