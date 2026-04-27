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
       Schema::table('patients', function (Blueprint $table) {
        $table->dropColumn([
            'allergies', 'chronic_diseases', 'family_history', 'surgical_history',
            'bloodtype_id', 'weight', 'height', 'observations',
            'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship',
        ]);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            //
        });
    }
};
