@extends('layouts.app')

@section('content')
<div class="mx-auto container py-8">
    <h1 class="text-lg font-pixel uppercase tracking-wider text-ink">Blocs minecraft</h1>
    <p class="mt-1 text-sm text-slate-600">Tous les blocs pour Erwan</p>
    <form method="GET" action="{{ route('block.index') }}" class="flex flex-col sm:flex-row items-left mt-4 gap-2 sm:gap-4">
        <p class="font-semibold text-lg">Filtrer par catégorie ou famille</p>
<input
    type="text"
    name="search"
    value="{{ request('search') }}"
    placeholder="Rechercher un bloc..."
    class="bg-white border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none w-full sm:w-64"
>
        <select name="category" class="bg-white border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none w-fit" onchange="this.form.submit()">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $category)
                @if (!empty($category))
                    <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                @endif
            @endforeach
        </select>
        <select name="family" class="bg-white border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none w-fit" onchange="this.form.submit()">
            <option value="">Toutes les familles</option>
            @foreach($families as $family)
                @if (!empty($family))
                    <option value="{{ $family }}" @selected(request('family') === $family)>{{ $family }}</option>
                @endif
            @endforeach
        </select>
    </form>

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
    @foreach($blocks as $block)
        <div class="relative rounded-lg flex flex-col gap-3 items-center justify-center bg-brown-dark p-4 shadow-[0_0_0_2px_var(--color-ink),0_0_0_6px_var(--color-stone),6px_6px_0_rgba(15,23,42,0.35)] transition hover:-translate-y-1 hover:shadow-[0_0_0_2px_var(--color-ink),0_0_0_6px_var(--color-stone),10px_10px_0_rgba(15,23,42,0.4)]"
        id="{{ \Illuminate\Support\Str::slug($block->block_name) }}">
            <div class="flex items-center justify-center mb-2">
                <img class="h-14 w-14 aspect-square rounded [image-rendering:pixelated] shadow-[inset_0_0_0_2px_rgba(0,0,0,0.35),0_2px_0_rgba(0,0,0,0.25)]" src="{{ asset('images/blocks/' . $block->file_name) }}" alt="{{ $block->block_name }}">
            </div>
            <p class="text-center font-pixel text-xs uppercase tracking-wide text-white mb-0">{{ $block->block_name }}</p>
            @if (!empty($block->category))
                <p class="px-2 py-1 bg-white uppercase text-ink font-semibold text-sm rounded-lg">{{ $block->category }}</p>
            @endif
            @if (!empty($block->family))
                <p class="px-2 py-1 bg-grass uppercase text-white font-semibold text-sm rounded-lg">{{ $block->family }}</p>
            @endif
            <a href="{{ route('block.show', $block) }}" class="px-4 py-2 bg-transparent border-2 z-100 relative border-white text-white rounded-lg no-underline! mx-auto w-fit transition-all transition-duration-300 ease-in-out">Voir détails</a>
        </div>
    @endforeach
</div>
<div class="mt-6">
    {{ $blocks->appends(request()->query())->links() }}
</div>
@endsection


