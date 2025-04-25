<?php

use Modules\User\Models\User;

test("that true is true", function () {
    $user = User::factory()->create();

    $this->assertTrue($user->exists);
});
