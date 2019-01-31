<?php

use Illuminate\Database\Seeder;
use LaravelVueJs\Models\Menu;
use LaravelVueJs\Models\MenuItem;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Menu::class, 4)->create()->each(function (Menu $menu) {
            factory(MenuItem::class, 5)->make()->each(function (MenuItem $menuItem) use ($menu) {
                $menuItem->menu_id = $menu->id;
                $menuItem->save();
            });
        });
    }
}
