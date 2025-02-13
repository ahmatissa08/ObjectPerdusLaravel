<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            // Optionnel : enregistrement de l'utilisateur qui a ajouté l'objet
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->text('description');
            // Type d'objet : "lost" pour perdu, "found" pour retrouvé
            $table->enum('type', ['lost', 'found']);
            $table->string('location')->nullable();
            $table->timestamps();
            $table->string('image')->nullable()->after('location');
            $table->date('found_date')->nullable()->after('image');
            $table->string('category')->nullable();
            // Définition de la clé étrangère (optionnel)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
