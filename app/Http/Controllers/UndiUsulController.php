<?php

namespace App\Http\Controllers;
use App\Models\Kluster;
use App\Models\UndiUsul;
use App\Models\PilihUsul;
use App\Models\Usul;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UndiUsulController extends Controller
{

    public function adbs_senarai_usul(Request $request)
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
            $data = Usul::select('usuls.id', 'usuls.kluster_id', 'usuls.title', 'klusters.nama_kluster as kluster_name')
                        ->join('klusters', 'klusters.id', '=', 'usuls.kluster_id')
                        ->join(
                            Usul::raw('(SELECT id, kluster_id
                                    FROM usuls
                                    WHERE (kluster_id, total_dipilih) IN (
                                        SELECT kluster_id, MAX(total_dipilih) AS max_votes
                                        FROM usuls
                                        GROUP BY kluster_id
                                    )
                            ) as top_usuls'),
                            function ($join) {
                                $join->on('top_usuls.id', '=', 'usuls.id')
                                    ->on('top_usuls.kluster_id', '=', 'usuls.kluster_id');
                            }
                        )
    ->orderBy('usuls.id', 'ASC');

            $number = 1;
            return datatables()->of($data)
                ->editColumn('no', function ($data) use (&$number) {
                    return $number++;
                })
                ->filter(function ($instance) use ($request, $data_usul) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                           $search = $request->get('search');
                           $search = $request->get('search');
                            $w->orWhere('usuls.title', 'LIKE', "%$search%")
                            ->orWhere('klusters.nama_kluster', 'LIKE', "%$search%");
                       });
                   }
                })
                ->addColumn('action', function ($data) {
                    
                    // Check if the user has voted for the current 'usul_id'
                    $hasVoted = UndiUsul::where('user_id', Auth::user()->id)
                        ->where('usul_id', $data->id) // Assuming $data->id is the 'usul_id' for this row
                        ->exists();

                    $hasPilih = PilihUsul::where('adbs_id', Auth::user()->id)
                        ->exists();
                
                    if (!$hasVoted && $hasPilih) {
                        $button = '<a href="javascript:void(0)" data-id="'.$data->id.'" class="edit btn text-primary btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a>';
                    } else {
                        $button = '<p>-</p>';
                    }
                
                    return $button;
                })
                ->addIndexColumn()
                ->make(true);

        }
        return view('adbs.senarai_usul', compact('data_kluster','data_usulkluster'));
    }

    public function adbs_undi_usul(Request $request)
    {   
        $usul  = Usul::select('usuls.id', 'usuls.kluster_id', 'usuls.title')
        ->selectRaw('(SELECT nama_kluster FROM klusters WHERE klusters.id = usuls.kluster_id) as kluster_name')
        ->where('id', $request->id)->first();

        return Response()->json($usul);
    }

    public function adbs_store_undi(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'undi' => 'required',
        ]);
        $user = Auth::user();
        // Check if the user has already voted 8 times
        $userUndiCount = UndiUsul::where('user_id', $user->id)->count();
        if ($userUndiCount > 9) {
            return redirect()->route('adbs-undi')
                ->with('error', 'You have already voted 8 times. You cannot vote more.');
        }


        // Create a new Usul instance and set its attributes
        $undiusul = new UndiUsul();
        $undiusul->usul_id = $request->input('id_edit');
        $undiusul->user_id = Auth::user()->id;
        $undiusul->undi = $request->input('undi');
        $undiusul->save();

        // Optionally, you can redirect the user to a success page or a different location
        return redirect()->route('adbs-undi')->with('success', 'Usul created successfully');
    }
    
}
