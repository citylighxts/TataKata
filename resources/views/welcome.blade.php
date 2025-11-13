@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A2E] relative overflow-hidden">
    
    {{-- Animated Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-[#0A0A2E] via-[#1a1a40] to-[#0A0A2E] animate-gradient-shift"></div>
    
    {{-- Grid Pattern Overlay --}}
    <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(#85BBEB 1px, transparent 1px), linear-gradient(90deg, #85BBEB 1px, transparent 1px); background-size: 50px 50px;"></div>
    
    {{-- Animated Background Elements - Interactive with Mouse --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="blob-interactive absolute top-0 -left-4 w-96 h-96 bg-[#85bbeb28] rounded-full mix-blend-screen filter blur-3xl opacity-20 animate-float"></div>
        <div class="blob-interactive absolute top-0 -right-4 w-96 h-96 bg-[#FEF9F0] rounded-full mix-blend-screen filter blur-3xl opacity-15 animate-float-delayed"></div>
        <div class="blob-interactive absolute -bottom-8 left-20 w-96 h-96 bg-[#85bbeb2f] rounded-full mix-blend-screen filter blur-3xl opacity-10 animate-float-slow"></div>
        
        {{-- Extra decorative blobs --}}
        <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-[#C0C0C0] rounded-full mix-blend-screen filter blur-2xl opacity-10 animate-pulse-slow"></div>
        <div class="absolute bottom-1/4 left-1/3 w-72 h-72 bg-[#85BBEB] rounded-full mix-blend-screen filter blur-3xl opacity-15 animate-pulse-slower"></div>
    </div>

    {{-- Navbar --}}
    <header class="relative z-50 backdrop-blur-xl bg-[#0A0A2E]/70 border-b border-[#85BBEB]/20 shadow-lg shadow-[#85BBEB]/5">
        <div class="w-full px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer flex-shrink-0">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-xl blur-lg opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                        <img src="{{ asset('images/ikon-logo.png') }}" alt="Logo" class="relative w-10 h-10 sm:w-12 sm:h-12 rounded-xl transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                </a>

                {{-- Tata Kata - Centered --}}
                <div class="absolute left-1/2 transform -translate-x-1/2">
                    <span class="text-lg sm:text-xl md:text-2xl font-bold bg-gradient-to-r from-[#FEF9F0] via-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent animate-gradient-text whitespace-nowrap">
                        Tata Kata
                    </span>
                </div>

                {{-- Tombol Masuk & Daftar - Hidden on mobile, visible on md+ --}}
                <div class="hidden md:flex gap-3 flex-shrink-0">
                    <a href="{{ route('login') }}" class="px-4 lg:px-6 py-2 lg:py-2.5 border-2 border-[#85BBEB]/40 text-[#FEF9F0] rounded-full hover:bg-[#85BBEB]/20 hover:border-[#85BBEB]/60 hover:shadow-lg hover:shadow-[#85BBEB]/30 transition-all duration-300 font-medium backdrop-blur-sm relative overflow-hidden group text-sm lg:text-base">
                        <span class="relative z-10">Masuk</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                    <a href="{{ route('register') }}" class="px-4 lg:px-6 py-2 lg:py-2.5 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-medium relative overflow-hidden group text-sm lg:text-base">
                        <span class="relative z-10 font-semibold">Daftar</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>

                {{-- Mobile Menu Button - Visible only on mobile --}}
                <button class="md:hidden w-10 h-10 flex items-center justify-center rounded-full bg-[#85BBEB]/10 border border-[#85BBEB]/30 hover:bg-[#85BBEB]/20 transition-all duration-300 flex-shrink-0" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6 text-[#85BBEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

            </div>
        </div>

        {{-- Mobile Menu Dropdown --}}
        <div id="mobileMenu" class="md:hidden hidden bg-[#0A0A2E]/95 backdrop-blur-xl border-t border-[#85BBEB]/20">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('login') }}" class="block w-full px-6 py-3 border-2 border-[#85BBEB]/40 text-[#FEF9F0] rounded-full hover:bg-[#85BBEB]/20 hover:border-[#85BBEB]/60 transition-all duration-300 font-medium text-center">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block w-full px-6 py-3 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 transition-all duration-300 font-semibold text-center">
                    Daftar
                </a>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            {{-- Left Content --}}
            <div class="space-y-8 fade-in-up">
                <div class="inline-block relative">
                    <div class="absolute inset-0 bg-[#85BBEB]/20 blur-xl rounded-full"></div>
                    <span class="relative px-5 py-2.5 bg-gradient-to-r from-[#85BBEB]/30 via-[#85BBEB]/20 to-transparent backdrop-blur-md border border-[#85BBEB]/40 rounded-full text-[#85BBEB] text-sm font-medium shadow-lg shadow-[#85BBEB]/10 flex items-center gap-2">
                        <span class="animate-pulse">✨</span>
                        <span>Powered by AI Technology</span>
                    </span>
                </div>
                
                <div class="space-y-6">
                    <h1 class="text-5xl lg:text-7xl font-black text-[#FFFFFF] leading-tight">
                        <span class="inline-block hover:scale-105 transition-transform duration-300">Periksa</span> 
                        <span class="inline-block hover:scale-105 transition-transform duration-300">Kata,</span><br>
                        <span class="relative inline-block">
                            <span class="absolute inset-0 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] blur-2xl opacity-20"></span>
                            <span class="relative bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] bg-clip-text text-transparent animate-gradient-text bg-[length:200%_auto]">Sempurnakan Bahasa</span>
                        </span>
                    </h1>
                    <p class="text-xl text-[#C0C0C0] leading-relaxed max-w-xl relative">
                        <span class="absolute -left-3 top-0 w-1 h-full bg-gradient-to-b from-[#85BBEB] to-transparent rounded-full"></span>
                        Platform koreksi tata bahasa berbasis AI yang membantu menyempurnakan tulisan tugas akhir Anda dengan akurat dan efisien.
                    </p>
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="group px-8 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 transition-all duration-300 font-semibold flex items-center gap-2 relative overflow-hidden">
                        <span class="relative z-10 flex items-center gap-2">
                            Mulai Gratis
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                    <a href="#features" class="px-8 py-4 backdrop-blur-md bg-[#FEF9F0]/10 border-2 border-[#85BBEB]/30 text-[#FEF9F0] rounded-full hover:bg-[#FEF9F0]/20 hover:border-[#85BBEB]/50 hover:shadow-lg hover:shadow-[#85BBEB]/20 transition-all duration-300 font-semibold relative overflow-hidden group">
                        <span class="relative z-10">Pelajari Lebih Lanjut</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                </div>

                
            </div>

            {{-- Right Content - Logo with enhanced effects --}}
            <div class="relative flex items-center justify-center fade-in-up" style="animation-delay: 0.2s;">
                
                <div class="absolute inset-0 bg-[#85BBEB]/20 rounded-full blur-2xl animate-spin-slow"></div>
                <div class="relative group cursor-pointer">
                    
                    <img src="{{ asset('images/logo-tatakata.png') }}" 
                         alt="Logo Tata Kata" 
                         class="relative w-full max-w-md lg:max-w-lg drop-shadow-2xl transition-all duration-[2000ms] ease-in-out group-hover:scale-110 group-hover:rotate-[360deg]"
                         >
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section with enhanced cards --}}
    <section id="features" class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16 fade-in-up">
            <div class="inline-block mb-4">
                
            </div>
            <h2 class="text-4xl lg:text-5xl font-bold text-[#FFFFFF] mb-4">
                Fitur <span class="bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent">Unggulan</span>
            </h2>
            <p class="text-xl text-[#C0C0C0]">
                Teknologi AI terdepan untuk analisis bahasa yang komprehensif
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            {{-- Feature 1 --}}
            <div class="group relative fade-in-up" style="animation-delay: 0.1s;">
                <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-2xl blur-xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-2xl opacity-0 group-hover:opacity-20 blur transition-all duration-500"></div>
                <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-2xl p-8 border border-[#85BBEB]/30 hover:border-[#85BBEB]/60 transition-all duration-500 h-full group-hover:translate-y-[-4px] shadow-xl hover:shadow-2xl hover:shadow-[#85BBEB]/20">
                    <div class="relative w-14 h-14 bg-gradient-to-br from-[#85BBEB] to-[#85BBEB]/70 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-lg shadow-[#85BBEB]/50">
                        <div class="absolute inset-0 bg-[#FEF9F0]/20 rounded-xl blur group-hover:blur-md transition-all duration-300"></div>
                        <svg class="relative z-10 w-7 h-7 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#FFFFFF] mb-3 group-hover:text-[#85BBEB] transition-colors duration-300">Pemeriksaan Tata Bahasa</h3>
                    <p class="text-[#C0C0C0] leading-relaxed">Deteksi otomatis kesalahan tata bahasa, ejaan, dan struktur kalimat dengan akurasi tinggi menggunakan AI terbaru.</p>
                    <div class="mt-4 h-1 w-0 group-hover:w-full bg-gradient-to-r from-[#85BBEB] to-transparent transition-all duration-500 rounded-full"></div>
                </div>
            </div>

            {{-- Feature 2 --}}
            <div class="group relative fade-in-up" style="animation-delay: 0.2s;">
                <div class="absolute inset-0 bg-gradient-to-br from-[#FEF9F0]/20 to-transparent rounded-2xl blur-xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#FEF9F0] to-[#85BBEB] rounded-2xl opacity-0 group-hover:opacity-20 blur transition-all duration-500"></div>
                <div class="relative bg-gradient-to-br from-[#85BBEB]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-2xl p-8 border border-[#85BBEB]/30 hover:border-[#85BBEB]/60 transition-all duration-500 h-full group-hover:translate-y-[-4px] shadow-xl hover:shadow-2xl hover:shadow-[#FEF9F0]/10">
                    <div class="relative w-14 h-14 bg-gradient-to-br from-[#FEF9F0] to-[#85BBEB] rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-lg shadow-[#FEF9F0]/30">
                        <div class="absolute inset-0 bg-[#85BBEB]/30 rounded-xl blur group-hover:blur-md transition-all duration-300"></div>
                        <svg class="relative z-10 w-7 h-7 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#FFFFFF] mb-3 group-hover:text-[#FEF9F0] transition-colors duration-300">Analisis Real-time</h3>
                    <p class="text-[#C0C0C0] leading-relaxed">Proses dokumen dengan cepat dan dapatkan hasil analisis komprehensif dalam hitungan detik dengan teknologi AI canggih.</p>
                    <div class="mt-4 h-1 w-0 group-hover:w-full bg-gradient-to-r from-[#FEF9F0] to-transparent transition-all duration-500 rounded-full"></div>
                </div>
            </div>

            {{-- Feature 3 --}}
            <div class="group relative fade-in-up" style="animation-delay: 0.3s;">
                <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-2xl blur-xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#C0C0C0] rounded-2xl opacity-0 group-hover:opacity-20 blur transition-all duration-500"></div>
                <div class="relative bg-gradient-to-br from-[#C0C0C0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-2xl p-8 border border-[#85BBEB]/30 hover:border-[#85BBEB]/60 transition-all duration-500 h-full group-hover:translate-y-[-4px] shadow-xl hover:shadow-2xl hover:shadow-[#85BBEB]/20">
                    <div class="relative w-14 h-14 bg-gradient-to-br from-[#85BBEB] to-[#C0C0C0] rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-lg shadow-[#85BBEB]/40">
                        <div class="absolute inset-0 bg-[#FEF9F0]/10 rounded-xl blur group-hover:blur-md transition-all duration-300"></div>
                        <svg class="relative z-10 w-7 h-7 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#FFFFFF] mb-3 group-hover:text-[#85BBEB] transition-colors duration-300">Aman & Privat</h3>
                    <p class="text-[#C0C0C0] leading-relaxed">Dokumen Anda tersimpan dengan enkripsi tingkat tinggi dan tidak akan dibagikan kepada pihak lain. Privasi terjamin 100%.</p>
                    <div class="mt-4 h-1 w-0 group-hover:w-full bg-gradient-to-r from-[#85BBEB] via-[#C0C0C0] to-transparent transition-all duration-500 rounded-full"></div>
                </div>
            </div>

            {{-- Feature 4 --}}
            <div class="group relative fade-in-up" style="animation-delay: 0.4s;">
                <div class="absolute inset-0 bg-gradient-to-br from-[#FEF9F0]/20 to-transparent rounded-2xl blur-xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-2xl opacity-0 group-hover:opacity-20 blur transition-all duration-500"></div>
                <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-2xl p-8 border border-[#85BBEB]/30 hover:border-[#85BBEB]/60 transition-all duration-500 h-full group-hover:translate-y-[-4px] shadow-xl hover:shadow-2xl hover:shadow-[#FEF9F0]/10">
                    <div class="relative w-14 h-14 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-lg shadow-[#85BBEB]/50">
                        <div class="absolute inset-0 bg-[#85BBEB]/20 rounded-xl blur group-hover:blur-md transition-all duration-300 animate-pulse-subtle"></div>
                        <svg class="relative z-10 w-7 h-7 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#FFFFFF] mb-3 group-hover:text-[#85BBEB] transition-colors duration-300">100% Gratis</h3>
                    <p class="text-[#C0C0C0] leading-relaxed">Semua fitur premium dapat diakses secara gratis tanpa biaya tersembunyi. Tidak ada batasan penggunaan atau watermark.</p>
                    <div class="mt-4 h-1 w-0 group-hover:w-full bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-transparent transition-all duration-500 rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works with timeline --}}
    <section class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16 fade-in-up">
            <div class="inline-block mb-4">
                
            </div>
            <h2 class="text-4xl lg:text-5xl font-bold text-[#FFFFFF] mb-4">
                Cara <span class="bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent">Kerja</span>
            </h2>
            <p class="text-xl text-[#C0C0C0]">
                Tiga langkah sederhana untuk menyempurnakan tulisan Anda
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 relative">
            {{-- Animated Connection Line --}}
            <div class="hidden md:block absolute top-24 left-0 right-0 h-0.5">
                <div class="h-full w-full bg-gradient-to-r from-transparent via-[#85BBEB]/50 to-transparent"></div>
                <div class="h-full w-0 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] animate-line-expand absolute top-0 left-0"></div>
            </div>
            
            {{-- Step 1 --}}
            <div class="relative text-center fade-in-up" style="animation-delay: 0.1s;">
                <div class="relative inline-flex items-center justify-center w-20 h-20 mb-6 group">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB] to-[#85BBEB]/70 rounded-2xl blur-md opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                    <div class="relative w-16 h-16 bg-gradient-to-br from-[#85BBEB] to-[#85BBEB]/80 rounded-2xl text-[#0A0A2E] text-2xl font-bold shadow-2xl shadow-[#85BBEB]/50 flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                        1
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-[#FFFFFF] mb-3">Unggah Dokumen</h3>
                <p class="text-[#C0C0C0]">Upload file DOCX atau PDF yang ingin Anda periksa</p>
            </div>

            {{-- Step 2 --}}
            <div class="relative text-center fade-in-up" style="animation-delay: 0.2s;">
                <div class="relative inline-flex items-center justify-center w-20 h-20 mb-6 group">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#FEF9F0] to-[#85BBEB] rounded-2xl blur-md opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                    <div class="relative w-16 h-16 bg-gradient-to-br from-[#FEF9F0] to-[#85BBEB] rounded-2xl text-[#0A0A2E] text-2xl font-bold shadow-2xl shadow-[#FEF9F0]/30 flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                        2
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-[#FFFFFF] mb-3">AI Menganalisis</h3>
                <p class="text-[#C0C0C0]">Sistem AI kami memproses dan menganalisis dokumen Anda</p>
            </div>

            {{-- Step 3 --}}
            <div class="relative text-center fade-in-up" style="animation-delay: 0.3s;">
                <div class="relative inline-flex items-center justify-center w-20 h-20 mb-6 group">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB] to-[#C0C0C0] rounded-2xl blur-md opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                    <div class="relative w-16 h-16 bg-gradient-to-br from-[#85BBEB] to-[#C0C0C0] rounded-2xl text-[#0A0A2E] text-2xl font-bold shadow-2xl shadow-[#85BBEB]/40 flex items-center justify-center group-hover:scale-110 transition-all duration-300">
                        3
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-[#FFFFFF] mb-3">Terima Hasil</h3>
                <p class="text-[#C0C0C0]">Dapatkan laporan lengkap dengan saran perbaikan</p>
            </div>
        </div>
    </section>

    {{-- CTA Section with enhanced design --}}
    <section class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="relative fade-in-up">
            <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/30 via-[#FEF9F0]/20 to-[#85BBEB]/30 rounded-3xl blur-3xl opacity-60 animate-pulse-slow"></div>
            <div class="absolute -inset-1 bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] rounded-3xl opacity-20 blur"></div>
            <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#85BBEB]/10 backdrop-blur-xl rounded-3xl p-12 border border-[#85BBEB]/30 text-center shadow-2xl">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-[#FFFFFF] mb-6 mt-4">
                    Siap Menyempurnakan<br/>
                    <span class="bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] bg-clip-text text-transparent animate-gradient-text bg-[length:200%_auto]">Tulisan Anda?</span>
                </h2>
                <p class="text-xl text-[#C0C0C0] mb-8 max-w-2xl mx-auto leading-relaxed">
                    Bergabunglah dengan <span class="text-[#85BBEB] font-semibold">ribuan mahasiswa</span> yang telah mempercayai Tata Kata untuk menyempurnakan tugas akhir mereka.
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] text-lg rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold group relative overflow-hidden">
                    <span class="relative z-10 flex items-center gap-3">
                        Mulai Sekarang - Gratis
                        <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </a>
                
            </div>
        </div>
    </section>

    {{-- Footer with enhanced design --}}
    <footer class="relative z-10 border-t border-[#85BBEB]/20 backdrop-blur-xl bg-[#0A0A2E]/80 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-[#85BBEB] rounded-lg blur opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                            <img src="{{ asset('images/ikon-logo.png') }}" alt="Logo" class="relative w-10 h-10 rounded-lg">
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-[#FEF9F0] to-[#85BBEB] bg-clip-text text-transparent">Tata Kata</span>
                    </div>
                    <p class="text-[#C0C0C0] leading-relaxed">
                        Platform koreksi tata bahasa berbasis AI untuk menyempurnakan tulisan tugas akhir Anda.
                    </p>
                    <div class="flex gap-3 pt-2">
                        <a href="#" class="w-10 h-10 rounded-full bg-[#85BBEB]/10 border border-[#85BBEB]/30 flex items-center justify-center hover:bg-[#85BBEB]/20 hover:border-[#85BBEB]/50 transition-all duration-300 group">
                            <svg class="w-5 h-5 text-[#85BBEB] group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-[#85BBEB]/10 border border-[#85BBEB]/30 flex items-center justify-center hover:bg-[#85BBEB]/20 hover:border-[#85BBEB]/50 transition-all duration-300 group">
                            <svg class="w-5 h-5 text-[#85BBEB] group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-[#85BBEB]/10 border border-[#85BBEB]/30 flex items-center justify-center hover:bg-[#85BBEB]/20 hover:border-[#85BBEB]/50 transition-all duration-300 group">
                            <svg class="w-5 h-5 text-[#85BBEB] group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-[#FFFFFF]">Lompat Ke</h3>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-[#C0C0C0] hover:text-[#85BBEB] transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-0 group-hover:w-2 h-0.5 bg-[#85BBEB] transition-all duration-300"></span>
                            Fitur
                        </a></li>
                        <li><a href="{{ route('register') }}" class="text-[#C0C0C0] hover:text-[#85BBEB] transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-0 group-hover:w-2 h-0.5 bg-[#85BBEB] transition-all duration-300"></span>
                            Daftar
                        </a></li>
                        <li><a href="{{ route('login') }}" class="text-[#C0C0C0] hover:text-[#85BBEB] transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-0 group-hover:w-2 h-0.5 bg-[#85BBEB] transition-all duration-300"></span>
                            Masuk
                        </a></li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-[#FFFFFF]">Kontak</h3>
                    <ul class="space-y-3 text-[#C0C0C0]">
                        <li class="flex items-center gap-3 group hover:text-[#85BBEB] transition-colors duration-300">
                            <div class="w-8 h-8 rounded-lg bg-[#85BBEB]/10 border border-[#85BBEB]/30 flex items-center justify-center group-hover:bg-[#85BBEB]/20 transition-all duration-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                            </div>
                            info@tatakata.com
                        </li>
                        <li class="flex items-center gap-3 group hover:text-[#85BBEB] transition-colors duration-300">
                            <div class="w-8 h-8 rounded-lg bg-[#85BBEB]/10 border border-[#85BBEB]/30 flex items-center justify-center group-hover:bg-[#85BBEB]/20 transition-all duration-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            Surabaya, Indonesia
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-[#85BBEB]/20 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[#C0C0C0] text-sm">&copy; {{ date('Y') }} Tata Kata. Semua hak dilindungi.</p>
                <div class="flex gap-6 text-sm text-[#C0C0C0]">
                    <a href="#" class="hover:text-[#85BBEB] transition-colors duration-300">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-[#85BBEB] transition-colors duration-300">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>
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

/* Spin Animation */
@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin-slow { animation: spin-slow 20s linear infinite; }

/* Line Expand Animation */
@keyframes line-expand {
    0% { width: 0%; }
    100% { width: 100%; }
}

.animate-line-expand { animation: line-expand 2s ease-out forwards; }

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

/* Interactive Blob */
.blob-interactive {
    will-change: transform;
    transition: transform 0.15s ease-out;
}
</style>

<script>
// Toggle mobile menu
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('mobileMenu');
    const button = event.target.closest('button[onclick="toggleMobileMenu()"]');
    
    if (!button && menu && !menu.classList.contains('hidden')) {
        if (!menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    }
});

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

    // Interactive Background with Mouse
    const blobs = document.querySelectorAll('.blob-interactive');
    
    if (blobs.length > 0) {
        document.addEventListener('mousemove', function(e) {
            const mouseX = e.clientX;
            const mouseY = e.clientY;
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
            
            blobs.forEach((blob, index) => {
                const speed = (index + 1) * 20;
                const moveX = ((mouseX / windowWidth) - 0.5) * speed;
                const moveY = ((mouseY / windowHeight) - 0.5) * speed;
                
                blob.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });
    }
});
</script>

@endsection