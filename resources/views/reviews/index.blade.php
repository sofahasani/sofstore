<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ulasan Saya - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            color: #333;
            padding-bottom: 70px;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .back-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
        }

        .header-title {
            flex: 1;
            font-size: 18px;
            font-weight: 600;
        }

        /* Review List */
        .reviews-container {
            padding: 16px;
            max-width: 800px;
            margin: 0 auto;
        }

        .review-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .review-header {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            background: #f5f5f5;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .order-date {
            font-size: 12px;
            color: #999;
        }

        .rating-stars {
            margin-bottom: 8px;
        }

        .star {
            color: #ffd700;
            font-size: 16px;
            margin-right: 2px;
        }

        .star.empty {
            color: #ddd;
        }

        .review-comment {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 12px;
        }

        .review-date {
            font-size: 12px;
            color: #999;
        }

        .delete-btn {
            background: #ff6b35;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .delete-btn:hover {
            background: #ff5722;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 80px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .empty-text {
            font-size: 14px;
            color: #999;
            margin-bottom: 24px;
        }

        .btn-browse {
            display: inline-block;
            padding: 12px 32px;
            background: #ff6b35;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .nav-item {
            padding: 8px;
            text-align: center;
            text-decoration: none;
            color: #999;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .nav-item.active {
            color: #ff6b35;
        }

        .nav-icon {
            font-size: 22px;
        }

        .nav-label {
            font-size: 10px;
        }

        /* Toast */
        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            z-index: 2000;
            display: none;
        }

        .toast.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -20px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <button class="back-btn" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="header-title">Ulasan Saya</div>
    </div>

    @if($reviews->count() > 0)
        <!-- Reviews List -->
        <div class="reviews-container">
            @foreach($reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    @if($review->product->images->first())
                    <img src="{{ asset('storage/' . $review->product->images->first()->image_path) }}" 
                         alt="{{ $review->product->name }}" 
                         class="product-image">
                    @else
                    <img src="https://via.placeholder.com/80x80?text={{ urlencode($review->product->name) }}" 
                         alt="{{ $review->product->name }}" 
                         class="product-image">
                    @endif
                    <div class="product-info">
                        <div class="product-name">{{ $review->product->name }}</div>
                        <div class="order-date">{{ $review->created_at->format('d M Y') }}</div>
                    </div>
                </div>

                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star star {{ $i <= $review->rating ? '' : 'empty' }}"></i>
                    @endfor
                </div>

                @if($review->comment)
                <div class="review-comment">{{ $review->comment }}</div>
                @endif

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="review-date">{{ $review->created_at->diffForHumans() }}</div>
                    <button class="delete-btn" onclick="deleteReview({{ $review->id }})">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div style="margin-top: 20px;">
                {{ $reviews->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="far fa-star"></i>
            </div>
            <div class="empty-title">Belum Ada Ulasan</div>
            <div class="empty-text">Yuk, beli produk dan berikan ulasanmu!</div>
            <a href="{{ route('home') }}" class="btn-browse">
                <i class="fas fa-shopping-bag"></i> Mulai Belanja
            </a>
        </div>
    @endif

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('home') }}" class="nav-item">
            <i class="fas fa-home nav-icon"></i>
            <span class="nav-label">Beranda</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-fire nav-icon"></i>
            <span class="nav-label">Trending</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-play-circle nav-icon"></i>
            <span class="nav-label">Live & Video</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-bell nav-icon"></i>
            <span class="nav-label">Notifikasi</span>
        </a>
        <a href="{{ route('profile') }}" class="nav-item">
            <i class="fas fa-user nav-icon"></i>
            <span class="nav-label">Saya</span>
        </a>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast"></div>

    <script>
        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        async function deleteReview(reviewId) {
            if (!confirm('Yakin ingin menghapus ulasan ini?')) return;

            try {
                const response = await fetch(`/reviews/${reviewId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showToast('Ulasan berhasil dihapus');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast('Gagal menghapus ulasan');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan');
            }
        }
    </script>
</body>
</html>
