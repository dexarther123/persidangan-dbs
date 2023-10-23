<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserSession;
  
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
  
    use AuthenticatesUsers;
  
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request)
{
    $input = $request->all();

    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
        $user = auth()->user();
        $session_id = Session::getId();

        // Check if the user has an active session in the database
        $existingSession = UserSession::where('user_id', $user->id)->first();

        if ($existingSession) {
            // Log out the user from the existing session
            Session::getHandler()->destroy($existingSession->session_id);

            // Delete the existing session record from the database
            $existingSession->delete();
        }

        // Store the new session in the database
        UserSession::create([
            'user_id' => $user->id,
            'session_id' => $session_id,
        ]);

            if (auth()->user()->type == 'president') {
                return redirect()->route('ikebs-dashboard');
            }
            else if (auth()->user()->type == 'bendahari') {
                return redirect()->route('adbs-senarai-pilih-usul');
            }
            else{
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login')
                    ->with('error','Emel/Kata Laluan anda salah.');
        }
}
}