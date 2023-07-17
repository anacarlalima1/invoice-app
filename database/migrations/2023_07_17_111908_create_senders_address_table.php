<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendersAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        {
            if (!Schema::hasTable('senders_address')) {
                Schema::create('senders_address', function (Blueprint $table) {
                    $table->id();
                    $table->string('street');
                    $table->string('city');
                    $table->string('country');
                    $table->string('cep');
                    $table->timestamps();
                    $table->softDeletes();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('senders_address');
    }
}
