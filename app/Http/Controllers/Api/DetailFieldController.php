<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailField;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Response;
class DetailFieldController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(DetailField::all());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|in:number,boolean,select',
        ]);

        $field = DetailField::create($validated);

        return response()->json($field, 201);
    }

    public function update(Request $request, DetailField $detailField): JsonResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|in:string,number,boolean,text',
        ]);

        $detailField->update($validated);

        return response()->json($detailField);
    }

    public function destroy(DetailField $detailField): Response
    {
        $detailField->delete();
        return response()->noContent();
    }
}
