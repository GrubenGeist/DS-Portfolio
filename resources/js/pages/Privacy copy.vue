<!-- /resources/js/Pages/Privacy.vue -->

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

defineOptions({ layout: AppLayout });

// Die "Schablone" (Interface) für unsere Abschnitte.
interface PrivacySection {
    title: string;
    content: string[];
    isMainTitle?: boolean;
    isSubSection?: boolean;
    titleClass?: string; // z.B. 'font-bold', 'italic'
    contentClass?: string; // z.B. 'text-sm'
}

// Hier definieren wir den gesamten Inhalt der Seite in einer strukturierten Form.
const privacySections: PrivacySection[] = [
    {
        title: 'Inhaltsübersicht',
        titleClass: 'font-semibold',
        content: [
            '<ul class="index list-disc pl-5 space-y-1"><li><a class="text-blue-500 dark:text-blue-400 hover:underline" href="#m3">Verantwortlicher</a></li><li><a class="text-blue-500 dark:text-blue-400 hover:underline" href="#mOverview">Übersicht der Verarbeitungen</a></li><li><a class="text-blue-500 dark:text-blue-400 hover:underline" href="#m2427">Maßgebliche Rechtsgrundlagen</a></li><li><a class="text-blue-500 dark:text-blue-400 hover:underline" href="#m27">Sicherheitsmaßnahmen</a></li><li><a class="text-blue-500 dark:text-blue-400 hover:underline" href="#m25">Übermittlung von personenbezogenen Daten</a></li><li><a class="text-blue-500 dark:text-blue-400 hover:underline" href="#m24">Internationale Datentransfers</a></li><li><a class="text-blue-500 dark:text-blue-400 hover:underline" href="#m12">Allgemeine Informationen zur Datenspeicherung und Löschung</a></li><li><a class="text-blue-500 dark:text-blue-400 hover:underline" href="#m10">Rechte der betroffenen Personen</a></li><li><a class="text-blue-500 dark:text-blue-400 hover:underline" href="#m225">Bereitstellung des Onlineangebots und Webhosting</a></li><li><a class="text-blue-500 dark:text-blue-400 hover:underline" href="#m182">Kontakt- und Anfrageverwaltung</a></li></ul>'
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Verantwortlicher',
        titleClass: 'font-semibold',
        content: [
            'Dennis Strauß<br>Roonstraße 8<br>12203 Berlin<br>Deutschland',
            'E-Mail-Adresse: <a href="mailto:deine-email@example.com" class="text-blue-500 dark:text-blue-400 hover:underline">deine-email@example.com</a>'
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Übersicht der Verarbeitungen',
        titleClass: 'font-semibold',
        content: [
            'Die nachfolgende Übersicht fasst die Arten der verarbeiteten Daten und die Zwecke ihrer Verarbeitung zusammen und verweist auf die betroffenen Personen.',
            '<strong>Arten der verarbeiteten Daten</strong><ul class="list-disc pl-5"><li>Bestandsdaten.</li><li>Zahlungsdaten.</li><li>Kontaktdaten.</li><li>Inhaltsdaten.</li><li>Vertragsdaten.</li><li>Nutzungsdaten.</li><li>Meta-, Kommunikations- und Verfahrensdaten.</li><li>Protokolldaten.</li></ul>',
            '<strong>Kategorien betroffener Personen</strong><ul class="list-disc pl-5"><li>Leistungsempfänger und Auftraggeber.</li><li>Interessenten.</li><li>Kommunikationspartner.</li><li>Nutzer.</li><li>Geschäfts- und Vertragspartner.</li></ul>',
            '<strong>Zwecke der Verarbeitung</strong><ul class="list-disc pl-5"><li>Erbringung vertraglicher Leistungen und Erfüllung vertraglicher Pflichten.</li><li>Kommunikation.</li><li>Sicherheitsmaßnahmen.</li><li>Direktmarketing.</li><li>Reichweitenmessung.</li><li>Tracking.</li><li>Büro- und Organisationsverfahren.</li><li>Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit.</li><li>Informationstechnische Infrastruktur.</li></ul>'
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Maßgebliche Rechtsgrundlagen',
        titleClass: 'font-semibold',
        content: [
            '<p><strong>Maßgebliche Rechtsgrundlagen nach der DSGVO:</strong> Im Folgenden erhalten Sie eine Übersicht der Rechtsgrundlagen der DSGVO, auf deren Basis wir personenbezogene Daten verarbeiten. Bitte nehmen Sie zur Kenntnis, dass neben den Regelungen der DSGVO nationale Datenschutzvorgaben in Ihrem bzw. unserem Wohn- oder Sitzland gelten können.</p><ul class="list-disc pl-5"><li><strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO)</strong> - Die betroffene Person hat ihre Einwilligung in die Verarbeitung der sie betreffenden personenbezogenen Daten für einen spezifischen Zweck oder mehrere bestimmte Zwecke gegeben.</li><li><strong>Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO)</strong> - Die Verarbeitung ist für die Erfüllung eines Vertrags, dessen Vertragspartei die betroffene Person ist, oder zur Durchführung vorvertraglicher Maßnahmen erforderlich, die auf Anfrage der betroffenen Person erfolgen.</li><li><strong>Rechtliche Verpflichtung (Art. 6 Abs. 1 S. 1 lit. c) DSGVO)</strong> - Die Verarbeitung ist zur Erfüllung einer rechtlichen Verpflichtung erforderlich, der der Verantwortliche unterliegt.</li><li><strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO)</strong> - die Verarbeitung ist zur Wahrung der berechtigten Interessen des Verantwortlichen oder eines Dritten notwendig, vorausgesetzt, dass die Interessen, Grundrechte und Grundfreiheiten der betroffenen Person, die den Schutz personenbezogener Daten verlangen, nicht überwiegen.</li></ul>',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Sicherheitsmaßnahmen',
        titleClass: 'font-semibold',
        content: [
            'Wir treffen nach Maßgabe der gesetzlichen Vorgaben unter Berücksichtigung des Stands der Technik, der Implementierungskosten und der Art, des Umfangs, der Umstände und der Zwecke der Verarbeitung sowie der unterschiedlichen Eintrittswahrscheinlichkeiten und des Ausmaßes der Bedrohung der Rechte und Freiheiten natürlicher Personen geeignete technische und organisatorische Maßnahmen, um ein dem Risiko angemessenes Schutzniveau zu gewährleisten.',
            'Zu den Maßnahmen gehören insbesondere die Sicherung der Vertraulichkeit, Integrität und Verfügbarkeit von Daten durch Kontrolle des physischen und elektronischen Zugangs zu den Daten als auch des sie betreffenden Zugriffs, der Eingabe, der Weitergabe, der Sicherung der Verfügbarkeit und ihrer Trennung. Des Weiteren haben wir Verfahren eingerichtet, die eine Wahrnehmung von Betroffenenrechten, die Löschung von Daten und Reaktionen auf die Gefährdung der Daten gewährleisten.'
        ],
        contentClass:'text-sm',
    },

        {
        title: 'Rechte der betroffenen Personen',
        titleClass: 'font-semibold',
        content: [
            'Ihnen stehen als Betroffene nach der DSGVO verschiedene Rechte zu, die sich insbesondere aus Art. 15 bis 21 DSGVO ergeben:',
            '<ul class="list-disc pl-5"><li><strong>Widerspruchsrecht: Sie haben das Recht, aus Gründen, die sich aus Ihrer besonderen Situation ergeben, jederzeit gegen die Verarbeitung der Sie betreffenden personenbezogenen Daten, die aufgrund von Art. 6 Abs. 1 lit. e oder f DSGVO erfolgt, Widerspruch einzulegen.</strong></li><li><strong>Widerrufsrecht bei Einwilligungen:</strong> Sie haben das Recht, erteilte Einwilligungen jederzeit zu widerrufen.</li><li><strong>Auskunftsrecht:</strong> Sie haben das Recht, eine Bestätigung darüber zu verlangen, ob betreffende Daten verarbeitet werden und auf Auskunft über diese Daten.</li><li><strong>Recht auf Berichtigung:</strong> Sie haben das Recht, die Vervollständigung der Sie betreffenden Daten oder die Berichtigung der Sie betreffenden unrichtigen Daten zu verlangen.</li><li><strong>Recht auf Löschung und Einschränkung der Verarbeitung:</strong> Sie haben das Recht, zu verlangen, dass Sie betreffende Daten unverzüglich gelöscht werden, bzw. eine Einschränkung der Verarbeitung der Daten zu verlangen.</li><li><strong>Recht auf Datenübertragbarkeit:</strong> Sie haben das Recht, Sie betreffende Daten, die Sie uns bereitgestellt haben, in einem strukturierten, gängigen und maschinenlesbaren Format zu erhalten.</li><li><strong>Beschwerde bei Aufsichtsbehörde:</strong> Sie haben das Recht auf Beschwerde bei einer Aufsichtsbehörde.</li></ul>'
        ],
        contentClass:'text-sm',
    },
        {
        title: 'Geschäftliche Leistungen',
        titleClass: 'font-semibold',
        content: [
            'Wir verarbeiten Daten unserer Vertrags- und Geschäftspartner, z. B. Kunden und Interessenten (zusammenfassend als „Vertragspartner" bezeichnet), im Rahmen von vertraglichen und vergleichbaren Rechtsverhältnissen sowie damit verbundenen Maßnahmen und im Hinblick auf die Kommunikation mit den Vertragspartnern (oder vorvertraglich), etwa zur Beantwortung von Anfragen.<br><br>',
            'Wir verwenden diese Daten, um unsere vertraglichen Verpflichtungen zu erfüllen. Dazu gehören insbesondere die Pflichten zur Erbringung der vereinbarten Leistungen, etwaige Aktualisierungspflichten und Abhilfe bei Gewährleistungs- und sonstigen Leistungsstörungen. Darüber hinaus verwenden wir die Daten zur Wahrung unserer Rechte und zum Zwecke der mit diesen Pflichten verbundenen Verwaltungsaufgaben sowie der Unternehmensorganisation. Zudem verarbeiten wir die Daten auf Grundlage unserer berechtigten Interessen sowohl an einer ordnungsgemäßen und betriebswirtschaftlichen Geschäftsführung als auch an Sicherheitsmaßnahmen zum Schutz unserer Vertragspartner und unseres Geschäftsbetriebs vor Missbrauch, Gefährdung ihrer Daten, Geheimnisse, Informationen und Rechte (z. B. zur Beteiligung von Telekommunikations-, Transport- und sonstigen Hilfsdiensten sowie Subunternehmern, Banken, Steuer- und Rechtsberatern, Zahlungsdienstleistern oder Finanzbehörden). Im Rahmen des geltenden Rechts geben wir die Daten von Vertragspartnern nur insoweit an Dritte weiter, als dies für die vorgenannten Zwecke oder zur Erfüllung gesetzlicher Pflichten erforderlich ist. Über weitere Formen der Verarbeitung, etwa zu Marketingzwecken, werden die Vertragspartner im Rahmen dieser Datenschutzerklärung informiert.<br><br>',
            'Welche Daten für die vorgenannten Zwecke erforderlich sind, teilen wir den Vertragspartnern vor oder im Rahmen der Datenerhebung, z. B. in Onlineformularen, durch besondere Kennzeichnung (z. B. Farben) bzw. Symbole (z. B. Sternchen o. Ä.), oder persönlich mit.<br><br>',
            'Wir löschen die Daten nach Ablauf gesetzlicher Gewährleistungs- und vergleichbarer Pflichten, d. h. grundsätzlich nach vier Jahren, es sei denn, dass die Daten in einem Kundenkonto gespeichert werden, z. B., solange sie aus gesetzlichen Gründen der Archivierung aufbewahrt werden müssen (etwa für Steuerzwecke im Regelfall zehn Jahre). Daten, die uns im Rahmen eines Auftrags durch den Vertragspartner offengelegt wurden, löschen wir entsprechend den Vorgaben und grundsätzlich nach Ende des Auftrags.<br><br>',
            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten:</strong>Bestandsdaten (z. B. der vollständige Name, Wohnadresse, Kontaktinformationen, Kundennummer, etc.); Zahlungsdaten (z. B. Bankverbindungen, Rechnungen, Zahlungshistorie); Kontaktdaten (z. B. Post- und E-Mail-Adressen oder Telefonnummern); Vertragsdaten (z. B. Vertragsgegenstand, Laufzeit, Kundenkategorie); Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz, verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen). Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen:</strong>Leistungsempfänger und Auftraggeber; Interessenten. Geschäfts- und Vertragspartner.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung:</strong>Erbringung vertraglicher Leistungen und Erfüllung vertraglicher Pflichten; Sicherheitsmaßnahmen; Kommunikation; Büro- und Organisationsverfahren; Organisations- und Verwaltungsverfahren. Geschäftsprozesse und betriebswirtschaftliche Verfahren.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Aufbewahrung und Löschung:</strong>Löschung entsprechend Angaben im Abschnitt "Allgemeine Informationen zur Datenspeicherung und Löschung".<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen:</strong>Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO); Rechtliche Verpflichtung (Art. 6 Abs. 1 S. 1 lit. c) DSGVO). Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).<br><br></li></ul>',
        '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</stong><br><br>',
        '<ul class="list-disc pl-5"><li><strong>Onlineshop, Bestellformulare, E-Commerce und Leistungserfüllung:</strong>Wir verarbeiten die Daten unserer Kunden, um ihnen die Auswahl, den Erwerb, bzw. die Bestellung der gewählten Produkte, Waren sowie verbundener Leistungen, als auch deren Bezahlung und Bereitstellung, bzw. Zustellung, oder Ausführung zu ermöglichen. Sofern für die Ausführung einer Bestellung erforderlich, setzen wir Dienstleister, insbesondere Post-, Speditions- und Versandunternehmen ein, um die Lieferung, bzw. Ausführung gegenüber unseren Kunden durchzuführen. Für die Abwicklung der Zahlungsvorgänge nehmen wir die Dienste von Banken und Zahlungsdienstleistern in Anspruch. Die erforderlichen Angaben sind als solche im Rahmen des Bestell- bzw. vergleichbaren Erwerbsvorgangs gekennzeichnet und umfassen die zur Auslieferung, bzw. Zurverfügungstellung und Abrechnung benötigten Angaben sowie Kontaktinformationen, um etwaige Rücksprache halten zu können; Rechtsgrundlagen: Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO).<br><br></li></ul>',


        ],
        contentClass:'text-sm',
    },
        {
        title: 'Bereitstellung des Onlineangebots und Webhosting',
        titleClass: 'font-semibold',
        content: [
            'Wir verarbeiten die Daten der Nutzer, um ihnen unsere Online-Dienste zur Verfügung stellen zu können. Zu diesem Zweck verarbeiten wir die IP-Adresse des Nutzers, die notwendig ist, um die Inhalte und Funktionen unserer Online-Dienste an den Browser oder das Endgerät der Nutzer zu übermitteln.',
            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen:</strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Aufbewahrung und Löschung:</strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen:</strong><br><br></li></ul>',
            'Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:',
            '<ul class="list-disc pl-5"><li><strong>Erhebung von Zugriffsdaten und Logfiles:</strong>Der Zugriff auf unser Onlineangebot wird in Form von sogenannten "Server-Logfiles" protokolliert. Zu den Serverlogfiles können die Adresse und der Name der abgerufenen Webseiten und Dateien, Datum und Uhrzeit des Abrufs, übertragene Datenmengen, Meldung über erfolgreichen Abruf, Browsertyp nebst Version, das Betriebssystem des Nutzers, Referrer URL (die zuvor besuchte Seite) und im Regelfall IP-Adressen und der anfragende Provider gehören. Die Serverlogfiles können zum einen zu Sicherheitszwecken eingesetzt werden, z. B. um eine Überlastung der Server zu vermeiden (insbesondere im Fall von missbräuchlichen Angriffen, sogenannten DDoS-Attacken), und zum anderen, um die Auslastung der Server und ihre Stabilität sicherzustellen; <strong>  Rechtsgrundlagen: </strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO). <strong> Löschung von Daten:</strong>  Logfile-Informationen werden für die Dauer von maximal 30 Tagen gespeichert und danach gelöscht oder anonymisiert. Daten, deren weitere Aufbewahrung zu Beweiszwecken erforderlich ist, sind bis zur endgültigen Klärung des jeweiligen Vorfalls von der Löschung ausgenommen.<br><br></li></ul>',
        ],
        contentClass:'text-sm',
    },
        {
        title: 'Einsatz von Cookies',
        titleClass: 'font-semibold',
        content: [
            'Unter dem Begriff „Cookies" werden Funktionen, die Informationen auf Endgeräten der Nutzer speichern und aus ihnen auslesen, verstanden. Cookies können ferner in Bezug auf unterschiedliche Anliegen Einsatz finden, etwa zu Zwecken der Funktionsfähigkeit, der Sicherheit und des Komforts von Onlineangeboten sowie der Erstellung von Analysen der Besucherströme. Wir verwenden Cookies gemäß den gesetzlichen Vorschriften. Dazu holen wir, wenn erforderlich, vorab die Zustimmung der Nutzer ein. Ist eine Zustimmung nicht notwendig, setzen wir auf unsere berechtigten Interessen. Dies gilt, wenn das Speichern und Auslesen von Informationen unerlässlich ist, um ausdrücklich angeforderte Inhalte und Funktionen bereitstellen zu können. Dazu zählen etwa die Speicherung von Einstellungen sowie die Sicherstellung der Funktionalität und Sicherheit unseres Onlineangebots. Die Einwilligung kann jederzeit widerrufen werden. Wir informieren klar über deren Umfang und welche Cookies genutzt werden.',
            '<strong>Hinweise zu datenschutzrechtlichen Rechtsgrundlagen: </strong>Ob wir personenbezogene Daten mithilfe von Cookies verarbeiten, hängt von einer Einwilligung ab. Liegt eine Einwilligung vor, dient sie als Rechtsgrundlage. Ohne Einwilligung stützen wir uns auf unsere berechtigten Interessen, die vorstehend in diesem Abschnitt und im Kontext der jeweiligen Dienste und Verfahren erläutert sind.',
            '<strong>Speicherdauer: </strong>Im Hinblick auf die Speicherdauer werden die folgenden Arten von Cookies unterschieden:',

            '<ul class="list-disc pl-5"><li><strong>Temporäre Cookies (auch: Session- oder Sitzungscookies): </strong>Temporäre Cookies werden spätestens gelöscht, nachdem ein Nutzer ein Onlineangebot verlassen und sein Endgerät (z. B. Browser oder mobile Applikation) geschlossen hat.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Permanente Cookies:</strong>Permanente Cookies bleiben auch nach dem Schließen des Endgeräts gespeichert. So können beispielsweise der Log-in-Status gespeichert und bevorzugte Inhalte direkt angezeigt werden, wenn der Nutzer eine Website erneut besucht. Ebenso können die mithilfe von Cookies erhobenen Nutzerdaten zur Reichweitenmessung Verwendung finden. Sofern wir Nutzern keine expliziten Angaben zur Art und Speicherdauer von Cookies mitteilen (z. B. im Rahmen der Einholung der Einwilligung), sollten sie davon ausgehen, dass diese permanent sind und die Speicherdauer bis zu zwei Jahre betragen kann.<br><br></li></ul>',
            
            '<strong>Allgemeine Hinweise zum Widerruf und Widerspruch (Opt-out) </strong>Nutzer können die von ihnen abgegebenen Einwilligungen jederzeit widerrufen und zudem einen Widerspruch gegen die Verarbeitung entsprechend den gesetzlichen Vorgaben, auch mittels der Privatsphäre-Einstellungen ihres Browsers, erklären.',

            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong>Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen:</strong>Nutzer (z. B. Webseitenbesucher, Nutzer von Onlinediensten).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen:</strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO). Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',

            '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</strong>',
            '<ul class="list-disc pl-5"><li><strong>Verarbeitung von Cookie-Daten auf Grundlage einer Einwilligung:</strong>Wir setzen eine Einwilligungs-Management-Lösung ein, bei der die Einwilligung der Nutzer zur Verwendung von Cookies oder zu den im Rahmen der Einwilligungs-Management-Lösung genannten Verfahren und Anbietern eingeholt wird. Dieses Verfahren dient der Einholung, Protokollierung, Verwaltung und dem Widerruf von Einwilligungen, insbesondere bezogen auf den Einsatz von Cookies und vergleichbaren Technologien, die zur Speicherung, zum Auslesen und zur Verarbeitung von Informationen auf den Endgeräten der Nutzer eingesetzt werden. Im Rahmen dieses Verfahrens werden die Einwilligungen der Nutzer für die Nutzung von Cookies und die damit verbundenen Verarbeitungen von Informationen, einschließlich der im Einwilligungs-Management-Verfahren genannten spezifischen Verarbeitungen und Anbieter, eingeholt. Die Nutzer haben zudem die Möglichkeit, ihre Einwilligungen zu verwalten und zu widerrufen. Die Einwilligungserklärungen werden gespeichert, um eine erneute Abfrage zu vermeiden und den Nachweis der Einwilligung gemäß der gesetzlichen Anforderungen führen zu können. Die Speicherung erfolgt serverseitig und/oder in einem Cookie (sogenanntes Opt-In-Cookie) oder mittels vergleichbarer Technologien, um die Einwilligung einem spezifischen Nutzer oder dessen Gerät zuordnen zu können. Sofern keine spezifischen Angaben zu den Anbietern von Einwilligungs-Management-Diensten vorliegen, gelten folgende allgemeine Hinweise: Die Dauer der Speicherung der Einwilligung beträgt bis zu zwei Jahre. Dabei wird ein pseudonymer Nutzer-Identifikator erstellt, der zusammen mit dem Zeitpunkt der Einwilligung, den Angaben zum Umfang der Einwilligung (z. B. betreffende Kategorien von Cookies und/oder Diensteanbieter) sowie Informationen über den Browser, das System und das verwendete Endgerät gespeichert wird; Rechtsgrundlagen: Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO).<br><br></li></ul>',  
        ],
        contentClass:'text-sm',
    },
        {
        title: 'Kontakt- und Anfrageverwaltung',
        titleClass: 'font-semibold',
        content: [
            'Bei der Kontaktaufnahme mit uns (z. B. per Post, Kontaktformular, E-Mail, Telefon oder via soziale Medien) sowie im Rahmen bestehender Nutzer- und Geschäftsbeziehungen werden die Angaben der anfragenden Personen verarbeitet, soweit dies zur Beantwortung der Kontaktanfragen und etwaiger angefragter Maßnahmen erforderlich ist.',
            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten:</strong>Bestandsdaten (z. B. der vollständige Name, Wohnadresse, Kontaktinformationen, Kundennummer, etc.); Kontaktdaten (z. B. Post- und E-Mail-Adressen oder Telefonnummern); Inhaltsdaten (z. B. textliche oder bildliche Nachrichten und Beiträge sowie die sie betreffenden Informationen, wie z. B. Angaben zur Autorenschaft oder Zeitpunkt der Erstellung); Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz, verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen). Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen: </strong>Kommunikationspartner.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong>Kommunikation; Organisations- und Verwaltungsverfahren; Feedback (z. B. Sammeln von Feedback via Online-Formular). Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Aufbewahrung und Löschung: </strong>Löschung entsprechend Angaben im Abschnitt "Allgemeine Informationen zur Datenspeicherung und Löschung".<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen: </strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO). Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO).<br><br></li></ul>',
            
            '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</strong>',
            '<ul class="list-disc pl-5"><li><strong>Kontaktformular: </strong>Bei Kontaktaufnahme über unser Kontaktformular, per E-Mail oder anderen Kommunikationswegen, verarbeiten wir die uns übermittelten personenbezogenen Daten zur Beantwortung und Bearbeitung des jeweiligen Anliegens. Dies umfasst in der Regel Angaben wie Name, Kontaktinformationen und gegebenenfalls weitere Informationen, die uns mitgeteilt werden und zur angemessenen Bearbeitung erforderlich sind. Wir nutzen diese Daten ausschließlich für den angegebenen Zweck der Kontaktaufnahme und Kommunikation; Rechtsgrundlagen: Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).<br><br></li></ul>',
        
        ],
        contentClass:'text-sm',
    },
            {
        title: 'Newsletter und elektronische Benachrichtigungen',
        titleClass: 'font-semibold',
        content: [
            'Wir versenden Newsletter, E-Mails und weitere elektronische Benachrichtigungen (nachfolgend „Newsletter") ausschließlich mit der Einwilligung der Empfänger oder aufgrund einer gesetzlichen Grundlage. Sofern im Rahmen einer Anmeldung zum Newsletter dessen Inhalte genannt werden, sind diese Inhalte für die Einwilligung der Nutzer maßgeblich. Für die Anmeldung zu unserem Newsletter ist normalerweise die Angabe Ihrer E-Mail-Adresse ausreichend. Um Ihnen jedoch einen personalisierten Service bieten zu können, bitten wir gegebenenfalls um die Angabe Ihres Namens für eine persönliche Ansprache im Newsletter oder um weitere Informationen, falls diese für den Zweck des Newsletters notwendig sind.<br><br>',
            'Löschung und Einschränkung der Verarbeitung: Wir können die ausgetragenen E-Mail-Adressen bis zu drei Jahren auf Grundlage unserer berechtigten Interessen speichern, bevor wir sie löschen, um eine ehemals gegebene Einwilligung nachweisen zu können. Die Verarbeitung dieser Daten wird auf den Zweck einer potenziellen Abwehr von Ansprüchen beschränkt. Ein individueller Löschungsantrag ist jederzeit möglich, sofern zugleich das ehemalige Bestehen einer Einwilligung bestätigt wird. Im Fall von Pflichten zur dauerhaften Beachtung von Widersprüchen behalten wir uns die Speicherung der E-Mail-Adresse alleine zu diesem Zweck in einer Sperrliste (sogenannte „Blocklist") vor.<br><br>',
            'Die Protokollierung des Anmeldeverfahrens erfolgt auf Grundlage unserer berechtigten Interessen zum Zweck des Nachweises seines ordnungsgemäßen Ablaufs. Soweit wir einen Dienstleister mit dem Versand von E-Mails beauftragen, erfolgt dies auf Grundlage unserer berechtigten Interessen an einem effizienten und sicheren Versandsystem.<br><br>',
            '<strong>Inhalte:</strong>',
            '<br>Informationen zu uns, unseren Leistungen, Aktionen und Angeboten.<br><br>',
            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong>Bestandsdaten (z. B. der vollständige Name, Wohnadresse, Kontaktinformationen, Kundennummer, etc.); Kontaktdaten (z. B. Post- und E-Mail-Adressen oder Telefonnummern); Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen). Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz, verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen: </strong>Kommunikationspartner.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong>Direktmarketing (z. B. per E-Mail oder postalisch).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen: </strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Widerspruchsmöglichkeit (Opt-Out): </strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO).<br><br></li></ul>',
            
            '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</strong>',
            '<ul class="list-disc pl-5"><li><strong>Messung von Öffnungs- und Klickraten: </strong>Die Newsletter enthalten einen sogenannten „Web Beacons", d. h. eine pixelgroße Datei, die beim Öffnen des Newsletters von unserem bzw. dessen Server, sofern wir einen Versanddienstleister einsetzen, abgerufen wird. Im Rahmen dieses Abrufs werden zunächst sowohl technische Informationen, wie beispielsweise Angaben zum Browser und Ihrem System, als auch Ihre IP-Adresse und der Zeitpunkt des Abrufs erhoben. Diese Informationen werden zur technischen Verbesserung unseres Newsletters anhand der technischen Daten oder der Zielgruppen und ihres Leseverhaltens auf Basis ihrer Abruforte (die mithilfe der IP-Adresse bestimmbar sind) oder der Zugriffszeiten genutzt. Diese Analyse beinhaltet ebenfalls die Feststellung, ob und wann die Newsletter geöffnet und welche Links angeklickt werden. Die Informationen werden den einzelnen Newsletterempfängern zugeordnet und in deren Profilen bis zur Löschung gespeichert. Die Auswertungen dienen dazu, die Lesegewohnheiten unserer Nutzer zu erkennen und unsere Inhalte an sie anzupassen oder unterschiedliche Inhalte entsprechend den Interessen unserer Nutzer zu versenden. Die Messung der Öffnungs- und Klickraten sowie die Speicherung der Messergebnisse in den Profilen der Nutzer<br><br></li></ul>',


        ],
        contentClass:'text-sm',
    },
            {
        title: '',
        titleClass: 'font-semibold',
        content: [
            '',
            '<br><br>',
            '<strong></strong>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
        
        ],
        contentClass:'text-sm',
    },
            {
        title: '',
        titleClass: 'font-semibold',
        content: [
            '',
            '<br><br>',
            '<strong></strong>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
        
        ],
        contentClass:'text-sm',
    },
];
</script>

