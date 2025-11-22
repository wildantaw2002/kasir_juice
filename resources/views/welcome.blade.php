<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir Juice - Sistem POS Modern</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px -10px rgba(0,0,0,0.15); }
        .bg-pattern { background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,0.03) 1px, transparent 0); background-size: 40px 40px; }
    </style>
</head>
<body class="bg-white">
    
    <!-- Navbar -->
    <nav class="bg-black border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-2xl">🍹</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white tracking-tight">Kasir Juice</h1>
                        <p class="text-xs text-gray-400">POS System</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-white text-black rounded-lg font-medium hover:bg-gray-100 transition-all duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 text-white hover:text-gray-300 rounded-lg font-medium transition-all duration-200">
                            Login
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-white text-black rounded-lg font-medium hover:bg-gray-100 transition-all duration-200">
                            Register
                        </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-1.5 bg-black text-white text-sm font-medium rounded-full mb-8">
                <span>Sistem POS Terbaik 2025</span>
            </div>
            <h1 class="text-6xl md:text-8xl font-black mb-6 tracking-tight">
                <span class="text-black">Kelola Bisnis</span>
                <br>
                <span class="text-gray-400">Lebih Simple</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 mb-12 max-w-3xl mx-auto font-light">
                Point of Sale modern untuk transaksi, menu, inventori, dan laporan real-time
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-10 py-4 bg-black text-white rounded-xl font-semibold text-lg hover:bg-gray-800 transition-all duration-200">
                        Buka Dashboard →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-10 py-4 bg-black text-white rounded-xl font-semibold text-lg hover:bg-gray-800 transition-all duration-200">
                        Mulai Sekarang →
                    </a>
                    <a href="#fitur" class="px-10 py-4 bg-white text-black rounded-xl font-semibold text-lg hover:bg-gray-50 transition-all duration-200 border-2 border-black">
                        Lihat Fitur
                    </a>
                @endauth
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-20">
            <div class="bg-white rounded-2xl p-8 border-2 border-black card-hover transition-all duration-300">
                <div class="text-5xl font-black text-black mb-2">100%</div>
                <div class="text-gray-600 font-medium">Real-time Data</div>
            </div>
            <div class="bg-black rounded-2xl p-8 border-2 border-black card-hover transition-all duration-300">
                <div class="text-5xl font-black text-white mb-2">Fast</div>
                <div class="text-gray-300 font-medium">Super Cepat</div>
            </div>
            <div class="bg-white rounded-2xl p-8 border-2 border-black card-hover transition-all duration-300">
                <div class="text-5xl font-black text-black mb-2">Safe</div>
                <div class="text-gray-600 font-medium">100% Aman</div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="fitur" class="py-20 bg-gray-50 bg-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl md:text-6xl font-black mb-4 text-black tracking-tight">
                    Fitur Lengkap
                </h2>
                <p class="text-xl text-gray-600 font-light">Semua yang Anda butuhkan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-8 border-2 border-black card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-black rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">🛒</span>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-3">POS Kasir</h3>
                    <p class="text-gray-600 mb-4 font-light">Transaksi cepat dengan 3 pilihan ukuran. Checkout AJAX tanpa reload.</p>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center"><span class="mr-2">•</span> Cart Management</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Multiple Payment</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Print Struk PDF</li>
                    </ul>
                </div>

                <div class="bg-black rounded-2xl p-8 border-2 border-black card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">📊</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Dashboard Admin</h3>
                    <p class="text-gray-300 mb-4 font-light">Pantau semua statistik bisnis secara real-time.</p>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-center"><span class="mr-2">•</span> Total Pendapatan</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Menu Terlaris</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Transaksi Hari Ini</li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl p-8 border-2 border-black card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-black rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">📋</span>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-3">Manajemen Menu</h3>
                    <p class="text-gray-600 mb-4 font-light">Kelola menu juice dengan mudah, lengkap dengan foto.</p>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center"><span class="mr-2">•</span> CRUD Lengkap</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Upload Foto</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Search & Filter</li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl p-8 border-2 border-black card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-black rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">📜</span>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-3">History Transaksi</h3>
                    <p class="text-gray-600 mb-4 font-light">Lihat riwayat lengkap dengan detail dan cetak ulang.</p>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center"><span class="mr-2">•</span> Detail Transaksi</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Print PDF</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Filter Data</li>
                    </ul>
                </div>

                <div class="bg-black rounded-2xl p-8 border-2 border-black card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">🔐</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Multi Role</h3>
                    <p class="text-gray-300 mb-4 font-light">Role-based access untuk Admin dan Kasir.</p>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-center"><span class="mr-2">•</span> Admin Access</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Kasir Access</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Secure Login</li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl p-8 border-2 border-black card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-black rounded-xl flex items-center justify-center mb-6">
                        <span class="text-2xl">🖨️</span>
                    </div>
                    <h3 class="text-2xl font-bold text-black mb-3">Print Struk</h3>
                    <p class="text-gray-600 mb-4 font-light">Cetak struk thermal 80mm format PDF.</p>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center"><span class="mr-2">•</span> Format Thermal 80mm</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Auto Download PDF</li>
                        <li class="flex items-center"><span class="mr-2">•</span> Professional Layout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-24 bg-black">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-5xl md:text-6xl font-black text-white mb-6 tracking-tight">
                Siap Meningkatkan<br>Bisnis Anda?
            </h2>
            <p class="text-xl text-gray-400 mb-10 font-light">
                Mulai gunakan sistem POS modern sekarang
            </p>
            @auth
                <a href="{{ url('/dashboard') }}" class="inline-block px-10 py-4 bg-white text-black rounded-xl font-semibold text-lg hover:bg-gray-100 transition-all duration-200">
                    Buka Dashboard →
                </a>
            @else
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('login') }}" class="px-10 py-4 bg-white text-black rounded-xl font-semibold text-lg hover:bg-gray-100 transition-all duration-200">
                        Login Sekarang
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-10 py-4 bg-black text-white rounded-xl font-semibold text-lg hover:bg-gray-900 transition-all duration-200 border-2 border-white">
                        Daftar Gratis
                    </a>
                    @endif
                </div>
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t-2 border-black py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center">
                            <span class="text-xl">🍹</span>
                        </div>
                        <h3 class="text-xl font-bold text-black">Kasir Juice</h3>
                    </div>
                    <p class="text-gray-600 font-light">Sistem POS Modern untuk Bisnis Juice</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-black">Akun Demo</h4>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li>Admin: admin@kasir.com</li>
                        <li>Kasir: kasir@kasir.com</li>
                        <li>Password: password</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-black">Fitur Utama</h4>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li>• POS Transaksi</li>
                        <li>• Manajemen Menu</li>
                        <li>• Dashboard Analytics</li>
                        <li>• Print Struk PDF</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-500 text-sm">
                <p>&copy; 2025 Kasir Juice. Made with Laravel 11</p>
            </div>
        </div>
    </footer>

</body>
</html>
