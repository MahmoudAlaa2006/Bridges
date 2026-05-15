@extends('layouts.hr_admin')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Interview Reports & Alerts</h1>
            <p class="text-slate-400 mt-2">Monitor escalations and handle time extension requests.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Escalations Section -->
        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                    Recent Escalations
                </h3>
                <span class="bg-red-500/10 text-red-400 px-3 py-1 rounded-full text-xs font-bold">{{ $escalations->count() }} Urgent</span>
            </div>
            <div class="divide-y divide-slate-700/50">
                @forelse($escalations as $escalation)
                <div class="p-6 hover:bg-slate-700/20 transition-colors">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-white font-bold">{{ $escalation->interview->user->name }}</p>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mt-1">Interviewer: {{ $escalation->user->name }}</p>
                        </div>
                        <form action="{{ route('hr.escalations.resolve', $escalation) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-blue-400 hover:text-blue-300 uppercase tracking-widest transition-colors">Mark Resolved</button>
                        </form>
                    </div>
                    <div class="bg-red-500/5 border border-red-500/10 rounded-xl p-4 text-sm text-red-200/80 italic">
                        "{{ $escalation->escalation_reason }}"
                    </div>
                </div>
                @empty
                <div class="p-12 text-center text-slate-500 italic">No active escalations found.</div>
                @endforelse
            </div>
        </div>

        <!-- Extension Requests Section -->
        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                    Extension Requests
                </h3>
                <span class="bg-blue-500/10 text-blue-400 px-3 py-1 rounded-full text-xs font-bold">{{ $extensionRequests->count() }} Pending</span>
            </div>
            <div class="divide-y divide-slate-700/50">
                @forelse($extensionRequests as $request)
                <div class="p-6 hover:bg-slate-700/20 transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-white font-bold">{{ $request->interview->user->name }} Session</p>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mt-1">Request by: {{ $request->requester->name }}</p>
                        </div>
                        <div class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg text-xs font-black">+{{ $request->requested_minutes }} MIN</div>
                    </div>
                    <p class="text-sm text-slate-400 mb-4 italic">"{{ $request->reason }}"</p>
                    <div class="flex space-x-3">
                        <form action="{{ route('hr.extensions.handle', $request) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="w-full py-2 bg-green-600/20 hover:bg-green-600/30 text-green-400 rounded-xl text-xs font-bold transition-all">Approve</button>
                        </form>
                        <form action="{{ route('hr.extensions.handle', $request) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="w-full py-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 rounded-xl text-xs font-bold transition-all">Reject</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center text-slate-500 italic">No pending extension requests.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
