<?php

namespace App\Services;

use App\Models\Interview;
use App\Models\TimeExtensionRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Service to manage time extension requests for interview sessions.
 */
class ExtensionRequestService
{
    /**
     * Create a new time extension request.
     *
     * @param User $user
     * @param Interview $interview
     * @param int $minutes
     * @param string|null $reason
     * @return TimeExtensionRequest
     */
    public function requestExtension(User $user, Interview $interview, int $minutes, $reason = null): TimeExtensionRequest
    {
        return TimeExtensionRequest::create([
            'interview_id' => $interview->id,
            'requested_by' => $user->id,
            'requested_minutes' => $minutes,
            'reason' => $reason,
            'status' => TimeExtensionRequest::STATUS_PENDING,
        ]);
    }

    /**
     * Handle HR Admin approval or rejection of an extension request.
     *
     * @param TimeExtensionRequest $request
     * @param string $status
     * @return void
     */
    public function handleRequest(TimeExtensionRequest $request, string $status)
    {
        if (in_array($status, [TimeExtensionRequest::STATUS_APPROVED, TimeExtensionRequest::STATUS_REJECTED])) {
            $request->update(['status' => $status]);
            Log::info("Time extension request #{$request->id} has been {$status}.");
        }
    }
}
