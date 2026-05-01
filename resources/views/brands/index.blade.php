@extends('layouts.admin')

@section('title', 'Data Merek - SALZA')

@section('page-title', 'Data Merek')

@section('content')
<div class="flex gap-6 items-start">
    <!-- Tabel -->
    <div class="flex-1">
        <div class="bg-dashboard-card rounded-xl border border-slate-700/30 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white">Data Merek</h2>
                <p class="text-sm text-slate-500">Total <span id="brandCount" class="text-purple-400 font-semibold">0</span> merek</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-700/20 text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                            <th class="px-6 py-3 w-14">No</th>
                            <th class="px-6 py-3">Merek</th>
                            <th class="px-6 py-3">Slug</th>
                            <th class="px-6 py-3 w-24 text-center">Gambar</th>
                            <th class="px-6 py-3 w-28 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="brandTableBody" class="divide-y divide-slate-700/50">
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
        <div class="bg-dashboard-card rounded-xl border border-slate-700/30 overflow-hidden sticky top-20">
            <div class="p-6 border-b border-slate-700/50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-plus text-purple-400 text-xs"></i>
                </div>
                <h3 class="text-sm font-bold text-white">Tambah Merek</h3>
            </div>
            <form id="addBrandForm" class="p-6 space-y-4" novalidate>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Merek <span class="text-red-400">*</span></label>
                    <input type="text" id="brandName" placeholder="Nama merek" class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none" required>
                    <p id="nameError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Nama merek wajib diisi</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Gambar <span class="text-red-400">*</span></label>
                    <div id="uploadZone" class="border-2 border-dashed border-slate-700/50 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer hover:border-purple-500 hover:bg-slate-800/50 transition-colors min-h-[120px]">
                        <div id="uploadPlaceholder" class="text-center">
                            <i class="fa-solid fa-cloud-arrow-up text-slate-500 text-lg mb-1"></i>
                            <p class="text-xs font-medium text-slate-400">Klik atau seret gambar</p>
                            <p class="text-[10px] text-slate-600 mt-0.5">PNG, JPG, SVG (Maks. 2MB)</p>
                        </div>
                        <div id="uploadPreview" class="hidden w-full text-center">
                            <img id="previewImg" src="" alt="Preview" class="w-14 h-14 rounded-lg object-contain mx-auto mb-1.5 bg-slate-800 border border-slate-700/50 p-0.5">
                            <p id="fileName" class="text-xs font-medium text-slate-300 truncate px-4"></p>
                            <button type="button" id="removeFile" class="text-[11px] text-red-400 font-semibold hover:text-red-300 mt-1"><i class="fa-solid fa-trash-can mr-0.5"></i>Hapus</button>
                        </div>
                    </div>
                    <input type="file" id="brandImage" accept="image/*" class="hidden">
                    <p id="imageError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Gambar wajib diunggah</p>
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
            <h3 class="text-sm font-bold text-white">Edit Merek</h3>
            <button id="closeEditBtn" class="w-8 h-8 rounded-lg hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editBrandForm" class="p-6 space-y-4" novalidate>
            <input type="hidden" id="editBrandId">
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Merek <span class="text-red-400">*</span></label>
                <input type="text" id="editBrandName" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Gambar Saat Ini</label>
                <img id="editCurrentImg" src="" alt="Gambar" class="w-14 h-14 rounded-lg object-contain bg-slate-900 border border-slate-700/50 p-0.5">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Ganti Gambar (Opsional)</label>
                <div id="editUploadZone" class="border-2 border-dashed border-slate-700/50 rounded-lg p-3 flex flex-col items-center justify-center cursor-pointer hover:border-purple-500 transition-colors">
                    <p class="text-xs text-slate-500"><i class="fa-solid fa-cloud-arrow-up mr-1"></i>Klik untuk ganti</p>
                </div>
                <input type="file" id="editBrandImage" accept="image/*" class="hidden">
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
            <h3 class="text-base font-bold text-white mb-1">Hapus Merek?</h3>
            <p class="text-sm text-slate-400">Merek <strong id="deleteBrandName" class="text-slate-300"></strong> akan dihapus permanen.</p>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="cancelDeleteBtn" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors">Batal</button>
            <button id="confirmDeleteBtn" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-lg transition-all">Hapus</button>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.row-hover { transition: background .15s, box-shadow .15s; }
