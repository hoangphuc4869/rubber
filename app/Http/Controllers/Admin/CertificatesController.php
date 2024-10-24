<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;

class CertificatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certificates = Certificate::all();
        return view("admin.certificates.index", compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'certificate_name' => 'required|string|max:255',
            'certificate_file' => 'required|file|mimes:pdf,jpg,png,jpeg',
        ]);

      
        $fileName = time() . '_' . $request->file('certificate_file')->getClientOriginalName();
        $filePath = $fileName;

       
        $request->file('certificate_file')->move(public_path('certificates_file'), $fileName);

        
        Certificate::create([
            'name' => $request->certificate_name,
            'file_path' => $filePath, 
        ]);

        return redirect()->route('certificates.index')->with('success', 'Chứng chỉ đã được thêm thành công!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('admin.certificates.edit', compact('certificate')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'certificate_name' => 'required|string|max:255',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,png,jpeg', // Make this nullable to allow updates without a new file
        ]);

       
        $certificate = Certificate::findOrFail($id);

       
        $certificate->name = $request->certificate_name;

       
        if ($request->hasFile('certificate_file')) {
            
            $fileName = time() . '_' . $request->file('certificate_file')->getClientOriginalName();
            
          
            $request->file('certificate_file')->move(public_path('certificates_file'), $fileName);

            
            $certificate->file_path = $fileName;
        }

       
        $certificate->save();

        return redirect()->route('certificates.index')->with('success', 'Chứng chỉ đã được cập nhật thành công!'); 
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);

        $filePath = public_path('certificates_file/'.$certificate->file_path); 
        if (file_exists($filePath)) {
            unlink($filePath); 
        }

        $certificate->delete(); 

        return redirect()->route('certificates.index')->with('success', 'Chứng chỉ đã được xóa thành công!');
    }
}