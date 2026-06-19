@extends('layouts.admin')

@section('title', 'Laporan')

@section('additional-css')
<style>
.card-stat {
    background: #1c1c2d;
    border: 1px solid rgba(46, 46, 72, 0.4);
    border-radius: 0.75rem;
    padding: 20px 24px;
    transition: all 0.2s;
}
.card-stat:hover { border-color: rgba(99, 102, 241, 0.3); }

.chart-card {
    background: #1c1c2d;
    border: 1px solid rgba(46, 46, 72, 0.4);
    border-radius: 0.75rem;
    padding: 24px;
}

.tbl-wrapper {
    background: #1c1c2d;
    border: 1px solid rgba(46, 46, 72, 0.4);
    border-radius: 0.75rem;
    overflow: hidden;
}
.tbl-wrapper table { width: 100%; border-collapse: collapse; }
.tbl-wrapper thead { background: rgba(46, 46, 72, 0.3); }
.tbl-wrapper th {
    padding: 12px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #64748b;
}
.tbl-wrapper td {
    padding: 12px 16px;
    font-size: 13px;
    color: #cbd5e1;
    border-top: 1px solid rgba(46, 46, 72, 0.3);
}
.tbl-wrapper tbody tr { transition: background 0.15s; }
.tbl-wrapper tbody tr:hover { background: rgba(99, 102, 241, 0.04); }

