<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;

class ProjectImageController extends Controller
{
    /**
     * Страница управления изображениями проекта
     */
    public function index(Project $project)
    {
        $images = $project->images()->orderBy('order')->get();

        return view('admin.projects.image', compact('project', 'images'));
    }


    /**
     * Загрузка изображений (одно или несколько)
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|max:5120',
        ]);

        $maxOrder = $project->images()->max('order') ?? 0;

        foreach ($request->file('images') as $index => $file) {
            $base64 = base64_encode(file_get_contents($file));
            $mime = $file->getMimeType();

            $project->images()->create([
                'base64' => $base64,
                'mime_type' => $mime,
                'alt' => '',
                'order' => $maxOrder + $index + 1,
                'is_main' => false,
            ]);
        }

        return redirect()->route('admin.projects.images.index', $project)->with('success', 'Изображения успешно загружены.');
    }

    /**
     * Удаление изображения
     */
    public function destroy(Project $project, ProjectImage $image)
    {
        if ($image->project_id !== $project->id) {
            abort(403);
        }

        $image->delete();

        return redirect()->route('admin.projects.images.index', $project)->with('success', 'Изображение удалено.');
    }

    /**
     * Сортировка изображений (по массиву ID)
     */
    public function reorder(Request $request, Project $project)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer',
        ]);

        foreach ($request->order as $index => $id) {
            ProjectImage::where('id', $id)
                ->where('project_id', $project->id)
                ->update(['order' => $index]);
        }

        return response()->json(['message' => 'Порядок изображений обновлён.']);
    }

    /**
     * Установить изображение как главное
     */
    public function setMain(Project $project, ProjectImage $image)
    {
        if ($image->project_id !== $project->id) {
            abort(403);
        }

        // сбросить прежние главные
        $project->images()->update(['is_main' => false]);

        // назначить новое главное
        $image->update(['is_main' => true]);

        return redirect()->route('admin.projects.images.index', $project)->with('success', 'Главное изображение обновлено.');
    }
}
