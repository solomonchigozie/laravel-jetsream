<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\multiple;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;


class BrandController extends Controller
{
    public function __construct()
    {
        //check if user is logged in
        $this->middleware('auth');
    }
    
    public function Allbrand(){
        $brands = Brand::latest()->paginate(5);
        return view("admin.brand.index", compact('brands'));
    }

    public function StoreBrand(Request $request){
        //insert and add validation
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg,jpeg,png',
            ],
            [
                'brand_name.required' => 'Please Input brand Name',
                'brand_name.min' => 'brand is longer than 4 characters',
            ]
        );  

        $brand_image = $request->file('brand_image');
        //create auto generated id, to make the image unique
        //use laravel function hexdec

        // $name_gen = hexdec(uniqid());
        // $image_ext = strtolower($brand_image->getClientOriginalExtension()); //get the image extension

        // //add generated code
        // $image_name = $name_gen.'.'.$image_ext; //new image name

        // //upload image location
        // $up_location = "image/brand/";

        // //save image
        // $last_img = $up_location.$image_name;
        // $brand_image->move($up_location, $image_name);

        

        //using the intervention package

        $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300, 200)->save('image/brand/'.$name_gen);
        $last_img = 'image/brand/'.$name_gen;

        Brand::insert([
            'brand_name'=>$request->brand_name,
            'brand_image'=>$last_img,
            'created_at'=>Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Brand inserted successfully');

    }

    public function Edit($id){
        $brands = Brand::find($id);
        return view('admin.brand.edit', compact('brands'));
    }

    public function Update(Request $request, $id){
        //add validation
        $validated = $request->validate([
            'brand_name' => 'required|min:4',
            ],
            [
                'brand_name.required' => 'Please Input brand Name',
                'brand_name.min' => 'brand is longer than 4 characters',
            ]
        );
        
        $old_image = $request->old_image; //get old image

        $brand_image = $request->file('brand_image');
        //create auto generated id, to make the image unique
        //use laravel function hexdec
        if($brand_image){
            $name_gen = hexdec(uniqid());
            $image_ext = strtolower($brand_image->getClientOriginalExtension()); //get the image extension

            //add generated code
            $image_name = $name_gen.'.'.$image_ext; //new image name

            //upload image location
            $up_location = "image/brand/";

            //save image
            $last_img = $up_location.$image_name;
            $brand_image->move($up_location, $image_name);

            unlink($old_image); //remove old image, only works when there is an existing image

            Brand::find($id)->update([
                'brand_name'=>$request->brand_name,
                'brand_image'=>$last_img,
                'created_at'=>Carbon::now()
            ]);

            return Redirect()->back()->with('success', 'Brand updated successfully');
        }else{
            Brand::find($id)->update([
                'brand_name'=>$request->brand_name,
                'created_at'=>Carbon::now()
            ]);

            return Redirect()->back()->with('success', 'Brand updated successfully');
        }
        

    }

    public function Delete($id){
        //find image to delete it from the folder
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);//when the data is deleted, the image is deleted as well

        Brand::find($id)->delete();
        return Redirect()->back()->with('success', 'Brand Deleted');
    }

    public function Multipic(){
        $images = multiple::all();
        return view('admin.multipic.index', compact('images'));
    }

    public function StoreImg(Request $request){
        $image = $request->file('image');

        //for multiple upload, add foreach
        foreach($image as $multi_img){

    

            //using the intervention package

            $name_gen = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension();
            Image::make($multi_img)->resize(300, 200)->save('image/multi/'.$name_gen);
            $last_img = 'image/multi/'.$name_gen;

            multiple::insert([
                'image'=>$last_img,
                'created_at'=>Carbon::now()
            ]);
        }// end of for loop

        return Redirect()->back()->with('success', 'Image inserted successfully');
    }


}
