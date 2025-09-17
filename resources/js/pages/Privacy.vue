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
            '<strong>Zwecke der Verarbeitung</strong><ul class="list-disc pl-5"><li>Erbringung vertraglicher Leistungen und Erfüllung vertraglicher Pflichten.</li><li>Kommunikation.</li><li>Sicherheitsmaßnahmen.</li><li>Direktmarketing.</li><li>Reichweitenmessung.</li><li>Tracking.</li><li>Büro- und Organisationsverfahren.</li><li>Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit.</li><li>Informationstechnische Infrastruktur.</li></ul>',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Maßgebliche Rechtsgrundlagen',
        titleClass: 'font-semibold',
        content: [
            '<br><p><strong>Maßgebliche Rechtsgrundlagen nach der DSGVO:</strong> Im Folgenden erhalten Sie eine Übersicht der Rechtsgrundlagen der DSGVO, auf deren Basis wir personenbezogene Daten verarbeiten. Bitte nehmen Sie zur Kenntnis, dass neben den Regelungen der DSGVO nationale Datenschutzvorgaben in Ihrem bzw. unserem Wohn- oder Sitzland gelten können.</p><ul class="list-disc pl-5"><li><strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO)</strong> - Die betroffene Person hat ihre Einwilligung in die Verarbeitung der sie betreffenden personenbezogenen Daten für einen spezifischen Zweck oder mehrere bestimmte Zwecke gegeben.</li><li><strong>Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO)</strong> - Die Verarbeitung ist für die Erfüllung eines Vertrags, dessen Vertragspartei die betroffene Person ist, oder zur Durchführung vorvertraglicher Maßnahmen erforderlich, die auf Anfrage der betroffenen Person erfolgen.</li><li><strong>Rechtliche Verpflichtung (Art. 6 Abs. 1 S. 1 lit. c) DSGVO)</strong> - Die Verarbeitung ist zur Erfüllung einer rechtlichen Verpflichtung erforderlich, der der Verantwortliche unterliegt.</li><li><strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO)</strong> - die Verarbeitung ist zur Wahrung der berechtigten Interessen des Verantwortlichen oder eines Dritten notwendig, vorausgesetzt, dass die Interessen, Grundrechte und Grundfreiheiten der betroffenen Person, die den Schutz personenbezogener Daten verlangen, nicht überwiegen.</li></ul>',
            '<br><strong>Nationale Datenschutzregelungen in Deutschland: </strong>Zusätzlich zu den Datenschutzregelungen der DSGVO gelten nationale Regelungen zum Datenschutz in Deutschland. Hierzu gehört insbesondere das Gesetz zum Schutz vor Missbrauch personenbezogener Daten bei der Datenverarbeitung (Bundesdatenschutzgesetz – BDSG). Das BDSG enthält insbesondere Spezialregelungen zum Recht auf Auskunft, zum Recht auf Löschung, zum Widerspruchsrecht, zur Verarbeitung besonderer Kategorien personenbezogener Daten, zur Verarbeitung für andere Zwecke und zur Übermittlung sowie automatisierten Entscheidungsfindung im Einzelfall einschließlich Profiling. Ferner können Landesdatenschutzgesetze der einzelnen Bundesländer zur Anwendung gelangen.<br><br>',
            '<strong>Hinweis auf Geltung DSGVO und Schweizer DSG: </strong> Diese Datenschutzhinweise dienen sowohl der Informationserteilung nach dem Schweizer DSG als auch nach der Datenschutzgrundverordnung (DSGVO). Aus diesem Grund bitten wir Sie zu beachten, dass aufgrund der breiteren räumlichen Anwendung und Verständlichkeit die Begriffe der DSGVO verwendet werden. Insbesondere statt der im Schweizer DSG verwendeten Begriffe „Bearbeitung" von „Personendaten", "überwiegendes Interesse" und "besonders schützenswerte Personendaten" werden die in der DSGVO verwendeten Begriffe „Verarbeitung" von „personenbezogenen Daten" sowie "berechtigtes Interesse" und "besondere Kategorien von Daten" verwendet. Die gesetzliche Bedeutung der Begriffe wird jedoch im Rahmen der Geltung des Schweizer DSG weiterhin nach dem Schweizer DSG bestimmt.<br><br>',

        ],
        contentClass:'text-sm',
    },
    {
        title: 'Sicherheitsmaßnahmen',
        titleClass: 'font-semibold',
        content: [
            '<br>Wir treffen nach Maßgabe der gesetzlichen Vorgaben unter Berücksichtigung des Stands der Technik, der Implementierungskosten und der Art, des Umfangs, der Umstände und der Zwecke der Verarbeitung sowie der unterschiedlichen Eintrittswahrscheinlichkeiten und des Ausmaßes der Bedrohung der Rechte und Freiheiten natürlicher Personen geeignete technische und organisatorische Maßnahmen, um ein dem Risiko angemessenes Schutzniveau zu gewährleisten.',
            '<br>Zu den Maßnahmen gehören insbesondere die Sicherung der Vertraulichkeit, Integrität und Verfügbarkeit von Daten durch Kontrolle des physischen und elektronischen Zugangs zu den Daten als auch des sie betreffenden Zugriffs, der Eingabe, der Weitergabe, der Sicherung der Verfügbarkeit und ihrer Trennung. Des Weiteren haben wir Verfahren eingerichtet, die eine Wahrnehmung von Betroffenenrechten, die Löschung von Daten und Reaktionen auf die Gefährdung der Daten gewährleisten.'
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Übermittlung von personenbezogenen Daten',
        titleClass: 'font-semibold',
        content: [
            '<br>Im Rahmen unserer Verarbeitung von personenbezogenen Daten kommt es vor, dass diese an andere Stellen, Unternehmen, rechtlich selbstständige Organisationseinheiten oder Personen übermittelt beziehungsweise ihnen gegenüber offengelegt werden. Zu den Empfängern dieser Daten können z. B. mit IT-Aufgaben beauftragte Dienstleister gehören oder Anbieter von Diensten und Inhalten, die in eine Website eingebunden sind. In solchen Fällen beachten wir die gesetzlichen Vorgaben und schließen insbesondere entsprechende Verträge bzw. Vereinbarungen, die dem Schutz Ihrer Daten dienen, mit den Empfängern Ihrer Daten ab.<br><br>',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Internationale Datentransfers',
        titleClass: 'font-semibold',
        content: [
            'Datenverarbeitung in Drittländern: Sofern wir Daten in ein Drittland (d. h. außerhalb der Europäischen Union (EU) oder des Europäischen Wirtschaftsraums (EWR)) übermitteln oder dies im Rahmen der Nutzung von Diensten Dritter oder der Offenlegung bzw. Übermittlung von Daten an andere Personen, Stellen oder Unternehmen geschieht (was erkennbar wird anhand der Postadresse des jeweiligen Anbieters oder wenn in der Datenschutzerklärung ausdrücklich auf den Datentransfer in Drittländer hingewiesen wird), erfolgt dies stets im Einklang mit den gesetzlichen Vorgaben.<br><br>',
            'Für Datenübermittlungen in die USA stützen wir uns vorrangig auf das Data Privacy Framework (DPF), welches durch einen Angemessenheitsbeschluss der EU-Kommission vom 10.07.2023 als sicherer Rechtsrahmen anerkannt wurde. Zusätzlich haben wir mit den jeweiligen Anbietern Standardvertragsklauseln abgeschlossen, die den Vorgaben der EU-Kommission entsprechen und vertragliche Verpflichtungen zum Schutz Ihrer Daten festlegen.<br><br>',
            'Diese zweifache Absicherung gewährleistet einen umfassenden Schutz Ihrer Daten: Das DPF bildet die primäre Schutzebene, während die Standardvertragsklauseln als zusätzliche Sicherheit dienen. Sollten sich Änderungen im Rahmen des DPF ergeben, greifen die Standardvertragsklauseln als zuverlässige Rückfalloption ein. So stellen wir sicher, dass Ihre Daten auch bei etwaigen politischen oder rechtlichen Veränderungen stets angemessen geschützt bleiben.<br><br>',
            'Bei den einzelnen Diensteanbietern informieren wir Sie darüber, ob sie nach dem DPF zertifiziert sind und ob Standardvertragsklauseln vorliegen. Weitere Informationen zum DPF und eine Liste der zertifizierten Unternehmen finden Sie auf der Website des US-Handelsministeriums unter https://www.dataprivacyframework.gov/ (in englischer Sprache).<br><br>',
            'Für Datenübermittlungen in andere Drittländer gelten entsprechende Sicherheitsmaßnahmen, insbesondere Standardvertragsklauseln, ausdrückliche Einwilligungen oder gesetzlich erforderliche Übermittlungen. Informationen zu Drittlandtransfers und geltenden Angemessenheitsbeschlüssen können Sie dem Informationsangebot der EU-Kommission entnehmen: https://commission.europa.eu/law/law-topic/data-protection/international-dimension-data-protection_en?prefLang=de.<br><br>',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Allgemeine Informationen zur Datenspeicherung und Löschung',
        titleClass: 'font-semibold',
        content: [
            '<br>Wir löschen personenbezogene Daten, die wir verarbeiten, gemäß den gesetzlichen Bestimmungen, sobald die zugrundeliegenden Einwilligungen widerrufen werden oder keine weiteren rechtlichen Grundlagen für die Verarbeitung bestehen. Dies betrifft Fälle, in denen der ursprüngliche Verarbeitungszweck entfällt oder die Daten nicht mehr benötigt werden. Ausnahmen von dieser Regelung bestehen, wenn gesetzliche Pflichten oder besondere Interessen eine längere Aufbewahrung oder Archivierung der Daten erfordern.<br><br>',
            'Insbesondere müssen Daten, die aus handels- oder steuerrechtlichen Gründen aufbewahrt werden müssen oder deren Speicherung notwendig ist zur Rechtsverfolgung oder zum Schutz der Rechte anderer natürlicher oder juristischer Personen, entsprechend archiviert werden.<br><br>',
            'Unsere Datenschutzhinweise enthalten zusätzliche Informationen zur Aufbewahrung und Löschung von Daten, die speziell für bestimmte Verarbeitungsprozesse gelten.<br><br>',
            'Bei mehreren Angaben zur Aufbewahrungsdauer oder Löschungsfristen eines Datums, ist stets die längste Frist maßgeblich. Daten, die nicht mehr für den ursprünglich vorgesehenen Zweck, sondern aufgrund gesetzlicher Vorgaben oder anderer Gründe aufbewahrt werden, verarbeiten wir ausschließlich zu den Gründen, die ihre Aufbewahrung rechtfertigen.<br><br>',
            'Aufbewahrung und Löschung von Daten: Die folgenden allgemeinen Fristen gelten für die Aufbewahrung und Archivierung nach deutschem Recht:<br><br>',

            '<ul class="list-disc pl-5"><li>10 Jahre - Aufbewahrungsfrist für Bücher und Aufzeichnungen, Jahresabschlüsse, Inventare, Lageberichte, Eröffnungsbilanz sowie die zu ihrem Verständnis erforderlichen Arbeitsanweisungen und sonstigen Organisationsunterlagen (§ 147 Abs. 1 Nr. 1 i.V.m. Abs. 3 AO, § 14b Abs. 1 UStG, § 257 Abs. 1 Nr. 1 i.V.m. Abs. 4 HGB).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li>8 Jahre - Buchungsbelege, wie z. B. Rechnungen und Kostenbelege (§ 147 Abs. 1 Nr. 4 und 4a i.V.m. Abs. 3 Satz 1 AO sowie § 257 Abs. 1 Nr. 4 i.V.m. Abs. 4 HGB).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li>6 Jahre - Übrige Geschäftsunterlagen: empfangene Handels- oder Geschäftsbriefe, Wiedergaben der abgesandten Handels- oder Geschäftsbriefe, sonstige Unterlagen, soweit sie für die Besteuerung von Bedeutung sind, z. B. Stundenlohnzettel, Betriebsabrechnungsbögen, Kalkulationsunterlagen, Preisauszeichnungen, aber auch Lohnabrechnungsunterlagen, soweit sie nicht bereits Buchungsbelege sind und Kassenstreifen (§ 147 Abs. 1 Nr. 2, 3, 5 i.V.m. Abs. 3 AO, § 257 Abs. 1 Nr. 2 u. 3 i.V.m. Abs. 4 HGB).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li>3 Jahre - Daten, die erforderlich sind, um potenzielle Gewährleistungs- und Schadensersatzansprüche oder ähnliche vertragliche Ansprüche und Rechte zu berücksichtigen sowie damit verbundene Anfragen zu bearbeiten, basierend auf früheren Geschäftserfahrungen und üblichen Branchenpraktiken, werden für die Dauer der regulären gesetzlichen Verjährungsfrist von drei Jahren gespeichert (§§ 195, 199 BGB).<br><br></li></ul>',
            '<strong></strong>',
        ],
        contentClass:'text-sm',
    },

    {
        title: 'Rechte der betroffenen Personen',
        titleClass: 'font-semibold',
        content: [
            '<br>Ihnen stehen als Betroffene nach der DSGVO verschiedene Rechte zu, die sich insbesondere aus Art. 15 bis 21 DSGVO ergeben:',
            '<br><ul class="list-disc pl-5"><li><strong>Widerspruchsrecht: </strong>Sie haben das Recht, aus Gründen, die sich aus Ihrer besonderen Situation ergeben, jederzeit gegen die Verarbeitung der Sie betreffenden personenbezogenen Daten, die aufgrund von Art. 6 Abs. 1 lit. e oder f DSGVO erfolgt, Widerspruch einzulegen.</strong></li><li><strong>Widerrufsrecht bei Einwilligungen:</strong> Sie haben das Recht, erteilte Einwilligungen jederzeit zu widerrufen.</li><li><strong>Auskunftsrecht:</strong> Sie haben das Recht, eine Bestätigung darüber zu verlangen, ob betreffende Daten verarbeitet werden und auf Auskunft über diese Daten.</li><li><strong>Recht auf Berichtigung:</strong> Sie haben das Recht, die Vervollständigung der Sie betreffenden Daten oder die Berichtigung der Sie betreffenden unrichtigen Daten zu verlangen.</li><li><strong>Recht auf Löschung und Einschränkung der Verarbeitung:</strong> Sie haben das Recht, zu verlangen, dass Sie betreffende Daten unverzüglich gelöscht werden, bzw. eine Einschränkung der Verarbeitung der Daten zu verlangen.</li><li><strong>Recht auf Datenübertragbarkeit:</strong> Sie haben das Recht, Sie betreffende Daten, die Sie uns bereitgestellt haben, in einem strukturierten, gängigen und maschinenlesbaren Format zu erhalten.</li><li><strong>Beschwerde bei Aufsichtsbehörde:</strong> Sie haben das Recht auf Beschwerde bei einer Aufsichtsbehörde.</li></ul>'
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
            '<br>Wir verarbeiten die Daten der Nutzer, um ihnen unsere Online-Dienste zur Verfügung stellen zu können. Zu diesem Zweck verarbeiten wir die IP-Adresse des Nutzers, die notwendig ist, um die Inhalte und Funktionen unserer Online-Dienste an den Browser oder das Endgerät der Nutzer zu übermitteln.',
            '<br><ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen:</strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Aufbewahrung und Löschung:</strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen:</strong><br><br></li></ul>',
            '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten: </strong>',
            '<br><ul class="list-disc pl-5"><li><strong>Erhebung von Zugriffsdaten und Logfiles:</strong>Der Zugriff auf unser Onlineangebot wird in Form von sogenannten "Server-Logfiles" protokolliert. Zu den Serverlogfiles können die Adresse und der Name der abgerufenen Webseiten und Dateien, Datum und Uhrzeit des Abrufs, übertragene Datenmengen, Meldung über erfolgreichen Abruf, Browsertyp nebst Version, das Betriebssystem des Nutzers, Referrer URL (die zuvor besuchte Seite) und im Regelfall IP-Adressen und der anfragende Provider gehören. Die Serverlogfiles können zum einen zu Sicherheitszwecken eingesetzt werden, z. B. um eine Überlastung der Server zu vermeiden (insbesondere im Fall von missbräuchlichen Angriffen, sogenannten DDoS-Attacken), und zum anderen, um die Auslastung der Server und ihre Stabilität sicherzustellen; <strong>  Rechtsgrundlagen: </strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO). <strong> Löschung von Daten:</strong>  Logfile-Informationen werden für die Dauer von maximal 30 Tagen gespeichert und danach gelöscht oder anonymisiert. Daten, deren weitere Aufbewahrung zu Beweiszwecken erforderlich ist, sind bis zur endgültigen Klärung des jeweiligen Vorfalls von der Löschung ausgenommen.<br><br></li></ul>',
        ],
        contentClass:'text-sm',
    },
        {
        title: 'Einsatz von Cookies',
        titleClass: 'font-semibold',
        content: [
            '<br>Unter dem Begriff „Cookies" werden Funktionen, die Informationen auf Endgeräten der Nutzer speichern und aus ihnen auslesen, verstanden. Cookies können ferner in Bezug auf unterschiedliche Anliegen Einsatz finden, etwa zu Zwecken der Funktionsfähigkeit, der Sicherheit und des Komforts von Onlineangeboten sowie der Erstellung von Analysen der Besucherströme. Wir verwenden Cookies gemäß den gesetzlichen Vorschriften. Dazu holen wir, wenn erforderlich, vorab die Zustimmung der Nutzer ein. Ist eine Zustimmung nicht notwendig, setzen wir auf unsere berechtigten Interessen. Dies gilt, wenn das Speichern und Auslesen von Informationen unerlässlich ist, um ausdrücklich angeforderte Inhalte und Funktionen bereitstellen zu können. Dazu zählen etwa die Speicherung von Einstellungen sowie die Sicherstellung der Funktionalität und Sicherheit unseres Onlineangebots. Die Einwilligung kann jederzeit widerrufen werden. Wir informieren klar über deren Umfang und welche Cookies genutzt werden.',
            '<br><strong>Hinweise zu datenschutzrechtlichen Rechtsgrundlagen: </strong>Ob wir personenbezogene Daten mithilfe von Cookies verarbeiten, hängt von einer Einwilligung ab. Liegt eine Einwilligung vor, dient sie als Rechtsgrundlage. Ohne Einwilligung stützen wir uns auf unsere berechtigten Interessen, die vorstehend in diesem Abschnitt und im Kontext der jeweiligen Dienste und Verfahren erläutert sind.',
            '<br><strong>Speicherdauer: </strong>Im Hinblick auf die Speicherdauer werden die folgenden Arten von Cookies unterschieden:',

            '<br><ul class="list-disc pl-5"><li><strong>Temporäre Cookies (auch: Session- oder Sitzungscookies): </strong>Temporäre Cookies werden spätestens gelöscht, nachdem ein Nutzer ein Onlineangebot verlassen und sein Endgerät (z. B. Browser oder mobile Applikation) geschlossen hat.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Permanente Cookies:</strong>Permanente Cookies bleiben auch nach dem Schließen des Endgeräts gespeichert. So können beispielsweise der Log-in-Status gespeichert und bevorzugte Inhalte direkt angezeigt werden, wenn der Nutzer eine Website erneut besucht. Ebenso können die mithilfe von Cookies erhobenen Nutzerdaten zur Reichweitenmessung Verwendung finden. Sofern wir Nutzern keine expliziten Angaben zur Art und Speicherdauer von Cookies mitteilen (z. B. im Rahmen der Einholung der Einwilligung), sollten sie davon ausgehen, dass diese permanent sind und die Speicherdauer bis zu zwei Jahre betragen kann.<br><br></li></ul>',
            
            '<strong>Allgemeine Hinweise zum Widerruf und Widerspruch (Opt-out) </strong>Nutzer können die von ihnen abgegebenen Einwilligungen jederzeit widerrufen und zudem einen Widerspruch gegen die Verarbeitung entsprechend den gesetzlichen Vorgaben, auch mittels der Privatsphäre-Einstellungen ihres Browsers, erklären.',

            '<br><ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong>Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen:</strong>Nutzer (z. B. Webseitenbesucher, Nutzer von Onlinediensten).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen:</strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO). Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO).<br><br></li></ul>',

            '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</strong><br><br>',
            '<ul class="list-disc pl-5"><li><strong>Verarbeitung von Cookie-Daten auf Grundlage einer Einwilligung:</strong>Wir setzen eine Einwilligungs-Management-Lösung ein, bei der die Einwilligung der Nutzer zur Verwendung von Cookies oder zu den im Rahmen der Einwilligungs-Management-Lösung genannten Verfahren und Anbietern eingeholt wird. Dieses Verfahren dient der Einholung, Protokollierung, Verwaltung und dem Widerruf von Einwilligungen, insbesondere bezogen auf den Einsatz von Cookies und vergleichbaren Technologien, die zur Speicherung, zum Auslesen und zur Verarbeitung von Informationen auf den Endgeräten der Nutzer eingesetzt werden. Im Rahmen dieses Verfahrens werden die Einwilligungen der Nutzer für die Nutzung von Cookies und die damit verbundenen Verarbeitungen von Informationen, einschließlich der im Einwilligungs-Management-Verfahren genannten spezifischen Verarbeitungen und Anbieter, eingeholt. Die Nutzer haben zudem die Möglichkeit, ihre Einwilligungen zu verwalten und zu widerrufen. Die Einwilligungserklärungen werden gespeichert, um eine erneute Abfrage zu vermeiden und den Nachweis der Einwilligung gemäß der gesetzlichen Anforderungen führen zu können. Die Speicherung erfolgt serverseitig und/oder in einem Cookie (sogenanntes Opt-In-Cookie) oder mittels vergleichbarer Technologien, um die Einwilligung einem spezifischen Nutzer oder dessen Gerät zuordnen zu können. Sofern keine spezifischen Angaben zu den Anbietern von Einwilligungs-Management-Diensten vorliegen, gelten folgende allgemeine Hinweise: Die Dauer der Speicherung der Einwilligung beträgt bis zu zwei Jahre. Dabei wird ein pseudonymer Nutzer-Identifikator erstellt, der zusammen mit dem Zeitpunkt der Einwilligung, den Angaben zum Umfang der Einwilligung (z. B. betreffende Kategorien von Cookies und/oder Diensteanbieter) sowie Informationen über den Browser, das System und das verwendete Endgerät gespeichert wird; Rechtsgrundlagen: Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO).<br><br></li></ul>',  
        ],
        contentClass:'text-sm',
    },
        {
        title: 'Kontakt- und Anfrageverwaltung',
        titleClass: 'font-semibold',
        content: [
            '<br>Bei der Kontaktaufnahme mit uns (z. B. per Post, Kontaktformular, E-Mail, Telefon oder via soziale Medien) sowie im Rahmen bestehender Nutzer- und Geschäftsbeziehungen werden die Angaben der anfragenden Personen verarbeitet, soweit dies zur Beantwortung der Kontaktanfragen und etwaiger angefragter Maßnahmen erforderlich ist.',
            '<br><ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten:</strong>Bestandsdaten (z. B. der vollständige Name, Wohnadresse, Kontaktinformationen, Kundennummer, etc.); Kontaktdaten (z. B. Post- und E-Mail-Adressen oder Telefonnummern); Inhaltsdaten (z. B. textliche oder bildliche Nachrichten und Beiträge sowie die sie betreffenden Informationen, wie z. B. Angaben zur Autorenschaft oder Zeitpunkt der Erstellung); Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz, verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen). Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen: </strong>Kommunikationspartner.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong>Kommunikation; Organisations- und Verwaltungsverfahren; Feedback (z. B. Sammeln von Feedback via Online-Formular). Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Aufbewahrung und Löschung: </strong>Löschung entsprechend Angaben im Abschnitt "Allgemeine Informationen zur Datenspeicherung und Löschung".<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen: </strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO). Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO).<br><br></li></ul>',
            
            '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</strong><br><br>',
            '<ul class="list-disc pl-5"><li><strong>Kontaktformular: </strong>Bei Kontaktaufnahme über unser Kontaktformular, per E-Mail oder anderen Kommunikationswegen, verarbeiten wir die uns übermittelten personenbezogenen Daten zur Beantwortung und Bearbeitung des jeweiligen Anliegens. Dies umfasst in der Regel Angaben wie Name, Kontaktinformationen und gegebenenfalls weitere Informationen, die uns mitgeteilt werden und zur angemessenen Bearbeitung erforderlich sind. Wir nutzen diese Daten ausschließlich für den angegebenen Zweck der Kontaktaufnahme und Kommunikation; Rechtsgrundlagen: Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b) DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).<br><br></li></ul>',
        
        ],
        contentClass:'text-sm',
    },
            {
        title: 'Newsletter und elektronische Benachrichtigungen',
        titleClass: 'font-semibold',
        content: [
            '<br>Wir versenden Newsletter, E-Mails und weitere elektronische Benachrichtigungen (nachfolgend „Newsletter") ausschließlich mit der Einwilligung der Empfänger oder aufgrund einer gesetzlichen Grundlage. Sofern im Rahmen einer Anmeldung zum Newsletter dessen Inhalte genannt werden, sind diese Inhalte für die Einwilligung der Nutzer maßgeblich. Für die Anmeldung zu unserem Newsletter ist normalerweise die Angabe Ihrer E-Mail-Adresse ausreichend. Um Ihnen jedoch einen personalisierten Service bieten zu können, bitten wir gegebenenfalls um die Angabe Ihres Namens für eine persönliche Ansprache im Newsletter oder um weitere Informationen, falls diese für den Zweck des Newsletters notwendig sind.<br><br>',
            'Löschung und Einschränkung der Verarbeitung: Wir können die ausgetragenen E-Mail-Adressen bis zu drei Jahren auf Grundlage unserer berechtigten Interessen speichern, bevor wir sie löschen, um eine ehemals gegebene Einwilligung nachweisen zu können. Die Verarbeitung dieser Daten wird auf den Zweck einer potenziellen Abwehr von Ansprüchen beschränkt. Ein individueller Löschungsantrag ist jederzeit möglich, sofern zugleich das ehemalige Bestehen einer Einwilligung bestätigt wird. Im Fall von Pflichten zur dauerhaften Beachtung von Widersprüchen behalten wir uns die Speicherung der E-Mail-Adresse alleine zu diesem Zweck in einer Sperrliste (sogenannte „Blocklist") vor.<br><br>',
            'Die Protokollierung des Anmeldeverfahrens erfolgt auf Grundlage unserer berechtigten Interessen zum Zweck des Nachweises seines ordnungsgemäßen Ablaufs. Soweit wir einen Dienstleister mit dem Versand von E-Mails beauftragen, erfolgt dies auf Grundlage unserer berechtigten Interessen an einem effizienten und sicheren Versandsystem.<br><br>',
            '<strong>Inhalte:</strong>',
            '<br>Informationen zu uns, unseren Leistungen, Aktionen und Angeboten.<br><br>',
            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong>Bestandsdaten (z. B. der vollständige Name, Wohnadresse, Kontaktinformationen, Kundennummer, etc.); Kontaktdaten (z. B. Post- und E-Mail-Adressen oder Telefonnummern); Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen). Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz, verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen: </strong>Kommunikationspartner.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong>Direktmarketing (z. B. per E-Mail oder postalisch).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen: </strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Widerspruchsmöglichkeit (Opt-Out): </strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO).<br><br></li></ul>',
            
            '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</strong><br><br>',
            '<ul class="list-disc pl-5"><li><strong>Messung von Öffnungs- und Klickraten: </strong>Die Newsletter enthalten einen sogenannten „Web Beacon“, d. h. eine pixelgroße Datei, die beim Öffnen des Newsletters von unserem bzw. dessen Server, sofern wir einen Versanddienstleister einsetzen, abgerufen wird. Im Rahmen dieses Abrufs werden zunächst sowohl technische Informationen, wie beispielsweise Angaben zum Browser und Ihrem System, als auch Ihre IP-Adresse und der Zeitpunkt des Abrufs erhoben. Diese Informationen werden zur technischen Verbesserung unseres Newsletters anhand der technischen Daten oder der Zielgruppen und ihres Leseverhaltens auf Basis ihrer Abruforte (die mithilfe der IP-Adresse bestimmbar sind) oder der Zugriffszeiten genutzt. Diese Analyse beinhaltet ebenfalls die Feststellung, ob und wann die Newsletter geöffnet und welche Links angeklickt werden. Die Informationen werden den einzelnen Newsletterempfängern zugeordnet und in deren Profilen bis zur Löschung gespeichert. Die Auswertungen dienen dazu, die Lesegewohnheiten unserer Nutzer zu erkennen und unsere Inhalte an sie anzupassen oder unterschiedliche Inhalte entsprechend den Interessen unserer Nutzer zu versenden. Die Messung der Öffnungs- und Klickraten sowie die Speicherung der Messergebnisse in den Profilen der Nutzer erfolgen ausschließlich zum Zweck der Erfolgskontrolle, Reichweitenmessung, inhaltlichen Optimierung und Segmentierung unseres Newsletters. Hierzu verknüpfen wir die genannten Ereignisdaten (Öffnung, Klicks, Zeitpunkt, Kampagne) mit Ihrer bei der Anmeldung verwendeten E-Mail-Adresse in einem personenbezogenen, pseudonymen Newsletter-Profil. Eine Weitergabe der Auswertungsdaten an Dritte findet nicht statt, sofern dies nicht für den technischen Versand erforderlich ist. Personenbezogene Auswertungsdaten speichern wir für die Dauer Ihres Newsletter-Abonnements; nach Abmeldung werden die Profile gelöscht oder – soweit rechtlich zulässig – zu rein statistischen Zwecken anonymisiert. Sie können Ihre Einwilligung in die Erfolgsmessung jederzeit mit Wirkung für die Zukunft widerrufen, z. B. über den Abmeldelink am Ende jedes Newsletters oder per Mitteilung an die oben genannten Kontaktwege; zudem können Sie in Ihrem E-Mail-Programm das Laden von Bildern deaktivieren, wodurch die Öffnungsmessung eingeschränkt wird.<br><br></li></ul>',
            '<strong>Rechtsgrundlagen: </strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO).<br><br>',

        ],
        contentClass:'text-sm',
    },
            {
        title: 'Werbliche Kommunikation via E-Mail, Post, Fax oder Telefon',
        titleClass: 'font-semibold',
        content: [
            '<br>Wir verarbeiten personenbezogene Daten zu Zwecken der werblichen Kommunikation, die über diverse Kanäle, wie z. B. E-Mail, Telefon, Post oder Fax, entsprechend den gesetzlichen Vorgaben erfolgen kann.<br><br>',
            'Die Empfänger haben das Recht, erteilte Einwilligungen jederzeit zu widerrufen oder der werblichen Kommunikation jederzeit zu widersprechen.<br><br>',
            'Nach Widerruf oder Widerspruch speichern wir die zum Nachweis der bisherigen Berechtigung erforderlichen Daten zur Kontaktaufnahme oder Zusendung bis zu drei Jahre nach Ablauf des Jahres des Widerrufs oder Widerspruchs auf der Grundlage unserer berechtigten Interessen. Die Verarbeitung dieser Daten ist auf den Zweck einer möglichen Abwehr von Ansprüchen beschränkt. Auf der Grundlage des berechtigten Interesses, den Widerruf bzw. Widerspruch der Nutzer dauerhaft zu beachten, speichern wir ferner die zur Vermeidung einer erneuten Kontaktaufnahme erforderlichen Daten (z. B. je nach Kommunikationskanal die E-Mail-Adresse, Telefonnummer, Name).<br><br>',
            '<strong></strong>',
            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong>Bestandsdaten (z. B. der vollständige Name, Wohnadresse, Kontaktinformationen, Kundennummer, etc.); Kontaktdaten (z. B. Post- und E-Mail-Adressen oder Telefonnummern). Inhaltsdaten (z. B. textliche oder bildliche Nachrichten und Beiträge sowie die sie betreffenden Informationen, wie z. B. Angaben zur Autorenschaft oder Zeitpunkt der Erstellung).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen: </strong>Kommunikationspartner.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong>Direktmarketing (z. B. per E-Mail oder postalisch); Marketing. Absatzförderung.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Aufbewahrung und Löschung: </strong>Löschung entsprechend Angaben im Abschnitt "Allgemeine Informationen zur Datenspeicherung und Löschung".<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen: </strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO). Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).<br><br></li></ul>',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Webanalyse, Monitoring und Optimierung',
        titleClass: 'font-semibold',
        content: [
            '<br>Die Webanalyse (auch als „Reichweitenmessung" bezeichnet) dient der Auswertung der Besucherströme unseres Onlineangebots und kann Verhalten, Interessen oder demografische Informationen zu den Besuchern, wie beispielsweise Alter oder Geschlecht, als pseudonyme Werte umfassen. Mithilfe der Reichweitenanalyse können wir zum Beispiel erkennen, zu welcher Zeit unser Onlineangebot oder dessen Funktionen beziehungsweise Inhalte am häufigsten genutzt werden, oder zur Wiederverwendung einladen. Ebenso ist es uns möglich, nachzuvollziehen, welche Bereiche der Optimierung bedürfen.<br><br>',
            'Neben der Webanalyse können wir auch Testverfahren einsetzen, um etwa unterschiedliche Versionen unseres Onlineangebots oder seiner Bestandteile zu testen und zu optimieren.<br><br>',
            'Sofern nachfolgend nicht anders angegeben, können zu diesen Zwecken Profile, also zu einem Nutzungsvorgang zusammengefasste Daten, angelegt und Informationen in einem Browser bzw. in einem Endgerät gespeichert und dann ausgelesen werden. Zu den erhobenen Angaben gehören insbesondere besuchte Websites und dort genutzte Elemente sowie technische Auskünfte, wie etwa der verwendete Browser, das benutzte Computersystem sowie Angaben zu Nutzungszeiten. Sofern sich Nutzer in die Erhebung ihrer Standortdaten uns gegenüber oder gegenüber den Anbietern der von uns eingesetzten Dienste einverstanden erklärt haben, ist auch die Verarbeitung von Standortdaten möglich.<br><br>',
            'Darüber hinaus werden die IP-Adressen der Nutzer gespeichert. Jedoch nutzen wir ein IP-Masking-Verfahren (d. h. Pseudonymisierung durch Kürzung der IP-Adresse) zum Schutz der Nutzer. Generell werden die im Rahmen von Webanalyse, A/B-Testings und Optimierung keine Klardaten der Nutzer (wie z. B. E-Mail-Adressen oder Namen) gespeichert, sondern Pseudonyme. Das heißt, wir als auch die Anbieter der eingesetzten Software kennen nicht die tatsächliche Identität der Nutzer, sondern nur die zum Zweck der jeweiligen Verfahren in deren Profilen gespeicherten Angaben.<br><br>',
            'Hinweise zu Rechtsgrundlagen: Sofern wir die Nutzer um deren Einwilligung in den Einsatz der Drittanbieter bitten, stellt die Rechtsgrundlage der Datenverarbeitung die Einwilligung dar. Ansonsten werden die Nutzerdaten auf Grundlage unserer berechtigten Interessen (d. h. Interesse an effizienten, wirtschaftlichen und empfängerfreundlichen Leistungen) verarbeitet. In diesem Zusammenhang möchten wir Sie auch auf die Informationen zur Verwendung von Cookies in dieser Datenschutzerklärung hinweisen.<br><br>',
 
            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong>Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz, verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen). Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen: </strong>Nutzer (z. B. Webseitenbesucher, Nutzer von Onlinediensten).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong>Reichweitenmessung (z. B. Zugriffsstatistiken, Erkennung wiederkehrender Besucher); Profile mit nutzerbezogenen Informationen (Erstellen von Nutzerprofilen). Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Aufbewahrung und Löschung: </strong>Löschung entsprechend Angaben im Abschnitt "Allgemeine Informationen zur Datenspeicherung und Löschung". Speicherung von Cookies von bis zu 2 Jahren (Sofern nicht anders angegeben, können Cookies und ähnliche Speichermethoden für einen Zeitraum von zwei Jahren auf den Geräten der Nutzer gespeichert werden.).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Sicherheitsmaßnahmen: </strong> IP-Masking (Pseudonymisierung der IP-Adresse).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen: </strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO). Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).<br><br></li></ul>',
            
            '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten:</strong><br><br>',
            
            '<ul class="list-disc pl-5"><li><strong>Google Analytics: <br></strong><br>Wir verwenden Google Analytics zur Messung und Analyse der Nutzung unseres Onlineangebotes auf der Grundlage einer pseudonymen Nutzeridentifikationsnummer. Diese Identifikationsnummer enthält keine eindeutigen Daten, wie Namen oder E-Mail-Adressen. Sie dient dazu, Analyseinformationen einem Endgerät zuzuordnen, um zu erkennen, welche Inhalte die Nutzer innerhalb eines oder verschiedener Nutzungsvorgänge aufgerufen haben, welche Suchbegriffe sie verwendet haben, diese erneut aufgerufen haben oder mit unserem Onlineangebot interagiert haben. Ebenso werden der Zeitpunkt der Nutzung und deren Dauer gespeichert, sowie die Quellen der Nutzer, die auf unser Onlineangebot verweisen und technische Aspekte ihrer Endgeräte und Browser.<br>Dabei werden pseudonyme Profile von Nutzern mit Informationen aus der Nutzung verschiedener Geräte erstellt, wobei Cookies eingesetzt werden können. Google Analytics protokolliert und speichert keine individuellen IP-Adressen für EU-Nutzer. Analytics stellt jedoch grobe geografische Standortdaten bereit, indem es die folgenden Metadaten von IP-Adressen ableitet: Stadt (und der abgeleitete Breiten- und Längengrad der Stadt), Kontinent, Land, Region, Subkontinent (und ID-basierte Gegenstücke). Beim EU-Datenverkehr werden die IP-Adressdaten ausschließlich für diese Ableitung von Geolokalisierungsdaten verwendet, bevor sie sofort gelöscht werden. Sie werden nicht protokolliert, sind nicht zugänglich und werden nicht für weitere Verwendungszwecke genutzt. Wenn Google Analytics Messdaten sammelt, werden alle IP-Abfragen auf EU-basierten Servern durchgeführt, bevor der Verkehr zur Verarbeitung an Analytics-Server weitergeleitet wird.</li></ul><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Dienstanbieter: </strong><br>Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen: </strong><br>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO)<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Website: </strong><br><a href="https://marketingplatform.google.com/intl/de/about/analytics/" target="_blank">https://marketingplatform.google.com/intl/de/about/analytics/</a><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Sicherheitsmaßnahmen: </strong><br>IP-Masking (Pseudonymisierung der IP-Adresse);<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong> Datenschutzerklärung: </strong><br><a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Auftragsverarbeitungsvertrag: </strong><br><a href="https://business.safety.google/adsprocessorterms/" target="_blank">https://business.safety.google/adsprocessorterms/</a><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Drittlandtransfers: </strong><br>Data Privacy Framework (DPF), Standardvertragsklauseln (<a href="https://business.safety.google/adsprocessorterms" target="_blank">https://business.safety.google/adsprocessorterms</a>)<br><br></li></ul>',
            
            '<strong>Widerspruchsmöglichkeit (Opt-Out):</strong><br><br>',
 
            '<ul class="list-disc pl-5"><li><strong>Opt-Out-Plugin: </strong><a href="https://tools.google.com/dlpage/gaoptout?hl=de" target="_blank">https://tools.google.com/dlpage/gaoptout?hl=de</a><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Einstellungen für die Darstellung von Werbeeinblendungen: </strong><a href="https://myadcenter.google.com/personalizationoff" target="_blank">https://myadcenter.google.com/personalizationoff</a><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Weitere Informationen: </strong><br><a href="https://business.safety.google/adsservices/" target="_blank">https://business.safety.google/adsservices/</a> (Arten der Verarbeitung sowie der verarbeiteten Daten).<br><br></li></ul>',


        ],
        contentClass:'text-sm',
    },
    {
        title: 'Affiliate-Programme und Affiliate-Links',
        titleClass: 'font-semibold',
        content: [
            
            '<br>In unser Onlineangebot binden wir sogenannte Affiliate-Links oder andere Verweise (zu denen z. B. Suchmasken, Widgets oder Rabatt-Codes gehören können) auf die Angebote und Leistungen von Drittanbietern ein (zusammenfassend bezeichnet als "Affiliate-Links"). Wenn Nutzer den Affiliate-Links folgen, bzw. anschließend die Angebote wahrnehmen, können wir von diesen Drittanbietern eine Provision oder sonstige Vorteile erhalten (zusammenfassend bezeichnet als "Provision").<br><br>',
            'Um nachverfolgen zu können, ob die Nutzer die Angebote eines von uns eingesetzten Affiliate-Links wahrgenommen haben, ist es notwendig, dass die jeweiligen Drittanbieter erfahren, dass die Nutzer einem innerhalb unseres Onlineangebotes eingesetzten Affiliate-Link gefolgt sind. Die Zuordnung der Affiliate-Links zu den jeweiligen Geschäftsabschlüssen oder zu sonstigen Aktionen (z. B. Käufen) dient alleine dem Zweck der Provisionsabrechnung und wird aufgehoben, sobald sie für den Zweck nicht mehr erforderlich ist.<br><br>',
            'Für die Zwecke der vorgenannten Zuordnung der Affiliate-Links können die Affiliate-Links um bestimmte Werte ergänzt werden, die ein Bestandteil des Links sind oder anderweitig, z. B. in einem Cookie, gespeichert werden können. Zu den Werten können insbesondere die Ausgangswebseite (Referrer), der Zeitpunkt, eine Online-Kennung der Betreiber der Webseite, auf der sich der Affiliate-Link befand, eine Online-Kennung des jeweiligen Angebotes, die Art des verwendeten Links, die Art des Angebotes und eine Online-Kennung des Nutzers gehören.<br><br>',

            '<strong>Hinweise zu Rechtsgrundlagen:</strong> Sofern wir die Nutzer um deren Einwilligung in den Einsatz der Drittanbieter bitten, ist die Rechtsgrundlage der Verarbeitung von Daten die Einwilligung. Ansonsten werden die Daten der Nutzer auf Grundlage unserer berechtigten Interessen (d. h. Interesse an effizienten, wirtschaftlichen und empfängerfreundlichen Leistungen) verarbeitet. In diesem Zusammenhang möchten wir Sie auch auf die Informationen zur Verwendung von Cookies in dieser Datenschutzerklärung hinweisen.<br><br>',
            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong>Vertragsdaten (z. B. Vertragsgegenstand, Laufzeit, Kundenkategorie); Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz, verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen). Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen: </strong> Interessenten. Nutzer (z. B. Webseitenbesucher, Nutzer von Onlinediensten).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong>Affiliate-Nachverfolgung.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Aufbewahrung und Löschung: </strong>Löschung entsprechend Angaben im Abschnitt "Allgemeine Informationen zur Datenspeicherung und Löschung".<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen: </strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO). Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).<br><br></li></ul>',
        
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Kundenrezensionen und Bewertungsverfahren',
        titleClass: 'font-semibold',
        content: [
            '<br>Wir nehmen an Rezensions- und Bewertungsverfahren teil, um unsere Leistungen zu evaluieren, zu optimieren und zu bewerben. Wenn Nutzer uns über die beteiligten Bewertungsplattformen oder -verfahren bewerten oder anderweitig Feedback geben, gelten zusätzlich die Allgemeinen Geschäfts- oder Nutzungsbedingungen und die Datenschutzhinweise der Anbieter. Im Regelfall setzt die Bewertung zudem eine Registrierung bei den jeweiligen Anbietern voraus.<br><br>',
            'Um sicherzustellen, dass die bewertenden Personen tatsächlich unsere Leistungen in Anspruch genommen haben, übermitteln wir mit Einwilligung der Kunden die hierzu erforderlichen Daten im Hinblick auf den Kunden und die in Anspruch genommene Leistung an die jeweilige Bewertungsplattform (einschließlich Name, E-Mail-Adresse und Bestellnummer bzw. Artikelnummer). Diese Daten werden alleine zur Verifizierung der Authentizität des Nutzers verwendet.<br><br>',

            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong>Vertragsdaten (z. B. Vertragsgegenstand, Laufzeit, Kundenkategorie); Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz, verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen). Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen: </strong> Leistungsempfänger und Auftraggeber. Nutzer (z. B. Webseitenbesucher, Nutzer von Onlinediensten).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong>Feedback (z. B. Sammeln von Feedback via Online-Formular). Marketing.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).<br><br></li></ul>',
        
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Präsenzen in sozialen Netzwerken (Social Media)',
        titleClass: 'font-semibold',
        content: [
            '<br>Wir unterhalten Onlinepräsenzen innerhalb sozialer Netzwerke und verarbeiten in diesem Rahmen Nutzerdaten, um mit den dort aktiven Nutzern zu kommunizieren oder Informationen über uns anzubieten.<br><br>',
            'Wir weisen darauf hin, dass dabei Nutzerdaten außerhalb des Raumes der Europäischen Union verarbeitet werden können. Hierdurch können sich für die Nutzer Risiken ergeben, weil so zum Beispiel die Durchsetzung der Nutzerrechte erschwert werden könnte.<br><br>',
            'Ferner werden die Daten der Nutzer innerhalb sozialer Netzwerke im Regelfall für Marktforschungs- und Werbezwecke verarbeitet. So können beispielsweise anhand des Nutzungsverhaltens und sich daraus ergebender Interessen der Nutzer Nutzungsprofile erstellt werden. Letztere finden möglicherweise wiederum Verwendung, um etwa Werbeanzeigen innerhalb und außerhalb der Netzwerke zu schalten, die mutmaßlich den Interessen der Nutzer entsprechen. Daher werden im Regelfall Cookies auf den Rechnern der Nutzer gespeichert, in denen das Nutzungsverhalten und die Interessen der Nutzer gespeichert werden. Zudem können in den Nutzungsprofilen auch Daten unabhängig der von den Nutzern verwendeten Geräten gespeichert werden (insbesondere, wenn sie Mitglieder der jeweiligen Plattformen und dort eingeloggt sind).<br><br>',
            'Für eine detaillierte Darstellung der jeweiligen Verarbeitungsformen und der Widerspruchsmöglichkeiten (Opt-out) verweisen wir auf die Datenschutzerklärungen und Angaben der Betreiber der jeweiligen Netzwerke.<br><br>',
            'Auch im Fall von Auskunftsanfragen und der Geltendmachung von Betroffenenrechten weisen wir darauf hin, dass diese am effektivsten bei den Anbietern geltend gemacht werden können. Nur Letztere haben jeweils Zugriff auf die Nutzerdaten und können direkt entsprechende Maßnahmen ergreifen und Auskünfte geben. Sollten Sie dennoch Hilfe benötigen, dann können Sie sich an uns wenden.<br><br>',

            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong>Kontaktdaten (z. B. Post- und E-Mail-Adressen oder Telefonnummern); Inhaltsdaten (z. B. textliche oder bildliche Nachrichten und Beiträge sowie die sie betreffenden Informationen, wie z. B. Angaben zur Autorenschaft oder Zeitpunkt der Erstellung). Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz, verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen: </strong>Nutzer (z. B. Webseitenbesucher, Nutzer von Onlinediensten).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong>Kommunikation; Feedback (z. B. Sammeln von Feedback via Online-Formular). Öffentlichkeitsarbeit.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Aufbewahrung und Löschung: </strong>Löschung entsprechend Angaben im Abschnitt "Allgemeine Informationen zur Datenspeicherung und Löschung".<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen: </strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).<br><br></li></ul>',
            
            '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten: </strong><br><br>',
            '<ul class="list-disc pl-5"><li><strong>Instagram: </strong></strong>Soziales Netzwerk, ermöglicht das Teilen von Fotos und Videos, das Kommentieren und Favorisieren von Beiträgen, Nachrichtenversand, Abonnieren von Profilen und Seiten; <strong>Dienstanbieter:</strong> Meta Platforms Ireland Limited, Merrion Road, Dublin 4, D04 X2K5, Irland; <span class=""><strong>Rechtsgrundlagen:</strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO); </span><strong>Website:</strong> <a href="https://www.instagram.com" target="_blank">https://www.instagram.com</a>; <strong>Datenschutzerklärung:</strong> <a href="https://privacycenter.instagram.com/policy/" target="_blank">https://privacycenter.instagram.com/policy/</a>. <strong>Grundlage Drittlandtransfers:</strong> Data Privacy Framework (DPF).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>LinkedIn: </strong>Soziales Netzwerk - Wir sind gemeinsam mit LinkedIn Irland Unlimited Company für die Erhebung (jedoch nicht die weitere Verarbeitung) von Daten der Besucher verantwortlich, die zur Erstellung der „Page-Insights" (Statistiken) unserer LinkedIn-Profile genutzt werden. Zu diesen Daten gehören Informationen über die Arten von Inhalten, die Nutzer sich ansehen oder mit denen sie interagieren, sowie die von ihnen vorgenommenen Handlungen. Außerdem werden Details über die genutzten Geräte erfasst, wie z. B. IP-Adressen, Betriebssystem, Browsertyp, Spracheinstellungen und Cookie-Daten, sowie Angaben aus den Nutzerprofilen, wie Berufsfunktion, Land, Branche, Hierarchieebene, Unternehmensgröße und Beschäftigungsstatus. Datenschutzinformationen zur Verarbeitung von Nutzerdaten durch LinkedIn können den Datenschutzhinweisen von LinkedIn entnommen werden: <a href="https://www.linkedin.com/legal/privacy-policy" target="_blank">https://www.linkedin.com/legal/privacy-policy.</a><br>Wir haben mit LinkedIn Irland eine spezielle Vereinbarung geschlossen („Page Insights Joint Controller Addendum", <a href="https://legal.linkedin.com/pages-joint-controller-addendum" target="_blank">https://legal.linkedin.com/pages-joint-controller-addendum</a>), in der insbesondere geregelt wird, welche Sicherheitsmaßnahmen LinkedIn beachten muss und in der LinkedIn sich bereit erklärt hat, die Rechte der Betroffenen zu erfüllen (d. h. Nutzer können z. B. Auskunfts- oder Löschungsanfragen direkt an LinkedIn richten). Die Rechte der Nutzer (insbesondere das Recht auf Auskunft, Löschung, Widerspruch und Beschwerde bei der zuständigen Aufsichtsbehörde) werden durch die Vereinbarungen mit LinkedIn nicht eingeschränkt. Die gemeinsame Verantwortlichkeit beschränkt sich auf die Erhebung und Übermittlung der Daten an LinkedIn Irland Unlimited Company, ein Unternehmen mit Sitz in der EU. Die weitere Verarbeitung der Daten obliegt ausschließlich LinkedIn Irland Unlimited Company, insbesondere was die Übermittlung der Daten an die Muttergesellschaft LinkedIn Corporation in den USA betrifft; <strong>Dienstanbieter:</strong> LinkedIn Ireland Unlimited Company, Wilton Place, Dublin 2, Irland; <span class=""><strong>Rechtsgrundlagen:</strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO); </span><strong>Website:</strong> <a href="https://www.linkedin.com" target="_blank">https://www.linkedin.com</a>; <strong>Datenschutzerklärung:</strong> <a href="https://www.linkedin.com/legal/privacy-policy" target="_blank">https://www.linkedin.com/legal/privacy-policy</a>; <strong>Grundlage Drittlandtransfers:</strong> Data Privacy Framework (DPF), Standardvertragsklauseln (<a href="https://legal.linkedin.com/dpa" target="_blank">https://legal.linkedin.com/dpa</a>). <strong>Widerspruchsmöglichkeit (Opt-Out):</strong> <a href="https://www.linkedin.com/psettings/guest-controls/retargeting-opt-out" target="_blank">https://www.linkedin.com/psettings/guest-controls/retargeting-opt-out</a>.<br><br></li></ul>',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Plug-ins und eingebettete Funktionen sowie Inhalte ',
        titleClass: 'font-semibold',
        content: [
            '<br>Wir binden Funktions- und Inhaltselemente in unser Onlineangebot ein, die von den Servern ihrer jeweiligen Anbieter (nachfolgend als „Drittanbieter" bezeichnet) bezogen werden. Dabei kann es sich zum Beispiel um Grafiken, Videos oder Stadtpläne handeln (nachfolgend einheitlich als „Inhalte" bezeichnet).<br><br>',
            'Die Einbindung setzt immer voraus, dass die Drittanbieter dieser Inhalte die IP-Adresse der Nutzer verarbeiten, da sie ohne IP-Adresse die Inhalte nicht an deren Browser senden könnten. Die IP-Adresse ist damit für die Darstellung dieser Inhalte oder Funktionen erforderlich. Wir bemühen uns, nur solche Inhalte zu verwenden, deren jeweilige Anbieter die IP-Adresse lediglich zur Auslieferung der Inhalte anzuwenden. Drittanbieter können ferner sogenannte Pixel-Tags (unsichtbare Grafiken, auch als „Web Beacons" bezeichnet) für statistische oder Marketingzwecke einsetzen. Durch die „Pixel-Tags" können Informationen, wie etwa der Besucherverkehr auf den Seiten dieser Website, ausgewertet werden. Die pseudonymen Informationen können darüber hinaus in Cookies auf dem Gerät der Nutzer gespeichert werden und unter anderem technische Auskünfte zum Browser und zum Betriebssystem, zu verweisenden Websites, zur Besuchszeit sowie weitere Angaben zur Nutzung unseres Onlineangebots enthalten, aber auch mit solchen Informationen aus anderen Quellen verbunden werden.<br><br>',
            '<br><br>',
            '<strong>Hinweise zu Rechtsgrundlagen: </strong>Sofern wir die Nutzer um ihre Einwilligung in den Einsatz der Drittanbieter bitten, stellt die Rechtsgrundlage der Datenverarbeitung die Erlaubnis dar. Ansonsten werden die Nutzerdaten auf Grundlage unserer berechtigten Interessen (d. h. Interesse an effizienten, wirtschaftlichen und empfängerfreundlichen Leistungen) verarbeitet. In diesem Zusammenhang möchten wir Sie auch auf die Informationen zur Verwendung von Cookies in dieser Datenschutzerklärung hinweisen.<br><br>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Verarbeitete Datenarten: </strong>Nutzungsdaten (z. B. Seitenaufrufe und Verweildauer, Klickpfade, Nutzungsintensität und -frequenz, verwendete Gerätetypen und Betriebssysteme, Interaktionen mit Inhalten und Funktionen). Meta-, Kommunikations- und Verfahrensdaten (z. B. IP-Adressen, Zeitangaben, Identifikationsnummern, beteiligte Personen).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Betroffene Personen: </strong>Nutzer (z. B. Webseitenbesucher, Nutzer von Onlinediensten).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Zwecke der Verarbeitung: </strong>Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit; Reichweitenmessung (z. B. Zugriffsstatistiken, Erkennung wiederkehrender Besucher); Tracking (z. B. interessens-/verhaltensbezogenes Profiling, Nutzung von Cookies); Zielgruppenbildung. Marketing.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Aufbewahrung und Löschung: </strong> Löschung entsprechend Angaben im Abschnitt "Allgemeine Informationen zur Datenspeicherung und Löschung". Speicherung von Cookies von bis zu 2 Jahren (Sofern nicht anders angegeben, können Cookies und ähnliche Speichermethoden für einen Zeitraum von zwei Jahren auf den Geräten der Nutzer gespeichert werden.).<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>Rechtsgrundlagen: </strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO). Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO).<br><br></li></ul>',
        
            '<strong>Weitere Hinweise zu Verarbeitungsprozessen, Verfahren und Diensten: </strong><br><br>',
            '<ul class="list-disc pl-5"><li><strong>Google Fonts (Bezug vom Google Server): </strong>Bezug von Schriften (und Symbolen) zum Zwecke einer technisch sicheren, wartungsfreien und effizienten Nutzung von Schriften und Symbolen im Hinblick auf Aktualität und Ladezeiten, deren einheitliche Darstellung und Berücksichtigung möglicher lizenzrechtlicher Beschränkungen. Dem Anbieter der Schriftarten wird die IP-Adresse des Nutzers mitgeteilt, damit die Schriftarten im Browser des Nutzers zur Verfügung gestellt werden können. Darüber hinaus werden technische Daten (Spracheinstellungen, Bildschirmauflösung, Betriebssystem, verwendete Hardware) übermittelt, die für die Bereitstellung der Schriften in Abhängigkeit von den verwendeten Geräten und der technischen Umgebung notwendig sind. Diese Daten können auf einem Server des Anbieters der Schriftarten in den USA verarbeitet werden - Beim Besuch unseres Onlineangebotes senden die Browser der Nutzer ihre Browser HTTP-Anfragen an die Google Fonts Web API (d. h. eine Softwareschnittstelle für den Abruf der Schriftarten). Die Google Fonts Web API stellt den Nutzern die Cascading Style Sheets (CSS) von Google Fonts und danach die in der CCS angegebenen Schriftarten zur Verfügung. Zu diesen HTTP-Anfragen gehören (1) die vom jeweiligen Nutzer für den Zugriff auf das Internet verwendete IP-Adresse, (2) die angeforderte URL auf dem Google-Server und (3) die HTTP-Header, einschließlich des User-Agents, der die Browser- und Betriebssystemversionen der Websitebesucher beschreibt, sowie die Verweis-URL (d. h. die Webseite, auf der die Google-Schriftart angezeigt werden soll). IP-Adressen werden weder auf Google-Servern protokolliert noch gespeichert und sie werden nicht analysiert. Die Google Fonts Web API protokolliert Details der HTTP-Anfragen (angeforderte URL, User-Agent und Verweis-URL). Der Zugriff auf diese Daten ist eingeschränkt und streng kontrolliert. Die angeforderte URL identifiziert die Schriftfamilien, für die der Nutzer Schriftarten laden möchte. Diese Daten werden protokolliert, damit Google bestimmen kann, wie oft eine bestimmte Schriftfamilie angefordert wird. Bei der Google Fonts Web API muss der User-Agent die Schriftart anpassen, die für den jeweiligen Browsertyp generiert wird. Der User-Agent wird in erster Linie zum Debugging protokolliert und verwendet, um aggregierte Nutzungsstatistiken zu generieren, mit denen die Beliebtheit von Schriftfamilien gemessen wird. Diese zusammengefassten Nutzungsstatistiken werden auf der Seite „Analysen" von Google Fonts veröffentlicht. Schließlich wird die Verweis-URL protokolliert, sodass die Daten für die Wartung der Produktion verwendet und ein aggregierter Bericht zu den Top-Integrationen basierend auf der Anzahl der Schriftartenanfragen generiert werden kann. Google verwendet laut eigener Auskunft keine der von Google Fonts erfassten Informationen, um Profile von Endnutzern zu erstellen oder zielgerichtete Anzeigen zu schalten; <strong>Dienstanbieter:</strong> Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland; <span class=""><strong>Rechtsgrundlagen:</strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f) DSGVO); </span><strong>Website:</strong> <a href="https://fonts.google.com/" target="_blank">https://fonts.google.com/</a>; <strong>Datenschutzerklärung:</strong> <a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a>; <strong>Grundlage Drittlandtransfers:</strong> Data Privacy Framework (DPF). <strong>Weitere Informationen:</strong> <a href="https://developers.google.com/fonts/faq/privacy?hl=de" target="_blank">https://developers.google.com/fonts/faq/privacy?hl=de</a>.<br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong>YouTube-Videos: </strong>Videoinhalte; <strong>Dienstanbieter:</strong> Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland; <span class=""><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a) DSGVO); </span><strong>Website:</strong> <a href="https://www.youtube.com" target="_blank">https://www.youtube.com</a>; <strong>Datenschutzerklärung:</strong> <a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a>; <strong>Grundlage Drittlandtransfers:</strong> Data Privacy Framework (DPF). <strong>Widerspruchsmöglichkeit (Opt-Out):</strong> Opt-Out-Plugin: <a href="https://tools.google.com/dlpage/gaoptout?hl=de" target="_blank">https://tools.google.com/dlpage/gaoptout?hl=de</a>,  Einstellungen für die Darstellung von Werbeeinblendungen: <a href="https://myadcenter.google.com/personalizationoff" target="_blank">https://myadcenter.google.com/personalizationoff</a>.</li></ul><p class="seal"><a href="https://datenschutz-generator.de/".<br><br></li></ul>',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Einsatz von Google Analytics',
        titleClass: 'font-semibold',
        content: [
            
            '<br>Wir nutzen den Webanalysedienst Google Analytics, bereitgestellt von Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA bzw. Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland. Google Analytics verwendet Cookies und ähnliche Technologien, die eine Analyse der Nutzung unserer Website durch Sie ermöglichen. Dabei können pseudonymisierte Informationen über die Benutzung dieser Website erhoben und an Server von Google in den USA übertragen und dort gespeichert werden. <br><br>',
            
            '<strong>Zweck der Verarbeitung</strong><br>',
            '<ul class="list-disc pl-5"><li> Die Nutzung von Google Analytics dient der Analyse des Nutzerverhaltens, um unsere Website und unser Angebot stetig zu verbessern. <br><br></li></ul>',

            '<strong>Datenweitergabe an Google</strong><br>',
            '<ul class="list-disc pl-5"><li> Wenn die Einstellung zur Datenfreigabe aktiviert ist, können die erhobenen Daten auch von Google selbst zu eigenen Zwecken, z. B. zur Verbesserung von Produkten und Diensten, verarbeitet werden. In diesem Fall handeln wir und Google als eigenständige Verantwortliche im Sinne der DSGVO. <br><br></li></ul>',

            '<strong>Rechtsgrundlage</strong><br>',
            '<ul class="list-disc pl-5"><li> Die Verarbeitung erfolgt ausschließlich mit Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Diese können Sie über unser Consent-Tool jederzeit erteilen oder widerrufen. <br><br></li></ul>',

            '<strong>Maßnahmen zum Schutz Ihrer Daten</strong><br>',
            '<ul class="list-disc pl-5"><li> IP-Anonymisierung ist auf dieser Website aktiviert, sodass Ihre IP-Adresse innerhalb der EU/EWR vor der Übertragung an Google gekürzt wird. <br></li></ul>',
            '<ul class="list-disc pl-5"><li> Wir haben mit Google die notwendigen Verträge und Standardvertragsklauseln abgeschlossen, um ein angemessenes Datenschutzniveau sicherzustellen. <br></li></ul>',
            '<ul class="list-disc pl-5"><li> Sie können die Speicherung von Cookies verhindern, indem Sie Ihre Browser-Einstellungen anpassen oder die Erfassung durch Google Analytics mit einem Browser-Add-on verhindern: https://tools.google.com/dlpage/gaoptout. <br><br></li></ul>',

            '<strong>Speicher- und Löschfristen</strong><br>',
            '<ul class="list-disc pl-5"><li> Die von uns gesetzten Cookies werden nach maximal 2 Jahren gelöscht. Reports und statistische Daten in Google Analytics werden je nach gewählter Einstellung nach 14 Monaten gelöscht. <br><br></li></ul>',

            '<strong>Empfänger</strong><br>',
            '<ul class="list-disc pl-5"><li>Empfänger der Daten ist Google LLC (USA). Eine Datenübermittlung in die USA kann stattfinden. Google ist verpflichtet, hierfür geeignete Schutzmechanismen (z. B. Standardvertragsklauseln oder das EU-U.S. Data Privacy Framework) einzuhalten. <br><br></li></ul>',
        
        ],
        contentClass:'text-sm',
    },
    /* TEMPLATE Für Spätere Einträge
    {
        title: '',
        titleClass: 'font-semibold',
        content: [
            '<br><br><br>',
            '<br><br>',
            '<strong></strong>',
            '<ul class="list-disc pl-5"><li><strong>YouTube-Videos: </strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
            '<ul class="list-disc pl-5"><li><strong></strong><br><br></li></ul>',
        
        ],
        contentClass:'text-sm',
    },*/
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
            </div>
        </div>
    </div>
