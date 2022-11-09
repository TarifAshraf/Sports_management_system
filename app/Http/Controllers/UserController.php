<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\UserInfo;
use App\Order;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if ($this->role != 'user') {
                Auth::logout();
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        return view('users.dashboard');
    }

    public function saveinfo(Request $request)
    {
        try
        {
            //dd($request->input());
            $info = new UserInfo;
            $info->uname = $request->uname;
            $info->contactno = $request->contactno;
            $info->email = $request->email;
            $info->address = $request->address;
            $info->uid = Auth()->user()->id;
            $info->save();
            DB::table('users')->where('id', Auth()->user()->id)->update(['status'=>'active']);
            return redirect(route('userDashboard'))->with('success', 'Information Updated ');
        }
        catch(Exception $e)
        {
            return redirect(route('userDashboard'))->with('failed', 'Operation Error !!!');
        }
    }

    public function productlist()
    {
        $data = DB::table('products')->get();
        $info = DB::table('userinfos')->where('uid', Auth()->user()->id)->get()->first();
        return view('users.productlist', ['data'=>$data, 'info'=>$info]);
    }

    public function makeorder(Request $request)
    {
        try
        {
            //dd($request->input());
            $userid = DB::table('userinfos')->where('uid', Auth()->user()->id)->pluck('usrid')->first();
            $product = DB::table('products')->where('proid', $request->proid)->get()->first();

            $order = new Order;
            $order->product = $request->proid;
            $order->unitprice = $product->price;
            $order->qty = $request->qty;
            $order->size = $request->size;
            $order->delivery = $request->delivery;
            $order->paymethod = $request->paymethod;
            $order->userid = $userid;
            $order->save();

            return redirect(route('userProductList'))->with('success', 'Purchase Order Submitted');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('userProductList'))->with('failed', 'Operation Error !!!');
        }
    }

    public function pendingorder()
    {
        $userid = DB::table('userinfos')->where('uid', Auth()->user()->id)->pluck('usrid')->first();
        $data = DB::table('orders')->join('products', 'orders.product','=','products.proid')->where('orders.userid', $userid)->get();

        return view('users.pendingorders', ['data'=>$data, 'userid'=>$userid]);
    }

}
