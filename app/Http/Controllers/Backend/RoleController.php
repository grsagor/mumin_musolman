<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Role;
use App\Models\Right;
use App\Models\RoleRight;
use Helper;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            if (!$this->user || $this->user->role == 2 || Helper::hasRight('role.view') == false) {           
                session()->flash('error', 'You can not access! Login first.');
                return redirect()->route('admin');
            }
            return $next($request);
        });
    }

    public function index(){
        return view('backend.pages.role.index');
    }

    public function getRoleList(Request $request){
        $data = Role::all();
        return Datatables::of($data)

        ->addColumn('action', function ($row) {
            $btn = '';
            if (Helper::hasRight('role.edit')) {
                $btn = $btn . '<a href="'.route('admin.role.edit', $row->id).'" class="btn btn-sm btn-primary "><i class="fa-solid fa-pencil"></i></a>';
            }
            if (Helper::hasRight('role.delete')) {
                $btn = $btn . '<a class="delete_btn btn btn-sm btn-danger mx-1" data-id="'.$row->id.'" href=""><i class="fa fa-trash" aria-hidden="true"></i></a>';
            }
            return $btn;
        })
        ->rawColumns(['action'])->make(true);
    }

    public function create(){
        $rights = Right::select('module')->orderBy('module', 'asc')->distinct('module')->get();
        foreach ($rights as $row) {
            $row->rights = Right::where('module', $row->module)->get();
        }
        return view('backend.pages.role.create', compact('rights'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
			'role_name' => 'required',
		]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::firstOrNew(array('name' => $request->role_name));
        $role->name = $request->role_name;
        if ($role->save()) {
            foreach(Right::all() as $right){
                $role_right = RoleRight::firstOrNew(array('role_id' => $role->id, 'right_id' => $right->id));
                $role_right->role_id = $role->id;
                $role_right->right_id = $right->id;
                if (isset($request->permission["$right->module"]["$right->id"]) && isset($request->permission["$right->module"]["$right->id"]) == 1) {
                    $role_right->permission = 1;
                }else{
                    $role_right->permission = 0;
                }
                $role_right->save();
            }
            return redirect()->route('admin.role')->with('success', 'Role created successfully.');
        }
    }

    public function edit($id){
        if($role = Role::find($id)){
            $rights = Right::select('module')->orderBy('module', 'asc')->distinct('module')->get();
            foreach ($rights as $row) {
                $row->rights = Right::where('module', $row->module)->get();
            }
            return view('backend.pages.role.edit', compact('role', 'rights'));
        }else{
            return redirect()->route('admin.role')->with('error', 'Role not found.');
        }
    }

    public function update(Request $request, $id){
        $role = Role::find($id);
        foreach(Right::all() as $right){
            $role_right = RoleRight::firstOrNew(array('role_id' => $role->id, 'right_id' => $right->id));
            $role_right->role_id = $role->id;
            $role_right->right_id = $right->id;
            if (isset($request->permission["$right->module"]["$right->id"]) && isset($request->permission["$right->module"]["$right->id"]) == 1) {
                $role_right->permission = 1;
            }else{
                $role_right->permission = 0;
            }
            $role_right->save();
        }
        return redirect()->route('admin.role')->with('success', 'Role updated successfully.');
    }

    public function delete($id){
        $role = Role::find($id);
        if($role){
            $role_right = RoleRight::where('role_id', $id)->delete();
            if ($role_right) {
                $role->delete();
            }
            return json_encode(['success' => 'Role deleted successfully.']);
        }else{
            return json_encode(['error' => 'Role not found.']);
        }
    }

    // right function 
    public function right(){
        return view('backend.pages.right.index');
    }

    public function getRightList(Request $request){
        $data = Right::query();
        return Datatables::of($data)

        ->addColumn('action', function ($row) {
            $btn = '';
            if (Helper::hasRight('right.edit')) {
                $btn = $btn . '<a href="" data-id="'.$row->id.'" class="btn btn-sm btn-primary edit_btn"><i class="fa-solid fa-pencil"></i></a>';
            }
            if (Helper::hasRight('right.delete')) {
                $btn = $btn . '<a class="delete_btn btn btn-sm btn-danger mx-1" data-id="'.$row->id.'" href=""><i class="fa fa-trash" aria-hidden="true"></i></a>';
            }
            return $btn;
        })
        ->rawColumns(['action'])->make(true);
    }

    public function rightStore(Request $request){
        // $common_right = ['view', 'create', 'edit', 'delete'];
        // foreach($common_right as $key => $value){

            $name = trim($request->module_name).'.'.$request->right_name;

            $new_right = Right::firstOrNew(array('name' => $name));
            $new_right->name = $name;
            $new_right->module = trim($request->module_name);

            if ($new_right->save()) {
                return redirect()->route('admin.role.right')->with('success', 'Right added successfully.');
            }else{
                return redirect()->route('admin.role.right')->with('error', 'Something went wrong.');
            }
        // }
        // dd('right created');
    }

    public function editRight($id){
        if($right = Right::find($id)){            
            return view('backend.pages.right.edit', compact('right'));
        }else{
            return redirect()->route('admin.role.right')->with('error', 'Right not found.');
        }
    }

    public function roleRightUpdate(Request $request, $id){
        if($right = Right::find($id)){   
            $name = trim($request->module_name).'.'.$request->right_name;
            $right->name = $name;
            $right->module = trim($request->module_name);
            if ($right->save()) {
                return redirect()->route('admin.role.right')->with('success', 'Right added successfully.');
            }else{
                return redirect()->route('admin.role.right')->with('error', 'Something went wrong.');
            }
        }else{
            return redirect()->route('admin.role.right')->with('error', 'Right not found.');
        }
    }

    public function rightDelete($id){
        if($right = Right::find($id)){   
            $right->delete();
            return json_encode(['success' => 'Right deleted successfully.']);
        }else{
            return json_encode(['error' => 'Something went wrong.']);
        }
    }
}