.filter-select {
    background: #121220;
    border: 1px solid rgba(46,46,72,0.4);
    border-radius: 0.5rem;
    padding: 9px 14px;
    color: #cbd5e1;
    font-size: 13px;
    outline: none;
    cursor: pointer;
    transition: border-color 0.2s;
}
.filter-select:focus { border-color: rgba(99,102,241,0.5); }
.filter-select option { background: #1c1c2d; }

.filter-input {
    background: #121220;
    border: 1px solid rgba(46,46,72,0.4);
    border-radius: 0.5rem;
    padding: 9px 14px;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
    caret-color: #6366f1;
}
.filter-input:focus { border-color: rgba(99,102,241,0.5); }
.filter-input::-webkit-calendar-picker-indicator { filter: invert(1); }

.btn-filter {
    padding: 9px 20px;
    border-radius: 0.5rem;
    font-size: 13px;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
    border: none;
    cursor: pointer;
    transition: opacity 0.15s;
}
.btn-filter:hover { opacity: 0.9; }

.chart-toggle {
    display: inline-flex;
    background: #121220;
    border: 1px solid rgba(46,46,72,0.4);
    border-radius: 0.5rem;
    overflow: hidden;
}
.chart-toggle button {
    padding: 7px 16px;
    font-size: 12px;
    font-weight: 500;
    color: #64748b;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.15s;
}
.chart-toggle button.active {
    background: rgba(99,102,241,0.15);
    color: #818cf8;
}

.badge-status-laporan {
    display: inline-flex;
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 600;
}
.bs-menunggu       { background: rgba(59,130,246,0.12); color: #60a5fa; }
.bs-dikonfirmasi{ background: rgba(168,85,247,0.12); color: #c084fc; }
.bs-dikemas     { background: rgba(234,179,8,0.12); color: #facc15; }
.bs-dikirim     { background: rgba(6,182,212,0.12); color: #22d3ee; }
.bs-diperjalanan{ background: rgba(249,115,22,0.12); color: #fb923c; }
.bs-selesai     { background: rgba(34,197,94,0.12); color: #4ade80; }
.bs-dibatalkan  { background: rgba(239,68,68,0.12); color: #f87171; }

.no-data { padding: 40px 20px; text-align: center; color: #475569; font-size: 13px; }
#customRange { display: none; }
#customRange.show { display: flex; }
</style>
@endsection

@section('content')
<div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">  

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-white">Laporan</h1>
            <p class="text-[12px] text-slate-500 mt-1">{{ $labelPeriode }}</p>
        </div>
    </div>

    <div class="flex flex-wrap items-end gap-3 mb-6">
        <div>
            <label class="block text-[11px] text-slate-500 font-medium mb-1.5 uppercase tracking-wider">Periode</label>
            <select class="filter-select" id="filterPeriode" onchange="toggleCustom()">
                <option value="hari_ini" {{ $periode === 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu_ini" {{ $periode === 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan_ini" {{ $periode === 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="bulan_lalu" {{ $periode === 'bulan_lalu' ? 'selected' : '' }}>Bulan Lalu</option>
                <option value="tahun_ini" {{ $periode === 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                <option value="custom" {{ $periode === 'custom' ? 'selected' : '' }}>Custom</option>
            </select>
        </div>
        <div id="customRange" class="{{ $periode === 'custom' ? 'show' : '' }} items-end gap-3">
            <div>
                <label class="block text-[11px] text-slate-500 font-medium mb-1.5 uppercase tracking-wider">Dari</label>
                <input type="date" class="filter-input" id="filterDari" value="{{ $dari ?? '' }}"/>
            </div>
            <div>
                <label class="block text-[11px] text-slate-500 font-medium mb-1.5 uppercase tracking-wider">Sampai</label>
                <input type="date" class="filter-input" id="filterSampai" value="{{ $sampai ?? '' }}"/>
            </div>
        </div>
        <button class="btn-filter" onclick="applyFilter()">
            <span class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">filter_list</span>
                Terapkan
            </span>
        </button>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="card-stat">
            <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">Total Pendapatan</p>
            <p class="text-2xl font-bold text-emerald-400 mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="card-stat">
            <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">Total Pesanan</p>
            <p class="text-2xl font-bold text-white mt-2">{{ number_format($totalPesanan) }}</p>
        </div>
        <div class="card-stat">
            <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">Pesanan Selesai</p>
            <p class="text-2xl font-bold text-indigo-400 mt-2">{{ number_format($pesananSelesai) }}</p>
        </div>
        <div class="card-stat">
            <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">Pesanan Dibatalkan</p>
            <p class="text-2xl font-bold text-red-400 mt-2">{{ number_format($pesananDibatalkan) }}</p>
        </div>
    </div>

    <div class="chart-card mb-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-[14px] font-semibold text-white">Grafik Penjualan</h2>
            <div class="flex items-center gap-3">
                <div class="chart-toggle">
                    <button class="active" id="btnBulanan" onclick="loadChart('bulanan')">Bulanan</button>
                    <button id="btnHarian" onclick="loadChart('harian')">Harian (30 hari)</button>
                </div>
                <select class="filter-select" id="filterTahun" onchange="loadChart('bulanan')" style="padding:7px 10px;font-size:12px;">
                    @for($y = now()->year; $y >= now()->year - 2; $y--)
                    <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div style="height:300px;position:relative;">
            <canvas id="salesChart"></canvas>
        </div>
        <div class="flex items-center justify-center gap-6 mt-4">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-sm" style="background:#818cf8"></span>
                <span class="text-[12px] text-slate-400">Pendapatan (Rp)</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-sm" style="background:#22d3ee"></span>
                <span class="text-[12px] text-slate-400">Jumlah Pesanan</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="tbl-wrapper">
            <div class="px-5 py-4 border-b border-outline-variant/20">
                <h2 class="text-[14px] font-semibold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-400 text-[18px]">trending_up</span>
                    Produk Terlaris
                </h2>
            </div>
            <table>
                <thead><tr><th>#</th><th>Produk</th><th class="text-right">Qty Terjual</th><th class="text-right">Pendapatan</th></tr></thead>
                <tbody>
                    @forelse($produkTerlaris as $i => $p)
                    <tr>
                        <td class="text-slate-500">{{ $i + 1 }}</td>
                        <td class="font-medium text-white">{{ $p['name'] }}</td>
                        <td class="text-right">{{ $p['qty'] }}</td>
                        <td class="text-right text-emerald-400">Rp {{ number_format($p['revenue'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="no-data">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="tbl-wrapper">
            <div class="px-5 py-4 border-b border-outline-variant/20">
                <h2 class="text-[14px] font-semibold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-400 text-[18px]">pie_chart</span>
                    Pesanan Per Status
                </h2>
            </div>
            <table>
                <thead><tr><th>Status</th><th class="text-right">Jumlah</th><th class="text-right">Persentase</th></tr></thead>
                <tbody>
                    @forelse($pesananPerStatus as $ps)
                    <tr>
                        <td>
                            <span class="badge-status-laporan bs-{{ $ps->status }}">
                                {{ ucfirst(str_replace('_', ' ', $ps->status)) }}
                            </span>
                        </td>
                        <td class="text-right font-medium text-white">{{ $ps->total }}</td>
                        <td class="text-right text-slate-400">{{ $totalPesanan > 0 ? round(($ps->total / $totalPesanan) * 100, 1) : 0 }}%</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="no-data">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($pesananPerStatus->count() > 0)
            <div class="px-5 py-3 border-t border-outline-variant/20">
                <div class="flex items-center gap-2 h-3 rounded-full overflow-hidden bg-[#121220]">
                    @foreach($pesananPerStatus as $ps)
                    @php
                    $pct = $totalPesanan > 0 ? ($ps->total / $totalPesanan) * 100 : 0;
                    $colors = ['masuk'=>'#3b82f6','dikonfirmasi'=>'#a855f7','dikemas'=>'#eab308','dikirim'=>'#06b6d4','diperjalanan'=>'#f97316','selesai'=>'#22c55e','dibatalkan'=>'#ef4444'];
                    $color = $colors[$ps->status] ?? '#64748b';
                    @endphp
                    <div style="width:{{ $pct }}%;background:{{ $color }};min-width:4px;" title="{{ ucfirst($ps->status) }}: {{ round($pct,1) }}%"></div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('additional-js')
// === PEMAKSAAN SCROLL VIA JS (Mengatasi bug Chart.js vs Flexbox) ===
function forceScrollFix() {
    var main = document.querySelector('main');
    if (!main) return;
    
    // 1. Paksa main persis setinggi layar, tidak lebih
    main.style.setProperty('height', '100vh', 'important');
    main.style.setProperty('min-height', '0', 'important');
    main.style.setProperty('max-height', '100vh', 'important');
    main.style.setProperty('overflow', 'hidden', 'important');

    // 2. Cari div content area (anak ke-2 dari main, setelah header)
    var kids = main.children;
    for (var i = 0; i < kids.length; i++) {
        if (kids[i].classList.contains('flex-1')) {
            kids[i].style.setProperty('min-height', '0', 'important');
            kids[i].style.setProperty('flex', '1 1 0%', 'important');
            kids[i].style.setProperty('overflow-y', 'auto', 'important');
        }
    }
}

// Jalankan beberapa kali (karena Chart.js load asynchronously dan merusak layout)
setTimeout(forceScrollFix, 0);
setTimeout(forceScrollFix, 100);
setTimeout(forceScrollFix, 500);
setTimeout(forceScrollFix, 1000);

// Chart.js CDN
var s = document.createElement('script');
s.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js';
document.head.appendChild(s);
s.onload = function(){ 
    loadChart('bulanan'); 
    // Jalankan fix lagi setelah chart selesai render
    setTimeout(forceScrollFix, 200); 
};

var salesChart = null;

function loadChart(tipe) {
    document.getElementById('btnBulanan').classList.toggle('active', tipe === 'bulanan');
    document.getElementById('btnHarian').classList.toggle('active', tipe === 'harian');

    var tahun = document.getElementById('filterTahun').value;
    var url = '{{ route("admin.laporan.chart") }}?tipe=' + tipe + '&tahun=' + tahun;

    fetch(url)
        .then(function(r){ return r.json() })
        .then(function(res) {
            var ctx = document.getElementById('salesChart').getContext('2d');
            if (salesChart) salesChart.destroy();

            salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: res.labels,
                    datasets: [
                        {
                            label: 'Pendapatan',
                            data: res.data.map(function(d){ return d.pendapatan }),
                            backgroundColor: 'rgba(129, 140, 248, 0.3)',
                            borderColor: '#818cf8',
                            borderWidth: 2,
                            borderRadius: 6,
                            yAxisID: 'y',
                            order: 2
                        },
                        {
                            label: 'Pesanan',
                            data: res.data.map(function(d){ return d.pesanan }),
                            type: 'line',
                            borderColor: '#22d3ee',
                            backgroundColor: 'rgba(34, 211, 238, 0.1)',
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: '#22d3ee',
                            tension: 0.3,
                            yAxisID: 'y1',
                            order: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1c1c2d',
                            borderColor: 'rgba(46,46,72,0.5)',
                            borderWidth: 1,
                            titleColor: '#e2e8f0',
                            bodyColor: '#94a3b8',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(ctx) {
                                    if (ctx.dataset.label === 'Pendapatan') return 'Pendapatan: Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                    return 'Pesanan: ' + ctx.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { color: 'rgba(46,46,72,0.2)' }, ticks: { color: '#64748b', font: { size: 11 } } },
                        y: {
                            position: 'left',
                            grid: { color: 'rgba(46,46,72,0.2)' },
                            ticks: {
                                color: '#64748b', font: { size: 11 },
                                callback: function(v) {
                                    if (v >= 1000000) return 'Rp ' + (v / 1000000).toFixed(1) + 'jt';
                                    if (v >= 1000) return 'Rp ' + (v / 1000).toFixed(0) + 'rb';
                                    return 'Rp ' + v;
                                }
                            }
                        },
                        y1: { position: 'right', grid: { display: false }, ticks: { color: '#64748b', font: { size: 11 }, stepSize: 1 } }
                    }
                }
            });
            
            // Fix scroll setelah chart selesai digambar
            setTimeout(forceScrollFix, 100);
        });
}

function toggleCustom() {
    var v = document.getElementById('filterPeriode').value;
    var cr = document.getElementById('customRange');
    if (v === 'custom') { cr.classList.add('show'); } 
    else { cr.classList.remove('show'); applyFilter(); }
}

function applyFilter() {
    var periode = document.getElementById('filterPeriode').value;
    var params = new URLSearchParams();
    params.set('periode', periode);
    if (periode === 'custom') {
        params.set('dari', document.getElementById('filterDari').value);
        params.set('sampai', document.getElementById('filterSampai').value);
    }
    window.location.href = '{{ route("admin.laporan") }}?' + params.toString();
}
@endsection