@extends('layouts.app')

@section('content')
<div class="mx-auto container py-8">
    <h1 class="text-2xl font-pixel uppercase tracking-wider text-ink mb-4">Inventaires</h1>
    <button class="btn-green hover:cursor-pointer" data-anim="open-form">
        Créer un inventaire
    </button>
</div>
{{-- Liste des inventaires --}}
<div class="container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
    @foreach($inventories as $inventory)
        <a href="{{ route('inventories.show', $inventory) }}" class="block rounded-lg border border-stone bg-white/80 p-4 shadow-lg backdrop-blur transition hover:-translate-y-1 hover:shadow-xl">
            <h2 class="text-center text-lg font-pixel uppercase tracking-wider text-ink">{{ $inventory->name }}</h2>
            @if ($inventory->description)
                <p class="mt-2 text-center text-sm text-ink/80">{{ $inventory->description }}</p>
            @else
                <p class="mt-2 text-center text-sm text-ink/60">Aucune description.</p>
            @endif
        </a>
    @endforeach
</div>

{{-- Formulaire de creation d'inventaire  --}}
<div class="fixed inset-0 bg-black/60 opacity-0 pointer-events-none" data-anim="overlay"></div>
<div class="fixed inset-0 z-999 items-center justify-center rounded-lg w-full h-screen text-ink hidden opacity-0 invisible py-4" data-anim="form-container">
    <div class="w-full max-w-lg rounded-2xl border border-stone bg-white/80 p-6 shadow-lg backdrop-blur opacity-0 invisible" data-anim="form">
        <h2 class="text-center text-xl font-pixel uppercase tracking-wider text-ink">Créer votre inventaire</h2>
        <p class="mt-2 text-center text-sm text-ink/70">Définissez votre nouvel inventaire en quelques secondes.</p>
        <form method="POST" action="{{ route('inventories.store') }}" class="mt-6 space-y-5">
            @csrf

            <div class="space-y-2">
                <label for="name" class="block text-sm text-ink">Nom de l'inventaire</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full rounded-lg border border-stone bg-white px-4 py-2 text-ink placeholder-stone focus:border-grass focus:outline-none focus:ring-2 focus:ring-grass/40 @error('name') border-red-500 ring-2 ring-red-400/40 @enderror"
                    placeholder="Mon inventaire"
                >
                @error('name')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-sm text-ink">Description (optionnel)</label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full rounded-lg border border-stone bg-white px-4 py-2 text-ink placeholder-stone focus:border-grass focus:outline-none focus:ring-2 focus:ring-grass/40 @error('description') border-red-500 ring-2 ring-red-400/40 @enderror"
                    placeholder="Une courte description..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between gap-3">
                <button type="button" class="rounded-2xl border border-white px-4 py-2 text-sm text-ink bg-white hover:bg-stone transition-colors hover:cursor-pointer" data-anim="close-form">
                    Annuler
                </button>
                <button type="submit" class="btn-green w-full max-w-xs justify-center py-3 hover:cursor-pointer">
                    Créer l'inventaire
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
