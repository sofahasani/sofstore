@extends('admin.layouts.admin')

@section('page-title', 'Edit Produk')

@section('content')
<div class="dashboard-content">
    <div class="max-w-3xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('products.index') }}" class="btn-back mb-6">
            ← Kembali ke Daftar Produk
        </a>

        <!-- Form Card -->
        <div class="card">
            <div class="mb-6">
                <h2 class="text-2xl font-bold" style="background: linear-gradient(135deg, #D4AF37, #FF7300); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Edit Produk</h2>
                <p class="text-sm opacity-60 mt-1">Update informasi produk</p>
            </div>

            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Nama Produk -->
                <div class="form-group">
                    <label class="form-label">Nama Produk *</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-input" required>
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-input">{{ $product->description }}</textarea>
                </div>

                <!-- Grid 2 Columns -->
                <div class="form-row">
                    <!-- Kategori -->
                    <div class="form-group">
                        <label class="form-label">Kategori *</label>
                        <select name="category" class="form-input" required>
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

                    <!-- Brand -->
                    <div class="form-group">
                        <label class="form-label">Brand/Merek</label>
                        <input type="text" name="brand" value="{{ $product->brand ?? '' }}" class="form-input">
                    </div>
                </div>

                <!-- Grid 2 Columns -->
                <div class="form-row">
                    <!-- Harga -->
                    <div class="form-group">
                        <label class="form-label">Harga (Rp) *</label>
                        <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="form-input" required>
                    </div>

                    <!-- Stock -->
                    <div class="form-group">
                        <label class="form-label">Jumlah Stock *</label>
                        <input type="number" name="stock" min="0" value="{{ $product->stock ?? 0 }}" class="form-input" required>
                    </div>
                </div>

                <!-- Gambar Produk -->
                <div class="form-group">
                    <label class="form-label">Gambar Produk</label>
                    @if($product->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                            <p class="text-xs opacity-60 mt-1">Gambar saat ini</p>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="form-input">
                    <p class="text-xs opacity-60 mt-1">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG, JPEG. Maksimal 2MB</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('products.index') }}" class="btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        ✓ Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        color: inherit;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
    }

    [data-theme="dark"] .form-input {
        background: rgba(26, 26, 29, 0.5);
        border-color: rgba(255, 255, 255, 0.1);
        color: #E4E4E7;
    }

    .form-input:focus {
        outline: none;
        border-color: #D4AF37;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: inherit;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        opacity: 1;
        transform: translateX(-4px);
    }

    .btn-primary {
        background: linear-gradient(135deg, #D4AF37, #FF7300);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
    }

    .btn-secondary {
        background: rgba(0, 0, 0, 0.05);
        color: inherit;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    [data-theme="dark"] .btn-secondary {
        background: rgba(255, 255, 255, 0.05);
    }

    .btn-secondary:hover {
        background: rgba(0, 0, 0, 0.1);
    }

    [data-theme="dark"] .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
    }
</style>
@endsection
