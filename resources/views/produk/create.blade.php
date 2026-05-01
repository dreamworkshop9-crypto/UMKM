@extends('layouts.admin')

@section('title', 'Tambah Produk - SALZA')
@section('page-title', 'Tambah Produk')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.upload-zone{transition:all .2s;border:2px dashed rgb(51 65 85 / .5)}
.upload-zone:hover,.upload-zone.drag-over{border-color:#a855f7!important;background:rgba(139,92,246,.05)!important}
@keyframes toastIn{from{opacity:0;transform:translateX(100%)}to{opacity:1;transform:translateX(0)}}
@keyframes toastOut{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(100%)}}
.toast-in{animation:toastIn .3s ease forwards}
.toast-out{animation:toastOut .25s ease forwards}
</style>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-dashboard-card rounded-xl border border-slate-700/30 overflow-hidden">
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-plus text-purple-400 text-xs"></i>
                </div>
                <h2 class="text-lg font-semibold text-white">Form Produk Baru</h2>
            </div>
            <p class="text-xs text-slate-500 ml-11">Isi data produk di bawah ini. Field bertanda <span class="text-red-400">*</span> wajib diisi.</p>
        </div>

        <form id="addForm" class="p-6 space-y-5" novalidate>
            <!-- Nama -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Produk <span class="text-red-400">*</span></label>
                <input type="text" id="inputName" placeholder="Contoh: Air Max 90" class="w-full px-4 py-3 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none" required>
                <p id="nameError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Nama wajib diisi</p>
            </div>

            <!-- Merek & Kategori -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Merek</label>
                    <select id="inputBrand" class="w-full px-4 py-3 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none">
                        <option value="">-- Pilih Merek --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Kategori <span class="text-red-400">*</span></label>
                    <select id="inputKategori" class="w-full px-4 py-3 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white focus:border-purple-500 outline-none" required>
                        <option value="">-- Pilih Kategori --</option>
                    </select>
                    <p id="kategoriError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Kategori wajib dipilih</p>
                </div>
            </div>

            <!-- Harga & Stok -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Harga (Rp) <span class="text-red-400">*</span></label>
                    <input type="number" id="inputPrice" placeholder="0" min="0" class="w-full px-4 py-3 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none" required>
                    <p id="priceError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Harga wajib diisi</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Stok <span class="text-red-400">*</span></label>
                    <input type="number" id="inputStock" placeholder="0" min="0" value="0" class="w-full px-4 py-3 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none" required>
                </div>
            </div>

            <!-- Ukuran -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Ukuran <span class="text-red-400">*</span> <span class="text-slate-600 font-normal">(klik untuk pilih)</span></label>
                <div id="sizePicker" class="flex flex-wrap gap-2 p-3 bg-slate-800 border border-slate-700/50 rounded-lg min-h-[46px]">
                    <!-- Diisi oleh JavaScript -->
                </div>
                <p id="sizeError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Pilih minimal 1 ukuran</p>
            </div>

            <!-- Warna -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Warna <span class="text-red-400">*</span> <span class="text-slate-600 font-normal">(klik untuk pilih)</span></label>
                <div id="colorPicker" class="flex flex-wrap gap-2 p-3 bg-slate-800 border border-slate-700/50 rounded-lg min-h-[46px]">
                    <!-- Diisi oleh JavaScript -->
                </div>
                <p id="colorError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Pilih minimal 1 warna</p>
            </div>

            <!-- Gambar -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Gambar Produk <span class="text-red-400">*</span></label>
                <div id="uploadZone" class="upload-zone rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer min-h-[130px]">
                    <div id="uploadPlaceholder" class="text-center">
                        <div class="w-12 h-12 rounded-full bg-slate-700/50 flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-cloud-arrow-up text-slate-500 text-lg"></i>
                        </div>
                        <p class="text-sm font-medium text-slate-400">Klik atau seret gambar ke sini</p>
                        <p class="text-[11px] text-slate-600 mt-0.5">PNG, JPG, SVG — Maksimal 2MB</p>
                    </div>
                    <div id="uploadPreview" class="hidden w-full text-center">
                        <img id="previewImg" src="" alt="Preview" class="w-20 h-20 rounded-lg object-contain mx-auto mb-2 bg-slate-800 border border-slate-700/50 p-1">
                        <p id="fileName" class="text-xs font-medium text-slate-300 truncate px-8"></p>
                        <button type="button" id="removeFile" class="text-[11px] text-red-400 font-semibold hover:text-red-300 mt-1.5 transition-colors"><i class="fa-solid fa-trash-can mr-0.5"></i>Hapus gambar</button>
                    </div>
                </div>
                <input type="file" id="inputImage" accept="image/*" class="hidden">
                <p id="imageError" class="text-xs text-red-400 mt-1 hidden"><i class="fa-solid fa-circle-exclamation mr-0.5"></i>Gambar wajib diunggah</p>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi</label>
                <textarea id="inputDesc" rows="3" placeholder="Deskripsi produk (opsional)" class="w-full px-4 py-3 text-sm bg-slate-800 border border-slate-700/50 rounded-lg text-white placeholder:text-slate-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none resize-none"></textarea>
            </div>

            <!-- Tombol -->
            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.produk') }}" class="flex-1 py-3 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-semibold rounded-lg transition-colors text-center">
                    <i class="fa-solid fa-arrow-left mr-1.5 text-xs"></i>Kembali
                </a>
                <button type="submit" id="submitBtn" class="flex-1 py-3 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-lg shadow-md shadow-purple-500/20 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>Simpan Produk
                </button>
            </div>
        </form>
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
const API = {store:'{{route("admin.produk.store")}}',options:'{{route("admin.produk.options")}}'};
let uploadedFile=null,selectedSizes=[],selectedColors=[];

