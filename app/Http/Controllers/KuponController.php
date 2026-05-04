<?php

namespace App\Http\Controllers;

use App\Models\Kupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class KuponController extends Controller
{
    public function index()
    {
        return view('admin.kupon.index');
    }

    public function list(Request $request)
    {
        $query = Kupon::query();

        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->orderByDesc('id')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'       => 'required|string|max:50|unique:kupons,code',
            'name'       => 'required|string|max:150',
            'image'      => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'discount'   => 'required|integer|min:0',
            'type'       => 'required|in:percentage,fixed',
            'min_order'  => 'nullable|integer|min:0',
            'valid_from' => 'nullable|date',
            'valid_until'=> 'required|date|after:valid_from',
            'usage_limit'=> 'nullable|integer|min:0',
        ]);

        $path = $request->file('image')->store('kupon', 'public');

        $kupon = Kupon::create([
            'code'       => strtoupper($request->code),
            'name'       => $request->name,
            'image'      => $path,
            'discount'   => $request->discount,
            'type'       => $request->type,
            'min_order'  => $request->min_order ?? 0,
            'valid_from' => $request->valid_from,
            'valid_until'=> $request->valid_until,
            'usage_limit'=> $request->usage_limit ?? 0,
        ]);

        return response()->json([
            'message' => "Kupon \"{$kupon->code}\" berhasil ditambahkan",
        ], 201);
    }

    public function show(Kupon $kupon)
    {
        return response()->json($kupon);
    }

    public function update(Request $request, Kupon $kupon)
    {
        $request->validate([
            'code'       => 'required|string|max:50|unique:kupons,code,' . $kupon->id,
            'name'       => 'required|string|max:150',
            'image'      => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'discount'   => 'required|integer|min:0',
            'type'       => 'required|in:percentage,fixed',
            'min_order'  => 'nullable|integer|min:0',
            'valid_from' => 'nullable|date',
            'valid_until'=> 'required|date',
            'usage_limit'=> 'nullable|integer|min:0',
            'is_active'  => 'required|boolean',
        ]);

        $data = [
            'code'       => strtoupper($request->code),
            'name'       => $request->name,
            'discount'   => $request->discount,
            'type'       => $request->type,
            'min_order'  => $request->min_order ?? 0,
            'valid_from' => $request->valid_from,
            'valid_until'=> $request->valid_until,
            'usage_limit'=> $request->usage_limit ?? 0,
            'is_active'  => $request->is_active,
        ];

        if ($request->hasFile('image')) {
            if ($kupon->image) Storage::delete('public/' . $kupon->image);
            $data['image'] = $request->file('image')->store('kupon', 'public');
        }

        $kupon->update($data);

        return response()->json([
            'message' => "Kupon \"{$kupon->code}\" berhasil diperbarui",
        ]);
    }

    public function destroy(Kupon $kupon)
    {
        $code = $kupon->code;
        if ($kupon->image) Storage::delete('public/' . $kupon->image);
        $kupon->delete();

        return response()->json([
            'message' => "Kupon \"{$code}\" berhasil dihapus",
        ]);
    }
}
