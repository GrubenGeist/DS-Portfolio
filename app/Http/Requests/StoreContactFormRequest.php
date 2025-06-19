<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactFormRequest extends FormRequest
{
    public function authorize(): bool // Darf der Nutzer das überhaupt tun?
    {
        return true; // Ja, jeder darf das Kontaktformular senden.
    }

    public function rules(): array // Welche Regeln gelten für die Felder?
    {
        return [
            'firstName' => 'required|string|max:255', // Geändert von 'name'
            'lastName' => 'required|string|max:255',  // Hinzugefügt
            'email' => 'required|email|max:255',  // E-Mail: Muss da sein, gültiges E-Mail-Format, max. 255 Zeichen
            'message' => 'required|string|min:10', // Nachricht: Muss da sein, Text, mind. 10 Zeichen
        ];
    }

    public function messages(): array // Eigene Fehlermeldungen (optional, aber netter)
    {
        return [
            'firstName.required' => 'Bitte geben Sie Ihren Vornamen an.',
            'firstName.string' => 'Der Vorname muss eine Zeichenkette sein.',
            'firstName.max' => 'Der Vorname darf maximal :max Zeichen lang sein.',
            'lastName.required' => 'Bitte geben Sie Ihren Nachnamen an.',
            'lastName.string' => 'Der Nachname muss eine Zeichenkette sein.',
            'lastName.max' => 'Der Nachname darf maximal :max Zeichen lang sein.',
            'email.required' => 'Bitte geben Sie Ihre E-Mail-Adresse an.',
            'email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse an.',
            'message.required' => 'Bitte geben Sie eine Nachricht ein.',
            'message.min' => 'Die Nachricht muss mindestens :min Zeichen lang sein.',
        ];
    }
}
