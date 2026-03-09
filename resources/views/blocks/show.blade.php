@extends('layouts.app')

@section('content')
<div class="mx-auto container px-4 py-8">
    <a href="{{ route('block.index') . "#" . \Illuminate\Support\Str::slug($block->block_name) }}" class="inline-flex items-center gap-2 text-base text-ink! hover:text-black! no-underline!">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5303 5.46967C10.8232 5.76256 10.8232 6.23744 10.5303 6.53033L5.81066 11.25H20C20.4142 11.25 20.75 11.5858 20.75 12C20.75 12.4142 20.4142 12.75 20 12.75H5.81066L10.5303 17.4697C10.8232 17.7626 10.8232 18.2374 10.5303 18.5303C10.2374 18.8232 9.76256 18.8232 9.46967 18.5303L3.46967 12.5303C3.17678 12.2374 3.17678 11.7626 3.46967 11.4697L9.46967 5.46967C9.76256 5.17678 10.2374 5.17678 10.5303 5.46967Z" fill="currentColor"/>
        </svg>
        <span>Retour</span>
    </a>
    @if (!empty($block->block_name))
        <h1 class="mt-4 text-lg font-pixel uppercase tracking-wider text-ink">{{ $block->block_name }}</h1>
    @endif
    <div class="flex flex-col gap-2 sm:gap-4 mt-6">
        @if (!is_array($block->file_name) && !empty($block->file_name))
            <img class="mb-3 h-14 w-14 aspect-square rounded [image-rendering:pixelated] shadow-[inset_0_0_0_2px_rgba(0,0,0,0.35),0_2px_0_rgba(0,0,0,0.25)]" src="{{ asset('images/blocks/' . $block->file_name) }}" alt="{{ $block->block_name }}">
        @endif
        @if (!empty($block->family))
            <p class="text-base sm:text-lg text-black font-semibold mb-0">Famille : <span class="font-normal">{{ $block->family }}</span></p>
        @endif
        @if (!empty($block->material))
            <p class="text-base sm:text-lg text-black font-semibold mb-0">Matériau : <span class="font-normal">{{ $block->material }}</span></p>
        @endif
        @if (!is_null($block->is_transparent))
            <p class="text-base sm:text-lg text-black font-semibold mb-0">Transparent : <span class="font-normal">{{ $block->is_transparent ? 'Oui' : 'Non' }}</span></p>
        @endif
        @if (!is_null($block->is_solid))
            <p class="text-base sm:text-lg text-black font-semibold mb-0">Solide : <span class="font-normal">{{ $block->is_solid ? 'Oui' : 'Non' }}</span></p>
        @endif
        @if (!empty($block->detail_form))
            <p class="text-base sm:text-lg text-black font-semibold mb-0">Forme : <span class="font-normal">{{ $block->detail_form }}</span></p>
        @endif
        @if (!is_null($block->detail_flammable))
            <p class="text-base sm:text-lg text-black font-semibold mb-0">Inflammable : <span class="font-normal">{{ $block->detail_flammable ? 'Oui' : 'Non' }}</span></p>
        @endif
        @if (!is_null($block->detail_interactive))
            <p class="text-base sm:text-lg text-black font-semibold mb-0">Interactif : <span class="font-normal">{{ $block->detail_interactive ? 'Oui' : 'Non' }}</span></p>
        @endif
    </div>
</div>
@endsection
