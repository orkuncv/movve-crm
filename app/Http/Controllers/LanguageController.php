<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang(Request $request, string $locale)
    {
        // Validate locale
        if (!array_key_exists($locale, config('app.available_locales'))) {
            return redirect()->back();
        }

        // Store the locale in the session
        Session::put('locale', $locale);

        // Get the referrer URL
        $previousUrl = url()->previous();
        $segments = explode('/', parse_url($previousUrl, PHP_URL_PATH));
        
        // Remove empty segments
        $segments = array_values(array_filter($segments));
        
        // If we have segments
        if (count($segments) > 0) {
            // Check if first segment is a locale
            $currentLocale = $segments[0];
            if (array_key_exists($currentLocale, config('app.available_locales'))) {
                // Replace current locale with new locale
                $segments[0] = $locale;
            } else {
                // Add new locale at the beginning
                array_unshift($segments, $locale);
            }
            
            // Reconstruct URL with new locale
            return redirect('/' . implode('/', $segments));
        }
        
        // If no segments, redirect to root with new locale
        return redirect('/' . $locale);
    }
}
