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
        Schema::create('interns', function (Blueprint $table) {
            $table->id();

            // Link to the supervisor
            $table->foreignId('supervisor_id')->nullable()->constrained('supervisors')->nullOnDelete();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('registration_number')->nullable();
            $table->string('department')->nullable();
            $table->string('university')->nullable();

            // Kept just in case your old views still reference it
            $table->string('task')->nullable();

            $table->string('status')->default('Active');
            $table->integer('progress')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
