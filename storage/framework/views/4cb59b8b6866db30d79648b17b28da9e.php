<?php $__env->startSection('title', 'Data User'); ?>

<?php $__env->startSection('additional-css'); ?>
<style>
.card-stat {
    background: #1c1c2d;
    border: 1px solid rgba(46, 46, 72, 0.4);
    border-radius: 0.75rem;
    padding: 20px 24px;
    transition: all 0.2s;
}
.card-stat:hover { border-color: rgba(99, 102, 241, 0.3); }

.tbl-wrapper {
    background: #1c1c2d;
    border: 1px solid rgba(46, 46, 72, 0.4);
    border-radius: 0.75rem;
    overflow-x: auto;
}
.tbl-wrapper table { width: 100%; border-collapse: collapse; }
.tbl-wrapper thead { background: rgba(46, 46, 72, 0.3); }
.tbl-wrapper th {
    padding: 14px 20px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #64748b;
    white-space: nowrap;
}
.tbl-wrapper td {
    padding: 14px 20px;
    font-size: 13px;
    color: #cbd5e1;
    border-top: 1px solid rgba(46, 46, 72, 0.3);
}
.tbl-wrapper tbody tr { transition: background 0.15s; }
.tbl-wrapper tbody tr:hover { background: rgba(99, 102, 241, 0.04); }

