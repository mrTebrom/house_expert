<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|url',
            'description' => 'nullable|string',
            'images' => 'required|images|max:2048',
        ]);

        $image = base64_encode(file_get_contents($request->file('images')->getRealPath()));

        Slider::create([
            'title' => $validated['title'],
            'link' => $validated['link'],
            'description' => $validated['description'],
            'image_base64' => $image,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Слайд добавлен');
    }
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|url',
            'description' => 'nullable|string',
            'images' => 'nullable|images|max:2048',
        ]);

        if ($request->hasFile('images')) {
            $image = base64_encode(file_get_contents($request->file('images')->getRealPath()));
            $slider->image_base64 = $image;
        }

        $slider->update([
            'title' => $validated['title'],
            'link' => $validated['link'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Слайд обновлён');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Слайд удалён');
    }

}
