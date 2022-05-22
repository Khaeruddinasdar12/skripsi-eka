<?php

use Illuminate\Database\Seeder;

class AdminSeedFaker extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = factory(\App\Admin::class, 40)->create();
    }
}
