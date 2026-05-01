@extends('layouts.admin')

@section('title', 'Data Produk - SALZA')
@section('page-title', 'Data Produk')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.row-hover{transition:background .15s,box-shadow .15s}
.row-hover:hover{background:rgba(139,92,246,.08);box-shadow:inset 3px 0 0 #a855f7}
@keyframes toastIn{from{opacity:0;transform:translateX(100%)}to{opacity:1;transform:translateX(0)}}
@keyframes toastOut{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(100%)}}
.toast-in{animation:toastIn .3s ease forwards}
.toast-out{animation:toastOut .25s ease forwards}
.size-tag{display:inline-block;padding:1px 6px;border-radius:4px;font-size:10px;font-weight:600;background:rgba(139,92,246,.1);color:#c084fc;border:1px solid rgba(139,92,246,.2)}
.color-dot{display:inline-block;width:14px;height:14px;border-radius:50%;border:2px solid rgba(255,255,255,.15);vertical-align:middle;margin-right:2px}
</style>
@endsection

@section('content')
<div class="bg-dashboard-card rounded-xl border border-slate-700/30 overflow-hidden">
    <div class="p-6 border-b border-slate-700/50 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                <i class="fa-solid fa-box text-purple-400 text-xs"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-white">Data Produk</h2>
                <p class="text-xs text-slate-500">Total <span id="produkCount" class="text-purple-400 font-semibold">0</span> produk</p>
            </div>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-lg transition-colors flex items-center gap-2 shadow-md shadow-purple-500/20">
            <i class="fa-solid fa-plus text-xs"></i>Tambah Produk
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-700/20 text-slate-400 uppercase text-[11px] font-bold tracking-widest">
                    <th class="px-5 py-3 w-12">No</th>
                    <th class="px-5 py-3 w-16">Gambar</th>
                    <th class="px-5 py-3">Produk</th>
                    <th class="px-5 py-3">Merek</th>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3">Ukuran</th>
                    <th class="px-5 py-3">Warna</th>
                    <th class="px-5 py-3 text-right">Harga</th>
                    <th class="px-5 py-3 text-center">Stok</th>
                    <th class="px-5 py-3 w-28 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody id="produkTableBody" class="divide-y divide-slate-700/50">
                <tr><td colspan="10" class="px-6 py-12 text-center text-slate-500">
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

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="editOverlay"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-slate-800 rounded-2xl border border-slate-700/50 shadow-2xl overflow-hidden max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-slate-700/50 flex items-center justify-between sticky top-0 bg-slate-800 z-10">
            <h3 class="text-sm font-bold text-white">Edit Produk</h3>
            <button id="closeEditBtn" class="w-8 h-8 rounded-lg hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editForm" class="p-6 space-y-4" novalidate>
            <input type="hidden" id="editId">
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Produk <span class="text-red-400">*</span></label>
                <input type="text" id="editName" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Merek</label>
                    <select id="editBrand" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none"></select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Kategori</label>
                    <select id="editKategori" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none"></select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Harga (Rp)</label>
                    <input type="number" id="editPrice" min="0" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Stok</label>
                    <input type="number" id="editStock" min="0" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Ukuran <span class="text-red-400">*</span> <span class="text-slate-600 font-normal">(klik untuk pilih)</span></label>
                <div id="editSizePicker" class="flex flex-wrap gap-2 p-3 bg-slate-900 border border-slate-700/50 rounded-lg min-h-[42px]"></div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Warna <span class="text-red-400">*</span> <span class="text-slate-600 font-normal">(klik untuk pilih)</span></label>
                <div id="editColorPicker" class="flex flex-wrap gap-2 p-3 bg-slate-900 border border-slate-700/50 rounded-lg min-h-[42px]"></div>
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
                <input type="file" id="editImage" accept="image/*" class="hidden">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi</label>
                <textarea id="editDesc" rows="2" class="w-full px-4 py-2.5 text-sm bg-slate-900 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none resize-none"></textarea>
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
            <h3 class="text-base font-bold text-white mb-1">Hapus Produk?</h3>
            <p class="text-sm text-slate-400">Produk <strong id="deleteName" class="text-slate-300"></strong> akan dihapus permanen.</p>
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
const SIZES = ['36','37','38','39','40','41','42','43','44','45'];
const COLORS = [
    {name:'Hitam',hex:'#1a1a1a'},{name:'Putih',hex:'#f5f5f5'},{name:'Merah',hex:'#dc2626'},
    {name:'Navy',hex:'#1e3a5f'},{name:'Abu-abu',hex:'#6b7280'},{name:'Coklat',hex:'#78350f'},
    {name:'Krem',hex:'#d4c5a9'},{name:'Hijau',hex:'#16a34a'},{name:'Biru',hex:'#2563eb'},
];
const API = {
    list:'{{route("admin.produk.list")}}',options:'{{route("admin.produk.options")}}',
    show:id=>`{{route("admin.produk.show","ID")}}`.replace('ID',id),
    update:id=>`{{route("admin.produk.update","ID")}}`.replace('ID',id),
    delete:id=>`{{route("admin.produk.destroy","ID")}}`.replace('ID',id),
};
let items=[],brands=[],kategoris=[],currentPage=1,PER_PAGE=5,editUploadedFile=null,deleteTargetId=null,editSizes=[],editColors=[];
function formatRp(n){return'Rp'+Number(n).toLocaleString('id-ID')}
function renderDots(colors,limit=4){if(!colors||!colors.length)return'<span class="text-slate-600 italic text-xs">-</span>';const shown=colors.slice(0,limit);const extra=colors.length-limit;return shown.map(c=>{const col=COLORS.find(x=>x.name===c);const bg=col?col.hex:'#6b7280';return`<span class="color-dot" style="background:${bg}" title="${c}"></span>`;}).join('')+(extra>0?`<span class="text-[10px] text-slate-500 ml-1">+${extra}</span>`:'');}
function renderTags(sizes,limit=4){if(!sizes||!sizes.length)return'<span class="text-slate-600 italic text-xs">-</span>';const shown=sizes.slice(0,limit);const extra=sizes.length-limit;return shown.map(s=>`<span class="size-tag">${s}</span>`).join(' ')+(extra>0?`<span class="text-[10px] text-slate-500 ml-1">+${extra}</span>`:'');}

function showToast(msg,type='success'){let c=document.getElementById('toastContainer');if(!c){c=document.createElement('div');c.id='toastContainer';c.className='fixed top-6 right-6 z-[60] space-y-3 pointer-events-none';document.body.appendChild(c)}const icons={success:'fa-circle-check text-emerald-400',error:'fa-circle-xmark text-red-400',info:'fa-circle-info text-sky-400'};const el=document.createElement('div');el.className='toast-in pointer-events-auto flex items-center gap-3 px-5 py-3 bg-slate-800 rounded-xl border border-slate-700/50 shadow-lg min-w-[280px]';el.innerHTML=`<i class="fa-solid ${icons[type]}"></i><span class="text-sm font-semibold text-white flex-1">${msg}</span>`;c.appendChild(el);setTimeout(()=>{el.classList.replace('toast-in','toast-out');setTimeout(()=>el.remove(),250)},3000)}

async function loadOptions(){try{const r=await fetch(API.options);if(!r.ok)throw new Error();const d=await r.json();brands=d.brands;kategoris=d.kategoris;}catch(e){showToast('Gagal memuat opsi','error')}}
async function fetchData(search=''){try{const u=search?`${API.list}?search=${encodeURIComponent(search)}`:API.list;const r=await fetch(u);if(!r.ok)throw new Error();items=await r.json();renderTable(search);}catch(e){showToast('Gagal memuat data','error')}}

function renderTable(filter=''){
    const f=items.filter(b=>b.name.toLowerCase().includes(filter.toLowerCase())||b.slug.toLowerCase().includes(filter.toLowerCase()));
    const tp=Math.max(1,Math.ceil(f.length/PER_PAGE));if(currentPage>tp)currentPage=tp;
    const s=(currentPage-1)*PER_PAGE,pd=f.slice(s,s+PER_PAGE),tb=document.getElementById('produkTableBody');tb.innerHTML='';
    if(!pd.length){tb.innerHTML='<tr><td colspan="10" class="px-6 py-12 text-center text-slate-500 italic">Tidak ada data.</td></tr>';return;}
    pd.forEach((p,i)=>{const img=p.image_url||'https://picsum.photos/seed/fp'+p.id+'/80/80.jpg';const tr=document.createElement('tr');tr.className='row-hover';
    tr.innerHTML=`<td class="px-5 py-3 text-sm text-slate-500">${s+i+1}</td>
        <td class="px-5 py-3 text-center"><img src="${img}" alt="${p.name}" class="w-9 h-9 rounded-lg object-contain inline-block bg-slate-800 border border-slate-700/50 p-0.5"></td>
        <td class="px-5 py-3"><p class="text-sm font-semibold text-white">${p.name}</p><p class="text-[11px] text-slate-500 truncate max-w-[140px]">${p.description||''}</p></td>
        <td class="px-5 py-3 text-sm text-slate-400">${p.brand?p.brand.name:'<span class="italic text-slate-600">-</span>'}</td>
        <td class="px-5 py-3"><span class="inline-block px-2 py-0.5 rounded text-[11px] font-medium ${p.kategori?'bg-purple-500/10 text-purple-400 border border-purple-500/20':'text-slate-600 italic'}">${p.kategori?p.kategori.name:'-'}</span></td>
        <td class="px-5 py-3">${renderTags(p.sizes)}</td>
        <td class="px-5 py-3">${renderDots(p.colors)}</td>
        <td class="px-5 py-3 text-sm text-emerald-400 font-semibold text-right">${formatRp(p.price)}</td>
        <td class="px-5 py-3 text-center"><span class="inline-block px-2 py-0.5 rounded text-xs font-semibold ${p.stock>0?'bg-emerald-500/10 text-emerald-400':'bg-red-500/10 text-red-400'}">${p.stock}</span></td>
        <td class="px-5 py-3 text-center"><div class="flex items-center justify-center gap-1"><button onclick="openEdit(${p.id})" class="w-7 h-7 rounded bg-amber-500/10 hover:bg-amber-500/20 flex items-center justify-center text-amber-400 hover:text-amber-300 transition-colors" title="Edit"><i class="fa-solid fa-pen text-[10px]"></i></button><button onclick="openDelete(${p.id})" class="w-7 h-7 rounded bg-red-500/10 hover:bg-red-500/20 flex items-center justify-center text-red-400 hover:text-red-300 transition-colors" title="Hapus"><i class="fa-solid fa-trash-can text-[10px]"></i></button></div></td>`;
    tb.appendChild(tr);});
    document.getElementById('produkCount').textContent=items.length;document.getElementById('showingCount').textContent=f.length;
    const pg=document.getElementById('pagination');pg.innerHTML='';
    if(tp>1){const mk=(h,c,fn)=>{const b=document.createElement('button');b.className=c;b.innerHTML=h;b.onclick=fn;pg.appendChild(b)};mk('<i class="fa-solid fa-chevron-left text-[10px]"></i>','w-7 h-7 rounded border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs '+(currentPage===1?'text-slate-600 pointer-events-none':'text-slate-400 hover:text-white'),()=>{currentPage--;renderTable(filter)});for(let p=1;p<=tp;p++)mk(p,p===currentPage?'w-7 h-7 rounded bg-purple-600 text-white flex items-center justify-center text-xs font-bold':'w-7 h-7 rounded border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs text-slate-400 hover:text-white',()=>{currentPage=p;renderTable(filter)});mk('<i class="fa-solid fa-chevron-right text-[10px]"></i>','w-7 h-7 rounded border border-slate-700/50 bg-slate-800 flex items-center justify-center text-xs '+(currentPage===tp?'text-slate-600 pointer-events-none':'text-slate-400 hover:text-white'),()=>{currentPage++;renderTable(filter)})}
}

function buildSizePicker(container,selected=[]){container.innerHTML='';SIZES.forEach(s=>{const active=selected.includes(s);const btn=document.createElement('button');btn.type='button';btn.className=`px-3 py-1.5 rounded-lg text-xs font-semibold border transition-all ${active?'bg-purple-600 border-purple-500 text-white shadow-sm shadow-purple-500/20':'bg-slate-900 border-slate-700/50 text-slate-400 hover:border-purple-500 hover:text-purple-400'}`;btn.textContent=s;btn.onclick=()=>{if(editSizes.includes(s))editSizes=editSizes.filter(x=>x!==s);else editSizes.push(s);buildSizePicker(container,editSizes)};container.appendChild(btn)})}
function buildColorPicker(container,selected=[]){container.innerHTML='';COLORS.forEach(c=>{const active=selected.includes(c.name);const btn=document.createElement('button');btn.type='button';btn.className=`w-8 h-8 rounded-lg border-2 transition-all flex items-center justify-center ${active?'border-purple-400 scale-110 shadow-md':'border-slate-700/50 hover:border-slate-500 scale-100'}`;btn.style.background=c.hex;btn.title=c.name;btn.innerHTML=active?'<i class="fa-solid fa-check text-[9px] text-white drop-shadow"></i>':'';btn.onclick=()=>{if(editColors.includes(c.name))editColors=editColors.filter(x=>x!==c.name);else editColors.push(c.name);buildColorPicker(container,editColors)};container.appendChild(btn)})}

function openEdit(id){const p=items.find(x=>x.id===id);if(!p)return;document.getElementById('editId').value=id;document.getElementById('editName').value=p.name;document.getElementById('editPrice').value=p.price;document.getElementById('editStock').value=p.stock;document.getElementById('editDesc').value=p.description||'';document.getElementById('editCurrentImg').src=p.image_url||'https://picsum.photos/seed/fp'+id+'/80/80.jpg';document.getElementById('editBrand').innerHTML='<option value="">-- Pilih --</option>'+brands.map(b=>`<option value="${b.id}" ${p.brand&&p.brand.id==b.id?'selected':''}>${b.name}</option>`).join('');document.getElementById('editKategori').innerHTML='<option value="">-- Pilih --</option>'+kategoris.map(k=>`<option value="${k.id}" ${p.kategori&&p.kategori.id==k.id?'selected':''}>${k.name}</option>`).join('');editSizes=p.sizes?[...p.sizes]:[];editColors=p.colors?[...p.colors]:[];buildSizePicker(document.getElementById('editSizePicker'),editSizes);buildColorPicker(document.getElementById('editColorPicker'),editColors);editUploadedFile=null;document.getElementById('editImage').value='';document.getElementById('editUploadZone').innerHTML='<p class="text-xs text-slate-500"><i class="fa-solid fa-cloud-arrow-up mr-1"></i>Klik untuk ganti</p>';document.getElementById('editModal').classList.remove('hidden')}
function closeEdit(){document.getElementById('editModal').classList.add('hidden')}
document.getElementById('closeEditBtn').onclick=closeEdit;document.getElementById('cancelEditBtn').onclick=closeEdit;document.getElementById('editOverlay').onclick=closeEdit;
document.getElementById('editUploadZone').addEventListener('click',()=>document.getElementById('editImage').click());
document.getElementById('editImage').addEventListener('change',e=>{if(e.target.files.length){editUploadedFile=e.target.files[0];document.getElementById('editUploadZone').innerHTML=`<p class="text-xs text-emerald-400"><i class="fa-solid fa-check-circle mr-1"></i>${editUploadedFile.name}</p>`}});

document.getElementById('editForm').addEventListener('submit',async e=>{e.preventDefault();const id=parseInt(document.getElementById('editId').value),name=document.getElementById('editName').value.trim();if(!name||!editSizes.length||!editColors.length){showToast('Nama, ukuran, dan warna wajib diisi','error');return}
try{const fd=new FormData();fd.append('name',name);fd.append('_method','PUT');fd.append('price',document.getElementById('editPrice').value);fd.append('stock',document.getElementById('editStock').value);fd.append('brand_id',document.getElementById('editBrand').value);fd.append('kategori_id',document.getElementById('editKategori').value);fd.append('description',document.getElementById('editDesc').value);editSizes.forEach(s=>fd.append('sizes[]',s));editColors.forEach(c=>fd.append('colors[]',c));if(editUploadedFile)fd.append('image',editUploadedFile);
const r=await fetch(API.update(id),{method:'POST',headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},body:fd});if(!r.ok)throw new Error();const d=await r.json();closeEdit();showToast(d.message);await fetchData()}catch(err){showToast('Gagal memperbarui','error')}});

