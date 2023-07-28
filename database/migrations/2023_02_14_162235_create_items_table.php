<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('items')){
            Schema::create('items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_invoice')->constrained('invoices')->onDelete('cascade');
                $table->string('name');
                $table->integer('qty');
                $table->decimal('price');
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('items');
    }
}
