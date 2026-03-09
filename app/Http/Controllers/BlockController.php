<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;

class BlockController extends Controller
{
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
