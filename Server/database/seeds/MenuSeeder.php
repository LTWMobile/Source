<?php

use App\Models\Shop;
use Illuminate\Database\Seeder;
use mnshankar\CSV\CSV;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Menu')->truncate();
        $csv = new CSV();
        $menu = $csv->fromFile(dirname(__FILE__) . '/csv/Menu.csv')->toArray();

        foreach ($menu as $item) {
            /** @var Shop $shop */
            $shop = Shop::findOrNew($item['shopid']);

            $i = new \App\Models\Menu();
            $i->name = $item['name'];
            $i->quantity = $item['quantity'];
            $i->price = $item['price'];

            $shop->menu()->save($i);
        }
    }
}
