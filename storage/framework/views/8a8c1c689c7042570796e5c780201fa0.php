<?php if(session('error')): ?>
<div id="error-toast" class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 animate-slideIn" style="animation: slideIn 0.3s ease-out;">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium"><?php echo e(session('error')); ?></span>
    <button onclick="closeToast('error-toast')" class="ml-4 hover:bg-red-600 rounded-full p-1 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
<script>
setTimeout(() => {
    const toast = document.getElementById('error-toast');
    if(toast) {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }
}, 5000);
</script>
<?php endif; ?>

<?php if(session('success')): ?>
<div id="success-toast" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 animate-slideIn">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    <span class="font-medium"><?php echo e(session('success')); ?></span>
    <button onclick="closeToast('success-toast')" class="ml-4 hover:bg-green-600 rounded-full p-1 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
<script>
setTimeout(() => {
    const toast = document.getElementById('success-toast');
    if(toast) {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }
}, 5000);
</script>
<?php endif; ?>

<style>
@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(400px);
        opacity: 0;
    }
}
</style>

<script>
function closeToast(id) {
    const toast = document.getElementById(id);
    if(toast) {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }
}

// Check if user is authenticated - DATA REAL dari Laravel Session
const isAuthenticated = <?php echo e(auth()->check() ? 'true' : 'false'); ?>;

// Debug log untuk memastikan auth status
console.log('Auth Status (Real from Laravel):', isAuthenticated);
<?php if(auth()->check()): ?>
console.log('Logged in as:', '<?php echo e(auth()->user()->name); ?>', '(<?php echo e(auth()->user()->email); ?>)');
<?php else: ?>
console.log('User is GUEST (not logged in)');
<?php endif; ?>

// Function to handle buy/checkout actions
function handleBuyAction(url, event) {
    if (!isAuthenticated) {
        event.preventDefault();
        showLoginModal();
        return false;
    }
    return true;
}

// Show login modal with glassmorphism design - FIXED z-index for mobile & desktop
function showLoginModal() {
    // Create modal
    const modal = document.createElement('div');
    modal.id = 'login-modal';
    modal.className = 'login-modal-overlay';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        background: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease-out;
    `;
    
    modal.innerHTML = `
        <div class="glass-card" style="
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px 28px;
            animation: slideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            z-index: 100000;
        ">
            <!-- Icon -->
            <div style="text-align: center; margin-bottom: 28px;">
                <div style="
                    width: 80px;
                    height: 80px;
                    background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
                    border-radius: 20px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 20px;
                    box-shadow: 0 8px 24px rgba(255, 107, 53, 0.4);
                ">
                    <svg style="width: 42px; height: 42px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 style="
                    font-size: 24px;
                    font-weight: 700;
                    color: #1a1a1a;
                    margin-bottom: 10px;
                    letter-spacing: -0.5px;
                ">Kamu Belum Punya Akun</h3>
                <p style="
                    font-size: 15px;
                    color: #666;
                    line-height: 1.6;
                ">Login terlebih dahulu untuk<br>melanjutkan pembelian</p>
            </div>
            
            <!-- Buttons -->
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <a href="<?php echo e(route('login')); ?>" style="
                    display: block;
                    background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
                    color: white;
                    text-align: center;
                    font-weight: 600;
                    font-size: 16px;
                    padding: 16px 24px;
                    border-radius: 16px;
                    text-decoration: none;
                    box-shadow: 0 4px 20px rgba(255, 107, 53, 0.35);
                    transition: all 0.3s ease;
                    position: relative;
                    overflow: hidden;
                " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(255, 107, 53, 0.5)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(255, 107, 53, 0.35)'">
                    🔐 Masuk Sekarang
                </a>
                
                <a href="<?php echo e(route('register')); ?>" style="
                    display: block;
                    background: rgba(255, 255, 255, 0.9);
                    color: #333;
                    text-align: center;
                    font-weight: 600;
                    font-size: 16px;
                    padding: 16px 24px;
                    border-radius: 16px;
                    text-decoration: none;
                    border: 2px solid rgba(255, 107, 53, 0.25);
                    transition: all 0.3s ease;
                " onmouseover="this.style.background='rgba(255, 255, 255, 1)'; this.style.borderColor='rgba(255, 107, 53, 0.5)'; this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.background='rgba(255, 255, 255, 0.9)'; this.style.borderColor='rgba(255, 107, 53, 0.25)'; this.style.transform='translateY(0)'">
                    ✨ Buat Akun Baru
                </a>
                
                <button onclick="closeLoginModal()" style="
                    background: transparent;
                    color: #999;
                    text-align: center;
                    font-weight: 500;
                    font-size: 15px;
                    padding: 14px;
                    border: none;
                    border-radius: 12px;
                    cursor: pointer;
                    transition: all 0.2s ease;
                " onmouseover="this.style.color='#666'; this.style.background='rgba(0,0,0,0.05)'" 
                   onmouseout="this.style.color='#999'; this.style.background='transparent'">
                    Batal
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
    
    // Close on background click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeLoginModal();
        }
    });
    
    // Close on ESC key
    const escHandler = function(e) {
        if (e.key === 'Escape') {
            closeLoginModal();
            document.removeEventListener('keydown', escHandler);
        }
    };
    document.addEventListener('keydown', escHandler);
}

// Close login modal
function closeLoginModal() {
    const modal = document.getElementById('login-modal');
    if (modal) {
        const card = modal.querySelector('.glass-card');
        card.style.animation = 'slideDown 0.3s ease-out';
        modal.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => {
            modal.remove();
            document.body.style.overflow = '';
        }, 300);
    }
}
</script>

<style>
/* Modal Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}

@keyframes slideUp {
    from {
        transform: translateY(40px) scale(0.95);
        opacity: 0;
    }
    to {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
}

@keyframes slideDown {
    from {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
    to {
        transform: translateY(40px) scale(0.95);
        opacity: 0;
    }
}

/* Login Modal Overlay - HIGHEST z-index */
.login-modal-overlay {
    position: fixed !important;
    z-index: 99999 !important;
}

/* Glass Card Styling */
.glass-card {
    position: relative;
    z-index: 100000 !important;
}

/* Mobile Responsive - Optimized for all screens */
@media (max-width: 640px) {
    .glass-card {
        max-width: 95% !important;
        padding: 32px 20px !important;
        margin: 0 auto;
    }
    
    .glass-card h3 {
        font-size: 20px !important;
    }
    
    .glass-card p {
        font-size: 14px !important;
    }
    
    .glass-card a, .glass-card button {
        font-size: 15px !important;
        padding: 14px 20px !important;
    }
}

/* Tablet Responsive */
@media (min-width: 641px) and (max-width: 1024px) {
    .glass-card {
        max-width: 440px !important;
    }
}

/* Desktop Responsive */
@media (min-width: 1025px) {
    .glass-card {
        max-width: 460px !important;
    }
}

/* Support untuk backdrop-filter di berbagai browser */
@supports not (backdrop-filter: blur(20px)) {
    .glass-card {
        background: rgba(255, 255, 255, 0.98) !important;
    }
    
    .login-modal-overlay {
        background: rgba(0, 0, 0, 0.6) !important;
    }
}

/* Prevent body scroll when modal is open */
body.modal-open {
    overflow: hidden !important;
    position: fixed;
    width: 100%;
}
</style>
<?php /**PATH C:\laragon\www\projectwahab\resources\views/components/auth-check.blade.php ENDPATH**/ ?>