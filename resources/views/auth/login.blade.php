@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mx-auto flex min-h-[70vh] w-full max-w-lg items-center justify-center">
        <div class="w-full rounded-2xl border border-stone bg-white/80 p-6 shadow-lg backdrop-blur">
            <h1 class="text-center text-xl font-pixel uppercase tracking-wider text-ink">{{ __('Login') }}</h1>

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="block text-sm text-ink">{{ __('Email Address') }}</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                        class="w-full rounded-lg border border-stone bg-white px-4 py-2 text-ink placeholder-stone focus:border-grass focus:outline-none focus:ring-2 focus:ring-grass/40 @error('email') border-red-500 ring-2 ring-red-400/40 @enderror"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-sm text-ink">{{ __('Password') }}</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-lg border border-stone bg-white px-4 py-2 text-ink placeholder-stone focus:border-grass focus:outline-none focus:ring-2 focus:ring-grass/40 @error('password') border-red-500 ring-2 ring-red-400/40 @enderror"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm text-ink">
                        <input
                            class="h-4 w-4 rounded border-stone text-grass focus:ring-grass"
                            type="checkbox"
                            name="remember"
                            id="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        {{ __('Remember Me') }}
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-grass hover:text-grass-dark transition-colors" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-green w-full justify-center py-3">
                    {{ __('Login') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
