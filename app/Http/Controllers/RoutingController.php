<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoutingController extends Controller
{

    public function __construct()
    {
        // $this->
        // middleware('auth')->
        // except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()) {
            $userType = Auth::user()->user_type;
            switch ($userType) {
                case 'admin':
                    return redirect('admin/dashboard');
                case 'karyawan':
                    return redirect('karyawan/dashboard');
                case 'mandor':
                    return redirect('mandor/dashboard');
            }
        } else {
            return redirect('login');
        }
    }

    /**
     * Display a view based on first route param
     *
     * @return \Illuminate\Http\Response
     */
    public function root(Request $request, $first)
    {

        // $mode = $request->query('mode');
        // $demo = $request->query('demo');
     
        // if ($first == "assets")
        //     return redirect('home');

        // return view($first, ['mode' => $mode, 'demo' => $demo]);
        if (Auth::user()) {
            $userType = Auth::user()->user_type;
            switch ($userType) {
                case 'admin':
                    return redirect('admin/dashboard');
                case 'karyawan':
                    return redirect('karyawan/dashboard');
                case 'mandor':
                    return redirect('mandor/dashboard');
            }
        } else {
            return redirect('login');
        }
    }

    /**
     * second level route
     */
    public function secondLevel(Request $request, $first, $second)
    {

        $mode = $request->query('mode');
        $demo = $request->query('demo');

        if ($first == "assets")
            return redirect('home');



    return view($first .'.'. $second, ['mode' => $mode, 'demo' => $demo]);
    }

    /**
     * third level route
     */
    public function thirdLevel(Request $request, $first, $second, $third)
    {
        $mode = $request->query('mode');
        $demo = $request->query('demo');

        if ($first == "assets")
            return redirect('home');

        return view($first . '.' . $second . '.' . $third, ['mode' => $mode, 'demo' => $demo]);
    }
}
