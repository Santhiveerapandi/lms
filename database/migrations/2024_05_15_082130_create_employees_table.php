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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('Name', 200)->nullable();
            $table->string('Country',200)->nullable();
            $table->string('Department', 200)->nullable();
            $table->string('Selected',40)->nullable();
            $table->string('Grade',2)->comment("C,H,L,M");
            $table->string('InterviewDate')->nullable();
            $table->string('EmployeeID')->nullable();
            $table->string('JoinDate')->nullable();
            $table->integer('Level')->unsigned();
            $table->double('PerHourRate')->default(0.0);
            $table->double('PerDayRate')->default(0.0);	
            $table->double('AnnualCTC')->default(0.0);
            $table->double('Expenses')->default(0.0);
            $table->double('TakeHomeSalary')->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
