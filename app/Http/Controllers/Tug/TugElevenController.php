<?php

namespace App\Http\Controllers\Tug;

use App\Unit;
use App\BbmUsage;
use App\Models\Tug;
use App\Models\CoalUsage;
use Illuminate\Http\Request;
use App\Models\FuelAdjusment;
use App\Models\HeadWarehouse;
use App\Http\Controllers\Controller;

class TugElevenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data['heads'] = HeadWarehouse::all();
        $units = Unit::all();
        $coal = [];
        $solar = [];
        $residu = [];
        foreach ($units as $unit){
            $coalUsage = CoalUsage::where('unit_id', $unit->id)
            ->when($request->date, function ($query) use ($request) {
                $query->where('usage_date', $request->date);
            })
            ->sum('amount_use');

            $coal [] = $coalUsage == null ? 0 : $coalUsage;
        }

        foreach ($units as $unit){
            $solarUsage = BbmUsage::where('bbm_use_for','unit')->where('bbm_type','solar')->where('unit_uuid', $unit->uuid)
            ->when($request->date, function ($query) use ($request) {
                $query->where('use_date', $request->date);
            })
            ->sum('amount');

            $solar [] = $solarUsage == null ? 0 : $solarUsage;
        }

        foreach ($units as $unit){
            $residuUsage = BbmUsage::where('bbm_use_for','unit')->where('bbm_type','residu')->where('unit_uuid', $unit->uuid)
            ->when($request->date, function ($query) use ($request) {
                $query->where('use_date', $request->date);
            })
            ->sum('amount');

            $residu [] = $residuUsage == null ? 0 : $residuUsage;
        }

        $coalOther = FuelAdjusment::where('type_fuel','Batu Bara')->when($request->date, function ($query) use ($request) {
            $query->where('usage_date', $request->date);
        })->sum('usage_amount');

        $solarOther = BbmUsage::where('bbm_use_for','other')->where('bbm_type','solar')->when($request->date, function ($query) use ($request) {
            $query->where('use_date', $request->date);
        })->sum('amount');
        
        $solarHeavy = BbmUsage::where('bbm_use_for','heavy')->where('bbm_type','solar')->when($request->date, function ($query) use ($request) {
            $query->where('use_date', $request->date);
        })->sum('amount');
        $residuOther = BbmUsage::where('bbm_use_for','other')->where('bbm_type','residu')->when($request->date, function ($query) use ($request) {
            $query->where('use_date', $request->date);
        })->sum('amount');
        
        $data['coal'] = $coal;
        $data['coalOther'] = $coalOther;
        $data['solar'] = $solar;
        $data['solarOther'] = $solarOther;
        $data['solarHeavy'] = $solarHeavy;
        $data['residu'] = $residu;
        $data['residuOther'] = $residuOther;

        return view('inputs.tug-11.index',$data);

    }
    public function detail($id){

        $data['tug'] = Tug::where('id',$id)->first();
        return view('inputs.tug-11.index',$data);
    }
    public function destroy($id)
    {
        Tug::where('id', $id)->delete();
        return redirect(route('inputs.tug-11.index'))->with('success', 'Pembongkaran Batu Bara berhasil di hapus.');
    }
}
