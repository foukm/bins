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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('lat');
            $table->string('lon');
            $table->string('category')->nullable();
            $table->text('info')->nullable();
            $table->boolean('isCompleted')->default(false);
            $table->string('bonus')->nullable();
            $table->boolean('is_assigned')->nullable();
            $table->bigInteger('assigned_to')->unsigned()->nullable();
            $table->index('assigned_to', 'request_route_index');
            $table->foreign('assigned_to', 'request_route_foreign')->references('id')
                ->on('routes')->onDelete('Cascade')->onUpdate('Cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