.row-hover:hover { background: rgba(139,92,246,0.08); box-shadow: inset 3px 0 0 #a855f7; }
.upload-zone { transition: all .2s; }
.upload-zone:hover, .upload-zone.drag-over { border-color: #a855f7 !important; background: rgba(139,92,246,0.05) !important; }
@keyframes toastIn { from{opacity:0;transform:translateX(100%)} to{opacity:1;transform:translateX(0)} }
@keyframes toastOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(100%)} }
.toast-in { animation: toastIn .3s ease forwards; }
.toast-out { animation: toastOut .25s ease forwards; }
</style>
@endsection

@section('scripts')
<script>
const API = {
    list:   '{{ route("admin.brands.list") }}',
    store:  '{{ route("admin.brands.store") }}',
    show:   id => `{{ route("admin.brands.show", "ID") }}`.replace('ID', id),
    update: id => `{{ route("admin.brands.update", "ID") }}`.replace('ID', id),
    delete: id => `{{ route("admin.brands.destroy", "ID") }}`.replace('ID', id),
};

let brands = [], currentPage = 1, PER_PAGE = 5, uploadedFile = null, editUploadedFile = null, deleteTargetId = null;

function toSlug(t) { return t.toLowerCase().trim().replace(/[^\w\s-]/g,'').replace(/[\s_]+/g,'-').replace(/^-+|-+$/g,''); }

function showToast(msg, type='success') {
    const c = document.getElementById('toastContainer');
    if (!c) { const tc = document.createElement('div'); tc.id='toastContainer'; tc.className='fixed top-6 right-6 z-[60] space-y-3 pointer-events-none'; document.body.appendChild(tc); }
    const el = document.createElement('div');
    const icons = { success:'fa-circle-check text-emerald-400', error:'fa-circle-xmark text-red-400', info:'fa-circle-info text-sky-400' };
    el.className = 'toast-in pointer-events-auto flex items-center gap-3 px-5 py-3 bg-slate-800 rounded-xl border border-slate-700/50 shadow-lg min-w-[280px]';
    el.innerHTML = `<i class="fa-solid ${icons[type]}"></i><span class="text-sm font-semibold text-white flex-1">${msg}</span>`;
    document.getElementById('toastContainer').appendChild(el);
    setTimeout(() => { el.classList.replace('toast-in','toast-out'); setTimeout(()=>el.remove(),250); }, 3000);
}

async function fetchBrands(search='') {
    try {
        const url = search ? `${API.list}?search=${encodeURIComponent(search)}` : API.list;
        const res = await fetch(url);
        if (!res.ok) throw new Error('Gagal memuat');
        brands = await res.json();
        renderTable(search);
    } catch(e) { showToast('Gagal memuat data','error'); }
}

