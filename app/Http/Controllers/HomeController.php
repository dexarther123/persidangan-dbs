<?php
  
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profil;
use App\Models\Kluster;
use App\Models\Usul;
use App\Charts\UmurChart;
use App\Charts\JantinaChart;
use Illuminate\Support\Carbon;


  
class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::check()){
            if(Auth::user()->type == 'president'){
                return redirect()->route('ikebs-dashboard');
            }elseif(Auth::user()->type == 'bendahari'){
                return redirect()->route('adbs-senarai-pilih-usul');
            }
        }
        return redirect('login');
    }

    public function adbs_profil()
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        if (!$user) {
            return abort(404); // Or handle the case where the user is not found
        }

        $profile = $user->profil; // Access the profile relationship


        return view('adbs.profil', ['profile' => $profile]);
    } 

    public function adbs_update_password (Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Validate the request data
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ], [
            'confirm_password.same' => 'Medan pengesahan kata laluan mesti sepadan dengan medan kata laluan baharu.',
        ]);

        // Check if the current password is correct
        if (!password_verify($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata laluan semasa tidak betul.']);
        }

        // Update the user's password
        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Kata laluan berjaya dikemas kini.');
    }
 
    public function adbs_dashboard()
    {
        return view('adbs.adbs-dashboard');
    }

    public function ikebs_dashboard(Request $request)
    {
        //umur chart =======================================================================================================
		$umur_chart = new UmurChart;
		$julat_umur = Profil::selectRaw('COUNT(*) as count, CASE 
			WHEN umur BETWEEN 15 AND 20 THEN "15-20"
			WHEN umur BETWEEN 21 AND 25 THEN "21-25"
			WHEN umur BETWEEN 26 AND 30 THEN "26-30"
			WHEN umur BETWEEN 31 AND 35 THEN "31-35"
		END as julat_umur')
		->groupBy('julat_umur')
		->get();

		$umur_chart->labels($julat_umur->pluck('julat_umur')->toArray());
		$umur_chart->dataset('Umur', 'bar', $julat_umur->pluck('count')->toArray())->backgroundColor('red');
		//==================================================================================================================		
		
		//jantina chart ====================================================================================================
		$jantina_chart = new JantinaChart;
        $lelaki = Profil::where('jantina','L')->count();
        $perempuan = Profil::where('jantina','P')->count(); 
        $jantina_chart->labels(['Lelaki', 'Perempuan']);
        $jantina_chart->dataset('Jantina', 'pie', [$lelaki, $perempuan])->backgroundColor(['blue','red']);
        $jantina_chart->options([
            'scales' => [
                'xAxes' => [
                    [
                        'display' => false,
                    ],
                ],
                'yAxes' => [
                    [
                        'display' => false,
                    ],
                ],
            ],
        ]);
		//==================================================================================================================

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
            $data = Usul::select('usuls.id', 'usuls.kluster_id', 'usuls.title')
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
                ->selectSub(function ($query) {
                    $query->selectRaw('COALESCE(SUM(CASE WHEN undian_usul.undi = "0" THEN 1 ELSE 0 END), 0)')
                        ->from('undian_usul')
                        ->whereColumn('undian_usul.usul_id', 'usuls.id');
                }, 'sokong_votes')
                ->selectSub(function ($query) {
                    $query->selectRaw('COALESCE(SUM(CASE WHEN undian_usul.undi = "1" THEN 1 ELSE 0 END), 0)')
                        ->from('undian_usul')
                        ->whereColumn('undian_usul.usul_id', 'usuls.id');
                }, 'tidak_sokong_votes')
                ->selectSub(function ($query) {
                    $query->selectRaw('COALESCE(SUM(CASE WHEN undian_usul.undi = "2" THEN 1 ELSE 0 END), 0)')
                        ->from('undian_usul')
                        ->whereColumn('undian_usul.usul_id', 'usuls.id');
                }, 'berkecuali_votes')
                ->selectRaw('(SELECT nama_kluster FROM klusters WHERE klusters.id = usuls.kluster_id) as kluster_name')
                ->selectRaw('ROW_NUMBER() OVER (ORDER BY usuls.id ASC) as no')
                ->groupBy('usuls.id', 'usuls.kluster_id', 'usuls.title','kluster_name')
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
                ->addIndexColumn()
                ->make(true);

        }
        return view('ikebs.ikebs-dashboard', compact('data_kluster','data_usulkluster','umur_chart','jantina_chart'));
    }

}