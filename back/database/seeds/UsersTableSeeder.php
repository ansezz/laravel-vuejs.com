<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = new \LaravelVueJs\Models\User([
            'name'     => 'admin',
            'email'    => 'admin@laravel-vuejs.com',
            'password' => bcrypt('secret'),
        ]);
        $admin->save();

        factory(\LaravelVueJs\Models\User::class, 50)->create()->each(function (\LaravelVueJs\Models\User $user) {
            $user->posts()->save(factory(\LaravelVueJs\Models\Post::class)->make());
        });
    }
}
