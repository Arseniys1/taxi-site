<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id');
            $table->bigInteger('driver_id')->nullable();
            $table->boolean('delivery')->default(false);
            $table->boolean('children')->default(false);
            $table->text('comment')->nullable();
            $table->string('status', 100)->default('created');
            // created - заказ создан, поиск водителя.
            // driver_in_way - водитель в пути.
            // in_way - в пути.
            // closed - выполнен.
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
        Schema::dropIfExists('orders');
    }
}
