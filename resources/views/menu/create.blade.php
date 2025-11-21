<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 rounded-xl shadow-2xl">
            <div>
                <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                    ✨ {{ __('Tambah Menu Baru') }}
                </h2>
                <p class="text-blue-100 text-sm mt-1">Tambahkan menu minuman juice baru</p>
            </div>
            <a href="{{ route('menu.index') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-indigo-200 rounded-xl font-bold text-sm text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 hover:scale-110 active:scale-95 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition-all duration-300 transform shadow-lg hover:shadow-2xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl animate-fade-in border-4 border-indigo-200">
                <div class="bg-gradient-to-r from-pink-100 to-rose-100 p-4 border-b-4 border-indigo-300">
                    <h3 class="text-2xl font-bold text-indigo-700 text-center">📝 Form Tambah Menu</h3>
                </div>
                <div class="p-8">
                    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- ID Menu -->
                        <div class="transform transition duration-300 hover:scale-[1.02] bg-gradient-to-r from-pink-50 to-rose-50 p-4 rounded-xl">
                            <label for="id_menu" class="block text-sm font-bold text-indigo-700 mb-2">
                                🆔 ID Menu <span class="text-red-500 text-lg">*</span>
                            </label>
                            <input type="text" name="id_menu" id="id_menu" value="{{ old('id_menu') }}" 
                                class="w-full px-4 py-3 border-2 @error('id_menu') border-red-500 @else border-indigo-300 @enderror rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition duration-300 shadow-sm" 
                                placeholder="Contoh: MN001" required>
                            @error('id_menu')
                                <p class="mt-2 text-sm text-red-600 animate-shake font-semibold">❌ {{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-indigo-600 font-medium">💡 Format: huruf dan angka, contoh MN001, MENU001</p>
                        </div>

                        <!-- Nama Menu -->
                        <div class="transform transition duration-300 hover:scale-[1.02] bg-gradient-to-r from-pink-50 to-rose-50 p-4 rounded-xl">
                            <label for="nama_menu" class="block text-sm font-bold text-indigo-700 mb-2">
                                🍹 Nama Menu <span class="text-red-500 text-lg">*</span>
                            </label>
                            <input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu') }}" 
                                class="w-full px-4 py-3 border-2 @error('nama_menu') border-red-500 @else border-indigo-300 @enderror rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition duration-300 shadow-sm" 
                                placeholder="Contoh: Jus Jeruk" required>
                            @error('nama_menu')
                                <p class="mt-2 text-sm text-red-600 animate-shake font-semibold">❌ {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="transform transition duration-300 hover:scale-[1.02] bg-gradient-to-r from-pink-50 to-rose-50 p-4 rounded-xl">
                            <label for="kategori" class="block text-sm font-bold text-indigo-700 mb-2">
                                📁 Kategori <span class="text-red-500 text-lg">*</span>
                            </label>
                            <select name="kategori" id="kategori" 
                                class="w-full px-4 py-3 border-2 @error('kategori') border-red-500 @else border-indigo-300 @enderror rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition duration-300 shadow-sm" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Jus" {{ old('kategori') == 'Jus' ? 'selected' : '' }}>🍊 Jus</option>
                                <option value="Smoothie" {{ old('kategori') == 'Smoothie' ? 'selected' : '' }}>🥤 Smoothie</option>
                                <option value="Milkshake" {{ old('kategori') == 'Milkshake' ? 'selected' : '' }}>🍨 Milkshake</option>
                                <option value="Mocktail" {{ old('kategori') == 'Mocktail' ? 'selected' : '' }}>🍸 Mocktail</option>
                            </select>
                            @error('kategori')
                                <p class="mt-2 text-sm text-red-600 animate-shake font-semibold">❌ {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div class="transform transition duration-300 hover:scale-[1.02] bg-gradient-to-r from-pink-50 to-rose-50 p-4 rounded-xl">
                            <label for="harga" class="block text-sm font-bold text-indigo-700 mb-2">
                                💰 Harga <span class="text-red-500 text-lg">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-indigo-600 font-bold text-lg">Rp</span>
                                <input type="number" name="harga" id="harga" value="{{ old('harga') }}" 
                                    class="w-full pl-14 pr-4 py-3 border-2 @error('harga') border-red-500 @else border-indigo-300 @enderror rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition duration-300 shadow-sm text-lg font-semibold" 
                                    placeholder="15000" min="0" step="100" required>
                            </div>
                            @error('harga')
                                <p class="mt-2 text-sm text-red-600 animate-shake font-semibold">❌ {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto -->
                        <div class="transform transition duration-300 hover:scale-[1.02] bg-gradient-to-r from-pink-50 to-rose-50 p-4 rounded-xl">
                            <label for="foto" class="block text-sm font-bold text-indigo-700 mb-2">
                                📸 Foto Menu
                            </label>
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <div id="preview-container" class="hidden">
                                        <img id="foto-preview" src="" alt="Preview" class="h-40 w-40 rounded-2xl object-cover shadow-2xl border-4 border-indigo-500 animate-fade-in">
                                    </div>
                                    <div id="placeholder" class="h-40 w-40 rounded-2xl bg-gradient-to-br from-pink-200 to-rose-300 flex items-center justify-center shadow-lg border-4 border-dashed border-pink-400">
                                        <svg class="h-16 w-16 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label for="foto" class="cursor-pointer inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-400 to-rose-400 border-2 border-indigo-300 rounded-xl font-bold text-sm text-white uppercase tracking-widest shadow-lg hover:from-pink-500 hover:to-rose-500 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition-all duration-300 transform hover:scale-110">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        Pilih Foto
                                    </label>
                                    <input type="file" name="foto" id="foto" accept="image/*" class="hidden" onchange="previewImage(event)">
                                    <p class="mt-3 text-xs text-indigo-600 font-semibold">📌 JPG, JPEG, PNG, GIF (Max. 2MB)</p>
                                    @error('foto')
                                        <p class="mt-2 text-sm text-red-600 animate-shake font-semibold">❌ {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-center space-x-6 pt-8 border-t-4 border-indigo-200 mt-8">
                            <a href="{{ route('menu.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-600 border-2 border-gray-400 rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:from-gray-600 hover:to-gray-700 transition ease-in-out duration-300 transform hover:scale-110 shadow-xl hover:shadow-2xl">
                                ❌ Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 border-2 border-pink-400 rounded-xl font-bold text-lg text-white uppercase tracking-widest hover:from-pink-600 hover:via-rose-600 hover:to-pink-700 active:scale-95 focus:outline-none focus:ring-4 focus:ring-pink-400 transition-all duration-300 transform hover:scale-110 shadow-2xl hover:shadow-pink-500/50 animate-pulse">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                                ✨ SIMPAN MENU ✨
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-8px); }
            20%, 40%, 60%, 80% { transform: translateX(8px); }
        }
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
        .animate-shake {
            animation: shake 0.6s ease-in-out;
        }
    </style>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('foto-preview');
            const previewContainer = document.getElementById('preview-container');
            const placeholder = document.getElementById('placeholder');

            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    previewContainer.classList.add('animate-fade-in');
                    placeholder.classList.add('hidden');
                }
                
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }

        // Format harga dengan thousand separator
        const hargaInput = document.getElementById('harga');
        hargaInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
    </script>
</x-app-layout>
