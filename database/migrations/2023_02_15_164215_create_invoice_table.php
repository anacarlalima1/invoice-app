<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('invoice')){
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_client')->constrained('client');
            $table->foreignId('id_item')->constrained('item');
            $table->string('description');
            $table->enum('status', ['Paid', 'Pending', 'Draft'])->default('Draft');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
