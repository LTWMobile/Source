<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|Menu[] $menu
 * @property string name
 * @property string address
 * @property string phonenumber
 * @property int cover_id
 */
class Shop extends Model
{
    protected $table = 'Shop';
    protected $appends = ['menu', 'thumbnail'];
    protected $hidden = ['id'];
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menu(){
        return $this->hasMany('App\Models\Menu', 'shopid', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return $this->hasMany('App\Models\Order', 'shop_id', 'id');
    }

    public function getMenuAttribute(){
        return $this->menu()->getResults();
    }

    public function getThumbnailAttribute(){
        /** @var \App\Models\Photo|null $thumb */
        $thumb = $this->hasOne('App\Models\Photo', 'id', 'cover_id')->getResults();
        if($thumb)
            return $thumb->src;
        else
            return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTkyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDE5MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTUxNDg5NmMzM2IgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNTE0ODk2YzMzYiI+PHJlY3Qgd2lkdGg9IjE5MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI3MC4wNTQ2ODc1IiB5PSIxMDQuNSI+MTkyeDIwMDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==';
    }

    public function getLowestPriceAttribute(){
        return $this->menu->min('price');
    }

    public function getHighestPriceAttribute(){
        return $this->menu->max('price');
    }
}
