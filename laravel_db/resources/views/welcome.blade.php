@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white flex flex-col">

    {{-- Navbar --}}
    <header class="flex justify-between items-center px-8 py-6 bg-gradient-to-r from-[#4a4a6a] via-[#5a6080] to-[#6a7a9a] shadow-lg">
        <div class="text-2xl font-bold text-white">Tata Kata</div>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="px-6 py-2.5 border-2 border-white text-white rounded-full hover:bg-white hover:text-[#4a4a6a] transition-all duration-300 font-medium">Masuk</a>
            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-white text-[#4a4a6a] rounded-full hover:bg-indigo-50 transition-all duration-300 font-medium shadow-md">Daftar</a>
        </div>
    </header>

    {{-- Hero Section --}}
    <main class="flex flex-col lg:flex-row items-center justify-between flex-1 px-8 md:px-16 lg:px-24 py-12 lg:py-20 gap-12">
        
        {{-- Konten Kiri --}}
        <div class="max-w-2xl space-y-8 flex-1">
            <div class="space-y-4">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">Periksa Kata, Sempurnakan Bahasa</h2>
                <h1 class="text-6xl md:text-7xl font-extrabold text-[#4a4a6a]">Tata Kata.</h1>
            </div>
            
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed">
                Tingkatkan kualitas tulisan tugas akhir Anda dengan koreksi otomatis tata bahasa, ejaan, dan gaya penulisan menggunakan teknologi AI.
            </p>

            {{-- Fitur Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-10">
    <!-- Kartu 1 -->
    <div
        class="relative bg-gradient-to-br from-[#4a4a6a] via-[#5a6080] to-[#6a7a9a] text-white text-center p-8 rounded-3xl shadow-lg
               hover:shadow-2xl hover:from-[#5c5c80] hover:to-[#8b9ac2]
               transition-all duration-500 ease-out transform hover:-translate-y-2 hover:rotate-[1deg]
               before:absolute before:inset-0 before:rounded-3xl before:bg-gradient-to-r before:from-purple-500 before:to-pink-500 before:opacity-0 hover:before:opacity-30 before:blur-2xl before:transition-opacity">
        <p class="font-semibold text-lg relative z-10">Pemrosesan Bahasa Berbasis AI</p>
    </div>

    <!-- Kartu 2 -->
    <div
        class="relative bg-gradient-to-br from-[#4a4a6a] via-[#5a6080] to-[#6a7a9a] text-white p-8 flex items-center justify-center rounded-3xl shadow-lg
               hover:shadow-2xl hover:scale-[1.05] hover:from-[#5c5c80] hover:to-[#8b9ac2]
               transition-all duration-500 ease-out transform hover:-translate-y-2 hover:-rotate-[1deg]
               before:absolute before:inset-0 before:rounded-3xl before:bg-gradient-to-r before:from-indigo-500 before:to-purple-500 before:opacity-0 hover:before:opacity-30 before:blur-2xl before:transition-opacity">
        <p class="font-semibold text-lg relative z-10">Semua Fitur Gratis</p>
    </div>

    <!-- Kartu 3 -->
    <div
        class="relative bg-gradient-to-br from-[#4a4a6a] via-[#5a6080] to-[#6a7a9a] text-white text-center p-8 rounded-3xl shadow-lg md:col-span-2
               hover:shadow-2xl hover:scale-[1.03] hover:from-[#5c5c80] hover:to-[#8b9ac2]
               transition-all duration-500 ease-out transform hover:-translate-y-2
               before:absolute before:inset-0 before:rounded-3xl before:bg-gradient-to-r before:from-pink-500 before:to-orange-400 before:opacity-0 hover:before:opacity-30 before:blur-2xl before:transition-opacity">
        <p class="font-semibold text-lg relative z-10">Kompatibilitas Penuh</p>
    </div>
</div>

        </div>

        {{-- Ilustrasi Kanan - Lebih Besar --}}
        <div class="flex-1 flex items-center justify-center lg:justify-end">
            <div class="relative">
                {{-- Decorative background --}}
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-200 to-purple-200 rounded-full blur-3xl opacity-30 animate-pulse"></div>
                
                {{-- Gambar Logo --}}
                <img src="{{ asset('images/logo-tatakata.png') }}" 
                     alt="Logo Tata Kata" 
                     class="relative w-[450px] md:w-[550px] lg:w-[650px] drop-shadow-2xl hover:scale-105 transition-transform duration-500">
            </div>
        </div>
    </main>

    <footer class="bg-gradient-to-r from-[#4a4a6a] via-[#5a6080] to-[#6a7a9a] text-white text-center py-4">
        <p class="text-sm">
            &copy; {{ date('Y') }} <span class="font-semibold">TataKata</span>. Semua hak cipta dilindungi.
        </p>
        <p class="text-xs opacity-80 mt-1">
            Tata Kata 
        </p>
    </footer>
</div>
@endsection