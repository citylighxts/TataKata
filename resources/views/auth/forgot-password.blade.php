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
                    <div class="absolute inset-0 bg-[#85BBEB] rounded-2xl blur-xl opacity-50 animate-pulse-subtle"></div>
                    <div class="relative w-16 h-16 bg-gradient-to-br from-[#85BBEB] to-[#85BBEB]/70 rounded-2xl flex items-center justify-center shadow-2xl shadow-[#85BBEB]/50">
                        <svg class="w-8 h-8 text-[#0A0A2E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-[#FFFFFF] mb-2">
                Lupa Kata Sandi
            </h2>
            <p class="text-center text-[#C0C0C0] mb-8">
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
                    <label for="email" class="block text-sm font-medium text-[#85BBEB] mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-[#85BBEB]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            class="w-full pl-12 pr-4 py-3 rounded-xl bg-[#0A0A2E]/50 border-2 border-[#85BBEB]/30 text-[#FFFFFF] placeholder-[#C0C0C0]/50 focus:border-[#85BBEB] focus:ring-2 focus:ring-[#85BBEB]/20 outline-none transition-all duration-300 backdrop-blur-sm @error('email') border-red-500/50 focus:border-red-500 focus:ring-red-500/20 @enderror"
                        />
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
                    class="w-full group relative px-8 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-base overflow-hidden"
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
                    <div class="w-full border-t border-[#85BBEB]/20"></div>
                </div>
            </div>

            {{-- Link Back --}}
            <div class="text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-[#C0C0C0] hover:text-[#85BBEB] transition-all duration-300 font-medium group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke <span class="text-[#85BBEB]">Masuk</span></span>
                </a>
            </div>
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