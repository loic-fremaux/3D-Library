<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_pivot', function (Blueprint $table) {
            $table->foreignId('tag_id')
                ->constrained('tags')
                ->cascadeOnDelete();

            $table->foreignId('model_id')
                ->constrained('models')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->primary(['tag_id', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_pivot');
    }
}
