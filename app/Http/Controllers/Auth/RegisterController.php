<?php


namespace App\Http\Controllers\Auth;

use App\{Mail\TutorialMail, User, Role};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\SendCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{


    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function register(Request $request)
    {



        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|alpha|max:255',
            'surname' => 'required|alpha|max:255',
            'patronymic' => 'max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|min:10|max:13|unique:users',
        ]);
    }

    protected function create(array $data)
    {

//dd($data);
        $code = rand(999, 9999);
        $user = User::create([
            'name' => $data['name'],
            'patronymic' => $data['patronymic'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'code' => $code,
            'attempt' => 1,
            'time' => Carbon::now()->addSeconds(30),
            'active' => 0,
        ]);

        if (!Role::where('name', 'owner')->exists()) {
            Role::create(['name' => 'owner']);
            Role::create(['name' => 'tourist']);
            Role::create(['name' => 'admin']);
        }

        if ($data['owner'] ?? 0) {
            $user->roles()->attach(Role::where('name', 'owner')->first()->id);


//            Mail::to($data['email'])->send(new TutorialMail($user));
        } else {
            $user->roles()->attach(Role::where('name', 'tourist')->first()->id);
        }
        return $user;
    }

    protected function registered(Request $request, $user)
    {

        if (!$user->isActive()) {
            try {
                $sendCode = new SendCode();
                $smsResponse = $sendCode->sendCode($request['phone'], $user->code);
                if ($smsResponse->code !== "100") {
                    $user->delete();
                    return redirect()->back()->with('message', 'Что то пошло не так, попробуйте, пожалуйста, еще раз');
                } else {
                    $this->guard()->login($user);
                    session()->put('user', $user);
                    return redirect()->route('getVerify');
                }

            } catch (\DomainException $e) {
                return back()->with('message', $e->getMessage());
            }

        }
        $this->guard()->login($user);
        return redirect()->intended(route('home'));
    }
}

