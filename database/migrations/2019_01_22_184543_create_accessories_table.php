<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('workplace_id')->nullable();
            $table->string('model');
            $table->string('mark')->unique();
            $table->year('purchase_year');
            $table->decimal('value', 6, 2);
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('type_id')
                ->references('id')->on('types');
            $table->foreign('workplace_id')
                ->references('id')->on('workplaces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accessories');
    }
}
