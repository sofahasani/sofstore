
<div id="reviewModal" class="review-modal" style="display: none;">
    <div class="review-modal-overlay" onclick="closeReviewModal()"></div>
    <div class="review-modal-content">
        <div class="review-modal-header">
            <h3 id="reviewModalTitle">Beri Ulasan Produk</h3>
            <button onclick="closeReviewModal()" class="modal-close-btn">×</button>
        </div>
        
        <form id="reviewModalForm" method="POST" action="<?php echo e(route('reviews.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="product_id" id="modalProductId">
            <input type="hidden" name="order_id" id="modalOrderId">
            <input type="hidden" name="rating" id="modalRatingInput" value="5">

            <div class="modal-rating-section">
                <label>Rating Produk</label>
                <div class="modal-star-rating">
                    <span class="modal-star" data-rating="1">★</span>
                    <span class="modal-star" data-rating="2">★</span>
                    <span class="modal-star" data-rating="3">★</span>
                    <span class="modal-star" data-rating="4">★</span>
                    <span class="modal-star" data-rating="5">★</span>
                </div>
            </div>

            <div class="modal-comment-section">
                <label for="modalComment">Ulasan Anda</label>
                <textarea name="comment" id="modalComment" rows="5" placeholder="Ceritakan pengalaman Anda dengan produk ini..." required></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" onclick="closeReviewModal()" class="btn-modal-cancel">Batal</button>
                <button type="submit" class="btn-modal-submit">Kirim Ulasan</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Review Modal Styles */
    .review-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .review-modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .review-modal-content {
        position: relative;
        background: white;
        border-radius: 20px;
        padding: 32px;
        max-width: 540px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .review-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .review-modal-header h3 {
        font-size: 22px;
        font-weight: 700;
        color: #1c1917;
        margin: 0;
    }

    .modal-close-btn {
        width: 36px;
        height: 36px;
        border: none;
        background: #f5f5f4;
        border-radius: 10px;
        font-size: 28px;
        color: #78716c;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        line-height: 1;
    }

    .modal-close-btn:hover {
        background: #e7e7e5;
        color: #1c1917;
        transform: rotate(90deg);
    }

    .modal-rating-section {
        margin-bottom: 24px;
    }

    .modal-rating-section label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #44403c;
        margin-bottom: 12px;
    }

    .modal-star-rating {
        display: flex;
        gap: 8px;
    }

    .modal-star {
        font-size: 36px;
        color: #fbbf24;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .modal-star:hover {
        transform: scale(1.15);
    }

    .modal-comment-section {
        margin-bottom: 24px;
    }

    .modal-comment-section label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #44403c;
        margin-bottom: 12px;
    }

    .modal-comment-section textarea {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e7e7e5;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        color: #1c1917;
        resize: vertical;
        transition: all 0.2s ease;
    }

    .modal-comment-section textarea:focus {
        outline: none;
        border-color: #1c1917;
        box-shadow: 0 0 0 3px rgba(28, 25, 23, 0.1);
    }

    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .btn-modal-cancel, .btn-modal-submit {
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-modal-cancel {
        background: #f5f5f4;
        color: #78716c;
    }

    .btn-modal-cancel:hover {
        background: #e7e7e5;
        color: #44403c;
    }

    .btn-modal-submit {
        background: #1c1917;
        color: white;
    }

    .btn-modal-submit:hover {
        background: #44403c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(28, 25, 23, 0.3);
    }

    @media (max-width: 768px) {
        .review-modal-content {
            padding: 24px;
            width: 95%;
        }

        .modal-star {
            font-size: 32px;
        }
    }
</style>

<script>
    // Review Modal Functions - Global scope
    window.openReviewModal = function(productId, orderId, productName) {
        document.getElementById('modalProductId').value = productId;
        document.getElementById('modalOrderId').value = orderId || '';
        document.getElementById('reviewModalTitle').textContent = 'Beri Ulasan: ' + productName;
        document.getElementById('reviewModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Reset form
        document.getElementById('modalComment').value = '';
        document.getElementById('modalRatingInput').value = '5';
        document.querySelectorAll('.modal-star').forEach(star => {
            star.style.color = '#fbbf24';
        });
    };

    window.closeReviewModal = function() {
        document.getElementById('reviewModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    // Modal Star Rating
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal-star').forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                document.getElementById('modalRatingInput').value = rating;
                
                document.querySelectorAll('.modal-star').forEach((s, index) => {
                    s.style.color = (index < rating) ? '#fbbf24' : '#e5e7eb';
                });
            });

            star.addEventListener('mouseenter', function() {
                const rating = this.dataset.rating;
                document.querySelectorAll('.modal-star').forEach((s, index) => {
                    s.style.color = (index < rating) ? '#fbbf24' : '#e5e7eb';
                });
            });
        });

        document.querySelector('.modal-star-rating')?.addEventListener('mouseleave', function() {
            const currentRating = document.getElementById('modalRatingInput').value;
            document.querySelectorAll('.modal-star').forEach((s, index) => {
                s.style.color = (index < currentRating) ? '#fbbf24' : '#e5e7eb';
            });
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('reviewModal').style.display === 'flex') {
                closeReviewModal();
            }
        });
    });
</script>
<?php /**PATH C:\laragon\www\projectwahab\resources\views/components/review-modal.blade.php ENDPATH**/ ?>