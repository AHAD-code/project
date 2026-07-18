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
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();
            // Connects to the intern who submitted it
            $table->foreignId('intern_id')->constrained('interns')->cascadeOnDelete();

            // Connects to the supervisor reviewing it
            $table->unsignedBigInteger('supervisor_id')->nullable();

            $table->string('title');
            $table->text('content');

            // Allows the student to upload a document/file for the report
            $table->string('file_path')->nullable();

            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('supervisor_comments')->nullable();
            $table->timestamps();

            // Optional: Explicitly define the foreign key for the supervisor table if it exists
            // $table->foreign('supervisor_id')->references('id')->on('supervisors')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
