<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('client_id');
            $table->string('offer_number');
            $table->date('offer_date');
            $table->date('delivery_date');
            $table->time('offer_time');
            $table->date('payment_deadline');
            $table->integer('remark_id');
            $table->string('payment_type');
            $table->string('city');
            $table->boolean('is_paid')->default(0);
            $table->date('paid')->nullable()->default(null);
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
        Schema::dropIfExists('offers');
    }
}