function renderTable(filter='') {
    const filtered = brands.filter(b => b.name.toLowerCase().includes(filter.toLowerCase()) || b.slug.toLowerCase().includes(filter.toLowerCase()));
    const totalPages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;
    const start = (currentPage-1)*PER_PAGE;
    const pageData = filtered.slice(start, start+PER_PAGE);
    const tbody = document.getElementById('brandTableBody');
    tbody.innerHTML = '';
    if (!pageData.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-12 text-center text-slate-500 italic">Tidak ada data.</td></tr>';
    } else {
        pageData.forEach((b,i) => {
            const img = b.image_url || 'https://picsum.photos/seed/fb'+b.id+'/80/80.jpg';
            const tr = document.createElement('tr');
            tr.className = 'row-hover';
            tr.innerHTML = `<td class="px-6 py-3 text-sm text-slate-500">${start+i+1}</td><td class="px-6 py-3 text-sm font-semibold text-white">${b.name}</td><td class="px-6 py-3"><span class="inline-block px-2 py-0.5 bg-slate-800 border border-slate-700/50 rounded text-[11px] font-mono text-slate-400">${b.slug}</span></td><td class="px-6 py-3 text-center"><img src="${img}" alt="${b.name}" class="w-9 h-9 rounded-lg object-contain inline-block bg-slate-800 border border-slate-700/50 p-0.5"></td><td class="px-6 py-3 text-center"><div class="flex items-center justify-center gap-1"><button onclick="openEditModal(${b.id})" class="w-7 h-7 rounded bg-amber-500/10 hover:bg-amber-500/20 flex items-center justify-center text-amber-400 hover:text-amber-300 transition-colors" title="Edit"><i class="fa-solid fa-pen text-[10px]"></i></button><button onclick="openDeleteModal(${b.id})" class="w-7 h-7 rounded bg-red-500/10 hover:bg-red-500/20 flex items-center justify-center text-red-400 hover:text-red-300 transition-colors" title="Hapus"><i class="fa-solid fa-trash-can text-[10px]"></i></button></div></td>`;
            tbody.appendChild(tr);
        });
    }
    document.getElementById('brandCount').textContent = brands.length;
    document.getElementById('showingCount').textContent = filtered.length;
    const pag = document.getElementById('pagination');
    pag.innerHTML = '';
    if (totalPages > 1) {
        const mk = (html,cls,fn) => { const b=document.createElement('button'); b.className=cls; b.innerHTML=html; b.onclick=fn; pag.appendChild(b); };
        mk('<i class="fa-solid fa-chevron-left text-[10px]"></i>', 'w-7 h-7 rounded border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs '+(currentPage===1?'text-slate-600 pointer-events-none':'text-slate-400 hover:text-white'), ()=>{currentPage--;renderTable(filter);});
        for(let p=1;p<=totalPages;p++) mk(p, p===currentPage?'w-7 h-7 rounded bg-purple-600 text-white flex items-center justify-center text-xs font-bold':'w-7 h-7 rounded border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs text-slate-400 hover:text-white', ()=>{currentPage=p;renderTable(filter);});
        mk('<i class="fa-solid fa-chevron-right text-[10px]"></i>', 'w-7 h-7 rounded border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs '+(currentPage===totalPages?'text-slate-600 pointer-events-none':'text-slate-400 hover:text-white'), ()=>{currentPage++;renderTable(filter);});
    }
}

const uz = document.getElementById('uploadZone');
uz.addEventListener('click', e => { if(!e.target.closest('#removeFile')) document.getElementById('brandImage').click(); });
uz.addEventListener('dragover', e => { e.preventDefault(); uz.classList.add('drag-over'); });
uz.addEventListener('dragleave', () => uz.classList.remove('drag-over'));
uz.addEventListener('drop', e => { e.preventDefault(); uz.classList.remove('drag-over'); if(e.dataTransfer.files.length) handleFile(e.dataTransfer.files[0]); });
document.getElementById('brandImage').addEventListener('change', e => { if(e.target.files.length) handleFile(e.target.files[0]); });

function handleFile(file) {
    if(!file.type.startsWith('image/')){showToast('File harus gambar','error');return;}
    if(file.size>2*1024*1024){showToast('Maks 2MB','error');return;}
    uploadedFile=file;
    const r=new FileReader();
    r.onload=e=>{document.getElementById('previewImg').src=e.target.result;document.getElementById('fileName').textContent=file.name;document.getElementById('uploadPlaceholder').classList.add('hidden');document.getElementById('uploadPreview').classList.remove('hidden');};
    r.readAsDataURL(file);
    document.getElementById('imageError').classList.add('hidden');
}
document.getElementById('removeFile').addEventListener('click',e=>{e.stopPropagation();uploadedFile=null;document.getElementById('brandImage').value='';document.getElementById('uploadPlaceholder').classList.remove('hidden');document.getElementById('uploadPreview').classList.add('hidden');});
document.getElementById('brandName').addEventListener('input',e=>{document.getElementById('slugPreview').textContent=toSlug(e.target.value)||'—';if(e.target.value.trim())document.getElementById('nameError').classList.add('hidden');});

