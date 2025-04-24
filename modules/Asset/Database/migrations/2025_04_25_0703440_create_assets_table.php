<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Asset\Enums\AssetStatus;
use Modules\Currency\Enums\Currency;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("assets", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained();
            $table->string("title", 255);
            $table->text("description")->nullable();
            $table
                ->enum("currency", Currency::values())
                ->default(Currency::USD);
            $table->decimal("initial_value", 15, 2);
            $table->decimal("current_value", 15, 2)->default(0.0);
            $table->decimal("target_funding", 15, 2);
            $table->decimal("current_funding", 15, 2)->default(0.0);
            $table
                ->enum("status", AssetStatus::values())
                ->default(AssetStatus::PROPOSED);
            $table->integer("vote_count")->default(0);
            $table->timestamp("funding_deadline")->nullable();
            $table->timestamp("maturity_date")->nullable();
            $table->decimal("risk_index", 3, 1)->default(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("assets");
    }
};
