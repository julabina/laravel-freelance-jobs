<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mission_messagings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mission_id')->index('mission_id');
            $table->unsignedBigInteger('mission_user_id')->index('mission_user_id');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_messagings');
    }
};
