<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Auth;
use Helper;
use Session;
use App\Models\User;


class DashboardController extends Controller
{
    public function index(){
        $total_transaction = TransactionHistory::sum('amount');
        $total_users = User::where('role', '!=', '1')->count();
        $premium_users = User::where('role', '!=', '1')->get()->filter(function ($user) {
            return $user->premium == 1;
        })->count();
        $chat_users = User::where('role', '!=', '1')->get()->filter(function ($user) {
            return $user->chat == 1;
        })->count();
        $data = [
            'total_transaction' => $total_transaction,
            'total_users' => $total_users,
            'premium_users' => $premium_users,
            'chat_users' => $chat_users,
        ];
        return view('backend.pages.dashboard', $data);
    }
}
