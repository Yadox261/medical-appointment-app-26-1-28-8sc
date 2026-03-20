<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('un usuario no puede eliminarse a sí mismo', function () {

    // Crear un usuario en la base de datos
    $user = User::factory()->create(
        [
            'email_validated_at' => now(),
        ]
    );

    // SIMULAR UN USUARIO LOGUEADO
    $this->actingAs($user, 'web');

    // Intentar eliminar el usuario logueado
    $response = $this->delete(route('admin.users.destroy', $user));

    // esperar que el servidor bloquee la solicitud
    $response->assertStatus(403);

    // Verificar que el usuario sigue existiendo en la base de datos
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});