<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Helper;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            if (!$this->user || Helper::hasRight('user.view') == false) {
                session()->flash('error', 'You can not access! Login first.');
                return redirect()->route('admin');
            }
            return $next($request);
        });
    }

    public function index(){
        return view('backend.pages.user.index');
    }

    public function getList(Request $request){

        $data = User::query()->where('role', '4');
        if ($request->name) {
            $data->where(function($query) use ($request){
                $query->where('name','like', "%" .$request->name ."%" );
            });
        }

        if ($request->email) {
            $data->where(function($query) use ($request){
                $query->where('email','like', "%" .$request->email ."%" );
            });
        }

        if ($request->phone) {
            $data->where(function($query) use ($request){
                $query->where('phone','like', "%" .$request->phone ."%" );
            });
        }


        return Datatables::of($data)

        ->editColumn('profile_image', function ($row) {
            return ($row->profile_image) ? '<img class="profile-img" src="'.asset('uploads/user-images/'.$row->profile_image).'" alt="profile image">' : '<img class="profile-img" src="'.asset('assets/img/no-img.jpg').'" alt="profile image">';
        })

        ->editColumn('name', function ($row) {
            return '<a href="'.route('admin.user.details', ['id' => $row->id]).'">' .$row->name. '</a>';
        })

        ->editColumn('role', function ($row) {
            return optional($row->roles)->name;
        })

        ->editColumn('status', function ($row) {
            if ($row->status == 1) {
                return '<span class="badge bg-success-200 text-success-700 rounded-pill w-80">Active</span>';
            }else{
                return '<span class="badge bg-gray-200 text-gray-600 rounded-pill w-80">Inactive</span>';
            }
        })

        ->addColumn('action', function ($row) {
            $btn = '';
            if (Helper::hasRight('user.edit')) {
                $btn = $btn . '<a href="" data-id="'.$row->id.'" class="edit_btn btn btn-sm text-gray-900"><i class="fa-solid fa-pencil"></i></a>';
            }
            // if (Helper::hasRight('user.edit')) {
            //     $btn = $btn . '<a class="change_password btn btn-sm text-gray-900 mx-1 " data-id="'.$row->id.'" href="" title="Change Password"><i class="fa-solid fa-key"></i></a>';
            // }
            if (Helper::hasRight('user.delete')) {
                $btn = $btn . '<a class="delete_btn btn btn-sm text-gray-900" data-id="'.$row->id.'" href=""><i class="fa fa-trash" aria-hidden="true"></i></a>';
            }
            return $btn;
        })
        ->rawColumns(['profile_image','name','role','status','action'])->make(true);
    }

    public function store(Request $request){
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:user',
            'phone' => 'required|unique:user',
            // 'gender' => 'required',
            'address' => 'required',
            'profile_image' => 'required|image|mimes:jpg,png|max:20480'
		]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // $user->gender = $request->gender;
        $user->address = $request->address;
        $user->status  = ($request->status) ? 1 : 0;
        $user->role = 4;

        Helper::updateFileField($request, $user, 'profile_image', 'uploads/user-images/');
        if ($user->save()) {
            return response()->json([
                'type' => 'success',
                'message' => 'User created successfully.',
            ]);
        }
    }

    public function edit($id){
        $user = User::find($id);
        return view('backend.pages.user.edit', compact('user'));
    }

    public function update(Request $request, $id){
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:user,email,'.$id,
            'phone' => 'required|unique:user,phone,'.$id,
            // 'gender' => 'required',
            'address' => 'required',
            'profile_image' => 'image|mimes:jpg,png|max:20480'
		]);

        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // $user->gender = $request->gender;
        $user->address = $request->address;
        $user->status  = ($request->status) ? 1 : 0;

        Helper::updateFileField($request, $user, 'profile_image', 'uploads/user-images/');

        if ($user->save()) {
            return response()->json([
                'type' => 'success',
                'message' => 'User updated successfully.',
            ]);
        }else{
            return response()->json([
                'type' => 'success',
                'message' => 'Something went wrong.',
            ]);
        }
    }

    public function delete($id){
        $user = User::find($id);
        if($user){
            if ($user->profile_image != Null && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }
            $user->delete();
            return json_encode(['success' => 'User deleted successfully.']);
        }else{
            return json_encode(['error' => 'User not found.']);
        }
    }

    public function changePassword(Request $request){
        $validator = $request->validate([
			'password' => 'required|min:8|confirmed',
			'password_confirmation' => 'required'
		]);

        $user = User::find($request->user_id);
        if($user){
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'User password changed successfully.',
            ]);
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'User not found.',
            ]);
        }
    }

    public function userDetails($id){
        $user = User::find($id);
        $data = [
            'user' => $user
        ];
        return view('backend.pages.user.user_details', $data);
    }
}