function openDelete(id){const p=items.find(x=>x.id===id);if(!p)return;deleteTargetId=id;document.getElementById('deleteName').textContent=p.name;document.getElementById('deleteModal').classList.remove('hidden')}
function closeDelete(){document.getElementById('deleteModal').classList.add('hidden');deleteTargetId=null}
document.getElementById('cancelDeleteBtn').onclick=closeDelete;document.getElementById('deleteOverlay').onclick=closeDelete;
document.getElementById('confirmDeleteBtn').addEventListener('click',async()=>{if(deleteTargetId===null)return;const btn=document.getElementById('confirmDeleteBtn');btn.disabled=true;btn.innerHTML='<i class="fa-solid fa-spinner fa-spin text-xs"></i>';try{const r=await fetch(API.delete(deleteTargetId),{method:'POST',headers:{'X-CSRF-TOKEN':'{{csrf_token()}}','Content-Type':'application/json'},body:JSON.stringify({_method:'DELETE'})});if(!r.ok)throw new Error();const d=await r.json();closeDelete();showToast(d.message,'info');await fetchData()}catch(err){showToast('Gagal menghapus','error')}finally{btn.disabled=false;btn.innerHTML='Hapus'}});
document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeEdit();closeDelete()}});
document.addEventListener('DOMContentLoaded',async()=>{await loadOptions();await fetchData()});
</script>
@endsection
