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
        Schema::table('routes', function (Blueprint $table) {
            //
            $table->boolean('is_assigned')->nullable();
            $table->bigInteger('assigned_to')->unsigned()->nullable();
            $table->index('assigned_to', 'driver_route_index');
            $table->foreign('assigned_to', 'driver_route_foreign')->references('id')
                ->on('drivers')->onDelete('Cascade')->onUpdate('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            //
        });
    }
};
