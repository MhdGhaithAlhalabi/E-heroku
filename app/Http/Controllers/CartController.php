<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Product;
use App\Models\Users_Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $UsersCustomersId= Users_Customers::where('user_id','=',Auth::user()->id)->get()->pluck('id');

        //   $cart = Cart::all()->whereIn('user_customer_id',$UsersCustomersId);

        return $cart = Cart::Join('orders','orders.cart_id','=','carts.id')
            ->join('products','products.id','=','orders.menu_id')
            ->select('carts.id','orders.amount','products.name','products.price')
            ->whereIn('carts.user_customer_id', $UsersCustomersId)
            ->orderBy('cart_id')
            ->get();

          // $cart2 = $cart->pluck('id');

         // $cart3 = Order::find(1)->whereIn('cart_id',$cart2)->orderBy('cart_id')->get();//cart
         // $cart4 = Order::find(1)->whereIn('cart_id',$cart2)->orderBy('cart_id')->pluck('menu_id');//cart

         // $product = Product::all()->whereIn('id',$cart4);
         // ['cart'=>$cart3,'product name' =>$product];
    }
    public function index2(Request $request)
    {
        $UsersCustomersId= Users_Customers::where('customer_id','=',$request->customer_id)->where('user_id','=',$request->user_id)->get()->pluck('id');
        return $cart = Cart::Join('orders','orders.cart_id','=','carts.id')
            ->join('products','products.id','=','orders.menu_id')
            ->select('carts.id','orders.amount','products.name','products.type','products.price')
            ->whereIn('carts.user_customer_id', $UsersCustomersId)
            ->orderBy('products.type')
            ->get();

    }
    public function random5(Request $request){

        $UsersCustomersId= Users_Customers::where('customer_id','=',$request->customer_id)->where('user_id','=',$request->user_id)->get()->pluck('id');
           $cart = Cart::Join('orders','orders.cart_id','=','carts.id')
            ->join('products','products.id','=','orders.menu_id')
            ->select('carts.id','orders.amount','products.name','products.price')
            ->whereIn('carts.user_customer_id', $UsersCustomersId)
            ->where('products.type', 'دجاج')->count('products.type');

           $cart2 = Cart::Join('orders','orders.cart_id','=','carts.id')
            ->join('products','products.id','=','orders.menu_id')
            ->select('carts.id','orders.amount','products.name','products.price')
            ->whereIn('carts.user_customer_id', $UsersCustomersId)
            ->where('products.type', 'سندويش')->count('products.type');

           if($cart > $cart2)
           {
               return  $checkin = Product::
               Join('menus','menus.product_id','=','products.id')
                   ->select('products.*')
                   ->where('products.type', 'دجاج')
                   ->where('menus.user_id','=',$request->user_id)
                   ->get()->random(1);
           }
           else
               return $sandwich = Product::
               Join('menus','menus.product_id','=','products.id')
                   ->select('products.*')
                   ->where('products.type', 'سندويش')
                   ->where('menus.user_id','=',$request->user_id)
                   ->get()->random(1);

       // $cart = Cart::Join('orders','orders.cart_id','=','carts.id')
        //    ->join('products','products.id','=','orders.menu_id')
        //    ->select('carts.id','orders.amount','products.name','products.type','products.price')
        //    ->whereIn('carts.user_customer_id', $UsersCustomersId)->get();
      //  return $BrandCollection = collect($cart)->countBy('type');
        //return  $max= $BrandCollection->where('type', $BrandCollection->max('type'))->first();

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => ['required'],
            'customer_id' => ['required'],
        ]);

        if ($validator->fails()) {

            return json_encode($validator->getMessageBag());
        }
   $UsersCustomersId= Users_Customers::where('user_id','=',$request->user_id)->where('customer_id','=',$request->customer_id)->first()->id;
        $users_customers_id = Cart::create([
            'user_customer_id' => $UsersCustomersId,
        ]);
        return json_encode('cart stored');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
