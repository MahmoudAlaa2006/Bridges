<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\ExamSubmission;
use App\Models\FocusLossLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonitorExam
{
    private const DEFAULT_THRESHOLD = 5;

    /**
     * All 4 monitored event types — each one increments the focus-loss counter.
     */
    private const COUNTED_EVENTS = [
        'tab_switch',
        'window_blur',
        'page_unload',
        'copy_paste',
    ];

    /**
     * POST /exam/monitor/log-event
     */
    public function logEvent(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'submission_id' => 'required|integer|exists:exam_submissions,id',
            'event_type'    => 'required|string|in:tab_switch,window_blur,page_unload,copy_paste',
            'event_detail'  => 'nullable|string|max:255',
            'occurred_at'   => 'nullable|date',
        ]);

        $submission = ExamSubmission::findOrFail($validated['submission_id']);

        if ($submission->submitted_at !== null) {
            return response()->json(['error' => 'Submission already closed'], 422);
        }

        $assessment = Assessment::findOrFail($submission->assessment_id);
        $threshold  = $assessment->focus_loss_threshold ?? self::DEFAULT_THRESHOLD;
        $isCounted  = in_array($validated['event_type'], self::COUNTED_EVENTS, true);

        $newCount = 0;
        $flagged  = false;

        DB::transaction(function () use (
            $submission, $assessment, $validated,
            $isCounted, $threshold, &$newCount, &$flagged
        ) {
            if ($isCounted) {
                $assessment->increment('focusLossCount');
                $assessment->refresh();
            }

            $newCount = $assessment->focusLossCount ?? 0;
            $flagged  = (bool) $assessment->flag_for_review;

            if ($isCounted && $newCount >= $threshold && !$flagged) {
                $assessment->flag_for_review = true;
                $assessment->save();
                $flagged = true;

                Log::warning('Assessment flagged for review', [
                    'assessment_id'    => $assessment->id,
                    'submission_id'    => $submission->id,
                    'focus_loss_count' => $newCount,
                    'threshold'        => $threshold,
                ]);
            }

            FocusLossLog::create([
                'submission_id'            => $submission->id,
                'user_id'                  => $submission->user_id,
                'assessment_id'            => $submission->assessment_id,
                'event_type'               => $validated['event_type'],
                'event_detail'             => $validated['event_detail'] ?? null,
                'focus_loss_count_snapshot' => $newCount,
                'occurred_at'              => $validated['occurred_at'] ?? now(),
            ]);
        });

        return response()->json([
            'focus_loss_count' => $newCount,
            'flagged'          => $flagged,
            'threshold'        => $threshold,
        ]);
    }

    /**
     * GET /exam/monitor/status/{submission}
     */
    public function status(ExamSubmission $submission): JsonResponse
    {
        $assessment = Assessment::findOrFail($submission->assessment_id);
        $threshold  = $assessment->focus_loss_threshold ?? self::DEFAULT_THRESHOLD;

        return response()->json([
            'focus_loss_count' => $assessment->focusLossCount ?? 0,
            'flagged'          => (bool) $assessment->flag_for_review,
            'threshold'        => $threshold,
        ]);
    }
}
