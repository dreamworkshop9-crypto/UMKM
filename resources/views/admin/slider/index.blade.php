@extends('layouts.admin')

@section('title', 'Slider - SALZA')
@section('page-title', 'Data Slider')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
@endsection

@section('content')
<div class="flex gap-6 items-start">    

    <!-- Tabel -->
    <div class="flex-1 min-w-0">
        <div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-images text-purple-400 text-xs"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-white">Data Slider</h2>
                        <p class="text-xs text-slate-500">Total <span id="sliderCount" class="text-purple-400 font-semibold">0</span> slider</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-700/20 text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                            <th class="px-6 py-3 w-12">No.</th>
                            <th class="px-6 py-3 w-56">Gambar</th>
                            <th class="px-6 py-3">Judul</th>
                            <th class="px-6 py-3">Deskripsi</th>
                            <th class="px-6 py-3 w-24 text-center">Status</th>
                            <th class="px-6 py-3 w-28 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody id="sliderTableBody" class="divide-y divide-slate-700/50">
                        <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <i class="fa-solid fa-spinner fa-spin text-xl mb-2"></i>
                            <p class="text-sm">Memuat data...</p>
                        </td></tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-slate-700/50 flex items-center justify-between">
                <p class="text-xs text-slate-500">Showing <span id="showingFrom" class="text-slate-300 font-semibold">0</span> to <span id="showingTo" class="text-slate-300 font-semibold">0</span> of <span id="showingTotal" class="text-slate-300 font-semibold">0</span> entries</p>
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
                <h3 class="text-sm font-bold text-white">Tambah Slider</h3>
            </div>
            <form id="addForm" class="p-6 space-y-4" novalidate>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Judul <span class="text-red-400">*</span></label>
                    <input type="text" id="inputTitle" placeholder="Masukkan judul slider" class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none" required>
                    <p id="titleError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Judul wajib diisi</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi</label>
                    <textarea id="inputDesc" rows="3" placeholder="Deskripsi slider (opsional)" class="w-full px-4 py-2.5 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Gambar <span class="text-red-400">*</span></label>
                    <div id="uploadZone" class="upload-zone rounded-xl p-5 flex flex-col items-center justify-center cursor-pointer min-h-[140px]">
                        <div id="uploadPlaceholder" class="text-center">
                            <div class="w-11 h-11 rounded-full bg-purple-50 flex items-center justify-center mx-auto mb-2.5">
                                <i class="fa-solid fa-cloud-arrow-up text-purple-500 text-base"></i>
                            </div>
                            <p class="text-xs font-semibold text-slate-400">Klik atau seret gambar</p>
                            <p class="text-[11px] text-slate-600 mt-0.5">PNG, JPG, SVG, WebP (Maks. 2MB)</p>
                        </div>
                        <div id="uploadPreview" class="hidden w-full text-center">
                            <img id="previewImg" src="" alt="Preview" class="slider-img mx-auto mb-2">
                            <p id="fileName" class="text-xs font-medium text-slate-300 truncate px-4"></p>
                            <button type="button" id="removeFile" class="text-[11px] text-red-400 font-semibold hover:text-red-300 mt-1.5 transition-colors"><i class="fa-solid fa-trash-can mr-0.5"></i>Hapus</button>
                        </div>
                    </div>
                    <input type="file" id="inputImage" accept="image/*" class="hidden">
                    <p id="imageError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Gambar wajib diunggah</p>
                </div>
                <button type="submit" id="submitBtn" class="btn-act w-full py-3 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-xl shadow-md shadow-purple-500/20 hover:shadow-lg hover:shadow-purple-500/30 transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>Tambah
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
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center"><i class="fa-solid fa-pen text-amber-500 text-xs"></i></div>
                <h3 class="text-sm font-bold text-white">Edit Slider</h3>
            </div>
            <button id="closeEditBtn" class="w-8 h-8 rounded-lg hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
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
                    <p class="text-xs text-slate-500"><i class="fa-solid fa-cloud-arrow-up mr-1"></i>Klik untuk ganti gambar</p>
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
            <div class="w-14 h-14 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-4"><i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i></div>
            <h3 class="text-base font-bold text-white mb-1">Hapus Slider?</h3>
            <p class="text-sm text-slate-400">Slider <strong id="deleteName" class="text-slate-300"></strong> akan dihapus permanen.</p>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="cancelDeleteBtn" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors">Batal</button>
            <button id="confirmDeleteBtn" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-lg shadow-sm shadow-red-500/20 transition-all">Hapus</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const API = {
    list:   '{{ route("admin.slider.list") }}',
    store:  '{{ route("admin.slider.store") }}',
    show:   id => `{{ route("admin.slider.show", "ID") }}`.replace('ID', id),
    update: id => `{{ route("admin.slider.update", "ID") }}`.replace('ID', id),
    delete: id => `{{ route("admin.slider.destroy", "ID") }}`.replace('ID', id),
};

