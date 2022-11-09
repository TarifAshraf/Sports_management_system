<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\ClubInfo;
use App\Booking;
use App\Product;

class ClubController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if ($this->role != 'club') {
                Auth::logout();
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        return view('club.dashboard');
    }

    public function saveinfo(Request $request)
    {
        try
        {
            //dd($request->input());
            $club = new ClubInfo;
            $club->cname = $request->cname;
            $club->location = $request->location;
            $club->email = $request->email;
            $club->league = $request->league;
            $club->grade = $request->grade;
            $club->uid = Auth()->user()->id;
            $club->save();
            DB::table('users')->where('id', Auth()->user()->id)->update(['status'=>'active']);
            return redirect(route('clubDashboard'))->with('success', 'Information Updated ');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('clubDashboard'))->with('failed', 'Operation Error !!!');
        }
    }

    public function playerlist()
    {
        $data = DB::table('playerinfos')->get();
        return view('club.players', ['data'=>$data]);
    }

    public function currentplayerlist()
    {
        $clubid = DB::table('clubinfos')->where('uid', Auth()->user()->id)->pluck('cid')->first();
        $data = DB::table('playerinfos')->where('currentclub', $clubid)->get();
        return view('club.current', ['data'=>$data]);
    }

    public function requestbuy(Request $request)
    {
        try
        {
            //dd($request->input());
            $clubid = DB::table('clubinfos')->where('uid', Auth()->user()->id)->pluck('cid')->first();
            $book = new Booking;
            $book->playerid = $request->pid;
            $book->bookfor = 'club';
            $book->bookerid = $clubid;
            $book->offerprice = $request->offerprice;
            $book->save();
            return redirect(route('clubPlayerList'))->with('success', 'Offer Submitted Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('clubPlayerList'))->with('failed', 'Operation Error');
        }
    }

    public function addproduct()
    {
        return view('club.addproduct');
    }

    public function productlist()
    {
        $clubid = DB::table('clubinfos')->where('uid', Auth()->user()->id)->pluck('cid')->first();
        $data = DB::table('products')->where('clubid', $clubid)->get();
        return view('club.productlist', ['data'=>$data]);
    }

    public function saveproduct(Request $request)
    {
        try
        {
            //dd($request->input());
            $filename = "";
            $destination = 'products/';
            $staticname = "PI".date('Ydmihs')."__";
            $file = $request->file('image');
            $filename = $staticname.$file->getClientOriginalName();
            $clubid = DB::table('clubinfos')->where('uid', Auth()->user()->id)->pluck('cid')->first();

            $product = new Product;
            $product->clubid = $clubid;
            $product->productname = $request->productname;
            $product->price = $request->price;
            $product->image = $filename;
            $product->save();

            if($file)
            {
                $file->move($destination, $filename);
            }

            return redirect(route('clubAddProduct'))->with('success', 'Product Addedd Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('clubAddProduct'))->with('failed', 'Operation Error !!');
        }
    }

    public function requestlist()
    {
        $clubid = DB::table('clubinfos')->where('uid', Auth()->user()->id)->pluck('cid')->first();
        $data = DB::table('bookings')
                ->join('playerinfos', 'bookings.playerid','=', 'playerinfos.pid')
                ->where(['bookings.bookerid'=>$clubid, 'bookings.bookfor'=>'club'])
                ->get();
        return view('club.requestlist', ['data'=>$data]);
    }

    public function confirmpayment(Request $request)
    {
        try
        {
            //dd($request->input());
            DB::table('bookings')->where('bid', $request->bid)->update([
                'txnid'=>$request->txnid,
                'paymethod'=>$request->paymethod,
                'status'=>'paid'
            ]);
            return redirect(route('clubRequestList'))->with('success', 'Payment Done Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('clubRequestList'))->with('failed', 'Operation Error');
        }
    }

    public function productorders()
    {
        $clubid = DB::table('clubinfos')->where('uid', Auth()->user()->id)->pluck('cid')->first();
        $data = DB::table('orders')
                ->join('products', 'orders.product', '=', 'products.proid')
                ->join('userinfos', 'orders.userid', '=', 'userinfos.usrid')
                ->where([['products.clubid', '=',$clubid],['orders.status','=','pending']])
                ->get();
                //dd($data);
        return view('club.productorders', ['data'=>$data]);
    }

    public function confirmdelivery(Request $request)
    {
        try
        {
            //dd($request->input());
            DB::table('orders')->where('oid', $request->oid)->update([
                'status'=>'delivered'
            ]);
            return redirect(route('clubProductOrders'))->with('success', 'Order Marked As Delivered');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('clubProductOrders'))->with('failed', 'Operation Error');
        }
    }

    public function deleteplayer(Request $request)
    {
        try
        {
            DB::table('playerinfos')->where('pid', $request->pid)->update(['currentclub'=>null]);
            return redirect(route('clubCurrentPlayerList'))->with('success', 'Player Removed Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('clubCurrentPlayerList'))->with('failed', 'Operation Error');
        }
    }

    public function deleteproduct(Request $request)
    {
        try
        {
            DB::table('products')->where('proid', $request->proid)->delete();
            return redirect(route('clubListProduct'))->with('success', 'Player Removed Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('clubListProduct'))->with('failed', 'Operation Error');
        }
    }

}
