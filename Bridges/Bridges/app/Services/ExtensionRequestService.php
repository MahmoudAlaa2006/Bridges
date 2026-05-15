<?php

namespace App\Services;

use App\Models\TimeExtensionRequest;

class ExtensionRequestService
{
    public function handleRequest(TimeExtensionRequest $request, string $status): void
    {
        $request->update(['status' => $status]);

        if ($status === 'approved') {
            $session = $request->interview->session;
            if ($session) {
                $session->increment('scheduled_duration', $request->requested_minutes);
            }
        }
    }
}
