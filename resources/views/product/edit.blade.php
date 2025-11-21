@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Produk</h1>
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white bg-opacity-80 rounded-2xl shadow-md p-6 max-w-lg mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">{{ $product->description }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Harga</label>
            <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
        </div>

        <!-- Stock Input -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Jumlah Stock</label>
            <input type="number" name="stock" min="0" value="{{ $product->stock ?? 0 }}" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
        </div>

        <!-- Category Select -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
            <select name="category" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" required>
                <option value="" disabled>Pilih Kategori</option>
                <option value="Elektronik" {{ ($product->category ?? '') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                <option value="Fashion" {{ ($product->category ?? '') == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                <option value="Makanan & Minuman" {{ ($product->category ?? '') == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                <option value="Kesehatan & Kecantikan" {{ ($product->category ?? '') == 'Kesehatan & Kecantikan' ? 'selected' : '' }}>Kesehatan & Kecantikan</option>
                <option value="Rumah Tangga" {{ ($product->category ?? '') == 'Rumah Tangga' ? 'selected' : '' }}>Rumah Tangga</option>
                <option value="Olahraga" {{ ($product->category ?? '') == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                <option value="Otomotif" {{ ($product->category ?? '') == 'Otomotif' ? 'selected' : '' }}>Otomotif</option>
                <option value="Hobi & Koleksi" {{ ($product->category ?? '') == 'Hobi & Koleksi' ? 'selected' : '' }}>Hobi & Koleksi</option>
                <option value="Lainnya" {{ ($product->category ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <!-- Brand Input -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Brand/Merek (Optional)</label>
            <input type="text" name="brand" value="{{ $product->brand ?? '' }}" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Produk</label>
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded-xl mb-2">
            @endif
            <input type="file" name="image" accept="image/*" class="w-full">
        </div>
        <div class="flex justify-end">
            <a href="{{ route('products.index') }}" class="mr-4 px-4 py-2 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-4 py-2 rounded-xl bg-blue-500 text-white hover:bg-blue-600">Update</button>
        </div>
    </form>
</div>
@endsection
