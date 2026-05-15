<?php

namespace App\Services;

use App\Models\Application;
use App\Models\TransitionRule;
use App\Contracts\INotificationChannel;

class ApplicationWorkflowService
{
    public function __construct(
        private ApplicationRepository $applicationRepository,
        private TransitionRuleRepository $transitionRuleRepository,
        private INotificationChannel $notificationService
    ) {
    }

    public function advanceStage(string $applicationId, string $toStage): void
    {
        $application = $this->applicationRepository->find($applicationId);

        if (!$this->validateTransition($applicationId, $toStage)) {
            throw new \Exception("Invalid transition to stage: {$toStage}");
        }

        $application->update(['status' => $toStage]);
        
        $this->notifyApplicationStatusChange($application, $toStage);
    }

    public function rejectApplication(string $applicationId, string $reason): void
    {
        $application = $this->applicationRepository->find($applicationId);
        $application->update(['status' => 'rejected']);

        $this->notificationService->send(
            $application->candidate->email,
            "Your application has been rejected. Reason: {$reason}"
        );
    }

    public function validateTransition(string $applicationId, string $toStage): bool
    {
        $application = $this->applicationRepository->find($applicationId);
        $rules = $this->transitionRuleRepository->findByJobId($application->job_id);

        foreach ($rules as $rule) {
            if ($rule->from_stage === $application->status && $rule->to_stage === $toStage) {
                return $rule->evaluate($application);
            }
        }

        return true;
    }

    public function getCurrentStage(string $applicationId): string
    {
        $application = $this->applicationRepository->find($applicationId);
        return $application->status;
    }

    private function notifyApplicationStatusChange(Application $application, string $newStage): void
    {
        $message = "Your application status has been updated to: {$newStage}";
        $this->notificationService->send($application->candidate->email, $message);
    }
}
