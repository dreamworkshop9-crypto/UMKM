@extends('layouts.admin')

@section('title', 'Kategori - SALZA')
@section('page-title', 'Kategori')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.row-hover { transition: background .15s, box-shadow .15s; }
.row-hover:hover { background: rgba(139,92,246,0.08); box-shadow: inset 3px 0 0 #a855f7; }
@keyframes toastIn { from{opacity:0;transform:translateX(100%)} to{opacity:1;transform:translateX(0)} }
@keyframes toastOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(100%)} }
.toast-in { animation: toastIn .3s ease forwards; }
.toast-out { animation: toastOut .25s ease forwards; }
</style>
@endsection

@section('content')
<div class="flex gap-6 items-start">
    <!-- Tabel -->
    <div class="flex-1">
        <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-layer-group text-purple-400 text-xs"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-white">Data Kategori</h2>
                </div>
                <p class="text-sm text-slate-500">Total <span id="kategoriCount" class="text-purple-400 font-semibold">0</span> kategori</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-700/20 text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                            <th class="px-6 py-3 w-14">No</th>
                            <th class="px-6 py-3">Nama Kategori</th>
                            <th class="px-6 py-3">Slug</th>
                            <th class="px-6 py-3">Deskripsi</th>
                            <th class="px-6 py-3 w-28 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="kategoriTableBody" class="divide-y divide-slate-700/50">
                        <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <i class="fa-solid fa-spinner fa-spin text-xl mb-2"></i>
                            <p class="text-sm">Memuat data...</p>
                        </td></tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-slate-700/50 flex items-center justify-between">
                <p class="text-xs text-slate-500">Menampilkan <span id="showingCount" class="text-slate-300 font-semibold">0</span> data</p>
                <div class="flex items-center gap-1" id="pagination"></div>
            </div>
        </div>
    </div>

    <!-- Form Tambah -->
    <div class="w-96 flex-shrink-0">
        <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-plus text-purple-400 text-xs"></i>
                </div>
                <h3 class="text-sm font-bold text-white">Tambah Kategori</h3>
            </div>
            <form id="addForm" class="p-6 space-y-4" novalidate>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Kategori <span class="text-red-400">*</span></label>
                    <input type="text" id="inputName" placeholder="Masukkan nama" class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none" required>
                    <p id="nameError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Nama wajib diisi</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi</label>
                    <textarea id="inputDesc" rows="3" placeholder="Deskripsi kategori (opsional)" class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Slug Preview</label>
                    <div class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-slate-500 truncate">
                        <span id="slugPreview" class="text-slate-400">—</span>
                    </div>
                </div>
                <button type="submit" id="submitBtn" class="w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-lg shadow-md shadow-purple-500/20 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>Tambah
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="editOverlay"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-slate-800 rounded-2xl border border-slate-700/50 shadow-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700/50 flex items-center justify-between">
            <h3 class="text-sm font-bold text-white">Edit Kategori</h3>
            <button id="closeEditBtn" class="w-8 h-8 rounded-lg hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editForm" class="p-6 space-y-4" novalidate>
            <input type="hidden" id="editId">
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Kategori <span class="text-red-400">*</span></label>
                <input type="text" id="editName" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi</label>
                <textarea id="editDesc" rows="3" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none resize-none"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" id="cancelEditBtn" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-lg transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="deleteOverlay"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-slate-800 rounded-2xl border border-slate-700/50 shadow-2xl overflow-hidden">
        <div class="p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-4"><i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i></div>
            <h3 class="text-base font-bold text-white mb-1">Hapus Kategori?</h3>
            <p class="text-sm text-slate-400">Kategori <strong id="deleteName" class="text-slate-300"></strong> akan dihapus permanen.</p>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="cancelDeleteBtn" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors">Batal</button>
            <button id="confirmDeleteBtn" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-lg transition-all">Hapus</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const API = {
    list:   '{{ route("admin.kategori.list") }}',
    store:  '{{ route("admin.kategori.store") }}',
    show:   id => `{{ route("admin.kategori.show", "ID") }}`.replace('ID', id),
    update: id => `{{ route("admin.kategori.update", "ID") }}`.replace('ID', id),
    delete: id => `{{ route("admin.kategori.destroy", "ID") }}`.replace('ID', id),
};

