@extends('layouts.app')

@section('content')
<div class="min-h-screen transition-colors duration-500" id="mainContainer">
    
    {{-- Animated Gradient Background --}}
    <div class="fixed inset-0 bg-gradient-to-br transition-colors duration-500" id="gradientBg"></div>
    
    {{-- Grid Pattern Overlay --}}
    <div class="fixed inset-0 opacity-5 transition-opacity duration-500" id="gridPattern"></div>

    {{-- Navbar --}}
    <header class="relative z-50 backdrop-blur-xl border-b shadow-lg transition-colors duration-500" id="navbar">
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
                    <span class="text-lg sm:text-xl md:text-2xl font-bold gradient-text-navbar animate-gradient-text whitespace-nowrap bg-[length:200%_auto]">
                        Tata Kata
                    </span>
                </div>

                {{-- Desktop Actions --}}
                <div class="hidden md:flex gap-3 items-center flex-shrink-0">
                    {{-- Theme Toggle Button --}}
                    <button onclick="toggleTheme()" class="w-10 h-10 rounded-full border-2 transition-all duration-300 flex items-center justify-center group relative overflow-hidden" id="themeToggle">
                        <svg class="w-5 h-5 transition-all duration-300" id="themeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    {{-- Profil --}}
                    <div class="relative flex items-center group cursor-pointer">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] flex items-center justify-center shadow-lg shadow-[#85BBEB]/30 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-6 h-6 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="absolute top-full right-0 mt-2 px-4 py-2 border text-sm rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 backdrop-blur-xl theme-tooltip">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Profil' }}
                            <div class="absolute -top-1 right-3 w-2 h-2 border-l border-t transform rotate-45 theme-tooltip-arrow"></div>
                        </div>
                    </div>

                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="relative group">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-full border flex items-center justify-center transition-all duration-300 group theme-btn-logout">
                            <svg class="w-6 h-6 text-[#85BBEB] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                            </svg>
                        </button>
                        <div class="absolute top-full right-0 mt-2 px-4 py-2 border text-sm rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50 backdrop-blur-xl theme-tooltip">
                            Keluar
                            <div class="absolute -top-1 right-3 w-2 h-2 border-l border-t transform rotate-45 theme-tooltip-arrow"></div>
                        </div>
                    </form>
                </div>

                {{-- Mobile Menu Button --}}
                <button class="md:hidden w-10 h-10 flex items-center justify-center rounded-full transition-all duration-300 flex-shrink-0 theme-btn-mobile" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6 text-[#85BBEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

            </div>
        </div>

        {{-- Mobile Menu Dropdown --}}
        <div id="mobileMenu" class="md:hidden hidden backdrop-blur-xl border-t transition-colors duration-500 theme-mobile-menu">
            <div class="px-4 py-4 space-y-3">
                {{-- Theme Toggle for Mobile --}}
                <button onclick="toggleTheme()" class="w-full px-6 py-3 border-2 rounded-full transition-all duration-300 font-medium text-center flex items-center justify-center gap-2 theme-btn-secondary">
                    <svg class="w-5 h-5" id="themeIconMobile" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <span id="themeTextMobile">Mode Terang</span>
                </button>

                {{-- Profile Info --}}
                <div class="w-full px-6 py-3 border-2 rounded-full transition-all duration-300 text-center theme-btn-secondary">
                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Profil' }}
                </div>

                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 transition-all duration-300 font-semibold text-center">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Page Title --}}
        <div class="mb-12 fade-in-up">
            <h1 class="text-4xl lg:text-5xl font-bold mb-3 transition-colors duration-500 theme-title">
                Selamat datang di
            </h1>
            <h2 class="text-4xl lg:text-5xl font-extrabold mb-4">
                <span class="gradient-text-hero animate-gradient-text bg-[length:200%_auto]">Tata Kata.</span>
            </h2>
            <p class="text-xl leading-relaxed transition-colors duration-500 theme-subtitle">
                Kelola dokumen Anda dengan mudah dan efisien
            </p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-8 fade-in-up">
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

        {{-- Action Cards --}}
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            
            {{-- Card 1: Unggah Dokumen --}}
            <a href="{{ route('upload') }}" class="group fade-in-up" style="animation-delay: 0.1s;">
                <div class="relative h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/30 to-transparent rounded-3xl blur-2xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-3xl opacity-0 group-hover:opacity-20 blur transition-all duration-500"></div>
                    <div class="relative backdrop-blur-xl rounded-3xl p-10 border transition-all duration-500 h-full group-hover:translate-y-[-8px] shadow-xl hover:shadow-2xl hover:shadow-[#85BBEB]/30 theme-card-inner">
                        
                        <div class="flex flex-col items-center text-center space-y-6">
                            {{-- Icon --}}
                            <div class="relative">
                                <div class="absolute inset-0 bg-[#85BBEB] rounded-2xl blur-xl opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                                <div class="relative w-20 h-20 bg-gradient-to-br from-[#85BBEB] to-[#85BBEB]/70 rounded-2xl flex items-center justify-center shadow-2xl shadow-[#85BBEB]/50 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                    <img src="{{ asset('images/ikonplus.png') }}" alt="Ikon Plus" class="w-10 h-10">
                                </div>
                            </div>

                            {{-- Title --}}
                            <div>
                                <h3 class="text-2xl font-bold mb-2 group-hover:text-[#85BBEB] transition-colors duration-300 theme-card-title">
                                    Unggah Dokumen
                                </h3>
                                <p class="leading-relaxed theme-card-text">
                                    Upload dokumen baru untuk dianalisis dan diperiksa tata bahasanya
                                </p>
                            </div>

                            {{-- Arrow Indicator --}}
                            <div class="flex items-center gap-2 text-[#85BBEB] font-medium pt-2">
                                <span>Mulai Sekarang</span>
                                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Bottom Border Effect --}}
                        <div class="mt-6 h-1 w-0 group-hover:w-full bg-gradient-to-r from-[#85BBEB] to-transparent transition-all duration-500 rounded-full"></div>
                    </div>
                </div>
            </a>

            {{-- Card 2: Riwayat --}}
            <a href="{{ route('history') }}" class="group fade-in-up" style="animation-delay: 0.2s;">
                <div class="relative h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/30 to-transparent rounded-3xl blur-2xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-3xl opacity-0 group-hover:opacity-20 blur transition-all duration-500"></div>
                    <div class="relative backdrop-blur-xl rounded-3xl p-10 border transition-all duration-500 h-full group-hover:translate-y-[-8px] shadow-xl hover:shadow-2xl hover:shadow-[#85BBEB]/30 theme-card-inner">
                        
                        <div class="flex flex-col items-center text-center space-y-6">
                            {{-- Icon --}}
                            <div class="relative">
                                <div class="absolute inset-0 bg-[#85BBEB] rounded-2xl blur-xl opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                                <div class="relative w-20 h-20 bg-gradient-to-br from-[#85BBEB] to-[#85BBEB]/70 rounded-2xl flex items-center justify-center shadow-2xl shadow-[#85BBEB]/50 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                    <img src="{{ asset('images/ikonriwayat.png') }}" alt="Ikon Riwayat" class="w-10 h-10">
                                </div>
                            </div>

                            {{-- Title --}}
                            <div>
                                <h3 class="text-2xl font-bold mb-2 group-hover:text-[#85BBEB] transition-colors duration-300 theme-card-title">
                                    Riwayat
                                </h3>
                                <p class="leading-relaxed theme-card-text">
                                    Lihat semua dokumen yang telah Anda unggah dan proses sebelumnya
                                </p>
                            </div>

                            {{-- Arrow Indicator --}}
                            <div class="flex items-center gap-2 text-[#85BBEB] font-medium pt-2">
                                <span>Lihat Riwayat</span>
                                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Bottom Border Effect --}}
                        <div class="mt-6 h-1 w-0 group-hover:w-full bg-gradient-to-r from-[#85BBEB] to-transparent transition-all duration-500 rounded-full"></div>
                    </div>
                </div>
            </a>

        </div>

        {{-- Info Section --}}
        <div class="mt-16 fade-in-up" style="animation-delay: 0.3s;">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/20 via-[#FEF9F0]/10 to-[#85BBEB]/20 rounded-3xl blur-2xl"></div>
                <div class="relative backdrop-blur-xl rounded-3xl p-8 border transition-colors duration-500 theme-info-card">
                    <div class="grid md:grid-cols-3 gap-6 text-center">
                        <div class="space-y-2">
                            <div class="text-3xl font-bold bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent">
                                100%
                            </div>
                            <div class="transition-colors duration-500 theme-subtitle">Gratis</div>
                        </div>
                        <div class="space-y-2">
                            <div class="text-3xl font-bold bg-gradient-to-r from-[#FEF9F0] to-[#85BBEB] bg-clip-text text-transparent">
                                AI
                            </div>
                            <div class="transition-colors duration-500 theme-subtitle">Powered</div>
                        </div>
                        <div class="space-y-2">
                            <div class="text-3xl font-bold bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent">
                                Aman
                            </div>
                            <div class="transition-colors duration-500 theme-subtitle">& Privat</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* Dark Mode (Default) */
#mainContainer {
    background-image: linear-gradient(to bottom right, #0A0A2E, #1a1a40, #0A0A2E);
}

#gradientBg {
    background-image: linear-gradient(to bottom right, #0A0A2E, #1a1a40, #0A0A2E);
}

#gridPattern {
    background-image: linear-gradient(#85BBEB 1px, transparent 1px), linear-gradient(90deg, #85BBEB 1px, transparent 1px);
    background-size: 50px 50px;
}

#navbar {
    background-color: rgba(10, 10, 46, 0.7);
    border-color: rgba(133, 187, 235, 0.2);
    box-shadow: 0 10px 15px -3px rgba(133, 187, 235, 0.05);
}