let items = [], currentPage = 1, PER_PAGE = 5, uploadedFile = null, editUploadedFile = null, deleteTargetId = null;

function showToast(msg,type='success'){
    let c=document.getElementById('toastContainer');
    if(!c){c=document.createElement('div');c.id='toastContainer';c.className='fixed top-6 right-6 z-[60] space-y-3 pointer-events-none';document.body.appendChild(c)}
    const icons={success:'fa-circle-check text-emerald-400',error:'fa-circle-xmark text-red-400',info:'fa-circle-info text-sky-400'};
    const el=document.createElement('div');
    el.className='toast-in pointer-events-auto flex items-center gap-3 px-5 py-3 bg-slate-800 rounded-xl border border-slate-700/50 shadow-lg min-w-[280px]';
    el.innerHTML=`<i class="fa-solid ${icons[type]}"></i><span class="text-sm font-semibold text-white flex-1">${msg}</span>`;
    c.appendChild(el);setTimeout(()=>{el.classList.replace('toast-in','toast-out');setTimeout(()=>el.remove(),250)},3000);
}

async function fetchData(search=''){
    try{const url=search?`${API.list}?search=${encodeURIComponent(search)}`:API.list;const r=await fetch(url);if(!r.ok)throw new Error();items=await r.json();renderTable(search);}catch(e){showToast('Gagal memuat data','error')}
}

function renderTable(filter=''){
    const f=items.filter(b=>b.title.toLowerCase().includes(filter.toLowerCase()));
    const tp=Math.max(1,Math.ceil(f.length/PER_PAGE));if(currentPage>tp)currentPage=tp;
    const s=(currentPage-1)*PER_PAGE,e=s+PER_PAGE,pd=f.slice(s,e),tb=document.getElementById('sliderTableBody');tb.innerHTML='';
    if(!pd.length){tb.innerHTML='<tr><td colspan="6" class="px-6 py-12 text-center text-slate-500 italic">Tidak ada data.</td></tr>';return;}
    pd.forEach((sl,i)=>{
        const img=sl.image_url||'https://picsum.photos/seed/slider'+sl.id+'/400/160.jpg';
        const tr=document.createElement('tr');tr.className='row-hover';
        tr.innerHTML=`
            <td class="px-6 py-3 text-sm text-slate-500">${s+i+1}</td>
            <td class="px-6 py-3"><img src="${img}" alt="${sl.title}" class="rounded-lg border border-slate-700/50"></td>
            <td class="px-6 py-3 text-sm font-semibold text-white">${sl.title}</td>
            <td class="px-6 py-3 text-sm text-slate-400 max-w-[200px] truncate">${sl.description||'<span class="italic text-slate-600">Tidak ada</span>'}</td>
            <td class="px-6 py-3 text-center"><span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold ${sl.is_active?'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20':'bg-red-500/10 text-red-400 border border-red-500/20'}"><span class="w-1.5 h-1.5 rounded-full ${sl.is_active?'bg-emerald-400':'bg-red-400'}"></span>${sl.is_active?'Aktif':'Tidak Aktif'}</span></td>
            <td class="px-6 py-3 text-center"><div class="flex items-center justify-center gap-1">
                <button onclick="openEdit(${sl.id})" class="w-8 h-8 rounded-lg bg-amber-500/10 hover:bg-amber-500/20 flex items-center justify-center text-amber-400 hover:text-amber-300 transition-colors" title="Edit"><i class="fa-solid fa-pen text-xs"></i></button>
                <button onclick="openDelete(${sl.id})" class="w-8 h-8 rounded-lg bg-red-500/10 hover:bg-red-500/20 flex items-center justify-center text-red-400 hover:text-red-300 transition-colors" title="Hapus"><i class="fa-solid fa-trash-can text-xs"></i></button>
            </div></td>`;
        tb.appendChild(tr);
    });
    // Info footer
    const from=s+1, to=Math.min(e,f.length);
    document.getElementById('showingFrom').textContent=from;
    document.getElementById('showingTo').textContent=to;
    document.getElementById('showingTotal').textContent=f.length;
    document.getElementById('sliderCount').textContent=items.length;

    // Paginasi
    const pg=document.getElementById('pagination');pg.innerHTML='';
    if(tp>1){
        const mk=(h,c,fn)=>{const b=document.createElement('button');b.className=c;b.innerHTML=h;b.onclick=fn;pg.appendChild(b)};
        mk('<i class="fa-solid fa-chevron-left text-[10px]"></i>','w-8 h-8 rounded-lg border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs '+(currentPage===1?'text-slate-600 pointer-events-none':'text-slate-400 hover:text-white'),()=>{currentPage--;renderTable(filter)});
        for(let p=1;p<=tp;p++)mk(p,p===currentPage?'w-8 h-8 rounded-lg bg-purple-600 text-white flex items-center justify-center text-xs font-bold shadow-sm shadow-purple-500/25':'w-8 h-8 rounded-lg border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs text-slate-400 hover:text-white',()=>{currentPage=p;renderTable(filter)});
        mk('<i class="fa-solid fa-chevron-right text-[10px]"></i>','w-8 h-8 rounded-lg border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs '+(currentPage===tp?'text-slate-600 pointer-events-none':'text-slate-400 hover:text-white'),()=>{currentPage++;renderTable(filter)});
    }
}

