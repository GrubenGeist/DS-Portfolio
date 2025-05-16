<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreContactFormRequest; // Unsere Eingangsregeln
use App\Mail\ContactFormMail;                 // Unsere Briefvorlage
use Illuminate\Support\Facades\Log;           // Um Fehler aufzuschreiben (Logging)
use Illuminate\Support\Facades\Mail;          // Um E-Mails zu versenden
use Illuminate\Http\JsonResponse;             // Um eine Antwort im JSON-Format zu geben (gut für Vue.js)

class ContactFormController extends Controller
{
    // Diese Funktion wird aufgerufen, wenn das Formular abgeschickt wird
    public function submit(StoreContactFormRequest $request): JsonResponse
    {
        // $request->validated() gibt uns die geprüften und sicheren Daten aus dem Formular
        $validatedData = $request->validated();

        try {
            // An wen soll die E-Mail geschickt werden?
            // Wir lesen das aus der Konfiguration (kommt gleich)
            $adminEmail = config('mail.admin_address', 'dennis-strauss@web.de');

            // Wenn du sicherstellen willst, dass immer eine E-Mail da ist, falls die Konfiguration fehlt:
            if (!$adminEmail) {
                Log::error('Admin-E-Mail-Adresse nicht in config/mail.php oder .env konfiguriert!');
                // Sende an eine absolute Fallback-Adresse oder wirf einen spezifischeren Fehler
                $adminEmail = 'hardcoded-fallback@example.com'; // Nur als absolute Notlösung
                // Oder besser: return response()->json(['message' => 'Systemfehler: Admin-E-Mail nicht konfiguriert.'], 500);
            }

            Mail::to($adminEmail) // An Admin senden
                ->send(new ContactFormMail($validatedData)); // Mit unserer Briefvorlage und den Daten

            // Erfolgsmeldung zurück an das Frontend (Vue.js) schicken
            return response()->json(['message' => 'Super! Deine Nachricht ist unterwegs.'], 200);

        } catch (\Exception $e) {
            Log::error('Hilfe, E-Mail konnte nicht gesendet werden: ' . $e->getMessage());
            // Fehlermeldung zurück an das Frontend schicken
            return response()->json(['message' => 'Ohje, da ist was schiefgelaufen. Versuch es später nochmal.'], 500);
        }
    }
}