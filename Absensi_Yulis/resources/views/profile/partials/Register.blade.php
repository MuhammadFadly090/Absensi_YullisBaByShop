<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Register') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Create an account to start using our services.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
                {{ __('Name') }}
            </label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" class="mt-1 block w-full">
            @error('name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Username -->
        <div class="mt-4">
            <label for="username" class="block text-sm font-medium text-gray-700">
                {{ __('Username') }}
            </label>
            <input id="username" type="text" name="username" :value="old('username')" required autocomplete="username" class="mt-1 block w-full">
            @error('username')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block text-sm font-medium text-gray-700">
                {{ __('Email') }}
            </label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="email" class="mt-1 block w-full">
            @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-gray-700">
                {{ __('Password') }}
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-1 block w-full">
            @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                {{ __('Confirm Password') }}
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1 block w-full">
            @error('password_confirmation')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Role -->
        <div class="mt-4">
            <label for="role" class="block text-sm font-medium text-gray-700">
                {{ __('Role') }}
            </label>
            <select id="role" name="role" required class="mt-1 block w-full">
                <option value="admin">{{ __('Admin') }}</option>
                <option value="owner">{{ __('Owner') }}</option>
            </select>
            @error('role')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</section>
