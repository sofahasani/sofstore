<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard Produk'); ?></title>
    <!-- Tailwind CSS CDN -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.7s cubic-bezier(.4,0,.2,1), transform 0.7s cubic-bezier(.4,0,.2,1);
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        /* Random label badges (used by product cards) */
        .random-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 999px;
            color: white;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        }
        .badge-ori { background: linear-gradient(90deg,#16a34a,#34d399); }
        .badge-mall { background: linear-gradient(90deg,#2563eb,#60a5fa); }
        .badge-flash { background: linear-gradient(90deg,#ff6b00,#ff3b30); }
        .badge-limited { background: linear-gradient(90deg,#7c3aed,#d8b4fe); color:#111; }
        .badge-new { background: linear-gradient(90deg,#06b6d4,#67e8f9); color:#053; }
        .badge-bestseller { background: linear-gradient(90deg,#f59e0b,#fbbf24); color:#111; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full z-30 glass flex items-center justify-between px-6 py-3 shadow-lg">
        <div class="flex items-center gap-2">
            <span class="text-xl font-semibold text-blue-700 tracking-wide">Product CRUD</span>
        </div>
        <div class="flex gap-4">
            <a href="/" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Home</a>
            <a href="/products" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Produk</a>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="flex-1 flex items-center justify-center pt-24 pb-16 px-2">
        <div class="glass w-full max-w-4xl mx-auto p-6 md:p-10 fade-in">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full glass fixed bottom-0 left-0 z-20 flex items-center justify-center py-3 px-6 text-sm text-gray-500 shadow-lg">
        <span>&copy; <?php echo e(date('Y')); ?> Product CRUD - Elegant Glassmorphism UI by Wahab</span>
    </footer>

    <!-- Fade-in Animation Script -->
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.fade-in').forEach(function(el) {
                setTimeout(function() {
                    el.classList.add('visible');
                }, 100);
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\projectwahab\resources\views/layouts/app.blade.php ENDPATH**/ ?>