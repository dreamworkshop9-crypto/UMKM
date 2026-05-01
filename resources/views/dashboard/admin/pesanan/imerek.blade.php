

@section('content')
<div class="p-6 lg:p-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Manajemen Merek</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola semua data merek produk</p>
        </div>
        <div class="relative">
            <input type="text" id="searchInput" placeholder="Cari merek..."
                   class="w-60 pl-9 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl font-medium placeholder:text-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/12 outline-none transition-all"
                   aria-label="Cari merek">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        </div>
    </div>

    <div class="flex gap-6 items-start">

        <!-- ========== TABEL ========== -->
        <section class="flex-1">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <!-- Header tabel -->
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <i class="fa-solid fa-database text-emerald-600 text-xs"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Data Merek</h3>
                        <p class="text-[11px] text-gray-500 mt-0.5">Total <span id="brandCount" class="font-semibold text-emerald-600">0</span> merek terdaftar</p>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50/60">
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wider w-14">No.</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Merek</th>
                                <th class="text-left px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Slug</th>
                                <th class="text-center px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wider w-24">Gambar</th>
                                <th class="text-center px-6 py-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wider w-28">Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="brandTableBody">
                            <tr><td colspan="5" class="px-6 py-12 text-center">
                                <i class="fa-solid fa-spinner fa-spin text-2xl text-gray-300"></i>
                                <p class="text-sm text-gray-400 mt-2">Memuat data...</p>
                            </td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginasi -->
                <div class="px-6 py-3.5 border-t border-gray-100 bg-gray-50/40 flex items-center justify-between">
                    <p class="text-xs text-gray-500">Menampilkan <span class="font-semibold text-gray-700" id="showingCount">0</span> data</p>
                    <div class="flex items-center gap-1" id="pagination"></div>
                </div>
            </div>
        </section>

        <!-- ========== FORM TAMBAH ========== -->
        <aside class="w-96 flex-shrink-0">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden sticky top-24">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center shadow-sm shadow-emerald-500/25">
                        <i class="fa-solid fa-plus text-white text-xs"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900">Tambah Merek</h3>
                </div>

                <form id="addBrandForm" class="p-6 space-y-5" novalidate>
                    <!-- Nama -->
                    <div>
                        <label for="brandName" class="block text-xs font-semibold text-gray-700 mb-1.5">Merek <span class="text-red-500">*</span></label>
                        <input type="text" id="brandName" placeholder="Masukkan nama merek"
                               class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl font-medium placeholder:text-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/12 outline-none transition-all" required>
                        <p id="nameError" class="text-[11px] text-red-500 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Nama merek wajib diisi</p>
                    </div>

                    <!-- Upload Gambar -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Gambar <span class="text-red-500">*</span></label>
                        <div id="uploadZone" class="rounded-xl p-5 flex flex-col items-center justify-center cursor-pointer bg-gray-50/50 min-h-[140px] border-2 border-dashed border-gray-200 hover:border-emerald-500 hover:bg-emerald-50/30 transition-all" role="button" tabindex="0">
                            <div id="uploadPlaceholder" class="text-center">
                                <div class="w-11 h-11 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-2.5">
                                    <i class="fa-solid fa-cloud-arrow-up text-emerald-500 text-base"></i>
                                </div>
                                <p class="text-xs font-semibold text-gray-700">Klik atau seret gambar</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">PNG, JPG, SVG (Maks. 2MB)</p>
                            </div>
                            <div id="uploadPreview" class="hidden w-full text-center">
                                <img id="previewImg" src="" alt="Preview" class="w-16 h-16 rounded-lg object-contain mx-auto mb-2 bg-gray-100 border border-gray-200 p-1">
                                <p id="fileName" class="text-xs font-medium text-gray-700 truncate px-4"></p>
                                <button type="button" id="removeFile" class="text-[11px] text-red-500 font-semibold hover:text-red-600 mt-1.5 transition-colors"><i class="fa-solid fa-trash-can mr-0.5"></i>Hapus</button>
                            </div>
                        </div>
                        <input type="file" id="brandImage" accept="image/*" class="hidden">
                        <p id="imageError" class="text-[11px] text-red-500 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Gambar wajib diunggah</p>
                    </div>

                    <!-- Slug Preview -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Slug Preview</label>
                        <div class="w-full px-4 py-2.5 text-sm bg-gray-100 border border-gray-200 rounded-xl text-gray-500 font-medium truncate">
                            <span id="slugPreview" class="text-gray-600">—</span>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <button type="submit" id="submitBtn"
                            class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 flex items-center justify-center gap-2 hover:-translate-y-0.5 active:translate-y-0">
                        <i class="fa-solid fa-plus text-xs"></i>Tambah
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>

