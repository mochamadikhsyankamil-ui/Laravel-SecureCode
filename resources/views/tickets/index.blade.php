@extends('layouts.app')

@section('title', 'Daftar Tiket')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <h1 class="text-2xl font-bold text-slate-800">Daftar Tiket</h1>
</div>

@if ($tickets->isEmpty())
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <p class="text-slate-600 mb-6">Belum ada tiket. Buat tiket pertama Anda.</p>
        <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Buat Tiket
        </a>
    </div>
@else
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <ul class="divide-y divide-slate-100">
            @foreach ($tickets as $ticket)
                <li class="hover:bg-slate-50/50 transition">
                    <a href="{{ route('tickets.show', $ticket) }}" class="block px-6 py-4 sm:flex sm:items-center sm:justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-800 truncate">{{ $ticket->title }}</p>
                            <p class="text-sm text-slate-500 mt-0.5">#{{ $ticket->id }} · {{ $ticket->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="flex items-center gap-3 mt-2 sm:mt-0 shrink-0">
                            @php
                                $statusClass = match($ticket->status) {
                                    'open' => 'bg-blue-100 text-blue-800',
                                    'in_progress' => 'bg-amber-100 text-amber-800',
                                    'resolved' => 'bg-emerald-100 text-emerald-800',
                                    'closed' => 'bg-slate-100 text-slate-600',
                                    default => 'bg-slate-100 text-slate-600',
                                };
                                $priorityClass = match($ticket->priority) {
                                    'high' => 'text-red-600',
                                    'medium' => 'text-amber-600',
                                    'low' => 'text-slate-500',
                                    default => 'text-slate-500',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">{{ $ticket->status_label }}</span>
                            <span class="text-sm font-medium {{ $priorityClass }}">{{ $ticket->priority_label }}</span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="px-4 py-3 border-t border-slate-100 bg-slate-50/50">
            {{ $tickets->links() }}
        </div>
    </div>
@endif
@endsection
