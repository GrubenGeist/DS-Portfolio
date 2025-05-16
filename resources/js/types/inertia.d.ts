// resources/js/types/inertia.d.ts

import { PageProps as InertiaPagePropsOriginal } from '@inertiajs/core';

// Definiere die Struktur deines User-Objekts, wie es vom Backend kommt
export interface AppUser { // Exportiere, falls du es woanders direkt importieren willst
    id: number;
    name: string;
    email: string;
    avatar?: string | null;
    roles: string[];
    email_verified_at: string | null;
    created_at: string | null;
    updated_at: string | null;
    // Füge weitere Felder hinzu, die von HandleInertiaRequests.php gesendet werden
}

// Erweitere die globalen PageProps von Inertia
declare module '@inertiajs/core' {
    interface PageProps extends InertiaPagePropsOriginal { // Erweitere die Original-PageProps
        auth: {
            user: AppUser | null; // Verwende den oben definierten AppUser-Typ
        };
        ziggy: {
            routes: object;
            url: string;
            port: number | null;
            defaults: object;
            location: string;
            // Weitere Ziggy-spezifische Eigenschaften
        };
        canRegister: boolean;
        name?: string;         // z.B. app.name
        quote?: {
            message: string;
            author: string;
        };
        breadcrumbs?: Array<{ // Wird von Controllern für die aktuelle Seite gesetzt
            title: string;
            href?: string;
        }>;
        flash?: {
            success?: string;
            error?: string;
            // Weitere Flash-Typen
        };
        errors?: Record<string, string>; // Validierungsfehler
        // Füge hier alle anderen globalen Props hinzu
    }
}

// Diese Zeile ist optional, aber gut, um sicherzustellen, dass es als Modul behandelt wird,
// besonders wenn du keine expliziten `export`s in dieser Datei hast und keine `import`s von `@inertiajs/core` hättest.
// Da wir aber `@inertiajs/core` importieren, ist es bereits ein Modul.
// export {};