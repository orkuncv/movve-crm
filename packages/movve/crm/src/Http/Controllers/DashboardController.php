<?php

namespace Movve\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Movve\Crm\Models\Contact;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end = (clone $start)->endOfMonth();

        // Dummy data, vervang dit met je eigen queries
        $newUsers = Contact::whereBetween('created_at', [$start, $end])->count();
        $bookings = '0'; // Booking::whereBetween('created_at', [$start, $end])->count();
        $earned = '0'; // Booking::whereBetween('created_at', [$start, $end])->sum('price');

        return view('crm::dashboard', [
            'newUsers' => $newUsers,
            'bookings' => $bookings,
            'earned' => $earned,
        ]);
    }
}
