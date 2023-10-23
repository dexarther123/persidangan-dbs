<?php

namespace App\Http\Controllers;

use App\Models\Kluster;
use App\Models\UndianUsul;
use App\Models\User;
use App\Models\Usul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class UsulController extends Controller
{

    public function ikebs_senarai_usul(Request $request)
    {
        $data_kluster = Kluster::select('id','nama_kluster')
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
            $data = Usul::select('usuls.id', 'usuls.kluster_id', 'usuls.title', 'usuls.total_dipilih')
            ->selectRaw('(SELECT nama_kluster FROM klusters WHERE klusters.id = usuls.kluster_id) as kluster_name')
            ->orderBy('id', 'DESC');

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
                    $button = '';
                    $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="edit btn text-primary btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a>';
                    return $button;
                })
                ->addIndexColumn()
                ->make(true);

        }
        return view('ikebs.usuls', compact('data_kluster','data_usulkluster'));
    }

    public function ikebs_update_usul(Request $request)
    {

        $id= $request->id_edit;
        $usul = Usul::find($id);
        if($id)
        {
            $nama_kluster= $request->kluster_edit;
            $id_kluster = Kluster::where('nama_kluster', $nama_kluster)
                            ->pluck('id')
                            ->first();
            $usul->kluster_id= $id_kluster;
            $usul->title= $request->title_edit;
            $usul->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $usul->update();
        }
        
        return Response()->json($usul);
    }

    public function ikebs_store_usul(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required',
            'kluster_id' => 'required|exists:klusters,id', // Ensure kluster_id exists in the kluster table
        ]);

        $usul = new Usul();
        $usul->title = $request->input('title');
        $usul->kluster_id = $request->input('kluster_id');
        $usul->save();

        // Optionally, you can redirect the user to a success page or a different location
        return redirect()->route('ikebs-senarai-usul')->with('success', 'Usul created successfully');
    } 

    public function ikebs_edit_usul(Request $request)
    {   
        $usul  = Usul::select('usuls.id', 'usuls.kluster_id', 'usuls.title')
        ->selectRaw('(SELECT nama_kluster FROM klusters WHERE klusters.id = usuls.kluster_id) as kluster_name')
        ->where('id', $request->id)->first();

        return Response()->json($usul);
    }


}
