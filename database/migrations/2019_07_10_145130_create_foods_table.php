<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedSmallInteger('serving_size')->nullable();
            $table->decimal('calories', 5,1);
            $table->decimal('carbohydrates', 5,1)->nullable();
            $table->decimal('sugar', 5,1)->nullable();
            $table->decimal('fibre', 5,1)->nullable();
            $table->decimal('fat', 5,1)->nullable();
            $table->decimal('saturated_fat', 5,1)->nullable();
            $table->decimal('protein', 5,1)->nullable();
            $table->decimal('sodium', 5,1)->nullable();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();

            $table->unique(['name', 'serving_size', 'calories', 'carbohydrates', 'sugar', 'fibre', 'fat',
                'saturated_fat', 'protein', 'sodium']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foods');
    }
}
