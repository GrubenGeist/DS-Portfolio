@component('mail::message')
# Neue Kontaktanfrage

**Name:** {{ $firstName }} {{ $lastName }}

**E-Mail:** {{ $email }}

**Nachricht:**
{{ $messageContent }}

Danke,
{{ config('app.name Portfolio Projekt') }}
@endcomponent