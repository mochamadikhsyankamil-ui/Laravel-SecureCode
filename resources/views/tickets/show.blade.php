@extends('layouts.app')

@section('title', 'Detail Tiket #' . $ticket->id)

@section('content')
<div class="mb-8">
    <a href="{{ route('tickets.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-indigo-600 font-medium transition mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Daftar
    </a>
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">{{ $ticket->title }}</h1>
            <p class="text-slate-500 mt-1">Tiket #{{ $ticket->id }} · Dibuat {{ $ticket->created_at->format('d M Y') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('tickets.edit', $ticket) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Edit
            </a>
            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus tiket ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg font-medium hover:bg-red-100 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 sm:p-8 border-b border-slate-100 bg-slate-50/30">
        <div class="flex flex-wrap gap-3">
            @php
                $statusClass = match($ticket->status) {
                    'open' => 'bg-blue-100 text-blue-800',
                    'in_progress' => 'bg-amber-100 text-amber-800',
                    'resolved' => 'bg-emerald-100 text-emerald-800',
                    'closed' => 'bg-slate-100 text-slate-600',
                    default => 'bg-slate-100 text-slate-600',
                };
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">Status: {{ $ticket->status_label }}</span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-700">Prioritas: {{ $ticket->priority_label }}</span>
        </div>
    </div>
    <div class="p-6 sm:p-8">
        <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-2">Deskripsi</h2>
        <div class="text-slate-700 whitespace-pre-wrap">{{ $ticket->description ?: '—' }}</div>
    </div>
    <div class="px-6 sm:px-8 py-4 bg-slate-50/50 border-t border-slate-100 text-sm text-slate-500">
        Terakhir diperbarui: {{ $ticket->updated_at->format('d M Y, H:i') }}
    </div>
</div>
@endsection
