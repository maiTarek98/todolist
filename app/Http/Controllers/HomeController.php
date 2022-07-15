<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $todos = Todo::where('user_id',auth()->user()->id)->whereDay('created_at',now()->day)->get();
        $sort='';
        if($request->sort != null){
            $sort= $request->sort;
        }
        if($sort == 'active'){
            $todos=Todo::where('user_id', auth()->user()->id)->whereDay('created_at',now()->day)->where('status','pending')->get();
        }else if($sort == 'completed'){
            $todos=Todo::where('user_id', auth()->user()->id)->whereDay('created_at',now()->day)->where('status','completed')->get();
        }


        $currentDate = Carbon::now();
        $filter='';
        if($request->filter != null){
            $filter= $request->filter;
        }
        if($filter == 'lastweek'){
            $agoDate = Carbon::now()->subWeek();
            $todos=Todo::where('user_id', auth()->user()->id)->whereBetween('created_at',[$agoDate,$currentDate])->get();
        }else if($filter == 'lastmonth'){
            $todos=Todo::where('user_id', auth()->user()->id)->whereBetween('created_at',[Carbon::now()->subMonth()->month, $currentDate])->get();
        }else if($filter == 'lastthreemonth'){
            $last_three_month = Carbon::now()->startOfMonth()->subMonth(3);

            $todos=Todo::where('user_id', auth()->user()->id)->whereBetween('created_at',[$last_three_month, $currentDate])->get();
        }


        return view('home', compact('todos'));
    }


    public function logout(){
        auth()->logout();

        return back();
    }
}
