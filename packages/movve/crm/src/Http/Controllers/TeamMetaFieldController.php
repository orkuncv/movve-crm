<?php

namespace Movve\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Movve\Crm\Models\TeamMetaField;

class TeamMetaFieldController extends Controller
{
    /**
     * Display a listing of the meta fields for the current team.
     */
    public function index(Request $request)
    {
        $metaFields = TeamMetaField::where('team_id', $request->user()->currentTeam->id)
            ->orderBy('name')
            ->get();
            
        return view('crm::team-meta-fields.index', [
            'metaFields' => $metaFields,
        ]);
    }
    
    /**
     * Show the form for creating a new meta field.
     */
    public function create()
    {
        return view('crm::team-meta-fields.create');
    }
    
    /**
     * Store a newly created meta field in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => ['required', 'integer', 'exists:teams,id'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:count,field'],
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Controleer of de gebruiker toegang heeft tot dit team
        $team = \App\Models\Team::find($request->team_id);
        if (!$team || !$request->user()->belongsToTeam($team)) {
            return redirect()->back()
                ->with('error', 'Je hebt geen toegang tot dit team.');
        }
        
        // Genereer een key op basis van de naam
        $key = strtolower(str_replace(' ', '_', $request->name));
        $key = preg_replace('/[^a-z0-9_]/', '', $key);
        
        // Controleer of de key al bestaat voor dit team
        $exists = TeamMetaField::where('team_id', $request->team_id)
            ->where('key', $key)
            ->exists();
            
        if ($exists) {
            return redirect()->back()
                ->with('error', 'Er bestaat al een veld met deze naam voor dit team.')
                ->withInput();
        }
        
        TeamMetaField::create([
            'team_id' => $request->team_id,
            'name' => $request->name,
            'key' => $key,
            'type' => $request->type,
            'description' => '',
            'is_active' => true,
        ]);
        
        return redirect()->back()
            ->with('success', 'Meta veld succesvol aangemaakt.');
    }
    
    /**
     * Show the form for editing the specified meta field.
     */
    public function edit($id)
    {
        $metaField = TeamMetaField::findOrFail($id);
        
        // Controleer of het meta veld bij het huidige team hoort
        if ($metaField->team_id !== auth()->user()->currentTeam->id) {
            abort(403);
        }
        
        return view('crm::team-meta-fields.edit', [
            'metaField' => $metaField,
        ]);
    }
    
    /**
     * Update the specified meta field in storage.
     */
    public function update(Request $request, $id)
    {
        $metaField = TeamMetaField::findOrFail($id);
        
        // Controleer of het meta veld bij het huidige team hoort
        if ($metaField->team_id !== auth()->user()->currentTeam->id) {
            abort(403);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $metaField->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);
        
        return redirect()->route('crm.team-meta-fields.index', ['locale' => app()->getLocale()])
            ->with('success', 'Meta veld succesvol bijgewerkt.');
    }
    
    /**
     * Remove the specified meta field from storage.
     */
    public function destroy($id)
    {
        $metaField = TeamMetaField::findOrFail($id);
        $teamId = $metaField->team_id;
        
        // Controleer of de gebruiker toegang heeft tot dit team
        $team = \App\Models\Team::find($teamId);
        if (!$team || !auth()->user()->belongsToTeam($team)) {
            abort(403, 'Je hebt geen toegang tot dit team.');
        }
        
        $metaField->delete();
        
        // Stuur terug naar de teams pagina
        return redirect('/teams/' . $teamId . '?locale=' . app()->getLocale())
            ->with('success', 'Meta veld succesvol verwijderd.');
    }
    
    /**
     * Toon de meta velden voor een specifiek team.
     * 
     * @param Request $request
     * @param int $id Team ID
     * @return \Illuminate\View\View
     */
    public function forTeam(Request $request, $id)
    {
        // Zorg ervoor dat we een integer ID hebben om route model binding problemen te voorkomen
        $teamId = (int) $id;
        
        // Haal het team op uit de database
        $teamModel = \App\Models\Team::find($teamId);
        
        if (!$teamModel) {
            abort(404, 'Team niet gevonden.');
        }
        
        // Controleer of de gebruiker toegang heeft tot dit team
        if (!$request->user()->belongsToTeam($teamModel)) {
            // Als de gebruiker geen toegang heeft, gebruik het huidige team
            $teamModel = $request->user()->currentTeam;
        }
        
        // Haal de meta velden op voor dit team
        $metaFields = TeamMetaField::where('team_id', $teamModel->id)
            ->orderBy('name')
            ->get();
            
        return view('crm::team-meta-fields.team', [
            'team' => $teamModel,
            'metaFields' => $metaFields,
        ]);
    }
}
