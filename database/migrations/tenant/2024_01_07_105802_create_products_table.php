<?php

use App\Models\Brand;
use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(Brand::class)->nullable();
            $table->foreignId('main_unit');
            $table->foreignId('sub_unit')->nullable();
            $table->float('stock', 20, 2)->nullable();
            $table->float('sale_price',20,2);
            $table->float('purchase_cost',20,2);
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
