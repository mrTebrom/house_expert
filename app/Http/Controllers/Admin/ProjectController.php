<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_code' => 'required|string|unique:projects',
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'total_area' => 'nullable|numeric',
            'dimensions' => 'nullable|string|max:255',
            'floors' => 'required|integer|min:1',
            'has_basement' => 'sometimes|boolean',
        ]);

        // Приводим чекбокс в нормальное булево значение
        $validated['has_basement'] = $request->has('has_basement');

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Проект успешно создан.');
    }

    public function edit(Project $project)
    {
        $categories = Category::all();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'project_code' => 'required|string|unique:projects,project_code,' . $project->id,
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'total_area' => 'nullable|numeric',
            'dimensions' => 'nullable|string|max:255',
            'floors' => 'required|integer|min:1',
            'has_basement' => 'sometimes|boolean',
        ]);

        $validated['has_basement'] = $request->has('has_basement');

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Проект успешно обновлён.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Проект удалён.');
    }
}
