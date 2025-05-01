<?php

namespace Movve\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Movve\Crm\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Lijst van bookings, eventueel filteren per team/user
        $bookings = Booking::latest()->paginate(20);
        return view('crm::bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('crm::bookings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'staff_member_id' => 'required|exists:staff_members,id',
            'service_id' => 'nullable|exists:services,id',
            'contact_id' => 'nullable|exists:crm_contacts,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'comment' => 'nullable|string',
        ]);
        $booking = Booking::create($validated);
        return redirect()->route('crm.bookings.index')->with('success', __('crm::booking.created'));
    }

    public function show(Booking $booking)
    {
        return view('crm::bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('crm::bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'staff_member_id' => 'required|exists:staff_members,id',
            'service_id' => 'nullable|exists:services,id',
            'contact_id' => 'nullable|exists:crm_contacts,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'comment' => 'nullable|string',
        ]);
        $booking->update($validated);
        return redirect()->route('crm.bookings.index')->with('success', __('crm::booking.updated'));
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('crm.bookings.index')->with('success', __('crm::booking.deleted'));
    }
}
