<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        $name = $request->name ?? null;
        $email = $request->email ?? null;
        $phone = $request->phone ?? null;
        $message = $request->message ?? null;
        $newContact = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
        ];
        $contact = Contact::create($newContact);
        Mail::to($_SERVER["EMAIL_NOTIFY"] ?? "phamquanglinhdev@gmail.com")->send(new ContactMail($contact));
        return redirect()->back()->with("success", "Thành công");
    }
}