// Upload
const uz=document.getElementById('uploadZone');
uz.addEventListener('click',e=>{if(!e.target.closest('#removeFile'))document.getElementById('inputImage').click()});
uz.addEventListener('dragover',e=>{e.preventDefault();uz.classList.add('drag-over')});
uz.addEventListener('dragleave',()=>uz.classList.remove('drag-over'));
uz.addEventListener('drop',e=>{e.preventDefault();uz.classList.remove('drag-over');if(e.dataTransfer.files.length)handleFile(e.dataTransfer.files[0])});
document.getElementById('inputImage').addEventListener('change',e=>{if(e.target.files.length)handleFile(e.target.files[0])});

function handleFile(file){
    if(!file.type.startsWith('image/')){showToast('File harus berupa gambar','error');return}
    if(file.size>2*1024*1024){showToast('Maks 2MB','error');return}
    uploadedFile=file;const r=new FileReader();
    r.onload=e=>{document.getElementById('previewImg').src=e.target.result;document.getElementById('fileName').textContent=file.name;document.getElementById('uploadPlaceholder').classList.add('hidden');document.getElementById('uploadPreview').classList.remove('hidden')};
    r.readAsDataURL(file);document.getElementById('imageError').classList.add('hidden');
}
document.getElementById('removeFile').addEventListener('click',e=>{e.stopPropagation();uploadedFile=null;document.getElementById('inputImage').value='';document.getElementById('uploadPlaceholder').classList.remove('hidden');document.getElementById('uploadPreview').classList.add('hidden')});
document.getElementById('inputTitle').addEventListener('input',e=>{if(e.target.value.trim())document.getElementById('titleError').classList.add('hidden')});

// Tambah
document.getElementById('addForm').addEventListener('submit',async e=>{
    e.preventDefault();const title=document.getElementById('inputTitle').value.trim();let ok=true;
    if(!title){document.getElementById('titleError').classList.remove('hidden');ok=false}
    if(!uploadedFile){document.getElementById('imageError').classList.remove('hidden');ok=false}
    if(!ok)return;
    const btn=document.getElementById('submitBtn');btn.disabled=true;btn.innerHTML='<i class="fa-solid fa-spinner fa-spin text-xs"></i>Menyimpan...';
    try{const fd=new FormData();fd.append('title',title);fd.append('description',document.getElementById('inputDesc').value);fd.append('image',uploadedFile);
    const r=await fetch(API.store,{method:'POST',headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},body:fd});
    if(!r.ok)throw new Error();const d=await r.json();showToast(d.message);
    document.getElementById('inputTitle').value='';document.getElementById('inputDesc').value='';
    uploadedFile=null;document.getElementById('inputImage').value='';document.getElementById('uploadPlaceholder').classList.remove('hidden');document.getElementById('uploadPreview').classList.add('hidden');
    currentPage=Math.ceil((items.length+1)/PER_PAGE);await fetchData();}
    catch(err){showToast('Gagal menyimpan','error')}finally{btn.disabled=false;btn.innerHTML='<i class="fa-solid fa-plus text-xs"></i>Tambah'}
});