<!-- ========== MODAL EDIT ========== -->
<div id="editModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" id="editOverlay"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center"><i class="fa-solid fa-pen text-amber-500 text-xs"></i></div>
                <h3 class="text-sm font-bold text-gray-900">Edit Merek</h3>
            </div>
            <button id="closeEditBtn" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editBrandForm" class="p-6 space-y-5" novalidate>
            <input type="hidden" id="editBrandId">
            <div>
                <label for="editBrandName" class="block text-xs font-semibold text-gray-700 mb-1.5">Merek <span class="text-red-500">*</span></label>
                <input type="text" id="editBrandName" class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl font-medium focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/12 outline-none transition-all" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Gambar Saat Ini</label>
                <img id="editCurrentImg" src="" alt="Gambar" class="w-16 h-16 rounded-lg object-contain bg-gray-100 border border-gray-200 p-1">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Ganti Gambar (Opsional)</label>
                <div id="editUploadZone" class="rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer bg-gray-50/50 border-2 border-dashed border-gray-200 hover:border-emerald-500 hover:bg-emerald-50/30 transition-all" role="button" tabindex="0">
                    <p class="text-xs font-medium text-gray-500"><i class="fa-solid fa-cloud-arrow-up mr-1 text-gray-400"></i>Klik untuk ganti gambar</p>
                </div>
                <input type="file" id="editBrandImage" accept="image/*" class="hidden">
            </div>
            <div class="flex gap-3">
                <button type="button" id="cancelEditBtn" class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-xl shadow-sm shadow-emerald-500/20 transition-all hover:-translate-y-0.5 active:translate-y-0">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ========== MODAL HAPUS ========== -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" id="deleteOverlay"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4"><i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i></div>
            <h3 class="text-base font-bold text-gray-900 mb-1">Hapus Merek?</h3>
            <p class="text-sm text-gray-500">Merek <strong id="deleteBrandName" class="text-gray-700"></strong> akan dihapus permanen.</p>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="cancelDeleteBtn" class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition-colors">Batal</button>
            <button id="confirmDeleteBtn" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-xl shadow-sm shadow-red-500/20 transition-all hover:-translate-y-0.5 active:translate-y-0">Hapus</button>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toastContainer" class="fixed top-6 right-6 z-[60] space-y-3 pointer-events-none"></div>

@endsection

