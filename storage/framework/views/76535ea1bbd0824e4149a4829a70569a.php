<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Pengaturan Akun</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }

        .settings-container {
            max-width: 600px;
            margin: 0 auto;
            min-height: 100vh;
            background: white;
        }

        /* Header */
        .settings-header {
            background: linear-gradient(135deg, #ee4d2d 0%, #ff6b35 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .back-btn {
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .back-btn:hover {
            transform: scale(1.1);
        }

        .settings-header h1 {
            font-size: 18px;
            font-weight: 600;
        }

        /* Tabs */
        .tabs-container {
            display: flex;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            overflow-x: auto;
            position: sticky;
            top: 51px;
            z-index: 99;
        }

        .tabs-container::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            flex: 1;
            min-width: 120px;
            padding: 15px 10px;
            border: none;
            background: white;
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .tab-btn.active {
            color: #ee4d2d;
            border-bottom-color: #ee4d2d;
            font-weight: 600;
        }

        .tab-btn:hover {
            background: #f9fafb;
        }

        /* Tab Content */
        .tab-content {
            display: none;
            padding: 20px;
        }

        .tab-content.active {
            display: block;
        }

        /* Settings Group */
        .settings-group {
            margin-bottom: 25px;
        }

        .settings-group h3 {
            font-size: 16px;
            color: #374151;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .setting-item {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s;
        }

        .setting-item:hover {
            border-color: #ee4d2d;
            box-shadow: 0 2px 8px rgba(238, 77, 45, 0.1);
        }

        .setting-info {
            flex: 1;
        }

        .setting-label {
            font-size: 14px;
            font-weight: 500;
            color: #111827;
            margin-bottom: 4px;
        }

        .setting-desc {
            font-size: 12px;
            color: #6b7280;
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            width: 50px;
            height: 26px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: 0.4s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: #ee4d2d;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(24px);
        }

        /* Form Input */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #ee4d2d;
            box-shadow: 0 0 0 3px rgba(238, 77, 45, 0.1);
        }

        /* Buttons */
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ee4d2d 0%, #ff6b35 100%);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(238, 77, 45, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }

        /* Address Card */
        .address-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            position: relative;
        }

        .address-card.default {
            border-color: #ee4d2d;
            background: #fff5f3;
        }

        .default-badge {
            display: inline-block;
            background: #ee4d2d;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .address-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        /* Payment Card */
        .payment-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 20px;
            color: white;
            margin-bottom: 15px;
            position: relative;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .payment-card-number {
            font-size: 18px;
            letter-spacing: 2px;
            margin: 15px 0;
            font-weight: 500;
        }

        .payment-card-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 50px;
            margin-bottom: 15px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 16px;
            margin-bottom: 8px;
            color: #6b7280;
        }

        .empty-state p {
            font-size: 14px;
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            display: none;
            z-index: 1000;
            animation: slideUp 0.3s ease-out;
        }

        .toast.show {
            display: block;
        }

        @keyframes slideUp {
            from {
                transform: translateX(-50%) translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="settings-container">
        <!-- Header -->
        <div class="settings-header">
            <i class="fas fa-arrow-left back-btn" onclick="window.location.href='<?php echo e(route('profile')); ?>'"></i>
            <h1>Pengaturan Akun</h1>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('account')">
                <i class="fas fa-user"></i> Akun
            </button>
            <button class="tab-btn" onclick="switchTab('address')">
                <i class="fas fa-map-marker-alt"></i> Alamat
            </button>
            <button class="tab-btn" onclick="switchTab('payment')">
                <i class="fas fa-credit-card"></i> Pembayaran
            </button>
            <button class="tab-btn" onclick="switchTab('notification')">
                <i class="fas fa-bell"></i> Notifikasi
            </button>
            <button class="tab-btn" onclick="switchTab('privacy')">
                <i class="fas fa-shield-alt"></i> Privasi
            </button>
        </div>

        <!-- Account Tab -->
        <div class="tab-content active" id="accountTab">
            <div class="settings-group">
                <h3>Informasi Pribadi</h3>
                <form id="accountForm">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-input" value="<?php echo e(auth()->user()->name); ?>" name="name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" value="<?php echo e(auth()->user()->email); ?>" name="email">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-input" value="<?php echo e(auth()->user()->phone ?? ''); ?>" name="phone">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>

            <div class="settings-group">
                <h3>Keamanan</h3>
                <div class="setting-item" onclick="alert('Fitur ganti password segera hadir!')">
                    <div class="setting-info">
                        <div class="setting-label">Ganti Password</div>
                        <div class="setting-desc">Ubah password akun Anda</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color: #9ca3af;"></i>
                </div>
                <div class="setting-item" onclick="alert('Fitur verifikasi 2 langkah segera hadir!')">
                    <div class="setting-info">
                        <div class="setting-label">Verifikasi 2 Langkah</div>
                        <div class="setting-desc">Tingkatkan keamanan akun</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color: #9ca3af;"></i>
                </div>
            </div>
        </div>

        <!-- Address Tab -->
        <div class="tab-content" id="addressTab">
            <div class="settings-group">
                <h3>Alamat Pengiriman</h3>
                
                <?php if(auth()->user()->address): ?>
                    <div class="address-card default">
                        <span class="default-badge">Utama</span>
                        <div style="font-weight: 600; margin-bottom: 5px;"><?php echo e(auth()->user()->name); ?></div>
                        <div style="font-size: 14px; color: #6b7280; margin-bottom: 5px;">
                            <?php echo e(auth()->user()->phone); ?>

                        </div>
                        <div style="font-size: 14px; color: #374151; line-height: 1.6;">
                            <?php echo e(auth()->user()->address); ?>

                        </div>
                        <div class="address-actions">
                            <button class="btn btn-secondary" style="flex: 1;" onclick="alert('Fitur edit alamat segera hadir!')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Belum Ada Alamat</h3>
                        <p>Tambahkan alamat pengiriman Anda</p>
                        <button class="btn btn-primary" style="margin-top: 15px;" onclick="alert('Fitur tambah alamat segera hadir!')">
                            <i class="fas fa-plus"></i> Tambah Alamat
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Payment Tab -->
        <div class="tab-content" id="paymentTab">
            <div class="settings-group">
                <h3>Metode Pembayaran</h3>
                
                <div class="empty-state">
                    <i class="fas fa-credit-card"></i>
                    <h3>Belum Ada Kartu Tersimpan</h3>
                    <p>Tambahkan kartu untuk pembayaran lebih cepat</p>
                    <button class="btn btn-primary" style="margin-top: 15px;" onclick="alert('Fitur tambah kartu segera hadir!')">
                        <i class="fas fa-plus"></i> Tambah Kartu
                    </button>
                </div>
            </div>

            <div class="settings-group">
                <h3>Rekening Bank</h3>
                <div class="empty-state">
                    <i class="fas fa-university"></i>
                    <h3>Belum Ada Rekening</h3>
                    <p>Tambahkan rekening untuk menerima refund</p>
                    <button class="btn btn-primary" style="margin-top: 15px;" onclick="alert('Fitur tambah rekening segera hadir!')">
                        <i class="fas fa-plus"></i> Tambah Rekening
                    </button>
                </div>
            </div>
        </div>

        <!-- Notification Tab -->
        <div class="tab-content" id="notificationTab">
            <div class="settings-group">
                <h3>Notifikasi Push</h3>
                
                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Promo & Diskon</div>
                        <div class="setting-desc">Dapatkan update promo terbaru</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked onchange="saveNotificationSetting('promo', this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Status Pesanan</div>
                        <div class="setting-desc">Update pengiriman & pesanan</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked onchange="saveNotificationSetting('order', this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Chat & Pesan</div>
                        <div class="setting-desc">Notifikasi pesan baru</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked onchange="saveNotificationSetting('chat', this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <div class="settings-group">
                <h3>Notifikasi Email</h3>
                
                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Newsletter</div>
                        <div class="setting-desc">Berita & tips belanja</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" onchange="saveNotificationSetting('newsletter', this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Ringkasan Pesanan</div>
                        <div class="setting-desc">Email invoice & resi</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked onchange="saveNotificationSetting('invoice', this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Privacy Tab -->
        <div class="tab-content" id="privacyTab">
            <div class="settings-group">
                <h3>Privasi Akun</h3>
                
                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Profil Publik</div>
                        <div class="setting-desc">Tampilkan profil di pencarian</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked onchange="savePrivacySetting('public_profile', this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Tampilkan Review</div>
                        <div class="setting-desc">Ulasan saya bisa dilihat publik</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked onchange="savePrivacySetting('public_reviews', this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <div class="setting-label">Rekomendasi Personal</div>
                        <div class="setting-desc">Gunakan data untuk rekomendasi</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked onchange="savePrivacySetting('personalization', this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>

            <div class="settings-group">
                <h3>Data & Histori</h3>
                
                <div class="setting-item" onclick="alert('Histori berhasil dihapus!')">
                    <div class="setting-info">
                        <div class="setting-label">Hapus Histori Pencarian</div>
                        <div class="setting-desc">Kosongkan riwayat pencarian</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color: #9ca3af;"></i>
                </div>

                <div class="setting-item" onclick="alert('Data cache berhasil dihapus!')">
                    <div class="setting-info">
                        <div class="setting-label">Hapus Cache</div>
                        <div class="setting-desc">Bebaskan ruang penyimpanan</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color: #9ca3af;"></i>
                </div>

                <div class="setting-item" onclick="if(confirm('Yakin ingin hapus akun?')) alert('Permintaan hapus akun sedang diproses')">
                    <div class="setting-info">
                        <div class="setting-label" style="color: #dc2626;">Hapus Akun</div>
                        <div class="setting-desc">Hapus akun & semua data</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color: #dc2626;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

    <script>
        // Switch Tab Function
        function switchTab(tabName) {
            // Remove active from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            // Add active to selected
            event.target.classList.add('active');
            document.getElementById(tabName + 'Tab').classList.add('active');
        }

        // Show Toast
        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Save Account Settings
        document.getElementById('accountForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            try {
                const response = await fetch('<?php echo e(route("profile.update")); ?>', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    showToast('✅ Perubahan berhasil disimpan!');
                } else {
                    showToast('❌ Gagal menyimpan perubahan');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('❌ Terjadi kesalahan');
            }
        });

        // Save Notification Settings
        function saveNotificationSetting(type, value) {
            showToast(`Notifikasi ${type} ${value ? 'diaktifkan' : 'dinonaktifkan'}`);
            // TODO: Send to backend to save setting
        }

        // Save Privacy Settings
        function savePrivacySetting(type, value) {
            showToast(`Pengaturan privasi ${type} ${value ? 'diaktifkan' : 'dinonaktifkan'}`);
            // TODO: Send to backend to save setting
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\projectwahab\resources\views/settings.blade.php ENDPATH**/ ?>