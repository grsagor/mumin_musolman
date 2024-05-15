<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationJob;
use App\Models\AmolVideo;
use App\Models\Channel;
use App\Models\DeviceToken;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MessagerequestController extends Controller
{
    public function index()
    {
        return view('backend.pages.message-request.index');
    }

    public function getList(Request $request)
    {

        $data = Channel::with('subscribers')->get();

        return DataTables::of($data)
            ->addColumn('user_id', function ($row) {
                return $row->subscribers[0]->user_id;
            })

            ->editColumn('status', function ($row) {
                if ($row->is_approved == 1) {
                    return '<span class="badge bg-success-200 text-success-700 rounded-pill w-80">Accepted</span>';
                } else if($row->is_approved == 0) {
                    return '<span class="badge bg-gray-200 text-gray-600 rounded-pill w-80">Pending</span>';
                } else if($row->is_approved == 2) {
                    return '<span class="badge bg-error-50 text-error-700 rounded-pill w-80">Canceled</span>';
                }
            })

            ->addColumn('action', function ($row) {
                $btn = '';
                if ($row->is_approved != 1) {
                    $btn = $btn . '<a title="accept" href="" data-id="' . $row->id . '" class="accept_btn btn btn-sm text-gray-900"><i class="fa-solid fa-circle-check"></i></a>';
                }
                if ($row->is_approved != 2) {
                    $btn = $btn . '<a title="cancel" class="cancel_btn btn btn-sm text-gray-900" data-id="' . $row->id . '" href=""><i class="fa-solid fa-xmark"></i></a>';
                }
                if (Helper::hasRight('truck_type.view')) {
                    $btn = $btn . '<a title="delete" class="delete_btn btn btn-sm text-gray-900" data-id="' . $row->id . '" href=""><i class="fa-solid fa-trash-can"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['user_id', 'status', 'action'])->make(true);
    }

    public function accept(Request $request)
    {
        $id = $request->id;
        $channel = Channel::find($id);

        if ($channel) {
            $channel->is_approved = 1;
            $channel->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Request accepted.',
            ]);
        } else {
            return response()->json([
                'type' => 'success',
                'message' => 'No chat fouond.',
            ]);
        }
    }
    public function cancel(Request $request)
    {
        $id = $request->id;
        $channel = Channel::find($id);

        if ($channel) {
            $channel->is_approved = 2;
            $channel->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Request canceled.',
            ]);
        } else {
            return response()->json([
                'type' => 'success',
                'message' => 'No chat fouond.',
            ]);
        }
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        $channel = Channel::find($id);

        if ($channel) {
            // $channel->is_approved = 2;
            $channel->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Request deleted.',
            ]);
        } else {
            return response()->json([
                'type' => 'success',
                'message' => 'No chat fouond.',
            ]);
        }
    }
}