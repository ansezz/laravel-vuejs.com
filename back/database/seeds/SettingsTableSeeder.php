<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var array $settings */
        $settings = [
            'name'        => 'App Name',
            'title'       => 'Title',
            'description' => 'Description',
            'form_email'  => 'From Email',
            'form_name'   => 'From Name',
            'form_name'   => 'From Name',
        ];

        foreach ($settings as $key => $value) {
            \LaravelVueJs\Models\Setting::Create([
                'name' => $value,
                'key'  => $key,
            ]);
        }

    }
}
