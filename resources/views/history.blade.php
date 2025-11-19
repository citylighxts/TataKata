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
                <span
                    class="text-2xl font-bold bg-gradient-to-r from-[#FEF9F0] via-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent animate-gradient-text">
                    Tata Kata
                </span>
            </div>

            {{-- Ikon User --}}
            <div class="flex items-center gap-4 absolute right-0 top-1/2 -translate-y-1/2 pr-4">
                {{-- Profil --}}
                <a class="relative flex items-center group cursor-pointer">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] flex items-center justify-center shadow-lg shadow-[#85BBEB]/30 group-hover:scale-110 transition-all duration-300">
                        <svg class="w-6 h-6 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div
                        class="absolute top-full right-0 mt-2 px-4 py-2 bg-[#1a1a40] border border-[#85BBEB]/30 text-[#FEF9F0] text-sm rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 backdrop-blur-xl">
                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Profil' }}
                        <div
                            class="absolute -top-1 right-3 w-2 h-2 bg-[#1a1a40] border-l border-t border-[#85BBEB]/30 transform rotate-45">
                        </div>
                    </div>
                </a>

                {{-- Tombol Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="relative group">
                    @csrf
                    <button type="submit"
                        class="w-10 h-10 rounded-full bg-[#85BBEB]/10 border border-[#85BBEB]/30 flex items-center justify-center hover:bg-[#85BBEB]/20 hover:border-[#85BBEB]/50 transition-all duration-300 group">
                        <svg class="w-6 h-6 text-[#85BBEB] group-hover:scale-110 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                        </svg>
                    </button>
                    <div
                        class="absolute top-full right-0 mt-2 px-4 py-2 bg-[#1a1a40] border border-[#85BBEB]/30 text-[#FEF9F0] text-sm rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 backdrop-blur-xl">
                        Keluar
                        <div
                            class="absolute -top-1 right-3 w-2 h-2 bg-[#1a1a40] border-l border-t border-[#85BBEB]/30 transform rotate-45">
                        </div>
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
                Riwayat Pemeriksaan
            </h1>
            <p class="text-[#C0C0C0] text-lg">
                Kelola dan lihat semua dokumen yang telah Anda periksa
            </p>
        </div>

        @if(isset($history) && $history->count() > 0)
            
            <form id="bulk-action-form" method="POST" action="{{ route('history.bulk-delete') }}" onsubmit="return confirmBulkAction(this);">
                @csrf
                
                {{-- Bulk Actions Panel --}}
                <div class="mb-6 sm:mb-8 fade-in-up" style="animation-delay: 0.2s;">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-2xl blur-xl opacity-60"></div>
                        <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-2xl p-4 sm:p-6 border border-[#85BBEB]/30 shadow-xl">
                            <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 items-stretch sm:items-center">
                                <label class="flex items-center space-x-2 cursor-pointer group">
                                    <input type="checkbox" id="select-all" class="form-checkbox h-5 w-5 text-[#85BBEB] rounded border-[#85BBEB]/50 focus:ring-[#85BBEB] bg-[#1a1a40]/50">
                                    <span class="text-sm sm:text-base font-semibold text-[#FEF9F0] group-hover:text-[#85BBEB] transition-colors">Pilih Semua</span>
                                </label>

                                <select name="action" id="bulk-action-select" class="form-select border-[#85BBEB]/50 bg-[#1a1a40]/50 text-[#FEF9F0] rounded-xl text-sm sm:text-base disabled:opacity-50 flex-1 sm:flex-initial focus:border-[#85BBEB] focus:ring-[#85BBEB] backdrop-blur-sm" disabled>
                                    <option value="">Pilih Aksi...</option>
                                    <option value="download">Unduh File</option>
                                    <option value="delete">Hapus</option>
                                </select>

                                <button type="submit" id="bulk-action-button" class="px-6 py-2.5 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-xl text-sm sm:text-base font-semibold hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed w-full sm:w-auto relative overflow-hidden group" disabled>
                                    <span class="relative z-10">Terapkan</span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- History Cards Grid --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    @foreach($history as $index => $item)
                        @php
                            $name = $item['name'];
                            $status = ucfirst($item['upload_status'] ?? 'Selesai');
                            $createdAt = $item['created_at']->format('d M Y, H:i');
                            $itemIdKey = "document_{$item['id']}";
                            $isCompleted = strtolower($item['upload_status'] ?? '') === 'completed';
                            $isProcessing = strtolower($item['upload_status'] ?? '') === 'processing';
                            $downloadable = $isCompleted;
                            $correctionUrl = route('correction.show', $item['id']);
                            $downloadUrl = route('document.download', $item['id']);
                            $typeBadge = 'Dokumen';
                        @endphp

                        {{-- Card Item --}}
                        <div class="fade-in-up" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-2xl blur-xl opacity-60 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-2xl opacity-20 blur group-hover:opacity-30 transition-opacity duration-300"></div>
                                
                                <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-2xl overflow-hidden border border-[#85BBEB]/30 shadow-xl hover:shadow-2xl hover:shadow-[#85BBEB]/20 transition-all duration-300">
                                    <div class="p-5 sm:p-6 flex items-start gap-3 sm:gap-4">
                                        
                                        {{-- Checkbox --}}
                                        <div class="mt-1 flex-shrink-0">
                                            <input type="checkbox" name="selected_items[]" value="{{ $itemIdKey }}" 
                                                class="item-checkbox form-checkbox h-5 w-5 text-[#85BBEB] rounded border-[#85BBEB]/50 focus:ring-[#85BBEB] bg-[#1a1a40]/50"
                                                data-downloadable="{{ $downloadable ? 'true' : 'false' }}"
                                                {{ $isProcessing ? 'disabled' : '' }}>
                                        </div>

                                        {{-- Content --}}
                                        <div class="flex flex-col gap-3 flex-1 min-w-0">
                                            
                                            {{-- Badge --}}
                                            <span class="inline-flex items-center w-fit px-3 py-1 rounded-full text-xs font-bold uppercase bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] text-[#0A0A2E]">
                                                {{ $typeBadge }}
                                            </span>
                                            
                                            {{-- Title --}}
                                            <h3 class="text-lg sm:text-xl font-bold text-[#FEF9F0] truncate group-hover:text-[#85BBEB] transition-colors">
                                                {{ $name }}
                                            </h3>
                                            
                                            {{-- Meta Info --}}
                                            <div class="flex flex-col sm:flex-row sm:flex-wrap gap-2 sm:gap-4 text-xs sm:text-sm text-[#C0C0C0]">
                                                <span class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-[#85BBEB] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $createdAt }}
                                                </span>
                                                <span class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $status }}
                                                </span>
                                            </div>
                                            
                                            {{-- Action Buttons --}}
                                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 mt-2">
                                                <a href="{{ $correctionUrl }}" 
                                                   class="flex-1 px-5 py-2.5 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-xl hover:shadow-[#85BBEB]/50 transition-all duration-300 font-semibold text-sm text-center relative overflow-hidden group">
                                                    <span class="relative z-10 flex items-center justify-center gap-2">
                                                        Lihat Hasil
                                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                                        </svg>
                                                    </span>
                                                    <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                                                </a>
                                                
                                                <div class="flex gap-2 sm:gap-3">
                                                    @if($downloadable)
                                                    <a href="{{ $downloadUrl }}" 
                                                       class="flex-1 sm:flex-initial px-5 py-2.5 backdrop-blur-md bg-[#FEF9F0]/10 border-2 border-[#85BBEB]/30 text-[#FEF9F0] rounded-full hover:bg-[#FEF9F0]/20 hover:border-[#85BBEB]/50 transition-all duration-300 font-semibold text-sm text-center relative overflow-hidden group">
                                                        <span class="relative z-10">Unduh</span>
                                                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                                                    </a>
                                                    @endif

                                                    @if($isProcessing)
                                                        <button type="button" disabled title="Dokumen sedang diproses dan tidak bisa dihapus"
                                                                class="px-4 py-2.5 bg-[#1a1a40]/50 text-[#C0C0C0] rounded-full cursor-not-allowed text-sm font-medium border border-[#85BBEB]/20">
                                                            Diproses...
                                                        </button>
                                                    @else
                                                        <form method="POST" action="{{ route('history.delete') }}" 
                                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat \'{{ $name }}\'? Tindakan ini tidak bisa dibatalkan.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                                                            <input type="hidden" name="item_type" value="{{ $item['type'] }}">
                                                            
                                                            <button type="submit"
                                                                    class="p-2.5 bg-red-500/20 border border-red-500/50 text-red-400 rounded-full hover:bg-red-500/30 hover:border-red-500 transition-all duration-300 shadow-md hover:shadow-xl hover:shadow-red-500/30 group"
                                                                    title="Hapus dokumen">
                                                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h10"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        @else
            {{-- Empty State --}}
            <div class="relative fade-in-up" style="animation-delay: 0.3s;">
                <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-3xl blur-2xl opacity-60"></div>
                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-3xl opacity-20 blur"></div>
                <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-3xl p-8 sm:p-12 text-center border border-[#85BBEB]/30 shadow-2xl">
                    <div class="max-w-md mx-auto">
                        <div class="mb-6">
                            <div class="relative inline-block">
                                <div class="absolute inset-0 bg-[#85BBEB] rounded-full blur-2xl opacity-30"></div>
                                <div class="relative w-20 h-20 sm:w-24 sm:h-24 mx-auto bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-full flex items-center justify-center shadow-2xl shadow-[#85BBEB]/40">
                                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-[#FEF9F0] mb-3">Belum Ada Riwayat</h3>
                        <p class="text-base sm:text-lg text-[#C0C0C0] mb-8">
                            Belum ada dokumen yang diperiksa. Mulai unggah dokumen pertama Anda untuk melihat hasil pemeriksaan di sini.
                        </p>
                        <a href="{{ route('upload') }}" 
                           class="inline-block px-8 py-3 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full font-semibold text-base hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 relative overflow-hidden group">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Mulai Pemeriksaan
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Floating Action Button --}}
    <div class="fixed bottom-6 right-6 sm:bottom-8 sm:right-8 z-50">
        <a href="{{ route('upload') }}" 
           class="relative group">
            <div class="absolute inset-0 bg-[#85BBEB] rounded-full blur-xl opacity-50 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-110 transition-all duration-300 font-semibold text-base shadow-xl">
                <span class="hidden xs:inline">Unggah Dokumen</span>
                <span class="xs:hidden">Unggah</span>
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
        </a>
    </div>
</div>

<style>
/* Gradient Animation */
@keyframes gradient-shift {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

.animate-gradient-shift {
    background-size: 200% 200%;
    animation: gradient-shift 15s ease infinite;
}

@keyframes gradient-text {
    0%, 100% {
        background-position: 0% center;
    }
    50% {
        background-position: 100% center;
    }
}

.animate-gradient-text {
    animation: gradient-text 3s linear infinite;
}

/* Float Animations */
@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -30px) scale(1.05);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.95);
    }
}

@keyframes float-delayed {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(-40px, 30px) scale(1.1);
    }
    66% {
        transform: translate(30px, -20px) scale(0.9);
    }
}

