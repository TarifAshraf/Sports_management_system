<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

use App\PlayerInfo;
use App\Booking;

class PlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if ($this->role != 'player') {
                Auth::logout();
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $data = DB::table('playerinfos')->where('uid', Auth()->user()->id)->get()->first();
        return view('player.dashboard', ['data'=>$data]);
    }

    public function saveinfo(Request $request)
    {
        try
        {
            //dd($request->input());
            $info = new PlayerInfo;
            $info->pname = $request->pname;
            $info->age = $request->age;
            $info->email = $request->email;
            $info->club = $request->club;
            $info->marketvalue = $request->marketvalue;
            $info->uid = Auth()->user()->id;
            $info->save();
            DB::table('users')->where('id', Auth()->user()->id)->update(['status'=>'active']);
            return redirect(route('playerDashboard'))->with('success', 'Information Updated ');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('playerDashboard'))->with('failed', 'Operation Error !!!');
        }
    }

    public function agentslist()
    {
        $info = DB::table('playerinfos')->where('uid', Auth()->user()->id)->get()->first();
        $agentid = $info->currentagent;
        $playerid = $info->pid;
        $current = DB::table('agentinfos')->where('aid', $agentid)->get()->first();
        $data = DB::table('agentinfos')->get();
        return view('player.agents',['data'=>$data, 'current'=>$current, 'playerid'=>$playerid]);
    }

    public function bookagent(Request $request)
    {
        try
        {
            //dd($request->input());
            $book = new Booking;
            $book->playerid = $request->pid;
            $book->bookfor = 'agent';
            $book->bookerid = $request->aid;
            $book->txnid = $request->txnid;
            $book->paymethod = $request->paymethod;
            $book->save();
            return redirect(route('playerAgentsList'))->with('success', 'Agent Request Submitted');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('playerAgentsList'))->with('failed', 'Operation Error !!!');
        }
    }

    public function requestlist()
    {
        $playerid = DB::table('playerinfos')->where('uid', Auth()->user()->id)->pluck('pid')->first();
        $data = DB::table('bookings')->where(['status'=>'forwarded', 'playerid'=>$playerid])->get();
        $data2 = DB::table('bookings')->where([['status','!=','confirmed'],'bookfor'=>'agent' ,'playerid'=>$playerid])->get();
        return view('player.requests', ['data'=>$data, 'data2'=>$data2]);
    }

    public function acceptrequest(Request $request)
    {
        try
        {
            DB::table('bookings')->where('bid', $request->bid)->update(['status'=>'accepted']);
            return redirect(route('playerRequestList'))->with('success', 'Request Accepted Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('playerRequestList'))->with('failed', 'Operation Error !!!');
        }
    }

    public function rejectrequest(Request $request)
    {
        try
        {
            DB::table('bookings')->where('bid', $request->bid)->update(['status'=>'rejected']);
            return redirect(route('playerRequestList'))->with('success', 'Request Rejected Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('playerRequestList'))->with('failed', 'Operation Error !!!');
        }
    }
}
