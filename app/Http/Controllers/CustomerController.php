<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Users_Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Mime\toString;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Auth::user()->customers()->get();
        return json_encode($customers);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mac_address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'points' => ['nullable', 'integer', 'max:255'],
            'user_id' => ['required'],
        ]);

        if ($validator->fails()) {

            return json_encode($validator->getMessageBag());
        }
        if ($request->points==Null){
            $request->points = 0;//saleh
        }
        $if_mac_exists =DB::table('customers')->select('id')->where('mac_address',$request->mac_address)->exists();
        if (! $if_mac_exists)//if mac not exists register
        {
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mac_address' => $request->mac_address,
                'phone_number' => $request->phone_number,
                'points' => $request->points,
            ]);
            $customer->users()->attach($request->user_id);
            $customer_id=  Menu::all()->where('user_id',$request->user_id)->pluck('product_id');
            $menu = Product::all()->wherein('id', $customer_id);
            $customer_id2 = Customer::all()->where('mac_address','=',$request->mac_address)->first()->id;
            $validator = Validator::make($request->all(),[
                'user_id' => ['required'],
            ]);

            if ($validator->fails()) {

                return json_encode($validator->getMessageBag());
            }
            $UsersCustomersId= Users_Customers::where('user_id','=',$request->user_id)->where('customer_id','=',$customer_id2)->first()->id;
              Cart::create([
                'user_customer_id' => $UsersCustomersId,
            ]);
            $userId =intval ($request->user_id);

            $cartId = Cart::where('user_customer_id',$UsersCustomersId)->orderBy('carts.id', 'desc')->first()->id;
            return ['menu'=>$menu,'user_id'=>$userId,'customer_id'=>$customer_id2,'cart_id'=>$cartId];
        }
        elseif ($if_mac_exists)//if mac exists
        {
            $customer_id= DB::table('customers')->select('id')->where('mac_address',$request->mac_address)->get()->pluck('id')->toArray();//select id of customer that have a mac_address
            $users_id_customer_have = DB::table('users_customers')->select('user_id')->where('customer_id','=',$customer_id[0])->get()->pluck('user_id')->toArray();
            if (!in_array($request->user_id, $users_id_customer_have))//need register in Users_Customers to new restaurant
            {
                $customer = DB::table('customers')->select('id')->where('mac_address', $request->mac_address)->get()->pluck('id')->toArray();
                Users_Customers::create([
                    'user_id' => $request->user_id,
                    'customer_id' => $customer[0],
                ]);
                $customer_id= Menu::all()->where('user_id',$request->user_id)->pluck('product_id');
                $menu = Product::all()->wherein('id', $customer_id);
                $customer_id2 = Customer::all()->where('mac_address','=',$request->mac_address)->first()->id;
                $UsersCustomersId= Users_Customers::where('user_id','=',$request->user_id)->where('customer_id','=',$customer_id2)->first()->id;
                  Cart::create([
                    'user_customer_id' => $UsersCustomersId,
                ]);
                $userId =intval ($request->user_id);
                $cartId = Cart::where('user_customer_id',$UsersCustomersId)->orderBy('carts.id', 'desc')->first()->id;
                return ['menu'=>$menu,'user_id'=>$userId,'customer_id'=>$customer_id2,'cart_id'=>$cartId];
            }
             elseif(in_array($request->user_id, $users_id_customer_have)){
                 $customer_id= Menu::all()->where('user_id',$request->user_id)->pluck('product_id');
                 $menu = Product::all()->wherein('id', $customer_id);
                 $customer_id2 = Customer::all()->where('mac_address','=',$request->mac_address)->first()->id;
                 $UsersCustomersId= Users_Customers::where('user_id','=',$request->user_id)->where('customer_id','=',$customer_id2)->first()->id;
                   Cart::create([
                     'user_customer_id' => $UsersCustomersId,
                 ]);
                   $userId =intval ($request->user_id);
                 $cartId = Cart::where('user_customer_id',$UsersCustomersId)->orderBy('carts.id', 'desc')->first()->id;

                     $x = Cart::Join('orders','orders.cart_id','=','carts.id')
                     ->join('products','products.id','=','orders.menu_id')
                     ->select('carts.id','orders.amount','products.name','products.price')
                     ->where('carts.user_customer_id', $UsersCustomersId)
                     ->orderBy('cart_id')
                     ->get();

                 return ['menu'=>$menu,'user_id'=>$userId,'customer_id'=>$customer_id2,'cart_id'=>$cartId,'cart_order'=>$x];
                            }
                    }
        }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
