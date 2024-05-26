<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TruckType;
use App\Models\TruckTypeDetail;
use App\Models\User;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class AlluserController extends Controller
{
    public function index()
    {
        return view('backend.pages.all_user.index');
    }

    public function getList(Request $request){

        $data = User::query();
        if ($request->user_type) {
            if ($request->user_type == 'chat') {
                $data = $data->get()->filter(function ($user) {
                    return $user->chat == 1;
                });
            } elseif($request->user_type == 'premium') {
                $data = $data->get()->filter(function ($user) {
                    return $user->premium == 1;
                });
            } else {
                $data = $data->get()->filter(function ($user) {
                    return $user->premium == 0 && $user->chat == 0;
                });
            }
        } else {
            $data = $data->get();
        }
        


        return Datatables::of($data)

        ->editColumn('profile_image', function ($row) {
            return ($row->profile_image) ? '<img class="profile-img" src="'.asset('uploads/user-images/'.$row->profile_image).'" alt="profile image">' : '<img class="profile-img" src="'.asset('assets/img/no-img.jpg').'" alt="profile image">';
        })

        ->editColumn('name', function ($row) {
            return $row->name;
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
        ->rawColumns(['profile_image','name','status','action'])->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:user',
            'phone' => 'required|unique:user',
            'address' => 'required',
            'profile_image' => 'required|image|mimes:jpg,png|max:20480',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->dob = $request->dob;
        $user->password = Hash::make($request->password);
        $user->visible_password = $request->password;
        $user->status = 1;
        Helper::updateFileField($request, $user, 'profile_image', 'uploads/user-images/');

        if ($user->save()) {
            return response()->json([
                'type' => 'success',
                'message' => 'User created successfully.',
            ]);
        }
    }

    public function edit(Request $request)
    {
        $user = User::find($request->id);
        return view('backend.pages.all_user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:user,email,'.$request->id,
            'phone' => 'required|unique:user,phone,'.$request->id,
            'address' => 'required',
            'profile_image' => 'image|mimes:jpg,png|max:20480',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->dob = $request->dob;
        $user->password = Hash::make($request->password);
        $user->visible_password = $request->password;
        $user->status = 1;
        Helper::updateFileField($request, $user, 'profile_image', 'uploads/user-images/');

        if ($user->save()) {
            return response()->json([
                'type' => 'success',
                'message' => 'User updated successfully.',
            ]);
        } else {
            return response()->json([
                'type' => 'success',
                'message' => 'Something went wrong.',
            ]);
        }
    }

    public function delete(Request $request)
    {
        $details = TruckTypeDetail::find($request->id);
        $truck_type = TruckType::with('truck_type_details')->find($details->truck_type_id);
        $count = count($truck_type->truck_type_details) - 1;

        $details->delete();

        if (!$count) {
            if ($truck_type->image != Null && file_exists(public_path($truck_type->image))) {
                unlink(public_path($truck_type->image));
            }
            $truck_type->delete();
        }

        return response()->json([
            'type' => 'success',
            'message' => 'Truck deleted successfully.',
        ]);
    }
}