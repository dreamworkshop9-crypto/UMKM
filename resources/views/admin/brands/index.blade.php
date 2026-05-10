@extends('layouts.admin')

@section('title', 'Data Merek')

@section('content')
<div class="max-w-[1200px] mx-auto flex flex-col lg:flex-row gap-6 flex-1 min-h-0">

    <!-- Tabel Kiri -->
    <section class="flex-1 bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl overflow-hidden flex flex-col min-h-0">
        <div class="px-6 py-5 border-b border-outline-variant/10 flex items-center gap-3 flex-shrink-0">
            <h2 class="text-[16px] font-semibold text-white">Data Merek</h2>
            <span class="bg-indigo-600 text-white text-[11px] font-bold px-2 py-0.5 rounded-full min-w-[24px] h-[24px] flex items-center justify-center" id="brand-count">0</span>
        </div>

        <div class="px-6 py-4 border-b border-outline-variant/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 flex-shrink-0">
            <div class="flex items-center gap-2 text-slate-400 text-[13px]">
                <span>Show</span>
                <select class="bg-[#121220] border border-outline-variant/30 rounded-md px-3 py-1.5 text-white focus:ring-1 focus:ring-indigo-500 outline-none text-[13px]">
                    <option>10</option><option>25</option><option>50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-slate-400 text-[13px]">Search:</span>
                <input class="bg-[#121220] border border-outline-variant/30 rounded-md px-4 py-1.5 text-white focus:ring-1 focus:ring-indigo-500 outline-none w-[200px] text-[13px] placeholder-slate-600" type="text" placeholder="Cari merek..." id="search-brand"/>
            </div>
        </div>

        <div class="overflow-x-auto flex-1 min-h-0">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#24243a] border-b border-outline-variant/30">
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Merek</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Opsi</th>
                    </tr>
                </thead>
                <tbody id="brand-tbody">
                    <tr>
                        <td class="px-6 py-12 text-center text-slate-500 text-[13px]" colspan="5">
                            <div class="flex flex-col items-center gap-2 py-8">
                                <span class="material-symbols-outlined text-[48px] opacity-10 animate-pulse">progress_activity</span>
                                <span>Memuat data...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Form Kanan - FULL HEIGHT -->
    <aside class="w-full lg:w-[380px] flex-shrink-0 lg:self-stretch">
        <div class="bg-[#1c1c2d] rounded-2xl border border-outline-variant/20 shadow-xl p-6 h-full flex flex-col">
            <h2 class="text-[16px] font-semibold text-white mb-6 flex items-center gap-2 flex-shrink-0">
                <span class="material-symbols-outlined text-[18px] text-indigo-400">add_circle</span>
                Tambah Merek
            </h2>
            <form id="brand-form" class="space-y-5 flex-1 flex flex-col">
                @csrf
                <input type="hidden" id="edit-id" value=""/>
                <div class="space-y-2">
                    <label class="block text-[12px] text-slate-400 uppercase font-bold" for="brand-name">Nama Merek <span class="text-red-400">*</span></label>
                    <input class="w-full bg-[#121220] border border-outline-variant/30 rounded-lg px-4 py-3 text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-[13px]" id="brand-name" placeholder="Masukkan nama merek" required type="text"/>
                </div>
                <div class="space-y-2">
                    <label class="block text-[12px] text-slate-400 uppercase font-bold" for="brand-image">Gambar <span id="image-required-star" class="text-red-400">*</span></label>
                    <div class="relative flex items-center bg-[#121220] border border-outline-variant/30 rounded-lg overflow-hidden">
                        <label class="cursor-pointer bg-[#2a2a40] text-slate-300 px-4 py-3 text-[12px] font-medium hover:bg-[#333350] transition-colors border-r border-outline-variant/30" for="brand-image">Telusuri...</label>
                        <span class="px-4 text-slate-500 text-[12px] truncate flex-1" id="file-name-display">Tidak ada berkas dipilih</span>
                        <input accept="image/*" class="hidden" id="brand-image" type="file"/>
                    </div>
                    <div id="image-preview" class="hidden mt-3">
                        <div class="bg-white p-2 rounded-lg w-20 h-16 flex items-center justify-center overflow-hidden border border-outline-variant/20">
                            <img id="preview-img" class="object-contain max-h-full" src="" alt="Preview"/>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 mt-auto pt-6">
                    <button id="cancel-edit" class="hidden flex-1 bg-[#2a2a40] hover:bg-[#333350] text-slate-300 text-[13px] font-semibold py-3 rounded-lg transition-colors" type="button">Batal</button>
                    <button id="submit-btn" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white text-[13px] font-semibold py-3 rounded-lg transition-colors shadow-lg shadow-indigo-500/20 active:scale-[0.98] flex items-center justify-center gap-2" type="submit">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        <span id="submit-text">Tambah</span>
                    </button>
                </div>
            </form>
        </div>
    </aside>

