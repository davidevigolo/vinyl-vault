<?php
function get_logged_user()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user_id'])) {
        return [
            'user_id' => $_SESSION['user_id'],
        ];
    }
    return null;
}

function check_user_logged_in()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login.php");
        http_response_code(403);
        exit();
    }
}

function get_nationality_codes()
{
    return [
        'it' => 'Italia',
        'us' => 'Stati Uniti',
        'uk' => 'Regno Unito',
        'fr' => 'Francia',
        'de' => 'Germania',
        'es' => 'Spagna',
        'jp' => 'Giappone',
        'ca' => 'Canada',
        'au' => 'Australia',
        'br' => 'Brasile',
        'mx' => 'Messico',
        'ar' => 'Argentina',
        'cl' => 'Cile',
        'co' => 'Colombia',
        'pe' => 'Perù',
        'nl' => 'Paesi Bassi',
        'be' => 'Belgio',
        'ch' => 'Svizzera',
        'at' => 'Austria',
        'se' => 'Svezia',
        'no' => 'Norvegia',
        'dk' => 'Danimarca',
        'fi' => 'Finlandia',
        'pl' => 'Polonia',
        'cz' => 'Repubblica Ceca',
        'hu' => 'Ungheria',
        'ro' => 'Romania',
        'bg' => 'Bulgaria',
        'gr' => 'Grecia',
        'pt' => 'Portogallo',
        'ie' => 'Irlanda',
        'ru' => 'Russia',
        'ua' => 'Ucraina',
        'tr' => 'Turchia',
        'il' => 'Israele',
        'sa' => 'Arabia Saudita',
        'ae' => 'Emirati Arabi Uniti',
        'in' => 'India',
        'cn' => 'Cina',
        'kr' => 'Corea del Sud',
        'th' => 'Tailandia',
        'vn' => 'Vietnam',
        'id' => 'Indonesia',
        'my' => 'Malesia',
        'sg' => 'Singapore',
        'ph' => 'Filippine',
        'nz' => 'Nuova Zelanda',
        'za' => 'Sudafrica',
        'eg' => 'Egitto',
        'ng' => 'Nigeria',
        've' => 'Venezuela',
        'uy' => 'Uruguay',
        'ec' => 'Ecuador',
    ];
}

/**
 * Generates HTML script tags for the given array of script names.
 * Use this only in main templates, not components.
 *
 * @param array $script_names An array of script file names.
 * @return string The generated HTML script tags.
 */
function get_validation_scripts($script_names)
{
    $scripts_html = '';
    foreach ($script_names as $script_name) {
        $scripts_html .= '<script src="scripts/' . htmlspecialchars($script_name) . '" defer></script>' . "\n";
    }
    return $scripts_html;
}