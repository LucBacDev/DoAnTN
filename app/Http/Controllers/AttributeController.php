<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use Attribute;
use Illuminate\Http\Request;
use App\Http\Requests\Attributes_addRequest;

class AttributeController extends Controller
{
    public function attribute()
    {
        $Attribute = Attributes::all();
        return view('admin.pages.attribute', compact('Attribute'));
    }
    public function attribute_add()
    {
        return view('admin.pages.attribute_add');
    }
    public function attribute_create(Attributes_addRequest $request)
    {
        $Attribute = Attributes::create($request->all());
        if ($Attribute) {
            return redirect()->route('admin.attribute')->with('notification','Thêm Mới Thành Công');
        }
        
    }
    public function attribute_update_show ($id)
    {
        $Attribute = Attributes::find($id);
        return view('admin.pages.attribute_update_show',compact('Attribute'));
    }
    public function attribute_delete($id)
    {
        $Attribute = Attributes::find($id)->delete();
        return redirect()->back();

    }
}
