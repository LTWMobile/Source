<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Shop;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::all();
        return view('page.shop.index', [
            'shops' => $shops,
            'success' => session('success')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dialog.editShop', [
            '_route' => 'shop.store',
            '_method' => 'POST',
            'shop' => new Shop()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $upload_rules = [
            'name' => 'required',
        ];
        $upload_rule_messages = [
            'required' => 'Trường ":attribute" bị bỏ trống',
        ];
        $validator = Validator::make($request->all(), $upload_rules, $upload_rule_messages);
        if ($validator->fails()) {
            return redirect()->route('shop.index')->withErrors($validator);
        }

        $shop = new Shop();
        $shop->name = $request->get('name');
        $shop->address = $request->get('address');
        $shop->phonenumber = $request->get('phonenumber');

        $shop->save();

        $file = $request->file('image');
        if (!is_null($file)) {
            /** @var \App\Models\Photo|\Exception $photo */
            $photo = Photo::upload(file_get_contents($file->getRealPath()), $file->getType());
            if ($photo instanceof Photo) {
                $shop->cover_id = $photo->id;
                $shop->save();
            } else {
                return redirect()->route('shop.index')->withErrors($photo->getMessage());
            }
        }

        return redirect()->route('shop.index')->with('success', "Tạo quán <strong>$shop->name</strong> thành công!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Shop $shop)
    {
        return view('dialog.editShop', [
            '_route' => 'shop.update',
            '_method' => 'PUT',
            'shop' => $shop
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Shop $shop
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Shop $shop)
    {
        $upload_rules = [
            'name' => 'required',
        ];
        $upload_rule_messages = [
            'required' => 'Trường ":attribute" bị bỏ trống',
        ];
        $validator = Validator::make($request->all(), $upload_rules, $upload_rule_messages);
        if ($validator->fails()) {
            return redirect()->route('shop.index')->withErrors($validator);
        }

        $shop->name = $request->get('name');
        $shop->address = $request->get('address');
        $shop->phonenumber = $request->get('phonenumber');

        $shop->save();

        $file = $request->file('image');
        if (!is_null($file)) {
            /** @var \App\Models\Photo|\Exception $photo */
            $photo = Photo::upload(file_get_contents($file->getRealPath()), $file->getType());
            if ($photo instanceof Photo) {
                $shop->cover_id = $photo->id;
                $shop->save();
            } else {
                return redirect()->route('shop.index')->withErrors($photo->getMessage());
            }
        }

        return redirect()->route('shop.index')->with('success', "Cập nhật dữ liệu cho quán <strong>$shop->name</strong> thành công!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