function showToast(msg,type='success'){let c=document.getElementById('toastContainer');if(!c){c=document.createElement('div');c.id='toastContainer';c.className='fixed top-6 right-6 z-[60] space-y-3 pointer-events-none';document.body.appendChild(c)}const icons={success:'fa-circle-check text-emerald-400',error:'fa-circle-xmark text-red-400'};const el=document.createElement('div');el.className='toast-in pointer-events-auto flex items-center gap-3 px-5 py-3 bg-slate-800 rounded-xl border border-slate-700/50 shadow-lg min-w-[300px]';el.innerHTML=`<i class="fa-solid ${icons[type]}"></i><span class="text-sm font-semibold text-white flex-1">${msg}</span>`;c.appendChild(el);setTimeout(()=>{el.classList.replace('toast-in','toast-out');setTimeout(()=>el.remove(),250)},3000)}

async function loadOptions(){try{const r=await fetch(API.options);if(!r.ok)throw new Error();const d=await r.json();const bs=d.brands,ks=d.kategoris;document.getElementById('inputBrand').innerHTML='<option value="">-- Pilih Merek --</option>'+bs.map(b=>`<option value="${b.id}">${b.name}</option>`).join('');document.getElementById('inputKategori').innerHTML='<option value="">-- Pilih Kategori --</option>'+ks.map(k=>`<option value="${k.id}">${k.name}</option>`).join('')}catch(e){showToast('Gagal memuat opsi','error')}}

// Ukuran picker
function buildSizePicker(){const c=document.getElementById('sizePicker');c.innerHTML='';SIZES.forEach(s=>{const active=selectedSizes.includes(s);const btn=document.createElement('button');btn.type='button';btn.className=`px-4 py-2 rounded-lg text-sm font-semibold border-2 transition-all ${active?'bg-purple-600 border-purple-500 text-white shadow-sm shadow-purple-500/25 scale-105':'bg-slate-800 border-slate-700/50 text-slate-400 hover:border-purple-500 hover:text-purple-400'}`;btn.textContent=s;btn.onclick=()=>{if(selectedSizes.includes(s))selectedSizes=selectedSizes.filter(x=>x!==s);else selectedSizes.push(s);buildSizePicker();document.getElementById('sizeError').classList.add('hidden')};c.appendChild(btn)})}

// Warna picker
function buildColorPicker(){const c=document.getElementById('colorPicker');c.innerHTML='';COLORS.forEach(col=>{const active=selectedColors.includes(col.name);const btn=document.createElement('button');btn.type='button';btn.className=`w-10 h-10 rounded-xl border-2 transition-all flex items-center justify-center ${active?'border-purple-400 scale-110 shadow-lg':'border-slate-700/50 hover:border-slate-400 scale-100'}`;btn.style.background=col.hex;btn.title=col.name;btn.innerHTML=active?'<i class="fa-solid fa-check text-[10px] text-white drop-shadow"></i>':'';btn.onclick=()=>{if(selectedColors.includes(col.name))selectedColors=selectedColors.filter(x=>x!==col.name);else selectedColors.push(col.name);buildColorPicker();document.getElementById('colorError').classList.add('hidden')};c.appendChild(btn)})}

