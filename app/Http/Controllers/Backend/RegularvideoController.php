<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationJob;
use App\Models\DeviceToken;
use App\Models\RegularAmolVideo;
use App\Models\User;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class RegularvideoController extends Controller
{
    public function index()
    {
        return view('backend.pages.regular_video.index');
    }

    public function getList(Request $request)
    {

        $data = RegularAmolVideo::all();

        return DataTables::of($data)

            ->editColumn('video', function ($row) {
                return '<iframe width="150" height="100" src="https://www.youtube.com/embed/' .$row->embed_link.'" title="1 minute introduction to islam" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
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
            ->rawColumns(['video', 'status', 'action'])->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'short_description' => 'required',
            'embed_link' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $video = new RegularAmolVideo();
            $video->title = $request->title;
            $video->short_description = $request->short_description;
            $video->embed_link = $request->embed_link;
            $video->status  = ($request->status) ? 1 : 0;
            $video->save();

            $users = DeviceToken::all();
            Helper::sendPushNotification(null, $request->title, $request->short_description);
    
            return response()->json([
                'type' => 'success',
                'message' => 'Video created successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'success',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $video = RegularAmolVideo::find($id);
        return view('backend.pages.regular_video.edit', compact('video'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'short_description' => 'required',
            'embed_link' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $id = $request->id;
            $video = RegularAmolVideo::find($id);

            $video->title = $request->title;
            $video->short_description = $request->short_description;
            $video->embed_link = $request->embed_link;
            $video->status  = ($request->status) ? 1 : 0;
            $video->save();
    
            return response()->json([
                'type' => 'success',
                'message' => 'Video updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'success',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $video = RegularAmolVideo::find($id);

        if ($video) {
            $video->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Video deleted.',
            ]);
        } else {
            return response()->json([
                'type' => 'success',
                'message' => 'No video fouond.',
            ]);
        }
    }
}