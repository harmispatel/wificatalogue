<?php

namespace App\Http\Controllers;

use App\Imports\CategoryandItemsImport;
use App\Models\Shop;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    public function index()
    {
        $data['shops'] = Shop::get();
        return view('admin.import_export.import_export',$data);
    }

    public function importData(Request $request)
    {
        $request->validate([
            'shop' => 'required',
            'import' => 'required|mimes:xls,csv,xlsx',
        ]);

        $import = Excel::import(new CategoryandItemsImport($request->shop),$request->file('import'));

        if($import)
        {
            return redirect()->route('admin.import.export')->with('success',"Data has been Imported SuccessFully");
        }
    }
}
