<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email'],
            'message'   => ['required', 'string', 'max:2000'],
            'consent'   => ['accepted'],
        ]);

        // Beispiel: E-Mail versenden
        Mail::raw(
            "Neue Kontaktanfrage von {$validated['firstname']} {$validated['lastname']} ({$validated['email']}):\n\n{$validated['message']}",
            fn($mail) => $mail
                ->to('deine@mailadresse.de')
                ->subject('Neue Kontaktanfrage')
        );

        return response()->json(['message' => 'Vielen Dank! Ihre Nachricht wurde erfolgreich gesendet.']);
    }
}