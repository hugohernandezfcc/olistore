<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/uploads');
            return response()->json(['url' => Storage::url($path)], 200);
        }
        return response()->json($request);
    }

    public function storeProductIcon(Request $request)
    {
        if ($request->hasFile('file')) {

            $filePath = Storage::putFileAs('products', $request->file('file'), $request->name);
            $fileUrl = Storage::url($filePath);
            
            $producto = Product::find($request->id);
            $producto->image = $fileUrl;
            $producto->contains_icon = true;
            $producto->save();

            return response()->json($producto, 200);
        }else{
            return response()->json(['error' => 'No file found'], 400);
        }
    }
    
    
    public function testing(){
        return Storage::get('file.txt');
    }
}