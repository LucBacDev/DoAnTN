<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use App\Models\Attribute_group;
use Illuminate\Http\Request;
use App\Http\Requests\Attributes_addRequest;

class AttributeController extends Controller
{
    public function attribute()
    {
        $Attribute = Attribute_group::all();
        return view('admin.pages.attribute', compact('Attribute'));
    }
    public function attribute_add()
    {
        $Attribute = Attribute_group::all();
        return view('admin.pages.attribute_add', compact('Attribute'));
    }
    public function attribute_create(Attributes_addRequest $request)
    {
        $Attribute = Attribute_group::create($request->all());
        if ($Attribute) {
            return redirect()->route('admin.attribute')->with('notification','Thêm Mới Thành Công');
        }
        
    }
    public function attribute_update_show ($id)
    {
        $Attribute = Attribute_group::find($id);
        return view('admin.pages.attribute_update_show',compact('Attribute'));
    }
    public function attribute_update(Attributes_addRequest $request,$id)
    {
        
        $Attribute = Attribute_group::find($id);
        $Attribute->update($request->all());
        if ($Attribute) {
            return redirect()->route('admin.attribute')->with('notification','Cập Nhật Thành Công');
        }
    }

    public function attribute_delete($id)
    {
        $Attribute = Attribute_group::find($id)->delete();
        return redirect()->back();

    }
}
