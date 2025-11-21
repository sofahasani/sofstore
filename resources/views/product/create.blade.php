@extends('layouts.app')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-white to-amber-50">
    <div class="w-full max-w-md mx-auto p-6 backdrop-blur-md bg-white/70 rounded-3xl shadow-lg border border-white/40">

        <!-- Judul -->
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Tambah Produk</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Nama Produk -->
            <div class="relative">
                <input type="text" name="name" id="name"
                       class="peer w-full rounded-2xl bg-white/60 border border-gray-200 px-4 pt-6 pb-2 
                              text-gray-800 placeholder-transparent focus:border-amber-400 focus:ring-0 focus:outline-none transition-all"
                       placeholder="Nama Produk" required>
                <label for="name"
                       class="absolute left-4 top-2 text-gray-500 text-sm transition-all 
                              peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                              peer-focus:top-2 peer-focus:text-sm peer-focus:text-amber-500">
                    Nama Produk
                </label>
            </div>

            <!-- Deskripsi -->
            <div class="relative">
                <textarea name="description" id="description" rows="3"
                          class="peer w-full rounded-2xl bg-white/60 border border-gray-200 px-4 pt-6 pb-2 
                                 text-gray-800 placeholder-transparent focus:border-amber-400 focus:ring-0 focus:outline-none transition-all"
                          placeholder="Deskripsi"></textarea>
                <label for="description"
                       class="absolute left-4 top-2 text-gray-500 text-sm transition-all 
                              peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                              peer-focus:top-2 peer-focus:text-sm peer-focus:text-amber-500">
                    Deskripsi
                </label>
            </div>

            <!-- Harga (dengan format jutaan otomatis) -->
            <div class="relative">
                <input type="text" name="price_display" id="price_display"
                       class="peer w-full rounded-2xl bg-white/60 border border-gray-200 px-4 pt-6 pb-2 
                              text-gray-800 placeholder-transparent focus:border-amber-400 focus:ring-0 focus:outline-none transition-all"
                       placeholder="Harga" required />
                <label for="price_display"
                       class="absolute left-4 top-2 text-gray-500 text-sm transition-all 
                              peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                              peer-focus:top-2 peer-focus:text-sm peer-focus:text-amber-500">
                    Harga
                </label>
                <input type="hidden" name="price" id="price">
            </div>

            <!-- Stock -->
            <div class="relative">
                <input type="number" name="stock" id="stock" min="0"
                       class="peer w-full rounded-2xl bg-white/60 border border-gray-200 px-4 pt-6 pb-2 
                              text-gray-800 placeholder-transparent focus:border-amber-400 focus:ring-0 focus:outline-none transition-all"
                       placeholder="Stock" required>
                <label for="stock"
                       class="absolute left-4 top-2 text-gray-500 text-sm transition-all 
                              peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                              peer-focus:top-2 peer-focus:text-sm peer-focus:text-amber-500">
                    Jumlah Stock
                </label>
            </div>

            <!-- Kategori -->
            <div class="relative">
                <select name="category" id="category"
                        class="peer w-full rounded-2xl bg-white/60 border border-gray-200 px-4 pt-6 pb-2 
                               text-gray-800 focus:border-amber-400 focus:ring-0 focus:outline-none transition-all appearance-none">
                    <option value="">Pilih Kategori</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Fashion">Fashion</option>
                    <option value="Makanan & Minuman">Makanan & Minuman</option>
                    <option value="Kesehatan & Kecantikan">Kesehatan & Kecantikan</option>
                    <option value="Rumah Tangga">Rumah Tangga</option>
                    <option value="Olahraga">Olahraga</option>
                    <option value="Otomotif">Otomotif</option>
                    <option value="Hobi & Koleksi">Hobi & Koleksi</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <label for="category"
                       class="absolute left-4 top-2 text-gray-500 text-sm">
                    Kategori Produk
                </label>
                <!-- Arrow icon -->
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            <!-- Brand -->
            <div class="relative">
                <input type="text" name="brand" id="brand"
                       class="peer w-full rounded-2xl bg-white/60 border border-gray-200 px-4 pt-6 pb-2 
                              text-gray-800 placeholder-transparent focus:border-amber-400 focus:ring-0 focus:outline-none transition-all"
                       placeholder="Brand">
                <label for="brand"
                       class="absolute left-4 top-2 text-gray-500 text-sm transition-all 
                              peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 
                              peer-focus:top-2 peer-focus:text-sm peer-focus:text-amber-500">
                    Brand/Merek (Optional)
                </label>
            </div>

            <!-- Gambar Produk -->
            <div class="relative">
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0 file:text-sm file:font-semibold
                              file:bg-gradient-to-r file:from-amber-400 file:to-amber-500
                              file:text-white hover:file:brightness-110 transition-all" />
            </div>

            <!-- Tombol -->
            <div class="flex justify-between gap-4">
                <a href="{{ route('products.index') }}"
                   class="flex-1 text-center px-4 py-2 rounded-2xl bg-white/70 border border-gray-200 
                          text-gray-700 hover:bg-gray-100 transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 px-4 py-2 rounded-2xl bg-gradient-to-r from-amber-400 to-amber-500 
                               text-white font-semibold hover:brightness-110 shadow-md transition-all">
                    Simpan Produk
                </button>
            </div>
        </form>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-500 mt-6">© 2025 Elegant Glass UI by Wahab</p>
    </div>
</div>

<script>
    // Format harga otomatis jutaan
    const priceDisplay = document.getElementById('price_display');
    const priceHidden = document.getElementById('price');

    priceDisplay.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, ''); // hapus semua non-digit
        let formatted = new Intl.NumberFormat('id-ID').format(value);
        this.value = formatted;
        priceHidden.value = value;
    });
</script>
@endsection
