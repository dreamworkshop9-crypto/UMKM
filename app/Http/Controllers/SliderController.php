<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        return view('admin.slider.index');
    }

    public function list(Request $request)
    {
        $query = Slider::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->orderBy('order')->orderByDesc('id')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'image'       => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ]);

        $path = $request->file('image')->store('slider', 'public');
        $maxOrder = Slider::max('order') ?? 0;

        $slider = Slider::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $path,
            'order'       => $maxOrder + 1,
        ]);

        return response()->json([
            'message' => "Slider \"{$slider->title}\" berhasil ditambahkan",
        ], 201);
    }

    public function show(Slider $slider)
    {
        return response()->json($slider);
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'image'       => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'is_active'   => 'required|boolean',
        ]);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'is_active'   => $request->is_active,
        ];

        if ($request->hasFile('image')) {
            if ($slider->image) Storage::delete('public/' . $slider->image);
            $data['image'] = $request->file('image')->store('slider', 'public');
        }

        $slider->update($data);

        return response()->json([
            'message' => "Slider \"{$slider->title}\" berhasil diperbarui",
        ]);
    }

    public function destroy(Slider $slider)
    {
        $name = $slider->title;
        if ($slider->image) Storage::delete('public/' . $slider->image);
        $slider->delete();

        return response()->json([
            'message' => "Slider \"{$name}\" berhasil dihapus",
        ]);
    }
}
