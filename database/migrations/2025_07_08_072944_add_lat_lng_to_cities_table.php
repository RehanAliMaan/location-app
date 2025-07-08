<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('cities', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
  public function down()
{
    Schema::table('cities', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->dropColumn(['latitude', 'longitude']);
    });
}
};
