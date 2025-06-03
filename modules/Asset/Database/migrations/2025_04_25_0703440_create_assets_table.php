<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("assets", function (Blueprint $table) {
            $table->uuid("uuid")->primary();
            $table->foreignUuid("user_uuid")->constrained("users", "uuid");
            $table->string("title", 255);
            $table->text("description")->nullable();
            $table->string("currency")->default("USD");
            $table->decimal("initial_value", 15, 2);
            $table->decimal("current_value", 15, 2)->default(0.0);
            $table->decimal("target_funding", 15, 2);
            $table->decimal("current_funding", 15, 2)->default(0.0);
            $table->string("state");
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
