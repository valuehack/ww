<?php

/**
 * Please note: we can use unencoded characters like ö, é etc here as we use the html5 doctype with utf8 encoding
 * in the application's header (in views/_header.php). To add new languages simply copy this file,
 * and create a language switch in your root files.
 */

// login & registration classes
define("MESSAGE_ACCOUNT_NOT_ACTIVATED", "Ihr Account wurde noch nicht aktiviert. Bitte klicken Sie auf den Best&auml;tigungslink in der E-Mail.");
define("MESSAGE_CAPTCHA_WRONG", "Captcha falsch!");
define("MESSAGE_COOKIE_INVALID", "Ung&uuml;ltiger Cookie");
define("MESSAGE_DATABASE_ERROR", "Verbindung zur Datenbank fehlgeschlagen!");
define("MESSAGE_EMAIL_ALREADY_EXISTS", "Diese E-Mail-Adresse ist bereits registriert. Ein Passwort wurde Ihnen zugesandt. <a href='/password_reset.php'>Passwort vergessen?");
define("MESSAGE_EMAIL_CHANGE_FAILED", "&Auml;nderung der E-Mail-Adresse fehlgeschlagen");
define("MESSAGE_EMAIL_CHANGED_SUCCESSFULLY", "Die &Auml;nderung der E-Mail-Adresse war erfolgreich. Die neue Adresse lautet ");
define("MESSAGE_EMAIL_EMPTY", "E-Mail-Feld leer");
define("MESSAGE_EMAIL_INVALID", "E-Mail-Adresse ung&uuml;ltig");
define("MESSAGE_EMAIL_SAME_LIKE_OLD_ONE", "Diese E-Mail-Adresse ist ident mit der alten. Bitte verwenden Sie eine andere.");
define("MESSAGE_EMAIL_TOO_LONG", "Ihre Email darf nicht l&auml;nger als 64 Zeichen sein");
define("MESSAGE_LINK_PARAMETER_EMPTY", "Dieser Link ist ohne Inhalt.");
define("MESSAGE_LOGGED_OUT", "Erfolgreich ausgeloggt.");
// The "login failed"-message is a security improved feedback that doesn't show a potential attacker if the user exists or not
define("MESSAGE_LOGIN_FAILED", "Login fehlgeschlagen. Sollten Sie Probleme mit der Anmeldung haben, schreiben Sie eine E-Mail an info@scholarium.at");
define("MESSAGE_OLD_PASSWORD_WRONG", "Das ALTE Passwort war falsch.");
define("MESSAGE_PASSWORD_BAD_CONFIRM", "Die Passw&ouml;rter stimmen nicht &uuml;berein.");
define("MESSAGE_PASSWORD_CHANGE_FAILED", "Verzeihen sie bitte, ihre Passwortver&auml;nderung ist fehlgeschlagen.");
define("MESSAGE_PASSWORD_CHANGED_SUCCESSFULLY", "Passwort erfolgreich ge&auml;ndert!");
define("MESSAGE_PASSWORD_EMPTY", "Passwort-Feld ist leer");
define("MESSAGE_PASSWORD_RESET_MAIL_FAILED", "Passwort zur&uuml;ksetzen E-mail wurde NICHT erfolgreich gesendet! Fehler ");
define("MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT", "\"Passwort zur&uuml;cksetzen\"-E-Mail wurde erfolgreich versendet");
define("MESSAGE_PASSWORD_TOO_SHORT", "Passwort muss mindestens 6 Zeichen haben");
define("MESSAGE_PASSWORD_WRONG", "Passwort falsch. <a href='/password_reset.php'>Passwort vergessen?</a>");
define("MESSAGE_PASSWORD_WRONG_3_TIMES", "Passwort wurde dreimal falsch eingegeben. Bitte warten Sie 30 Sekunden, um es noch einmal zu probieren.");
define("MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL", "...Verzeihen sie bitte, solche Code-Kombinationen sind hier nicht zul&auml;ssig");
define("MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL", "Aktivierung war erfolgreich!");
define("MESSAGE_REGISTRATION_FAILED", "Verzeihen sie bitte, ihre Registrierung ist fehlgeschlagen. Bitte versuchen sie es erenut.");
define("MESSAGE_RESET_LINK_HAS_EXPIRED", "Ihr R&uuml;cksetzungs-link ist abgelaufen. Bitte benutzen sie den Link innerhalb einer Stunde");
define("MESSAGE_VERIFICATION_MAIL_ERROR", "Verzeihen sie bitte, wir konnten ihnen keine Best&auml;tigungs-E-mail senden. Ihr Account wurde NICHT erstellt.");
define("MESSAGE_VERIFICATION_MAIL_NOT_SENT", "Best&auml;tigungs-E-mail konnte NICHT erfolgreich gesendet werden! Fehler: ");
define("MESSAGE_VERIFICATION_MAIL_SENT", "Ihr Account wurde erfolgreich erstellt. Bitte pr&uuml;fen Sie Ihren Posteingang.");
define("MESSAGE_USER_DOES_NOT_EXIST", "Der Nutzer existiert nicht.");
define("MESSAGE_USERNAME_BAD_LENGTH", "Ihr Benutzername darf weder k&uuml;rzer als 2, noch l&auml;nger als 64 Zeichen sein");
define("MESSAGE_USERNAME_CHANGE_FAILED", "Verzeihen sie bitte, die Umbenennung ihres Benutzernamens ist ung&uuml;ltig");
define("MESSAGE_USERNAME_CHANGED_SUCCESSFULLY", "Ihr Benutzername wurde erfolgreich umbenannt. Ihr neuer Benutzername ist ");
define("MESSAGE_USERNAME_EMPTY", "Das Feld 'Benutzername' war leer");
define("MESSAGE_USERNAME_EXISTS", "Verzeihen sie bitte, dieser Benutzername ist bereits vergeben. W&auml;hlen sie bitte einen anderen.");
define("MESSAGE_USERNAME_INVALID", "Benutzername entspricht nicht den vorgegebenen Angaben: es sind ausschließlich a-Z und Zahlen erlaubt, insgesamt zwischen 2 und 64 Zeichen");
define("MESSAGE_USERNAME_SAME_LIKE_OLD_ONE", "Verzeihen sie bitte, diesen Benutzernamen besitzen sie bereits. W&auml;hlen sie bitte einen anderen.");

