@extends('layouts.app')

@section('title', 'Manajemen Merek')

@section('styles')
<style>
    :root {
        --bg:#f4f7f5; --fg:#1a2e22; --muted:#6b8072;
        --accent:#16a34a; --accent-hover:#15803c;
        --card:#ffffff; --border:#dce5df;
    }
    body { background:var(--bg); color:var(--fg); }
    body::before {
        content:''; position:fixed; inset:0; z-index:-1; pointer-events:none;
        background-image:
            radial-gradient(circle at 20% 20%, rgba(22,163,74,0.04) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(22,163,74,0.03) 0%, transparent 50%);
    }
    ::-webkit-scrollbar { width:6px; height:6px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#c5d7cc; border-radius:999px; }

    @keyframes slideUp {
        from { opacity:0; transform:translateY(18px); }
        to { opacity:1; transform:translateY(0); }
    }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    .anim-slide-up { animation:slideUp .5s cubic-bezier(.22,1,.36,1) both; }
    .anim-fade { animation:fadeIn .35s ease both; }

    .row-hover { transition:background .15s, box-shadow .15s; }
    .row-hover:hover { background:#f0fdf6; box-shadow:inset 3px 0 0 var(--accent); }

    .btn-act { transition:all .2s cubic-bezier(.22,1,.36,1); }
    .btn-act:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(0,0,0,.1); }
    .btn-act:active { transform:translateY(0); }

    .inp-focus { transition:border-color .2s, box-shadow .2s; }
    .inp-focus:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(22,163,74,.12); outline:none; }

    .upload-zone { transition:all .2s; border:2px dashed var(--border); }
    .upload-zone:hover, .upload-zone.drag-over { border-color:var(--accent); background:#f0fdf6; }

    @keyframes toastIn { from{opacity:0;transform:translateX(100%) scale(.95)} to{opacity:1;transform:translateX(0) scale(1)} }
    @keyframes toastOut { from{opacity:1;transform:translateX(0) scale(1)} to{opacity:0;transform:translateX(100%) scale(.95)} }
    .toast-in { animation:toastIn .35s cubic-bezier(.22,1,.36,1) forwards; }
    .toast-out { animation:toastOut .25s ease forwards; }

    .modal-bg { transition:opacity .2s; }
    .modal-box { transition:transform .25s cubic-bezier(.22,1,.36,1), opacity .2s; }

    @media (prefers-reduced-motion:reduce) {
        *, *::before, *::after { animation-duration:0.01ms!important; transition-duration:0.01ms!important; }
    }
</style>
@endsection

@section('content')
<!-- Header -->
<header class="sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-panel-border">
    <div class="max-w-[1400px] mx-auto px-8 py-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-surface-500">
                <span class="hover:text-brand-600 transition-colors cursor-default">Dashboard</span>
                <i class="fa-solid fa-chevron-right text-[9px] text-surface-300"></i>
                <span class="text-surface-800 font-medium">Data Merek</span>
            </div>
            <h2 class="text-xl font-bold text-surface-900 mt-0.5">Manajemen Merek</h2>
        </div>
        <div class="relative">
            <input type="text" id="searchInput" placeholder="Cari merek..." class="inp-focus w-60 pl-9 pr-4 py-2.5 text-sm bg-surface-50 border border-panel-border rounded-xl font-medium placeholder:text-surface-400" aria-label="Cari merek">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-surface-400 text-xs"></i>
        </div>
    </div>
</header>

<!-- Konten Utama -->
<div class="max-w-[1400px] mx-auto p-8">
    <div class="flex gap-6 items-start">

        <!-- Tabel Data Merek -->
        <section class="flex-1 anim-slide-up" aria-label="Tabel Data Merek">
            <div class="bg-white rounded-2xl border border-panel-border shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-panel-border flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center">
                        <i class="fa-solid fa-database text-brand-600 text-xs"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-surface-900">Data Merek</h3>
                        <p class="text-[11px] text-surface-500 mt-0.5">Total <span id="brandCount" class="font-semibold text-brand-600">0</span> merek terdaftar</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full" role="table">
                        <thead>
                            <tr class="bg-surface-50/60">
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-surface-500 uppercase tracking-wider w-14">No.</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-surface-500 uppercase tracking-wider">Merek</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-surface-500 uppercase tracking-wider">Slug</th>
                                <th class="text-center px-6 py-3 text-[11px] font-semibold text-surface-500 uppercase tracking-wider w-24">Gambar</th>
                                <th class="text-center px-6 py-3 text-[11px] font-semibold text-surface-500 uppercase tracking-wider w-28">Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="brandTableBody">
                            <tr><td colspan="5" class="px-6 py-12 text-center">
                                <i class="fa-solid fa-spinner fa-spin text-2xl text-surface-300"></i>
                                <p class="text-sm text-surface-400 mt-2">Memuat data...</p>
                            </td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3.5 border-t border-panel-border bg-surface-50/40 flex items-center justify-between">
                    <p class="text-xs text-surface-500">Menampilkan <span class="font-semibold text-surface-700" id="showingCount">0</span> data</p>
                    <div class="flex items-center gap-1" id="pagination"></div>
                </div>
            </div>
        </section>

        <!-- Form Tambah Merek -->
        <aside class="w-96 flex-shrink-0 anim-slide-up" style="animation-delay:.08s" aria-label="Form Tambah Merek">
            <div class="bg-white rounded-2xl border border-panel-border shadow-sm overflow-hidden sticky top-24">
                <div class="px-6 py-4 border-b border-panel-border flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center shadow-sm shadow-brand-500/25">
                        <i class="fa-solid fa-plus text-white text-xs"></i>
                    </div>
                    <h3 class="text-sm font-bold text-surface-900">Tambah Merek</h3>
                </div>
                <form id="addBrandForm" class="p-6 space-y-5" novalidate>
                    <div>
                        <label for="brandName" class="block text-xs font-semibold text-surface-700 mb-1.5">Merek <span class="text-red-500">*</span></label>
                        <input type="text" id="brandName" placeholder="Masukkan nama merek" class="inp-focus w-full px-4 py-2.5 text-sm bg-surface-50 border border-panel-border rounded-xl font-medium placeholder:text-surface-400" required>
                        <p id="nameError" class="text-[11px] text-red-500 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Nama merek wajib diisi</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-surface-700 mb-1.5">Gambar <span class="text-red-500">*</span></label>
                        <div id="uploadZone" class="upload-zone rounded-xl p-5 flex flex-col items-center justify-center cursor-pointer bg-surface-50/50 min-h-[140px]" role="button" tabindex="0" aria-label="Unggah gambar">
                            <div id="uploadPlaceholder" class="text-center">
                                <div class="w-11 h-11 rounded-full bg-brand-50 flex items-center justify-center mx-auto mb-2.5">
                                    <i class="fa-solid fa-cloud-arrow-up text-brand-500 text-base"></i>
                                </div>
                                <p class="text-xs font-semibold text-surface-700">Klik atau seret gambar</p>
                                <p class="text-[11px] text-surface-400 mt-0.5">PNG, JPG, SVG (Maks. 2MB)</p>
                            </div>
                            <div id="uploadPreview" class="hidden w-full text-center">
                                <img id="previewImg" src="" alt="Preview" class="w-16 h-16 rounded-lg object-contain mx-auto mb-2 bg-surface-100 border border-panel-border p-1">
                                <p id="fileName" class="text-xs font-medium text-surface-700 truncate px-4"></p>
                                <button type="button" id="removeFile" class="text-[11px] text-red-500 font-semibold hover:text-red-600 mt-1.5 transition-colors"><i class="fa-solid fa-trash-can mr-0.5"></i>Hapus</button>
                            </div>
                        </div>
                        <input type="file" id="brandImage" accept="image/*" class="hidden">
                        <p id="imageError" class="text-[11px] text-red-500 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Gambar wajib diunggah</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-surface-700 mb-1.5">Slug Preview</label>
                        <div class="w-full px-4 py-2.5 text-sm bg-surface-100 border border-panel-border rounded-xl text-surface-500 font-medium truncate">
                            <span id="slugPreview" class="text-surface-600">—</span>
                        </div>
                    </div>
                    <button type="submit" id="submitBtn" class="btn-act w-full py-3 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl shadow-md shadow-brand-500/20 hover:shadow-lg hover:shadow-brand-500/30 transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus text-xs"></i>Tambah
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="modal-bg absolute inset-0 bg-black/40 backdrop-blur-sm" id="editOverlay"></div>
    <div class="modal-box absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-panel-border flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center"><i class="fa-solid fa-pen text-amber-500 text-xs"></i></div>
                <h3 class="text-sm font-bold text-surface-900">Edit Merek</h3>
            </div>
            <button id="closeEditBtn" class="btn-act w-8 h-8 rounded-lg hover:bg-surface-100 flex items-center justify-center text-surface-400 hover:text-surface-600" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editBrandForm" class="p-6 space-y-5" novalidate>
            <input type="hidden" id="editBrandId">
            <div>
                <label for="editBrandName" class="block text-xs font-semibold text-surface-700 mb-1.5">Merek <span class="text-red-500">*</span></label>
                <input type="text" id="editBrandName" class="inp-focus w-full px-4 py-2.5 text-sm bg-surface-50 border border-panel-border rounded-xl font-medium" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-surface-700 mb-1.5">Gambar Saat Ini</label>
                <img id="editCurrentImg" src="" alt="Gambar saat ini" class="w-16 h-16 rounded-lg object-contain bg-surface-100 border border-panel-border p-1">
            </div>
            <div>
                <label class="block text-xs font-semibold text-surface-700 mb-1.5">Ganti Gambar (Opsional)</label>
                <div id="editUploadZone" class="upload-zone rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer bg-surface-50/50" role="button" tabindex="0">
                    <p class="text-xs font-medium text-surface-500"><i class="fa-solid fa-cloud-arrow-up mr-1 text-surface-400"></i>Klik untuk ganti gambar</p>
                </div>
                <input type="file" id="editBrandImage" accept="image/*" class="hidden">
            </div>
            <div class="flex gap-3">
                <button type="button" id="cancelEditBtn" class="btn-act flex-1 py-2.5 bg-surface-100 hover:bg-surface-200 text-surface-700 text-sm font-semibold rounded-xl transition-colors">Batal</button>
                <button type="submit" class="btn-act flex-1 py-2.5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl shadow-sm shadow-brand-500/20 transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="modal-bg absolute inset-0 bg-black/40 backdrop-blur-sm" id="deleteOverlay"></div>
    <div class="modal-box absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4"><i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i></div>
            <h3 class="text-base font-bold text-surface-900 mb-1">Hapus Merek?</h3>
            <p class="text-sm text-surface-500">Merek <strong id="deleteBrandName" class="text-surface-700"></strong> akan dihapus permanen.</p>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="cancelDeleteBtn" class="btn-act flex-1 py-2.5 bg-surface-100 hover:bg-surface-200 text-surface-700 text-sm font-semibold rounded-xl transition-colors">Batal</button>
            <button id="confirmDeleteBtn" class="btn-act flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-xl shadow-sm shadow-red-500/20 transition-all">Hapus</button>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toastContainer" class="fixed top-6 right-6 z-[60] space-y-3 pointer-events-none"></div>
@endsection

@section('scripts')
<script>
// ============================================
// KONFIGURASI — Sesuaikan dengan route Laravel
// ============================================
const API = {
    list:   '{{ route("brands.list") }}',
    store:  '{{ route("brands.store") }}',
    show:   id => `{{ route("brands.show", "BRAND_ID") }}`.replace('BRAND_ID', id),
    update: id => `{{ route("brands.update", "BRAND_ID") }}`.replace('BRAND_ID', id),
    delete: id => `{{ route("brands.destroy", "BRAND_ID") }}`.replace('BRAND_ID', id),
};

// === State ===
let brands = [];
let currentPage = 1;
const PER_PAGE = 5;
let uploadedFile = null;
let editUploadedFile = null;
let deleteTargetId = null;

// === Utilitas ===
function toSlug(t) {
    return t.toLowerCase().trim().replace(/[^\w\s-]/g,'').replace(/[\s_]+/g,'-').replace(/^-+|-+$/g,'');
}

// === Toast ===
function showToast(msg, type = 'success') {
    const c = document.getElementById('toastContainer');
    const icons = { success:'fa-circle-check text-brand-500', error:'fa-circle-xmark text-red-500', info:'fa-circle-info text-sky-500' };
    const bdr   = { success:'border-brand-200', error:'border-red-200', info:'border-sky-200' };
    const el = document.createElement('div');
    el.className = `toast-in pointer-events-auto flex items-center gap-3 px-5 py-3.5 bg-white rounded-xl border ${bdr[type]} shadow-lg shadow-black/8 min-w-[280px]`;
    el.innerHTML = `<i class="fa-solid ${icons[type]} text-base"></i><span class="text-sm font-semibold text-surface-800 flex-1">${msg}</span><button class="text-surface-400 hover:text-surface-600 ml-2 close-toast" aria-label="Tutup"><i class="fa-solid fa-xmark text-xs"></i></button>`;
    c.appendChild(el);
    el.querySelector('.close-toast').onclick = () => dismissToast(el);
    setTimeout(() => dismissToast(el), 3500);
}
function dismissToast(el) {
    if (!el.parentElement) return;
    el.classList.replace('toast-in','toast-out');
    setTimeout(() => el.remove(), 250);
}

// ============================================
// AMBIL DATA DARI SERVER
// ============================================
async function fetchBrands(search = '') {
    try {
        const url = search ? `${API.list}?search=${encodeURIComponent(search)}` : API.list;
        const res = await fetch(url);
        if (!res.ok) throw new Error('Gagal memuat data');
        brands = await res.json();
        renderTable(search);
    } catch (err) {
        showToast('Gagal memuat data dari server', 'error');
        document.getElementById('brandTableBody').innerHTML = `
            <tr><td colspan="5" class="px-6 py-12 text-center">
                <i class="fa-solid fa-circle-exclamation text-3xl text-red-300 mb-3"></i>
                <p class="text-sm font-medium text-red-400">${err.message}</p>
            </td></tr>`;
    }
}

// === Render Tabel ===
function renderTable(filter = '') {
    const filtered = brands.filter(b =>
        b.name.toLowerCase().includes(filter.toLowerCase()) ||
        b.slug.toLowerCase().includes(filter.toLowerCase())
    );
    const totalPages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;
    const start = (currentPage - 1) * PER_PAGE;
    const pageData = filtered.slice(start, start + PER_PAGE);

    const tbody = document.getElementById('brandTableBody');
    tbody.innerHTML = '';

    if (pageData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-12 text-center"><div class="flex flex-col items-center"><i class="fa-solid fa-box-open text-3xl text-surface-300 mb-3"></i><p class="text-sm font-medium text-surface-400">Tidak ada data ditemukan</p></div></td></tr>`;
    } else {
        pageData.forEach((b, i) => {
            const imgUrl = b.image_url || `https://picsum.photos/seed/fb${b.id}/80/80.jpg`;
            const tr = document.createElement('tr');
            tr.className = 'row-hover border-b border-panel-border/60 last:border-0 anim-fade';
            tr.style.animationDelay = `${i * 0.04}s`;
            tr.innerHTML = `
                <td class="px-6 py-3.5 text-sm font-medium text-surface-500">${start + i + 1}</td>
                <td class="px-6 py-3.5"><span class="text-sm font-semibold text-surface-800">${b.name}</span></td>
                <td class="px-6 py-3.5"><span class="inline-flex items-center px-2.5 py-1 rounded-md bg-surface-50 border border-panel-border text-[12px] font-mono font-medium text-surface-600">${b.slug}</span></td>
                <td class="px-6 py-3.5 text-center"><img src="${imgUrl}" alt="${b.name}" class="w-10 h-10 rounded-lg object-contain inline-block bg-surface-50 border border-panel-border p-0.5 hover:scale-110 transition-transform duration-200"></td>
                <td class="px-6 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-1.5">
                        <button onclick="openEditModal(${b.id})" class="btn-act w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 flex items-center justify-center text-amber-600 hover:text-amber-700" title="Edit" aria-label="Edit ${b.name}"><i class="fa-solid fa-pen text-[11px]"></i></button>
                        <button onclick="openDeleteModal(${b.id})" class="btn-act w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center text-red-500 hover:text-red-600" title="Hapus" aria-label="Hapus ${b.name}"><i class="fa-solid fa-trash-can text-[11px]"></i></button>
                    </div>
                </td>`;
            tbody.appendChild(tr);
        });
    }

    // Paginasi
    const pag = document.getElementById('pagination');
    pag.innerHTML = '';
    if (totalPages > 1) {
        const prev = document.createElement('button');
        prev.className = `btn-act w-8 h-8 rounded-lg border border-panel-border bg-white flex items-center justify-center text-xs ${currentPage===1?'text-surface-300 pointer-events-none':'text-surface-500 hover:text-surface-700'}`;
        prev.innerHTML = '<i class="fa-solid fa-chevron-left"></i>';
        prev.onclick = () => { currentPage--; renderTable(filter); };
        pag.appendChild(prev);

        for (let p = 1; p <= totalPages; p++) {
            const btn = document.createElement('button');
            btn.className = p === currentPage
                ? 'w-8 h-8 rounded-lg bg-brand-500 text-white flex items-center justify-center text-xs font-bold shadow-sm shadow-brand-500/25'
                : 'btn-act w-8 h-8 rounded-lg border border-panel-border bg-white flex items-center justify-center text-surface-500 hover:text-surface-700 text-xs font-medium';
            btn.textContent = p;
            btn.onclick = () => { currentPage = p; renderTable(filter); };
            pag.appendChild(btn);
        }

        const next = document.createElement('button');
        next.className = `btn-act w-8 h-8 rounded-lg border border-panel-border bg-white flex items-center justify-center text-xs ${currentPage===totalPages?'text-surface-300 pointer-events-none':'text-surface-500 hover:text-surface-700'}`;
        next.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
        next.onclick = () => { currentPage++; renderTable(filter); };
        pag.appendChild(next);
    }

    document.getElementById('brandCount').textContent = brands.length;
    document.getElementById('showingCount').textContent = filtered.length;
}

// ============================================
// UPLOAD GAMBAR
// ============================================
const uploadZone = document.getElementById('uploadZone');
uploadZone.addEventListener('click', e => { if (!e.target.closest('#removeFile')) document.getElementById('brandImage').click(); });
uploadZone.addEventListener('keydown', e => { if (e.key==='Enter'||e.key===' ') { e.preventDefault(); document.getElementById('brandImage').click(); } });
uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('drag-over'); });
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('drag-over'));
uploadZone.addEventListener('drop', e => { e.preventDefault(); uploadZone.classList.remove('drag-over'); if(e.dataTransfer.files.length) handleFile(e.dataTransfer.files[0]); });
document.getElementById('brandImage').addEventListener('change', e => { if(e.target.files.length) handleFile(e.target.files[0]); });

