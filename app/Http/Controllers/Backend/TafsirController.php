<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tafsir;
use App\Models\TruckType;
use App\Models\TruckTypeDetail;
use Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TafsirController extends Controller
{
    public function index()
    {
        return view('backend.pages.tafsir.index');
    }

    public function getList(Request $request)
    {

        $data = Tafsir::all();

        return DataTables::of($data)

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
            ->rawColumns(['status', 'action'])->make(true);
    }

    public function store(Request $request)
    {
        $tafsir = new Tafsir();

        $tafsir->sura_no = $request->sura_no;
        $tafsir->ayat_no = $request->ayat_no;
        $tafsir->jakariya_heading = $request->jakariya_heading;
        $tafsir->jakariya_tafsir = $request->jakariya_tafsir;
        $tafsir->majid_heading = $request->majid_heading;
        $tafsir->majid_tafsir = $request->majid_tafsir;
        $tafsir->ahsanul_heading = $request->ahsanul_heading;
        $tafsir->ahsanul_tafsir = $request->ahsanul_tafsir;
        $tafsir->kasir_heading = $request->kasir_heading;
        $tafsir->kasir_tafsir = $request->kasir_tafsir;
        $tafsir->other_heading = $request->other_heading;
        $tafsir->other_tafsir = $request->other_tafsir;
        $tafsir->status  = ($request->status) ? 1 : 0;
        $tafsir->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Tafsir created successfully.',
        ]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $tafsir = Tafsir::find($id);
        return view('backend.pages.tafsir.edit', compact('tafsir'));
    }

    public function update(Request $request)
    {
        $tafsir = Tafsir::find($request->id);

        $tafsir->sura_no = $request->sura_no;
        $tafsir->ayat_no = $request->ayat_no;
        $tafsir->jakariya_heading = $request->jakariya_heading;
        $tafsir->jakariya_tafsir = $request->jakariya_tafsir;
        $tafsir->majid_heading = $request->majid_heading;
        $tafsir->majid_tafsir = $request->majid_tafsir;
        $tafsir->ahsanul_heading = $request->ahsanul_heading;
        $tafsir->ahsanul_tafsir = $request->ahsanul_tafsir;
        $tafsir->kasir_heading = $request->kasir_heading;
        $tafsir->kasir_tafsir = $request->kasir_tafsir;
        $tafsir->other_heading = $request->other_heading;
        $tafsir->other_tafsir = $request->other_tafsir;
        $tafsir->status  = ($request->status) ? 1 : 0;

        if ($tafsir->save()) {
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
        $tafsir = Tafsir::find($request->id);

        if ($tafsir) {
            $tafsir->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Truck deleted successfully.',
            ]);
        }
    }
}