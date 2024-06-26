<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TransactionHistory;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TransactionHistoryController extends Controller
{
    public function index()
    {
        return view('backend.pages.transaction_history.index');
    }

    public function getList(Request $request)
    {
        $data = TransactionHistory::with('user')->get();

        return DataTables::of($data)
            ->addColumn('username', function ($row) {
                return $row->user->name;
            })
            ->editColumn('cause', function ($row) {
                if ($row->cause == "chat") {
                    return '<span class="badge bg-success-200 text-success-700 rounded-pill w-80">Chat</span>';
                } else {
                    return '<span class="badge bg-gray-200 text-gray-600 rounded-pill w-80">Premium</span>';
                }
            })
            ->editColumn('transaction_id', function ($row) {
                if ($row->transaction_id) {
                    return $row->transaction_id;
                } else {
                    return 'N/A';
                }
            })
            ->rawColumns(['username', 'cause'])->make(true);
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
            $video = new TransactionHistory();
            $video->title = $request->title;
            $video->short_description = $request->short_description;
            $video->embed_link = $request->embed_link;
            $video->status  = ($request->status) ? 1 : 0;
            $video->save();
    
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
        $video = TransactionHistory::find($id);
        return view('backend.pages.transaction_history.edit', compact('video'));
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
            $video = TransactionHistory::find($id);

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
        $video = TransactionHistory::find($id);

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