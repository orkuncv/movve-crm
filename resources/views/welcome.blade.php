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
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.1);
        }
    </style>
</head>
<body class="antialiased bg-white">
<div class="min-h-screen">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                       class="flex items-center space-x-2 font-extrabold">
                        <span class="text-3xl font-black gradient-text">{{ __('crm.movve') }}</span>
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-indigo-600 transition-colors duration-200 font-medium">{{ __('Features') }}</a>
                    <x-language-switcher/>
                    <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="bg-indigo-600 text-white px-8 py-2 rounded-lg font-semibold text-lg hover:bg-indigo-700 transition-colors duration-200 w-full sm:w-auto shadow-md">{{ __('Login') }}</a>
                </div>
                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button" class="text-gray-600 hover:text-indigo-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-white">
        <!-- Hero content -->
        <div class="relative pt-32 pb-16 sm:pt-40 sm:pb-20 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-gray-900 mb-6 leading-tight">
                    <span class="gradient-text">{{ __('Transform') }}</span> {{ __('Your') }}
                    <br class="hidden sm:block" />
                    {{ __('Customer Relations') }}
                </h1>
                <p class="text-xl text-gray-600 mb-10 max-w-3xl mx-auto">
                    {{ __('Powerful, intuitive, and modern CRM solution designed to help your business grow and succeed in the digital age.') }}
                </p>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6 mb-16">
                    <a href="{{ route('login', ['locale' => app()->getLocale()]) }}"
                       class="bg-indigo-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-700 transition-colors duration-200 w-full sm:w-auto shadow-md">
                        {{ __('Login') }}
                    </a>
                </div>

                <!-- Stats Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8 max-w-5xl mx-auto">
                    <div class="p-6 bg-gray-50 rounded-xl shadow-sm">
                        <div class="text-4xl font-bold text-indigo-600 mb-2">99.9%</div>
                        <div class="text-gray-600">{{ __('Platform uptime') }}</div>
                    </div>
                    <div class="p-6 bg-gray-50 rounded-xl shadow-sm">
                        <div class="text-4xl font-bold text-indigo-600 mb-2">3 min</div>
                        <div class="text-gray-600">{{ __('Average support response') }}</div>
                    </div>
                    <div class="p-6 bg-gray-50 rounded-xl shadow-sm">
                        <div class="text-4xl font-bold text-indigo-600 mb-2">10k+</div>
                        <div class="text-gray-600">{{ __('Happy customers') }}</div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Feature Section -->
    <div class="bg-gray-50 py-24" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('Everything you need, all in one place') }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ __('Our comprehensive CRM solution replaces multiple systems with one integrated platform') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg feature-card">
                    <div class="bg-indigo-100 w-14 h-14 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('Customer Management') }}</h3>
                    <p class="text-gray-600 mb-4">{{ __('Efficiently manage and organize your customer data in one centralized location.') }}</p>
                    <a href="#" class="text-indigo-600 font-medium hover:text-indigo-700 inline-flex items-center">
                        {{ __('Learn more') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg feature-card">
                    <div class="bg-indigo-100 w-14 h-14 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('Analytics & Insights') }}</h3>
                    <p class="text-gray-600 mb-4">{{ __('Make data-driven decisions with powerful analytics and reporting tools.') }}</p>
                    <a href="#" class="text-indigo-600 font-medium hover:text-indigo-700 inline-flex items-center">
                        {{ __('Learn more') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg feature-card">
                    <div class="bg-indigo-100 w-14 h-14 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('Automation') }}</h3>
                    <p class="text-gray-600 mb-4">{{ __('Streamline your workflow with intelligent automation features.') }}</p>
                    <a href="#" class="text-indigo-600 font-medium hover:text-indigo-700 inline-flex items-center">
                        {{ __('Learn more') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Section -->
    <div class="bg-white py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('Why choose Movve CRM?') }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ __('See how our solution compares to traditional systems') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Other Systems -->
                <div class="bg-gray-50 rounded-lg p-8 shadow-sm">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ __('With other systems') }}</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span class="text-gray-600">{{ __('Multiple disconnected tools') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span class="text-gray-600">{{ __('Complex setup and maintenance') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span class="text-gray-600">{{ __('Higher total cost of ownership') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- With Movve -->
                <div class="bg-indigo-50 rounded-lg p-8 shadow-sm border border-indigo-100">
                    <h3 class="text-2xl font-bold text-indigo-900 mb-6">{{ __('With Movve CRM') }}</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">{{ __('All-in-one integrated solution') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">{{ __('Easy setup and intuitive interface') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">{{ __('Predictable pricing with no hidden costs') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</body>
</html>
