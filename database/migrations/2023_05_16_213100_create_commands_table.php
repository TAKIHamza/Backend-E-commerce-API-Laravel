<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandsTable extends Migration
{
    public function up()
    {
        Schema::create('commands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->boolean('is_validate')->default(false);
            $table->date('date_commande')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone');
            $table->boolean('received')->default(false);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('commands');
    }
}
