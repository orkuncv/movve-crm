# Movve CRM Stijlgids & Ontwikkelaarshandleiding

Deze stijlgids dient als referentie voor ontwikkelaars en AI-assistenten die werken aan het Movve CRM-platform. Het document beschrijft de visuele taal, componenten, en best practices die gebruikt worden in het project.

## Inhoudsopgave

1. [Branding & Visuele Identiteit](#branding--visuele-identiteit)
2. [Kleuren](#kleuren)
3. [Typografie](#typografie)
4. [UI Componenten](#ui-componenten)
5. [Iconen](#iconen)
6. [Formulieren](#formulieren)
7. [Lokalisatie](#lokalisatie)
8. [Projectstructuur](#projectstructuur)
9. [Best Practices](#best-practices)

## Branding & Visuele Identiteit

Movve CRM is een modern, professioneel en gebruiksvriendelijk platform dat bedrijven helpt hun klantrelaties te beheren. De visuele identiteit is gebaseerd op de volgende principes:

- **Modern & Professioneel**: Gebruik van gradiënten, subtiele schaduwen en afgeronde hoeken
- **Gebruiksvriendelijk**: Duidelijke visuele hiërarchie, consistente navigatie en intuïtieve interacties
- **Responsief**: Alle interfaces zijn ontworpen om goed te werken op verschillende schermformaten

## Kleuren

### Primaire Kleuren

De primaire kleuren worden gebruikt voor belangrijke elementen zoals knoppen, links en accentuering.

```css
/* Primaire gradiënt */
.gradient-primary {
  background-image: linear-gradient(to right, #6366f1, #a855f7);
}

/* Primaire kleuren */
.indigo-600 { color: #4f46e5; }
.purple-600 { color: #9333ea; }
```

### Secundaire Kleuren

Secundaire kleuren worden gebruikt voor minder prominente elementen, achtergronden en accenten.

```css
/* Grijstinten */
.gray-50 { color: #f9fafb; }
.gray-100 { color: #f3f4f6; }
.gray-200 { color: #e5e7eb; }
.gray-300 { color: #d1d5db; }
.gray-400 { color: #9ca3af; }
.gray-500 { color: #6b7280; }
.gray-700 { color: #374151; }
.gray-800 { color: #1f2937; }
```

### Functionele Kleuren

Functionele kleuren worden gebruikt om specifieke statussen of acties aan te geven.

```css
/* Success */
.green-500 { color: #10b981; }

/* Warning */
.yellow-500 { color: #f59e0b; }

/* Error */
.red-500 { color: #ef4444; }

/* Info */
.blue-500 { color: #3b82f6; }
```

## Typografie

Movve CRM gebruikt een consistente typografische hiërarchie om informatie duidelijk te structureren.

### Font Familie

```css
font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
```

### Koppen

```html
<h1 class="font-bold text-3xl gradient-text">Pagina Titel</h1>
<h2 class="font-bold text-2xl gradient-text">Sectie Titel</h2>
<h3 class="font-semibold text-xl text-gray-800">Subsectie Titel</h3>
<h4 class="font-medium text-lg text-gray-700">Kleinere Titel</h4>
```

### Bodytekst

```html
<p class="text-base text-gray-600">Standaard paragraaf tekst</p>
<p class="text-sm text-gray-500">Kleinere tekst voor minder belangrijke informatie</p>
```

## UI Componenten

### Knoppen

#### Primaire Knop

Gebruik voor de belangrijkste actie op een pagina.

```html
<button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <!-- Icon path here -->
    </svg>
    {{ __('Button Text') }}
</button>
```

#### Secundaire Knop

Gebruik voor secundaire acties zoals "Annuleren" of "Terug".

```html
<a href="{{ route('route.name', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 tracking-wider hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <!-- Icon path here -->
    </svg>
    {{ __('Button Text') }}
</a>
```

### Kaarten

Gebruik kaarten om gerelateerde informatie te groeperen.

```html
<div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
    <div class="p-6 lg:p-8">
        <!-- Kaart inhoud -->
    </div>
</div>
```

### Tabellen

Gebruik tabellen voor het weergeven van gestructureerde gegevens.

```html
<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Column Name') }}
            </th>
            <!-- Meer kolommen -->
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        <!-- Tabelrijen -->
    </tbody>
</table>
```

### Paginaheaders

Gebruik consistente paginaheaders met een titel en actieknoppen.

```html
<div class="flex justify-between items-center">
    <h2 class="font-bold text-2xl gradient-text">
        {{ __('Page Title') }}
    </h2>
    <div class="flex space-x-3">
        <!-- Actieknoppen -->
    </div>
</div>
```

## Iconen

Movve CRM gebruikt Heroicons (Outline) voor alle iconen. Gebruik altijd de volgende structuur:

```html
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="...path data..." />
</svg>
```

### Veelgebruikte Iconen

- **Toevoegen**: `M12 6v6m0 0v6m0-6h6m-6 0H6`
- **Bewerken**: `M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z`
- **Verwijderen**: `M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16`
- **Bekijken**: `M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z`
- **Terug**: `M10 19l-7-7m0 0l7-7m-7 7h18`
- **Annuleren**: `M6 18L18 6M6 6l12 12`

## Formulieren

### Invoervelden

Gebruik consistente styling voor alle invoervelden met iconen en labels.

```html
<div>
    <x-label for="field_name" value="{{ __('Field Label') }}" class="text-gray-700 font-medium" />
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <!-- Icon path here -->
            </svg>
        </div>
        <x-input id="field_name" name="field_name" type="text" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('field_name', $model->field_name ?? '') }}" />
    </div>
    <x-input-error for="field_name" class="mt-2" />
</div>
```

### Formulierlayout

Gebruik een grid-layout voor formulieren met meerdere velden.

```html
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Formuliervelden -->
</div>
```

## Lokalisatie

Movve CRM ondersteunt meerdere talen. Volg deze richtlijnen voor lokalisatie:

### Vertalingen

Gebruik altijd de `__()` helper voor alle zichtbare tekst.

```php
{{ __('Text to translate') }}
```

### Routes met Locale Parameter

Alle routes moeten de locale parameter bevatten.

```php
route('route.name', ['locale' => app()->getLocale(), 'parameter' => $value])
```

### Taalbestanden

Vertalingen worden opgeslagen in JSON-bestanden in de `lang` directory:

- `lang/en.json` - Engels
- `lang/nl.json` - Nederlands

Voeg nieuwe vertalingen toe aan beide bestanden.

## Projectstructuur

### Belangrijke Mappen

- `packages/movve/crm/` - CRM-functionaliteit
- `resources/views/` - Algemene views
- `lang/` - Taalbestanden
- `routes/` - Route definities
- `app/Http/Controllers/` - Controllers
- `app/Http/Middleware/` - Middleware, inclusief LocaleMiddleware

### Belangrijke Bestanden

- `routes/web.php` - Hoofdroutes
- `packages/movve/crm/routes/web.php` - CRM-routes
- `config/app.php` - Applicatie-instellingen, inclusief beschikbare talen

## Best Practices

### Lokalisatie

1. Gebruik altijd de `__()` helper voor alle zichtbare tekst
2. Voeg vertalingen toe aan alle taalbestanden
3. Zorg ervoor dat alle routes de locale parameter bevatten
4. Test de applicatie in alle ondersteunde talen

### UI/UX

1. Gebruik consistente styling voor vergelijkbare elementen
2. Zorg voor duidelijke visuele hiërarchie
3. Gebruik iconen om acties en informatie te verduidelijken
4. Zorg voor voldoende witruimte tussen elementen
5. Maak formulieren gebruiksvriendelijk met duidelijke labels en foutmeldingen

### Code

1. Gebruik Blade-componenten voor herbruikbare UI-elementen
2. Houd controllers dun en verplaats logica naar services
3. Gebruik resourceful controllers en routes waar mogelijk
4. Volg de Laravel-conventies voor naamgeving

---

Dit document is bedoeld als levende gids en kan worden bijgewerkt naarmate het project evolueert. Voor vragen of suggesties, neem contact op met het ontwikkelingsteam.
