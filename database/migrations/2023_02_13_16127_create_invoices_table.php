<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('invoices')){
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_client')->constrained('clients');
                $table->string('description');
                $table->enum('payment_terms', ['1', '7', '14', '30'])->default('1');
                $table->enum('status', ['Paid', 'Pending', 'Draft'])->default('Pending');
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
        Schema::dropIfExists('invoices');
    }
}
