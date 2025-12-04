<?php

use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use App\Models\Role;
use function Pest\Livewire\livewire;


beforeEach(function () {
    $roles = Role::factory(4)->create();
    $user = User::factory()->create();
    $user->roles()->attach($roles->where('slug', 'admin'));
    $this->actingAs($user);
});

describe("User Test", function () {
    it('can load the page', function () {
        $users = User::factory()->count(5)->create();

        livewire(ListUsers::class)
            ->assertOk()
            ->assertCanSeeTableRecords($users);
    });
});
