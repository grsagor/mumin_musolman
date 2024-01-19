<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TruckType;
use App\Models\TruckTypeDetail;
use App\Models\User;
use Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AlluserController extends Controller
{
    public function index()
    {
        return view('backend.pages.all_user.index');
    }

    public function getList(Request $request){

        $data = User::query();
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
        $validator = $request->validate([
            'name' => 'required',
            'rent_type' => 'required',
            'rent_amount' => 'required',
            'driver_charge' => 'required',
            'image' => 'required|image|mimes:jpg,png|max:20480'
        ]);

        $truck_type = new TruckType();
        $truck_type->name = $request->name;
        $truck_type->rent_type = $request->rent_type;
        $truck_type->driver_charge = $request->driver_charge;
        $truck_type->status  = ($request->status) ? 1 : 0;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path('uploads/truck-images'), $filename);
            $truck_type->image = 'uploads/truck-images/' . $filename;
        }
        $truck_type->save();

        foreach ($request->rent_amount as $index => $value) {
            $details = new TruckTypeDetail();

            $details->truck_type_id = $truck_type->id;
            if ($request->rent_type == 'load') {
                $details->load_type = $request->load_type[$index];
            }
            $details->rent_amount = $value;

            $details->save();
        }

        return response()->json([
            'type' => 'success',
            'message' => 'Trucktype created successfully.',
        ]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $truck_details = TruckTypeDetail::with('truck_type')->find($id);
        return view('backend.pages.all_user.edit', compact('truck_details'));
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'rent_type' => 'required',
            'rent_amount' => 'required',
            'driver_charge' => 'required',
            'image' => 'image|mimes:jpg,png|max:20480'
        ]);

        $truck_type = TruckType::find($request->truck_type_id);
        $truck_type->name = $request->name;
        $truck_type->rent_type = $request->rent_type;
        $truck_type->driver_charge = $request->driver_charge;
        $truck_type->status  = ($request->status) ? 1 : 0;
        if ($request->hasFile('image')) {
            if ($truck_type->image != Null && file_exists(public_path($truck_type->image))) {
                unlink(public_path($truck_type->image));
            }
            $image = $request->file('image');
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path('uploads/truck-images'), $filename);
            $truck_type->image = 'uploads/truck-images/' . $filename;
        }
        $truck_type->save();

        $details = TruckTypeDetail::find($request->id);
        if ($request->rent_type == 'load') {
            $details->load_type = $request->load_type;
        }
        $details->rent_amount = $request->rent_amount;
        $details->save();

        if ($truck_type->save()) {
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