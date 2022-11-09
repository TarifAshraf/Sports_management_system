<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Sponsor;
use App\Booking;

class SponsorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if ($this->role != 'sponsor') {
                Auth::logout();
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        #$data = DB::table('playerinfos')->where('uid', Auth()->user()->id)->get()->first();
        return view('sponsor.dashboard');
    }

    public function saveinfo(Request $request)
    {
        try
        {
            //dd($request->input());
            $info = new Sponsor;
            $info->sname = $request->sname;
            $info->networth = $request->networth;
            $info->email = $request->email;
            $info->uid = Auth()->user()->id;
            $info->save();
            DB::table('users')->where('id', Auth()->user()->id)->update(['status'=>'active']);
            return redirect(route('sponsorDashboard'))->with('success', 'Information Updated ');
        }
        catch(Exception $e)
        {
            return redirect(route('sponsorDashboard'))->with('failed', 'Operation Error !!!');
        }
    }

    public function playerlist()
    {
        $data = DB::table('playerinfos')->get();
        return view('sponsor.players', ['data'=>$data]);
    }

    public function currentplayerlist()
    {
        $sponsorid = DB::table('sponsors')->where('uid', Auth()->user()->id)->pluck('sid')->first();
        $data = DB::table('playerinfos')->where('sponsor', $sponsorid)->get();
        return view('sponsor.current', ['data'=>$data]);
    }

    public function requestbuy(Request $request)
    {
        try
        {
            //dd($request->input());
            $sponsorid = DB::table('sponsors')->where('uid', Auth()->user()->id)->pluck('sid')->first();
            $book = new Booking;
            $book->playerid = $request->pid;
            $book->bookfor = 'sponsor';
            $book->bookerid = $sponsorid;
            $book->offerprice = $request->offerprice;
            $book->save();
            return redirect(route('sponsorPlayerList'))->with('success', 'Offer Submitted Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('sponsorPlayerList'))->with('failed', 'Operation Error');
        }
    }

    public function requestlist()
    {
        $sponsorid = DB::table('sponsors')->where('uid', Auth()->user()->id)->pluck('sid')->first();
        $data = DB::table('bookings')
                ->join('playerinfos', 'bookings.playerid','=', 'playerinfos.pid')
                ->where(['bookings.bookerid'=>$sponsorid, 'bookings.bookfor'=>'sponsor'])
                ->get();
        return view('sponsor.requestlist', ['data'=>$data]);
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
            return redirect(route('sponsorRequestList'))->with('success', 'Payment Done Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('sponsorRequestList'))->with('failed', 'Operation Error');
        }
    }
}