document.getElementById('addBrandForm').addEventListener('submit',async e=>{
    e.preventDefault();
    const name=document.getElementById('brandName').value.trim();let ok=true;
    if(!name){document.getElementById('nameError').classList.remove('hidden');ok=false;}
    if(!uploadedFile){document.getElementById('imageError').classList.remove('hidden');ok=false;}
    if(!ok)return;
    const btn=document.getElementById('submitBtn');btn.disabled=true;btn.innerHTML='<i class="fa-solid fa-spinner fa-spin text-xs"></i>Menyimpan...';
    try{const fd=new FormData();fd.append('name',name);fd.append('image',uploadedFile);
    const res=await fetch(API.store,{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},body:fd});
    if(!res.ok)throw new Error('Gagal');const data=await res.json();showToast(data.message);
    document.getElementById('brandName').value='';document.getElementById('slugPreview').textContent='—';uploadedFile=null;document.getElementById('brandImage').value='';document.getElementById('uploadPlaceholder').classList.remove('hidden');document.getElementById('uploadPreview').classList.add('hidden');
    currentPage=Math.ceil((brands.length+1)/PER_PAGE);await fetchBrands();}catch(err){showToast(err.message,'error');}finally{btn.disabled=false;btn.innerHTML='<i class="fa-solid fa-plus text-xs"></i>Tambah';}
});

function openEditModal(id){const b=brands.find(x=>x.id===id);if(!b)return;document.getElementById('editBrandId').value=id;document.getElementById('editBrandName').value=b.name;document.getElementById('editCurrentImg').src=b.image_url||'https://picsum.photos/seed/fb'+id+'/80/80.jpg';editUploadedFile=null;document.getElementById('editBrandImage').value='';document.getElementById('editUploadZone').innerHTML='<p class="text-xs text-slate-500"><i class="fa-solid fa-cloud-arrow-up mr-1"></i>Klik untuk ganti</p>';document.getElementById('editModal').classList.remove('hidden');}
function closeEditModal(){document.getElementById('editModal').classList.add('hidden');}
document.getElementById('closeEditBtn').onclick=closeEditModal;document.getElementById('cancelEditBtn').onclick=closeEditModal;document.getElementById('editOverlay').onclick=closeEditModal;
document.getElementById('editUploadZone').addEventListener('click',()=>document.getElementById('editBrandImage').click());
document.getElementById('editBrandImage').addEventListener('change',e=>{if(e.target.files.length){editUploadedFile=e.target.files[0];document.getElementById('editUploadZone').innerHTML=`<p class="text-xs text-emerald-400"><i class="fa-solid fa-check-circle mr-1"></i>${editUploadedFile.name}</p>`;}});

document.getElementById('editBrandForm').addEventListener('submit',async e=>{
    e.preventDefault();const id=parseInt(document.getElementById('editBrandId').value);const name=document.getElementById('editBrandName').value.trim();if(!name)return;
    try{const fd=new FormData();fd.append('name',name);fd.append('_method','PUT');if(editUploadedFile)fd.append('image',editUploadedFile);
    const res=await fetch(API.update(id),{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},body:fd});
    if(!res.ok)throw new Error('Gagal');const data=await res.json();closeEditModal();showToast(data.message);await fetchBrands();}catch(err){showToast(err.message,'error');}
});

function openDeleteModal(id){const b=brands.find(x=>x.id===id);if(!b)return;deleteTargetId=id;document.getElementById('deleteBrandName').textContent=b.name;document.getElementById('deleteModal').classList.remove('hidden');}
function closeDeleteModal(){document.getElementById('deleteModal').classList.add('hidden');deleteTargetId=null;}
document.getElementById('cancelDeleteBtn').onclick=closeDeleteModal;document.getElementById('deleteOverlay').onclick=closeDeleteModal;

document.getElementById('confirmDeleteBtn').addEventListener('click',async()=>{
    if(deleteTargetId===null)return;const btn=document.getElementById('confirmDeleteBtn');btn.disabled=true;btn.innerHTML='<i class="fa-solid fa-spinner fa-spin text-xs"></i>';
    try{const res=await fetch(API.delete(deleteTargetId),{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},body:JSON.stringify({_method:'DELETE'})});
    if(!res.ok)throw new Error('Gagal');const data=await res.json();closeDeleteModal();showToast(data.message,'info');await fetchBrands();}catch(err){showToast(err.message,'error');}finally{btn.disabled=false;btn.innerHTML='Hapus';}
});

document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeEditModal();closeDeleteModal();}});
document.addEventListener('DOMContentLoaded',()=>fetchBrands());
</script>
@endsection
