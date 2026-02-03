<?php
function get_logged_user()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user_id'])) {
        return [
            'user_id' => $_SESSION['user_id'],
            'is_admin' => $_SESSION['is_admin'],
            'first_name' => $_SESSION['first_name'],
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
        header("Location: /dvigolo/403.php");
        //http_response_code(403);
        exit();
    }
}

function check_user_is_admin()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
        header("Location: /dvigolo/403.php");
        exit();
    }
}

function get_nationality_codes()
{
    return [
        'au' => 'Australia',
        'at' => 'Austria',
        'be' => 'Belgio',
        'bg' => 'Bulgaria',
        'br' => 'Brasile',
        'ca' => 'Canada',
        'ch' => 'Svizzera',
        'cl' => 'Cile',
        'cn' => 'Cina',
        'co' => 'Colombia',
        'cz' => 'Repubblica Ceca',
        'de' => 'Germania',
        'dk' => 'Danimarca',
        'ec' => 'Ecuador',
        'eg' => 'Egitto',
        'es' => 'Spagna',
        'fi' => 'Finlandia',
        'fr' => 'Francia',
        'gr' => 'Grecia',
        'hu' => 'Ungheria',
        'id' => 'Indonesia',
        'ie' => 'Irlanda',
        'il' => 'Israele',
        'in' => 'India',
        'it' => 'Italia',
        'jp' => 'Giappone',
        'kr' => 'Corea del Sud',
        'mx' => 'Messico',
        'my' => 'Malesia',
        'ng' => 'Nigeria',
        'nl' => 'Paesi Bassi',
        'no' => 'Norvegia',
        'nz' => 'Nuova Zelanda',
        'pe' => 'Perù',
        'ph' => 'Filippine',
        'pl' => 'Polonia',
        'pt' => 'Portogallo',
        'ro' => 'Romania',
        'ru' => 'Russia',
        'sa' => 'Arabia Saudita',
        'se' => 'Svezia',
        'sg' => 'Singapore',
        'th' => 'Tailandia',
        'tr' => 'Turchia',
        'ua' => 'Ucraina',
        'uk' => 'Regno Unito',
        'us' => 'Stati Uniti',
        'uy' => 'Uruguay',
        've' => 'Venezuela',
        'vn' => 'Vietnam',
        'za' => 'Sudafrica',
    ];
}

function get_nationality_languages()
{
    return [
        'it' => 'it',
        'us' => 'en',
        'uk' => 'en',
        'fr' => 'fr',
        'de' => 'de',
        'es' => 'es',
        'jp' => 'ja',
        'ca' => 'en',
        'au' => 'en',
        'br' => 'pt',
        'mx' => 'es',
        'ar' => 'es',
        'cl' => 'es',
        'co' => 'es',
        'pe' => 'es',
        'nl' => 'nl',
        'be' => 'nl', // Belgium: Dutch is most common, could also be 'fr'
        'ch' => 'de', // Switzerland: German is most common, could also be 'fr', 'it'
        'at' => 'de',
        'se' => 'sv',
        'no' => 'no',
        'dk' => 'da',
        'fi' => 'fi',
        'pl' => 'pl',
        'cz' => 'cs',
        'hu' => 'hu',
        'ro' => 'ro',
        'bg' => 'bg',
        'gr' => 'el',
        'pt' => 'pt',
        'ie' => 'en',
        'ru' => 'ru',
        'ua' => 'uk',
        'tr' => 'tr',
        'il' => 'he',
        'sa' => 'ar',
        'ae' => 'ar',
        'in' => 'hi', // India: Hindi is most common, could also be 'en'
        'cn' => 'zh',
        'kr' => 'ko',
        'th' => 'th',
        'vn' => 'vi',
        'id' => 'id',
        'my' => 'ms',
        'sg' => 'en', // Singapore: English is official, could also be 'zh', 'ms', 'ta'
        'ph' => 'tl',
        'nz' => 'en',
        'za' => 'en',
        'eg' => 'ar',
        'ng' => 'en',
        've' => 'es',
        'uy' => 'es',
        'ec' => 'es',
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
        $scripts_html .= '<script src="scripts/' . htmlspecialchars($script_name) . '" defer="defer"></script>' . "\n";
    }
    return $scripts_html;
}

function get_all_disk_ids()
{
    $connection = DbConnection::get_instance()->get_connection();
    $ids = [];
    $result = mysqli_query($connection, "SELECT id FROM disk");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ids[] = $row['id'];
        }
        mysqli_free_result($result);
    }
    return $ids;
}

function get_max_tracks_by_type($disk_type){
    switch ($disk_type) {
        case 'ALBUM':
            return 20;
        case 'EP':
            return 6;
        case 'SINGLE':
            return 1;
        default:
            return 0;
    }
}

function get_disk_type_display_names(){
    return [
        'SINGLE' => 'Singolo',
        'EP' => 'EP',
        'ALBUM' => 'Album'
    ];
}