<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 rounded-xl shadow-2xl">
            <div>
                <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                    ✏️ {{ __('Edit Menu') }}
                </h2>
                <p class="text-blue-100 text-sm mt-1">Perbarui informasi menu juice</p>
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
                    <h3 class="text-2xl font-bold text-indigo-700 text-center">📝 Form Edit Menu</h3>
                </div>
                <div class="p-8">
                    <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- ID Menu -->
                        <div class="transform transition duration-200 hover:scale-[1.01]">
                            <label for="id_menu" class="block text-sm font-medium text-gray-700 mb-2">
                                ID Menu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="id_menu" id="id_menu" value="{{ old('id_menu', $menu->id_menu) }}" 
                                class="w-full px-4 py-2 border @error('id_menu') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" 
                                placeholder="Contoh: MN001" required>
                            @error('id_menu')
                                <p class="mt-1 text-sm text-red-500 animate-shake">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: huruf dan angka, contoh MN001, MENU001</p>
                        </div>

                        <!-- Nama Menu -->
                        <div class="transform transition duration-200 hover:scale-[1.01]">
                            <label for="nama_menu" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Menu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}" 
                                class="w-full px-4 py-2 border @error('nama_menu') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" 
                                placeholder="Contoh: Jus Jeruk" required>
                            @error('nama_menu')
                                <p class="mt-1 text-sm text-red-500 animate-shake">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="transform transition duration-200 hover:scale-[1.01]">
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="kategori" id="kategori" 
                                class="w-full px-4 py-2 border @error('kategori') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Jus" {{ old('kategori', $menu->kategori) == 'Jus' ? 'selected' : '' }}>Jus</option>
                                <option value="Smoothie" {{ old('kategori', $menu->kategori) == 'Smoothie' ? 'selected' : '' }}>Smoothie</option>
                                <option value="Milkshake" {{ old('kategori', $menu->kategori) == 'Milkshake' ? 'selected' : '' }}>Milkshake</option>
                                <option value="Mocktail" {{ old('kategori', $menu->kategori) == 'Mocktail' ? 'selected' : '' }}>Mocktail</option>
                            </select>
                            @error('kategori')
                                <p class="mt-1 text-sm text-red-500 animate-shake">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div class="transform transition duration-200 hover:scale-[1.01]">
                            <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-2.5 text-gray-500 font-semibold">Rp</span>
                                <input type="number" name="harga" id="harga" value="{{ old('harga', $menu->harga) }}" 
                                    class="w-full pl-12 pr-4 py-2 border @error('harga') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" 
                                    placeholder="15000" min="0" step="100" required>
                            </div>
                            @error('harga')
                                <p class="mt-1 text-sm text-red-500 animate-shake">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto -->
                        <div class="transform transition duration-200 hover:scale-[1.01]">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Menu
                            </label>
                            <div class="flex items-start space-x-6">
                                <!-- Current Photo -->
                                <div class="flex-shrink-0">
                                    <p class="text-xs text-gray-600 mb-2 font-medium">Foto Saat Ini:</p>
                                    @if($menu->foto)
                                    <div id="current-photo" class="relative group">
                                        <img src="{{ asset('storage/' . $menu->foto) }}" alt="Current Photo" class="h-32 w-32 rounded-lg object-cover shadow-lg border-2 border-gray-300">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition duration-200 rounded-lg flex items-center justify-center">
                                            <span class="text-white opacity-0 group-hover:opacity-100 text-xs font-semibold">Foto Lama</span>
                                        </div>
                                    </div>
                                    @else
                                    <div class="h-32 w-32 rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-md">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>

                                <!-- New Photo Preview -->
                                <div class="flex-shrink-0">
                                    <p class="text-xs text-gray-600 mb-2 font-medium">Preview Foto Baru:</p>
                                    <div id="preview-container" class="hidden">
                                        <div class="relative">
                                            <img id="foto-preview" src="" alt="Preview" class="h-32 w-32 rounded-lg object-cover shadow-lg border-4 border-indigo-500">
                                            <div class="absolute -top-2 -right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg animate-pulse">
                                                Baru
                                            </div>
                                        </div>
                                    </div>
                                    <div id="placeholder" class="h-32 w-32 rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center shadow-md border-2 border-dashed border-indigo-300">
                                        <svg class="h-12 w-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Upload Button -->
                                <div class="flex-1">
                                    <label for="foto" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        Ganti Foto
                                    </label>
                                    <input type="file" name="foto" id="foto" accept="image/*" class="hidden" onchange="previewImage(event)">
                                    <p class="mt-2 text-xs text-gray-500">JPG, JPEG, PNG, GIF (Max. 2MB)</p>
                                    <p class="mt-1 text-xs text-amber-600 font-medium">⚠️ Kosongkan jika tidak ingin mengubah foto</p>
                                    @error('foto')
                                        <p class="mt-1 text-sm text-red-500 animate-shake">{{ $message }}</p>
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
                                ✨ UPDATE MENU ✨
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('foto-preview');
            const previewContainer = document.getElementById('preview-container');
            const placeholder = document.getElementById('placeholder');
            const currentPhoto = document.getElementById('current-photo');

            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    previewContainer.classList.add('animate-fade-in');
                    placeholder.classList.add('hidden');
                    
                    // Add visual cue to old photo
                    if (currentPhoto) {
                        currentPhoto.classList.add('opacity-50', 'grayscale');
                    }
                }
                
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
                placeholder.classList.remove('hidden');
                
                // Remove visual cue from old photo
                if (currentPhoto) {
                    currentPhoto.classList.remove('opacity-50', 'grayscale');
                }
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
