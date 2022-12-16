<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->text('name');
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->unsignedBigInteger('phone')->nullable();
            $table->text('position')->nullable();
            $table->unsignedBigInteger('responsible_user_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('createdBy')->nullable();
            $table->unsignedBigInteger('updatedBy')->nullable();
            $table->unsignedBigInteger('createdAt')->nullable();
            $table->unsignedBigInteger('updatedAt')->nullable();
            $table->boolean('is_deleted')->nullable();
            $table->unsignedBigInteger('closest_task_at')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