@keyframes float-slow {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(20px, -40px) scale(1.05);
    }
}

.animate-float {
    animation: float 8s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 10s ease-in-out infinite;
}

.animate-float-slow {
    animation: float-slow 12s ease-in-out infinite;
}

/* Pulse Animations */
@keyframes pulse-slow {
    0%, 100% {
        opacity: 0.3;
        transform: scale(1);
    }
    50% {
        opacity: 0.5;
        transform: scale(1.05);
    }
}

@keyframes pulse-slower {
    0%, 100% {
        opacity: 0.2;
        transform: scale(1);
    }
    50% {
        opacity: 0.4;
        transform: scale(1.1);
    }
}

@keyframes pulse-subtle {
    0%, 100% {
        opacity: 0.5;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-pulse-slow {
    animation: pulse-slow 4s ease-in-out infinite;
}

.animate-pulse-slower {
    animation: pulse-slower 6s ease-in-out infinite;
}

.animate-pulse-subtle {
    animation: pulse-subtle 2s ease-in-out infinite;
}

/* Scroll Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
}

.fade-in-up.visible {
    animation: fadeInUp 0.8s ease-out forwards;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll Animation Observer
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

    // Bulk Action Controls
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const bulkActionSelect = document.getElementById('bulk-action-select');
    const bulkActionButton = document.getElementById('bulk-action-button');
    const bulkActionForm = document.getElementById('bulk-action-form');

    const routes = {
        delete: '{{ route("history.bulk-delete") }}',
        download: '{{ route("history.bulk-download") }}'
    };

    function updateBulkControls() {
        const checkedItems = document.querySelectorAll('.item-checkbox:checked');
        const checkedCount = checkedItems.length;
        const action = bulkActionSelect.value;

        const enableButton = checkedCount > 0 && action !== '';
        bulkActionButton.disabled = !enableButton;
        bulkActionSelect.disabled = checkedCount === 0;
        
        let canDownload = true;
        if (action === 'download') {
            checkedItems.forEach(checkbox => {
                if (checkbox.dataset.downloadable !== 'true') {
                    canDownload = false;
                }
            });
            bulkActionButton.disabled = !canDownload;
            if (!canDownload) {
                bulkActionButton.title = 'Aksi Unduh Massal hanya untuk dokumen yang sudah selesai.';
            } else {
                bulkActionButton.title = '';
            }
        } else {
             bulkActionButton.title = '';
        }
        
        bulkActionButton.disabled = !enableButton || (action === 'download' && !canDownload);
        
        bulkActionForm.querySelector('input[name="_method"]')?.remove();

        if (action === 'download') {
            bulkActionForm.method = 'GET';
            bulkActionForm.action = routes.download;
        } else if (action === 'delete') {
            bulkActionForm.method = 'POST';
            bulkActionForm.action = routes.delete;
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            bulkActionForm.appendChild(methodField);
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            itemCheckboxes.forEach(checkbox => {
                if (!checkbox.disabled) {
                    checkbox.checked = selectAllCheckbox.checked;
                }
            });
            updateBulkControls();
        });
    }

    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkControls);
    });

    if (bulkActionSelect) {
        bulkActionSelect.addEventListener('change', updateBulkControls);
    }

    window.confirmBulkAction = function(form) {
        const action = form.querySelector('#bulk-action-select').value;
        const count = document.querySelectorAll('.item-checkbox:checked').length;
        if (action === 'delete') {
            return confirm(`Anda akan menghapus ${count} item terpilih. Apakah Anda yakin?`);
        }
        return true;
    };
    
    if (itemCheckboxes.length > 0) {
        updateBulkControls();
    }
});
</script>

@endsection