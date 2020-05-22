<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\CartMail;
use Illuminate\Support\Facades\Mail;

class SendMail extends Controller
{

    public function sendMail($request, $mail)
    {
//        dd($request->session());
        Mail::to($mail)->send(new CartMail($request));
    }

        public function sendMailPicture()
    {
//        dd($request->session());
       return view('mail.tutorial');
    }




}
