<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bloodtype;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.patients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('admin.patients.index', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $blood_types = Bloodtype::all();

        return view('admin.patients.edit', compact('patient', 'blood_types'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
      $request->validate([
        'allergies'                      => 'nullable|string',
        'chronic_diseases'               => 'nullable|string',
        'family_history'                 => 'nullable|string',
        'surgical_history'               => 'nullable|string',
        'bloodtype_id'                   => 'nullable|exists:bloodtypes,id',
        'weight'                         => 'nullable|numeric',
        'height'                         => 'nullable|numeric',
        'observations'                   => 'nullable|string',
        'emergency_contact_name'         => 'required|string|max:255',
        'emergency_contact_phone'        => 'required|string|max:20',
        'emergency_contact_relationship' => 'required|string|max:255',
    ]);

    $patient->update($request->only([
        'allergies', 'chronic_diseases', 'family_history', 'surgical_history',
        'bloodtype_id', 'weight', 'height', 'observations',
        'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship',
    ]));

    return redirect()->route('admin.patients.edit', $patient)
        ->with('success', 'Paciente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