</div>
@endsection

@section('additional-js')
<script>
const brandTbody=document.getElementById('brand-tbody'),brandCount=document.getElementById('brand-count'),brandForm=document.getElementById('brand-form'),fileInput=document.getElementById('brand-image'),fileNameDisplay=document.getElementById('file-name-display'),imagePreview=document.getElementById('image-preview'),previewImg=document.getElementById('preview-img'),editIdField=document.getElementById('edit-id'),cancelBtn=document.getElementById('cancel-edit'),submitBtn=document.getElementById('submit-btn'),submitText=document.getElementById('submit-text'),imageRequiredStar=document.getElementById('image-required-star');

function loadBrands(s=''){fetch('{{route("admin.brands.list")}}'+(s?'?search='+s:'')).then(r=>r.json()).then(d=>{brandCount.textContent=d.length;if(!d.length){brandTbody.innerHTML='<tr><td class="px-6 py-12 text-center text-slate-500 text-[13px]" colspan="5"><div class="flex flex-col items-center gap-2 py-8"><span class="material-symbols-outlined text-[48px] opacity-10">category</span><span>Tidak ada data merek</span></div></td></tr>';return}brandTbody.innerHTML=d.map((b,i)=>'<tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors"><td class="px-6 py-4 text-[13px] text-slate-400">'+(i+1)+'</td><td class="px-6 py-4 text-[13px] text-white font-medium">'+b.name+'</td><td class="px-6 py-4 text-[13px] text-slate-400">'+b.slug+'</td><td class="px-6 py-4">'+(b.image_url?'<div class="bg-white p-1 rounded w-14 h-10 flex items-center justify-center overflow-hidden"><img alt="'+b.name+'" class="object-contain max-h-full" src="'+b.image_url+'"/></div>':'<span class="text-[12px] text-slate-600">Tidak ada</span>')+'</td><td class="px-6 py-4"><div class="flex gap-2"><button onclick="editBrand('+b.id+',\''+b.name.replace(/'/g,"\\'")+'\')" class="p-2 rounded-lg bg-purple-500/10 text-purple-400 hover:text-white hover:bg-purple-500/20 transition-all" title="Edit"><span class="material-symbols-outlined text-[16px]">edit</span></button><button onclick="deleteBrand('+b.id+',\''+b.name.replace(/'/g,"\\'")+'\')" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:text-white hover:bg-red-500/20 transition-all" title="Hapus"><span class="material-symbols-outlined text-[16px]">delete</span></button></div></td></tr>').join(')}).catch(()=>{brandTbody.innerHTML='<tr><td class="px-6 py-12 text-center text-red-400 text-[13px]" colspan="5"><span class="material-symbols-outlined text-[36px] block mb-2">wifi_off</span>Gagal memuat data</td></tr>'})}

let st;document.getElementById('search-brand').addEventListener('input',e=>{clearTimeout(st);st=setTimeout(()=>loadBrands(e.target.value),400)});

fileInput.addEventListener('change',e=>{if(e.target.files.length>0){fileNameDisplay.textContent=e.target.files[0].name;fileNameDisplay.classList.remove('text-slate-500');fileNameDisplay.classList.add('text-slate-200');const r=new FileReader;r.onload=ev=>{previewImg.src=ev.target.result;imagePreview.classList.remove('hidden')};r.readAsDataURL(e.target.files[0])}else{fileNameDisplay.textContent='Tidak ada berkas dipilih';fileNameDisplay.classList.add('text-slate-500');fileNameDisplay.classList.remove('text-slate-200');imagePreview.classList.add('hidden')}});

brandForm.addEventListener('submit',async e=>{e.preventDefault();const isEdit=editIdField.value!=='';const bHTML=submitBtn.innerHTML;submitBtn.disabled=true;submitBtn.innerHTML='<span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span> Menyimpan...';const fd=new FormData;fd.append('name',document.getElementById('brand-name').value);if(fileInput.files.length>0)fd.append('image',fileInput.files[0]);else if(!isEdit){showToast('Gambar wajib diupload','error');submitBtn.disabled=false;submitBtn.innerHTML=bHTML;return}const url=isEdit?'{{route("admin.brands.update",":id")}}'.replace(':id',editIdField.value):'{{route("admin.brands.store")}}';try{const res=await fetch(url,{method:isEdit?'PUT':'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},body:fd});const data=await res.json();if(res.ok||res.status===201){showToast(data.message||(isEdit?'Merek diperbarui':'Merek ditambahkan'),'success');resetForm();loadBrands()}else showToast(data.message||'Gagal menyimpan','error')}catch{showToast('Terjadi kesalahan koneksi','error')}submitBtn.disabled=false;submitBtn.innerHTML=bHTML});

function editBrand(id,name){editIdField.value=id;document.getElementById('brand-name').value=name;fileInput.removeAttribute('required');imageRequiredStar.classList.add('hidden');submitText.textContent='Simpan';cancelBtn.classList.remove('hidden');submitBtn.querySelector('.material-symbols-outlined').textContent='save';window.scrollTo({top:0,behavior:'smooth'})}

function deleteBrand(id,name){if(!confirm('Yakin hapus merek "'+name+'"?'))return;fetch('{{route("admin.brands.destroy",":id")}}'.replace(':id',id),{method:'DELETE',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}}).then(r=>r.json()).then(d=>{if(d.message){showToast(d.message,'success');loadBrands()}else showToast('Gagal menghapus','error')}).catch(()=>showToast('Terjadi kesalahan','error'))}

function resetForm(){brandForm.reset();editIdField.value='';fileNameDisplay.textContent='Tidak ada berkas dipilih';fileNameDisplay.classList.add('text-slate-500');fileNameDisplay.classList.remove('text-slate-200');imagePreview.classList.add('hidden');fileInput.setAttribute('required','');imageRequiredStar.classList.remove('hidden');submitText.textContent='Tambah';cancelBtn.classList.add('hidden');submitBtn.querySelector('.material-symbols-outlined').textContent='add'}

cancelBtn.addEventListener('click',resetForm);

function showToast(m,t){const toast=document.createElement('div');toast.className='fixed top-6 right-6 z-[100] px-5 py-3 rounded-xl text-[13px] font-medium shadow-xl transition-all transform translate-x-full '+(t==='success'?'bg-emerald-600 text-white':'bg-red-600 text-white');toast.textContent=m;document.body.appendChild(toast);requestAnimationFrame(()=>{toast.classList.remove('translate-x-full');toast.classList.add('translate-x-0')});setTimeout(()=>{toast.classList.remove('translate-x-0');toast.classList.add('translate-x-full');setTimeout(()=>toast.remove(),300)},3000)}

loadBrands();
</script>
@endsection