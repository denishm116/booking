<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UsersRequest;
use App\Notifications\AdminMessage;
use App\Notifications\SendPassword;
use App\Role;
use App\SendCode;
use App\TouristObject;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckAdmin');
    }

    public function index(Request $request)
    {
        $sort = 'desc';
        if ($request->get('desc'))
            $sort = 'asc';
        $query = User::with(['roles', 'tobjects'])->orderBy('id', $sort);
        $users = $query->paginate(50);

        if ($request->get('checkUserObject') == 'usersWithoutObject')
            $users = $query->whereDoesntHave('tobjects')->whereHas('roles', function ($q) {
                $q->where('name', 'owner');
            })->paginate(50);

        if ($request->get('checkUserObject') == 'usersWithObject')
            $users = $query->has('tobjects')->paginate(50);

        if ($request->get('checkUserObject') == 'guests')
            $users = $query->whereHas('roles', function ($q) {
                $q->where('name', 'tourist');
            })->paginate(50);

        return view('backend.admin.users.index', compact('users'));

    }

    public function show($id)
    {
        $user = User::with(['objects', 'roles'])->where('id', $id)->first();
        return view('backend.admin.users.show', compact(['user']));
    }

    public function addUserForm($id = null)
    {
        $roles = Role::all();
        if ($id)
            $user = User::findOrFail($id);
        else
            $user = null;
        return view('backend.admin.users.add', compact(['roles', 'user']));
    }

    public function addUser(UsersRequest $request, $id = null)
    {

        if ($id) {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request['name'],
                'patronymic' => $request['patronymic'],
                'surname' => $request['surname'],
                'email' => $request['email'],
                'phone' => $request['phone'],
            ]);

        } else {
            $pass = strrev(substr($request['phone'], 1, 10));
            $code = rand(999, 9999);
            $user = User::create([
                'name' => $request['name'],
                'patronymic' => $request['patronymic'],
                'surname' => $request['surname'],
                'email' => $request['email'],
                'password' => bcrypt($pass),
                'phone' => $request['phone'],
                'code' => $code,
                'attempt' => 1,
                'time' => Carbon::now()->addSeconds(30),
                'active' => 0,
            ]);

        }
        $user->roles()->detach();
        $user->roles()->attach($request->input('roles'));
        if ($request->input('sendmail') && !$id)
            $user->notify(new SendPassword($pass));

            return redirect()->route('index');
    }

    public function activateUser($id)
    {
        $user = User::findOrFail($id);
        $user->activateUser();
        return redirect()->back()->with('message', 'Пользователь ' . $user->fullName . ' активирован');
    }

    public function removeUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $user->roles()->detach();
        return redirect()->route('index');
    }
    public function sendSms($phone, $message) {
        SendCode::sendAdminNotification($phone, $message);
        return 'Success';
    }

    public function sendEmail($email, $message) {
        $recipient = User::where('email', $email)->first();

        $recipient->notify(new AdminMessage($message));
        return 'Success';
    }

}