let items = [], currentPage = 1, PER_PAGE = 5, deleteTargetId = null;

function toSlug(t) { return t.toLowerCase().trim().replace(/[^\w\s-]/g,'').replace(/[\s_]+/g,'-').replace(/^-+|-+$/g,''); }

function showToast(msg, type='success') {
    let c = document.getElementById('toastContainer');
    if (!c) { c = document.createElement('div'); c.id='toastContainer'; c.className='fixed top-6 right-6 z-[60] space-y-3 pointer-events-none'; document.body.appendChild(c); }
    const icons = { success:'fa-circle-check text-emerald-400', error:'fa-circle-xmark text-red-400', info:'fa-circle-info text-sky-400' };
    const el = document.createElement('div');
    el.className = 'toast-in pointer-events-auto flex items-center gap-3 px-5 py-3 bg-slate-800 rounded-xl border border-slate-700/50 shadow-lg min-w-[280px]';
    el.innerHTML = `<i class="fa-solid ${icons[type]}"></i><span class="text-sm font-semibold text-white flex-1">${msg}</span>`;
    c.appendChild(el);
    setTimeout(() => { el.classList.replace('toast-in','toast-out'); setTimeout(()=>el.remove(),250); }, 3000);
}

async function fetchData(search='') {
    try {
        const url = search ? `${API.list}?search=${encodeURIComponent(search)}` : API.list;
        const res = await fetch(url);
        if (!res.ok) throw new Error();
        items = await res.json();
        renderTable(search);
    } catch(e) { showToast('Gagal memuat data','error'); }
}

function renderTable(filter='') {
    const filtered = items.filter(b => b.name.toLowerCase().includes(filter.toLowerCase()) || b.slug.toLowerCase().includes(filter.toLowerCase()));
    const totalPages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;
    const start = (currentPage-1)*PER_PAGE;
    const pageData = filtered.slice(start, start+PER_PAGE);
    const tbody = document.getElementById('kategoriTableBody');
    tbody.innerHTML = '';
    if (!pageData.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-12 text-center text-slate-500 italic">Tidak ada data.</td></tr>';
    } else {
        pageData.forEach((b,i) => {
            const tr = document.createElement('tr');
            tr.className = 'row-hover';
            tr.innerHTML = `<td class="px-6 py-3 text-sm text-slate-500">${start+i+1}</td>
                <td class="px-6 py-3 text-sm font-semibold text-white">${b.name}</td>
                <td class="px-6 py-3"><span class="inline-block px-2 py-0.5 bg-slate-800 border border-slate-700/50 rounded text-[11px] font-mono text-slate-400">${b.slug}</span></td>
                <td class="px-6 py-3 text-sm text-slate-400 max-w-xs truncate">${b.description || '<span class="italic text-slate-600">Tidak ada</span>'}</td>
                <td class="px-6 py-3 text-center"><div class="flex items-center justify-center gap-1">
                    <button onclick="openEdit(${b.id})" class="w-7 h-7 rounded bg-amber-500/10 hover:bg-amber-500/20 flex items-center justify-center text-amber-400 hover:text-amber-300 transition-colors" title="Edit"><i class="fa-solid fa-pen text-[10px]"></i></button>
                    <button onclick="openDelete(${b.id})" class="w-7 h-7 rounded bg-red-500/10 hover:bg-red-500/20 flex items-center justify-center text-red-400 hover:text-red-300 transition-colors" title="Hapus"><i class="fa-solid fa-trash-can text-[10px]"></i></button>
                </div></td>`;
            tbody.appendChild(tr);
        });
    }
    document.getElementById('kategoriCount').textContent = items.length;
    document.getElementById('showingCount').textContent = filtered.length;
    const pag = document.getElementById('pagination');
    pag.innerHTML = '';
    if (totalPages > 1) {
        const mk = (html,cls,fn) => { const b=document.createElement('button'); b.className=cls; b.innerHTML=html; b.onclick=fn; pag.appendChild(b); };
        mk('<i class="fa-solid fa-chevron-left text-[10px]"></i>','w-7 h-7 rounded border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs '+(currentPage===1?'text-slate-600 pointer-events-none':'text-slate-400 hover:text-white'),()=>{currentPage--;renderTable(filter);});
        for(let p=1;p<=totalPages;p++) mk(p, p===currentPage?'w-7 h-7 rounded bg-purple-600 text-white flex items-center justify-center text-xs font-bold':'w-7 h-7 rounded border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs text-slate-400 hover:text-white',()=>{currentPage=p;renderTable(filter);});
        mk('<i class="fa-solid fa-chevron-right text-[10px]"></i>','w-7 h-7 rounded border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs '+(currentPage===totalPages?'text-slate-600 pointer-events-none':'text-slate-400 hover:text-white'),()=>{currentPage++;renderTable(filter);});
    }
}

