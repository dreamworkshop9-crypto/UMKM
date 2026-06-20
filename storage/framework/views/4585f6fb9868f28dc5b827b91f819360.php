<?php $__env->startSection('title', 'Slider - SALZA'); ?>
<?php $__env->startSection('page-title', 'Data Slider'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.row-hover{transition:background .15s,box-shadow .15s}
.row-hover:hover{background:rgba(139,92,246,.08);box-shadow:inset 3px 0 0 #a855f7}
@keyframes toastIn{from{opacity:0;transform:translateX(100%)}to{opacity:1;transform:translateX(0)}}
@keyframes toastOut{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(100%)}}
.toast-in{animation:toastIn .3s ease forwards}
.toast-out{animation:toastOut .25s ease forwards}
.upload-zone{transition:all .2s;border:2px dashed rgb(51 65 85 / .5)}
.upload-zone:hover,.upload-zone.drag-over{border-color:#a855f7!important;background:rgba(139,92,246,.05)!important}
.slider-img{width:200px;height:80px;object-fit:cover;border-radius:10px;border:2px solid rgb(51 65 85 / .5);background:rgb(30 41 59 / .5)}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="flex gap-6 items-start">

    <!-- Tabel -->
    <div class="flex-1 min-w-0">
        <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-400 text-xs font-bold">S</div>
                    <div>
                        <h2 class="text-lg font-semibold text-white">Data Slider</h2>
                        <p class="text-xs text-slate-500">Total <span id="sliderCount" class="text-purple-400 font-semibold">0</span> slider</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto max-h-[500px]">
                <table class="w-full text-left">
                    <thead class="sticky top-0 z-10">
                        <tr class="bg-slate-700/20 text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                            <th class="px-6 py-3 w-12">No</th>
                            <th class="px-6 py-3 w-48">Gambar</th>
                            <th class="px-6 py-3">Judul</th>
                            <th class="px-6 py-3">Deskripsi</th>
                            <th class="px-6 py-3 w-28 text-center">Status</th>
                            <th class="px-6 py-3 w-36 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="sliderTableBody" class="divide-y divide-slate-700/50">
                        <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <div class="inline-block w-6 h-6 border-2 border-slate-600 border-t-slate-400 rounded-full animate-spin mb-2"></div>
                            <p class="text-sm">Memuat data...</p>
                        </td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Tambah -->
    <div class="w-96 flex-shrink-0">
        <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-400 text-xs font-bold">+</div>
                <h3 class="text-sm font-bold text-white">Tambah Slider</h3>
            </div>
            <form id="addForm" class="p-6 space-y-4" novalidate>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Judul <span class="text-red-400">*</span></label>
                    <input type="text" id="inputTitle" placeholder="Masukkan judul slider" class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none" required>
                    <p id="titleError" class="text-xs text-red-400 mt-1 hidden">Judul wajib diisi</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi</label>
                    <textarea id="inputDesc" rows="3" placeholder="Deskripsi slider (opsional)" class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Gambar <span class="text-red-400">*</span></label>
                    <div id="uploadZone" class="upload-zone rounded-xl p-5 flex flex-col items-center justify-center cursor-pointer min-h-[140px]">
                        <div id="uploadPlaceholder" class="text-center">
                            <div class="w-11 h-11 rounded-full bg-purple-500/10 flex items-center justify-center mx-auto mb-2.5 text-purple-400 text-lg font-bold">^</div>
                            <p class="text-xs font-semibold text-slate-400">Klik atau seret gambar</p>
                            <p class="text-[11px] text-slate-600 mt-0.5">PNG, JPG, SVG, WebP (Maks. 2MB)</p>
                        </div>
                        <div id="uploadPreview" class="hidden w-full text-center">
                            <img id="previewImg" src="" alt="Preview" class="slider-img mx-auto mb-2">
                            <p id="fileName" class="text-xs font-medium text-slate-300 truncate px-4"></p>
                            <button type="button" id="removeFile" class="text-[11px] text-red-400 font-semibold hover:text-red-300 mt-1.5 transition-colors">Hapus</button>
                        </div>
                    </div>
                    <input type="file" id="inputImage" accept="image/*" class="hidden">
                    <p id="imageError" class="text-xs text-red-400 mt-1 hidden">Gambar wajib diunggah</p>
                </div>
                <button type="submit" id="submitBtn" class="w-full py-3 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-xl shadow-md shadow-purple-500/20 transition-all flex items-center justify-center gap-2">
                    + Tambah
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="editOverlay"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-slate-800 rounded-2xl border border-slate-700/50 shadow-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-700/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500 text-xs font-bold">E</div>
                <h3 class="text-sm font-bold text-white">Edit Slider</h3>
            </div>
            <button id="closeEditBtn" class="w-8 h-8 rounded-lg hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white text-lg">&times;</button>
        </div>
        <form id="editForm" class="p-6 space-y-4" novalidate>
            <input type="hidden" id="editId">
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Judul <span class="text-red-400">*</span></label>
                <input type="text" id="editTitle" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi</label>
                <textarea id="editDesc" rows="3" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none resize-none"></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Status</label>
                <div class="flex items-center gap-6 mt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="editStatus" value="1" id="editStatusOn" class="accent-purple-500 w-4 h-4">
                        <span class="text-sm text-slate-300">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="editStatus" value="0" id="editStatusOff" class="accent-slate-500 w-4 h-4">
                        <span class="text-sm text-slate-300">Tidak Aktif</span>
                    </label>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Gambar Saat Ini</label>
                <img id="editCurrentImg" src="" alt="Gambar" class="slider-img">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Ganti Gambar (Opsional)</label>
                <div id="editUploadZone" class="upload-zone rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer">
                    <p class="text-xs text-slate-500">Klik untuk ganti gambar</p>
                </div>
                <input type="file" id="editImage" accept="image/*" class="hidden">
            </div>
            <div class="flex gap-3">
                <button type="button" id="cancelEditBtn" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-xl shadow-sm shadow-purple-500/20 transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="deleteOverlay"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-slate-800 rounded-2xl border border-slate-700/50 shadow-2xl overflow-hidden">
        <div class="p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-4 text-red-500 text-2xl font-bold">!</div>
            <h3 class="text-base font-bold text-white mb-1">Hapus Slider?</h3>
            <p class="text-sm text-slate-400">Slider <strong id="deleteName" class="text-slate-300"></strong> akan dihapus permanen.</p>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="cancelDeleteBtn" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors">Batal</button>
            <button id="confirmDeleteBtn" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-lg shadow-sm shadow-red-500/20 transition-all">Hapus</button>
        </div>
    </div>
</div>

<script>
var sampleSliders = [
    { id:1, title:'Summer Collection 2025',     description:'Koleksi sepatu terbaru untuk musim panas',           image_url:'https://picsum.photos/seed/slider-summer/400/160.jpg',   is_active:1 },
    { id:2, title:'Flash Sale Nike Air Max',     description:'Diskon hingga 50% untuk semua Nike Air Max',        image_url:'https://picsum.photos/seed/slider-nike/400/160.jpg',     is_active:1 },
    { id:3, title:'Adidas Originals Arrived',    description:'Adidas Originals telah hadir di toko kami',           image_url:'https://picsum.photos/seed/slider-adidas/400/160.jpg',  is_active:1 },
    { id:4, title:'Puma Running Collection',     description:'Sepatu lari Puma dengan teknologi terbaru',         image_url:'https://picsum.photos/seed/slider-puma/400/160.jpg',     is_active:0 },
    { id:5, title:'Gratis Ongkir Semua Sepatu',  description:'Promo gratis ongkir tanpa minimum belanja',          image_url:'https://picsum.photos/seed/slider-ongkir/400/160.jpg',  is_active:1 },
    { id:6, title:'New Balance Classic Series',   description:'Kembalinya klasik New Balance yang ikonik',          image_url:'https://picsum.photos/seed/slider-nb/400/160.jpg',      is_active:0 },
    { id:7, title:'Converse All Star Promo',     description:'Beli 2 pair Converse All Star harga spesial',       image_url:'https://picsum.photos/seed/slider-converse/400/160.jpg', is_active:1 }
];

var API = {
    list:   '<?php echo e(route("admin.slider.list")); ?>',
    store:  '<?php echo e(route("admin.slider.store")); ?>',
    show:   function(id){ return '<?php echo e(route("admin.slider.show", "ID")); ?>'.replace('ID', id); },
    update: function(id){ return '<?php echo e(route("admin.slider.update", "ID")); ?>'.replace('ID', id); },
    delete: function(id){ return '<?php echo e(route("admin.slider.destroy", "ID")); ?>'.replace('ID', id); }
};

var items = [], uploadedFile = null, editUploadedFile = null, deleteTargetId = null, currentFilter = '';

function showToast(msg, type) {
    type = type || 'success';
    var c = document.getElementById('toastContainer');
    if (!c) { c = document.createElement('div'); c.id = 'toastContainer'; c.className = 'fixed top-6 right-6 z-[60] space-y-3 pointer-events-none'; document.body.appendChild(c); }
    var colors = { success:'border-l-4 border-emerald-500', error:'border-l-4 border-red-500', info:'border-l-4 border-sky-500' };
    var el = document.createElement('div');
    el.className = 'toast-in pointer-events-auto px-5 py-3 bg-slate-800 rounded-xl border border-slate-700/50 shadow-lg min-w-[280px] text-sm font-semibold text-white ' + (colors[type] || colors.success);
    el.textContent = msg;
    c.appendChild(el);
    setTimeout(function() { el.classList.replace('toast-in','toast-out'); setTimeout(function(){ el.remove(); }, 250); }, 3000);
}

async function fetchData(search) {
    if (typeof search === 'undefined') search = currentFilter;
    currentFilter = search || '';
    try {
        var url = search ? API.list + '?search=' + encodeURIComponent(search) : API.list;
        var r = await fetch(url);
        if (!r.ok) throw new Error();
        var data = await r.json();
        if (Array.isArray(data) && data.length) {
            items = data;
        } else {
            items = sampleSliders.filter(function(b){ return !search || b.title.toLowerCase().includes(search.toLowerCase()); });
        }
        renderTable(search);
    } catch(e) {
        items = sampleSliders.filter(function(b){ return !search || b.title.toLowerCase().includes(search.toLowerCase()); });
        renderTable(search);
    }
}

function renderTable(filter) {
    if (typeof filter === 'undefined') filter = currentFilter;
    var filtered = items.filter(function(b){ return b.title.toLowerCase().includes(filter.toLowerCase()); });
    var tbody = document.getElementById('sliderTableBody');
    tbody.innerHTML = '';
    if (!filtered.length) {
        tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">Tidak ada data.</td></tr>';
    } else {
        for (var i = 0; i < filtered.length; i++) {
            var sl = filtered[i];
            var img = sl.image_url || 'https://picsum.photos/seed/slider' + sl.id + '/400/160.jpg';
            var descHtml = sl.description ? sl.description : '<span class="italic text-slate-600">Tidak ada</span>';
            var statusClass = sl.is_active ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20';
            var dotClass = sl.is_active ? 'bg-emerald-400' : 'bg-red-400';
            var statusText = sl.is_active ? 'Aktif' : 'Tidak Aktif';
            var tr = document.createElement('tr');
            tr.className = 'row-hover';
            tr.innerHTML = '<td class="px-6 py-3 text-sm text-slate-500">' + (i + 1) + '</td>'
                + '<td class="px-6 py-3"><img src="' + img + '" alt="' + sl.title + '" class="w-40 h-16 object-cover rounded-lg border border-slate-700/50"></td>'
                + '<td class="px-6 py-3 text-sm font-semibold text-white">' + sl.title + '</td>'
                + '<td class="px-6 py-3 text-sm text-slate-400 max-w-[200px] truncate">' + descHtml + '</td>'
                + '<td class="px-6 py-3 text-center"><span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border ' + statusClass + '"><span class="w-1.5 h-1.5 rounded-full ' + dotClass + '"></span>' + statusText + '</span></td>'
                + '<td class="px-6 py-3 text-center"><div class="flex items-center justify-center gap-2">'
                + '<button onclick="openEdit(' + sl.id + ')" class="px-3 py-1.5 rounded-lg bg-amber-500/15 hover:bg-amber-500/30 text-amber-400 hover:text-amber-300 text-[12px] font-semibold transition-colors border border-amber-500/20">Edit</button>'
                + '<button onclick="openDelete(' + sl.id + ')" class="px-3 py-1.5 rounded-lg bg-red-500/15 hover:bg-red-500/30 text-red-400 hover:text-red-300 text-[12px] font-semibold transition-colors border border-red-500/20">Hapus</button>'
                + '</div></td>';
            tbody.appendChild(tr);
        }
    }
    document.getElementById('sliderCount').textContent = items.length;
}

// Upload
var uz = document.getElementById('uploadZone');
uz.addEventListener('click', function(e){ if (!e.target.closest('#removeFile')) document.getElementById('inputImage').click(); });
uz.addEventListener('dragover', function(e){ e.preventDefault(); uz.classList.add('drag-over'); });
uz.addEventListener('dragleave', function(){ uz.classList.remove('drag-over'); });
uz.addEventListener('drop', function(e){ e.preventDefault(); uz.classList.remove('drag-over'); if (e.dataTransfer.files.length) handleFile(e.dataTransfer.files[0]); });
document.getElementById('inputImage').addEventListener('change', function(e){ if (e.target.files.length) handleFile(e.target.files[0]); });

function handleFile(file) {
    if (!file.type.startsWith('image/')) { showToast('File harus berupa gambar', 'error'); return; }
    if (file.size > 2*1024*1024) { showToast('Maks 2MB', 'error'); return; }
    uploadedFile = file;
    var r = new FileReader();
    r.onload = function(e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('uploadPlaceholder').classList.add('hidden');
        document.getElementById('uploadPreview').classList.remove('hidden');
    };
    r.readAsDataURL(file);
    document.getElementById('imageError').classList.add('hidden');
}

document.getElementById('removeFile').addEventListener('click', function(e) {
    e.stopPropagation();
    uploadedFile = null;
    document.getElementById('inputImage').value = '';
    document.getElementById('uploadPlaceholder').classList.remove('hidden');
    document.getElementById('uploadPreview').classList.add('hidden');
});

document.getElementById('inputTitle').addEventListener('input', function(e) {
    if (e.target.value.trim()) document.getElementById('titleError').classList.add('hidden');
});

// Tambah
document.getElementById('addForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    var title = document.getElementById('inputTitle').value.trim();
    var ok = true;
    if (!title) { document.getElementById('titleError').classList.remove('hidden'); ok = false; }
    if (!uploadedFile) { document.getElementById('imageError').classList.remove('hidden'); ok = false; }
    if (!ok) return;
    var btn = document.getElementById('submitBtn');
    btn.disabled = true; btn.textContent = 'Menyimpan...';
    try {
        var fd = new FormData();
        fd.append('title', title);
        fd.append('description', document.getElementById('inputDesc').value);
        fd.append('image', uploadedFile);
        var r = await fetch(API.store, { method:'POST', headers:{'X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'}, body:fd });
        if (!r.ok) throw new Error();
        var d = await r.json();
        showToast(d.message);
        sampleSliders.push({ id: d.id || Date.now(), title: title, description: document.getElementById('inputDesc').value, image_url: '', is_active: 1 });
        items = sampleSliders;
        renderTable(currentFilter);
        document.getElementById('inputTitle').value = '';
        document.getElementById('inputDesc').value = '';
        uploadedFile = null;
        document.getElementById('inputImage').value = '';
        document.getElementById('uploadPlaceholder').classList.remove('hidden');
        document.getElementById('uploadPreview').classList.add('hidden');
        fetchData();
    } catch(err) { showToast('Gagal menyimpan', 'error'); }
    finally { btn.disabled = false; btn.textContent = '+ Tambah'; }
});

// Edit
function openEdit(id) {
    var sl = items.find(function(x){ return x.id === id; }); if (!sl) return;
    document.getElementById('editId').value = id;
    document.getElementById('editTitle').value = sl.title;
    document.getElementById('editDesc').value = sl.description || '';
    document.getElementById('editCurrentImg').src = sl.image_url || 'https://picsum.photos/seed/slider' + id + '/400/160.jpg';
    document.getElementById(sl.is_active ? 'editStatusOn' : 'editStatusOff').checked = true;
    editUploadedFile = null;
    document.getElementById('editImage').value = '';
    document.getElementById('editUploadZone').innerHTML = '<p class="text-xs text-slate-500">Klik untuk ganti gambar</p>';
    document.getElementById('editModal').classList.remove('hidden');
}
function closeEdit() { document.getElementById('editModal').classList.add('hidden'); }
document.getElementById('closeEditBtn').onclick = closeEdit;
document.getElementById('cancelEditBtn').onclick = closeEdit;
document.getElementById('editOverlay').onclick = closeEdit;
document.getElementById('editUploadZone').addEventListener('click', function(){ document.getElementById('editImage').click(); });
document.getElementById('editImage').addEventListener('change', function(e) {
    if (e.target.files.length) {
        editUploadedFile = e.target.files[0];
        document.getElementById('editUploadZone').innerHTML = '<p class="text-xs text-emerald-400">' + editUploadedFile.name + '</p>';
    }
});

document.getElementById('editForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    var id = parseInt(document.getElementById('editId').value);
    var title = document.getElementById('editTitle').value.trim();
    if (!title) { showToast('Judul wajib diisi', 'error'); return; }
    try {
        var fd = new FormData();
        fd.append('title', title);
        fd.append('_method', 'PUT');
        fd.append('description', document.getElementById('editDesc').value);
        var statusRadio = document.querySelector('input[name="editStatus"]:checked');
        fd.append('is_active', statusRadio ? statusRadio.value : '0');
        if (editUploadedFile) fd.append('image', editUploadedFile);
        var r = await fetch(API.update(id), { method:'POST', headers:{'X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'}, body:fd });
        if (!r.ok) throw new Error();
        var d = await r.json();
        for (var i = 0; i < sampleSliders.length; i++) {
            if (String(sampleSliders[i].id) === String(id)) {
                sampleSliders[i].title = title;
                sampleSliders[i].description = document.getElementById('editDesc').value;
                sampleSliders[i].is_active = statusRadio ? parseInt(statusRadio.value) : 0;
                if (editUploadedFile) sampleSliders[i].image_url = '';
                break;
            }
        }
        items = sampleSliders;
        renderTable(currentFilter);
        closeEdit(); showToast(d.message); fetchData();
    } catch(err) { showToast('Gagal memperbarui', 'error'); }
});

