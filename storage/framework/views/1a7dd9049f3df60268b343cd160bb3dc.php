

<?php $__env->startSection('page-title', 'Manajemen Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-content">
    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold" style="background: linear-gradient(135deg, #D4AF37, #FF7300); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Daftar Produk</h2>
            <p class="text-sm opacity-60 mt-1">Kelola semua produk di toko Anda</p>
        </div>
        <a href="<?php echo e(route('products.create')); ?>" class="btn-primary">
            <span style="font-size: 18px;">➕</span> Tambah Produk
        </a>
    </div>

    <!-- Products Table Card -->
    <div class="card table-card">
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Brand</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Terjual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/'.$product->image)); ?>" alt="<?php echo e($product->name); ?>" class="w-12 h-12 object-cover rounded-lg">
                            <?php else: ?>
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                    <span style="font-size: 20px;">📦</span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo e($product->name); ?></strong>
                            <?php if($product->sku): ?>
                                <div style="font-size: 11px; opacity: 0.6;">SKU: <?php echo e($product->sku); ?></div>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($product->category ?? '-'); ?></td>
                        <td><?php echo e($product->brand ?? '-'); ?></td>
                        <td>
                            <strong>Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></strong>
                            <?php if($product->discount_price): ?>
                                <div style="font-size: 11px; text-decoration: line-through; opacity: 0.6;">
                                    Rp <?php echo e(number_format($product->discount_price, 0, ',', '.')); ?>

                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(($product->stock ?? 0) <= 10): ?>
                                <span class="badge danger"><?php echo e($product->stock ?? 0); ?></span>
                            <?php else: ?>
                                <span class="badge success"><?php echo e($product->stock ?? 0); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($product->is_active ?? true): ?>
                                <span class="badge success">Aktif</span>
                            <?php else: ?>
                                <span class="badge danger">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($product->total_sold ?? 0); ?></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn-icon btn-edit" title="Edit">
                                    ✏️
                                </a>
                                <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-icon btn-delete" title="Hapus">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 60px 20px; opacity: 0.6;">
                            <div style="font-size: 48px; margin-bottom: 16px;">📦</div>
                            <div style="font-size: 16px; font-weight: 600;">Belum ada produk</div>
                            <div style="font-size: 14px; margin-top: 8px;">Klik tombol "Tambah Produk" untuk memulai</div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($products->hasPages()): ?>
        <div style="padding: 20px; border-top: 1px solid rgba(0,0,0,0.05);">
            <?php echo e($products->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .btn-primary {
        background: linear-gradient(135deg, #D4AF37, #FF7300);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .btn-edit {
        background: rgba(59, 130, 246, 0.1);
        color: #3B82F6;
    }

    .btn-edit:hover {
        background: #3B82F6;
        transform: scale(1.1);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #EF4444;
    }

    .btn-delete:hover {
        background: #EF4444;
        transform: scale(1.1);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectwahab\resources\views/admin/products/index.blade.php ENDPATH**/ ?>