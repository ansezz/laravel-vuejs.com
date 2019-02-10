<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param \Faker\Generator $faker
     *
     * @return void
     */
    public function run(Faker $faker): void
    {

        $admin = new \LaravelVueJs\Models\User([
            'name'     => 'admin',
            'nickname' => 'admin',
            'email'    => 'admin@laravel-vuejs.com',
            'password' => bcrypt('secret'),
        ]);
        $admin->save();

        factory(\LaravelVueJs\Models\User::class, 5)->create()->each(function (\LaravelVueJs\Models\User $user) use (
            $faker
        ) {
            factory(\LaravelVueJs\Models\Post::class, 3)->make()->each(function (\LaravelVueJs\Models\Post $post) use (
                $user,
                $faker
            ) {
                $post->user_id = $user->id;
                $post->addMediaFromUrl($faker->imageUrl())
                    ->toMediaCollection(\LaravelVueJs\Models\Post::MEDIA_COLLECTION);
                $post->save();
                $post->attachTags([$faker->text(6), $faker->text(6), $faker->text(6)]);
                $post->attachCategories([$faker->text(6), $faker->text(6), $faker->text(6)]);
            });

        });
    }
}
