<?php

use App\Models\Order;
use App\Models\Product;
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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)
                ->constrained()
                ->onDelete('cascade');
            $table->foreignIdFor(Product::class)->constrained();
            $table->integer('qty')->default(0);
            $table->float('purchase_cost')->default(0);
            $table->float('total_purchase_cost', 15, 2)->nullable();
            $table->float('sell_price', 15, 2);
            $table->float('total_sell_price', 15, 2);
            $table->timestamp('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
