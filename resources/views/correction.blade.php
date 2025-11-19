@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A2E] relative overflow-hidden">
    
    {{-- Animated Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-[#0A0A2E] via-[#1a1a40] to-[#0A0A2E] animate-gradient-shift"></div>
    
    {{-- Grid Pattern Overlay --}}
    <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(#85BBEB 1px, transparent 1px), linear-gradient(90deg, #85BBEB 1px, transparent 1px); background-size: 50px 50px;"></div>
    

    {{-- Navbar --}}
    <header class="relative z-50 backdrop-blur-xl bg-[#0A0A2E]/70 border-b border-[#85BBEB]/20 shadow-lg shadow-[#85BBEB]/5">
        <div class="w-full py-10"> 
            <div class="flex justify-between items-center relative">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer absolute left-0 top-1/2 -translate-y-1/2 pl-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-xl blur-lg opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                        <img src="{{ asset('images/ikon-logo.png') }}" alt="Logo"
                            class="relative w-12 h-12 rounded-xl transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                </a>
                
                {{-- Tata Kata --}}
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <span class="text-2xl font-bold bg-gradient-to-r from-[#FEF9F0] via-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent animate-gradient-text">
                        Tata Kata
                    </span>
                </div>

                {{-- Ikon User --}}
                <div class="flex items-center gap-4 absolute right-0 top-1/2 -translate-y-1/2 pr-4">
                    {{-- Profil --}}
                    <a class="relative flex items-center group cursor-pointer">
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

                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="relative group">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-full bg-[#85BBEB]/10 border border-[#85BBEB]/30 flex items-center justify-center hover:bg-[#85BBEB]/20 hover:border-[#85BBEB]/50 transition-all duration-300 group">
                            <svg class="w-6 h-6 text-[#85BBEB] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                            </svg>
                        </button>
                        <div class="absolute top-full right-0 mt-2 px-4 py-2 bg-[#1a1a40] border border-[#85BBEB]/30 text-[#FEF9F0] text-sm rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 backdrop-blur-xl">
                            Keluar
                            <div class="absolute -top-1 right-3 w-2 h-2 bg-[#1a1a40] border-l border-t border-[#85BBEB]/30 transform rotate-45"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="relative">
        {{-- Breadcrumb --}}
    <div class="absolute left-0 w-screen">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-2 text-[#85BBEB] hover:text-[#FEF9F0] transition-colors duration-300 group fade-in-up px-4 pt-2">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="font-medium">Kembali ke Beranda</span>
        </a>
    </div>

        {{-- Main Content --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            
            {{-- Page Title --}}
            <div class="text-center mb-8 sm:mb-12 fade-in-up" style="animation-delay: 0.1s;">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[#FFFFFF] mb-3">
                    Hasil Pemeriksaan
                </h1>
                <p class="text-[#C0C0C0] text-base sm:text-lg">
                    File: <span class="font-semibold text-[#85BBEB]">{{ $document->file_name }}</span>
                </p>
            </div>

            {{-- Container untuk logika AlpineJS --}}
            <div class="space-y-6 fade-in-up" style="animation-delay: 0.2s;" x-data="chapterCorrector()">

                @forelse ($document->chapters as $chapter)
                    {{-- Setiap Bab adalah komponen AlpineJS --}}
                    <div class="relative"
                         x-data="chapterItem(
                             {{ $chapter->id }},
                             '{{ $chapter->status }}',
                             '{{ $chapter->details }}',
                             {{ $chapter->corrected_text ? 'true' : 'false' }},
                             '{{ route('chapter.correct', $chapter) }}',
                             '{{ route('chapter.status', $chapter) }}'
                         )">
                        
                        <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-3xl blur-2xl opacity-60"></div>
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-3xl opacity-20 blur"></div>
                        
                        <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-[#85BBEB]/30 overflow-hidden">
                            
                            {{-- Header Bab (Tombol Accordion) --}}
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-4 sm:p-6 cursor-pointer" @click="isOpen = !isOpen">
                                <h2 class="text-xl sm:text-2xl font-bold text-[#FFFFFF]">
                                    {{ $chapter->chapter_order }}. {{ $chapter->chapter_title }}
                                </h2>
                                <div class="flex flex-wrap items-center gap-3 sm:gap-4 w-full sm:w-auto">
                                    {{-- Indikator Status --}}
                                    <span class="px-3 sm:px-4 py-1 rounded-full text-xs sm:text-sm font-semibold"
                                          :class="{
                                              'bg-yellow-300/20 text-yellow-300': status === 'Pending',
                                              'bg-blue-300/20 text-blue-300': status === 'Queued' || status === 'Processing',
                                              'bg-green-400/20 text-green-400': status === 'Completed',
                                              'bg-red-400/20 text-red-400': status === 'Failed'
                                          }"
                                          x-text="statusText()"></span>
                                    
                                    {{-- Tombol Koreksi / Indikator Loading --}}
                                    <template x-if="status === 'Pending' || status === 'Failed'">
                                        <button @click.stop="startCorrection()" class="px-4 sm:px-6 py-2 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] text-[#0A0A2E] rounded-full font-bold text-sm sm:text-base hover:opacity-90 transition-all duration-200 shadow-xl whitespace-nowrap">
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
                                <div class="px-4 sm:px-6 pb-4 -mt-2 text-red-400 text-sm" x-text="'Error: ' + details"></div>
                            </template>

                            {{-- Konten Accordion (Teks Asli vs Koreksi) --}}
                            <div x-show="isOpen" x-transition class="border-t border-[#85BBEB]/20 p-4 sm:p-6 lg:p-8">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                                    {{-- Teks Asli --}}
                                    <div>
                                        <h5 class="text-lg sm:text-xl font-bold text-[#FFFFFF] mb-3 sm:mb-4">Teks Asli</h5>
                                        <div class="prose max-w-none text-[#C0C0C0] leading-relaxed text-sm sm:text-base bg-[#0A0A2E]/50 p-4 rounded-xl max-h-[400px] sm:max-h-[600px] overflow-y-auto custom-scrollbar">
                                            <p class="whitespace-pre-wrap break-words">{{ $chapter->original_text }}</p>
                                        </div>
                                    </div>
                                    {{-- Teks Koreksi --}}
                                    <div>
                                        <h5 class="text-lg sm:text-xl font-bold text-[#FFFFFF] mb-3 sm:mb-4">Rekomendasi Koreksi</h5>
                                        <div class="prose max-w-none text-[#C0C0C0] leading-relaxed text-sm sm:text-base bg-[#0A0A2E]/50 p-4 rounded-xl min-h-[200px] max-h-[400px] sm:max-h-[600px] overflow-y-auto custom-scrollbar"
                                             :class="{'flex items-center justify-center': status !== 'Completed'}">
                                            
                                            {{-- Tampilkan berdasarkan status --}}
                                            <template x-if="status === 'Pending' || status === 'Failed'">
                                                <span class="text-[#85BBEB]/50 italic text-center">Klik "Koreksi Bab Ini" untuk memulai.</span>
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
                    </div>
                @empty
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/10 to-transparent rounded-2xl blur-xl"></div>
                        <div class="relative text-center text-lg sm:text-xl text-[#C0C0C0] bg-[#0A0A2E]/50 backdrop-blur-sm p-8 sm:p-12 rounded-2xl border border-[#85BBEB]/20">
                            Dokumen ini tidak memiliki bab.
                        </div>
                    </div>
                @endforelse

            </div> {{-- End container AlpineJS --}}

            {{-- Tombol Aksi Bawah --}}
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 mt-8 sm:mt-12 fade-in-up" style="animation-delay: 0.3s;">
                <a href="{{ route('history') }}" class="flex-1 px-6 sm:px-8 py-3 sm:py-4 backdrop-blur-md bg-[#FEF9F0]/10 border-2 border-[#85BBEB]/30 text-[#FEF9F0] rounded-xl hover:bg-[#FEF9F0]/20 hover:border-[#85BBEB]/50 transition-all duration-300 font-semibold text-center relative overflow-hidden group">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Riwayat
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </a>

                <button onclick="downloadDocument()" class="flex-1 px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-xl hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-semibold relative overflow-hidden group">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Unduh PDF
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </button>
            </div>
        </div>
    </main>
</div>

<style>
/* Gradient Animation */
@keyframes gradient-shift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-gradient-shift {
    background-size: 200% 200%;
    animation: gradient-shift 15s ease infinite;
}

@keyframes gradient-text {
    0%, 100% { background-position: 0% center; }
    50% { background-position: 100% center; }
}

.animate-gradient-text {
    animation: gradient-text 3s linear infinite;
}

/* Float Animations */
@keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -30px) scale(1.05); }
    66% { transform: translate(-20px, 20px) scale(0.95); }
}

@keyframes float-delayed {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(-40px, 30px) scale(1.1); }
    66% { transform: translate(30px, -20px) scale(0.9); }
}

@keyframes float-slow {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(20px, -40px) scale(1.05); }
}

.animate-float { animation: float 8s ease-in-out infinite; }
.animate-float-delayed { animation: float-delayed 10s ease-in-out infinite; }
.animate-float-slow { animation: float-slow 12s ease-in-out infinite; }

/* Pulse Animations */
@keyframes pulse-slow {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.05); }
}

@keyframes pulse-slower {
    0%, 100% { opacity: 0.2; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(1.1); }
}

@keyframes pulse-subtle {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 0.8; }
}

.animate-pulse-slow { animation: pulse-slow 4s ease-in-out infinite; }
.animate-pulse-slower { animation: pulse-slower 6s ease-in-out infinite; }
.animate-pulse-subtle { animation: pulse-subtle 2s ease-in-out infinite; }

/* Scroll Animation */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
}

.fade-in-up.visible {
    animation: fadeInUp 0.8s ease-out forwards;
}

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(133, 187, 235, 0.1);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(133, 187, 235, 0.4);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(133, 187, 235, 0.6);
}


</style>

<script>
function downloadDocument() {
    window.location.href = '{{ route("document.download", $document->id) }}';
}

function chapterCorrector() {
    return {};
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
            }, 3000);
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

// Scroll Animation Observer
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });

});
</script>
@endsection