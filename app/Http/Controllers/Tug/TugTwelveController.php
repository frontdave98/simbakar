<?php

namespace App\Http\Controllers\Tug;

use App\Models\Tug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TugTwelveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tugs = Tug::query();
        $tugs->where('tug',9)
        ->when($request->date, function ($query) use ($request) {
            $query->where('created_at', $request->date);
        });
        $data['tugs'] = $tugs->latest()->get()->chunk(6)->map(function ($item){
            return $item->pad(6,null);
        });
        return view('inputs.tug-12.index',$data);

    }
    public function detail($id){

        $data['tug'] = Tug::where('id',$id)->first();
        return view('inputs.tug-12.index',$data);
    }
    public function destroy($id)
    {
        Tug::where('id', $id)->delete();
        return redirect(route('inputs.tug-12.index'))->with('success', 'Pembongkaran Batu Bara berhasil di hapus.');
    }
}
