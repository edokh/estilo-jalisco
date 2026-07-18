<x-guest-layout>
    <div class="w-full max-w-md rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 shadow-2xl">

        <div class="mb-8 text-center">
            <h1 class="font-serif text-3xl text-[#D4A017]">
                Create an Account
            </h1>

            <p class="mt-2 text-sm text-[#FAF3E0]/60">
                Join us to save your orders and checkout faster.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="mb-2 text-[#FAF3E0]" />

                <x-text-input id="name"
                    class="block w-full rounded-lg border-[#D4A017]/20 bg-[#130E07] text-[#FAF3E0] placeholder:text-[#FAF3E0]/40 focus:border-[#D4A017] focus:ring-[#D4A017]"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />

                <x-input-error :messages="$errors->get('name')" class="mt-2 text-[#C0392B]" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="mb-2 text-[#FAF3E0]" />

                <x-text-input id="email"
                    class="block w-full rounded-lg border-[#D4A017]/20 bg-[#130E07] text-[#FAF3E0] placeholder:text-[#FAF3E0]/40 focus:border-[#D4A017] focus:ring-[#D4A017]"
                    type="email" name="email" :value="old('email')" required autocomplete="username" />

                <x-input-error :messages="$errors->get('email')" class="mt-2 text-[#C0392B]" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('Phone')" class="mb-2 text-[#FAF3E0]" />

                <x-text-input id="phone"
                    class="block w-full rounded-lg border-[#D4A017]/20 bg-[#130E07] text-[#FAF3E0] placeholder:text-[#FAF3E0]/40 focus:border-[#D4A017] focus:ring-[#D4A017]"
                    type="tel" name="phone" :value="old('phone')" required autocomplete="tel" />

                <x-input-error :messages="$errors->get('phone')" class="mt-2 text-[#C0392B]" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="mb-2 text-[#FAF3E0]" />

                <x-text-input id="password"
                    class="block w-full rounded-lg border-[#D4A017]/20 bg-[#130E07] text-[#FAF3E0] placeholder:text-[#FAF3E0]/40 focus:border-[#D4A017] focus:ring-[#D4A017]"
                    type="password" name="password" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-[#C0392B]" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="mb-2 text-[#FAF3E0]" />

                <x-text-input id="password_confirmation"
                    class="block w-full rounded-lg border-[#D4A017]/20 bg-[#130E07] text-[#FAF3E0] placeholder:text-[#FAF3E0]/40 focus:border-[#D4A017] focus:ring-[#D4A017]"
                    type="password" name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[#C0392B]" />
            </div>

            <div class="flex flex-col-reverse gap-4 pt-2 sm:flex-row sm:items-center sm:justify-between">

                <a href="{{ route('login') }}"
                    class="text-center text-sm text-[#D4A017] transition hover:text-[#e8b72d]">

                    {{ __('Already registered? Sign in') }}

                </a>

                <x-primary-button
                    class="w-full justify-center rounded-lg bg-[#C0392B] py-3 text-base font-semibold text-white transition hover:bg-[#a93226] focus:bg-[#a93226] focus:ring-[#D4A017] sm:w-auto">

                    {{ __('Register') }}

                </x-primary-button>

            </div>

        </form>

    </div>
</x-guest-layout>
