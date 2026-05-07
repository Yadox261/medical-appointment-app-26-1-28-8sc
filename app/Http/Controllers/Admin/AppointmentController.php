<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointments.index');
    }

    public function create()
    {
        return view('admin.appointments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'required|exists:doctors,id',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'reason'     => 'nullable|string|max:1000',
        ]);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id'  => $request->doctor_id,
            'date'       => $request->date,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'duration'   => $request->duration ?? 15,
            'reason'     => $request->reason,
            'status'     => 1,
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('swal', [
                'title' => '¡Cita registrada!',
                'text'  => 'La cita médica fue registrada correctamente.',
                'icon'  => 'success',
            ]);
    }

    public function show(Appointment $appointment)
    {
        return redirect()->route('admin.appointments.consultation', $appointment);
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::with('user')->get()->sortBy('user.name');
        $doctors  = Doctor::with('user')->get()->sortBy('user.name');

        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'required|exists:doctors,id',
            'date'       => 'required|date',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'reason'     => 'nullable|string|max:1000',
            'status'     => 'required|integer|in:1,2,3',
        ]);

        $appointment->update($request->only([
            'patient_id', 'doctor_id', 'date',
            'start_time', 'end_time', 'reason', 'status',
        ]));

        return redirect()->route('admin.appointments.index')
            ->with('swal', [
                'title' => '¡Cita actualizada!',
                'text'  => 'La cita médica fue actualizada correctamente.',
                'icon'  => 'success',
            ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('swal', [
                'title' => 'Cita eliminada',
                'text'  => 'La cita médica fue eliminada correctamente.',
                'icon'  => 'success',
            ]);
    }

    /**
     * Muestra el componente de atención de la consulta médica.
     */
    public function consultation(Appointment $appointment)
    {
        $appointment->load([
            'patient.user',
            'patient.bloodtype',
            'doctor.user',
            'consultation.prescriptions',
        ]);

        return view('admin.appointments.consultation', compact('appointment'));
    }
}
