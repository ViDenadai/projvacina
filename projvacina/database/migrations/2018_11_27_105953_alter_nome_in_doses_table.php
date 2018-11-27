<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNomeInDosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doses', function (Blueprint $table) {
            $table->dropColumn('nome');
            $table->integer('vaccine_id')->unsigned()->after('id')->default(1);
            $table->foreign('vaccine_id')->references('id')->on('vaccines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doses', function (Blueprint $table) {
            $table->dropForeign(['vaccine_id']);
            $table->string('nome');
        });
    }
}
