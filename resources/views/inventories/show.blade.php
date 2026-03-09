@extends('layouts.app')

@section('content')
    <div class="mx-auto container px-4 py-8">
        <a href="{{ route('inventories.index') }}"
            class="inline-flex items-center gap-2 text-base text-ink! hover:text-black! no-underline!">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M10.5303 5.46967C10.8232 5.76256 10.8232 6.23744 10.5303 6.53033L5.81066 11.25H20C20.4142 11.25 20.75 11.5858 20.75 12C20.75 12.4142 20.4142 12.75 20 12.75H5.81066L10.5303 17.4697C10.8232 17.7626 10.8232 18.2374 10.5303 18.5303C10.2374 18.8232 9.76256 18.8232 9.46967 18.5303L3.46967 12.5303C3.17678 12.2374 3.17678 11.7626 3.46967 11.4697L9.46967 5.46967C9.76256 5.17678 10.2374 5.17678 10.5303 5.46967Z"
                    fill="currentColor" />
            </svg>
            <span>Retour</span>
        </a>
        <h1 class="mt-4 text-lg font-pixel uppercase tracking-wider text-ink">{{ $inventory->name }}</h1>
        <div class="flex flex-col gap-2 sm:gap-4 mt-6">
            @if ($inventory->description)
                <p class="text-base sm:text-lg text-black font-semibold mb-0">Description : <span
                        class="font-normal">{{ $inventory->description }}</span></p>
            @else
                <p class="text-base sm:text-lg text-black font-semibold mb-0">Description : <span class="font-normal">Aucune
                        description.</span></p>
            @endif
            <div class="pt-2 flex flex-col md:flex-row gap-2">
                <button class="btn-green hover:cursor-pointer" type="button" data-anim="open-blocks">
                    Ajouter des blocs
                </button>
                {{-- <button class="btn-brown hover:cursor-pointer" type="button" data-anim="open-blocks">
                    Modifier l'inventaire
                </button> --}}
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-lg font-pixel uppercase tracking-wider text-ink">Blocs dans l'inventaire</h2>
            @if ($inventoryBlocks->isEmpty())
                <p class="mt-3 text-sm text-ink/70">Aucun bloc pour le moment.</p>
            @else
                <ul class="mt-4 flex flex-col gap-3">
                    @foreach ($inventoryBlocks as $block)
                        <li class="flex items-center gap-4 rounded-lg bg-white/70 p-3 shadow-sm">
                            <img class="h-10 w-10 aspect-square rounded [image-rendering:pixelated] shadow-[inset_0_0_0_2px_rgba(0,0,0,0.35),0_2px_0_rgba(0,0,0,0.25)]"
                                src="{{ asset('images/blocks/' . $block->file_name) }}" alt="{{ $block->block_name }}">
                            <span class="text-sm font-semibold text-ink">x{{ $block->pivot->quantity }}</span>
                            <span
                                class="font-pixel text-sm uppercase tracking-wide text-ink">{{ $block->block_name }}</span>
                            <div class="ml-auto flex items-center gap-2">
                                <form method="POST" action="{{ route('inventories.blocks.update', [$inventory, $block]) }}"
                                    class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" min="1" value="{{ $block->pivot->quantity }}"
                                    class="w-20 rounded-md border border-stone bg-white px-2 py-1 text-sm text-ink">
                                <button type="submit"
                                    class="rounded-md border border-stone px-3 py-1 text-xs text-ink hover:bg-stone/60 transition-colors">
                                    Modifier
                                </button>
                                </form>
                                <form method="POST" action="{{ route('inventories.blocks.remove', [$inventory, $block]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-md border border-red-400 px-3 py-1 text-xs text-red-700 hover:bg-red-50 transition-colors">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    
        <form method="POST" action="{{ route('inventories.delete', $inventory) }}"
            class="mt-8">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="btn-red hover:cursor-pointer">
                Supprimer l'inventaire
            </button>
        </form>
    </div>

    <div class="fixed inset-0 bg-black/60 opacity-0 pointer-events-none" data-anim="blocks-overlay"></div>
    <div class="fixed inset-0 z-999 items-center justify-center rounded-lg w-full h-screen text-ink hidden opacity-0 invisible py-4"
        data-anim="blocks-container">
        <div class="max-sm:container h-[80dvh] md:w-200 md:h-150 rounded-lg border-2 border-black bg-white opacity-0 invisible p-6 flex flex-col gap-4"
            data-anim="blocks-box">
            <h2 class="text-center text-xl font-pixel uppercase tracking-wider text-ink">Ajouter des blocs</h2>
            <form method="GET" action="{{ route('inventories.show', $inventory) }}" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un bloc..."
                    class="w-full rounded-lg border border-stone bg-white px-3 py-2 text-sm text-ink placeholder-stone focus:border-grass focus:outline-none focus:ring-2 focus:ring-grass/40">
                <button type="submit"
                    class="rounded-lg border border-stone px-3 py-2 text-sm text-ink hover:bg-stone/60 transition-colors">
                    Chercher
                </button>
            </form>
            <div class="flex-1 overflow-y-auto pr-1">
                @if ($allBlocks->isEmpty())
                    <p class="text-center text-sm text-ink">Aucun bloc disponible pour le moment.</p>
                @else
                    <ul>
                        @foreach ($allBlocks as $block)
                            <li class="flex items-center gap-4 mb-3 bg-stone/50 rounded-lg p-3">
                                <img class="h-13 w-13 aspect-square rounded [image-rendering:pixelated] shadow-[inset_0_0_0_2px_rgba(0,0,0,0.35),0_2px_0_rgba(0,0,0,0.25)]"
                                    src="{{ asset('images/blocks/' . $block->file_name) }}"
                                    alt="{{ $block->block_name }}">
                                <div class="flex flex-col gap-3">
                                    <span
                                        class="font-pixel text-sm uppercase tracking-wide text-ink">{{ $block->block_name }}</span>
                                    <form method="POST" action="{{ route('inventories.blocks.add', $inventory) }}"
                                        class="flex items-center gap-3 select-none">
                                        @csrf
                                        <input type="hidden" name="block_id" value="{{ $block->id }}">
                                        <input type="hidden" name="quantity" value="0" data-anim="qty-input">
                                        <button type="button"
                                            class="bg-grass flex items-center justify-center p-1.5 rounded-md hover:cursor-pointer w-fit h-fit"
                                            data-anim="qty-minus" aria-label="Diminuer">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="none">
                                                <path
                                                    d="M4 12C4 11.4477 4.44772 11 5 11H19C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H5C4.44772 13 4 12.5523 4 12Z"
                                                    fill="#ffffff" />
                                            </svg>
                                        </button>

                                        <span class="text-sm font-semibold text-ink select-none"
                                            data-anim="qty-value">0</span>
                                        <button type="button"
                                            class="bg-grass flex items-center justify-center p-1.5 rounded-md hover:cursor-pointer w-fit h-fit"
                                            data-anim="qty-plus" aria-label="Augmenter">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="none">
                                                <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <button type="submit"
                                            class="btn-brown ml-1 md:ml-4 rounded-lg! py-1! opacity-0 pointer-events-none"
                                            data-anim="add-button">
                                            Ajouter
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4">
                        {{ $allBlocks->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
            <button type="button"
                class="rounded-2xl border border-stone px-4 py-2 text-sm text-ink hover:bg-stone/60 transition-colors w-full md:w-2/5 mx-auto"
                data-anim="close-blocks">
                Annuler
            </button>
        </div>
    </div>
@endsection
