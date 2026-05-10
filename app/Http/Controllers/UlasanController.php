<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index(Request $request)
    {
        $query = Ulasan::with(['user', 'pesanan']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('review', 'LIKE', "%{$s}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'LIKE', "%{$s}%"))
                  ->orWhereHas('pesanan', fn($p) => $p->where('code', 'LIKE', "%{$s}%"));
            });
        }

        $ulasan = $query->orderBy('created_at', 'desc')->paginate($request->per_page ?? 10);

        return view('admin.ulasan', compact('ulasan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $ulasan = Ulasan::findOrFail($id);
        $ulasan->update(['status' => $request->status]);

        return response()->json([
            'message' => "Ulasan berhasil diperbarui",
        ]);
    }

    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->delete();

        return response()->json([
            'message' => "Ulasan berhasil dihapus",
        ]);
    }
}