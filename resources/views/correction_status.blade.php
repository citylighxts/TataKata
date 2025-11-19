@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A2E] relative overflow-hidden flex items-center justify-center p-4 sm:p-6">
    
    {{-- Animated Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-[#0A0A2E] via-[#1a1a40] to-[#0A0A2E] animate-gradient-shift"></div>
    
    {{-- Grid Pattern Overlay --}}
    <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(#85BBEB 1px, transparent 1px), linear-gradient(90deg, #85BBEB 1px, transparent 1px); background-size: 50px 50px;"></div>
    

    {{-- Main Content Card --}}
    <div class="relative z-10 w-full max-w-2xl">
        <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/20 to-transparent rounded-3xl blur-2xl opacity-60"></div>
        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#85BBEB] to-[#FEF9F0] rounded-3xl opacity-20 blur"></div>
        
        <div class="relative bg-gradient-to-br from-[#FEF9F0]/10 via-[#0A0A2E]/50 to-[#0A0A2E]/80 backdrop-blur-xl p-6 sm:p-8 md:p-10 lg:p-12 rounded-3xl shadow-2xl border border-[#85BBEB]/30 text-center">
            
            {{-- Title --}}
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#FFFFFF] mb-3 sm:mb-4" id="main-title">
                Sedang Memproses Dokumen ⏳
            </h1>
            
            {{-- Document Info --}}
            <p class="text-base sm:text-lg md:text-xl text-[#C0C0C0] mb-6 sm:mb-8" id="doc-info">
                Dokumen <strong class="text-[#85BBEB]">{{ $document->file_name }}</strong> sedang dianalisis.
            </p>

            {{-- Status Display --}}
            <div class="flex flex-col items-center">
                <div id="status-display" class="mb-4">
                    <div class="relative inline-flex items-center justify-center">
                        <div class="absolute inset-0 bg-[#85BBEB] rounded-full blur-xl opacity-50 animate-pulse-subtle"></div>
                        <svg id="processing-spinner" class="relative animate-spin h-12 w-12 sm:h-14 sm:w-14 text-[#85BBEB]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
                
                {{-- Status Message --}}
                <p id="status-message" class="text-base sm:text-lg font-semibold text-[#85BBEB] mb-2">
                    Status: {{ $document->upload_status }}...
                </p>
                <p id="status-details" class="text-sm sm:text-base text-[#C0C0C0]">{{ $document->details ?? '' }}</p>
                
                {{-- Action Button --}}
                <div class="w-full mt-6 flex gap-3 justify-center">
                    <a href="{{ route('correction.original', $document->id) }}" target="_blank" rel="noopener noreferrer"
                       class="px-6 py-3 backdrop-blur-md bg-[#FEF9F0]/10 border-2 border-[#85BBEB]/40 text-[#FEF9F0] rounded-full hover:bg-[#FEF9F0]/20 hover:border-[#85BBEB]/60 hover:shadow-lg hover:shadow-[#85BBEB]/30 transition-all duration-300 font-medium relative overflow-hidden group">
                        <span class="relative z-10">Lihat Dokumen Asli</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#85BBEB]/0 via-[#85BBEB]/20 to-[#85BBEB]/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    </a>
                </div>
                
                {{-- Progress Panel --}}
                <div id="progress-panel" class="w-full mt-6 text-left">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#85BBEB]/10 to-transparent rounded-xl blur"></div>
                        <div class="relative bg-[#0A0A2E]/50 backdrop-blur-sm p-4 rounded-xl border border-[#85BBEB]/20">
                            <h4 class="text-sm font-semibold text-[#85BBEB] mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Progres
                            </h4>
                            <ul id="progress-list" class="text-sm text-[#C0C0C0] space-y-2 max-h-40 overflow-auto pr-2 custom-scrollbar">
                                @foreach(array_slice($document->progress_log ?? [], -10) as $entry)
                                    <li class="flex gap-2 items-start hover:text-[#FEF9F0] transition-colors duration-200">
                                        <span class="text-xs text-[#85BBEB]/70 font-mono">[{{ \Carbon\Carbon::parse($entry['ts'] ?? now())->format('H:i:s') }}]</span>
                                        <span>{{ $entry['message'] ?? '' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Error Message --}}
            <div id="error-message" class="mt-4 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 font-semibold hidden"></div>
        </div>
    </div>

    <script>
        function redirectToCorrection(url) {
            window.location.replace(url);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkUrl = "{{ route('correction.check-status', $document->id) }}"; // Ganti nama route
            const statusMessage = document.getElementById('status-message');
            const statusDisplay = document.getElementById('status-display');
            const mainTitle = document.getElementById('main-title');
            const docInfo = document.getElementById('doc-info');
            
            const intervalDuration = 5000; // Cek setiap 5 detik
            let pollingIntervalId = null;

            function createRedirectButton(url) {
                return `<button onclick="redirectToCorrection('${url}')"
                            class="group px-8 py-4 bg-gradient-to-r from-[#85BBEB] via-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-lg relative overflow-hidden">
                            <span class="relative z-10 flex items-center gap-2 justify-center">
                                Lihat Hasil Koreksi
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        </button>`;
            }

            function checkProcessingStatus() {
                fetch(checkUrl, { headers: { 'Accept': 'application/json' } })
                .then(response => response.json())
                .then(data => {
                    statusMessage.innerText = `Status: ${data.status}...`;

                    // ==========================================================
                    // PERUBAHAN STEP 3: JAVASCRIPT HANDLER BARU
                    // ==========================================================
                    
                    if (data.done) { // Ini HANYA akan true jika status = 'Ready'
                        if (pollingIntervalId !== null) {
                            clearInterval(pollingIntervalId); 
                            pollingIntervalId = null; 
                        }
                        
                        mainTitle.innerText = "Pemrosesan Selesai! 🎉";
                        statusDisplay.innerHTML = createRedirectButton(data.redirect_url);
                        statusMessage.innerText = "Dokumen siap. Klik tombol di atas untuk melihat perubahannya.";
                    
                    } else if (data.status === 'No_Chapters') {
                        // Status baru: Dokumen bukan TA
                        if (pollingIntervalId !== null) { clearInterval(pollingIntervalId); }
                        
                        docInfo.classList.add('hidden');
                        mainTitle.innerText = "Format Dokumen Salah 📑";
                        statusDisplay.innerHTML = `
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-lg relative overflow-hidden group">
                                <span class="relative z-10 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
                                    </svg>
                                    Kembali ke Beranda
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                            </a>
                        `;
                        statusMessage.innerText = "Gagal memecah dokumen.";
                        
                        const errorEl = document.getElementById('error-message');
                        if (data.details) {
                            errorEl.innerText = data.details; // "Dokumen ini tidak dapat dipecah..."
                            errorEl.classList.remove('hidden');
                        }

                    } else if (data.status === 'Failed') {
                        // Status Gagal (Error sistem)
                        if (pollingIntervalId !== null) { clearInterval(pollingIntervalId); }
                        
                        docInfo.classList.add('hidden');
                        mainTitle.innerText = "Pemrosesan Gagal ❌";
                        statusDisplay.innerHTML = `
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-lg relative overflow-hidden group">
                                <span class="relative z-10 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
                                    </svg>
                                    Kembali ke Beranda
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                            </a>
                        `;
                        statusMessage.innerText = "Terjadi kesalahan. Silakan coba unggah dokumen lagi.";
                        const errorEl = document.getElementById('error-message');
                        if (data.details) {
                            errorEl.innerText = 'Error: ' + data.details;
                            errorEl.classList.remove('hidden');
                        }
                    }
                    else if (data.status === 'Deleted') {
                        // Status Dihapus
                        if (pollingIntervalId !== null) { clearInterval(pollingIntervalId); }
                        mainTitle.innerText = "Dokumen Dihapus 🗑️";
                        statusDisplay.innerHTML = `
                            <a href="{{ route('history') }}"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#85BBEB] to-[#85BBEB] text-[#0A0A2E] rounded-full hover:shadow-2xl hover:shadow-[#85BBEB]/60 hover:scale-105 transition-all duration-300 font-bold text-lg relative overflow-hidden group">
                                <span class="relative z-10 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Kembali ke Riwayat
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-[#FEF9F0]/30 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                            </a>
                        `;
                        statusMessage.innerText = data.details || 'Dokumen telah dihapus.';
                        docInfo.classList.add('hidden');
                    }
                    
                    // Update detail dan progres (jika masih memproses)
                    const detailsEl = document.getElementById('status-details');
                    if (data.details && detailsEl) {
                        detailsEl.innerText = data.details;
                    }

                    if (data.progress && Array.isArray(data.progress)) {
                        const list = document.getElementById('progress-list');
                        if (list) {
                            list.innerHTML = '';
                            data.progress.slice().reverse().forEach(entry => { // Tampilkan dari terbaru
                                const li = document.createElement('li');
                                li.className = 'flex gap-2 items-start hover:text-[#FEF9F0] transition-colors duration-200';
                                const ts = document.createElement('span');
                                ts.className = 'text-xs text-[#85BBEB]/70 font-mono';
                                // Format timestamp H:i:s
                                let date = new Date(entry.ts);
                                let timeString = [date.getHours(), date.getMinutes(), date.getSeconds()]
                                    .map(v => v < 10 ? '0' + v : v)
                                    .join(':');
                                ts.innerText = '[' + (timeString || '...') + ']';
                                const msg = document.createElement('span');
                                msg.innerText = entry.message || '';
                                li.appendChild(ts);
                                li.appendChild(msg);
                                list.appendChild(li);
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking status:', error);
                    statusMessage.innerText = 'Gagal terhubung ke server. Mencoba lagi...';
                });
            }
            
            // Periksa status segera saat halaman dimuat
            checkProcessingStatus(); 
            // Mulai polling
            pollingIntervalId = setInterval(checkProcessingStatus, intervalDuration);

        });

    
    </script>

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

    /* Pulse Animation */
    @keyframes pulse-subtle {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 0.8; }
    }

    .animate-pulse-subtle { animation: pulse-subtle 2s ease-in-out infinite; }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(133, 187, 235, 0.1);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(133, 187, 235, 0.4);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(133, 187, 235, 0.6);
    }

    </style>
</div>
@endsection