@push('scripts')
<style>
    @keyframes slideUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
    @keyframes fadeIn{from{opacity:0}to{opacity:1}}
    @keyframes toastIn{from{opacity:0;transform:translateX(100%) scale(.95)}to{opacity:1;transform:translateX(0) scale(1)}}
    @keyframes toastOut{from{opacity:1;transform:translateX(0) scale(1)}to{opacity:0;transform:translateX(100%) scale(.95)}}
    .anim-slide-up{animation:slideUp .5s cubic-bezier(.22,1,.36,1) both}
    .anim-fade{animation:fadeIn .35s ease both}
    .row-hover{transition:background .15s,box-shadow .15s}
    .row-hover:hover{background:#f0fdf6;box-shadow:inset 3px 0 0 #16a34a}
    .toast-in{animation:toastIn .35s cubic-bezier(.22,1,.36,1) forwards}
    .toast-out{animation:toastOut .25s ease forwards}
    .drag-over{border-color:#16a34a!important;background:#f0fdf6!important}
</style>

<script>
// === Konfigurasi Route ===
const API = {
    list:   '{{ route("brands.list") }}',
    store:  '{{ route("brands.store") }}',
    update: id => `{{ route("brands.update", "ID") }}`.replace('ID', id),
    delete: id => `{{ route("brands.destroy", "ID") }}`.replace('ID', id),
};

let brands = [];
let currentPage = 1;
const PER_PAGE = 5;
let uploadedFile = null;
let editUploadedFile = null;
let deleteTargetId = null;

function toSlug(t) { return t.toLowerCase().trim().replace(/[^\w\s-]/g,'').replace(/[\s_]+/g,'-').replace(/^-+|-+$/g,''); }

// Toast
function showToast(msg, type='success') {
    const c = document.getElementById('toastContainer');
    const icons = {success:'fa-circle-check text-emerald-500',error:'fa-circle-xmark text-red-500',info:'fa-circle-info text-sky-500'};
    const bdr = {success:'border-emerald-200',error:'border-red-200',info:'border-sky-200'};
    const el = document.createElement('div');
    el.className = `toast-in pointer-events-auto flex items-center gap-3 px-5 py-3.5 bg-white rounded-xl border ${bdr[type]} shadow-lg min-w-[280px]`;
    el.innerHTML = `<i class="fa-solid ${icons[type]} text-base"></i><span class="text-sm font-semibold text-gray-800 flex-1">${msg}</span><button class="text-gray-400 hover:text-gray-600 ml-2 ct" aria-label="Tutup"><i class="fa-solid fa-xmark text-xs"></i></button>`;
    c.appendChild(el);
    el.querySelector('.ct').onclick = () => killToast(el);
    setTimeout(() => killToast(el), 3500);
}
function killToast(el) { if(!el.parentElement) return; el.classList.replace('toast-in','toast-out'); setTimeout(()=>el.remove(),250); }

// Fetch data
async function fetchBrands(search='') {
    try {
        const url = search ? `${API.list}?search=${encodeURIComponent(search)}` : API.list;
        const res = await fetch(url);
        if (!res.ok) throw new Error('Gagal memuat data');
        brands = await res.json();
        renderTable(search);
    } catch(e) {
        showToast('Gagal memuat data dari server','error');
        document.getElementById('brandTableBody').innerHTML = `<tr><td colspan="5" class="px-6 py-12 text-center"><i class="fa-solid fa-circle-exclamation text-3xl text-red-300 mb-3 block"></i><p class="text-sm text-red-400">${e.message}</p></td></tr>`;
    }
}

// Render tabel
function renderTable(filter='') {
    const filtered = brands.filter(b => b.name.toLowerCase().includes(filter.toLowerCase()) || b.slug.toLowerCase().includes(filter.toLowerCase()));
    const totalPages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;
    const start = (currentPage-1)*PER_PAGE;
    const pageData = filtered.slice(start, start+PER_PAGE);
    const tbody = document.getElementById('brandTableBody');
    tbody.innerHTML = '';

    if (!pageData.length) {
        tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-12 text-center"><i class="fa-solid fa-box-open text-3xl text-gray-300 mb-3 block"></i><p class="text-sm text-gray-400">Tidak ada data ditemukan</p></td></tr>`;
    } else {
        pageData.forEach((b,i) => {
            const img = b.image_url || `https://picsum.photos/seed/fb${b.id}/80/80.jpg`;
            const tr = document.createElement('tr');
            tr.className = 'row-hover border-b border-gray-100 last:border-0 anim-fade';
            tr.style.animationDelay = `${i*0.04}s`;
            tr.innerHTML = `
                <td class="px-6 py-3.5 text-sm font-medium text-gray-500">${start+i+1}</td>
                <td class="px-6 py-3.5"><span class="text-sm font-semibold text-gray-800">${b.name}</span></td>
                <td class="px-6 py-3.5"><span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-50 border border-gray-200 text-[12px] font-mono font-medium text-gray-600">${b.slug}</span></td>
                <td class="px-6 py-3.5 text-center"><img src="${img}" alt="${b.name}" class="w-10 h-10 rounded-lg object-contain inline-block bg-gray-50 border border-gray-200 p-0.5 hover:scale-110 transition-transform duration-200"></td>
                <td class="px-6 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-1.5">
                        <button onclick="openEditModal(${b.id})" class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 flex items-center justify-center text-amber-600 hover:text-amber-700 transition-all hover:-translate-y-0.5 active:translate-y-0" title="Edit"><i class="fa-solid fa-pen text-[11px]"></i></button>
                        <button onclick="openDeleteModal(${b.id})" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center text-red-500 hover:text-red-600 transition-all hover:-translate-y-0.5 active:translate-y-0" title="Hapus"><i class="fa-solid fa-trash-can text-[11px]"></i></button>
                    </div>
                </td>`;
            tbody.appendChild(tr);
        });
    }

    // Paginasi
    const pag = document.getElementById('pagination');
    pag.innerHTML = '';
    if (totalPages > 1) {
        const mkBtn = (html, cls, fn) => { const b=document.createElement('button'); b.className=cls; b.innerHTML=html; if(fn) b.onclick=fn; pag.appendChild(b); };
        mkBtn('<i class="fa-solid fa-chevron-left"></i>', `w-8 h-8 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-xs transition-all ${currentPage===1?'text-gray-300 pointer-events-none':'text-gray-500 hover:text-gray-700 hover:-translate-y-0.5'}`, ()=>{currentPage--;renderTable(filter)});
        for(let p=1;p<=totalPages;p++) mkBtn(p, p===currentPage?'w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center text-xs font-bold shadow-sm shadow-emerald-500/25':'w-8 h-8 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-xs font-medium text-gray-500 hover:text-gray-700 hover:-translate-y-0.5 transition-all', ()=>{currentPage=p;renderTable(filter)});
        mkBtn('<i class="fa-solid fa-chevron-right"></i>', `w-8 h-8 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-xs transition-all ${currentPage===totalPages?'text-gray-300 pointer-events-none':'text-gray-500 hover:text-gray-700 hover:-translate-y-0.5'}`, ()=>{currentPage++;renderTable(filter)});
    }
    document.getElementById('brandCount').textContent = brands.length;
    document.getElementById('showingCount').textContent = filtered.length;
}

// Upload
const uz = document.getElementById('uploadZone');
uz.addEventListener('click', e => { if(!e.target.closest('#removeFile')) document.getElementById('brandImage').click(); });
uz.addEventListener('keydown', e => { if(e.key==='Enter'||e.key===' '){e.preventDefault();document.getElementById('brandImage').click()} });
uz.addEventListener('dragover', e => { e.preventDefault(); uz.classList.add('drag-over'); });
uz.addEventListener('dragleave', () => uz.classList.remove('drag-over'));
uz.addEventListener('drop', e => { e.preventDefault(); uz.classList.remove('drag-over'); if(e.dataTransfer.files.length) handleFile(e.dataTransfer.files[0]); });
document.getElementById('brandImage').addEventListener('change', e => { if(e.target.files.length) handleFile(e.target.files[0]); });

function handleFile(file) {
    if(!file.type.startsWith('image/')){showToast('File harus berupa gambar','error');return}
    if(file.size>2*1024*1024){showToast('Ukuran file maksimal 2MB','error');return}
    uploadedFile=file;
    const r=new FileReader();
    r.onload=e=>{document.getElementById('previewImg').src=e.target.result;document.getElementById('fileName').textContent=file.name;document.getElementById('uploadPlaceholder').classList.add('hidden');document.getElementById('uploadPreview').classList.remove('hidden')};
    r.readAsDataURL(file);
    document.getElementById('imageError').classList.add('hidden');
}
document.getElementById('removeFile').addEventListener('click',e=>{e.stopPropagation();uploadedFile=null;document.getElementById('brandImage').value='';document.getElementById('uploadPlaceholder').classList.remove('hidden');document.getElementById('uploadPreview').classList.add('hidden')});
document.getElementById('brandName').addEventListener('input',e=>{document.getElementById('slugPreview').textContent=toSlug(e.target.value)||'—';if(e.target.value.trim())document.getElementById('nameError').classList.add('hidden')});

// Tambah merek
document.getElementById('addBrandForm').addEventListener('submit', async e => {
    e.preventDefault();
    const name=document.getElementById('brandName').value.trim();
    let ok=true;
    if(!name){document.getElementById('nameError').classList.remove('hidden');ok=false}
    if(!uploadedFile){document.getElementById('imageError').classList.remove('hidden');ok=false}
    if(!ok) return;
    const btn=document.getElementById('submitBtn'); btn.disabled=true; btn.innerHTML='<i class="fa-solid fa-spinner fa-spin text-xs"></i>Menyimpan...';
    try {
        const fd=new FormData(); fd.append('name',name); fd.append('image',uploadedFile);
        const res=await fetch(API.store,{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},body:fd});
        if(!res.ok){const err=await res.json();throw new Error(err.message||'Gagal menyimpan')}
        const data=await res.json(); showToast(data.message);
        document.getElementById('brandName').value='';document.getElementById('slugPreview').textContent='—';uploadedFile=null;document.getElementById('brandImage').value='';document.getElementById('uploadPlaceholder').classList.remove('hidden');document.getElementById('uploadPreview').classList.add('hidden');
        currentPage=Math.ceil((brands.length+1)/PER_PAGE);
        await fetchBrands(document.getElementById('searchInput').value);
    } catch(err){showToast(err.message,'error')} finally{btn.disabled=false;btn.innerHTML='<i class="fa-solid fa-plus text-xs"></i>Tambah'}
});

// Pencarian
let st; document.getElementById('searchInput').addEventListener('input',e=>{clearTimeout(st);st=setTimeout(()=>{currentPage=1;fetchBrands(e.target.value)},300)});

// Edit
function openEditModal(id){const b=brands.find(x=>x.id===id);if(!b)return;document.getElementById('editBrandId').value=id;document.getElementById('editBrandName').value=b.name;document.getElementById('editCurrentImg').src=b.image_url||`https://picsum.photos/seed/fb${id}/80/80.jpg`;editUploadedFile=null;document.getElementById('editBrandImage').value='';document.getElementById('editUploadZone').innerHTML='<p class="text-xs font-medium text-gray-500"><i class="fa-solid fa-cloud-arrow-up mr-1 text-gray-400"></i>Klik untuk ganti gambar</p>';document.getElementById('editModal').classList.remove('hidden')}
function closeEditModal(){document.getElementById('editModal').classList.add('hidden')}
document.getElementById('closeEditBtn').onclick=closeEditModal;
document.getElementById('cancelEditBtn').onclick=closeEditModal;
document.getElementById('editOverlay').onclick=closeEditModal;
document.getElementById('editUploadZone').addEventListener('click',()=>document.getElementById('editBrandImage').click());
document.getElementById('editBrandImage').addEventListener('change',e=>{if(e.target.files.length){editUploadedFile=e.target.files[0];document.getElementById('editUploadZone').innerHTML=`<p class="text-xs font-medium text-emerald-600"><i class="fa-solid fa-check-circle mr-1"></i>${editUploadedFile.name}</p>`}});

document.getElementById('editBrandForm').addEventListener('submit', async e => {
    e.preventDefault();
    const id=parseInt(document.getElementById('editBrandId').value), name=document.getElementById('editBrandName').value.trim();
    if(!name)return;
    try {
        const fd=new FormData(); fd.append('name',name); fd.append('_method','PUT');
        if(editUploadedFile) fd.append('image',editUploadedFile);
        const res=await fetch(API.update(id),{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},body:fd});
        if(!res.ok){const err=await res.json();throw new Error(err.message||'Gagal memperbarui')}
        const data=await res.json(); closeEditModal(); showToast(data.message); await fetchBrands(document.getElementById('searchInput').value);
    } catch(err){showToast(err.message,'error')}
});

