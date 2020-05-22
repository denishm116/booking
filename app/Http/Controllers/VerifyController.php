<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\{Mail\TutorialMail, User, Role};

class VerifyController extends Controller
{
    use RegistersUsers;
    private $user;

    public function __construct()
    {
        $this->user = session('user');
        $this->middleware('CheckActive');
    }

    public function getVerify()
    {

        return view('auth.verifysms');
    }

    public function requestNewCode()
    {
        $user = session('user');
        if (Carbon::now() > $user->time) {
            $user->updateCode();
            return redirect()->route('getVerify')->with('message', 'Код выслан повторно');
        } else {
            $diff_in_min = Carbon::now()->diffInMinutes($user->time) + 1;
            return redirect()->route('getVerify')->with('message', 'Повторно отправить код можно через ' . $diff_in_min . ' мин.');
        }
    }

    public function postVerify(Request $request)
    {
        $user = session('user');
        if ($user->codeIsCorrect($request->input('code'))) {
            Auth::login($user);
            $user = Auth::user();
            $user->activateUser();
            if ($user->hasRole(['owner']))
                Mail::to($user)->send(new TutorialMail($user));
            return redirect()->intended();
        } else {
            if ($user->addAttempt() < 5) {
                return back()->withMessage('Некорректный код подтверждения, осталось попыток ' . (5 - $user->attempt));
            } else {
                $diff_in_min = Carbon::now()->diffInMinutes($user->time) + 1;
                return back()->withMessage('Попробуйте заново через ' . $diff_in_min . ' мин');
            }
        }
    }


}

