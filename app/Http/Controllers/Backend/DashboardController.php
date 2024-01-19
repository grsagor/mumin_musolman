<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Helper;
use Session;
use App\Models\User;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();
            if ($this->user->role == 3 || $this->user->role == 4) {
                Auth::logout();
                return redirect()->route('login');
            }else{
                if (!$this->user || Helper::hasRight('dashboard.view') !=  true) {
                    Auth::logout();
                    $request->session()->invalidate();
                    session()->flash('error', 'You can not access! Login first.');
                    return redirect()->route('admin');
                }
            }
            return $next($request);
        });
    }

    public function index(){
        if (empty(Session::get('admin_language'))) {
            Session::put('admin_language', 'en');
        }
        return view('backend.pages.dashboard');
    }
}