function handleFile(file) {
    if (!file.type.startsWith('image/')) { showToast('File harus berupa gambar','error'); return; }
    if (file.size > 2*1024*1024) { showToast('Ukuran file maksimal 2MB','error'); return; }
    uploadedFile = file;
    const r = new FileReader();
    r.onload = e => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('uploadPlaceholder').classList.add('hidden');
        document.getElementById('uploadPreview').classList.remove('hidden');
    };
    r.readAsDataURL(file);
    document.getElementById('imageError').classList.add('hidden');
}

document.getElementById('removeFile').addEventListener('click', e => {
    e.stopPropagation();
    uploadedFile = null;
    document.getElementById('brandImage').value = '';
    document.getElementById('uploadPlaceholder').classList.remove('hidden');
    document.getElementById('uploadPreview').classList.add('hidden');
});

// Slug preview
document.getElementById('brandName').addEventListener('input', e => {
    document.getElementById('slugPreview').textContent = toSlug(e.target.value) || '—';
    if (e.target.value.trim()) document.getElementById('nameError').classList.add('hidden');
});

// ============================================
// TAMBAH MEREK — Kirim ke server via FormData
// ============================================
document.getElementById('addBrandForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const name = document.getElementById('brandName').value.trim();
    let ok = true;
    if (!name) { document.getElementById('nameError').classList.remove('hidden'); ok=false; }
    if (!uploadedFile) { document.getElementById('imageError').classList.remove('hidden'); ok=false; }
    if (!ok) return;

    // Disable tombol saat loading
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i>Menyimpan...';

    try {
        const formData = new FormData();
        formData.append('name', name);
        formData.append('image', uploadedFile);

        const res = await fetch(API.store, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData,
        });

        if (!res.ok) {
            const err = await res.json();
            throw new Error(err.message || 'Gagal menyimpan');
        }

        const data = await res.json();
        showToast(data.message);

        // Reset form
        document.getElementById('brandName').value = '';
        document.getElementById('slugPreview').textContent = '—';
        uploadedFile = null;
        document.getElementById('brandImage').value = '';
        document.getElementById('uploadPlaceholder').classList.remove('hidden');
        document.getElementById('uploadPreview').classList.add('hidden');

        // Muat ulang data
        currentPage = Math.ceil((brands.length + 1) / PER_PAGE);
        await fetchBrands(document.getElementById('searchInput').value);
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-plus text-xs"></i>Tambah';
    }
});

