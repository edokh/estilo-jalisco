<x-guest-layout>
    <div class="w-full max-w-md rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 shadow-2xl">

        <div class="mb-8 text-center">
            <h1 class="font-serif text-3xl text-[#D4A017]">
                Welcome Back
            </h1>

            <p class="mt-2 text-sm text-[#FAF3E0]/60">
                Sign in to continue your order.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6 rounded-lg border border-[#D4A017]/20 bg-[#130E07] p-3 text-[#D4A017]"
            :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="mb-2 text-[#FAF3E0]" />

                <x-text-input id="email"
                    class="block w-full rounded-lg border-[#D4A017]/20 bg-[#130E07] text-[#FAF3E0] placeholder:text-[#FAF3E0]/40 focus:border-[#D4A017] focus:ring-[#D4A017]"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />

                <x-input-error :messages="$errors->get('email')" class="mt-2 text-[#C0392B]" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="mb-2 text-[#FAF3E0]" />

                <x-text-input id="password"
                    class="block w-full rounded-lg border-[#D4A017]/20 bg-[#130E07] text-[#FAF3E0] placeholder:text-[#FAF3E0]/40 focus:border-[#D4A017] focus:ring-[#D4A017]"
                    type="password" name="password" required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-[#C0392B]" />
            </div>

            <!-- Remember -->
            <div class="flex items-center justify-between">

                <label for="remember_me" class="inline-flex items-center">

                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-[#D4A017]/30 bg-[#130E07] text-[#C0392B] focus:ring-[#D4A017]">

                    <span class="ms-2 text-sm text-[#FAF3E0]/70">
                        {{ __('Remember me') }}
                    </span>

                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-[#D4A017] transition hover:text-[#e8b72d]">

                        {{ __('Forgot password?') }}

                    </a>
                @endif

            </div>

            <!-- Login Button -->
            <x-primary-button
                class="w-full justify-center rounded-lg bg-[#C0392B] py-3 text-base font-semibold text-white transition hover:bg-[#a93226] focus:bg-[#a93226] focus:ring-[#D4A017]">

                {{ __('Log in') }}

            </x-primary-button>

            <p class="text-center text-sm text-[#FAF3E0]/50">
                Don't have an account?

                <a href="{{ route('register') }}" class="font-medium text-[#D4A017] hover:text-[#e8b72d]">

                    Sign Up

                </a>
            </p>

        </form>

    </div>
</x-guest-layout>
