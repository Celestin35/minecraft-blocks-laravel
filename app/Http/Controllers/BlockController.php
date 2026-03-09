<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;

class BlockController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file_name' => 'required|string|max:255',
            'block_name' => 'required|string|max:255',
            'variant' => 'nullable|string|max:255',
            'avg_color_srgb' => 'nullable|string|max:255',
            'avg_color_linear' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'family' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'is_transparent' => 'boolean',
            'is_solid' => 'boolean',
            'detail_form' => 'nullable|string|max:255',
            'detail_flammable' => 'boolean',
            'detail_interactive' => 'boolean',
        ]);

        $block = Block::create($validated);

        return redirect()->route('block.show', $block);
    }

    public function update(Request $request, Block $block)
    {
        $validated = $request->validate([
            'file_name' => 'sometimes|string|max:255',
            'block_name' => 'sometimes|string|max:255',
            'variant' => 'nullable|string|max:255',
            'avg_color_srgb' => 'nullable|string|max:255',
            'avg_color_linear' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'family' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'is_transparent' => 'boolean',
            'is_solid' => 'boolean',
            'detail_form' => 'nullable|string|max:255',
            'detail_flammable' => 'boolean',
            'detail_interactive' => 'boolean',
        ]);

        $block->update($validated);

        return redirect()->route('block.show', $block);
    }

    public function destroy(Block $block)
    {
        $block->delete();

        return redirect()->route('block.index');
    }

    public function index(Request $request)
    {
        $query = Block::query();

        // Requète pour les barre de recherche 
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('block_name', 'like', "%{$search}%");
        }

        $query->orderBy('block_name');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('family')) {
            $query->where('family', $request->family);
        }

        $blocks = $query->paginate(50);

        $categories = Block::query()
            ->select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $families = Block::query()
            ->select('family')
            ->whereNotNull('family')
            ->distinct()
            ->orderBy('family')
            ->pluck('family');

        return view('blocks.list', compact('blocks', 'categories', 'families'));
    }

    public function show(Block $block)
    {
        return view('blocks.show', compact('block'));
    }
}