// Pencarian (debounce 300ms)
let searchTimer;
document.getElementById('searchInput').addEventListener('input', e => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        currentPage = 1;
        fetchBrands(e.target.value);
    }, 300);
});

// ============================================
// EDIT MEREK — Ambil data, kirim update
// ============================================
function openEditModal(id) {
    const b = brands.find(x => x.id === id);
    if (!b) return;
    document.getElementById('editBrandId').value = id;
    document.getElementById('editBrandName').value = b.name;
    document.getElementById('editCurrentImg').src = b.image_url || `https://picsum.photos/seed/fb${id}/80/80.jpg`;
    editUploadedFile = null;
    document.getElementById('editBrandImage').value = '';
    document.getElementById('editUploadZone').innerHTML = '<p class="text-xs font-medium text-surface-500"><i class="fa-solid fa-cloud-arrow-up mr-1 text-surface-400"></i>Klik untuk ganti gambar</p>';
    document.getElementById('editModal').classList.remove('hidden');
}
function closeEditModal() { document.getElementById('editModal').classList.add('hidden'); }
document.getElementById('closeEditBtn').onclick = closeEditModal;
document.getElementById('cancelEditBtn').onclick = closeEditModal;
document.getElementById('editOverlay').onclick = closeEditModal;

document.getElementById('editUploadZone').addEventListener('click', () => document.getElementById('editBrandImage').click());
document.getElementById('editBrandImage').addEventListener('change', e => {
    if (e.target.files.length) {
        editUploadedFile = e.target.files[0];
        document.getElementById('editUploadZone').innerHTML = `<p class="text-xs font-medium text-brand-600"><i class="fa-solid fa-check-circle mr-1"></i>${editUploadedFile.name}</p>`;
    }
});

