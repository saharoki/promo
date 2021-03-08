<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvertedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('converted')) {
            Schema::create('converted', function (Blueprint $table) {
                $table->increments('id');;
                $table->string('url', 510);
                $table->string('path', 255);
                $table->string('uniq_id', 255);
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
        if (Schema::hasTable('converted')) {
            Schema::dropIfExists('converted');
        }
    }
}
