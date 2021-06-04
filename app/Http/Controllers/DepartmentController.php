<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
//query builder
//use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index(){
        //query data by eloquent
        // $departments = Department::all();

        //eloquent paging table
        $departments = Department::paginate(2);
        //query builder query data
        //$departments = DB::table('departments')->get();
        //query builder paging table
        //$departments = DB::table('departments')->paginate(3);

        //join table with query builder
        //DB::table('departments')
        //->join('users','departments.user_id','user_id')
        //->select('departments.*','users.name')->paginate(5);
        $trashDepartments = Department::onlyTrashed()->paginate(2);
        return view('admin.department.index',compact('departments','trashDepartments'));
    }

    public function store(Request $request){
        //validation
        $request->validate([
            'department_name'=>'required|unique:departments|max:255'
        ],
        [
            'department_name.required'=>"Please insert your department name.",
            'department_name.max'=>"Max characters is 255 characters.",
            'department_name.unique'=>"This department is already taker."
        ]);

        //insert data
        $department = new Department;
        $department->department_name = $request->department_name;
        $department->user_id = Auth::user()->id;
        $department->save();

        //query builder style
        //$data = array();
        //data["department_name"] = $request->department_name;
        //data["user_id"] = Auth::user_id;
        
        //DB::table('departments')->insert($data);
        return redirect()->back()->with('success','Insert data complete');
    }

    public function edit($id){
        //eloquent
        $department = Department::find($id);
        return view('admin.department.edit',compact('department'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'department_name'=>'required|unique:departments|max:255'
        ],
        [
            'department_name.required'=>"Please insert your department name.",
            'department_name.max'=>"Max characters is 255 characters.",
            'department_name.unique'=>"This department is already taker."
        ]);

        //update data
        $update = Department::find($id)->update([
            'department_name'=>$request->department_name,
            'user_id'=>Auth::user()->id
        ]);

        return redirect()->route('department')->with('success','Update department name success.');
    }

    public function softdelete($id){
        //eloquent
        $delete = Department::find($id)->delete();
        return redirect()->back()->with('success','Delete data success.');
    }

    public function restore($id){
        $restore = Department::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success','Restore data success.');
    }

    public function delete($id){
        $delete = Department::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success','Delete permanantly data success.');
    }
}
