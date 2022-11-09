<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\AgentInfo;

use function PHPUnit\Framework\returnSelf;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if ($this->role != 'agent') {
                Auth::logout();
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        #$data = DB::table('playerinfos')->where('uid', Auth()->user()->id)->get()->first();
        #return view('player.dashboard', ['data'=>$data]);
        return view('agent.dashboard');
    }

    public function saveinfo(Request $request)
    {
        try
        {
            //dd($request->input());
            $info = new AgentInfo;
            $info->aname = $request->aname;
            $info->age = $request->age;
            $info->email = $request->email;
            $info->experience = $request->experience;
            $info->marketvalue = $request->marketvalue;
            $info->uid = Auth()->user()->id;
            $info->save();
            DB::table('users')->where('id', Auth()->user()->id)->update(['status'=>'active']);
            return redirect(route('agentDashboard'))->with('success', 'Information Updated ');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('agentDashboard'))->with('failed', 'Operation Error !!!');
        }
    }

    public function payrequests()
    {
        $agentid = DB::table('agentinfos')->where('uid', Auth()->user()->id)->pluck('aid')->first();
        $data = DB::table('bookings')->join('playerinfos', 'bookings.playerid','=','playerinfos.pid')->where(['bookerid'=>$agentid, 'status'=>'pending'])->get();
        return view('agent.payrequests', ['data'=>$data]);
    }

    public function acceptpayrequests(Request $request)
    {
        try
        {
            $booking = DB::table('bookings')->where('bid', $request->bid)->get()->first();
            DB::table('bookings')->where('bid', $request->bid)->update(['status'=>'confirmed']);
            DB::table('playerinfos')->where('pid', $booking->playerid)->update(['currentagent'=>$booking->bookerid]);
            return redirect(route('agentPayRequests'))->with('success', 'Payment Authorized Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('agentPayRequests'))->with('failed', 'Operation Error !!!');
        }
    }

    public function rejectpayrequests(Request $request)
    {
        try
        {
            $booking = DB::table('bookings')->where('bid', $request->bid)->update(['status'=>'Rejected']);
            return redirect(route('agentPayRequests'))->with('success', 'Payment Rejected Successfully');
        }
        catch(Exception $e)
        {
            dd($e);
            return redirect(route('agentPayRequests'))->with('failed', 'Operation Error !!!');
        }
    }

    public function approvalrequests()
    {
        $agentid = DB::table('agentinfos')->where('uid', Auth()->user()->id)->pluck('aid')->first();
        $data = DB::table('playerinfos')
                ->join('bookings', 'playerinfos.pid','=','bookings.playerid')
                ->where([
                    ['playerinfos.currentagent', '=' ,$agentid],
                    ['bookings.bookfor', '!=' , 'agent'],
                    ['bookings.status', '!=', 'confirmed'],
                ])
                ->get();
        //dd($data);
        return view('agent.approval', ['data'=>$data]);
    }

    public function forwardapproval(Request $request)
    {
        try
        {
            DB::table('bookings')->where('bid', $request->bid)->update(['status'=>'forwarded']);
            return redirect(route('agentApprovalRequests'))->with('success', 'Request Forwarded Successfully');
        }
        catch(Exception $e)
        {
            return redirect(route('agentApprovalRequests'))->with('failed', 'Operation Error !!!');
        }
    }

    public function rejectapproval(Request $request)
    {
        try
        {
            DB::table('bookings')->where('bid', $request->bid)->update(['status'=>'rejected']);
            return redirect(route('agentApprovalRequests'))->with('success', 'Request Forwarded Successfully');
        }
        catch(Exception $e)
        {
            return redirect(route('agentApprovalRequests'))->with('failed', 'Operation Error !!!');
        }
    }

    public function acceptpayment(Request $request)
    {
        try
        {
            $booking = DB::table('bookings')->where('bid', $request->bid)->get()->first();
            $playerid = $booking->playerid;

            if($booking->bookfor == 'club')
            {
                $clubname = DB::table('clubinfos')->where('cid', $booking->bookerid)->pluck('cname')->first();
                DB::table('playerinfos')->where('pid', $playerid)->update(['club'=>$clubname, 'currentclub'=>$booking->bookerid]);
            }

            if($booking->bookfor == 'sponsor')
            {
                DB::table('playerinfos')->where('pid', $playerid)->update(['sponsor'=>$booking->bookerid]);
            }

            DB::table('bookings')->where('bid', $request->bid)->update(['status'=>'confirmed']);
            return redirect(route('agentApprovalRequests'))->with('success', 'Request Forwarded Successfully');
        }
        catch(Exception $e)
        {
            return redirect(route('agentApprovalRequests'))->with('failed', 'Operation Error !!!');
        }
    }
}
