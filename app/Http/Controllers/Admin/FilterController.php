<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductsFilter;
use App\Models\ProductsFilterValue;
use App\Models\Section;
use DB;

class FilterController extends Controller
{
    public function filters()
    {
        $filters = ProductsFilter::get()->toArray();
        return view('admin.filter.filters')->with(compact('filters'));
    }

    public function filtersvalues()
    {
        $filters_values = ProductsFilterValue::get()->toArray();
        return view('admin.filter.filters_values')->with(compact('filters_values'));
    }

    
    /*------ Update Filter Status ------*/
    public function updateFilterStatus(Request $request)
    {   
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            if($data['status']=="active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsFilter::where('id',$data['filter_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
    }

    /*------ Update Filter Value Status ------*/
    public function updateFilterValueStatus(Request $request)
    {   
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            if($data['status']=="active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsFilterValue::where('id',$data['filter_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        }
    }

    /*------ Add Edit Filter ------*/
    public function addEditFilter(Request $request,$id=null)
    {
        if($id==""){
            $title = "Add Filter Columns";
            $filter = new ProductsFilter;
            $message = "Filter Added Successfully!";
        }else{
            $title = "Edit Filter Columns";
            $filter = ProductsFilter::find($id);
            $message = "Filter Updated Successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $cat_ids = implode(',',$data['cat_ids']);

            // save Filter Column details in products_filters_table
            $filter->cat_ids = $cat_ids;
            $filter->filter_name = ucfirst($data['filter_name']);
            $filter->filter_column = $data['filter_column'];
            $filter->save();

            // Add Filter Column in Products Table
            DB::statement('Alter table products add '. $data['filter_column'].' varchar(255) after description');
            return redirect('admin/filters')->with('message',$message);

        }

        // Get Sections with Categories and Sub Categories
        $categories = Section::with('categories')->get()->toArray();
        return view('admin.filter.add_edit_filters')->with(compact('title','categories','filter','message'));
        
    }

    /*------ Add Edit Filter Value ------*/
    public function addEditFilterValue(Request $request,$id=null)
    {
        if($id==""){
            $title = "Add Filter Value";
            $filter = new ProductsFilterValue;
            $message = "Filter Value Added Successfully!";
        }else{
            $title = "Edit Filter Value";
            $filter = ProductsFilterValue::find($id);
            $message = "Filter Value Updated Successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            // save Filter Column details in products_filters_table
            $filter->filter_id = $data['filter_id'];
            $filter->filter_value = ucfirst($data['filter_value']);
            $filter->save();

            return redirect('admin/filters-values')->with('message',$message);

        }

        // Get Filters
        $filters = ProductsFilter::where('status',1)->get()->toArray();

       return view('admin.filter.add_edit_filter_values')->with(compact('title','filter','filters','message'));
        
    }

    /*------ Category Filter ------*/
    public function categoryFilters(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            
            $category_id = $data['category_id'];
            return response()->json(['view'=>(String)View::make('admin.filter.category_filters')->with(compact('category_id'))]);
        }
    }

    
    public function destroy($id)
    {
        ProductsFilter::where('id',$id)->delete();
        return redirect()->back()->with('message','Section has been deleted Successfully!');
    }

}
