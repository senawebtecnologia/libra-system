<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'central';

    public function up(): void
    {
        Schema::connection('central')->create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->unique();
            $table->string('plan')->default('basic');
            $table->enum('database_mode', ['shared', 'exclusive'])->default('shared');

            // Preenchidos só quando database_mode = exclusive
            $table->string('db_host')->nullable();
            $table->string('db_database')->nullable();
            $table->string('db_username')->nullable();
            $table->text('db_password')->nullable();

            $table->string('status')->default('active'); // active, suspended, maintenance
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('central')->dropIfExists('tenants');
    }
};