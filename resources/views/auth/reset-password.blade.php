@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A2E] relative overflow-hidden flex items-center justify-center p-4 sm:p-6 lg:p-8">
    
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
    </div>

    {{-- Main Content Card --}}
    <div class="w-full max-w-md relative z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-3xl blur-2xl opacity-60"></div>
        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-3xl opacity-20 blur"></div>
        
        <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-[#85BBEB]/30 p-8 sm:p-10 md:p-12">
            
            {{-- Logo/Icon --}}
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <div class="absolute inset-0 bg-[#FEF9F0] rounded-2xl blur-xl opacity-50 animate-pulse-subtle"></div>
                    <div class="relative w-16 h-16 bg-gradient-to-br from-[#FEF9F0] to-[#85BBEB] rounded-2xl flex items-center justify-center shadow-2xl shadow-[#FEF9F0]/30">
                        <svg class="w-8 h-8 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-[#FFFFFF] mb-2">
                Konfirmasi Kata Sandi
            </h2>
            
            {{-- Info Text --}}
            <div class="mb-8 relative">
                <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/10 to-transparent rounded-xl blur"></div>
                <div class="relative p-4 bg-[#85BBEB]/5 border border-[#85BBEB]/20 rounded-xl backdrop-blur-sm">
                    <p class="text-[#C0C0C0] text-sm leading-relaxed flex items-start gap-3">
                        <svg class="w-5 h-5 text-[#85BBEB] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Ini adalah area aman dari aplikasi. Harap konfirmasi kata sandi Anda sebelum melanjutkan.</span>
                    </p>
                </div>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                {{-- Password Input --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-[#85BBEB] mb-2">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-[#85BBEB]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            required 
                            autocomplete="current-password"
                            placeholder="Masukkan kata sandi Anda"
                            class="w-full pl-12 pr-4 py-3 rounded-xl bg-[#0A0A2E]/50 border-2 border-[#85BBEB]/30 text-[#FFFFFF] placeholder-[#C0C0C0]/50 focus:border-[#85BBEB] focus:ring-2 focus:ring-[#85BBEB]/20 outline-none transition-all duration-300 backdrop-blur-sm @error('password') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror"
                        />
                    </div>
                    
                    @error('password')
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
                    class="w-full group relative px-8 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-base overflow-hidden"
                >
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Konfirmasi
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                </button>
            </form>
        </div>
    </div>
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
    0%, 100% { opacity: 0.5; }
    50% { opacity: 0.8; }
}

.animate-pulse-slow { animation: pulse-slow 4s ease-in-out infinite; }
.animate-pulse-subtle { animation: pulse-subtle 2s ease-in-out infinite; }

/* Interactive Blob */
.blob-interactive {
    will-change: transform;
    transition: transform 0.15s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
@endsecti