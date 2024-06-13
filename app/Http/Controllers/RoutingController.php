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
        $userType = Auth::user()->user_type;

        if ($first == "assets")
            return redirect('home');

        if (Auth::user()->user_type === 'karyawan pimpinan' || Auth::user()->user_type === 'karyawan pelaksana') { 
            return view('karyawan' .'.'. $first, ['mode' => $request->query('mode'), 'demo' => $request->query('demo')]);
        } else {
            return view($userType .'.'. $first, ['mode' => $request->query('mode'), 'demo' => $request->query('demo')]);
        }
    }

    /**
     * second level route
     */
    public function secondLevel(Request $request, $first, $second)
    {
        $userType = Auth::user()->user_type;

        if ($first == "assets")
            return redirect('home');

        if (Auth::user()->user_type === 'karyawan pimpinan' || Auth::user()->user_type === 'karyawan pelaksana') { 
            return view('karyawan' .'.'. $first . '.' . $second, ['mode' => $request->query('mode'), 'demo' => $request->query('demo')]);
        } else {
            return view($userType .'.'. $first . '.' . $second, ['mode' => $request->query('mode'), 'demo' => $request->query('demo')]);
        }
    }

    /**
     * third level route
     */
    public function thirdLevel(Request $request, $first, $second, $third)
    {
        $userType = Auth::user()->user_type;

        if ($first == "assets")
            return redirect('home');

        if (Auth::user()->user_type === 'karyawan pimpinan' || Auth::user()->user_type === 'karyawan pelaksana') { 
            return view('karyawan' .'.'. $first . '.' . $second . '.' . $third, ['mode' => $request->query('mode'), 'demo' => $request->query('demo')]);
        } else {
            return view($userType .'.'. $first . '.' . $second . '.' . $third, ['mode' => $request->query('mode'), 'demo' => $request->query('demo')]);
        }
    }
}
