<?php

use App\Models\BankAccount;
use App\Models\Owner;
use App\Models\PurchasePayment;
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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BankAccount::class);
            $table->unsignedBigInteger('historyable_id')->nullable();
            $table->string('historyable_type')->nullable();
            $table->float('amount', 15, 2);
            $table->string('type')->comment('+ or -');
            $table->text('note')->nullable();
            $table->timestamp('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
