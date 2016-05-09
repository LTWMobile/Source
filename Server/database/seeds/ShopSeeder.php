<?php

use Illuminate\Database\Seeder;
use mnshankar\CSV\CSV;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Shop')->truncate();
        DB::table('Photo')->truncate();
        $csv = new CSV();
        $shops = $csv->fromFile(dirname(__FILE__) . '/csv/Shop.csv')->toArray();

        foreach ($shops as $shop) {
            $s = new \App\Models\Shop();
            $s->name = $shop['name'];
            $s->address = $shop['address'];
            $s->phonenumber = $shop['phonenumber'];
            $s->save();
        }
    }
}
