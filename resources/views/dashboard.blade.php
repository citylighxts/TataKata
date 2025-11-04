@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A2E] relative overflow-hidden">
    
    {{-- Animated Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-[#0A0A2E] via-[#1a1a40] to-[#0A0A2E] animate-gradient-shift"></div>
    
    {{-- Grid Pattern Overlay --}}
    <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(#85BBEB 1px, transparent 1px), linear-gradient(90deg, #85BBEB 1px, transparent 1px); background-size: 50px 50px;"></div>
    
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="blob-interactive absolute top-0 -left-4 w-96 h-96 bg-[#85bbeb28] rounded-full mix-blend-screen filter blur-3xl opacity-20 animate-float"></div>
        <div class="blob-interactive absolute top-0 -right-4 w-96 h-96 bg-[#FEF9F0] rounded-full mix-blend-screen filter blur-3xl opacity-15 animate-float-delayed"></div>
        <div class="blob-interactive absolute -bottom-8 left-20 w-96 h-96 bg-[#85bbeb2f] rounded-full mix-blend-screen filter blur-3xl opacity-10 animate-float-slow"></div>
        <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-[#C0C0C0] rounded-full mix-blend-screen filter blur-2xl opacity-10 animate-pulse-slow"></div>
        <div class="absolute bottom-1/4 left-1/3 w-72 h-72 bg-[#85BBEB] rounded-full mix-blend-screen filter blur-3xl opacity-15 animate-pulse-slower"></div>
    </div>

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

    {{-- Main Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Page Title --}}
        <div class="mb-12 fade-in-up">
            <h1 class="text-4xl lg:text-5xl font-bold text-[#FFFFFF] mb-3">
                Selamat datang di
            </h1>
            <h2 class="text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] bg-clip-text text-transparent animate-gradient-text bg-[length:200%_auto]">
                Tata Kata.
            </h2>
            <p class="text-[#C0C0C0] text-lg mt-4">
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
                    <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-3xl p-10 border border-[#85BBEB]/30 hover:border-[#85BBEB]/60 transition-all duration-500 h-full group-hover:translate-y-[-8px] shadow-xl hover:shadow-2xl hover:shadow-[#85BBEB]/30">
                        
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
                                <h3 class="text-2xl font-bold text-[#FFFFFF] mb-2 group-hover:text-[#85BBEB] transition-colors duration-300">
                                    Unggah Dokumen
                                </h3>
                                <p class="text-[#C0C0C0] leading-relaxed">
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
                    <div class="absolute inset-0 bg-gradient-to-br from-[#FEF9F0]/30 to-transparent rounded-3xl blur-2xl opacity-0 group-hover:opacity-60 transition-all duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-[#FEF9F0] to-[#85BBEB] rounded-3xl opacity-0 group-hover:opacity-20 blur transition-all duration-500"></div>
                    <div class="relative bg-gradient-to-br from-[#85BBEB]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-3xl p-10 border border-[#85BBEB]/30 hover:border-[#85BBEB]/60 transition-all duration-500 h-full group-hover:translate-y-[-8px] shadow-xl hover:shadow-2xl hover:shadow-[#FEF9F0]/20">
                        
                        <div class="flex flex-col items-center text-center space-y-6">
                            {{-- Icon --}}
                            <div class="relative">
                                <div class="absolute inset-0 bg-[#FEF9F0] rounded-2xl blur-xl opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                                <div class="relative w-20 h-20 bg-gradient-to-br from-[#FEF9F0] to-[#85BBEB] rounded-2xl flex items-center justify-center shadow-2xl shadow-[#FEF9F0]/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                    <img src="{{ asset('images/ikonriwayat.png') }}" alt="Ikon Riwayat" class="w-10 h-10">
                                </div>
                            </div>

                            {{-- Title --}}
                            <div>
                                <h3 class="text-2xl font-bold text-[#FFFFFF] mb-2 group-hover:text-[#FEF9F0] transition-colors duration-300">
                                    Riwayat
                                </h3>
                                <p class="text-[#C0C0C0] leading-relaxed">
                                    Lihat semua dokumen yang telah Anda unggah dan proses sebelumnya
                                </p>
                            </div>

                            {{-- Arrow Indicator --}}
                            <div class="flex items-center gap-2 text-[#FEF9F0] font-medium pt-2">
                                <span>Lihat Riwayat</span>
                                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Bottom Border Effect --}}
                        <div class="mt-6 h-1 w-0 group-hover:w-full bg-gradient-to-r from-[#FEF9F0] to-transparent transition-all duration-500 rounded-full"></div>
                    </div>
                </div>
            </a>

        </div>

        {{-- Info Section --}}
        <div class="mt-16 fade-in-up" style="animation-delay: 0.3s;">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/20 via-[#FEF9F0]/10 to-[#85BBEB]/20 rounded-3xl blur-2xl"></div>
                <div class="relative bg-gradient-to-br from-[#FEF9F0]/5 via-[#0A0A2E]/50 to-[#85BBEB]/5 backdrop-blur-xl rounded-3xl p-8 border border-[#85BBEB]/20">
                    <div class="grid md:grid-cols-3 gap-6 text-center">
                        <div class="space-y-2">
                            <div class="text-3xl font-bold bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent">
                                100%
                            </div>
                            <div class="text-[#C0C0C0]">Gratis</div>
                        </div>
                        <div class="space-y-2">
                            <div class="text-3xl font-bold bg-gradient-to-r from-[#FEF9F0] to-[#85BBEB] bg-clip-text text-transparent">
                                AI
                            </div>
                            <div class="text-[#C0C0C0]">Powered</div>
                        </div>
                        <div class="space-y-2">
                            <div class="text-3xl font-bold bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent">
                                Aman
                            </div>
                            <div class="text-[#C0C0C0]">& Privat</div>
                        </div>
                    </div>
                </div>
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

/* Interactive Blob */
.blob-interactive {
    will-change: transform;
    transition: transform 0.15s ease-out;
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