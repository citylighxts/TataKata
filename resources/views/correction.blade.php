@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A2E] relative overflow-hidden">
    {{-- Animated background elements to match dashboard vibes --}}
    <div class="absolute inset-0 bg-gradient-to-br from-[#0A0A2E] via-[#1a1a40] to-[#0A0A2E] animate-gradient-shift"></div>
    <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(#85BBEB 1px, transparent 1px), linear-gradient(90deg, #85BBEB 1px, transparent 1px); background-size: 50px 50px;"></div>

    <header class="relative z-50 backdrop-blur-xl bg-[#0A0A2E]/70 border-b border-[#85BBEB]/20 shadow-lg shadow-[#85BBEB]/5">
        <div class="w-full py-6">
            <div class="flex justify-between items-center relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-xl blur-lg opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                        <img src="{{ asset('images/ikon-logo.png') }}" alt="Logo" class="relative w-12 h-12 rounded-xl transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                </a>

                <div class="text-center">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-[#FEF9F0] via-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent animate-gradient-text">
                        Tata Kata.
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    <a class="relative flex items-center group">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] flex items-center justify-center shadow-lg shadow-[#85BBEB]/30 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-6 h-6 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="absolute top-full right-0 mt-2 px-4 py-2 bg-[#1a1a40] border border-[#85BBEB]/30 text-[#FEF9F0] text-sm rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 backdrop-blur-xl">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Profil' }}
                            <div class="absolute -top-1 right-3 w-2 h-2 bg-[#1a1a40] border-l border-t border-[#85BBEB]/30 transform rotate-45"></div>
                        </div>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="relative group">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-full bg-[#85BBEB]/10 border border-[#85BBEB]/30 flex items-center justify-center hover:bg-[#85BBEB]/20 hover:border-[#85BBEB]/50 transition-all duration-300 group">
                            <svg class="w-6 h-6 text-[#85BBEB] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="relative w-full min-h-[calc(100vh-88px)] overflow-hidden pb-12">
        <div class="absolute -top-48 -right-48 w-[900px] h-[900px] bg-[#85bbeb28] rounded-full blur-[220px] pointer-events-none opacity-20"></div>
        <div class="absolute -bottom-20 -left-20 w-[550px] h-[550px] bg-[#FEF9F0]/10 rounded-full blur-[150px] pointer-events-none"></div>

        <main class="relative z-10 px-6 sm:px-8 lg:px-12 py-8 max-w-7xl mx-auto">
            <a href="{{ route('dashboard') }}" class="inline-block text-3xl font-semibold text-[#1a1a2e]/80 hover:underline mb-8 underline">
                Beranda
            </a>

            <h1 class="text-4xl md:text-5xl font-bold text-[#FFFFFF] mb-12 text-center">
                Hasil Pemeriksaan
            </h1>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-7xl mx-auto mb-12">
                <div class="relative">
                    <div class="flex justify-center mb-4">
                        <span class="bg-[#85BBEB] text-[#0A0A2E] px-8 py-3 rounded-full font-semibold text-lg shadow-lg">
                            Teks Asli
                        </span>
                    </div>
                    <div class="relative bg-gradient-to-br from-[#FEF9F0]/5 via-[#0A0A2E]/50 to-[#85BBEB]/5 backdrop-blur-xl rounded-3xl p-8 min-h-[600px] shadow-2xl border border-[#85BBEB]/20 overflow-">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[#85BBEB]/10">
                            <h5 class="text-xl font-bold text-[#FFFFFF]">Teks Asli</h5>
                        </div>
                        <div class="prose max-w-none text-[#C0C0C0] leading-relaxed text-base">
                            <p class="whitespace-pre-wrap break-words break-all max-w-full">{{ $originalText ?? $original_text ?? 'Teks asli akan muncul di sini.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="flex justify-center mb-4">
                        <span class="bg-[#FEF9F0] text-[#0A0A2E] px-8 py-3 rounded-full font-semibold text-lg shadow-lg">
                            Koreksi AI
                        </span>
                    </div>
                    <div class="relative bg-gradient-to-br from-[#FEF9F0]/5 via-[#0A0A2E]/50 to-[#85BBEB]/5 backdrop-blur-xl rounded-3xl p-8 min-h-[600px] shadow-2xl border border-[#85BBEB]/20">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[#85BBEB]/10">
                            <h5 class="text-xl font-bold text-[#FFFFFF]">Hasil Koreksi</h5>
                        </div>
                        <div class="prose max-w-none text-[#C0C0C0] leading-relaxed text-base">
                            <p class="whitespace-pre-wrap break-words break-all max-w-full">{{ $correctedText ?? $corrected_text ?? 'Teks koreksi akan muncul di sini.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-6 justify-between items-center max-w-7xl mx-auto px-4">
                <a href="{{ route('history') }}" class="px-12 py-4 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] text-[#0A0A2E] rounded-full font-bold text-lg hover:opacity-90 transition-all duration-200 shadow-xl border-2 border-[#85BBEB]/30">
                    Riwayat
                </a>

                <button onclick="downloadDocument()" class="px-12 py-4 bg-gradient-to-r from-[#FEF9F0] to-[#85BBEB] text-[#0A0A2E] rounded-full font-bold text-lg hover:opacity-90 transition-all duration-200 shadow-xl border-2 border-[#85BBEB]/30">
                    Terapkan & Unduh
                </button>
            </div>
        </main>
    </div>
</div>

@if(isset($document))
    <script>
        // Trigger single-file download for the current document (same behavior as history view)
        function downloadDocument() {
            // Use window.location to let Laravel return a download response (Content-Disposition: attachment)
            window.location.href = '{{ route("document.download", $document->id) }}';
        }
    </script>
@else
    <script>
        function downloadDocument() {
            alert('File tidak tersedia untuk diunduh.');
        }
    </script>
@endif

@endsection