<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        //check if user is logged in
        $this->middleware('auth');
    }

    public function Allcat(){
        // $categories = Category::all(); //get all data from model
        // $categories = Category::latest()->get(); //get data in descending format
        $categories = Category::latest()->paginate(5); //pagination

        $trashCat = Category::onlyTrashed()->latest()->paginate(3);

        //query builder
        // $categories = DB::table('categories')->latest()->get();

        //to use pagination in querybuilder
        // $categories = DB::table('categories')->latest()->paginate(5);

        //join tables with query builder
        // $categories = DB::table('categories')
        //     ->join('users', 'categories.user_id', 'users.id')
        //     ->select('categories.*', 'users.name')
        //     ->latest()->paginate(5);
        
        return view('admin.category.index', compact('categories', 'trashCat'));
    }

    public function Addcat(Request $request){
        //insert and add validation

        //add validation
        $validated = $request->validate([
                'category_name' => 'required|unique:categories|max:255',
            ],
            [
                'category_name.required' => 'Please Input Category Name',
                'category_name.max' => 'Category is less than 255 characters',
            ]
        );

        //to use Eloquent ORM -=== Category is the Model Name
        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now()
        // ]);
        

        //USING ORM Method 2
        $category = new Category;
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        return Redirect()->back()->with('success', 'Category Inserted Successfully');

        //USING THE QUERY BUILDER
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

    
    }

    public function Edit($id){
        // $categories = Category::find($id);

        //query builder
        $categories = DB::table("categories")->where("id", $id)->first(); 
        return view('admin.category.edit', compact('categories'));
    }


    public function Update(Request $request, $id){
        //EORM
        // $update = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id
        // ]);

        //QUERY BUILDER
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table("categories")->where('id', $id)->update($data);

        return Redirect()->route('all.category')->with('success', 'Category Updated Successfully');

    }

    public function SoftDelete($id){
        $delete = Category::find($id)->delete();

        return Redirect()->back()->with('success', 'Category Soft Deleted Successfully');
    }

    public function Restore($id){
        $restore = Category::withTrashed()->find($id)->restore();

        return Redirect()->back()->with('success', 'Category Restored Successfully');
    }

    public function Pdelete($id){
        $pdelete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category Parmently Deleted');
    }


}
