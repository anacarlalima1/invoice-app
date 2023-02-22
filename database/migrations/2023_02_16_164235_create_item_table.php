<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
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
                $table->string('name');
                $table->integer('qty');
                $table->decimal('price');
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if (!Schema::hasTable('invoices')){
            Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_client')->constrained('clients');
            $table->foreignId('id_item')->constrained('items');
            $table->string('description');
            $table->enum('status', ['Paid', 'Pending', 'Draft'])->default('Draft');
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
        Schema::dropIfExists('invoices');
    }
}