// Slug preview
document.getElementById('inputName').addEventListener('input', e => {
    document.getElementById('slugPreview').textContent = toSlug(e.target.value) || '—';
    if (e.target.value.trim()) document.getElementById('nameError').classList.add('hidden');
});

// Tambah
document.getElementById('addForm').addEventListener('submit', async e => {
    e.preventDefault();
    const name = document.getElementById('inputName').value.trim();
    if (!name) { document.getElementById('nameError').classList.remove('hidden'); return; }
    const btn = document.getElementById('submitBtn');
    btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i>Menyimpan...';
    try {
        const res = await fetch(API.store, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ name, description: document.getElementById('inputDesc').value.trim() })
        });
        if (!res.ok) throw new Error();
        const data = await res.json();
        showToast(data.message);
        document.getElementById('inputName').value = '';
        document.getElementById('inputDesc').value = '';
        document.getElementById('slugPreview').textContent = '—';
        currentPage = Math.ceil((items.length + 1) / PER_PAGE);
        await fetchData();
    } catch(err) { showToast('Gagal menyimpan','error'); }
    finally { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-plus text-xs"></i>Tambah'; }
});

// Edit
function openEdit(id) {
    const b = items.find(x => x.id === id); if (!b) return;
    document.getElementById('editId').value = id;
    document.getElementById('editName').value = b.name;
    document.getElementById('editDesc').value = b.description || '';
    document.getElementById('editModal').classList.remove('hidden');
}
function closeEdit() { document.getElementById('editModal').classList.add('hidden'); }
document.getElementById('closeEditBtn').onclick = closeEdit;
document.getElementById('cancelEditBtn').onclick = closeEdit;
document.getElementById('editOverlay').onclick = closeEdit;

document.getElementById('editForm').addEventListener('submit', async e => {
    e.preventDefault();
    const id = parseInt(document.getElementById('editId').value);
    const name = document.getElementById('editName').value.trim();
    if (!name) return;
    try {
        const res = await fetch(API.update(id), {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ name, description: document.getElementById('editDesc').value.trim(), _method: 'PUT' })
        });
        if (!res.ok) throw new Error();
        const data = await res.json();
        closeEdit(); showToast(data.message); await fetchData();
    } catch(err) { showToast('Gagal memperbarui','error'); }
});

// Hapus
function openDelete(id) {
    const b = items.find(x => x.id === id); if (!b) return;
    deleteTargetId = id;
    document.getElementById('deleteName').textContent = b.name;
    document.getElementById('deleteModal').classList.remove('hidden');
}
function closeDelete() { document.getElementById('deleteModal').classList.add('hidden'); deleteTargetId = null; }
document.getElementById('cancelDeleteBtn').onclick = closeDelete;
document.getElementById('deleteOverlay').onclick = closeDelete;

document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
    if (deleteTargetId === null) return;
    const btn = document.getElementById('confirmDeleteBtn');
    btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i>';
    try {
        const res = await fetch(API.delete(deleteTargetId), {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ _method: 'DELETE' })
        });
        if (!res.ok) throw new Error();
        const data = await res.json();
        closeDelete(); showToast(data.message, 'info'); await fetchData();
    } catch(err) { showToast('Gagal menghapus','error'); }
    finally { btn.disabled = false; btn.innerHTML = 'Hapus'; }
});

document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeEdit(); closeDelete(); } });
document.addEventListener('DOMContentLoaded', () => fetchData());
</script>
@endsection
