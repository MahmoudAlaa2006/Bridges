@extends('layouts.hr_employee')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8">
        <h1 class="text-2xl font-bold text-white mb-2">Interview Briefing</h1>
        <p class="text-slate-400">Context and guidelines for the interview with {{ $interview->user->name }}.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-slate-800/50 border border-slate-700 p-6 rounded-2xl">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Candidate Profile</h3>
            <p class="text-white">{{ $interview->brief->candidate_bio ?? 'No bio provided.' }}</p>
        </div>
        <div class="bg-slate-800/50 border border-slate-700 p-6 rounded-2xl">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Evaluation Goals</h3>
            <p class="text-white">{{ $interview->brief->problem_statement ?? 'Standard evaluation.' }}</p>
        </div>
    </div>
</div>
@endsection