<template>
    <Head 
     title="Datenschutzerklärung"/>
    
    <!-- Der Hauptcontainer für die Seite -->
    <div class="container mx-auto md:py-20">
        <!-- Die Inhalts-Karte -->
        <div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 rounded-lg shadow-2xl overflow-hidden">
            
            <!-- Der Header mit Farbverlauf und Hintergrund-Icon -->
            <div class="relative bg-gradient-to-br from-blue-700 to-blue-800 p-8 md:p-12 overflow-hidden">
                <!-- Das Icon (Schild) liegt im Hintergrund -->
                <div class="absolute -bottom-12 -right-12 text-white opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
                </div>

                <!-- Der Text liegt mit z-10 im Vordergrund -->
                <div class="relative z-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-white">
                        Datenschutzerklärung
                    </h1>
                    <p class="mt-2 text-blue-200">Stand: 13. August 2025</p>
                </div>
            </div>

            <!-- Der eigentliche Textinhalt auf weißem/dunklem Hintergrund -->
            <div class="p-8 md:p-12 prose dark:prose-invert max-w-none">
                <!-- Das Template rendert den Inhalt jetzt dynamisch aus der Datenstruktur -->
                <div v-for="(section, index) in privacySections" :key="index" class="mb-8 last:mb-0">
                    <h1 v-if="section.isMainTitle" :class="section.titleClass" class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">{{ section.title }}</h1>
                    <h2 v-else-if="!section.isSubSection" :class="section.titleClass">{{ section.title }}</h2>
                    <strong v-else :class="section.titleClass">{{ section.title }}</strong>
                    <div 
                        v-for="(paragraph, pIndex) in section.content" 
                        :key="pIndex" 
                        v-html="paragraph" 
                        class="text-gray-700 dark:text-gray-300"
                        :class="section.contentClass"
                    ></div>
                </div>
                <!-- Quelle des Generators -->
                <p class="mt-12 text-sm text-gray-500">
                    <a 
                        href="https://datenschutz-generator.de/" 
                        title="Rechtstext von Dr. Schwenke - für weitere Informationen bitte anklicken." 
                        target="_blank" 
                        rel="noopener noreferrer nofollow"
                        class="text-blue-500 dark:text-blue-400 hover:underline"
                    >
                        Erstellt mit kostenlosem Datenschutz-Generator.de von Dr. Thomas Schwenke
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>