// Hapus
function openDelete(id) {
    var sl = items.find(function(x){ return x.id === id; }); if (!sl) return;
    deleteTargetId = id;
    document.getElementById('deleteName').textContent = sl.title;
    document.getElementById('deleteModal').classList.remove('hidden');
}
function closeDelete() { document.getElementById('deleteModal').classList.add('hidden'); deleteTargetId = null; }
document.getElementById('cancelDeleteBtn').onclick = closeDelete;
document.getElementById('deleteOverlay').onclick = closeDelete;

document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
    if (deleteTargetId === null) return;
    var btn = document.getElementById('confirmDeleteBtn');
    btn.disabled = true; btn.textContent = 'Menghapus...';
    try {
        var r = await fetch(API.delete(deleteTargetId), { method:'POST', headers:{'X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>','Content-Type':'application/json'}, body:JSON.stringify({_method:'DELETE'}) });
        if (!r.ok) throw new Error();
        var d = await r.json();
        sampleSliders = sampleSliders.filter(function(b){ return String(b.id) !== String(deleteTargetId); });
        items = sampleSliders;
        renderTable(currentFilter);
        closeDelete(); showToast(d.message, 'info'); fetchData();
    } catch(err) { showToast('Gagal menghapus', 'error'); }
    finally { btn.disabled = false; btn.textContent = 'Hapus'; }
});

document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeEdit(); closeDelete(); } });

items = sampleSliders;
renderTable('');
fetchData();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/irawan/laravel/shoesmarket/UMKMmm/UMKM/resources/views/admin/slider/index.blade.php ENDPATH**/ ?>