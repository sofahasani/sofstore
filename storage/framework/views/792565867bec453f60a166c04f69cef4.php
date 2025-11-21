<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Saya</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header dengan Gradient Orange */
        .page-header {
            background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%);
            padding: 40px 30px;
            border-radius: 24px;
            margin-bottom: 40px;
            box-shadow: 0 10px 40px rgba(255, 115, 0, 0.2);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .back-btn {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-4px);
        }

        h1 {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        /* Product Cards - Background Putih */
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }

        .product-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            animation: slideUp 0.6s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(255, 115, 0, 0.15);
            border-color: #ff9500;
        }

        .remove-icon {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: none;
            font-size: 18px;
            color: #6b7280;
        }

        .remove-icon:hover {
            background: #fee2e2;
            color: #dc2626;
            transform: rotate(90deg) scale(1.1);
        }
        
        .remove-form {
            margin: 0;
            padding: 0;
        }

        .product-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .product-info {
            padding: 20px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 22px;
            font-weight: 700;
            color: #ff7300;
            margin-bottom: 16px;
        }

        .product-actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-add {
            background: linear-gradient(135deg, #ff7300, #ff9500);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 115, 0, 0.3);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 115, 0, 0.4);
        }
        
        .btn-view {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #e5e7eb;
        }

        .btn-view:hover {
            background: #e5e7eb;
            color: #1f2937;
            border-color: #d1d5db;
        }

        .btn-remove {
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }

        .btn-remove:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* Empty State - Background Putih */
        .empty-state {
            background: white;
            border: 2px dashed #e5e7eb;
            border-radius: 24px;
            padding: 80px 40px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .empty-icon {
            font-size: 80px;
            margin-bottom: 24px;
            opacity: 0.3;
        }

        .empty-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1f2937;
        }

        .empty-text {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 32px;
        }

        .shop-btn {
            display: inline-block;
            background: linear-gradient(135deg, #ff7300, #ff9500);
            color: white;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(255, 115, 0, 0.4);
        }

        .shop-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(255, 115, 0, 0.6);
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 24px;
            }

            .wishlist-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 16px;
            }

            .page-header {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header dengan Gradient Orange -->
        <div class="page-header">
            <div class="header-content">
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">←</a>
                <h1>❤️ Wishlist Saya (<?php echo e($wishlists->count()); ?>)</h1>
            </div>
        </div>

        <?php if($wishlists->isEmpty()): ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">❤️</div>
                <div class="empty-title">Wishlist Masih Kosong</div>
                <div class="empty-text">Tambahkan produk favoritmu ke wishlist!</div>
                <a href="<?php echo e(route('dashboard')); ?>" class="shop-btn">🛍️ Mulai Belanja</a>
            </div>
        <?php else: ?>
            <!-- Wishlist Products -->
            <div class="wishlist-grid">
                <?php $__currentLoopData = $wishlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wishlist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card" id="wishlist-<?php echo e($wishlist->id); ?>">
                    <form action="<?php echo e(route('wishlist.destroy', $wishlist->id)); ?>" method="POST" class="remove-form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="remove-icon" onclick="return confirm('Hapus dari wishlist?')">✕</button>
                    </form>
                    
                    <a href="<?php echo e(route('products.show', $wishlist->product->id)); ?>">
                        <?php
                            $imagePath = $wishlist->product->primary_image ?? $wishlist->product->image;
                            $imageUrl = $imagePath 
                                ? (str_starts_with($imagePath, 'http') 
                                    ? $imagePath 
                                    : asset('storage/' . $imagePath)) 
                                : 'https://via.placeholder.com/280x220/ff7300/ffffff?text=No+Image';
                        ?>
                        <img src="<?php echo e($imageUrl); ?>" 
                             alt="<?php echo e($wishlist->product->name); ?>" 
                             class="product-image"
                             onerror="this.src='https://via.placeholder.com/280x220/ff7300/ffffff?text=No+Image'">
                    </a>
                    
                    <div class="product-info">
                        <a href="<?php echo e(route('products.show', $wishlist->product->id)); ?>" style="text-decoration: none;">
                            <div class="product-name"><?php echo e($wishlist->product->name); ?></div>
                        </a>
                        <div class="product-price">Rp <?php echo e(number_format($wishlist->product->price, 0, ',', '.')); ?></div>
                        
                        <div class="product-actions">
                            <button class="btn btn-add" onclick="addToCart(<?php echo e($wishlist->product->id); ?>)">
                                🛒 Keranjang
                            </button>
                            <a href="<?php echo e(route('products.show', $wishlist->product->id)); ?>" class="btn btn-view">
                                👁️ Lihat
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Add to cart function
        function addToCart(productId) {
            fetch('<?php echo e(route("cart.add")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('✅ Berhasil ditambahkan ke keranjang', 'success');
                } else {
                    showToast('❌ ' + (data.message || 'Gagal menambahkan ke keranjang'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('❌ Terjadi kesalahan', 'error');
            });
        }

        // Toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                bottom: 80px;
                left: 50%;
                transform: translateX(-50%);
                background: ${type === 'success' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #ef4444, #dc2626)'};
                color: white;
                padding: 16px 28px;
                border-radius: 16px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.2);
                z-index: 100000;
                font-size: 15px;
                font-weight: 600;
                animation: slideUp 0.3s ease-out;
            `;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideDown 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }

        @keyframes slideUp {
            from { transform: translate(-50%, 30px); opacity: 0; }
            to { transform: translate(-50%, 0); opacity: 1; }
        }

        @keyframes slideDown {
            from { transform: translate(-50%, 0); opacity: 1; }
            to { transform: translate(-50%, 30px); opacity: 0; }
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\projectwahab\resources\views/wishlist/index.blade.php ENDPATH**/ ?>