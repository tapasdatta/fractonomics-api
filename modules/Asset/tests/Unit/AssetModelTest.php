<?php

use Modules\Asset\Models\Asset;
use Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it("can create an asset via factory", function () {
    $asset = Asset::factory()->create();

    expect($asset)
        ->toBeInstanceOf(\Modules\Asset\Models\Asset::class)
        ->and($asset->id)
        ->toBeInt()
        ->and($asset->user_id)
        ->toBeInt()
        ->and($asset->title)
        ->toBeString()
        ->and($asset->initial_value)
        ->toBeFloat()
        ->and($asset->current_value)
        ->toBeFloat()
        ->and($asset->target_funding)
        ->toBeFloat()
        ->and($asset->current_funding)
        ->toBeFloat()
        ->and($asset->vote_count)
        ->toBeInt()
        ->and($asset->risk_index)
        ->toBeFloat();
});

it("sets default values correctly", function () {
    $asset = Asset::create([
        "current_value" => null,
        "current_funding" => null,
        "vote_count" => null,
        "status" => null,
        "risk_index" => null,
    ]);

    $asset->refresh();

    expect($asset->current_value)
        ->toEqual(0.0)
        ->and($asset->current_funding)
        ->toEqual(0.0)
        ->and($asset->vote_count)
        ->toEqual(0)
        ->and($asset->status)
        ->and($asset->risk_index)
        ->toEqual(5.0);
});

it("belongs to a user", function () {
    $user = User::factory()->create();
    $asset = Asset::factory()->create([
        "user_id" => $user->id,
    ]);

    expect($asset->user)
        ->toBeInstanceOf(User::class)
        ->and($asset->user->id)
        ->toEqual($user->id);
});

it("can have proposed state", function () {
    $asset = Asset::factory()->proposed()->create();
});

it("can have active state", function () {
    $asset = Asset::factory()->active()->create();
});

it("can have funding state", function () {
    $asset = Asset::factory()->funding()->create();
});

it("can have matured state", function () {
    $asset = Asset::factory()->matured()->create();
});

it("can have voting state", function () {
    $asset = Asset::factory()->voting()->create();
});

it("validates currency values", function () {
    $asset = Asset::factory()->create();
});

it("validates status values", function () {
    $asset = Asset::factory()->create();
});

it("has correct date formats", function () {
    $asset = Asset::factory()->create();

    expect($asset->funding_deadline)
        ->toBeInstanceOf(\Illuminate\Support\Carbon::class)
        ->and($asset->maturity_date)
        ->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});
