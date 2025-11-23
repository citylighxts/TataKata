@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A2E] relative overflow-hidden flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    {{-- Animated Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-[#0A0A2E] via-[#1a1a40] to-[#0A0A2E] animate-gradient-shift"></div>
    
    {{-- Grid Pattern Overlay --}}
    <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(#85BBEB 1px, transparent 1px), linear-gradient(90deg, #85BBEB 1px, transparent 1px); background-size: 50px 50px;"></div>
    
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 -left-4 w-96 h-96 bg-[#85bbeb28] rounded-full mix-blend-screen filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute top-0 -right-4 w-96 h-96 bg-[#FEF9F0] rounded-full mix-blend-screen filter blur-3xl opacity-15 animate-float-delayed"></div>
        <div class="absolute -bottom-8 left-20 w-96 h-96 bg-[#85bbeb2f] rounded-full mix-blend-screen filter blur-3xl opacity-10 animate-float-slow"></div>
    </div>

    {{-- Confirm Password Card --}}
    <div class="relative z-10 w-full max-w-md fade-in-up">
        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/30 via-[#FEF9F0]/20 to-[#85BBEB]/30 rounded-3xl blur-2xl opacity-60 animate-pulse-slow"></div>
        <div class="absolute -inset-1 bg-gradient-to-r from-[#85BBEB] via-[#FEF9F0] to-[#85BBEB] rounded-3xl opacity-20 blur"></div>
        
        <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#85BBEB]/10 backdrop-blur-xl rounded-3xl p-8 sm:p-10 border border-[#85BBEB]/30 shadow-2xl">
            
            {{-- Logo & Brand --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-3 group mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-xl blur-lg opacity-50 group-hover:opacity-100 transition-all duration-300 animate-pulse-subtle"></div>
                        <img src="{{ asset('images/logofix.png') }}" alt="Logo" class="relative w-12 h-12 rounded-xl transform group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-[#FEF9F0] via-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent animate-gradient-text">TataTAku</span>
                </div>

                {{-- Lock Icon --}}
                <div class="relative inline-flex items-center justify-center mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-2xl blur-md opacity-50 animate-pulse-subtle"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-2xl flex items-center justify-center shadow-2xl shadow-[#85BBEB]/50">
                        <svg class="w-10 h-10 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>

                <h2 class="text-3xl font-bold text-[#FFFFFF] mb-3">
                    Konfirmasi <span class="bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent">Password</span>
                </h2>
            </div>

            {{-- Information Text --}}
            <div class="relative mb-6 p-4 bg-[#85BBEB]/10 border border-[#85BBEB]/30 rounded-xl">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-[#85BBEB]/20 rounded-full flex items-center justify-center mt-0.5">
                        <svg class="w-4 h-4 text-[#85BBEB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-[#C0C0C0] leading-relaxed">
                        Ini adalah area aman dari aplikasi. Silakan konfirmasi kata sandi Anda sebelum melanjutkan.
                    </p>
                </div>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                {{-- Password Input --}}
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-[#FEF9F0]">
                        Password
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/20 to-[#FEF9F0]/20 rounded-xl blur opacity-0 group-focus-within:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-[#85BBEB]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <input 
                                type="password" 
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="relative w-full pl-12 pr-4 py-3.5 bg-[#0A0A2E]/50 border-2 border-[#85BBEB]/30 rounded-xl text-[#FEF9F0] placeholder-[#C0C0C0]/50 focus:border-[#85BBEB] focus:outline-none focus:ring-2 focus:ring-[#85BBEB]/20 transition-all duration-300 backdrop-blur-sm"
                                placeholder="Masukkan password Anda"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword()"
                                class="absolute right-4 text-[#85BBEB] hover:text-[#FEF9F0] transition-colors duration-300"
                            >
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Error Messages --}}
                    @error('password')
                        <div class="relative fade-in-up">
                            <div class="absolute inset-0 bg-red-500/20 rounded-lg blur"></div>
                            <div class="relative p-3 bg-red-500/10 border border-red-500/30 rounded-lg flex items-start gap-2">
                                <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm text-red-400">{{ $message }}</span>
                            </div>
                        </div>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full group px-6 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-semibold relative overflow-hidden">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Konfirmasi
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </button>
            </form>

            {{-- Helper Text --}}
            <div class="mt-6 pt-6 border-t border-[#85BBEB]/20">
                <p class="text-xs text-[#C0C0C0] text-center leading-relaxed">
                    Lupa password Anda? 
                    <a href="{{ route('password.request') }}" class="text-[#85BBEB] hover:text-[#FEF9F0] transition-colors duration-300 font-medium">
                        Reset di sini
                    </a>
                </p>
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

.animate-pulse-subtle {
    animation: pulse-subtle 2s ease-in-out infinite;
}

/* Fade In Animation */
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
    animation: fadeInUp 0.8s ease-out forwards;
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeOffIcon = document.getElementById('eye-off-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeOffIcon.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeOffIcon.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Focus animation
    const passwordInput = document.getElementById('password');
    
    passwordInput.addEventListener('focus', function() {
        this.parentElement.parentElement.classList.add('focused');
    });
    
    passwordInput.addEventListener('blur', function() {
        this.parentElement.parentElement.classList.remove('focused');
    });
});
</script>
@endsection