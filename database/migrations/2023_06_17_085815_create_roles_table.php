<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('roleUID');
            $table->string('roleName');
            $table->boolean('isActive')->default(true);
            $table->string('createdBy');
            $table->string('modifiedBy')->nullable();
            $table->timestamp('createdDate')->default(now());
            $table->timestamp('modifiedDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
