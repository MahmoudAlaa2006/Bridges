@extends('layouts.interviewer')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Assigned Interviews</h1>
            <p class="text-slate-400 mt-2">Manage your upcoming and pending feedback sessions.</p>
        </div>
        <div class="flex space-x-4">
            <div class="bg-slate-800/50 border border-slate-700 px-4 py-2 rounded-xl text-sm">
                <span class="text-slate-500 font-medium">This Week:</span>
                <span class="text-white font-bold ml-2">{{ $interviews->count() }}</span>
            </div>
        </div>
    </div>

    {{-- ── SECTION: Scheduled Interviews ─────────────────────────────────── --}}
    <div class="grid grid-cols-1 gap-6">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <span class="w-2 h-8 bg-blue-500 rounded-full"></span>
            Upcoming Sessions
        </h2>
        @forelse($interviews as $interview)
        <div class="bg-slate-800/40 backdrop-blur border border-slate-700/50 rounded-3xl overflow-hidden group hover:border-blue-500/30 transition-all">
            <div class="p-8 flex flex-col md:flex-row items-center gap-8">
                <!-- Date/Time Card -->
                <div class="w-full md:w-32 bg-slate-900 rounded-2xl p-4 text-center border border-slate-700">
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $interview->get_date->format('M') }}</span>
                    <span class="block text-3xl font-black text-white my-1">{{ $interview->get_date->format('d') }}</span>
                    <span class="block text-xs font-medium text-blue-400">{{ $interview->get_date->format('H:i') }}</span>
                </div>

                <!-- Candidate Info -->
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h3 class="text-xl font-bold text-white">{{ $interview->user->name }}</h3>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            {{ $interview->application->job->title ?? 'Technical Role' }}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-4 text-sm text-slate-400">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            60 Min Session
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Panel: {{ $interview->panels->count() }} Members
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('interviewer.brief', $interview) }}" class="px-6 py-3 rounded-xl bg-slate-700 hover:bg-slate-600 text-white font-bold transition-all text-center">
                        View Brief
                    </a>
                    
                    @if(!$interview->is_finish)
                        <a href="{{ route('session.show', $interview) }}" class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition-all shadow-lg shadow-blue-600/20 text-center">
                            Join Session
                        </a>
                    @else
                        <button disabled class="px-8 py-3 rounded-xl bg-slate-900 text-slate-500 font-bold cursor-not-allowed">
                            Completed
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-slate-800/40 border border-dashed border-slate-700 rounded-3xl p-8 text-center text-slate-500 text-sm">
            No scheduled interviews for this week.
        </div>
        @endforelse
    </div>

    {{-- ── SECTION: Candidates Awaiting Scheduling ─────────────────────── --}}
    <div class="grid grid-cols-1 gap-6 mt-12">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <span class="w-2 h-8 bg-amber-500 rounded-full"></span>
            Awaiting Scheduling
        </h2>
        <p class="text-slate-400 text-sm -mt-4">Candidates who passed the assessment and shared their availability. Get in touch to finalize a slot.</p>
        
        @forelse($pendingCandidates as $candidate)
        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Profile & Contact -->
                <div class="lg:w-1/3 border-r border-slate-700/50 pr-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-amber-500/10 text-amber-500 rounded-2xl flex items-center justify-center font-bold text-xl">
                            {{ substr($candidate->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-white font-bold">{{ $candidate->name }}</h4>
                            <p class="text-slate-500 text-xs">{{ $candidate->applications->first()->job->title ?? 'Candidate' }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm text-slate-300">
                            <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $candidate->email }}
                        </div>
                        <a href="mailto:{{ $candidate->email }}" class="mt-4 block w-full py-2 bg-amber-500/10 hover:bg-amber-500/20 text-amber-500 text-center rounded-xl text-xs font-bold transition-all border border-amber-500/20">
                            Contact via Email
                        </a>
                    </div>
                </div>

                <!-- Availability Windows -->
                <div class="flex-1">
                    <h5 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Preferred Availability</h5>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($candidate->availabilityWindows as $window)
                        <div class="bg-slate-900/50 border border-slate-700/50 p-3 rounded-2xl flex items-center justify-between">
                            <div>
                                <span class="block text-white text-sm font-bold">{{ \Carbon\Carbon::parse($window->date)->format('D, M d') }}</span>
                                <span class="block text-slate-500 text-[11px]">{{ $window->start_time }} — {{ $window->end_time }}</span>
                            </div>
                            <span class="text-[10px] bg-slate-800 px-2 py-1 rounded-lg text-slate-400">{{ $window->time_zone }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-slate-800/40 border border-dashed border-slate-700 rounded-3xl p-12 text-center">
            <h3 class="text-slate-500 font-medium">No candidates awaiting scheduling</h3>
        </div>
        @endforelse
    </div>
</div>
</div>
@endsection