// views
define("WORDING_BACK_TO_LOGIN", "Zur&uuml;ck zum Login");
define("WORDING_CHANGE_EMAIL", "E-mail Adresse wechseln");
define("WORDING_CHANGE_PASSWORD", "Passwort wechseln");
define("WORDING_CHANGE_USERNAME", "Benutzername wechseln");
define("WORDING_CURRENTLY", "aktuell");
define("WORDING_EDIT_USER_DATA", "Benutzerdaten bearbeiten");
define("WORDING_EDIT_YOUR_CREDENTIALS", "Sie sind angemeldet und k&ouml;nnen ihre Zugangsdaten hier bearbeiten");
define("WORDING_FORGOT_MY_PASSWORD", "Ich habe mein Passwort vergessen");
define("WORDING_LOGIN", "Anmelden");
define("WORDING_LOGOUT", "Abmelden");
define("WORDING_NEW_EMAIL", "Neue E-Mail");
define("WORDING_NEW_PASSWORD", "Neues Passwort");
define("WORDING_NEW_PASSWORD_REPEAT", "Wiederhole neues Passwort");
define("WORDING_NEW_USERNAME", "Neuer Benutzername (Das Feld Benutzername darf nicht leer sein und muss azAZ09 und 2-64 Zeichen enthalten");
define("WORDING_OLD_PASSWORD", "Ihr ALTES Passwort");
define("WORDING_PASSWORD", "Passwort");
define("WORDING_PROFILE_PICTURE", "Ihr Profilbild (von Gravatar):");
define("WORDING_REGISTER", "Registrieren");
define("WORDING_REGISTER_NEW_ACCOUNT", "Registrieren sie einen neuen Account");
define("WORDING_REGISTRATION_CAPTCHA", "Bitte best&auml;tigen sie diese Benutzer");
define("WORDING_REGISTRATION_EMAIL", "Benutzer E-mail (bitte geben sie eine reale E-mail Adresse an, sie werden eine Best&auml;tigungs-E-mail mit einem Aktivierungslink erhalten");
define("WORDING_REGISTRATION_PASSWORD", "Passwort (min. 6 Zeichen");
define("WORDING_REGISTRATION_PASSWORD_REPEAT", "Passwort wiederholen");
define("WORDING_REGISTRATION_USERNAME", "Benutzername (nur Buchstaben und Zahlen, zwischen 2 und 64 Zeichen)");
define("WORDING_REMEMBER_ME", "Angemeldet bleiben (für 2 Wochen)");
define("WORDING_REQUEST_PASSWORD_RESET", "Fordern Sie ein neues Passwort an. Geben Sie hier Ihre E-Mail-Adresse ein und Sie bekommen eine E-Mail mit weiteren Anweisungen:");
define("WORDING_RESET_PASSWORD", "Passwort zur&uuml;cksetzen");
define("WORDING_SUBMIT_NEW_PASSWORD", "Neues Passwort abschicken");
define("WORDING_USERNAME", "Benutzername");
define("WORDING_YOU_ARE_LOGGED_IN_AS", "Sie sind angemeldet als");
