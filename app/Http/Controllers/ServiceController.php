<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index(){
        $services = Service::paginate(2);
        return view('admin.service.index',compact('services'));
    }

    public function store(Request $request){
        $request->validate([
            'service_name'=>'required|unique:services|max:255',
            'service_image'=>'required|mimes:jpg,jpeg,png'
        ],
        [
            'service_name.required'=>"Please insert your service name.",
            'service_name.max'=>"Max characters is 255 characters.",
            'service_name.unique'=>"This service is already taker.",
            'service_image.required'=>"Please insert your service image.",
            'service_image.mimes'=>"Your file is not correct type."
        ]);

        //encode image
        $service_image = $request->file('service_image');
        //generate image name
        $name_gen = hexdec(uniqid());
        
        //call image type
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        
        $img_name = $name_gen.'.'.$img_ext;
        
        //upload and insert data
        $upload_location = 'image/service/';
        $full_path = $upload_location.$img_name;

        Service::insert([
            'service_name'=>$request->service_name,
            'service_image'=>$full_path,
            'created_at'=>Carbon::now()
        ]);
        $service_image->move($upload_location,$img_name);
        return redirect()->back()->with('success','Insert data complete');

    }

    public function edit($id){
        $service = Service::find($id);
        return view('admin.service.edit',compact('service'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'service_name'=>'required|max:255',
            'service_image'=>'mimes:jpg,jpeg,png'
        ],
        [
            'service_name.required'=>"Please insert your service image.",
            'service_name.max'=>"Max characters is 255 characters.",
            'service_image.mimes'=>"Your file is not correct type."
        ]);

        $service_image = $request->file('service_image');

        //update name and image
        if($service_image){
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            
            $img_name = $name_gen.'.'.$img_ext;

            $upload_location = 'image/service/';
            $full_path = $upload_location.$img_name;

            Service::find($id)->update([
                'service_name'=>$request->service_name,
                'service_image'=>$full_path
            ]);

            //delete old pic and upload new pic
            $old_image = $request->old_image;
            unlink($old_image);
            $service_image->move($upload_location,$img_name);
            return redirect()->route('service')->with('success','Update picture service complete');
        }else{
            Service::find($id)->update([
                'service_name'=>$request->service_name,
            ]);
            return redirect()->route('service')->with('success','Update name service complete');
        }
    }

    public function delete($id){

        //must delete pic before
        $img = Service::find($id)->service_image;
        unlink($img);

        $delete = Service::find($id)->delete();
        return redirect()->back()->with('success','Delete permanantly service success.');
    }

}
