@extends('layouts.hr_employee')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold text-white tracking-tight">Scheduled Interviews</h1>
        <p class="text-slate-400 mt-2">View and manage interviews where you are a panel member.</p>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @forelse($interviews as $interview)
        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl p-8 flex items-center gap-8">
            <div class="w-32 bg-slate-900 rounded-2xl p-4 text-center border border-slate-700">
                <span class="block text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $interview->get_date->format('M') }}</span>
                <span class="block text-3xl font-black text-white my-1">{{ $interview->get_date->format('d') }}</span>
                <span class="block text-xs font-medium text-blue-400">{{ $interview->get_date->format('H:i') }}</span>
            </div>

            <div class="flex-1">
                <h3 class="text-xl font-bold text-white mb-2">{{ $interview->user->name }}</h3>
                <p class="text-slate-400 text-sm">Role: {{ $interview->application->job->title ?? 'Technical Position' }}</p>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('hr_employee.brief', $interview) }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-xl transition-all">
                    View Brief
                </a>
                <a href="{{ route('session.show', $interview) }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition-all">
                    Join Session
                </a>
            </div>
        </div>
        @empty
        <div class="p-12 text-center text-slate-500 border border-dashed border-slate-700 rounded-3xl italic">
            No interviews scheduled.
        </div>
        @endforelse
    </div>
</div>
@endsection