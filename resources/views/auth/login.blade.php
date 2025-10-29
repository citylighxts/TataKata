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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-xl blur-lg opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                        <img src="{{ asset('images/ikon-logo.png') }}" alt="Logo" class="relative w-12 h-12 rounded-xl transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-[#FEF9F0] via-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent animate-gradient-text">Tata Kata</span>
                </a>
                <div class="flex gap-3">
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-medium relative overflow-hidden group">
                        <span class="relative z-10 font-semibold">Daftar</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Login Section --}}
    <section class="relative z-10 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12 min-h-[calc(100vh-88px)]">
        <div class="w-full max-w-6xl">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                
                {{-- Left Content - Info Section --}}
                <div class="hidden lg:block space-y-6 fade-in-up">
                    <div class="space-y-4">
                        <div class="inline-block relative">
                            <div class="absolute inset-0 bg-[#85BBEB]/20 blur-xl rounded-full"></div>
                            <span class="relative px-5 py-2.5 bg-gradient-to-r from-[#85BBEB]/30 via-[#85BBEB]/20 to-transparent backdrop-blur-md border border-[#85BBEB]/40 rounded-full text-[#85BBEB] text-sm font-medium shadow-lg shadow-[#85BBEB]/10 flex items-center gap-2 w-fit">
                                <span class="animate-pulse">👋</span>
                                <span>Selamat Datang Kembali</span>
                            </span>
                        </div>
                        
                        <h1 class="text-4xl lg:text-5xl font-black text-[#FFFFFF] leading-tight">
                            <span class="inline-block">Masuk ke</span><br>
                            <span class="relative inline-block">
                                <span class="absolute inset-0 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] blur-2xl opacity-20"></span>
                                <span class="relative bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] bg-clip-text text-transparent animate-gradient-text bg-[length:200%_auto]">Akun Anda</span>
                            </span>
                        </h1>
                        
                        <p class="text-lg text-[#C0C0C0] leading-relaxed relative pl-4">
                            <span class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-[#85BBEB] to-transparent rounded-full"></span>
                            Lanjutkan perjalanan menyempurnakan tulisan Anda dengan teknologi AI terdepan.
                        </p>
                    </div>

                    {{-- Stats Cards --}}
                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="group relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-xl blur opacity-0 group-hover:opacity-60 transition-all duration-300"></div>
                            <div class="relative bg-gradient-to-br from-[#85BBEB]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-xl p-5 border border-[#85BBEB]/30 group-hover:border-[#85BBEB]/50 transition-all duration-300">
                                <div class="text-3xl font-bold text-[#85BBEB] mb-1">100%</div>
                                <div class="text-sm text-[#C0C0C0]">Gratis</div>
                            </div>
                        </div>
                        
                        <div class="group relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-[#FEF9F0]/20 to-transparent rounded-xl blur opacity-0 group-hover:opacity-60 transition-all duration-300"></div>
                            <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-xl p-5 border border-[#85BBEB]/30 group-hover:border-[#FEF9F0]/50 transition-all duration-300">
                                <div class="text-3xl font-bold text-[#FEF9F0] mb-1">AI</div>
                                <div class="text-sm text-[#C0C0C0]">Powered</div>
                            </div>
                        </div>
                    </div>

                    {{-- Decorative Image --}}
                    <div class="relative mt-8 flex justify-center">
                        <div class="absolute inset-0 bg-[#85BBEB]/20 rounded-full blur-3xl"></div>
                        <img src="{{ asset('images/logo-tatakata.png') }}" alt="Logo" class="relative w-64 h-64 object-contain opacity-30 animate-spin-slow">
                    </div>
                </div>

                {{-- Right Content - Login Form --}}
                <div class="relative fade-in-up" style="animation-delay: 0.2s;">
                    {{-- Mobile Logo --}}
                    <div class="lg:hidden text-center mb-6">
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] bg-clip-text text-transparent animate-gradient-text bg-[length:200%_auto]">
                            Tata Kata
                        </h1>
                        <p class="text-[#C0C0C0] mt-2">Masuk ke akun Anda</p>
                    </div>

                    {{-- Form Card --}}
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/30 via-[#FEF9F0]/20 to-[#85BBEB]/30 rounded-3xl blur-2xl opacity-60 group-hover:opacity-80 transition-opacity duration-500"></div>
                        <div class="absolute -inset-1 bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] rounded-3xl opacity-20 blur"></div>
                        
                        <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#85BBEB]/10 backdrop-blur-xl rounded-3xl p-8 sm:p-10 border border-[#85BBEB]/30 shadow-2xl">
                            <div class="text-center mb-8">
                                <h2 class="text-2xl sm:text-3xl font-bold text-[#FFFFFF] mb-2">Selamat Datang</h2>
                                <p class="text-[#C0C0C0]">Masuk untuk melanjutkan</p>
                            </div>

                            {{-- Status Messages --}}
                            @if (session('status'))
                                <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/30 backdrop-blur-sm">
                                    <p class="text-green-300 text-sm flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ session('status') }}
                                    </p>
                                </div>
                            @endif

                            {{-- Error Messages --}}
                            @if ($errors->any())
                                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 backdrop-blur-sm">
                                    <ul class="space-y-2">
                                        @foreach ($errors->all() as $error)
                                            <li class="flex items-start gap-2 text-red-300 text-sm">
                                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                <span>{{ $error }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Login Form --}}
                            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                                @csrf

                                {{-- Email --}}
                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-semibold text-[#FEF9F0]">
                                        Alamat Email
                                    </label>
                                    <div class="relative group">
                                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                            class="w-full px-4 py-3 rounded-xl bg-[#0A0A2E]/50 border border-[#85BBEB]/30 text-[#FEF9F0] placeholder-[#C0C0C0] focus:border-[#85BBEB] focus:ring-2 focus:ring-[#85BBEB]/50 outline-none transition-all duration-300 backdrop-blur-sm"
                                            placeholder="nama@email.com">
                                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/5 to-[#85BBEB]/0 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-semibold text-[#FEF9F0]">
                                        Kata Sandi
                                    </label>
                                    <div class="relative group">
                                        <input id="password" type="password" name="password" required
                                            class="w-full px-4 py-3 rounded-xl bg-[#0A0A2E]/50 border border-[#85BBEB]/30 text-[#FEF9F0] placeholder-[#C0C0C0] focus:border-[#85BBEB] focus:ring-2 focus:ring-[#85BBEB]/50 outline-none transition-all duration-300 backdrop-blur-sm"
                                            placeholder="••••••••">
                                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/5 to-[#85BBEB]/0 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                    </div>
                                </div>

                                {{-- Remember Me & Forgot Password --}}
                                <div class="flex items-center justify-between">
                                    <label class="flex items-center gap-2 cursor-pointer group">
                                        <input type="checkbox" name="remember" id="remember_me"
                                            class="w-4 h-4 rounded border-[#85BBEB]/30 bg-[#0A0A2E]/50 text-[#85BBEB] focus:ring-[#85BBEB] focus:ring-offset-0 transition-all">
                                        <span class="text-sm text-[#C0C0C0] group-hover:text-[#FEF9F0] transition-colors">Ingat saya</span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-sm text-[#85BBEB] hover:text-[#FEF9F0] transition-colors duration-300">
                                            Lupa kata sandi?
                                        </a>
                                    @endif
                                </div>

                                {{-- Submit Button --}}
                                <div class="pt-2">
                                    <button type="submit"
                                        class="w-full group px-8 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 transition-all duration-300 font-bold flex items-center justify-center gap-2 relative overflow-hidden">
                                        <span class="relative z-10 flex items-center gap-2">
                                            Masuk
                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </span>
                                        <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                                    </button>
                                </div>
                            </form>

                            {{-- Divider --}}
                            <div class="relative my-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-[#85BBEB]/20"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-[#0A0A2E]/50 text-[#C0C0C0] backdrop-blur-sm">atau</span>
                                </div>
                            </div>

                            {{-- Register Link --}}
                            <div class="text-center">
                                <p class="text-[#C0C0C0]">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}" class="text-[#85BBEB] hover:text-[#FEF9F0] font-semibold transition-colors duration-300 hover:underline">
                                        Daftar sekarang
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

/* Spin Animation */
@keyframes spin-slow {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.animate-spin-slow {
    animation: spin-slow 20s linear infinite;
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