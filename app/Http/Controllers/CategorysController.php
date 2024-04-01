<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Http\Requests\Category_addRequest;
use App\Http\Requests\Category_updateRequest;
use DB;

class CategorysController extends Controller
{

    public function category(Request $request)
    {
        
        $Categories = Categories::orderBy('created_at','DESC')->paginate(6);
        if($request->keyword){
            $Categories = Categories::orderBy('created_at','DESC')->where('name','like','%'.$request->keyword.'%')->paginate(6);
        }
      
        return view('admin.pages.category', compact('Categories'));
    }

    public function category_add()
    {
        $Categories = Categories::all();
        return view('admin.pages.category-add',compact('Categories'));
    }

    // create
    public function category_create(Category_addRequest $request)
    {
        $Categories = Categories::create($request->all());
       
        if ($Categories) {
            return redirect()->route('admin.category')->with('notification','Thêm Mới Thành Công');
        }
    }
    public function category_list($id)
    {
        $Category = DB::table('Categories')->where('parent_id',$id)->orderBy('id', 'DESC')->paginate(6);
        $Categories = Categories::all();
        return view('admin.pages.category_list', compact('Categories', 'Category'));
    }
    // update show
    public function category_update_show ($id)
    {
        $Category = Categories::find($id);
        $Categories = Categories::all();
        return view('admin.pages.category_update_show', compact('Categories', 'Category'));
        
    }
    public function category_update(Category_updateRequest $request,$id)
    {
        
        $Categories = Categories::find($id);
        $Categories->update($request->all());
        if ($Categories) {
            return redirect()->route('admin.category')->with('notification','Cập Nhật Thành Công');
        }
    }

    // delete
    public function category_delete($id)
    {
        $Categories = Categories::find($id)->delete();
        return redirect()->back()->with('notification','Xóa Thành Công');
    }
}
