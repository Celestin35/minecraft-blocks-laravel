<nav class="bg-white shadow-sm">
    <div class="container flex flex-col gap-4 py-4 md:flex-row md:items-center md:justify-between">
        <a class="text-base uppercase font-pixel text-ink hover:text-grass transition-colors " href="{{ route('block.index') }}">
            minecraft
        </a>

        <div class="flex flex-col gap-3 md:flex-row md:items-center md:gap-6">
            <ul class="flex flex-col gap-2 text-sm md:flex-row md:items-center md:gap-6">
                <li>
                    <a class="text-ink hover:text-grass transition-colors" href="{{ route('inventories.index') }}">
                        Voir les inventaires
                    </a>
                </li>
                <li>
                    <a class="text-ink hover:text-grass transition-colors" href="{{ route('block.index') }}">
                        Voir les blocs
                    </a>
                </li>
            </ul>

            <ul class="flex flex-col gap-2 md:flex-row md:items-center md:gap-4">
                @guest
                    @if (Route::has('login'))
                        <li>
                            <a class="text-ink hover:text-grass transition-colors" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li>
                            <a class="text-ink hover:text-grass transition-colors" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="text-ink">
                        {{ Auth::user()->name }}
                    </li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-2xl border border-stone px-4 py-2 text-sm text-ink hover:bg-stone/60 transition-colors">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
