<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use App\Models\Attribute_group;
use Illuminate\Http\Request;
use App\Http\Requests\Attributes_add_colorRequest;
use App\Http\Requests\Attributes_add_sizeRequest;
use App\Http\Requests\Attributes_addRequest;



class AttributeController extends Controller
{
    public function attribute()
    {
        $Attribute_group = Attribute_group::all();
        $Attribute = Attributes::all();
        return view('admin.pages.attribute', compact('Attribute_group','Attribute'));
    }
    public function attribute_add_color()
    {
        $Attribute = Attribute_group::all();
        return view('admin.pages.attribute_add_color', compact('Attribute'));
    }
    public function attribute_add_size()
    {
        $Attribute = Attribute_group::all();
        return view('admin.pages.attribute_add_size', compact('Attribute'));
    }
    // public function attribute_create(Attributes_addRequest $request)
    public function attribute_create_color(Attributes_add_colorRequest $request)
    {
        $Attribute_group_color = Attribute_group::where('name','Màu sắc')->first();
        if ($request->has('name')) {
            foreach ($request->name as $name) {
                $Attribute = Attributes::create([
                    'attribute_group_id' => $Attribute_group_color->id,
                    'name' => $name,
                ]);
            }
        }
        if ($Attribute_group_color) {
            return redirect()->route('admin.attribute')->with('notification','Thêm Mới Thành Công');
        }
        
    }
    public function attribute_create_size(Attributes_add_sizeRequest $request)
    {
        $Attribute_group_size = Attribute_group::where('name','Size')->first();
        if ($request->has('name')) {
            foreach ($request->name as $name) {
                $Attribute = Attributes::create([
                    'attribute_group_id' => $Attribute_group_size->id,
                    'name' => $name,
                ]);
            }
        }
        if ($Attribute  ) {
            return redirect()->route('admin.attribute')->with('notification','Thêm Mới Thành Công');
        }
        
    }
    public function attribute_update_show ($id)
    {
        // Lấy thông tin nhóm thuộc tính và các thuộc tính của nó dựa trên ID
        $attribute_group = Attribute_group::findOrFail($id);
        $attributes = Attributes::where('attribute_group_id', $id)->get();

        // Trả về view sửa thuộc tính với dữ liệu nhóm thuộc tính và các thuộc tính của nó
        return view('admin.pages.attribute_update_show', compact('attribute_group', 'attributes'));
    }
    public function attribute_update(Attributes_addRequest $request, $id)
    {
        // Lấy thông tin nhóm thuộc tính dựa trên ID
        $attribute_group = Attribute_group::findOrFail($id);
    
        // Lấy các thuộc tính hiện tại của nhóm thuộc tính
        $existingAttributes = Attributes::where('attribute_group_id', $id)->get();
    
        // Danh sách các tên thuộc tính mới từ request
        $newNames = $request->name ?? [];
    
        // Lấy danh sách các tên thuộc tính hiện tại
        $existingNames = $existingAttributes->pluck('name')->toArray();
    
        // Danh sách các tên cần xóa (soft delete)
        $namesToDelete = array_diff($existingNames, $newNames);
    
        // Soft delete các thuộc tính không còn tồn tại trong danh sách mới
        Attributes::where('attribute_group_id', $id)
            ->whereIn('name', $namesToDelete)
            ->delete();
    
        // Lưu các thuộc tính mới của nhóm vào cơ sở dữ liệu
        foreach ($newNames as $name) {
            Attributes::updateOrCreate(
                ['attribute_group_id' => $id, 'name' => $name],
                ['name' => $name]
            );
        }
    
        // Redirect hoặc trả về view nào đó sau khi cập nhật thành công
        return redirect()->route('admin.attribute')->with('notification', 'Cập nhật Thành Công');
    }

    public function attribute_delete($id)
    {
        $Attribute = Attribute_group::find($id)->delete();
        return redirect()->back();

    }
}
