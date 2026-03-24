<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('type')->default('person')->after('name');
            $table->string('company_name')->nullable()->after('type');
            $table->text('bio')->nullable()->after('company_name');
            $table->string('linkedin')->nullable()->after('bio');
            $table->string('portfolio')->nullable()->after('linkedin');
            $table->string('avatar')->nullable()->after('portfolio');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['type','company_name','bio','linkedin','portfolio','avatar']);
        });
    }
};
