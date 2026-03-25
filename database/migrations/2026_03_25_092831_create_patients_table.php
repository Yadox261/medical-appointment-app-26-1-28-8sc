<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('bloodtype_id')
                ->nullable()
                ->constrained('bloodtypes')
                ->onDelete('set null');

            $table->string('allergies')
                ->nullable()
                ->comment('Alergias del paciente');

            $table->string('medical_history')
                ->nullable()
                ->comment('Antecedentes medicos del paciente');

            $table->string('chronical_conditions')
                ->nullable()
                ->comment('Enfermedades cronicas del paciente');

            $table->string('surgical_history')
                ->nullable()
                ->comment('Cirugias previas del paciente');

            $table->string('family_history')
                ->nullable()
                ->comment('Antecedentes familiares del paciente');

            $table->string('observations')
                ->nullable()
                ->comment('Observaciones del paciente');

            $table->string('emergency_contact_name')
                ->nullable()
                ->comment('Nombre del contacto de emergencia del paciente');

            $table->string('emergency_contact_phone')
                ->nullable()
                ->comment('Telefono del contacto de emergencia del paciente');

            $table->string('emergency_contact_relationship')
                ->nullable()
                ->comment('Relación del contacto de emergencia con el paciente');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
