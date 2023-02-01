<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
    
    public function sections()
    {
        $sections = Section::get()->toArray();
        // dd($sections);
        return view('admin.section.sections')->with(compact('sections'));
    }

    
    public function create()
    {
        return view('admin.section.add');
    }

    
    public function store(Request $request)
    {
        $request->validate(
            [
                'section_name' => 'required|regex:/^[\pL\s\-]+$/u',
                
            ],
            [
                'section_name.required' => 'Section Name is required',
                'section_name.regex' => 'Valid name is required',
            ],   
        );

        Section::insert([
            'section_name' => ucfirst($request->section_name),
            
        ]);

        return redirect()->route('sections')->with('message','Section Created Successfully!');

    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $sections = Section::find($id)->toarray();
        if($sections)
        {
            return view('admin.section.edit',compact('sections'));
        }
        else
        {
            return back()->with('message','Data Not Found');
        }
    }

    
    public function update(Request $request)
    {
        $sections_id = $request->sections_id; 

        $request->validate(
            [
                'section_name' => 'required|regex:/^[\pL\s\-]+$/u',
                
            ],
            [
                'section_name.required' => 'Section Name is required',
                'section_name.regex' => 'Valid name is required',
            ]   
        );

        // Section::find($sections_id)->update([
        //     'section_name' =>ucfirst($request->section_name),
            
        // ]); 
        
        $sections = Section::find($sections_id);
        $sections->section_name = ucfirst($request->section_name);
        $sections->save();

        return redirect()->route('sections')->with('message','Section Updated Successfully!');
   
    }


     /*------ Update Section Status ------*/
    public function updateSectionStatus(Request $request)
    {   
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die; 
            if($data['status']=="active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Section::where('id',$data['section_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);
        }
    }

    
    public function destroy($id)
    {
        Section::where('id',$id)->delete();
        return redirect()->back()->with('message','Section has been deleted Successfully!');
    }
    
}
