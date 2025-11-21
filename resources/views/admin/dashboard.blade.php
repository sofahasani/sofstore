@extends('admin.layouts.admin')

@section('page-title', 'Dashboard Overview')

@section('content')
<div class="dashboard-content">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="card stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Total Penjualan Hari Ini</div>
                    <div class="stat-value" id="dailySales">0</div>
                    <div class="stat-change" style="opacity: 0.5;">Real-time data</div>
                </div>
                <div class="stat-icon gold">💰</div>
            </div>
        </div>

        <div class="card stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Revenue Bulan Ini</div>
                    <div class="stat-value" id="monthlyRevenue">Rp 0</div>
                    <div class="stat-change" style="opacity: 0.5;">Real-time data</div>
                </div>
                <div class="stat-icon orange">📈</div>
            </div>
        </div>

        <div class="card stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Pesanan Baru</div>
                    <div class="stat-value" id="newOrders">0</div>
                    <div class="stat-change" style="opacity: 0.5;">Real-time data</div>
                </div>
                <div class="stat-icon blue">🛍️</div>
            </div>
        </div>

        <div class="card stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-title">Produk Terjual</div>
                    <div class="stat-value" id="productsSold">0</div>
                    <div class="stat-change" style="opacity: 0.5;">Real-time data</div>
                </div>
                <div class="stat-icon green">📦</div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="charts-grid">
        <div class="card chart-card">
            <div class="chart-header">
                <div class="chart-title">Grafik Penjualan (7 Hari Terakhir)</div>
                <div class="chart-subtitle">Tren penjualan harian dalam seminggu terakhir</div>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="card chart-card">
            <div class="chart-header">
                <div class="chart-title">Top Kategori</div>
                <div class="chart-subtitle">5 kategori paling populer</div>
            </div>
            <div class="chart-container">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Products Table -->
    <div class="card table-card">
        <div class="chart-header">
            <div class="chart-title">Produk Terbaru</div>
            <div class="chart-subtitle">10 produk yang baru ditambahkan</div>
        </div>
        <table id="productsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Terjual</th>
                    <th>Dibuat</th>
                </tr>
            </thead>
            <tbody id="productsTableBody">
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px;">
                        <div class="skeleton" style="height: 20px; margin-bottom: 8px;"></div>
                        <div class="skeleton" style="height: 20px; margin-bottom: 8px;"></div>
                        <div class="skeleton" style="height: 20px;"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Fetch Stats
    fetch('/admin/stats')
        .then(res => res.json())
        .then(data => {
            document.getElementById('dailySales').textContent = data.dailySales;
            document.getElementById('monthlyRevenue').textContent = data.monthlyRevenue;
            document.getElementById('newOrders').textContent = data.newOrders;
            document.getElementById('productsSold').textContent = data.productsSold;
        })
        .catch(err => console.error('Error fetching stats:', err));

    // Sales Chart (Line Chart)
    let salesChart;
    fetch('/admin/sales-chart')
        .then(res => res.json())
        .then(data => {
            const ctx = document.getElementById('salesChart').getContext('2d');
            salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: data.data,
                        borderColor: '#D4AF37',
                        backgroundColor: 'rgba(212, 175, 55, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#D4AF37',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleColor: '#D4AF37',
                            bodyColor: '#fff',
                            borderColor: '#D4AF37',
                            borderWidth: 1,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000) + 'K';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        })
        .catch(err => console.error('Error fetching sales chart:', err));

    // Category Chart (Bar Chart)
    let categoryChart;
    fetch('/admin/top-categories')
        .then(res => res.json())
        .then(data => {
            const ctx = document.getElementById('categoryChart').getContext('2d');
            categoryChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Jumlah Produk',
                        data: data.data,
                        backgroundColor: [
                            'rgba(212, 175, 55, 0.8)',
                            'rgba(255, 115, 0, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                        ],
                        borderRadius: 8,
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        })
        .catch(err => console.error('Error fetching category chart:', err));

    // Recent Products Table
    fetch('/admin/recent-products')
        .then(res => res.json())
        .then(products => {
            const tbody = document.getElementById('productsTableBody');
            tbody.innerHTML = '';
            
            if (products.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px; opacity: 0.6;">Belum ada produk</td></tr>';
                return;
            }

            products.forEach(product => {
                const statusBadge = product.status === 'Aktif' 
                    ? '<span class="badge success">Aktif</span>' 
                    : '<span class="badge danger">Nonaktif</span>';
                
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>#${product.id}</td>
                    <td><strong>${product.name}</strong></td>
                    <td>${product.category}</td>
                    <td>${product.price}</td>
                    <td>${product.stock}</td>
                    <td>${statusBadge}</td>
                    <td>${product.total_sold}</td>
                    <td>${product.created_at}</td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(err => console.error('Error fetching products:', err));
</script>
@endpush
