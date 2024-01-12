<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Mail;

class ContactController extends Controller
{
    public function store(Request $request) 
    {
        $data = Contact::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        if ($this->sendContactForm($data)) {
            return response()->json([
                'message' => 'contact has been sent!'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error!'
            ], 400);
        }
    }

    private function sendContactForm($d) 
    {
        try {
            $data = [
                'first_name' => $d->first_name,
                'last_name' => $d->last_name,
                'email' => $d->email,
                'subject' => $d->subject,
                'text' => $d->message,
            ];

            Mail::send('email.contact', $data, function ($message) use ($data) {
                $message->to('spicyburns90@gmail.com', 'Calcium & Joyjoy - Contact Us')
                    ->from($data['email'], $data['first_name'] . ' ' . $data['last_name'])
                    ->subject($data['subject']);
            });
    
            return true;
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            \Log::error($e->getMessage());
            return false;
        }
    }

    public function index()
    {
        return Contact::all();
    }

    public function reply(Request $request)
    {
        $id = $request->id;
        $reply = $request->reply;
        $contact = Contact::find($id);

        if ($this->sendReply($contact, $reply)) {
            return response()->json([
                'message' => 'reply has been sent!'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error!'
            ], 400);
        }
    }
    
    private function sendReply($d, $r) 
    {
        try {
            $data = [
                'first_name' => $d->first_name,
                'last_name' => $d->last_name,
                'email' => $d->email,
                'subject' => $d->subject,
                'text' => $d->message,
                'reply' => $r
            ];

            Mail::send('email.contact_reply', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['first_name'] . ' ' . $data['last_name'])
                    ->from('spicyburns90@gmail.com', 'Calcium & Joyjoy - Contact Us')
                    ->subject('RE: ' . $data['subject']);
            });
    
            return true;
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            \Log::error($e->getMessage());
            return false;
        }
    }
}
