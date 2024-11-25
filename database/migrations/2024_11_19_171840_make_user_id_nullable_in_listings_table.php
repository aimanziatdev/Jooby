<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUserIdNullableInListingsTable extends Migration
{
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
}
