@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Produk</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-2xl shadow-md transition-all">Tambah Produk</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white bg-opacity-70 rounded-2xl shadow-lg">
            <thead>
                <tr class="text-left text-gray-700 border-b">
                    <th class="py-3 px-4 font-semibold">Gambar</th>
                    <th class="py-3 px-4 font-semibold">Nama</th>
                    <th class="py-3 px-4 font-semibold">Harga</th>
                    <th class="py-3 px-4 font-semibold">Deskripsi</th>
                    <th class="py-3 px-4 font-semibold">Kategori</th>
                    <th class="py-3 px-4 font-semibold">Stok</th>
                    <th class="py-3 px-4 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $labels = ['Ori','Mall','Flash Sale','Limited','New','Best Seller'];
                @endphp
                @foreach($products as $product)
                @php
                    $label = $labels[array_rand($labels)];
                    switch($label) {
                        case 'Ori': $badgeClass = 'badge-ori'; break;
                        case 'Mall': $badgeClass = 'badge-mall'; break;
                        case 'Flash Sale': $badgeClass = 'badge-flash'; break;
                        case 'Limited': $badgeClass = 'badge-limited'; break;
                        case 'New': $badgeClass = 'badge-new'; break;
                        case 'Best Seller': $badgeClass = 'badge-bestseller'; break;
                        default: $badgeClass = 'badge-mall';
                    }
                @endphp
                <tr class="border-b hover:bg-blue-50 transition-colors">
                    <td class="py-2 px-4">
                        <div class="relative inline-block">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg shadow">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                            <span class="random-badge {{ $badgeClass }}">{{ $label }}</span>
                        </div>
                    </td>
                    <td class="py-2 px-4 font-bold text-gray-900">{{ $product->name }}</td>
                    <td class="py-2 px-4 text-blue-600 font-semibold">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 text-gray-600">{{ Str::limit($product->description, 40) }}</td>
                    <td class="py-2 px-4 text-gray-600">{{ $product->category ?? '-' }}</td>
                    <td class="py-2 px-4 text-gray-600">{{ $product->stock ?? 0 }}</td>
                    <td class="py-2 px-4 flex gap-2">
                        <a href="{{ route('products.edit', $product) }}" class="p-2 rounded-full bg-blue-100 hover:bg-blue-200 transition-all" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0l1.586 1.586a1 1 0 010 1.414L11 15H9v-2z" /></svg>
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-full bg-red-100 hover:bg-red-200 transition-all" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<style>
@media (max-width: 640px) {
    table { font-size: 13px; }
    th, td { padding-left: 6px !important; padding-right: 6px !important; }
    img { width: 40px !important; height: 40px !important; }
}
</style>
@endsection