.badge-role {
    display: inline-flex;
    align-items: center;
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 600;
}
.badge-customer { background: rgba(34,197,94,0.12); color: #4ade80; }
.badge-admin    { background: rgba(99,102,241,0.15); color: #818cf8; }

.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 600;
}
.badge-active   { background: rgba(34,197,94,0.12); color: #4ade80; }
.badge-inactive { background: rgba(239,68,68,0.12); color: #f87171; }
.badge-active .dot, .badge-inactive .dot {
    width: 6px; height: 6px; border-radius: 50%;
}
.badge-active .dot   { background: #4ade80; }
.badge-inactive .dot { background: #f87171; }

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 0.5rem;
    transition: all 0.15s;
    cursor: pointer;
    border: none;
    background: none;
    padding: 0;
}
.btn-view   { background: rgba(99,102,241,0.1) !important; color: #818cf8; }
.btn-view:hover   { background: rgba(99,102,241,0.25) !important; }
.btn-edit   { background: rgba(234,179,8,0.1) !important; color: #facc15; }
.btn-edit:hover   { background: rgba(234,179,8,0.25) !important; }
.btn-delete { background: rgba(239,68,68,0.1) !important; color: #f87171; }
.btn-delete:hover { background: rgba(239,68,68,0.25) !important; }

.search-input {
    background: #121220 !important;
    border: 1px solid rgba(46,46,72,0.4);
    border-radius: 0.5rem;
    padding: 10px 16px 10px 42px;
    color: #ffffff !important;
    -webkit-text-fill-color: #ffffff !important;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
    width: 320px;
    caret-color: #6366f1;
}
.search-input:focus { border-color: rgba(99,102,241,0.5); }
.search-input::placeholder { color: #475569 !important; -webkit-text-fill-color: #475569 !important; }

.filter-select {
    background: #1c1c2d;
    border: 1px solid rgba(46,46,72,0.4);
    border-radius: 0.5rem;
    padding: 10px 14px;
    color: #cbd5e1;
    font-size: 13px;
    outline: none;
    cursor: pointer;
    transition: border-color 0.2s;
}
.filter-select:focus { border-color: rgba(99,102,241,0.5); }
.filter-select option { background: #1c1c2d; }

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
    border: 1px solid rgba(46,46,72,0.5);
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
    border: 1px solid rgba(46,46,72,0.5);
    border-radius: 0.5rem;
    padding: 10px 14px;
    color: #e3e0f5;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
}
.modal-input:focus { border-color: rgba(99,102,241,0.5); }

.pagination { display: flex; gap: 4px; }
.pagination a, .pagination span {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 34px; height: 34px;
    border-radius: 0.5rem;
    font-size: 12px; font-weight: 500;
    transition: all 0.15s;
}
.pagination a { color: #94a3b8; background: transparent; }
.pagination a:hover { background: rgba(99,102,241,0.1); color: #c7d2fe; }
.pagination .active {
    background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
    color: white; font-weight: 600;
}
.pagination .disabled { color: #334155; cursor: default; }

.empty-state { padding: 60px 20px; text-align: center; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-[#1c1c2d] rounded-xl border border-outline-variant/20 overflow-hidden">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-white">Data User</h1>
            <p class="text-[12px] text-slate-500 mt-1">Kelola data pengguna terdaftar</p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="card-stat">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">Total User</p>
                    <p class="text-2xl font-bold text-white mt-1"><?php echo e(number_format($totalUsers)); ?></p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-indigo-400 text-[20px]">group</span>
                </div>
            </div>
        </div>
        <div class="card-stat">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">User Aktif</p>
                    <p class="text-2xl font-bold text-emerald-400 mt-1"><?php echo e(number_format($activeUsers)); ?></p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-emerald-400 text-[20px]">verified</span>
                </div>
            </div>
        </div>
        <div class="card-stat">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">User Baru (Bulan Ini)</p>
                    <p class="text-2xl font-bold text-amber-400 mt-1"><?php echo e(number_format($newUsersMonth)); ?></p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-400 text-[20px]">person_add</span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 mb-4">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-500">search</span>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama atau email..." class="search-input" id="searchInput" autocomplete="off"/>
        </div>
        <select name="role" class="filter-select" id="filterRole">
            <option value="">Semua Role</option>
            <option value="customer" <?php echo e(request('role') === 'customer' ? 'selected' : ''); ?>>Customer</option>
            <option value="admin" <?php echo e(request('role') === 'admin' ? 'selected' : ''); ?>>Admin</option>
        </select>
        <select name="status" class="filter-select" id="filterStatus">
            <option value="">Semua Status</option>
            <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Aktif</option>
            <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Nonaktif</option>
        </select>
        <button type="button" onclick="resetFilters()" class="px-4 py-2.5 rounded-lg text-[12px] font-medium text-slate-400 hover:text-white border border-outline-variant/30 hover:border-slate-500 transition-all">Reset</button>
    </div>

    <div class="tbl-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Tgl Daftar</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-slate-500"><?php echo e(($users->currentPage() - 1) * $users->perPage() + $i + 1); ?></td>
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&background=6366f1&color=fff&size=32" class="w-8 h-8 rounded-full" alt=""/>
                            <span class="font-medium text-white"><?php echo e($user->name); ?></span>
                        </div>
                    </td>
                    <td><?php echo e($user->email); ?></td>
                    <td>
                        <span class="badge-role badge-<?php echo e($user->role ?? 'customer'); ?>">
                            <?php echo e($user->role === 'admin' ? 'Admin' : 'Customer'); ?>

                        </span>
                    </td>
                    <td>
                        <span class="badge-status badge-<?php echo e($user->email_verified_at ? 'active' : 'inactive'); ?>">
                            <span class="dot"></span>
                            <?php echo e($user->email_verified_at ? 'Aktif' : 'Nonaktif'); ?>

                        </span>
                    </td>
                    <td class="text-slate-500"><?php echo e($user->created_at ? $user->created_at->format('d M Y') : '-'); ?></td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" class="btn-action btn-view" title="Detail" onclick="viewUser(<?php echo e($user->id); ?>)">
                                <span class="material-symbols-outlined" style="font-size:18px">visibility</span>
                            </button>
                            <button type="button" class="btn-action btn-edit" title="Edit" onclick="openEdit(<?php echo e($user->id); ?>)">
                                <span class="material-symbols-outlined" style="font-size:18px">edit</span>
                            </button>
                            <button type="button" class="btn-action btn-delete" title="Hapus" onclick="confirmDelete(<?php echo e($user->id); ?>, '<?php echo e($user->name); ?>')">
                                <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <span class="material-symbols-outlined text-[48px] text-slate-600">person_off</span>
                            <p class="text-slate-500 mt-3 text-[13px]">Tidak ada data user ditemukan</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if($users->hasPages()): ?>
        <div class="flex items-center justify-between px-5 py-4 border-t border-outline-variant/20">
            <p class="text-[12px] text-slate-500">Menampilkan <?php echo e($users->firstItem()); ?>-<?php echo e($users->lastItem()); ?> dari <?php echo e($users->total()); ?> data</p>
            <div class="pagination"><?php echo e($users->withQueryString()->links('admin.partials.pagination-custom')); ?></div>
        </div>
        <?php endif; ?>
    </div>
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
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
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
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div class="flex items-center gap-3 px-6 py-4 border-t border-outline-variant/30">
                <button type="button" onclick="closeModal('modalDelete')" class="flex-1 px-4 py-2.5 rounded-lg text-[13px] font-medium text-slate-400 hover:text-white border border-outline-variant/30 hover:border-slate-500 transition-all text-center">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-lg text-[13px] font-semibold text-white bg-red-600 hover:bg-red-500 transition-all text-center">Hapus</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('additional-js'); ?>
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
    window.location.href = '<?php echo e(route("admin.users")); ?>' + (params.toString() ? '?' + params.toString() : '');
}

function resetFilters() {
    window.location.href = '<?php echo e(route("admin.users")); ?>';
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
    fetch('<?php echo e(route("admin.users.show", ":id")); ?>'.replace(':id', id))
        .then(function(r){ return r.json() })
        .then(function(data) {
            document.getElementById('detailContent').innerHTML = '<div class="flex flex-col items-center mb-6"><img src="https://ui-avatars.com/api/?name='+encodeURIComponent(data.name)+'&background=6366f1&color=fff&size=64" class="w-16 h-16 rounded-full border-2 border-indigo-500/30"/><h4 class="text-[16px] font-semibold text-white mt-3">'+data.name+'</h4><span class="badge-role badge-'+(data.role||'customer')+' mt-1">'+(data.role==='admin'?'Admin':'Customer')+'</span></div><div class="space-y-3"><div class="flex justify-between py-2.5 border-b border-outline-variant/20"><span class="text-[12px] text-slate-500">Email</span><span class="text-[13px] text-white">'+data.email+'</span></div><div class="flex justify-between py-2.5 border-b border-outline-variant/20"><span class="text-[12px] text-slate-500">Status</span><span class="badge-status badge-'+(data.email_verified_at?'active':'inactive')+'"><span class="dot"></span>'+(data.email_verified_at?'Aktif':'Nonaktif')+'</span></div><div class="flex justify-between py-2.5 border-b border-outline-variant/20"><span class="text-[12px] text-slate-500">Terdaftar</span><span class="text-[13px] text-white">'+(data.created_at?new Date(data.created_at).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'}):'-')+'</span></div><div class="flex justify-between py-2.5"><span class="text-[12px] text-slate-500">Terakhir Update</span><span class="text-[13px] text-white">'+(data.updated_at?new Date(data.updated_at).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'}):'-')+'</span></div></div>';
        })
        .catch(function() {
            document.getElementById('detailContent').innerHTML = '<div class="text-center py-8"><span class="material-symbols-outlined text-red-400 text-[36px]">error</span><p class="text-slate-400 mt-2 text-[13px]">Gagal memuat data</p></div>';
        });
}

// Edit User
function openEdit(id) {
    fetch('<?php echo e(route("admin.users.show", ":id")); ?>'.replace(':id', id))
        .then(function(r){ return r.json() })
        .then(function(data) {
            document.getElementById('editId').value = data.id;
            document.getElementById('editName').value = data.name;
            document.getElementById('editEmail').value = data.email;
            document.getElementById('editRole').value = data.role || 'customer';
            document.getElementById('editPassword').value = '';
            document.getElementById('formEdit').action = '<?php echo e(route("admin.users.update", ":id")); ?>'.replace(':id', id);
            openModal('modalEdit');
        });
}

// Delete User
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('formDelete').action = '<?php echo e(route("admin.users.destroy", ":id")); ?>'.replace(':id', id);
    openModal('modalDelete');
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.show').forEach(function(m){ closeModal(m.id) });
    }
});
<?php $__env->stopSection(); ?>         
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\UMKM-main\resources\views/admin/users.blade.php ENDPATH**/ ?>