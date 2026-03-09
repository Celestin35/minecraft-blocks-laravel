<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Block;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    // Afficher la liste des inventaires de l'utilisateur
    public function index(Request $request)
    {
        $inventories = Inventory::with('user')->orderBy('created_at', 'desc')->get();
        return view('inventories.list', compact('inventories'));
    }

    // Afficher les détails d'un inventaire
    public function show(Request $request, Inventory $inventory)
    {
        if ($inventory->user_id !== Auth::id()) {
            abort(403);
        }
        $inventory->load('user', 'blocks');
        $inventoryBlocks = $inventory->blocks;
        $search = $request->input('search');
        $allBlocks = Block::when($search, function ($q) use ($search) {
            $q->where('block_name', 'like', "%{$search}%");
        })->orderBy('block_name')->paginate(50);

        return view('inventories.show', compact('inventory', 'inventoryBlocks', 'allBlocks'));
    }

    public function delete(Inventory $inventory)
    {
        if ($inventory->user_id !== Auth::id()) {
            abort(403);
        }
        $inventory->delete();
        return redirect()->route('inventories.index')->with('success', 'Inventory deleted successfully.');
    }
    
    // Afficher le formulaire de création d'inventaire
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $inventory = Inventory::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('inventories.show', $inventory)->with('success', 'Inventory created successfully.');
    }


    // Ajouter un bloc à l'inventaire
    public function addBlock(Request $request, Inventory $inventory)
    {
        if ($inventory->user_id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $quantity = (int) $request->quantity;
        // Vérifier si le bloc existe déjà dans l'inventaire
        $existing = $inventory->blocks()->where('blocks.id', $request->block_id)->first();
        if ($existing) {
            $inventory->blocks()->updateExistingPivot(
                $request->block_id,
                ['quantity' => $existing->pivot->quantity + $quantity]
            );
        } else {
            $inventory->blocks()->attach($request->block_id, ['quantity' => $quantity]);
        }

        $this->recountBlocks($inventory);
        return redirect()->route('inventories.show', $inventory)->with('success', 'Block added to inventory.');
    }

    // Mettre à jour la quantité d'un bloc dans l'inventaire
    public function updateBlock(Request $request, Inventory $inventory, Block $block)
    {
        if ($inventory->user_id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $inventory->blocks()->updateExistingPivot($block->id, ['quantity' => $request->quantity]);
        $this->recountBlocks($inventory);
        return redirect()->route('inventories.show', $inventory)->with('success', 'Block quantity updated.');
    }

    // Retirer un bloc de l'inventaire
    public function removeBlock(Inventory $inventory, Block $block)
    {
        if ($inventory->user_id !== Auth::id()) {
            abort(403);
        }

        $inventory->blocks()->detach($block->id);
        $this->recountBlocks($inventory);
        return redirect()->route('inventories.show', $inventory)->with('success', 'Block removed from inventory.');
    }

    // Recalculer le nombre total de blocs dans l'inventaire
    private function recountBlocks(Inventory $inventory): void
    {
        $total = $inventory->blocks()->sum('block_inventory.quantity');
        $inventory->update(['total_blocks' => $total]);
    }
}