// Edit
function openEdit(id){const sl=items.find(x=>x.id===id);if(!sl)return;
    document.getElementById('editId').value=id;document.getElementById('editTitle').value=sl.title;
    document.getElementById('editDesc').value=sl.description||'';
    document.getElementById('editCurrentImg').src=sl.image_url||'https://picsum.photos/seed/slider'+id+'/400/160.jpg';
    document.getElementById(sl.is_active?'editStatusOn':'editStatusOff').checked=true;
    editUploadedFile=null;document.getElementById('editImage').value='';
    document.getElementById('editUploadZone').innerHTML='<p class="text-xs text-slate-500"><i class="fa-solid fa-cloud-arrow-up mr-1"></i>Klik untuk ganti gambar</p>';
    document.getElementById('editModal').classList.remove('hidden');
}
function closeEdit(){document.getElementById('editModal').classList.add('hidden')}
document.getElementById('closeEditBtn').onclick=closeEdit;document.getElementById('cancelEditBtn').onclick=closeEdit;document.getElementById('editOverlay').onclick=closeEdit;
document.getElementById('editUploadZone').addEventListener('click',()=>document.getElementById('editImage').click());
document.getElementById('editImage').addEventListener('change',e=>{if(e.target.files.length){editUploadedFile=e.target.files[0];document.getElementById('editUploadZone').innerHTML=`<p class="text-xs text-emerald-400"><i class="fa-solid fa-check-circle mr-1"></i>${editUploadedFile.name}</p>`}});

document.getElementById('editForm').addEventListener('submit',async e=>{
    e.preventDefault();const id=parseInt(document.getElementById('editId').value),title=document.getElementById('editTitle').value.trim();
    if(!title){showToast('Judul wajib diisi','error');return}
    try{const fd=new FormData();fd.append('title',title);fd.append('_method','PUT');
    fd.append('description',document.getElementById('editDesc').value);
    fd.append('is_active',document.querySelector('input[name="editStatus"]:checked').value);
    if(editUploadedFile)fd.append('image',editUploadedFile);
    const r=await fetch(API.update(id),{method:'POST',headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},body:fd});
    if(!r.ok)throw new Error();const d=await r.json();closeEdit();showToast(d.message);await fetchData();}
    catch(err){showToast('Gagal memperbarui','error')}
});

// Hapus
function openDelete(id){const sl=items.find(x=>x.id===id);if(!sl)return;deleteTargetId=id;document.getElementById('deleteName').textContent=sl.title;document.getElementById('deleteModal').classList.remove('hidden')}
function closeDelete(){document.getElementById('deleteModal').classList.add('hidden');deleteTargetId=null}
document.getElementById('cancelDeleteBtn').onclick=closeDelete;document.getElementById('deleteOverlay').onclick=closeDelete;
document.getElementById('confirmDeleteBtn').addEventListener('click',async()=>{
    if(deleteTargetId===null)return;const btn=document.getElementById('confirmDeleteBtn');btn.disabled=true;btn.innerHTML='<i class="fa-solid fa-spinner fa-spin text-xs"></i>';
    try{const r=await fetch(API.delete(deleteTargetId),{method:'POST',headers:{'X-CSRF-TOKEN':'{{csrf_token()}}','Content-Type':'application/json'},body:JSON.stringify({_method:'DELETE'})});
    if(!r.ok)throw new Error();const d=await r.json();closeDelete();showToast(d.message,'info');await fetchData();}
    catch(err){showToast('Gagal menghapus','error')}finally{btn.disabled=false;btn.innerHTML='Hapus'}
});

document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeEdit();closeDelete()}});
document.addEventListener('DOMContentLoaded',()=>fetchData());
</script>
@endsection