</template>


<!-- Übersetzungs Vorlage

<!-- /resources/js/Pages/Privacy.vue 

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

defineOptions({ layout: AppLayout });

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

// Die "Schablone" (Interface) für unsere Abschnitte.
// Wir ändern `title` und `content` zu `titleKey` und `contentKey`.
interface PrivacySection {
    titleKey: string;
    contentKey: string;
    isMainTitle?: boolean;
    isSubSection?: boolean;
    titleClass?: string;
    contentClass?: string;
}

// Die STRUKTUR der Seite wird hier definiert.
// Der INHALT wird reaktiv aus den JSON-Dateien geladen.
const privacySections = computed<PrivacySection[]>(() => [
    {
        titleKey: 'privacy.s0.title',
        contentKey: 'privacy.s0.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'privacy.s1.title',
        contentKey: 'privacy.s1.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'privacy.s2.title',
        contentKey: 'privacy.s2.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'privacy.s3.title',
        contentKey: 'privacy.s3.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'privacy.s4.title',
        contentKey: 'privacy.s4.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'privacy.s5.title',
        contentKey: 'privacy.s5.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'privacy.s6.title',
        contentKey: 'privacy.s6.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'privacy.s7.title',
        contentKey: 'privacy.s7.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    // Hinweis: Ich habe hier nur die ersten 8 Abschnitte übersetzt,
    // um die JSON-Dateien nicht zu überladen. Das Prinzip ist für alle
    // weiteren Abschnitte exakt dasselbe:
    // 1. Schlüssel in de.json & en.json anlegen (z.B. "privacy.s8.title")
    // 2. Neuen Abschnitt hier in der `computed`-Property hinzufügen.
]);
</script>

<template>
    <Head :title="t('privacy.head_title')"/>
    
    <!-- Der Hauptcontainer für die Seite 
    <div class="container mx-auto px-4 py-8 md:py-20">
        <!-- Die Inhalts-Karte 
        <div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-lg shadow-2xl overflow-hidden">
            
            <!-- Der Header mit Farbverlauf und Hintergrund-Icon 
            <div class="relative bg-gradient-to-br from-blue-700 to-blue-800 p-8 md:p-12 overflow-hidden">
                <!-- Das Icon (Schild) liegt im Hintergrund --
                <div class="absolute -bottom-12 -right-12 text-white opacity-10">
                    <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" width="160" height="160" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
                </div>

                <!-- Der Text liegt mit z-10 im Vordergrund --
                <div class="relative z-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-white">
                        {{ $t('privacy.main_headline') }}
                    </h1>
                    <p class="mt-2 text-blue-200">{{ $t('privacy.last_updated') }}</p>
                </div>
            </div>

            <!-- Der eigentliche Textinhalt auf weißem/dunklem Hintergrund --
            <div class="p-8 md:p-12 prose dark:prose-invert max-w-none">
                <!-- Das Template rendert den Inhalt jetzt dynamisch aus der computed-Property --
                <div v-for="(section, index) in privacySections" :key="index" class="mb-8 last:mb-0">
                    
                    <h1 v-if="section.isMainTitle" :class="section.titleClass" class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">{{ t(section.titleKey) }}</h1>
                    <h2 v-else-if="!section.isSubSection" :class="section.titleClass">{{ t(section.titleKey) }}</h2>
                    <strong v-else :class="section.titleClass">{{ t(section.titleKey) }}</strong>
                    
                    <div
                        v-html="t(section.contentKey)"
                        class="text-gray-700 dark:text-gray-300"
                        :class="section.contentClass"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>






-->