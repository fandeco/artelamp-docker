<?php
/**
 * Default Dutch Lexicon Entries for SEO Suite
 *
 * @package seosuite
 * @subpackage lexicon
 */

$_lang['seosuite'] = 'SEO Suite';

$_lang['seosuite.menu.seosuite']      = 'SEO Suite';
$_lang['seosuite.menu.seosuite_desc'] = 'Beheer je 404 URL\'s.';

$_lang['seosuite.global.search'] = 'Zoeken';

$_lang['seosuite.url.urls']      = '404 URL\'s';
$_lang['seosuite.url.intro_msg'] = '404 errors zijn ontzettend vervelend, voor zowel de gebruiker en Google, en kunnen relevant verkeer van je website weghouden. 
 Met de MODX Extra \'SEO Suite\' kunnen 404 errors gemakkelijk opgelost worden. Upload simpelweg een bestand met alle errors en SEO Suite zoekt matches met bestaande pagina’s:<br/><br/>
1. Als er één match is gevonden zal SEO Suite de pagina automatisch redirecten naar deze functionerende pagina<br/>
2. Als er meerdere matched gevonden zijn, geeft SEO Suite suggesties en kun jij kiezen naar welke pagina geredirect wordt<br/>
3. Als er geen matches gevonden zijn, kun jij handmatig de juiste URL invoeren.';
$_lang['seosuite.url.import']          = 'Importeer bestand';
$_lang['seosuite.url.file']            = 'Bestand';
$_lang['seosuite.import.start']        = 'Starten met importeren van de URL\'s, dit kan even duren afhankelijk van de grootte van je bestand.';
$_lang['seosuite.import.instructions'] = 'Gebruik een .csv, .xls of .xlsx bestand. Zorg ervoor dat je de complete URL\'s hebt ingevuld, inclusief de domeinnaam. Voorbeeld: https://www.seosuite.com in plaats van seosuite.com.';

$_lang['seosuite.url.url']                        = '404 URL';
$_lang['seosuite.url.solved']                     = 'Opgelost';
$_lang['seosuite.url.position']                   = 'Positie';
$_lang['seosuite.url.redirect_to']                = 'Redirect naar';
$_lang['seosuite.url.suggestions']                = 'Redirect suggesties';
$_lang['seosuite.url.triggered']                  = '404 Aanroepen';
$_lang['seosuite.url.createdon']                  = '404 Aanmaakdatum';
$_lang['seosuite.url.find_suggestions']           = 'Vind suggesties';
$_lang['seosuite.url.found_suggestions']          = 'Er is een suggestie gevonden! De suggestie is nu verbonden met deze URL.';
$_lang['seosuite.url.found_suggestions_multiple'] = 'Er is meer dan 1 suggestie gevonden. Voeg a.u.b. handmatig een redirect toe.';
$_lang['seosuite.url.notfound_suggestions']       = 'Er zijn geen suggesties gevonden voor deze URL.';
$_lang['seosuite.url.update']                     = 'Update URL';
$_lang['seosuite.url.remove']                     = 'Verwijder URL';
$_lang['seosuite.url.remove_confirm']             = 'Weet je zeker dat je deze URL wil verwijderen?';
$_lang['seosuite.url.choose_suggestion']          = 'Kies uit suggesties';
$_lang['seosuite.url.choose_manually']            = 'Kies handmatig een pagina';
$_lang['seosuite.url.redirect_to_selected']       = 'Geselecteerde redirect';

$_lang['seosuite.error.url_alreadyexists']       = 'Deze URL bestaat al.';
$_lang['seosuite.error.url_notfound']            = 'Item niet gevonden.';
$_lang['seosuite.err.item_name_ae']              = 'Item niet gevonden.';
$_lang['seosuite.error.url_notspecified']        = 'URL is niet gedefinieerd.';
$_lang['seosuite.err.item_name_ns']              = 'Waarde is niet gedefinieerd.';
$_lang['seosuite.error.url_remove']              = 'Er is een fout opgetreden tijdens het verwijderen van de URL.';
$_lang['seosuite.error.url_save']                = 'Er is een fout opgetreden tijdens het opslaan van de URL.';
$_lang['seosuite.error.emptyfile']               = 'Geen bestand opgegeve.';
$_lang['seosuite.error.extension_notallowed']    = 'Bestandstype niet toegestaan. Alleen .csv bestanden zijn toegestaan.';
$_lang['seosuite.error.ziparchive_notinstalled'] = 'PHP extensie ZipArchive is niet geïnstalleerd, 
deze is nodig om xls(x) bestanden te importeren. Installeer de ZipArchive extensie of gebruik een .csv bestand.';

$_lang['seosuite.import.seoUrl.error'] = 'De gevonden suggestie kon niet automatisch worden toegevoegd als redirect. Voeg deze a.u.b. handmatig toe.';
$_lang['seosuite.import.seoUrl.error'] = 'De suggestie kon niet worden verbonden met de SEO Tab URL. Verbind deze a.u.b. handmatig.';
$_lang['seosuite.seotab.notfound']     = 'SEO Tab is niet geïnstalleerd of de versie is ongeldig. 
Installeer a.u.b. SEO Tab (versie 2.0 of hoger) om SEO Suite in staat te stellen
 om redirects automatisch te koppelen aan 404 URL\'s.';
$_lang['seosuite.seotab.versioninvalid'] = 'De geinstalleerde versie van Seo Tab is verouderd. 
Installeer Seo Tab versie 2 (of hoger) om een redirect te kunnen toevoegen.';

$_lang['seosuite.widget_desc'] = 'Hier zie je de meest recent toegevoegde 404 URL\'s. Om alle 404 URL\'s te bekijken en beheren, 
 ga je naar de <a href="[[++manager_url]]?a=home&amp;namespace=seosuite">SEO Suite manager pagina.</a>';

$_lang['seosuite.match_site_url']      = 'Match op basis van de context site url';
$_lang['seosuite.match_site_url_desc'] = 'Vink aan als het matching systeem alleen pagina\'s moet matches op basis van dezelfde context. 
 Dit is vooral handig als je een meertalige website hebt waarbij meerdere contexten veel dezelfde pagina\'s hebben.';

$_lang['setting_seosuite.exclude_words']      = 'Uitgesloten woorden';
$_lang['setting_seosuite.exclude_words_desc'] = 'Komma gescheiden lijst van woorden welke dienen te worden uitgesloten van de gevonden suggesties.';
