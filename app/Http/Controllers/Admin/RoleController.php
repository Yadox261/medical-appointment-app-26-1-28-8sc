<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar que se cree bien
    $request->validate([
        'name' => 'required|unique:roles,name'
    ]);

    // crear el rol si pasa la validacion
    Role::create([
        'name' => $request->name
    ]);

    // confirmacion de operacion exitosa
    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Rol creado correctamente',
        'text' => 'El rol se creo correctamente'
    ]);

    // redireccionar al index
    return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
// validar que se edite bien y que excluya la fila que esta editando
    $request->validate([
        'name' => 'required|unique:roles,name,'. $role->id
    ]);

    // si pasa la validacion
    $role->update([
        'name' => $request->name
    ]);

    // confirmacion de operacion exitosa
    session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Rol actualizado correctamente',
        'text' => 'El rol se actualizo correctamente'
    ]);

    // redireccionar al index
    return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //borrar el elemento
        $role->delete();

        // confirmacion de operacion exitosa
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol eliminado correctamente',
            'text' => 'El rol se elimino correctamente'
        ]);

        // redireccionar al index
        return redirect()->route('admin.roles.index');
    }
}