// Upload
const uz=document.getElementById('uploadZone');
uz.addEventListener('click',e=>{if(!e.target.closest('#removeFile'))document.getElementById('inputImage').click()});
uz.addEventListener('dragover',e=>{e.preventDefault();uz.classList.add('drag-over')});
uz.addEventListener('dragleave',()=>uz.classList.remove('drag-over'));
uz.addEventListener('drop',e=>{e.preventDefault();uz.classList.remove('drag-over');if(e.dataTransfer.files.length)handleFile(e.dataTransfer.files[0])});
document.getElementById('inputImage').addEventListener('change',e=>{if(e.target.files.length)handleFile(e.target.files[0])});

function handleFile(file){if(!file.type.startsWith('image/')){showToast('File harus berupa gambar','error');return}if(file.size>2*1024*1024){showToast('Maks 2MB','error');return}uploadedFile=file;const r=new FileReader();r.onload=e=>{document.getElementById('previewImg').src=e.target.result;document.getElementById('fileName').textContent=file.name;document.getElementById('uploadPlaceholder').classList.add('hidden');document.getElementById('uploadPreview').classList.remove('hidden')};r.readAsDataURL(file);document.getElementById('imageError').classList.add('hidden')}
document.getElementById('removeFile').addEventListener('click',e=>{e.stopPropagation();uploadedFile=null;document.getElementById('inputImage').value='';document.getElementById('uploadPlaceholder').classList.remove('hidden');document.getElementById('uploadPreview').classList.add('hidden')});
document.getElementById('inputName').addEventListener('input',e=>{if(e.target.value.trim())document.getElementById('nameError').classList.add('hidden')});
document.getElementById('inputPrice').addEventListener('input',()=>document.getElementById('priceError').classList.add('hidden'));
document.getElementById('inputKategori').addEventListener('change',()=>document.getElementById('kategoriError').classList.add('hidden'));

// Submit
document.getElementById('addForm').addEventListener('submit',async e=>{
    e.preventDefault();const name=document.getElementById('inputName').value.trim(),price=document.getElementById('inputPrice').value,kategori=document.getElementById('inputKategori').value;
    let ok=true;
    if(!name){document.getElementById('nameError').classList.remove('hidden');ok=false}
    if(!kategori){document.getElementById('kategoriError').classList.remove('hidden');ok=false}
    if(!price||price<0){document.getElementById('priceError').classList.remove('hidden');ok=false}
    if(!selectedSizes.length){document.getElementById('sizeError').classList.remove('hidden');ok=false}
    if(!selectedColors.length){document.getElementById('colorError').classList.remove('hidden');ok=false}
    if(!uploadedFile){document.getElementById('imageError').classList.remove('hidden');ok=false}
    if(!ok)return;

    const btn=document.getElementById('submitBtn');btn.disabled=true;btn.innerHTML='<i class="fa-solid fa-spinner fa-spin text-xs"></i>Menyimpan...';
    try{const fd=new FormData();fd.append('name',name);fd.append('price',price);fd.append('stock',document.getElementById('inputStock').value||0);
    fd.append('brand_id',document.getElementById('inputBrand').value);fd.append('kategori_id',kategori);fd.append('description',document.getElementById('inputDesc').value);
    selectedSizes.forEach(s=>fd.append('sizes[]',s));selectedColors.forEach(c=>fd.append('colors[]',c));fd.append('image',uploadedFile);
    const r=await fetch(API.store,{method:'POST',headers:{'X-CSRF-TOKEN':'{{csrf_token() }}'},body:fd});
    if(!r.ok){const err=await r.json();throw new Error(err.message||'Gagal menyimpan')}
    const d=await r.json();showToast(d.message);setTimeout(()=>{window.location.href='{{route("admin.produk")}}'},1000)}
    catch(err){showToast(err.message,'error')}finally{btn.disabled=false;btn.innerHTML='<i class="fa-solid fa-plus text-xs"></i>Simpan Produk'}
});

document.addEventListener('DOMContentLoaded',()=>{loadOptions();buildSizePicker();buildColorPicker()});
</script>
@endsection
