<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content; // Für den Inhalt der E-Mail
use Illuminate\Mail\Mailables\Envelope; // Für Betreff, Absender, Empfänger
use Illuminate\Mail\Mailables\Address;  // Für E-Mail-Adressen
use Illuminate\Queue\SerializesModels;







class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data; // Hier speichern wir die Formulardaten (Name, E-Mail, Nachricht) // Bleibt als Array, um flexibel zu sein

    public function __construct(array $data) // Wenn wir die Briefvorlage "nehmen", geben wir die Daten mit
    {
        $this->data = $data; // $data enthält jetzt ['firstName' => ..., 'lastName' => ..., 'email' => ..., 'message' => ...]
    }

    public function envelope(): Envelope // Umschlag-Infos
    {
        // Konstruiere den vollen Namen für die Anzeige
        $fullName = trim(($this->data['firstName'] ?? '') . ' ' . ($this->data['lastName'] ?? ''));

        return new Envelope(
            from: new Address($this->data['email'], $fullName ?: 'Kontaktformular Nutzer'), // Fallback, falls Name leer
            replyTo: [
                new Address($this->data['email'], $fullName ?: 'Kontaktformular Nutzer')
            ],
            subject: 'Neue Kontaktanfrage von ' . ($fullName ?: $this->data['email']), // Betreff anpassen
        );
    }

    public function content(): Content // Inhalt der E-Mail
    {
        // Wir nutzen eine "Blade"-Datei (HTML-Vorlage von Laravel) für das Aussehen der E-Mail
        return new Content(
            markdown: 'emails.contact', // Name der Vorlagendatei: resources/views/emails/contact.blade.php
            with: [ // Welche Infos geben wir an die Vorlage weiter?
                'firstName' => $this->data['firstName'] ?? '', // Sicherstellen, dass die Schlüssel existieren
                'lastName' => $this->data['lastName'] ?? '',
                'email' => $this->data['email'],
                'messageContent' => $this->data['message'], // 'message' ist ein Spezialwort, daher 'messageContent'
            ],
        );
    }
    public function attachments(): array
    {
        return [];
    }
}