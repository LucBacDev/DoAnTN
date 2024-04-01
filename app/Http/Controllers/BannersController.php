<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Requests\BannerRequest;




class BannersController extends Controller
{
    public function banners()
    {
        $banner = Banner::all();
        $category = Categories::all();
        return view('admin.pages.banners', compact('banner','category'));
    }
    public function banners_add()
    {
        $Category = Categories::all();
        return view('admin.pages.banners_add', compact('Category'));
    }
    
    public function banners_create(BannerRequest $req)
    {
        
        if ($req->hasFile('image')) {
            
            $file = $req->image;
            // get name
            $file_name = $file->getClientOriginalName();
            // go to folder
            $file->move('image_brands', $file_name);
        } else {
            $file_name = '';
        }
        
            Banner::create([
                'name' => $req->name,
                'image' => $file_name,
                'status' => $req->status,
                'category_id'=>$req-> category_id
            ]);
            return redirect()->route('admin.banners')->with('notification', 'Thêm mới thành công');
        
    }

    // show brands
    public function banners_update_show($id)
    {
        $banner = Banner::find($id);
        $category = Categories::all();
        return view('admin.pages.banners_update_show',compact('banner','category'));
    }

    // update brands
    public function banners_update_update (Request $req ,$id)
    {
        $Banner = Banner::find($id);
        if ($req->hasFile('image')) {
            $file = $req->image;
            // get name
            $file_name = $file->getClientOriginalName();
            // go to folder
            $file->move('image_brands', $file_name);
        } else {
            $file_name = $Banner->image;
        }
        try {
            $Banner->update([
                'name' => $req->name,
                'image' => $file_name,
                'status' => $req->status,
                'category_id' =>$req->category_id
            ]);
            return redirect()->route('admin.banners')->with('notification', 'Cập nhật thành công');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    // delete brands
    public function banners_delete($id)
    {
        $Banner = Banner::find($id)->delete();
        return redirect()->back()->with('notification','Xóa Thành Công');
    }
}
