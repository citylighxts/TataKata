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
                <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-xl blur-lg opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                        <img src="{{ asset('images/ikon-logo.png') }}" alt="Logo" class="relative w-12 h-12 rounded-xl transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                </a>

                {{-- Tata Kata - Centered --}}
                <div class="absolute left-1/2 transform -translate-x-1/2">
                    <span class="text-2xl font-bold gradient-text-navbar animate-gradient-text bg-[length:200%_auto] whitespace-nowrap">Tata Kata</span>
                </div>

                {{-- Desktop Actions --}}
                <div class="hidden md:flex gap-3 items-center">
                    {{-- Theme Toggle Button --}}
                    <button onclick="toggleTheme()" class="w-10 h-10 rounded-full border-2 transition-all duration-300 flex items-center justify-center group relative overflow-hidden" id="themeToggle">
                        <svg class="w-5 h-5 transition-all duration-300" id="themeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    <a href="{{ route('login') }}" class="px-6 py-2.5 border-2 rounded-full transition-all duration-300 font-medium backdrop-blur-sm relative overflow-hidden group theme-btn-secondary">
                        <span class="relative z-10">Masuk</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <button class="md:hidden w-10 h-10 flex items-center justify-center rounded-full transition-all duration-300 theme-btn-mobile" onclick="toggleMobileMenu()">
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
                <a href="{{ route('login') }}" class="block w-full px-6 py-3 border-2 rounded-full transition-all duration-300 font-medium text-center theme-btn-secondary">
                    Masuk
                </a>
            </div>
        </div>
    </header>

    {{-- Forgot Password Section --}}
    <section class="relative z-10 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12 min-h-[calc(100vh-88px)]">
        <div class="w-full max-w-md">
            {{-- Main Content Card --}}
            <div class="relative group fade-in-up">
                <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/30 via-[#FEF9F0]/20 to-[#85BBEB]/30 rounded-3xl blur-2xl opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
                <div class="absolute -inset-1 bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] rounded-3xl opacity-20 blur"></div>
                
                <div class="relative backdrop-blur-xl rounded-3xl p-8 sm:p-10 md:p-12 border shadow-2xl transition-all duration-500 theme-card-inner">
                    
                    {{-- Logo/Icon --}}
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div class="absolute inset-0 bg-[#85BBEB] rounded-2xl blur-xl opacity-50 animate-pulse-subtle"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-[#85BBEB] to-[#85BBEB]/70 rounded-2xl flex items-center justify-center shadow-2xl shadow-[#85BBEB]/50">
                                <svg class="w-8 h-8 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Title --}}
                    <h2 class="text-2xl sm:text-3xl font-bold text-center mb-2 transition-colors duration-500 theme-title">
                        Lupa Kata Sandi
                    </h2>
                    <p class="text-center mb-8 transition-colors duration-500 theme-subtitle">
                        Masukkan email Anda untuk menerima kode reset
                    </p>

                    {{-- Session Status (Success Message) --}}
                    @if (session('status'))
                        <div class="mb-6 relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-500/20 to-transparent rounded-xl blur"></div>
                            <div class="relative p-4 bg-green-500/10 border-2 border-green-500/40 text-green-400 rounded-xl text-sm font-medium backdrop-blur-sm">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ session('status') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                        @csrf

                        {{-- Email Input --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold mb-2 transition-colors duration-500 theme-label-input">
                                Email
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 transition-colors duration-500 theme-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    value="{{ old('email') }}"
                                    required 
                                    autofocus
                                    placeholder="nama@email.com"
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border-2 outline-none transition-all duration-300 backdrop-blur-sm theme-input @error('email') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                />
                                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/5 to-[#85BBEB]/0 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                            </div>
                            
                            @error('email')
                                <p class="mt-2 text-sm text-red-400 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <button 
                            type="submit"
                            class="w-full group relative px-8 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 transition-all duration-300 font-bold text-base overflow-hidden"
                        >
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Kirim Kode Reset
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t transition-colors duration-500 theme-divider"></div>
                        </div>
                    </div>

                    {{-- Link Back --}}
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 transition-all duration-300 font-medium group back-link">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span class="transition-colors duration-500 theme-subtitle">Kembali ke <span class="text-[#85BBEB] back-link-highlight">Masuk</span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

.theme-mobile-menu {
    background-color: rgba(10, 10, 46, 0.95);
}

.theme-title {
    color: #FFFFFF;
}

.theme-subtitle {
    color: #C0C0C0;
}

.theme-label-input {
    color: #85BBEB;
}

.theme-icon {
    color: rgba(133, 187, 235, 0.5);
}

.theme-card-inner {
    background: linear-gradient(to bottom right, rgba(254, 249, 240, 0.1), rgba(10, 10, 46, 0.5), rgba(133, 187, 235, 0.1));
    border-color: rgba(133, 187, 235, 0.3);
}

.theme-input {
    background-color: rgba(10, 10, 46, 0.5);
    border-color: rgba(133, 187, 235, 0.3);
    color: #FFFFFF;
}

.theme-input::placeholder {
    color: rgba(192, 192, 192, 0.5);
}

.theme-input:focus {
    border-color: #85BBEB;
    ring: 2px;
    ring-color: rgba(133, 187, 235, 0.2);
}

.theme-divider {
    border-color: rgba(133, 187, 235, 0.2);
}

/* Dark mode back link */
.back-link {
    color: #C0C0C0;
}

.back-link:hover {
    color: #85BBEB;
}

.back-link:hover .back-link-highlight {
    color: #FEF9F0;
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

/* Light Mode */
body.light-mode #gradientBg {
    background-image: linear-gradient(to bottom right, #FAFBFC, #F0F4F8, #E8EEF5);
}

body.light-mode #gridPattern {
    background-image: linear-gradient(#4A5568 1px, transparent 1px), linear-gradient(90deg, #4A5568 1px, transparent 1px);
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

body.light-mode .theme-mobile-menu {
    background-color: rgba(255, 255, 255, 0.95);
}

body.light-mode .theme-title {
    color: #1A202C;
}

body.light-mode .theme-subtitle {
    color: #4A5568;
}

body.light-mode .theme-label-input {
    color: #2C5282;
}

body.light-mode .theme-icon {
    color: rgba(44, 82, 130, 0.5);
}

body.light-mode .theme-card-inner {
    background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.98), rgba(250, 251, 252, 0.95), rgba(245, 247, 250, 0.98));
    border-color: rgba(133, 187, 235, 0.25);
    box-shadow: 0 4px 12px rgba(133, 187, 235, 0.1), 0 2px 4px rgba(0, 0, 0, 0.03);
}

body.light-mode .theme-input {
    background-color: rgba(255, 255, 255, 0.9);
    border-color: rgba(133, 187, 235, 0.25);
    color: #1A202C;
}

body.light-mode .theme-input::placeholder {
    color: #718096;
}

body.light-mode .theme-input:focus {
    border-color: #85BBEB;
    background-color: #FFFFFF;
}

body.light-mode .theme-divider {
    border-color: rgba(133, 187, 235, 0.15);
}

/* Light mode back link */
body.light-mode .back-link {
    color: #4A5568;
}

body.light-mode .back-link:hover {
    color: #2C5282;
}

body.light-mode .back-link:hover .back-link-highlight {
    color: #2C5282;
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
    0%, 100% {
        opacity: 0.5;
    }
    50% {
        opacity: 0.8;
    }
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