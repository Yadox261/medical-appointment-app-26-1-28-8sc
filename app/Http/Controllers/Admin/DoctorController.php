<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return view('admin.doctors.index');
    }

    public function create()
    {
        // Usuarios que aún no tienen doctor asignado
        $users = User::whereDoesntHave('doctor')->orderBy('name')->get();
        return view('admin.doctors.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'           => 'required|exists:users,id|unique:doctors,user_id',
            'specialty'         => 'required|string|max:255',
            'cedula_profesional'=> 'nullable|string|max:255',
        ]);

        Doctor::create($request->only(['user_id', 'specialty', 'cedula_profesional']));

        return redirect()->route('admin.doctors.index')
            ->with('swal', [
                'title' => '¡Doctor registrado!',
                'text'  => 'El doctor fue registrado correctamente.',
                'icon'  => 'success',
            ]);
    }

    public function show(Doctor $doctor)
    {
        return redirect()->route('admin.doctors.edit', $doctor);
    }

    public function edit(Doctor $doctor)
    {
        // Usuarios disponibles: el actual del doctor + los que no tienen doctor
        $users = User::where('id', $doctor->user_id)
            ->orWhereDoesntHave('doctor')
            ->orderBy('name')
            ->get();

        return view('admin.doctors.edit', compact('doctor', 'users'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'user_id'           => 'required|exists:users,id|unique:doctors,user_id,' . $doctor->id,
            'specialty'         => 'required|string|max:255',
            'cedula_profesional'=> 'nullable|string|max:255',
        ]);

        $doctor->update($request->only(['user_id', 'specialty', 'cedula_profesional']));

        return redirect()->route('admin.doctors.edit', $doctor)
            ->with('swal', [
                'title' => '¡Doctor actualizado!',
                'text'  => 'Los datos del doctor fueron actualizados correctamente.',
                'icon'  => 'success',
            ]);
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('admin.doctors.index')
            ->with('swal', [
                'title' => 'Doctor eliminado',
                'text'  => 'El doctor fue eliminado correctamente.',
                'icon'  => 'success',
            ]);
    }

    /**
     * Muestra la vista de gestión de horarios del doctor.
     */
    public function schedule(Doctor $doctor)
    {
        return view('admin.doctors.schedule', compact('doctor'));
    }
}
