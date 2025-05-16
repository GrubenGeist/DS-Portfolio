<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request; // Nur wenn du das Request-Objekt brauchst
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class PageController extends Controller
{
    public function welcome(): InertiaResponse
    {
        return Inertia::render('Welcome', [
            'breadcrumbs' => [['label' => 'Startseite']],
        ]);
    }

    public function contactForm(): InertiaResponse // Für route('Kontaktformular')
    {
        // Stelle sicher, dass die Vue-Komponente 'Contactform.vue' (oder wie auch immer sie heißt) existiert
        return Inertia::render('Contactform', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Kontaktformular'],
            ],
        ]);
    }

    public function dashboard(): InertiaResponse // Für Admin-Dashboard
    {
        return Inertia::render('Dashboard', [
            'breadcrumbs' => [['label' => 'Dashboard']],
        ]);
    }

    // Für die Admin-Route GET /register (Anzeige des Formulars)
    public function showAdminRegistrationForm(): InertiaResponse
    {
        // Stelle sicher, dass die Vue-Komponente 'register.vue' (oder wie auch immer sie für Admins heißt) existiert
        // z.B. 'Auth/Register' oder 'Admin/CreateUser'
        return Inertia::render('register', [
            'breadcrumbs' => [['label' => 'Benutzer registrieren (Admin)']],
        ]);
    }

    public function testPage(): InertiaResponse // Für /test
    {
        return Inertia::render('Test', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Testseite'],
            ],
        ]);
    }

    public function projects(): InertiaResponse
    {
        return Inertia::render('Projects', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Projekte'],
            ],
        ]);
    }

    public function services(): InertiaResponse
    {
        return Inertia::render('Services', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Dienstleistungen'],
            ],
        ]);
    }

    public function aboutMe(): InertiaResponse
    {
        return Inertia::render('Aboutme', [
            'breadcrumbs' => [
                ['label' => 'Startseite', 'href' => route('welcome')],
                ['label' => 'Über Mich'],
            ],
        ]);
    }
}