.theme-btn-secondary {
    border-color: rgba(133, 187, 235, 0.4);
    color: #FEF9F0;
    background-color: rgba(254, 249, 240, 0);
}

.theme-btn-secondary:hover {
    background-color: rgba(133, 187, 235, 0.2);
    border-color: rgba(133, 187, 235, 0.6);
}

.theme-btn-mobile {
    background-color: rgba(133, 187, 235, 0.1);
    border: 1px solid rgba(133, 187, 235, 0.3);
}

.theme-btn-mobile:hover {
    background-color: rgba(133, 187, 235, 0.2);
}

.theme-btn-logout {
    background-color: rgba(133, 187, 235, 0.1);
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-btn-logout:hover {
    background-color: rgba(133, 187, 235, 0.2);
    border-color: rgba(133, 187, 235, 0.5);
}

.theme-tooltip {
    background-color: #1a1a40;
    border-color: rgba(133, 187, 235, 0.3);
    color: #FEF9F0;
}

.theme-tooltip-arrow {
    background-color: #1a1a40;
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-mobile-menu {
    background-color: rgba(10, 10, 46, 0.95);
    border-color: rgba(133, 187, 235, 0.2);
}

.theme-title {
    color: #FFFFFF;
}

.theme-subtitle {
    color: #C0C0C0;
}

.theme-card-inner {
    background: linear-gradient(to bottom right, rgba(254, 249, 240, 0.1), rgba(10, 10, 46, 0.5), rgba(10, 10, 46, 0.8));
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-card-inner:hover {
    border-color: rgba(133, 187, 235, 0.6);
}

.theme-card-title {
    color: #FFFFFF;
}

.theme-card-text {
    color: #C0C0C0;
}

.theme-info-card {
    background: linear-gradient(to bottom right, rgba(254, 249, 240, 0.05), rgba(10, 10, 46, 0.5), rgba(133, 187, 235, 0.05));
    border-color: rgba(133, 187, 235, 0.2);
}

#themeToggle {
    border-color: rgba(133, 187, 235, 0.4);
    color: #85BBEB;
    background-color: rgba(133, 187, 235, 0.1);
}

#themeToggle:hover {
    background-color: rgba(133, 187, 235, 0.2);
    border-color: rgba(133, 187, 235, 0.6);
}

/* Dynamic gradient text colors - DARK MODE */
.gradient-text-navbar {
    background: linear-gradient(to right, #FFFFFF, #85BBEB, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.gradient-text-hero {
    background: linear-gradient(to right, #85BBEB, #FFFFFF, #85BBEB);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Light Mode */
body.light-mode #gradientBg {
    background-image: linear-gradient(to bottom right, #FAFBFC, #F0F4F8, #E8EEF5);
}

body.light-mode #gridPattern {
    background-image: linear-gradient(#4A5568  1px, transparent 1px), linear-gradient(90deg, #4A5568 1px, transparent 1px);
    opacity: 0.05;
}

body.light-mode #navbar {
    background-color: rgba(255, 255, 255, 0.85);
    border-color: rgba(133, 187, 235, 0.15);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

body.light-mode .theme-btn-secondary {
    border-color: rgba(133, 187, 235, 0.3);
    color: #2D3748;
    background-color: rgba(255, 255, 255, 0.6);
}

body.light-mode .theme-btn-secondary:hover {
    background-color: rgba(133, 187, 235, 0.8);
    border-color: rgba(133, 187, 235, 0.5);
    color: #FFFFFF;
}

body.light-mode .theme-btn-mobile {
    background-color: rgba(133, 187, 235, 0.08);
    border-color: rgba(133, 187, 235, 0.2);
}

body.light-mode .theme-btn-mobile:hover {
    background-color: rgba(133, 187, 235, 0.15);
}

body.light-mode .theme-btn-logout {
    background-color: rgba(133, 187, 235, 0.08);
    border-color: rgba(133, 187, 235, 0.2);
}

body.light-mode .theme-btn-logout:hover {
    background-color: rgba(133, 187, 235, 0.15);
    border-color: rgba(133, 187, 235, 0.35);
}

body.light-mode .theme-tooltip {
    background-color: rgba(255, 255, 255, 0.98);
    border-color: rgba(133, 187, 235, 0.2);
    color: #2D3748;
}

body.light-mode .theme-tooltip-arrow {
    background-color: rgba(255, 255, 255, 0.98);
    border-color: rgba(133, 187, 235, 0.2);
}

body.light-mode .theme-mobile-menu {
    background-color: rgba(255, 255, 255, 0.95);
    border-color: rgba(133, 187, 235, 0.15);
}

body.light-mode .theme-title {
    color: #1A202C;
}

body.light-mode .theme-subtitle {
    color: #2D3748;
}

body.light-mode .theme-card-inner {
    background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.95), rgba(250, 251, 252, 0.9), rgba(245, 247, 250, 0.95));
    border-color: rgba(133, 187, 235, 0.2);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
}

body.light-mode .theme-card-inner:hover {
    border-color: rgba(133, 187, 235, 0.35);
    box-shadow: 0 8px 16px rgba(133, 187, 235, 0.12), 0 2px 4px rgba(0, 0, 0, 0.04);
}

body.light-mode .theme-card-title {
    color: #1A202C;
}

body.light-mode .theme-card-text {
    color: #4A5568;
}

body.light-mode .theme-info-card {
    background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.98), rgba(250, 251, 252, 0.95), rgba(245, 247, 250, 0.98));
    border-color: rgba(133, 187, 235, 0.2);
    box-shadow: 0 2px 8px rgba(133, 187, 235, 0.08), 0 1px 2px rgba(0, 0, 0, 0.02);
}

