<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Excellence - {{ $user->name }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Cinzel:wght@500;700&display=swap" rel="stylesheet">
    <!-- TailwindCSS for quick layout -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        playfair: ['Playfair Display', 'serif'],
                        cinzel: ['Cinzel', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .cert-border {
            border-image: linear-gradient(to right, #d4af37, #f3e5ab, #d4af37) 30;
        }
        .bg-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        @media print {
            body {
                background: none;
                color: black;
            }
            .no-print {
                display: none;
            }
            .print-card {
                box-shadow: none !important;
                border: 15px solid #d4af37 !important;
            }
        }
    </style>
</head>
<body class="bg-slate-900 font-outfit text-slate-800 flex flex-col items-center justify-center min-h-screen p-4 sm:p-8">

    <!-- Top floating print button -->
    <div class="no-print mb-6 flex space-x-4">
        <button onclick="window.print()" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-6 py-2.5 rounded-xl transition-all shadow-lg flex items-center space-x-2">
            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Print Certificate</span>
        </button>
        <a href="/dashboard" class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold px-6 py-2.5 rounded-xl border border-slate-700 transition-all flex items-center space-x-2">
            <span>Back to Dashboard</span>
        </a>
    </div>

    <!-- Outer Frame -->
    <div class="print-card w-full max-w-4xl bg-glass border-[16px] border-amber-500/30 p-8 sm:p-14 shadow-2xl rounded-2xl relative overflow-hidden transition-all duration-300">
        
        <!-- Premium Watermark Pattern (Simulated with absolute shapes) -->
        <div class="absolute -top-32 -left-32 w-64 h-64 bg-amber-500/5 rounded-full filter blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-64 h-64 bg-amber-500/5 rounded-full filter blur-3xl pointer-events-none"></div>

        <!-- Certificate Inner Design -->
        <div class="border-[4px] border-amber-500/20 p-6 sm:p-10 flex flex-col items-center justify-between text-center relative z-10">
            
            <!-- Logo Header -->
            <div class="flex items-center space-x-2.5 mb-6">
                <span class="text-2xl font-black tracking-tight text-slate-900 font-outfit">Code<span class="text-amber-500">Solve</span></span>
            </div>

            <!-- Main Heading -->
            <div class="mb-4">
                <h1 class="font-cinzel text-xs sm:text-sm tracking-[0.25em] text-amber-600 font-bold uppercase mb-2">Milestone Achievement</h1>
                <h2 class="font-playfair text-3xl sm:text-4xl md:text-5xl font-bold italic text-slate-900">Certificate of Coding Excellence</h2>
            </div>

            <!-- Divider -->
            <div class="w-40 h-[1.5px] bg-gradient-to-r from-transparent via-amber-500 to-transparent my-6"></div>

            <!-- Certificate Core Text -->
            <div class="max-w-2xl space-y-4">
                <p class="font-playfair text-slate-500 text-base sm:text-lg italic">This is proudly presented to</p>
                <h3 class="font-cinzel text-3xl sm:text-4xl md:text-5xl font-bold tracking-wide text-slate-800 border-b border-slate-200 pb-2 inline-block px-12">{{ $user->name }}</h3>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed font-outfit max-w-xl mx-auto py-2">
                    {{ $description }} Verified on the CodeSolve competitive programming playground upon successfully completing rigorous algorithmic and data structure assessments.
                </p>
            </div>

            <!-- Stats Block -->
            <div class="my-6 bg-slate-50 border border-slate-100 px-6 py-2.5 rounded-2xl flex items-center space-x-6">
                <div>
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Solved Problems</span>
                    <span class="text-lg font-bold text-slate-800">{{ $solvedCount }}+ Problems</span>
                </div>
                <div class="h-8 w-[1px] bg-slate-200"></div>
                <div>
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Verify ID</span>
                    <span class="text-xs font-mono font-bold text-slate-500 uppercase">CS-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}-{{ strtoupper($type) }}</span>
                </div>
            </div>

            <!-- Footer Signatures -->
            <div class="w-full flex flex-col sm:flex-row justify-between items-center mt-8 pt-8 border-t border-slate-100 gap-6">
                <!-- Date -->
                <div class="text-center sm:text-left">
                    <span class="text-slate-800 font-semibold text-sm border-b border-slate-300 pb-1 px-4 block min-w-[120px]">{{ $date }}</span>
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1 block">Date of Issue</span>
                </div>

                <!-- Verification Stamp (Glass Stamp style) -->
                <div class="w-20 h-20 rounded-full border-[3px] border-amber-500/40 flex items-center justify-center relative rotate-12 bg-amber-500/5 select-none shadow-sm">
                    <div class="text-center flex flex-col items-center justify-center">
                        <span class="text-[7px] font-bold text-amber-700 tracking-widest uppercase">VERIFIED</span>
                        <span class="text-[9px] font-bold text-slate-800 font-cinzel">{{ strtoupper($type) }}</span>
                        <span class="text-[5px] text-amber-600 tracking-wider">CODESOLVE</span>
                    </div>
                </div>

                <!-- Authorized Signature -->
                <div class="text-center sm:text-right">
                    <span class="font-playfair text-lg text-slate-800 italic border-b border-slate-300 pb-1 px-4 block min-w-[120px]">CodeSolve Team</span>
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1 block">Authorized Signatory</span>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
