<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Http\Resources\ColorResource;
use Illuminate\Http\Request;


class ColorController extends Controller
{
    public function index(Request $request)
    {
        $q = Color::query()
            ->when($request->filled('active'), fn($x) => $x->where('active', (bool)$request->boolean('active')))
            ->paginate($request->integer('per_page', 15));

        return response()->json($q);
    }

    public function show(Color $color)
    {
        return response()->json($color);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'hex'   => 'nullable|string|max:7', // Example: #FFFFFF
            'active'=> 'boolean'
        ]);

        $color = Color::create($data);

        return response()->json($color, 201);
    }

    public function update(Request $request, Color $color)
    {
        $data = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'hex'   => 'nullable|string|max:7',
            'active'=> 'boolean'
        ]);

        $color->update($data);

        return response()->json($color);
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return response()->json(['message' => 'deleted']);
    }
}