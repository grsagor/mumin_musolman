<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CustomAd;
use App\Models\TruckType;
use App\Models\TruckTypeDetail;
use Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomadsController extends Controller
{
    public function index()
    {
        return view('backend.pages.custom_ads.index');
    }

    public function getList(Request $request)
    {

        $data = CustomAd::all();

        return DataTables::of($data)

            ->editColumn('image', function ($row) {
                return ($row->image) ? '<img class="object-fit-cover" width="120" height="80" src="' . asset($row->image) . '" alt="profile image">' : '<img class="profile-img" src="' . asset('assets/img/no-img.jpg') . '" alt="profile image">';
            })

            ->editColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge bg-success-200 text-success-700 rounded-pill w-80">Active</span>';
                } else {
                    return '<span class="badge bg-gray-200 text-gray-600 rounded-pill w-80">Inactive</span>';
                }
            })

            ->addColumn('action', function ($row) {
                $btn = '';
                if (Helper::hasRight('truck_type.view')) {
                    $btn = $btn . '<a href="" data-id="' . $row->id . '" class="edit_btn btn btn-sm text-gray-900"><i class="fa-solid fa-pencil"></i></a>';
                }
                if (Helper::hasRight('truck_type.view')) {
                    $btn = $btn . '<a class="delete_btn btn btn-sm text-gray-900" data-id="' . $row->id . '" href=""><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['image', 'status', 'action'])->make(true);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'ad_no' => 'required|unique:custom_ads',
            'link' => 'required',
            'image' => 'required|image|mimes:jpg,png|max:20480'
        ]);

        $custom_ad = new CustomAd();
        $custom_ad->ad_no = $request->ad_no;
        $custom_ad->link = $request->link;
        $custom_ad->status  = ($request->status) ? 1 : 0;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path('uploads/customad-images'), $filename);
            $custom_ad->image = 'uploads/customad-images/' . $filename;
        }
        $custom_ad->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Custom ad created successfully.',
        ]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $ad = CustomAd::find($id);
        return view('backend.pages.custom_ads.edit', compact('ad'));
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'ad_no' => 'required|unique:custom_ads',
            'link' => 'required',
            'image' => 'image|mimes:jpg,png|max:20480'
        ]);

        try {    
            $custom_ad = CustomAd::find($request->id);
            $custom_ad->ad_no = $request->ad_no;
            $custom_ad->link = $request->link;
            $custom_ad->status  = ($request->status) ? 1 : 0;
            if ($request->hasFile('image')) {
                if ($custom_ad->image != Null && file_exists(public_path($custom_ad->image))) {
                    unlink(public_path($custom_ad->image));
                }
                $image = $request->file('image');
                $filename = time() . uniqid() . $image->getClientOriginalName();
                $image->move(public_path('uploads/customad-images'), $filename);
                $custom_ad->image = 'uploads/customad-images/' . $filename;
            }
            $custom_ad->save();
    
            return response()->json([
                'type' => 'success',
                'message' => 'Custom ad created successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request)
    {
        $custom_ad = CustomAd::find($request->id);


        if ($custom_ad) {
            if ($custom_ad->image != Null && file_exists(public_path($custom_ad->image))) {
                unlink(public_path($custom_ad->image));
            }
            $custom_ad->delete();

            return response()->json([
                'type' => 'success',
                'message' => 'Custom ad deleted successfully.',
            ]);
        } else {
            return response()->json([
                'type' => 'error',
                'message' => 'Custom ad does not found.',
            ]);
        }
    }
}