<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Data;
use App\Exports\DataExport;
use App\Imports\DataImport;
use Illuminate\Http\Request;
use Phpml\Clustering\KMeans;
use App\Models\OptionCluster;
use Illuminate\Support\Facades\DB;
use Phpml\Math\Distance\Euclidean;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    public function home(){
        return view('pages.home');
    }

    public function data(){
        $data = Data::paginate(20);
        return view('pages.data',compact('data'));
    }

    public function import(Request $request) {
        try {
            Excel::import(new DataImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data berhasil di Import');
        } catch (\Exception $e) {
            return redirect('/data')->with('error', 'Data gagal di Import, pastikan judul kolom dan tipe data sudah sesuai');
        }
    }

    public function export(Request $request) {
        return (new DataExport)->download('data-'.Carbon::now()->timestamp.'.xlsx');
    }

    public function deleteData()
    {
        try {
            DB::table('data')->truncate();
            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }
}