body.light-mode #themeToggle {
    border-color: rgba(245, 158, 11, 0.3);
    color: #F59E0B;
    background-color: rgba(255, 237, 213, 0.4);
}

body.light-mode #themeToggle:hover {
    background-color: rgba(255, 237, 213, 0.6);
    border-color: rgba(245, 158, 11, 0.4);
}

/* Light mode gradient text overrides */
body.light-mode .gradient-text-navbar {
    background: linear-gradient(to right, #000000, #85BBEB, #000000);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

body.light-mode .gradient-text-hero {
    background: linear-gradient(to right, #85BBEB, #000000, #85BBEB);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Animations */
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

@keyframes pulse-subtle {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 0.8; }
}

.animate-pulse-subtle { 
    animation: pulse-subtle 2s ease-in-out infinite; 
}

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
</style>

<script>
// Theme Toggle Function
function toggleTheme() {
    const body = document.body;
    const themeIcon = document.getElementById('themeIcon');
    const themeIconMobile = document.getElementById('themeIconMobile');
    const themeTextMobile = document.getElementById('themeTextMobile');
    
    body.classList.toggle('light-mode');
    
    const isLightMode = body.classList.contains('light-mode');
    
    // Update icons
    const moonPath = 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z';
    const sunPath = 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z';
    
    if (isLightMode) {
        themeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${sunPath}"/>`;
        themeIconMobile.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${sunPath}"/>`;
        themeTextMobile.textContent = 'Mode Gelap';
        localStorage.setItem('theme', 'light');
    } else {
        themeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${moonPath}"/>`;
        themeIconMobile.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${moonPath}"/>`;
        themeTextMobile.textContent = 'Mode Terang';
        localStorage.setItem('theme', 'dark');
    }
}

// Load saved theme on page load
function loadTheme() {
    const savedTheme = localStorage.getItem('theme');
    // Default is dark mode, only apply light if explicitly saved
    if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
        const themeIcon = document.getElementById('themeIcon');
        const themeIconMobile = document.getElementById('themeIconMobile');
        const themeTextMobile = document.getElementById('themeTextMobile');
        const sunPath = 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z';
        themeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${sunPath}"/>`;
        themeIconMobile.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${sunPath}"/>`;
        themeTextMobile.textContent = 'Mode Gelap';
    }
}

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
    // Load theme
    loadTheme();
    
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
</script>

@endsection