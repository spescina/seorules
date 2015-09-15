<?php

use Illuminate\Database\Migrations\Migration;

class CreateSeorulesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(config('seorules.table'), function($table) {
            $table->increments('id');
            $table->string('alias', 250);
            $table->string('pattern', 250);
            $table->string('route', 250);
            $table->string('title', 250);
            $table->text('description');
            $table->text('keywords');
            $table->boolean('noindex');
            $table->integer('priority');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop(config('seorules.table'));
    }

}
