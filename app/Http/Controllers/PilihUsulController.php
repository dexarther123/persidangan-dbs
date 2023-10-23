<?php

namespace App\Http\Controllers;
use App\Models\Kluster;
use App\Models\PilihUsul;
use App\Models\Usul;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PilihUsulController extends Controller
{
    public function adbs_senarai_pilih_usul(Request $request)
    {
        $data_klusters = Kluster::select('id','nama_kluster')
        ->orderBy('id', 'ASC')
        ->get();

        $data_usulkluster = Usul::select('usuls.kluster_id', 'klusters.nama_kluster')
        ->join('klusters', 'usuls.kluster_id', '=', 'klusters.id')
        ->groupBy('usuls.kluster_id', 'klusters.nama_kluster')
        ->orderBy('klusters.id', 'ASC')
        ->get();

        $data_usul = Usul::select('kluster_id')
        ->orderBy('kluster_id', 'ASC')
        ->get();
        

        if ($request->ajax()) 
        {
            $data = Usul::select('usuls.id', 'usuls.kluster_id', 'usuls.title')
            ->selectRaw('(SELECT nama_kluster FROM klusters WHERE klusters.id = usuls.kluster_id) as kluster_name')
            ->orderBy('id', 'ASC');

            $number = 1;
            return datatables()->of($data)
                ->editColumn('no', function ($data) use (&$number) {
                    return $number++;
                })
                ->filter(function ($instance) use ($request, $data_usul) {
                    $filter_kluster = $request->get('filter_kluster');
                    if (!empty($filter_kluster) && $data_usul->contains('kluster_id', $filter_kluster)) {
                        $instance->where('kluster_id', $filter_kluster);
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                           $search = $request->get('search');
                           $w->orWhere('title', 'LIKE', "%$search%");
                       });
                   }
                })
                ->addColumn('action', function ($data) {
                        $button = '<input type="checkbox" class="usulCheckbox" data-title="'.$data->title.'" data-id="'.$data->id.'" ${isChecked}>';
                    return $button;
                })
                ->addIndexColumn()
                ->make(true);

        }
        return view('adbs.senarai_pilih_usul', compact('data_klusters','data_usulkluster'));
    }


    public function adbs_undi_usul(Request $request)
    {   
        $usul  = Usul::select('usuls.id', 'usuls.kluster_id', 'usuls.title')
        ->selectRaw('(SELECT nama_kluster FROM klusters WHERE klusters.id = usuls.kluster_id) as kluster_name')
        ->where('id', $request->id)->first();

        return Response()->json($usul);
    }

    public function adbs_store_pilih_usul(Request $request)
    {
        $usulIds = $request->input('checkedUsulIds');

        // Convert the comma-separated string to an array of integers
        $usulIdsArray = array_map('intval', explode(',', $usulIds));

        $user = Auth::user();

        if (PilihUsul::where('adbs_id', $user->id)->exists()) {
            return response()->json(['message' => 'Maaf, anda telah hantar pilihan usul anda.', 'status' => 'error']);
        }

        $pilihusul = new PilihUsul;
        $pilihusul->adbs_id = $user->id;
        // Convert the array back to a comma-separated string if needed
        $pilihusul->selected_usuls = implode(',', $usulIdsArray);

        // Save the record
        $pilihusul->save();
        

        Usul::whereIn('id', $usulIdsArray)->increment('total_dipilih');

        return response()->json(['message' => 'Anda telah berjaya hantar pilihan usul anda.', 'status' => 'success']);

    }
    
}
