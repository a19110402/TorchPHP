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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->string('role')->default('cliente');
            $table->string('createdBy')->nullable();

            // if(auth()->user() != null && auth()->user()->role =='admin'){
            //     // $table->string('createdBy')->user()->name;
            //     $table->where('createdBy', auth()->user()->name)->get();
            // }else{
            //     // $table->where('createdBy', auth()->id())->get();
            //     $table->string('createdBy')->nullable();
            // }
            
            // $table->timestamp('email_verified_at')->nullable();
            // $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
