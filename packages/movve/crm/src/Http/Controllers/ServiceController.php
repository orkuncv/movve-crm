<?php

namespace Movve\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Movve\Crm\Models\Service;
use Movve\Crm\Models\ServiceCategory;
use Movve\Crm\Models\StaffMember;

class ServiceController extends Controller
{
    public function create()
    {
        $team = Auth::user()->currentTeam;
        $categories = ServiceCategory::where('team_id', $team->id)->get();
        if ($categories->count() === 0) {
            $default = ServiceCategory::create([
                'team_id' => $team->id,
                'name' => 'Algemeen',
            ]);
            $categories = collect([$default]);
        }
        $staffMembers = $team->staffMembers;
        return view('crm::services.create', compact('categories', 'staffMembers'));
    }

    public function index()
    {
        $team = Auth::user()->currentTeam;
        $services = Service::with(['category', 'staffMembers'])->where('team_id', $team->id)->orderBy('name')->get();
        return view('crm::services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $team = Auth::user()->currentTeam;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'info' => 'nullable|string|max:1000',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer|min:1',
            'category_id' => 'nullable|exists:service_categories,id',
            'staff_member_ids' => 'nullable|array',
            'staff_member_ids.*' => 'exists:staff_members,id',
        ]);
        $service = Service::create([
            'team_id' => $team->id,
            'category_id' => $validated['category_id'] ?? null,
            'name' => $validated['name'],
            'info' => $validated['info'] ?? null,
            'price' => $validated['price'] ?? null,
            'duration' => $validated['duration'] ?? null,
        ]);
        if (isset($validated['staff_member_ids'])) {
            $service->staffMembers()->sync($validated['staff_member_ids']);
        }
        return redirect()->route('crm.services.index')->with('success', __('Service succesvol toegevoegd.'));
    }

    public function edit($id)
    {
        $id = request()->segment(4);
        $team = Auth::user()->currentTeam;
        $service = Service::where('team_id', $team->id)->findOrFail($id);
        $categories = ServiceCategory::where('team_id', $team->id)->get();
        $staffMembers = $team->staffMembers;
        $selectedStaff = $service->staffMembers->pluck('id')->toArray();
        return view('crm::services.edit', compact('service', 'categories', 'staffMembers', 'selectedStaff'));
    }

    public function update(Request $request, $id)
    {
        $id = request()->segment(4);
        $team = Auth::user()->currentTeam;
        $service = Service::where('team_id', $team->id)->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'info' => 'nullable|string|max:1000',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer|min:1',
            'category_id' => 'nullable|exists:service_categories,id',
            'staff_member_ids' => 'nullable|array',
            'staff_member_ids.*' => 'exists:staff_members,id',
        ]);
        $service->update([
            'category_id' => $validated['category_id'] ?? null,
            'name' => $validated['name'],
            'info' => $validated['info'] ?? null,
            'price' => $validated['price'] ?? null,
            'duration' => $validated['duration'] ?? null,
        ]);
        if (isset($validated['staff_member_ids'])) {
            $service->staffMembers()->sync($validated['staff_member_ids']);
        } else {
            $service->staffMembers()->detach();
        }
        return redirect()->route('crm.services.index')->with('success', __('Service succesvol bijgewerkt.'));
    }

    public function show($id)
    {
        dump($id);
        $team = Auth::user()->currentTeam;
        if (!$team) {
            abort(500, 'Geen currentTeam gevonden voor de ingelogde gebruiker.');
        }
        // DEBUG: Haal het id direct uit de URL als tijdelijke workaround
        $id = request()->segment(4);
        $serviceCheck = \Movve\Crm\Models\Service::find($id);
        if (!$serviceCheck) {
            abort(500, 'Service met ID ' . $id . ' bestaat niet in de database.');
        }
        \Log::info('Gevonden service:', $serviceCheck ? $serviceCheck->toArray() : []);
        \Log::info('Current team:', $team ? $team->toArray() : []);
        try {
            $service = Service::where('team_id', $team->id)->findOrFail($id);
        } catch (\Exception $e) {
            abort(500, 'Service niet gevonden of DB error: ' . $e->getMessage());
        }
        try {
            return view('crm::services.show', compact('service'));
        } catch (\Throwable $e) {
            abort(500, 'View error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $id = request()->segment(4);
        $team = Auth::user()->currentTeam;
        $service = Service::where('team_id', $team->id)->findOrFail($id);
        $service->staffMembers()->detach();
        $service->delete();
        return redirect()->route('crm.services.index')->with('success', __('Service verwijderd.'));
    }

    // Temporary test method to verify controller registration
    public function ping()
    {
        return response('ServiceController OK', 200);
    }
}
