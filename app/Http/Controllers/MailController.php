<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendStatus()
    {
        $data = [
            'subject' => 'Rencana Aggaran Belanja',
            "body" => ""
        ];

        try {
            Mail::to('afifhibatullah59@gmail.com')->send(new MailNotify($data));

            return \response()->json(['msg' => 'Status RAB telah dikirim ke pembuat RAB']);
        } catch (\Throwable $th) {
            return \response()->json(['msg' => 'Maaf, terjadi kesalahan']);
        }
    }
}
