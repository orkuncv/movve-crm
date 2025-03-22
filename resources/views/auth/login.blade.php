<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Movve CRM') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/flag-icon-css@3.5.0/css/flag-icon.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-text {
            background: linear-gradient(to right, #4f46e5, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .login-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="antialiased bg-gray-50">
<div class="min-h-screen">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="flex items-center space-x-2 font-extrabold">
                        <span class="text-3xl font-black gradient-text">{{ __('crm.movve') }}</span>
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="flex items-center space-x-8">
                    <x-language-switcher/>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="pt-32 pb-20">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Sign in') }}</h1>
                <p class="text-gray-600">{{ __('Welcome back to Movve CRM') }}</p>
            </div>

            <div class="bg-white rounded-lg p-8 login-card">
                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-medium" />
                        <x-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium" />
                        <x-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-indigo-600 hover:text-indigo-800 transition-colors duration-200" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition-colors duration-200 shadow-md">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
