<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUserTable::class);
        $this->call(ProvinsiSeeder::class);
        $this->call(KotaSeeder::class);
        $this->call(BarangSeeder::class);
        $this->call(TransaksiBarangSeeder::class);
        $this->call(CartTransaksiSeeder::class);
        $this->call(TransaksiLahan::class);
    }
}
