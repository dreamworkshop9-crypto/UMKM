<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.brands.index');
    }

    public function list(Request $request)
    {
        $query = Brand::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        $brands = $query->orderBy('name')->get();

        $brands->transform(function ($brand) {
            $brand->image_url = $brand->image
                ? Storage::url($brand->image)
                : null;
            return $brand;
        });

        return response()->json($brands);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $path = $request->file('image')->store('brands', 'public');

        $brand = Brand::create([
            'name'  => $request->name,
            'slug'  => Str::slug($request->name),
            'image' => $path,
        ]);

        return response()->json([
            'message' => "Merek \"{$brand->name}\" berhasil ditambahkan",
        ], 201);
    }

    public function show(Brand $brand)
    {
        $brand->image_url = $brand->image
            ? Storage::url($brand->image)
            : null;

        return response()->json($brand);
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        if ($request->hasFile('image')) {
            if ($brand->image) {
                Storage::delete('public/' . $brand->image);
            }
            $data['image'] = $request->file('image')->store('brands', 'public');
        }

        $brand->update($data);

        return response()->json([
            'message' => "Merek \"{$brand->name}\" berhasil diperbarui",
        ]);
    }

    public function destroy(Brand $brand)
    {
        $name = $brand->name;

        if ($brand->image) {
            Storage::delete('public/' . $brand->image);
        }

        $brand->delete();

        return response()->json([
            'message' => "Merek \"{$name}\" berhasil dihapus",
        ]);
    }
}
