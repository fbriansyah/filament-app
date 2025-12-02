<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = Role::factory(4)->create();
        Customer::factory(10)->create();
        Service::factory(5)->create();

        User::factory(3)
            ->create()
            ->each(function ($user) use ($roles) {
                $user->roles()->attach($roles->filter(function ($role) {
                    return $role->slug !== 'admin';
                })->random(2));
            });
        User::create([
            'name' => 'Feb',
            'email' => 'f@m.com',
            'password' => '123qweasdzxc',
            'email_verified_at' => now(),
        ])
            ->roles()->attach($roles->where('slug', 'admin')->first());
    }
}
