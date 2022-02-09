<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transitions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('from_user_id')->index()->constrained('users')->onDelete('cascade');
            $table->foreignId('to_user_id')->index()->constrained('users')->onDelete('cascade');
            $table->string('from_currency', 3)->default("USD");
            $table->string('to_currency', 3)->default("USD");
            $table->decimal('amount', 22)->default(0);
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
        Schema::dropIfExists('transitions');
    }
}
