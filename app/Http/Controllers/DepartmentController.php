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
        $departments = Department::paginate(3);
        //query builder query data
        //$departments = DB::table('departments')->get();
        //query builder paging table
        //$departments = DB::table('departments')->paginate(3);

        //join table with query builder
        //DB::table('departments')
        //->join('users','departments.user_id','user_id')
        //->select('departments.*','users.name')->paginate(5);
        return view('admin.department.index',compact('departments'));
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
}
