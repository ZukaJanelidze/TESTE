<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 via-blue-600 to-purple-700 p-6">

    <div class="w-full max-w-md bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/20">

        <!-- Title -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-white">Create Account</h1>
            <p class="text-white/70 mt-2">Join and start your journey</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" class="text-white" />
                <x-text-input id="name"
                    class="block mt-1 w-full bg-white/20 text-white placeholder-white/60 border-0 focus:ring-2 focus:ring-white rounded-xl"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="text-white" />
                <x-text-input id="email"
                    class="block mt-1 w-full bg-white/20 text-white placeholder-white/60 border-0 focus:ring-2 focus:ring-white rounded-xl"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="text-white" />
                <x-text-input id="password"
                    class="block mt-1 w-full bg-white/20 text-white placeholder-white/60 border-0 focus:ring-2 focus:ring-white rounded-xl"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full bg-white/20 text-white placeholder-white/60 border-0 focus:ring-2 focus:ring-white rounded-xl"
                    type="password"
                    name="password_confirmation"
                    required autocomplete="new-password" />
            </div>

            <!-- Gender -->
            <div class="mb-4">
                <label class="text-white text-sm">Gender</label>
                <select id="gender" name="gender" required
                    class="block mt-1 w-full bg-white/20 text-white border-0 focus:ring-2 focus:ring-white rounded-xl">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <!-- Button -->
            <div class="flex items-center justify-between mt-6">

                <a href="{{ route('login') }}"
                   class="text-white/80 hover:text-white text-sm underline">
                    Already registered?
                </a>

                <x-primary-button
                    class="bg-white text-indigo-600 hover:bg-gray-200 px-5 py-2 rounded-xl font-bold transition">
                    {{ __('Register') }}
                </x-primary-button>

            </div>

        </form>

    </div>
</div>

</x-guest-layout>
