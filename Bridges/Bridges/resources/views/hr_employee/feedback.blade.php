@extends('layouts.hr_employee')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8">
        <h1 class="text-2xl font-bold text-white mb-2">Interview Feedback Submission</h1>
        <p class="text-slate-400">Share your assessment for the interview with <strong>{{ $interview->user->name }}</strong>.</p>
    </div>

    <!-- Reusing the interviewer feedback form logic here if needed, or specific HR Employee view -->
    <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8">
        <p class="text-slate-400 italic">HR Employee assessment form goes here...</p>
        <a href="{{ route('feedback.create', $interview) }}" class="mt-4 inline-block text-blue-400 hover:underline">Go to Standard Feedback Form</a>
    </div>
</div>
@endsection
