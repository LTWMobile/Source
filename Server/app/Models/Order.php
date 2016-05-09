<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @property int table_id
 * @package App\Models
 * @property-read \Illuminate\Database\Eloquent\Collection|Menu[] items
 */
class Order extends Model
{
    protected $table = 'Order';
    protected $appends = ['items'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items(){
        return $this->belongsToMany('\App\Models\Menu','OrderDetail','order_id','menu_id')->withPivot('count');
    }

    public function shop(){
        return $this->belongsTo('\App\Models\Shop');
    }

    public function getTotallyAttribute(){
        return $this->items->sum(/**
         * @param \App\Models\Menu $item
         * @return mixed
         */
            function($item){
            return $item->price * $item->pivot->count;
        });
    }
}
