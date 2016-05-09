<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Photo;
use App\Models\Shop;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;

class ShopMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function index(Shop $shop)
    {
        return view('page.menu.index', [
            'shop' => $shop,
            'menu' => $shop->menu,
            'success' => session('success')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function create(Shop $shop)
    {
        return view('dialog.editMenu', [
            '_route'    => 'shop.menu.store',
            '_method'   => 'POST',
            'shop'      => $shop,
            'menu'      => new Menu()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shop $shop)
    {
        $upload_rules = [
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required|numeric'
        ];
        $upload_rule_messages = [
            'required' => 'Trường ":attribute" bị bỏ trống',
            'numeric' => 'Trường ":attribute" bắt buộc phải là một số'
        ];
        $validator = Validator::make($request->all(),$upload_rules,$upload_rule_messages);
        if($validator->fails()){
            return redirect()->route('shop.menu.index', [
                'shop' => $shop
            ])->withErrors($validator);
        }

        $menu = new Menu();
        $menu->name = $request->get('name');
        $menu->quantity = $request->get('quantity');
        $menu->price = $request->get('price');
        $shop->menu()->save($menu);

        $file = $request->file('image');
        if(!is_null($file)) {
            /** @var \App\Models\Photo|\Exception $photo */
            $photo = Photo::upload(file_get_contents($file->getRealPath()), $file->getType());
            if ($photo instanceof Photo) {
                $menu->avatar_id = $photo->id;
                $menu->save();
            } else {
                return redirect()->route('shop.menu.index', [
                    'shop' => $shop
                ])->withErrors($photo->getMessage());
            }
        }

        return redirect()->route('shop.menu.index', [
            'shop' => $shop
        ])->with('success',"Tạo mới món <strong>$menu->name ($shop->name)</strong> thành công!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Shop $shop
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Shop $shop, Menu $menu)
    {
        return view('dialog.editMenu', [
            '_route'     => 'shop.menu.update',
            '_method'    => 'PUT',
            'shop'       => $shop,
            'menu'       => $menu,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Shop $shop
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Shop $shop, Menu $menu)
    {
        $upload_rules = [
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required|numeric'
        ];
        $upload_rule_messages = [
            'required' => 'Trường ":attribute" bị bỏ trống',
            'numeric' => 'Trường ":attribute" bắt buộc phải là một số'
        ];
        $validator = Validator::make($request->all(),$upload_rules,$upload_rule_messages);
        if($validator->fails()){
            return redirect()->route('shop.menu.index', [
                'shop' => $shop
            ])->withErrors($validator);
        }

        $menu->name = $request->get('name');
        $menu->quantity = $request->get('quantity');
        $menu->price = $request->get('price');

        $menu->save();

        $file = $request->file('image');
        if(!is_null($file)) {
            /** @var \App\Models\Photo|\Exception $photo */
            $photo = Photo::upload(file_get_contents($file->getRealPath()), $file->getType());
            if ($photo instanceof Photo) {
                $menu->avatar_id = $photo->id;
                $menu->save();
            } else {
                return redirect()->route('shop.menu.index', [
                    'shop' => $shop
                ])->withErrors($photo->getMessage());
            }
        }

        return redirect()->route('shop.menu.index', [
            'shop' => $shop
        ])->with('success',"Cập nhật món <strong>$menu->name ($shop->name)</strong> thành công!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Shop $shop
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Shop $shop, Menu $menu)
    {
        $menu_name = $menu->name;

        $menu->delete();

        return redirect()->route('shop.menu.index', [
            'shop' => $shop
        ])->with('success',"Xoá món <strong>$menu_name ($shop->name)</strong> thành công!");
    }
}
