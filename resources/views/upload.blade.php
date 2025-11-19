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
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        

        {{-- Page Title --}}
        <div class="text-center mb-8 sm:mb-12 fade-in-up" style="animation-delay: 0.1s;">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[#FFFFFF] mb-3">
                Unggah Dokumen
            </h1>
            <p class="text-[#C0C0C0] text-lg">
                Upload dokumen Anda untuk analisis tata bahasa
            </p>
        </div>

        {{-- Success/Error Messages --}}
        @if(session('success'))
        <div class="mb-6 fade-in-up" style="animation-delay: 0.2s;">
            <div class="relative">
                <div class="absolute inset-0 bg-green-500/20 rounded-2xl blur-xl"></div>
                <div class="relative bg-gradient-to-br from-green-500/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl border border-green-500/30 text-green-400 px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 fade-in-up" style="animation-delay: 0.2s;">
            <div class="relative">
                <div class="absolute inset-0 bg-red-500/20 rounded-2xl blur-xl"></div>
                <div class="relative bg-gradient-to-br from-red-500/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        </div>
        @endif

        {{-- Upload Form Card --}}
        <div class="relative fade-in-up" style="animation-delay: 0.3s;">
            <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-3xl blur-2xl opacity-60"></div>
            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-3xl opacity-20 blur"></div>
            <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-3xl p-6 sm:p-8 lg:p-10 border border-[#85BBEB]/30 shadow-2xl">
                
                <form id="document-upload" method="POST" action="{{ route('upload.post') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Document Name Input --}}
                    <div class="space-y-2">
                        <label for="document_name" class="block text-[#FEF9F0] font-medium text-sm">
                            Nama Dokumen
                        </label>
                        <input type="text" 
                               name="document_name" 
                               id="document_name"
                               placeholder="Masukkan nama dokumen"
                               required
                               class="w-full px-5 py-3.5 bg-[#1a1a40]/50 backdrop-blur-sm border border-[#85BBEB]/30 text-[#FEF9F0] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#85BBEB] focus:border-transparent transition-all duration-300 placeholder-[#C0C0C0]/50"
                               value="{{ old('document_name') }}">
                        @error('document_name')
                            <p class="text-red-400 text-sm mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- File Upload Area --}}
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#85BBEB]/5 rounded-2xl blur-xl"></div>
                        <div class="relative bg-[#1a1a40]/30 backdrop-blur-sm border-2 border-dashed border-[#85BBEB]/40 rounded-2xl p-8 sm:p-12 text-center hover:border-[#85BBEB]/60 transition-all duration-300 group">
                            
                            <input type="file" 
                                   name="file" 
                                   id="document"
                                   accept=".pdf,.doc,.docx"
                                   required
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                   onchange="updateFileName(this)">
                            
                            {{-- Default State --}}
                            <div id="upload-default" class="pointer-events-none">
                                <div class="relative inline-block mb-4">
                                    <div class="absolute inset-0 bg-[#85BBEB] rounded-full blur-lg opacity-30 group-hover:opacity-50 transition-opacity"></div>
                                    <div class="relative w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-full flex items-center justify-center shadow-xl shadow-[#85BBEB]/30 group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-[#FEF9F0] text-lg font-semibold mb-2">
                                    Tarik & lepas dokumen disini
                                </h3>
                                <p class="text-[#C0C0C0] text-sm mb-3">
                                    atau klik untuk memilih file
                                </p>
                                <div class="flex items-center justify-center gap-2 text-[#85BBEB] text-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Format: PDF, DOC, DOCX (Max: 10MB)</span>
                                </div>
                            </div>

                            {{-- Success State --}}
                            <div id="upload-success" class="pointer-events-none hidden">
                                <div class="relative inline-block mb-4">
                                    <div class="absolute inset-0 bg-green-500 rounded-2xl blur-lg opacity-40"></div>
                                    <div class="relative w-20 h-24 sm:w-24 sm:h-28 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-2xl flex items-center justify-center shadow-2xl shadow-[#85BBEB]/40 mx-auto">
                                        <svg class="w-12 h-12 sm:w-14 sm:h-14 text-[#0A0A2E]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                        </svg>
                                        <div class="absolute -top-2 -right-2 bg-green-500 rounded-full w-8 h-8 flex items-center justify-center shadow-lg shadow-green-500/50">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="text-[#FEF9F0] text-lg font-semibold mb-2" id="file-name">Dokumen.pdf</h3>
                                <p class="text-[#C0C0C0] text-sm mb-3">
                                    Klik untuk mengganti file
                                </p>
                                <div class="flex items-center justify-center gap-2 text-green-400 text-sm font-medium">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>File siap diunggah</span>
                                </div>
                            </div>
                        </div>
                        @error('file')
                            <p class="text-red-400 text-sm mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('dashboard') }}" 
                           class="flex-1 px-6 py-3.5 backdrop-blur-md bg-[#FEF9F0]/10 border-2 border-[#85BBEB]/30 text-[#FEF9F0] rounded-xl hover:bg-[#FEF9F0]/20 hover:border-[#85BBEB]/50 transition-all duration-300 font-semibold text-center relative overflow-hidden group">
                            <span class="relative z-10">Batal</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        </a>
                        
                        <button type="submit" 
                                class="flex-1 px-6 py-3.5 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-xl hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-semibold relative overflow-hidden group">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Unggah dan Periksa
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        </button>
                    </div>
                </form>

                {{-- PEMISAH DAN TOMBOL DEBUG --}}
                <div class="relative flex items-center justify-center my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[#85BBEB]/20"></div>
                    </div>
                    <div class="relative px-4">
                        <span class="text-[#C0C0C0] text-sm">Atau</span>
                    </div>
                </div>
            
                {{-- TOMBOL DEBUG BARU --}}
                <a href="{{ route('upload.debug') }}" 
                   class="w-full flex-1 px-6 py-3.5 backdrop-blur-md bg-[#1a1a40]/50 border-2 border-[#85BBEB]/30 text-[#85BBEB] rounded-xl hover:bg-[#1a1a40]/80 hover:border-[#85BBEB]/50 transition-all duration-300 font-semibold text-center relative overflow-hidden group flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.43a4 4 0 00-5.656 0L12 17.256l-1.772-1.826a4 4 0 00-5.656 0 4 4 0 000 5.656L12 24l7.428-7.914a4 4 0 000-5.656zM12 2a4 4 0 014 4v2a4 4 0 11-8 0V6a4 4 0 014-4z"></path></svg>
                    <span class="relative z-10">Gunakan File Testcase</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/10 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </a>
                {{-- AKHIR BAGIAN MODIFIKASI --}}

            </div>
        </div>

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

/* File Upload Animation */
@keyframes fadeIn {
    from { 
        opacity: 0; 
        transform: scale(0.95); 
    }
    to { 
        opacity: 1; 
        transform: scale(1); 
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
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

});

// File Upload Handler
function updateFileName(input) {
    const defaultState = document.getElementById('upload-default');
    const successState = document.getElementById('upload-success');
    const fileNameDisplay = document.getElementById('file-name');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileName = file.name;

        // Validasi ekstensi file
        // Pastikan ini sinkron dengan validasi 'mimes' di DocumentController
        const allowedExtensions = ['pdf', 'doc', 'docx']; // Menghapus 'txt'
        const fileExtension = fileName.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            // (Catatan: Anda tidak menggunakan alert() di kode asli, jadi saya akan ikuti pola itu)
            // Jika Anda ingin notifikasi, di sinilah tempatnya.
            // alert("❌ Format file tidak diizinkan!\nHarap upload file dengan format: PDF, DOC, atau DOCX.");
            input.value = ''; // reset input
            
            // Kembalikan ke default
            defaultState.classList.remove('hidden');
            successState.classList.add('hidden');
            return; // hentikan fungsi (file tidak diterima)
        }

        // Kalau format benar → tampilkan nama file
        fileNameDisplay.textContent = fileName;

        // Ubah tampilan jadi "file berhasil dipilih"
        defaultState.classList.add('hidden');
        successState.classList.remove('hidden');
        successState.classList.add('animate-fadeIn');

        // Hilangkan animasi setelah selesai
        setTimeout(() => {
            successState.classList.remove('animate-fadeIn');
        }, 300);
    } else {
        // Jika user batal pilih file → kembalikan ke default
        defaultState.classList.remove('hidden');
        successState.classList.add('hidden');
    }
}


// Drag and Drop Enhancement
const uploadArea = document.querySelector('[id="document"]').parentElement;

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    uploadArea.classList.add('border-[#85BBEB]', 'bg-[#85BBEB]/5');
}

function unhighlight(e) {
    uploadArea.classList.remove('border-[#85BBEB]', 'bg-[#85BBEB]/5');
}

uploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    const fileInput = document.getElementById('document');
    fileInput.files = files;
    updateFileName(fileInput);
}

</script>

@endsection