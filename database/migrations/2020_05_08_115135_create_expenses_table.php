<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id');
            $table->integer('associate_id')->nullable();
            $table->text('description');
            $table->integer('unit_id');
            $table->float('amount');
            $table->float('price');
            $table->integer('discount')->nullable();
            $table->string('currency')->default('HRK');
            $table->string('hnb_middle_exchange')->nullable();
            $table->date('expense_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('associates');
        Schema::dropIfExists('projects');
    }
}
