<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Movve CRM') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/flag-icon-css@3.5.0/css/flag-icon.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800">
    <!-- Navigation -->
    <nav class="bg-transparent border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                       class="flex items-center py-4 space-x-2 font-extrabold text-white md:py-0">
                            <span class="flex items-center justify-center w-32 h-8">
                                <svg width="1387" height="175" viewBox="0 0 1387 175" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M94.608 174.62C64.0413 174.62 40.7233 167.109 24.654 152.088C8.58467 137.067 0.55 115.845 0.55 88.422C0.55 60.126 8.41 38.4673 24.13 23.446C39.85 8.24999 63.2553 0.651989 94.346 0.651989C104.826 0.651989 114.171 1.43799 122.38 3.00999C130.589 4.58199 138.449 6.76533 145.96 9.56V52.528C130.939 45.8907 114.869 42.572 97.752 42.572C81.8573 42.572 70.0673 46.24 62.382 53.576C54.6967 60.7373 50.854 72.3527 50.854 88.422C50.854 104.142 54.8713 115.495 62.906 122.482C71.1153 129.294 82.9053 132.7 98.276 132.7C106.66 132.7 114.782 131.914 122.642 130.342C130.677 128.77 138.624 126.325 146.484 123.006V166.236C138.973 168.856 131.026 170.865 122.642 172.262C114.433 173.834 105.088 174.62 94.608 174.62ZM164.935 172V3.27199H252.705C266.503 3.27199 277.769 5.80466 286.503 10.87C295.411 15.9353 302.048 23.0093 306.415 32.092C310.781 41 312.965 51.3927 312.965 63.27C312.965 74.6233 310.083 84.6667 304.319 93.4C298.729 101.959 291.219 108.509 281.787 113.05C283.708 114.622 285.367 116.543 286.765 118.814C288.162 120.91 289.734 123.879 291.481 127.722L310.869 172H259.517L241.701 131.39C240.303 128.246 238.557 126.063 236.461 124.84C234.539 123.443 231.745 122.744 228.077 122.744H214.191V172H164.935ZM214.191 85.016H240.129C247.29 85.016 252.792 83.182 256.635 79.514C260.652 75.6713 262.661 70.2567 262.661 63.27C262.661 48.4233 255.674 41 241.701 41H214.191V85.016ZM331.243 172V3.27199H379.189L421.109 88.946L462.767 3.27199H510.451V172H461.195V87.636L434.209 143.18H407.747L380.499 87.636V172H331.243ZM528.9 172V136.63H567.676V172H528.9ZM586.079 172V47.812H631.667L632.977 57.768C638.392 54.1 644.418 51.1307 651.055 48.86C657.867 46.4147 665.29 45.192 673.325 45.192C681.36 45.192 687.648 46.3273 692.189 48.598C696.73 50.8687 700.398 54.1873 703.193 58.554C708.782 54.5367 715.07 51.3053 722.057 48.86C729.218 46.4147 737.602 45.192 747.209 45.192C761.706 45.192 772.361 49.0347 779.173 56.72C785.985 64.2307 789.391 75.7587 789.391 91.304V172H740.921V97.068C740.921 91.4787 739.786 87.5487 737.515 85.278C735.244 82.8327 731.489 81.61 726.249 81.61C719.437 81.61 713.848 84.0553 709.481 88.946C709.83 91.2167 710.005 93.4 710.005 95.496C710.005 97.4173 710.005 99.6007 710.005 102.046V172H664.417V96.282C664.417 91.2167 663.544 87.5487 661.797 85.278C660.05 82.8327 656.732 81.61 651.841 81.61C648.522 81.61 645.291 82.4833 642.147 84.23C639.003 85.9767 636.208 88.0727 633.763 90.518V172H586.079ZM877.546 174.62C852.743 174.62 834.403 169.118 822.526 158.114C810.823 147.11 804.972 131.041 804.972 109.906C804.972 88.946 810.911 72.964 822.788 61.96C834.665 50.7813 852.918 45.192 877.546 45.192C902.349 45.192 920.689 50.7813 932.566 61.96C944.618 72.964 950.644 88.946 950.644 109.906C950.644 131.041 944.705 147.11 932.828 158.114C920.951 169.118 902.523 174.62 877.546 174.62ZM877.546 138.726C885.581 138.726 891.345 136.455 894.838 131.914C898.506 127.373 900.34 120.037 900.34 109.906C900.34 99.95 898.506 92.7013 894.838 88.16C891.345 83.444 885.581 81.086 877.546 81.086C869.686 81.086 864.009 83.444 860.516 88.16C857.023 92.7013 855.276 99.95 855.276 109.906C855.276 120.037 857.023 127.373 860.516 131.914C864.009 136.455 869.686 138.726 877.546 138.726ZM998.526 172L949.532 47.812H1000.88L1024.46 120.648L1048.04 47.812H1099.4L1050.4 172H998.526ZM1154.86 172L1105.86 47.812H1157.21L1180.79 120.648L1204.37 47.812H1255.73L1206.73 172H1154.86ZM1328.14 174.62C1313.64 174.62 1300.8 172.262 1289.62 167.546C1278.62 162.655 1269.97 155.407 1263.69 145.8C1257.57 136.193 1254.52 124.316 1254.52 110.168C1254.52 90.4307 1260.11 74.7107 1271.28 63.008C1282.46 51.1307 1299.14 45.192 1321.33 45.192C1341.59 45.192 1357.4 50.3447 1368.75 60.65C1380.28 70.9553 1386.04 85.016 1386.04 102.832V124.578H1299.84C1302.11 131.215 1306.57 135.931 1313.2 138.726C1319.84 141.521 1328.84 142.918 1340.19 142.918C1347.35 142.918 1354.51 142.307 1361.67 141.084C1369.01 139.687 1374.86 138.115 1379.23 136.368V165.974C1367 171.738 1349.97 174.62 1328.14 174.62ZM1299.84 97.854H1343.6V93.4C1343.6 88.5093 1342.02 84.492 1338.88 81.348C1335.91 78.204 1330.58 76.632 1322.9 76.632C1314.34 76.632 1308.31 78.466 1304.82 82.134C1301.5 85.6273 1299.84 90.8673 1299.84 97.854Z"
                                        fill="white"/>
                                </svg>
                            </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-4">
                    <x-language-switcher/>
                    <a href="{{ route('login', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-white/10 rounded-md hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/20">
                        {{ __('Sign In') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h2 class="text-4xl font-extrabold text-white sm:text-5xl md:text-6xl">
                <span class="block">{{ __('Manage your customers') }}</span>
                <span class="block text-green-600">{{ __('Effortlessly') }}</span>
            </h2>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-300 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                {{ __('Streamline your customer relationships, boost productivity, and grow your business with our powerful CRM solution.') }}
            </p>
            <div class="mt-10 flex justify-center gap-x-6">
                <a href="{{ route('login', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Sign in') }}
                </a>
                <a href="#"
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-green-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                    {{ __('Learn More') }}
                </a>
            </div>
        </div>
    </main>
</div>
</body>
</html>
