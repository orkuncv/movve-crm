<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Movve CRM') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flag-icon-css@3.5.0/css/flag-icon.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

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
    <body class="font-sans antialiased bg-gray-50 h-screen" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen">
            <!-- Sidebar (1 versie, Alpine controlled) -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" class="fixed md:static inset-y-0 left-0 z-40 w-64 flex-shrink-0 transition-transform duration-200 ease-in-out bg-white border-r border-gray-200/40 h-full" x-cloak>
                <x-sidebar />
            </aside>
            <!-- Overlay for mobile sidebar -->
            <div x-show="sidebarOpen" class="fixed inset-0 bg-black bg-opacity-30 z-30 md:hidden" @click="sidebarOpen = false" x-cloak></div>
            <!-- Main Content -->
            <div class="flex-1 flex flex-col transition-all duration-200">
                <header class="flex items-center h-20 px-8 border-b border-gray-200 bg-white relative">
                    <!-- Hamburger left -->
                    <button @click="sidebarOpen = !sidebarOpen" class="inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:text-[#251b98] hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#251b98] md:hidden">
                        <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex-1 flex items-center justify-between w-full">
                        {{ $header ?? '' }}
                    </div>

                    <div class="flex items-center gap-2 ml-auto">
                        @yield('header-action')
                    </div>
                </header>
                <main class="flex-1 p-8 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('modals')

        @livewireScripts

        @stack('scripts')

        <script>
            function incrementCounter(contactId, metaKey, csrfToken) {
                console.log('Incrementing counter for contact ' + contactId + ' and meta key ' + metaKey);

                // Toon direct feedback aan de gebruiker
                const counterElement = document.getElementById('counter-' + metaKey);
                if (counterElement) {
                    const currentValue = parseInt(counterElement.innerText.trim()) || 0;
                    counterElement.innerText = currentValue + 1;
                }

                // Stuur een AJAX verzoek om de teller te verhogen in de database
                fetch('/' + '{{ app()->getLocale() }}' + '/crm/test/increment-meta/' + contactId + '/' + metaKey, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Counter updated successfully:', data);
                    // Als de server een andere waarde teruggeeft dan we verwachten, update dan de UI
                    if (data.counter && counterElement) {
                        counterElement.innerText = data.counter;
                    }
                })
                .catch(error => {
                    console.error('Error updating counter:', error);
                    // Bij een fout, herstel de oorspronkelijke waarde
                    if (counterElement) {
                        const currentValue = parseInt(counterElement.innerText.trim()) || 0;
                        counterElement.innerText = currentValue - 1;
                    }
                });
            }

            function saveNotes(contactId, csrfToken) {
                console.log('Saving notes for contact ' + contactId);

                // Haal de notities op uit de CKEditor
                let notes = '';

                // Als er een CKEditor instantie is, gebruik die
                if (window.editor) {
                    notes = window.editor.getData();
                } else {
                    // Anders gebruik de textarea
                    const textarea = document.getElementById('notes-editor');
                    if (textarea) {
                        notes = textarea.value;
                    }
                }

                // Toon een laad-indicator of feedback aan de gebruiker
                const saveButton = document.getElementById('save-notes-button');
                if (saveButton) {
                    saveButton.disabled = true;
                    saveButton.innerText = 'Opslaan...';
                }

                // Stuur een AJAX verzoek om de notities op te slaan in de database
                fetch('/' + '{{ app()->getLocale() }}' + '/crm/test/save-notes/' + contactId + '?notes=' + encodeURIComponent(notes), {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Notes saved successfully:', data);

                    // Toon een succesmelding aan de gebruiker
                    const container = document.getElementById('notes-container');
                    if (container) {
                        const successMessage = document.createElement('div');
                        successMessage.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4';
                        successMessage.innerHTML = '<span class="block sm:inline">Notities opgeslagen.</span>';
                        container.insertBefore(successMessage, container.firstChild);

                        // Verwijder de succesmelding na 3 seconden
                        setTimeout(() => {
                            successMessage.remove();
                        }, 3000);
                    }

                    // Ververs de pagina om de nieuwe notities te tonen
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                })
                .catch(error => {
                    console.error('Error saving notes:', error);

                    // Toon een foutmelding aan de gebruiker
                    const container = document.getElementById('notes-container');
                    if (container) {
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4';
                        errorMessage.innerHTML = '<span class="block sm:inline">Fout bij opslaan notities: ' + error.message + '</span>';
                        container.insertBefore(errorMessage, container.firstChild);
                    }
                })
                .finally(() => {
                    // Herstel de knop
                    if (saveButton) {
                        saveButton.disabled = false;
                        saveButton.innerText = 'Notities opslaan';
                    }
                });
            }
        </script>
    </body>
</html>
