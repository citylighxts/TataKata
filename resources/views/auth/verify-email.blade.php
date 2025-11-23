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

    {{-- Verification Card --}}
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

                {{-- Email Icon --}}
                <div class="relative inline-flex items-center justify-center mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-2xl blur-md opacity-50 animate-pulse-subtle"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-br from-[#85BBEB] to-[#FEF9F0] rounded-2xl flex items-center justify-center shadow-2xl shadow-[#85BBEB]/50">
                        <svg class="w-10 h-10 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>

                <h2 class="text-3xl font-bold text-[#FFFFFF] mb-3">
                    Verifikasi <span class="bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] bg-clip-text text-transparent">Email</span>
                </h2>
            </div>

            {{-- Information Text --}}
            <div class="relative mb-6 p-4 bg-[#85BBEB]/10 border border-[#85BBEB]/30 rounded-xl">
                <p class="text-sm text-[#C0C0C0] leading-relaxed text-center">
                    Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkannya lagi.
                </p>
            </div>

            {{-- Success Message --}}
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 relative fade-in-up">
                    <div class="absolute inset-0 bg-green-500/20 rounded-xl blur"></div>
                    <div class="relative p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-green-500/20 rounded-full flex items-center justify-center mt-0.5">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-sm text-green-400 leading-relaxed">
                            Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                        </p>
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="space-y-4">
                {{-- Resend Button --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full group px-6 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-semibold relative overflow-hidden">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Kirim Ulang Email Verifikasi
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </button>
                </form>

                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-6 py-4 backdrop-blur-md bg-[#FEF9F0]/10 border-2 border-[#85BBEB]/30 text-[#FEF9F0] rounded-full hover:bg-[#FEF9F0]/20 hover:border-[#85BBEB]/50 hover:shadow-lg hover:shadow-[#85BBEB]/20 transition-all duration-300 font-semibold relative overflow-hidden group">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Keluar
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </button>
                </form>
            </div>

            {{-- Helper Text --}}
            <div class="mt-6 pt-6 border-t border-[#85BBEB]/20">
                <p class="text-xs text-[#C0C0C0] text-center leading-relaxed">
                    Mengalami masalah? 
                    <a href="mailto:support@tatataku.com" class="text-[#85BBEB] hover:text-[#FEF9F0] transition-colors duration-300 font-medium">
                        Hubungi dukungan kami
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
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success message after 5 seconds
    const successMessage = document.querySelector('.fade-in-up');
    if (successMessage && successMessage.textContent.includes('Tautan verifikasi baru')) {
        setTimeout(() => {
            successMessage.style.transition = 'opacity 0.5s ease-out';
            successMessage.style.opacity = '0';
            setTimeout(() => {
                successMessage.remove();
            }, 500);
        }, 5000);
    }
});
</script>
@endsection