// Hapus
function openDeleteModal(id){const b=brands.find(x=>x.id===id);if(!b)return;deleteTargetId=id;document.getElementById('deleteBrandName').textContent=b.name;document.getElementById('deleteModal').classList.remove('hidden')}
function closeDeleteModal(){document.getElementById('deleteModal').classList.add('hidden');deleteTargetId=null}
document.getElementById('cancelDeleteBtn').onclick=closeDeleteModal;
document.getElementById('deleteOverlay').onclick=closeDeleteModal;
document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
    if(deleteTargetId===null)return;
    const btn=document.getElementById('confirmDeleteBtn'); btn.disabled=true; btn.innerHTML='<i class="fa-solid fa-spinner fa-spin text-xs"></i>';
    try {
        const res=await fetch(API.delete(deleteTargetId),{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},body:JSON.stringify({_method:'DELETE'})});
        if(!res.ok) throw new Error('Gagal menghapus');
        const data=await res.json(); closeDeleteModal(); showToast(data.message,'info'); await fetchBrands(document.getElementById('searchInput').value);
    } catch(err){showToast(err.message,'error')} finally{btn.disabled=false;btn.innerHTML='Hapus'}
});

document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeEditModal();closeDeleteModal()}});
document.addEventListener('DOMContentLoaded',()=>fetchBrands());
</script>
@endpush