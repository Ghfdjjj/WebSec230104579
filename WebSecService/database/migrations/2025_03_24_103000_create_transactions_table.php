<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->decimal('amount', 10, 2);
            $table->string('type'); // credit_add, purchase
            $table->string('status')->default('completed');
            $table->foreignId('purchase_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('processed_by')->nullable()->constrained('users');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
