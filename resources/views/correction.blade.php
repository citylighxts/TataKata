@extends('layouts.app')

@section('content')
{{-- PERBAIKAN 1: 'classF' diubah menjadi 'class' & 'overflow-hidden' dihapus --}}
<div class="min-h-screen bg-[#0A0A2E] relative">
    {{-- Animated background elements --}}
    {{-- PERBAIKAN 2: 'absolute' diubah menjadi 'fixed' --}}
    <div class="fixed inset-0 bg-gradient-to-br from-[#0A0A2E] via-[#1a1a40] to-[#0A0A2E] animate-gradient-shift"></div>
    {{-- PERBAIKAN 3: 'absolute' diubah menjadi 'fixed' --}}
    <div class="fixed inset-0 opacity-5" style="background-image: linear-gradient(#85BBEB 1px, transparent 1px), linear-gradient(90deg, #85BBEB 1px, transparent 1px); background-size: 50px 50px;"></div>

    {{-- PERBAIKAN 4: Lingkaran blur dipindahkan ke sini dan diubah menjadi 'fixed' --}}
    <div class="fixed -top-48 -right-48 w-[900px] h-[900px] bg-[#85bbeb28] rounded-full blur-[220px] pointer-events-none opacity-20"></div>
    <div class="fixed -bottom-20 -left-20 w-[550px] h-[550px] bg-[#FEF9F0]/10 rounded-full blur-[150px] pointer-events-none"></div>

    {{-- Header (z-50, akan tetap di atas background) --}}
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
                    {{-- Profile Icon --}}
                    <a class="relative flex items-center group">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] flex items-center justify-center shadow-lg shadow-[#85BBEB]/30 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-6 h-6 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <div class="absolute top-full right-0 mt-2 px-4 py-2 bg-[#1a1a40] border border-[#85BBEB]/30 text-[#FEF9F0] text-sm rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 backdrop-blur-xl">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Profil' }}
                            <div class="absolute -top-1 right-3 w-2 h-2 bg-[#1a1a40] border-l border-t border-[#85BBEB]/30 transform rotate-45"></div>
                        </div>
                    </a>
                    {{-- Logout Button --}}
                    <form method="POST" action="{{ route('logout') }}" class="relative group">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-full bg-[#85BBEB]/10 border border-[#85BBEB]/30 flex items-center justify-center hover:bg-[#85BBEB]/20 hover:border-[#85BBEB]/50 transition-all duration-300 group">
                            <svg class="w-6 h-6 text-[#85BBEB] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <div class="relative w-full min-h-[calc(100vh-88px)] overflow-hidden pb-12">
        {{-- PERBAIKAN 5: Lingkaran blur DIHAPUS dari sini --}}

        <main class="relative z-10 px-6 sm:px-8 lg:px-12 py-8 max-w-7xl mx-auto">
            <a href="{{ route('dashboard') }}" class="inline-block text-xl font-semibold text-[#85BBEB]/80 hover:text-[#FEF9F0] hover:underline mb-6 transition-colors">
                &larr; Kembali ke Beranda
            </a>

            <h1 class="text-4xl md:text-5xl font-bold text-[#FFFFFF] mb-4 text-center">
                Hasil Pemeriksaan
            </h1>
            <p class="text-center text-lg text-[#C0C0C0] mb-12">
                File: <span class="font-semibold text-[#FEF9F0]">{{ $document->file_name }}</span>
            </p>

            {{-- Container untuk logika AlpineJS --}}
            <div class="space-y-6" x-data="chapterCorrector()">

                @forelse ($document->chapters as $chapter)
                    {{-- Setiap Bab adalah komponen AlpineJS --}}
                    <div class="relative bg-gradient-to-br from-[#FEF9F0]/5 via-[#0A0A2E]/50 to-[#85BBEB]/5 backdrop-blur-xl rounded-3xl shadow-2xl border border-[#85BBEB]/20 overflow-hidden"
                         x-data="chapterItem(
                             {{ $chapter->id }},
                             '{{ $chapter->status }}',
                             '{{ $chapter->details }}',
                             {{ $chapter->corrected_text ? 'true' : 'false' }},
                             '{{ route('chapter.correct', $chapter) }}',
                             '{{ route('chapter.status', $chapter) }}'
                         )">
                        
                        {{-- Header Bab (Tombol Accordion) --}}
                        <div class="flex justify-between items-center p-6 cursor-pointer" @click="isOpen = !isOpen">
                            <h2 class="text-2xl font-bold text-[#FFFFFF]">
                                {{ $chapter->chapter_order }}. {{ $chapter->chapter_title }}
                            </h2>
                            <div class="flex items-center gap-4">
                                {{-- Indikator Status --}}
                                <span class="px-4 py-1 rounded-full text-sm font-semibold"
                                      :class="{
                                          'bg-yellow-300/20 text-yellow-300': status === 'Pending',
                                          'bg-blue-300/20 text-blue-300': status === 'Queued' || status === 'Processing',
                                          'bg-green-400/20 text-green-400': status === 'Completed',
                                          'bg-red-400/20 text-red-400': status === 'Failed'
                                      }"
                                      x-text="statusText()"></span>
                                
                                {{-- Tombol Koreksi / Indikator Loading --}}
                                <template x-if="status === 'Pending' || status === 'Failed'">
                                    <button @click.stop="startCorrection()" class="px-6 py-2 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] text-[#0A0A2E] rounded-full font-bold hover:opacity-90 transition-all duration-200 shadow-xl">
                                        Koreksi Bab Ini
                                    </button>
                                </template>
                                <template x-if="status === 'Queued' || status === 'Processing'">
                                    <div class="w-6 h-6 border-4 border-[#85BBEB] border-t-transparent rounded-full animate-spin"></div>
                                </template>
                                <template x-if="status === 'Completed'">
                                    <div class="w-6 h-6 text-green-400">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </template>

                                {{-- Chevron --}}
                                <div class="w-6 h-6 text-[#85BBEB] transition-transform" :class="{'rotate-180': isOpen}">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Pesan Error (jika gagal) --}}
                        <template x-if="status === 'Failed' && details">
                             <div class="px-6 pb-4 -mt-2 text-red-400" x-text="'Error: ' + details"></div>
                        </template>

                        {{-- Konten Accordion (Teks Asli vs Koreksi) --}}
                        <div x-show="isOpen" x-transition class="border-t border-[#85BBEB]/20 p-8">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                {{-- Teks Asli --}}
                                <div>
                                    <h5 class="text-xl font-bold text-[#FFFFFF] mb-4">Teks Asli</h5>
                                    <div class="prose max-w-none text-[#C0C0C0] leading-relaxed text-base bg-[#0A0A2E]/50 p-4 rounded-lg max-h-[600px] overflow-y-auto">
                                        <p class="whitespace-pre-wrap break-words">{{ $chapter->original_text }}</p>
                                    </div>
                                </div>
                                {{-- Teks Koreksi --}}
                                <div>
                                    <h5 class="text-xl font-bold text-[#FFFFFF] mb-4">Rekomendasi Koreksi</h5>
                                    <div class="prose max-w-none text-[#C0C0C0] leading-relaxed text-base bg-[#0A0A2E]/50 p-4 rounded-lg min-h-[200px] max-h-[600px] overflow-y-auto"
                                         :class="{'flex items-center justify-center': status !== 'Completed'}">
                                        
                                        {{-- Tampilkan berdasarkan status --}}
                                        <template x-if="status === 'Pending' || status === 'Failed'">
                                            <span class="text-[#85BBEB]/50 italic">Klik "Koreksi Bab Ini" untuk memulai.</span>
                                        </template>
                                        <template x-if="status === 'Queued' || status === 'Processing'">
                                            <div class="text-center">
                                                <div class="w-8 h-8 border-4 border-[#85BBEB] border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                                                <span class="text-[#85BBEB]/80 italic" x-text="details || 'Memproses...'"></span>
                                            </div>
                                        </template>
                                        <template x-if="status === 'Completed'">
                                            <p class="whitespace-pre-wrap break-words" x-text="correctedText"></p>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-xl text-[#C0C0C0] bg-black/20 p-12 rounded-lg">
                        Dokumen ini tidak memiliki bab.
                    </div>
                @endforelse

            </div> {{-- End container AlpineJS --}}

            {{-- Tombol Aksi Bawah --}}
            <div class="flex flex-col sm:flex-row gap-6 justify-between items-center max-w-7xl mx-auto px-4 mt-12">
                <a href="{{ route('history') }}" class="px-12 py-4 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] text-[#0A0A2E] rounded-full font-bold text-lg hover:opacity-90 transition-all duration-200 shadow-xl border-2 border-[#85BBEB]/30">
                    Riwayat
                </a>

                <button onclick="downloadDocument()" class="px-12 py-4 bg-gradient-to-r from-[#FEF9F0] to-[#85BBEB] text-[#0A0A2E] rounded-full font-bold text-lg hover:opacity-90 transition-all duration-200 shadow-xl border-2 border-[#85BBEB]/30">
                    Unduh PDF (Gabungan)
                </button>
            </div>
        </main>
    </div>
</div>

{{-- JavaScript (Tidak berubah) --}}
<script>
    function downloadDocument() {
        window.location.href = '{{ route("document.download", $document->id) }}';
    }

    function chapterCorrector() {
        return {
            // ...
        };
    }

    function chapterItem(id, initialStatus, initialDetails, hasCorrected, correctUrl, statusUrl) {
        return {
            id: id,
            isOpen: false,
            status: initialStatus,
            details: initialDetails,
            correctedText: '',
            pollInterval: null,

            init() {
                if (this.status === 'Queued' || this.status === 'Processing') {
                    this.startPolling();
                }
                if (this.status === 'Completed' && hasCorrected) {
                    this.fetchCompletedText();
                }
            },

            statusText() {
                const map = {
                    'Pending': 'Menunggu',
                    'Queued': 'Antrian',
                    'Processing': 'Memproses',
                    'Completed': 'Selesai',
                    'Failed': 'Gagal'
                };
                return map[this.status] || this.status;
            },

            startCorrection() {
                if (this.status === 'Processing' || this.status === 'Queued') return;
                
                this.status = 'Queued';
                this.details = 'Mengantri...';
                this.isOpen = true; 

                fetch(correctUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'Queued') {
                        this.startPolling();
                    } else {
                        this.status = 'Failed';
                        this.details = 'Gagal memulai job.';
                    }
                })
                .catch(err => {
                    this.status = 'Failed';
                    this.details = 'Error jaringan saat memulai.';
                    console.error(err);
                });
            },

            startPolling() {
                if (this.pollInterval) clearInterval(this.pollInterval);

                this.pollInterval = setInterval(() => {
                    fetch(statusUrl, {
                        headers: { 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.status = data.status;
                        this.details = data.details;

                        if (data.status === 'Completed') {
                            clearInterval(this.pollInterval);
                            this.correctedText = data.corrected_text;
                        }
                        if (data.status === 'Failed') {
                            clearInterval(this.pollInterval);
                        }
                    })
                    .catch(err => {
                        clearInterval(this.pollInterval);
                        this.status = 'Failed';
                        this.details = 'Error polling status.';
                        console.error(err);
                    });
                }, 3000); // Poll setiap 3 detik
            },
            
            fetchCompletedText() {
                fetch(statusUrl, { headers: { 'Accept': 'application/json' }})
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'Completed') {
                        this.correctedText = data.corrected_text;
                    }
                });
            }
        };
    }
</script>
@endsection