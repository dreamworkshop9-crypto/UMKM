@extends('layouts.admin')

@section('title', 'Data User')

@section('additional-css')
<style>
.modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s;
}
.modal-overlay.show { opacity: 1; pointer-events: auto; }
.modal-box {
    background: #1c1c2d;
    border: 1px solid rgba(46, 46, 72, 0.5);
    border-radius: 0.75rem;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    transform: translateY(20px) scale(0.97);
    transition: transform 0.25s;
    position: relative;
    z-index: 10000;
}
.modal-overlay.show .modal-box { transform: translateY(0) scale(1); }

.modal-input {
    width: 100%;
    background: #121220;
    border: 1px solid rgba(46, 46, 72, 0.5);
    border-radius: 0.5rem;
    padding: 10px 14px;
    color: #e3e0f5;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
}
.modal-input:focus { border-color: rgba(99, 102, 241, 0.5); }
</style>
@endsection

@section('content')

<!-- Header Section -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-white">Data User</h1>
        <p class="text-[12px] text-slate-500 mt-1">Kelola data pengguna terdaftar</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-surface-container rounded-2xl p-6 border border-outline-variant/10 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">Total User</p>
                <p class="text-2xl font-bold text-white mt-1">{{ number_format($totalUsers) }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-indigo-400 text-[20px]">group</span>
            </div>
        </div>
    </div>
    <div class="bg-surface-container rounded-2xl p-6 border border-outline-variant/10 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">User Aktif</p>
                <p class="text-2xl font-bold text-emerald-400 mt-1">{{ number_format($activeUsers) }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-400 text-[20px]">verified</span>
            </div>
        </div>
    </div>
    <div class="bg-surface-container rounded-2xl p-6 border border-outline-variant/10 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">User Baru (Bulan Ini)</p>
                <p class="text-2xl font-bold text-amber-400 mt-1">{{ number_format($newUsersMonth) }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-400 text-[20px]">person_add</span>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden shadow-xl">
    
    <!-- Controls (Search & Filters) -->
    <div class="px-6 py-4 border-b border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[18px] text-slate-500">search</span>
                <input type="text" id="searchInput" placeholder="Cari nama atau email..." value="{{ request('search') }}" autocomplete="off" class="bg-[#121220] border border-outline-variant/30 rounded-lg py-2 pl-10 pr-4 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none w-[280px]">
            </div>
            <select id="filterRole" class="bg-[#121220] border border-outline-variant/30 rounded-lg px-3 py-2 text-sm text-slate-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none cursor-pointer">
                <option value="">Semua Role</option>
                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <select id="filterStatus" class="bg-[#121220] border border-outline-variant/30 rounded-lg px-3 py-2 text-sm text-slate-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <button type="button" onclick="resetFilters()" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white border border-outline-variant/30 hover:border-slate-500 transition-all">Reset</button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#24243a] border-b border-outline-variant/30">
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tgl Daftar</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $i => $user)
                <tr class="border-b border-outline-variant/5 hover:bg-[#1a1a2e] transition-colors">
                    <td class="px-6 py-4 text-[13px] text-slate-500">{{ ($users->currentPage() - 1) * $users->perPage() + $i + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=32" class="w-8 h-8 rounded-full" alt=""/>
                            <span class="text-[13px] font-medium text-white">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-[13px] text-slate-300">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $user->role === 'admin' ? 'bg-indigo-500/15 text-indigo-400 border-indigo-500/20' : 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20' }}">
                            {{ $user->role === 'admin' ? 'Admin' : 'Customer' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border {{ $user->email_verified_at ? 'bg-emerald-500/15 text-emerald-400 border-emerald-500/20' : 'bg-red-500/15 text-red-400 border-red-500/20' }}">
                            {{ $user->email_verified_at ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-[13px] text-slate-400">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <button type="button" class="p-1.5 rounded-lg bg-slate-500/10 text-slate-400 hover:text-white hover:bg-slate-500/20 transition-all" title="Detail" onclick="viewUser({{ $user->id }})">
                                <span class="material-symbols-outlined text-[16px]">visibility</span>
                            </button>
                            <button type="button" class="p-1.5 rounded-lg bg-amber-500/10 text-amber-400 hover:text-white hover:bg-amber-500/20 transition-all" title="Edit" onclick="openEdit({{ $user->id }})">
                                <span class="material-symbols-outlined text-[16px]">edit</span>
                            </button>
                            <button type="button" class="p-1.5 rounded-lg bg-red-500/10 text-red-400 hover:text-white hover:bg-red-500/20 transition-all" title="Hapus" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center text-slate-500">
                        <div class="flex flex-col items-center gap-2 py-8">
                            <span class="material-symbols-outlined text-[48px] opacity-10">person_off</span>
                            <span class="text-[13px]">Tidak ada data user ditemukan</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($users->hasPages())
    <div class="px-6 py-4 border-t border-outline-variant/10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <p class="text-[13px] text-slate-500">Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries</p>
        <div class="flex flex-wrap gap-1">
            <a href="{{ $users->appends(request()->query())->previousPageUrl() ?? '#' }}" class="px-4 py-2 border border-outline-variant/30 bg-[#212135] text-slate-400 rounded-l-lg text-[13px] hover:bg-[#2a2a40] hover:text-white transition-colors {{ $users->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">Previous</a>
            <a href="{{ $users->appends(request()->query())->nextPageUrl() ?? '#' }}" class="px-4 py-2 border border-l-0 border-outline-variant/30 bg-[#212135] text-slate-400 rounded-r-lg text-[13px] hover:bg-[#2a2a30] hover:text-white transition-colors {{ $users->hasMorePages() ? '' : 'opacity-40 pointer-events-none' }}">Next</a>
        </div>
    </div>
    @endif

</div>

<!-- Modal Detail -->
<div class="modal-overlay" id="modalDetail">
    <div class="modal-box">
        <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant/30">
            <h3 class="text-[15px] font-semibold text-white">Detail User</h3>
            <span class="material-symbols-outlined text-slate-400 cursor-pointer hover:text-white text-[20px]" onclick="closeModal('modalDetail')">close</span>
        </div>
        <div class="p-6" id="detailContent"></div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-box">
        <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant/30">
            <h3 class="text-[15px] font-semibold text-white">Edit User</h3>
            <span class="material-symbols-outlined text-slate-400 cursor-pointer hover:text-white text-[20px]" onclick="closeModal('modalEdit')">close</span>
        </div>
        <form method="POST" action="" id="formEdit">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <input type="hidden" name="id" id="editId"/>
                <div>
                    <label class="block text-[12px] font-medium text-slate-400 mb-1.5">Nama</label>
                    <input type="text" name="name" id="editName" class="modal-input" required/>
                </div>
                <div>
                    <label class="block text-[12px] font-medium text-slate-400 mb-1.5">Email</label>
                    <input type="email" name="email" id="editEmail" class="modal-input" required/>
                </div>
                <div>
                    <label class="block text-[12px] font-medium text-slate-400 mb-1.5">Role</label>
                    <select name="role" id="editRole" class="modal-input" required>
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[12px] font-medium text-slate-400 mb-1.5">Password <span class="text-slate-600 font-normal">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" id="editPassword" class="modal-input" placeholder="••••••••"/>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-outline-variant/30">
                <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:text-white border border-outline-variant/30 hover:border-slate-500 transition-all">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-lg text-[13px] font-semibold text-white bg-active-gradient hover:opacity-90 transition-all shadow-lg shadow-indigo-500/20">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal-overlay" id="modalDelete">
    <div class="modal-box" style="max-width: 400px;">
        <div class="p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-red-400 text-[28px]">warning</span>
            </div>
            <h3 class="text-[15px] font-semibold text-white mb-2">Hapus User?</h3>
            <p class="text-[13px] text-slate-400">User "<span id="deleteName" class="text-white font-medium"></span>" akan dihapus secara permanen.</p>
        </div>
        <form method="POST" action="" id="formDelete">
            @csrf
            @method('DELETE')
            <div class="flex items-center gap-3 px-6 py-4 border-t border-outline-variant/30">
                <button type="button" onclick="closeModal('modalDelete')" class="flex-1 px-4 py-2.5 rounded-lg text-[13px] font-medium text-slate-400 hover:text-white border border-outline-variant/30 hover:border-slate-500 transition-all text-center">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-lg text-[13px] font-semibold text-white bg-red-600 hover:bg-red-500 transition-all text-center">Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('additional-js')
// Pindahkan modal ke body supaya tidak ketutupan scroll
var mc = document.getElementById('modalDetail');
var me = document.getElementById('modalEdit');
var md = document.getElementById('modalDelete');
if(mc) document.body.appendChild(mc);
if(me) document.body.appendChild(me);
if(md) document.body.appendChild(md);

// Search & Filter
var searchTimeout;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function(){ applyFilters() }, 400);
});
document.getElementById('filterRole').addEventListener('change', applyFilters);
document.getElementById('filterStatus').addEventListener('change', applyFilters);

function applyFilters() {
    var params = new URLSearchParams();
    var search = document.getElementById('searchInput').value.trim();
    var role = document.getElementById('filterRole').value;
    var status = document.getElementById('filterStatus').value;
    if (search) params.set('search', search);
    if (role) params.set('role', role);
    if (status) params.set('status', status);
    window.location.href = '{{ route("admin.users") }}' + (params.toString() ? '?' + params.toString() : '');
}

function resetFilters() {
    window.location.href = '{{ route("admin.users") }}';
}

// Modal
function openModal(id) {
    document.getElementById(id).classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('show');
    document.body.style.overflow = '';
}

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay') && e.target.classList.contains('show')) {
        closeModal(e.target.id);
    }
});

// View User
function viewUser(id) {
    openModal('modalDetail');
    document.getElementById('detailContent').innerHTML = '<div class="flex items-center justify-center py-8"><span class="material-symbols-outlined animate-spin text-indigo-400 text-[28px]">progress_activity</span></div>';
    fetch('{{ route("admin.users.show", ":id") }}'.replace(':id', id))
        .then(function(r){ return r.json() })
        .then(function(data) {
            document.getElementById('detailContent').innerHTML = '<div class="flex flex-col items-center mb-6"><img src="https://ui-avatars.com/api/?name='+encodeURIComponent(data.name)+'&background=6366f1&color=fff&size=64" class="w-16 h-16 rounded-full border-2 border-indigo-500/30"/><h4 class="text-[16px] font-semibold text-white mt-3">'+data.name+'</h4><span class="text-[11px] font-bold px-2.5 py-1 rounded-full border '+(data.role==='admin'?'bg-indigo-500/15 text-indigo-400 border-indigo-500/20':'bg-emerald-500/15 text-emerald-400 border-emerald-500/20')+' mt-1">'+(data.role==='admin'?'Admin':'Customer')+'</span></div><div class="space-y-3"><div class="flex justify-between py-2.5 border-b border-outline-variant/20"><span class="text-[12px] text-slate-500">Email</span><span class="text-[13px] text-white">'+data.email+'</span></div><div class="flex justify-between py-2.5 border-b border-outline-variant/20"><span class="text-[12px] text-slate-500">Status</span><span class="text-[11px] font-bold px-2.5 py-1 rounded-full border '+(data.email_verified_at?'bg-emerald-500/15 text-emerald-400 border-emerald-500/20':'bg-red-500/15 text-red-400 border-red-500/20')+'">'+(data.email_verified_at?'Aktif':'Nonaktif')+'</span></div><div class="flex justify-between py-2.5 border-b border-outline-variant/20"><span class="text-[12px] text-slate-500">Terdaftar</span><span class="text-[13px] text-white">'+(data.created_at?new Date(data.created_at).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'}):'-')+'</span></div><div class="flex justify-between py-2.5"><span class="text-[12px] text-slate-500">Terakhir Update</span><span class="text-[13px] text-white">'+(data.updated_at?new Date(data.updated_at).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'}):'-')+'</span></div></div>';
        })
        .catch(function() {
            document.getElementById('detailContent').innerHTML = '<div class="text-center py-8"><span class="material-symbols-outlined text-red-400 text-[36px]">error</span><p class="text-slate-400 mt-2 text-[13px]">Gagal memuat data</p></div>';
        });
}

// Edit User
function openEdit(id) {
    fetch('{{ route("admin.users.show", ":id") }}'.replace(':id', id))
        .then(function(r){ return r.json() })
        .then(function(data) {
            document.getElementById('editId').value = data.id;
            document.getElementById('editName').value = data.name;
            document.getElementById('editEmail').value = data.email;
            document.getElementById('editRole').value = data.role || 'customer';
            document.getElementById('editPassword').value = '';
            document.getElementById('formEdit').action = '{{ route("admin.users.update", ":id") }}'.replace(':id', id);
            openModal('modalEdit');
        });
}

// Delete User
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('formDelete').action = '{{ route("admin.users.destroy", ":id") }}'.replace(':id', id);
    openModal('modalDelete');
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.show').forEach(function(m){ closeModal(m.id) });
    }
});
@endsection