document.getElementById('editBrandForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = parseInt(document.getElementById('editBrandId').value);
    const name = document.getElementById('editBrandName').value.trim();
    if (!name) return;

    try {
        const formData = new FormData();
        formData.append('name', name);
        formData.append('_method', 'PUT'); // Laravel butuh ini untuk method spoofing
        if (editUploadedFile) formData.append('image', editUploadedFile);

        const res = await fetch(API.update(id), {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData,
        });

        if (!res.ok) {
            const err = await res.json();
            throw new Error(err.message || 'Gagal memperbarui');
        }

        const data = await res.json();
        closeEditModal();
        showToast(data.message);
        await fetchBrands(document.getElementById('searchInput').value);
    } catch (err) {
        showToast(err.message, 'error');
    }
});

// ============================================
// HAPUS MEREK — Kirim DELETE ke server
// ============================================
function openDeleteModal(id) {
    const b = brands.find(x => x.id === id);
    if (!b) return;
    deleteTargetId = id;
    document.getElementById('deleteBrandName').textContent = b.name;
    document.getElementById('deleteModal').classList.remove('hidden');
}
function closeDeleteModal() { document.getElementById('deleteModal').classList.add('hidden'); deleteTargetId = null; }
document.getElementById('cancelDeleteBtn').onclick = closeDeleteModal;
document.getElementById('deleteOverlay').onclick = closeDeleteModal;

document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
    if (deleteTargetId === null) return;

    const btn = document.getElementById('confirmDeleteBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i>';

    try {
        const res = await fetch(API.delete(deleteTargetId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ _method: 'DELETE' }),
        });

        if (!res.ok) throw new Error('Gagal menghapus');

        const data = await res.json();
        closeDeleteModal();
        showToast(data.message, 'info');
        await fetchBrands(document.getElementById('searchInput').value);
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = 'Hapus';
    }
});

// Escape tutup modal
document.addEventListener('keydown', e => { if(e.key==='Escape'){ closeEditModal(); closeDeleteModal(); } });

// === Muat data saat halaman dibuka ===
document.addEventListener('DOMContentLoaded', () => {
    fetchBrands();
});
</script>
@endsection