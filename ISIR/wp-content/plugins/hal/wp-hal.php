<?php
/**
 * Plugin Name: HAL
 * Plugin URI: http://www.ccsd.cnrs.fr
 * Description: Crée une page qui remonte les publications d'un auteur ou d'une structure en relation avec HAL et un widget des dernières publications d'un auteur ou d'une structure.
 * Version: 2.0.6
 * Author: Baptiste Blondelle
 * Author URI: http://www.ccsd.cnrs.fr
 * Text Domain: wp-hal
 * Domain Path: /lang/
 */


// Traduction de la description
__("Crée une page qui remonte les publications d'un auteur ou d'une structure en relation avec HAL et un widget des dernières publications d'un auteur ou d'une structure.", "wp-hal");

//Récupère les constantes
require_once("constantes.php");


if (locale == 'fr_FR') {
    define('lang', 'fr');
} elseif (locale == 'es_ES') {
    define('lang', 'es');
} else {
    define('lang', 'en');
}

// Création du shortcode ('nom du shortcode', 'fonction appelée')
add_shortcode( 'cv-hal', 'cv_hal' );
add_shortcode( 'nb-doc', 'nb_doc' );


function charger_languages() {
    load_plugin_textdomain('wp-hal', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}

add_action('plugins_loaded', 'charger_languages');

function hal_plugin_action_links( $links, $file ) {
    if ( $file != plugin_basename( __FILE__ ))
        return $links;

    $settings_link = '<a href="admin.php?page=wp-hal.php">' . __( 'Paramètres', 'wp-hal' ) . '</a>';

    array_unshift( $links, $settings_link );

    return $links;
}


add_filter( 'plugin_action_links', 'hal_plugin_action_links',10,2);


/***********************************************************************************************************************
 * PLUGIN SHORTCODE ND-DOC
 **********************************************************************************************************************/
function nb_doc($param)
{
    $idhal = verifSolr(get_option('option_idhal'));
    extract(shortcode_atts(array(
        'type' => get_option('option_type'),
        'id' => $idhal
    ),
        $param
    ));
    $id = verifSolr($id);

    $url = api . '?q=*:*&fq=' . $type . ':(' . urlencode($id) . ')&rows=0&wt=json';
    $ch = curl_init($url);
    // Options
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-type: application/json'),
        CURLOPT_TIMEOUT => 10,
        CURLOPT_USERAGENT => "HAL Plugin Wordpress " . version
    );

    // Bind des options et de l'objet cURL que l'on va utiliser
    curl_setopt_array($ch, $options);
    // Récupération du résultat JSON
    $json = json_decode(curl_exec($ch));
    curl_close($ch);

    return $json->response->numFound;
}
/***********************************************************************************************************************
 * PLUGIN SHORTCODE CV-HAL
 **********************************************************************************************************************/
function cv_hal($param){
    if ( !function_exists('curl_init' ) ) {
        echo 'Please check the';?> <a href="https://wordpress.org/plugins/hal/faq/" target="_blank" id="curl">FAQ</a><?php echo ' with the code : CURL';
    } else {

        if(in_array('disciplines', get_option('option_choix'))){ //Lance les scripts pour le Graphique
            wp_enqueue_style('wp-hal-style2');

            wp_enqueue_script('wp-hal-script1');
            wp_enqueue_script('wp-hal-script2');
            wp_enqueue_script('wp-hal-script3');
        }

        if (get_option('option_idhal') != '') {
            $idhal = verifSolr(get_option('option_idhal'));
            extract(shortcode_atts(array(
                'type' => get_option('option_type'),
                'id' => $idhal,
                'contact' => get_option('option_infocontact')
            ),
                $param
            ));
            $id = verifSolr($id);

            if (get_option('option_groupe') == 'grouper') {
                //cURL sur l'API pour récupérer les données
                $url = api . '?q=*:*&fq=' . $type . ':(' . urlencode($id) . ')&group=true&group.field=docType_s&group.limit=1000&fl=docid,citationFull_s&facet.field=' . lang . '_domainAllCodeLabel_fs&facet.field=keyword_s&facet.field=journalIdTitle_fs&facet.field=producedDateY_i&facet.field=authIdLastNameFirstName_fs&facet.field=instStructIdName_fs&facet.field=labStructIdName_fs&facet.field=deptStructIdName_fs&facet.field=rteamStructIdName_fs&facet.mincount=1&facet=true&sort=' . producedDateY . '&wt=json&json.nl=arrarr';
            } elseif (get_option('option_groupe') == 'paginer') {
                $url = api . '?q=*:*&fq=' . $type . ':(' . urlencode($id) . ')&fl=docid,citationFull_s&facet.field=' . lang . '_domainAllCodeLabel_fs&facet.field=keyword_s&facet.field=journalIdTitle_fs&facet.field=producedDateY_i&facet.field=authIdLastNameFirstName_fs&facet.field=instStructIdName_fs&facet.field=labStructIdName_fs&facet.field=deptStructIdName_fs&facet.field=rteamStructIdName_fs&facet.mincount=1&facet=true&sort=' . producedDateY . '&wt=json&json.nl=arrarr';
            }

            $ch = curl_init($url);
            // Options
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                CURLOPT_TIMEOUT => 10,
                CURLOPT_USERAGENT => "HAL Plugin Wordpress " . version
            );

            // Bind des options et de l'objet cURL que l'on va utiliser
            curl_setopt_array($ch, $options);
            // Récupération du résultat JSON
            $json = json_decode(curl_exec($ch));
            curl_close($ch);

            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $content = '<div id="wphal-content">
    <ul id="wphal-menu">';
            $content .= '<li><a href="#publications" onclick="displayElem(\'publications\'); return false;" style="font-size:18px; text-decoration: none;">' . __('Publications', 'wp-hal') . '</a></li>';
            if (is_array(get_option('option_choix'))) {
                $content .= '<li><a href="#filtres" onclick="return false;" style="font-size:18px; text-decoration: none; cursor:default;">' . __('Filtres', 'wp-hal') . '</a>';
                $content .= '<ul id="wphal-filtres">';
                foreach (get_option('option_choix') as $option) {
                    if ($option == 'contact') {
                        $content .= '<li><a href="#contact" onclick="displayElem(\'wphal-contact\'); return false;" style="margin:1px; text-decoration: none;">' . __('Contact', 'wp-hal');
                        $content .= '</a></li>';
                    }
                    if ($option == 'disciplines') {
                        $content .= '<li><a href="#disciplines" onclick="displayElem(\'wphal-disciplines\'); return false;" style="margin:1px; text-decoration: none;">' . __('Disciplines', 'wp-hal');
                        $content .= '</a></li>';
                    }
                    if ($option == 'mots-clefs') {
                        $content .= '<li><a href="#keywords" onclick="displayElem(\'wphal-keywords\'); return false;" style="margin:1px; text-decoration: none;">' . __('Mots-clefs', 'wp-hal');
                        $content .= '</a></li>';
                    }
                    if ($option == 'auteurs') {
                        $content .= '<li><a href="#auteurs" onclick="displayElem(\'wphal-auteurs\'); return false;" style="margin:1px; text-decoration: none;">' . __('Auteurs', 'wp-hal');
                        $content .= '</a></li>';
                    }
                    if ($option == 'revues') {
                        $content .= '<li><a href="#revues" onclick="displayElem(\'wphal-revues\'); return false;" style="margin:1px; text-decoration: none;">' . __('Revues', 'wp-hal');
                        $content .= '</a></li>';
                    }
                    if ($option == 'annee') {
                        $content .= '<li><a href="#annees" onclick="displayElem(\'wphal-annees\'); return false;" style="margin:1px; text-decoration: none;">' . __('Année de production', 'wp-hal');
                        $content .= '</a></li>';
                    }
                    if ($option == 'institution') {
                        $content .= '<li><a href="#insts" onclick="displayElem(\'wphal-insts\'); return false;" style="margin:1px; text-decoration: none;">' . __('Institutions', 'wp-hal');
                        $content .= '</a></li>';
                    }
                    if ($option == 'laboratoire') {
                        $content .= '<li><a href="#labs" onclick="displayElem(\'wphal-labs\'); return false;" style="margin:1px; text-decoration: none;">' . __('Laboratoires', 'wp-hal');
                        $content .= '</a></li>';
                    }
                    if ($option == 'departement') {
                        $content .= '<li><a href="#depts" onclick="displayElem(\'wphal-depts\'); return false;" style="margin:1px; text-decoration: none;">' . __('Départements', 'wp-hal');
                        $content .= '</a></li>';
                    }
                    if ($option == 'equipe') {
                        $content .= '<li><a href="#equipes" onclick="displayElem(\'wphal-equipes\'); return false;" style="margin:1px; text-decoration: none;">' . __('Équipes de recherche', 'wp-hal');
                        $content .= '</a></li>';
                    }
                }
                $content .= '</ul></li>';
            }
            $content .= '</ul><br/><hr>';

            $content .= '<div id="meta">
        <div class="display" id="wphal-contact" style="display: none;">
            <h3 class="wphal-titre">' . __('Contact', 'wp-hal');
            $content .= '</h3>

            <ul id="wphal-cont" style="list-style-type: none;">';

            if ($contact == 'yes' && $type == 'authIdHal_s') {
                $urlauthor = urlauthor.'?indent=true&fq=valid_s:VALID&fl=idref_s,url_s,email_s,fullName_s,arxiv_s,idHal_s,viaf_s,isni_s,orcid_s,hasCV_bool&q=idHal_s:'.urlencode($id);
                $ch = curl_init($urlauthor);
                // Options
                $options = array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_USERAGENT => "HAL Plugin Wordpress " . version
                );

                // Bind des options et de l'objet cURL que l'on va utiliser
                curl_setopt_array($ch, $options);
                // Récupération du résultat JSON
                $jsonauthor = json_decode(curl_exec($ch));
                curl_close($ch);

                for ($i = 0; $jsonauthor->response->docs[$i] != ''; $i++) {
                    $content .= '<div class="wphal-infocontact" id="wphal-infocontact'.$i.'">';
                    if ($jsonauthor->response->docs[$i]->fullName_s != '') {
                        $content .= '<li class="wphal-fullname"><span>Nom : </span><span>'. $jsonauthor->response->docs[$i]->fullName_s .'</span></li>';
                    }
                    if ($jsonauthor->response->docs[$i]->email_s != '') {
                        $content .= '<li class="wphal-email"><span>Email : </span><span><a href="mailto:'. $jsonauthor->response->docs[$i]->email_s .'">' . $jsonauthor->response->docs[$i]->email_s . '</a></span></li>';
                    }
                    if ($jsonauthor->response->docs[$i]->idHal_s != '') {
                        $content .= '<li class="wphal-idhal"><span>IdHAL : </span><span>' . $jsonauthor->response->docs[$i]->idHal_s . '</span></li>';
                    }
                    if ($jsonauthor->response->docs[$i]->hasCV_bool == true){
                        $content .= '<li class="wphal-cvhal"><span>CV HAL : </span><a href="'.cvhal. $jsonauthor->response->docs[$i]->idHal_s.'" target="_blank">CV de '.$jsonauthor->response->docs[$i]->fullName_s.'</a></li>';
                    }
                    if ($jsonauthor->response->docs[$i]->arxiv_s != '') {
                        $content .= '<li class="wphal-"><span>arXiv : </span><span><a href="' . $jsonauthor->response->docs[$i]->arxiv_s . '" target="_blank">' . substr(strrchr($jsonauthor->response->docs[$i]->arxiv_s, "/"), 1) . '</a></span></li>';
                    }
                    if ($jsonauthor->response->docs[$i]->idref_s != '') {
                        $content .= '<li class="wphal-"><span>IdRef : </span><span><a href="' . $jsonauthor->response->docs[$i]->idref_s . '" target="_blank">' . substr(strrchr($jsonauthor->response->docs[$i]->idref_s, "/"), 1) . '</a></span></li>';
                    }
                    if ($jsonauthor->response->docs[$i]->orcid_s != '') {
                        $content .= '<li class="wphal-"><span>ORCID : </span><span><a href="' . $jsonauthor->response->docs[$i]->orcid_s . '" target="_blank">' . substr(strrchr($jsonauthor->response->docs[$i]->orcid_s, "/"), 1) . '</a></span></li>';
                    }
                    if ($jsonauthor->response->docs[$i]->viaf_s != '') {
                        $content .= '<li class="wphal-"><span>VIAF : </span><span><a href="' . $jsonauthor->response->docs[$i]->viaf_s . '" target="_blank">' . substr(strrchr($jsonauthor->response->docs[$i]->viaf_s, "/"), 1) . '</a></span></li>';
                    }
                    if ($jsonauthor->response->docs[$i]->isni_s != '') {
                        $content .= '<li class="wphal-"><span>ISNI : </span><span><a href="' . $jsonauthor->response->docs[$i]->isni_s . '" target="_blank">' . substr(strrchr($jsonauthor->response->docs[$i]->isni_s, "/"), 1) . '</a></span></li>';
                    }
                    $content .= '</div>';
                }
            }
            if (get_option('option_email') != '') {
                $content .= '<li><img alt="mail" src=" ' . plugin_dir_url(__FILE__) . 'img/mail.svg" style=" width:16px; margin-left:2px; margin-right:2px;"/><a href="mailto:' . get_option('option_email') . '" target="_blank">' . get_option('option_email') . '</a></li>';
            }
            if (get_option('option_tel') != '') {
                $content .= '<li><img alt="phone" src=" ' . plugin_dir_url(__FILE__) . 'img/phone.svg" style="width:16px; margin-left:2px; margin-right:2px;"/>' . get_option('option_tel') . '</li>';
            }
            if (get_option('option_social0') != '') {
                $content .= '<li><a href="http://www.facebook.com/' . get_option('option_social0') . '" target="_blank"><img src=" ' . plugin_dir_url(__FILE__) . 'img/facebook.svg" style="width:32px; margin:4px;"/></a></li>';
            }
            if (get_option('option_social1') != '') {
                $content .= '<li><a href="http://www.twitter.com/' . get_option('option_social1') . '" target="_blank"><img src=" ' . plugin_dir_url(__FILE__) . 'img/twitter.svg" style="width:32px; margin:4px;"/></a></li>';
            }
            if (get_option('option_social2') != '') {
                $content .= '<li><a href="https://plus.google.com/u/0/+' . get_option('option_social2') . '" target="_blank"><img src=" ' . plugin_dir_url(__FILE__) . 'img/google-plus.svg" style="width:32px; margin:4px;"/></a></li>';
            }
            if (get_option('option_social3') != '') {
                $content .= '<li><a href="https://www.linkedin.com/in/' . get_option('option_social3') . '" target="_blank"><img src=" ' . plugin_dir_url(__FILE__) . 'img/linkedin.svg" style="width:32px; margin:4px;"/></a></li>';
            }
            $content .= '</ul>
        </div>
        <div class="display" id="wphal-disciplines" style="display: none;">
            <h3 class="wphal-titre">' . __('Disciplines', 'wp-hal') . '</h3>';

            if (locale == 'fr_FR') {
                $facetdomain = $json->facet_counts->facet_fields->fr_domainAllCodeLabel_fs;
            } elseif (locale == 'es_ES') {
                $facetdomain = $json->facet_counts->facet_fields->es_domainAllCodeLabel_fs;
            } else {
                $facetdomain = $json->facet_counts->facet_fields->en_domainAllCodeLabel_fs;
            }

            if (!is_null($facetdomain) && !empty($facetdomain)) {
                $content .= '<div id="listdisci">';
                $content .= '<span id="tridisciplines">';
                $content .= '<button type="button" class="trial" href="" id="tridisci" onclick="toggleSort(this, true, \'wphal-discipline\', \'wphal-discipline\', \'tridisci\'); return false;" style="font-size:16px;  text-decoration: none;" >Tri Alphabétique</button>';
                $content .= '<button type="button" class="trioc" href="" id="trinbdisci" onclick="toggleSort(this, false, \'wphal-discipline\', \'wphal-discipline\', \'trinbdisci\'); return false;" style="font-size:16px;  text-decoration: none;">Tri Occurrence</button>';
                $content .= '</span>';
                $content .= '<ul id="wphal-discipline" class="wphal-discipline">';
                foreach ($facetdomain as $res) {
                    $name = explode(delimiter, $res[0]);
                    $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=domainAllCode_s:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                }
                $content .= '</ul>';
                $content .= '</div>';

                $content .= '<div id="wphal-graph" style="display:none;">';
                $content .= '<div id="wphal-piedisci"></div>';
                $content .= '</div>';
                $content .= '<button type="button" href="" style="text-decoration: none;" id="wphal-disci" onclick="visibilitedisci(\'listdisci\',\'wphal-graph\',\'tridisciplines\'); return false;" >' . __('Graphique', 'wp-hal');
                $content .= '</button>';
            }
            $content .= '</div>
        <div class="display" id="wphal-keywords" style="display: none;">
            <h3 class="wphal-titre">' . __('Mots-clefs', 'wp-hal') . '</h3>';
            if (!is_null($json->facet_counts->facet_fields->keyword_s) && !empty($json->facet_counts->facet_fields->keyword_s)) {
                $content .= '<div id="wphal-keys">';
                $r = 0;
                // CSS Nuage de mots
                $maxsize = 25;
                $minsize = 10;
                $maxval = max(array_values($json->facet_counts->facet_fields->keyword_s[1]));
                $minval = min(array_values($json->facet_counts->facet_fields->keyword_s[1]));
                $spread = ($maxval - $minval);
                $step = ($maxsize - $minsize) / $spread;
                $tab = array();
                foreach ($json->facet_counts->facet_fields->keyword_s as $res) {
                    $r = $r + 1;
                    if ($r > 20) {
                        break;
                    }
                    $tab[] = $res;
                }
                asort($tab); // Tri du tableau par ordre alphabétique
                foreach ($tab as $res) {
                    $size = round($minsize + (($res[1] - $minval) * $step));
                    $content .= '<a style="display: inline-block; font-size:' . $size . 'px" href="' . halv3 . '?q=keyword_s:' . urlencode('"' . $res[0] . '"') . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $res[0] . '</a>&nbsp;';
                }
                $content .= '</div>';
                $content .= '<div id="keysuite" style="display:none;">';
                $content .= '<span id="trikeywords">';
                $content .= '<button type="button" class="trial" href="" id="trikey" onclick="toggleSort(this, true, \'wphal-keyw\', \'wphal-keyword\', \'trikey\'); return false;" style="font-size:16px;  text-decoration: none;" >Tri Alphabétique</button>';
                $content .= '<button type="button" class="trioc" href="" id="trinbkey" onclick="toggleSort(this, false, \'wphal-keyw\', \'wphal-keyword\', \'trinbkey\'); return false;" style="font-size:16px;  text-decoration: none;">Tri Occurrence</button>';
                $content .= '</span>';
                $content .= '<ul class="wphal-keyword">';
                $content .= '<div id="wphal-keyw">';
                foreach ($json->facet_counts->facet_fields->keyword_s as $res) {
                    $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=keyword_s:' . urlencode('"' . $res[0] . '"') . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $res[0] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                }
                $content .= '</div>';
                $content .= '</ul>';
                $content .= '</div>';
                $content .= '<button type="button" href="" style="text-decoration: none;" id="wphal-key" onclick="visibilitekey(\'wphal-keys\',\'keysuite\', \'trikeywords\'); return false;" >' . __('Liste complète', 'wp-hal');
                $content .= '</button>';
            }
            $content .= '</div>
        <div class="display" id="wphal-auteurs" style="display: none;">
            <h3 class="wphal-titre">' . __('Auteurs', 'wp-hal') . '</h3>';
            if (!is_null($json->facet_counts->facet_fields->authIdLastNameFirstName_fs) && !empty($json->facet_counts->facet_fields->authIdLastNameFirstName_fs)) {
                $content .= '<span id="triauteurs">';
                $content .= '<button type="button" class="trial" href="" id="triaut" onclick="toggleSort(this, true, \'wphal-aut\', \'auteursuite\', \'triaut\'); return false;" style="font-size:16px;  text-decoration: none;" >Tri Alphabétique</button>';
                $content .= '<button type="button" class="trioc" href="" id="trinbaut" onclick="toggleSort(this, false, \'wphal-aut\', \'auteursuite\', \'trinbaut\'); return false;" style="font-size:16px;  text-decoration: none;">Tri Occurrence</button>';
                $content .= '</span>';
                $content .= '<ul class="wphal-auteurs" style="list-style-type: none;">';
                $content .= '<div id="wphal-aut">';
                $r = 0;
                foreach ($json->facet_counts->facet_fields->authIdLastNameFirstName_fs as $res) {
                    $r = $r + 1;
                    if ($r > 10) {
                        break;
                    }
                    $name = explode(delimiter, $res[0]);
                    $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><img alt="user" src=" ' . plugin_dir_url(__FILE__) . '/img/user.svg" style="width:16px; margin-left:2px; margin-right:2px;"/><a href="' . halv3 . '?q=authId_i:' . $name[0] . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                }
                $i = 1;
                $content .= '<div id="auteursuite" style="display:none;">';
                foreach ($json->facet_counts->facet_fields->authIdLastNameFirstName_fs as $res) {
                    if ($r < 10) {
                        break;
                    }
                    if ($i < $r) {
                        $i = $i + 1;
                    } else {
                        $name = explode(delimiter, $res[0]);
                        $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><img alt="user" src=" ' . plugin_dir_url(__FILE__) . '/img/user.svg" style="width:16px; margin-left:2px; margin-right:2px;"/><a href="' . halv3 . '?q=authId_i:' . $name[0] . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                    }
                }
                $content .= '</div>';
                $content .= '</div>';
                $content .= '</ul>';
                if ($r > 10) {
                    $content .= '<button type="button" href="" style="text-decoration: none;" id="wphal-auteur" onclick="visibilite(\'auteursuite\'); return false;" >' . __('Liste complète', 'wp-hal');
                    $content .= '</button>';
                }
            }
            $content .= '</div>
        <div class="display" id="wphal-revues" style="display: none;">
            <h3 class="wphal-titre">' . __('Revues', 'wp-hal') . '</h3>';
            if (!is_null($json->facet_counts->facet_fields->journalIdTitle_fs) && !empty($json->facet_counts->facet_fields->journalIdTitle_fs)) {
                $content .= '<span id="trirevues">';
                $content .= '<button type="button" class="trial" href="" id="trirev" onclick="toggleSort(this, true, \'wphal-rev\', \'revuesuite\', \'trirev\'); return false;" style="font-size:16px;  text-decoration: none;" >Tri Alphabétique</button>';
                $content .= '<button type="button" class="trioc" href="" id="trinbrev" onclick="toggleSort(this, false, \'wphal-rev\', \'revuesuite\', \'trinbrev\'); return false;" style="font-size:16px;  text-decoration: none;">Tri Occurrence</button>';
                $content .= '</span>';
                $content .= '<ul class="wphal-revues">';
                $content .= '<div id="wphal-rev">';
                $r = 0;
                foreach ($json->facet_counts->facet_fields->journalIdTitle_fs as $res) {
                    $r = $r + 1;
                    if ($r > 10) {
                        break;
                    }
                    $name = explode(delimiter, $res[0]);
                    $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=journalId_i:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                }
                $i = 1;
                $content .= '<div id="revuesuite" style="display:none;">';
                foreach ($json->facet_counts->facet_fields->journalIdTitle_fs as $res) {
                    if ($r < 10) {
                        break;
                    }
                    if ($i < $r) {
                        $i = $i + 1;
                    } else {
                        $name = explode(delimiter, $res[0]);
                        $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=journalId_i:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                    }
                }
                $content .= '</div>';
                $content .= '</div>';
                $content .= '</ul>';
                if ($r > 10) {
                    $content .= '<button type="button" href="" style="text-decoration: none;" id="wphal-revue" onclick="visibiliterevues(\'revuesuite\'); return false;" >' . __('Liste complète', 'wp-hal');
                    $content .= '</button>';
                }
            }
            $content .= '</div>
        <div class="display" id="wphal-annees" style="display: none;">
            <h3 class="wphal-titre">' . __('Année de production', 'wp-hal') . '</h3>';
            if (!is_null($json->facet_counts->facet_fields->producedDateY_i) && !empty($json->facet_counts->facet_fields->producedDateY_i)) {
                $content .= '<span id="triannees">';
                $content .= '<button type="button" class="trial" href="" id="trian" onclick="toggleSort(this, true, \'wphal-an\', \'anneesuite\', \'trian\'); return false;" style="font-size:16px;  text-decoration: none;" >Tri Alphabétique</button>';
                $content .= '<button type="button" class="trioc" href="" id="trinban" onclick="toggleSort(this, false, \'wphal-an\', \'anneesuite\', \'trinban\'); return false;" style="font-size:16px;  text-decoration: none;">Tri Occurrence</button>';
                $content .= '</span>';
                $content .= '<ul class="wphal-annees">';
                $content .= '<div id="wphal-an">';

                rsort($json->facet_counts->facet_fields->producedDateY_i);
                $r = 0;
                foreach ($json->facet_counts->facet_fields->producedDateY_i as $res) {
                    $r = $r + 1;
                    if ($r > 10) {
                        break;
                    }
                    $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=producedDateY_i:' . urlencode($res[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $res[0] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                }
                $i = 1;
                $content .= '<div id="anneesuite" style="display:none;">';
                foreach ($json->facet_counts->facet_fields->producedDateY_i as $res) {
                    if ($r < 10) {
                        break;
                    }
                    if ($i < $r) {
                        $i = $i + 1;
                    } else {
                        $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=producedDateY_i:' . urlencode($res[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $res[0] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                    }
                }
                $content .= '</div>';
                $content .= '</div>';
                $content .= '</ul>';
                if ($r > 10) {
                    $content .= '<button type="button" href="" style="text-decoration: none;" id="wphal-annee" onclick="visibiliteannee(\'anneesuite\'); return false;" >' . __('Liste complète', 'wp-hal');
                    $content .= '</button>';
                }
            }
            $content .= '</div>
        <div class="display" id="wphal-insts" style="display: none;">
            <h3 class="wphal-titre">' . __('Institutions', 'wp-hal') . '</h3>';
            if (!is_null($json->facet_counts->facet_fields->instStructIdName_fs) && !empty($json->facet_counts->facet_fields->instStructIdName_fs)) {
                $content .= '<span id="triinsts">';
                $content .= '<button type="button" class="trial" href="" id="triinst" onclick="toggleSort(this, true, \'wphal-institu\', \'instsuite\', \'triinst\');  return false;" style="font-size:16px;  text-decoration: none;" >Tri Alphabétique</button>';
                $content .= '<button type="button" class="trioc" href="" id="trinbinst" onclick="toggleSort(this, false, \'wphal-institu\', \'instsuite\', \'trinbinst\'); return false;" style="font-size:16px;  text-decoration: none;">Tri Occurrence</button>';
                $content .= '</span>';
                $content .= '<ul class="wphal-insts">';
                $content .= '<div id="wphal-institu">';
                $r = 0;
                foreach ($json->facet_counts->facet_fields->instStructIdName_fs as $res) {
                    $r = $r + 1;
                    if ($r > 10) {
                        break;
                    }
                    $name = explode(delimiter, $res[0]);
                    $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=instStructId_i:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                }
                $i = 1;
                $content .= '<div id="instsuite" style="display:none;">';
                foreach ($json->facet_counts->facet_fields->instStructIdName_fs as $res) {
                    if ($r < 10) {
                        break;
                    }
                    if ($i < $r) {
                        $i = $i + 1;
                    } else {
                        $name = explode(delimiter, $res[0]);
                        $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=instStructId_i:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                    }
                }
                $content .= '</div>';
                $content .= '</div>';
                $content .= '</ul>';
                if ($r > 10) {
                    $content .= '<button type="button" href="" style="text-decoration: none;" id="wphal-inst" onclick="visibiliteinst(\'instsuite\'); return false;" >' . __('Liste complète', 'wp-hal');
                    $content .= '</button>';
                }
            }
            $content .= '</div>
       <div class="display" id="wphal-labs" style="display: none;">
            <h3 class="wphal-titre">' . __('Laboratoires', 'wp-hal') . '</h3>';
            if (!is_null($json->facet_counts->facet_fields->labStructIdName_fs) && !empty($json->facet_counts->facet_fields->labStructIdName_fs)) {
                $content .= '<span id="trilabs">';
                $content .= '<button type="button" class="trial" href="" id="trilab" onclick="toggleSort(this, true, \'wphal-labo\', \'labsuite\', \'trilab\');  return false;" style="font-size:16px;  text-decoration: none;" >Tri Alphabétique</button>';
                $content .= '<button type="button" class="trioc" href="" id="trinblab" onclick="toggleSort(this, false, \'wphal-labo\', \'labsuite\', \'trinblab\'); return false;" style="font-size:16px;  text-decoration: none;">Tri Occurrence</button>';
                $content .= '</span>';
                $content .= '<ul class="wphal-labs">';
                $content .= '<div id="wphal-labo">';

                $r = 0;
                foreach ($json->facet_counts->facet_fields->labStructIdName_fs as $res) {
                    $r = $r + 1;
                    if ($r > 10) {
                        break;
                    }
                    $name = explode(delimiter, $res[0]);
                    $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=labStructId_i:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                }
                $i = 1;
                $content .= '<div id="labsuite" style="display:none;">';
                foreach ($json->facet_counts->facet_fields->labStructIdName_fs as $res) {
                    if ($r < 10) {
                        break;
                    }
                    if ($i < $r) {
                        $i = $i + 1;
                    } else {
                        $name = explode(delimiter, $res[0]);
                        $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=labStructId_i:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                    }
                }
                $content .= '</div>';
                $content .= '</div>';
                $content .= '</ul>';
                if ($r > 10) {
                    $content .= '<button type="button" href="" style="text-decoration: none;" id="wphal-lab" onclick="visibilitelab(\'labsuite\'); return false;" >' . __('Liste complète', 'wp-hal');
                    $content .= '</button>';
                }
            }
            $content .= '</div>
       <div class="display" id="wphal-depts" style="display: none;">
            <h3 class="wphal-titre">' . __('Départements', 'wp-hal') . '</h3>';
            if (!is_null($json->facet_counts->facet_fields->deptStructIdName_fs) && !empty($json->facet_counts->facet_fields->deptStructIdName_fs)) {
                $content .= '<span id="tridept">';
                $content .= '<button type="button" class="trial" href="" id="tridept" onclick="toggleSort(this, true, \'wphal-dpt\', \'deptsuite\', \'tridept\');  return false;" style="font-size:16px;  text-decoration: none;" >Tri Alphabétique</button>';
                $content .= '<button type="button" class="trioc" href="" id="trinbdept" onclick="toggleSort(this, false, \'wphal-dpt\', \'deptsuite\', \'trinbdept\'); return false;" style="font-size:16px;  text-decoration: none;">Tri Occurrence</button>';
                $content .= '</span>';
                $content .= '<ul class="wphal-depts">';
                $content .= '<div id="wphal-dpt">';
                $r = 0;
                foreach ($json->facet_counts->facet_fields->deptStructIdName_fs as $res) {
                    $r = $r + 1;
                    if ($r > 10) {
                        break;
                    }
                    $name = explode(delimiter, $res[0]);
                    $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=deptStructId_i:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                }
                $i = 1;
                $content .= '<div id="deptsuite" style="display:none;">';
                foreach ($json->facet_counts->facet_fields->deptStructIdName_fs as $res) {
                    if ($r < 10) {
                        break;
                    }
                    if ($i < $r) {
                        $i = $i + 1;
                    } else {
                        $name = explode(delimiter, $res[0]);
                        $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=deptStructId_i:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                    }
                }
                $content .= '</div>';
                $content .= '</div>';
                $content .= '</ul>';
                if ($r > 10) {
                    $content .= '<button type="button" href="" style="text-decoration: none;" id="wphal-dept" onclick="visibilitedept(\'deptsuite\'); return false;" >' . __('Liste complète', 'wp-hal');
                    $content .= '</button>';
                }
            }
            $content .= '</div>
       <div class="display" id="wphal-equipes" style="display: none;">
            <h3 class="wphal-titre">' . __('Équipes de recherche', 'wp-hal') . '</h3>';
            if (!is_null($json->facet_counts->facet_fields->rteamStructIdName_fs) && !empty($json->facet_counts->facet_fields->rteamStructIdName_fs)) {
                $content .= '<span id="triequipe">';
                $content .= '<button type="button" class="trial" href="" id="triequipe" onclick="toggleSort(this, true, \'wphal-rteam\', \'equipesuite\', \'triequipe\');  return false;" style="font-size:16px;text-decoration: none;" >Tri Alphabétique</button>';
                $content .= '<button type="button" class="trioc" href="" id="trinbequipe" onclick="toggleSort(this, false, \'wphal-rteam\', \'equipesuite\', \'trinbequipe\'); return false;" style="font-size:16px;  text-decoration: none;">Tri Occurrence</button>';
                $content .= '</span>';
                $content .= '<ul class="wphal-equipes">';
                $content .= '<div id="wphal-rteam">';

                $r = 0;
                foreach ($json->facet_counts->facet_fields->rteamStructIdName_fs as $res) {
                    $r = $r + 1;
                    if ($r > 10) {
                        break;
                    }
                    $name = explode(delimiter, $res[0]);
                    $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=rteamStructId_i:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                }
                $i = 1;
                $content .= '<div id="equipesuite" style="display:none;">';
                foreach ($json->facet_counts->facet_fields->rteamStructIdName_fs as $res) {
                    if ($r < 10) {
                        break;
                    }
                    if ($i < $r) {
                        $i = $i + 1;
                    } else {
                        $content .= '<li class="metadata" data-percentage="' . $res[1] . '"><a href="' . halv3 . '?q=rteamStructId_i:' . urlencode($name[0]) . "+AND+" . $type . ':(' . $id . ')" target="_blank">' . $name[1] . '</a><span class="wphal-nbmetadata">' . $res[1] . '</span></li>';
                    }
                }
                $content .= '</div>';
                $content .= '</div>';
                $content .= '</ul>';
                if ($r > 10) {
                    $content .= '<button type="button" href="" style="text-decoration: none;" id="wphal-equipe" onclick="visibiliteequipe(\'equipesuite\'); return false;" >' . __('Liste complète', 'wp-hal');
                    $content .= '</button>';
                }
            }
            $content .= '</div>
    <div class="display" id="publications">';
            if (get_option('option_groupe') == 'grouper') {
                $doctype = file_get_contents(plugin_dir_path( __FILE__ ).'json'. DIRECTORY_SEPARATOR .'doctype_'.lang.'.json');
                $jsontype = json_decode($doctype);

//LISTE DES DOCUMENTS PAR GROUPE

                $content .= '<div class="counter-doc"><span class="wphal-nbtot">' . $json->grouped->docType_s->matches . ' </span>';
                $content .= __('documents', 'wp-hal'). '</div><br>';
                for ($i = 0; $jsontype->response->result->doc[$i] != null; $i++) {
                    for ($d = 0; $json->grouped->docType_s->groups[$d] != null; $d++) {
                        if ($json->grouped->docType_s->groups[$d]->groupValue == $jsontype->response->result->doc[$i]->str[0]){
                            $titre = $jsontype->response->result->doc[$i]->str[1];
                            $content .= '<div class="grp-div"><h3 class="wphal-titre-groupe">' . $titre . '<span class="wphal-nbmetadata" style="margin-left:10px;">' . $json->grouped->docType_s->groups[$d]->doclist->numFound . ' ' . _n('document', 'documents', $json->grouped->docType_s->groups[$d]->doclist->numFound, 'wp-hal') . '</span></h3>';
                            $content .= '<div class="grp-content">';
                            $content .= '<ul>';
                            foreach ($json->grouped->docType_s->groups[$d]->doclist->docs as $result) {
                                $content .= '<li>' . $result->citationFull_s . '</li>';
                            }
                            $content .= '</ul></div>';
                            $content .= '</div><br>';
                            break;
                        }
                    }
                }
            } elseif (get_option('option_groupe') == 'paginer') {

//LISTE DES DOCUMENTS AVEC PAGINATION
                $content .= '<div class="counter-doc"><span class="wphal-nbtot">' . $json->response->numFound . ' </span>';
                $content .= __('documents', 'wp-hal'). '</div><br>';

//--MODULE PAGINATION--//
                $messagesParPage = 10;

                $total = $json->response->numFound;

                $nombreDePages = ceil($total / $messagesParPage);

                if (isset($paged)) {
                    $pageActuelle = intval($paged);

                    if ($pageActuelle > $nombreDePages) {
                        $pageActuelle = $nombreDePages;
                    }
                } else {
                    $pageActuelle = 1;
                }
                $premiereEntree = ($pageActuelle - 1) * $messagesParPage;

                $url = api . '?q=*:*&fq=' . $type . ':(' . urlencode($id) . ')&fl=docid,citationFull_s,keyword_s,bookTitle_s,producedDate_s,authFullName_s&start=' . $premiereEntree . '&rows=' . $messagesParPage . '&sort=' . producedDateY . '&wt=json';
                $ch = curl_init($url);
// Options
                $options = array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_USERAGENT => "HAL Plugin Wordpress " . version
                );

// Bind des options et de l'objet cURL que l'on va utiliser
                curl_setopt_array($ch, $options);
// Récupération du résultat JSON
                $json = json_decode(curl_exec($ch));
                curl_close($ch);

//--MODULE PAGINATION--//

                $content .= '<ul>';
                for ($i = 0; $json->response->docs[$i] != ''; $i++) {
                    $content .= '<li>' . $json->response->docs[$i]->citationFull_s . '</li>';
                }
                $content .= '</ul>';

//--AFFICHAGE PAGINATION--//
                $precedents = $pageActuelle - 2;
                $suivants = $pageActuelle + 2;
                $precedent = $pageActuelle - 1;
                $suivant = $pageActuelle + 1;
                $penultimate = $nombreDePages - 1;

                $content .= '<ul class="wphal-pagination">';
//--BOUTON PRECEDENT--//
                if ($pageActuelle == 1) {
                    $content .= '<li class="disabled"><a href="#">&laquo;</a></li>';
                } else {
                    $content .= '<li><a href="?paged=' . $precedent . '">&laquo;</a></li>';
                }
                if ($nombreDePages <= 6) {// Cas 1 : 6 pages ou moins - Pas de troncature
                    for ($i = 1; $i <= $nombreDePages; $i++) {
                        if ($i == $pageActuelle) {
                            $content .= '<li class="active"><a href="#">' . $i . '</a></li>';
                        } else {
                            $content .= ' <li><a href="?paged=' . $i . '">' . $i . '</a></li> ';
                        }
                    }
                } elseif ($nombreDePages >= 7) {// Cas 2 : 7 pages ou plus - Troncature
                    if ($pageActuelle <= 3) {// Lorsque l'on est sur les trois premières pages
                        for ($i = 1; $i <= 4; $i++) {
                            if ($i == $pageActuelle) {
                                $content .= '<li class="active"><a href="#">' . $i . '</a></li>';
                            } else {
                                $content .= '<li><a href="?paged=' . $i . '">' . $i . '</a></li>';
                            }
                        }
                        $content .= '<li class="disabled"><a href="#">&hellip;</a></li>';
                        $content .= '<li><a href="?paged=' . $penultimate . '">' . $penultimate . '</a></li>';
                        $content .= '<li><a href="?paged=' . $nombreDePages . '">' . $nombreDePages . '</a></li>';
                    }
                    if ($pageActuelle >= 4 && $pageActuelle <= $penultimate - 2) {//Lorsque l'on arrive sur la quatrième page
                        $content .= '<li><a href="?paged=">1</a></li>';
                        $content .= '<li class="disabled"><a href="#">&hellip;</a></li>';
                        $content .= '<li><a href="?paged=' . $precedents . '">' . $precedents . '</a></li>';
                        $content .= '<li><a href="?paged=' . $precedent . '">' . $precedent . '</a></li>';
                        $content .= '<li class="active"><a href="#">' . $pageActuelle . '</a></li>';
                        $content .= '<li><a href="?paged=' . $suivant . '">' . $suivant . '</a></li>';
                        $content .= '<li><a href="?paged=' . $suivants . '">' . $suivants . '</a></li>';
                        $content .= '<li class="disabled"><a href="#">&hellip;</a></li>';
                        $content .= '<li><a href="?paged=' . $nombreDePages . '">' . $nombreDePages . '</a></li>';
                    }
                    if ($pageActuelle >= $penultimate - 1) {
                        $content .= '<li><a href="?paged=1">1</a></li>';
                        $content .= '<li><a href="?paged=2">2</a></li>';
                        $content .= '<li class="disabled"><a href="#">&hellip;</a></li>';
                        for ($i = $penultimate - 2; $i <= $nombreDePages; $i++) {
                            if ($i == $pageActuelle) {
                                $content .= '<li class="active"><a href="#">' . $i . '</a></li>';
                            } else {
                                $content .= '<li><a href="?paged=' . $i . '">' . $i . '</a></li>';
                            }
                        }
                    }
                }
//--BOUTON SUIVANT--//
                if ($pageActuelle < $nombreDePages) {
                    $content .= '<li><a href="?paged=' . $suivant . '">&raquo;</a></li>';
                } else {
                    $content .= '<li class="disabled"><a href="#">&raquo;</a></li>';
                }
                $content .= '</ul>';
//--AFFICHAGE PAGINATION--//
            }
            $content .= '</div>
    </div>
</div>';
        }
        $content .= '<div class="wphal-footer">';
        $content .= '<p style="color:#B3B2B0">' . __("Documents récupérés de l'archive ouverte HAL", 'wp-hal') . '&nbsp;<a href="' . site . '" target="_blank"><img alt="logo" src=" ' . plugin_dir_url(__FILE__) . 'img/logo-hal.svg" style="width:32px;"></a></p>';
        $content .= '</div>';

//--AFFICHAGE GRAPHIQUE DOMAINE--//
        if (!is_null($facetdomain)) {
            foreach ($facetdomain as $res) {
                $name = explode(delimiter, $res[0])[1];
                $value = $res[1];
                $array[] = array($name, $value);
            }
        }
        wp_localize_script('wp-hal-script4', 'WPWallSettings', json_encode($array));
        $translation = array('liste' => __('Liste', 'wp-hal'), 'compl' => __('Liste complète', 'wp-hal'), 'princ' => __('Liste principale', 'wp-hal'), 'graph' => __('Graphique', 'wp-hal'), 'nuage' => __('Nuage de mots', 'wp-hal'));
        wp_localize_script('wp-hal-script4', 'translate', $translation);
    }
    return  $content;
}

function verifSolr($values){
    $verifsolr = explode(',',$values);
    $numverif = count($verifsolr);
    $solrsql = '';
    if ($numverif<1024){
        $solrsql = str_replace(',',' OR ',$values);
    } else {
        $listsolrsql = explode(',',$values);
        for($i=0;$i<1024;$i++){
            if ($i == 0){
                $solrsql = $listsolrsql[$i];
            } else {
                $solrsql .= ' OR ';
                $solrsql .= $listsolrsql[$i];
            }
        }
    }

    return $solrsql;
}

function wp_adding_style() {
    wp_register_style('wp-hal-style1', plugins_url('/css/style.css', __FILE__));
    wp_register_style('wp-hal-style2', plugins_url('/css/jquery.jqplot.css', __FILE__));

    wp_enqueue_style('wp-hal-style1');
}

function wp_adding_script() {
    wp_register_script('wp-hal-script1',plugins_url('/js/jquery.jqplot.js', __FILE__));
    wp_register_script('wp-hal-script2',plugins_url('/js/jqplot.highlighter.js', __FILE__));
    wp_register_script('wp-hal-script3',plugins_url('/js/jqplot.pieRenderer.js', __FILE__));
    wp_register_script('wp-hal-script4',plugins_url('/js/cv-hal.js', __FILE__));


    wp_enqueue_script("jquery");
    wp_enqueue_script('wp-hal-script4', false, array(), false, true);
}

/**
 * Récupère les fichiers css et js
 */
if ( function_exists('curl_init' ) ) {
    add_action('wp_enqueue_scripts', 'wp_adding_style');
    add_action('wp_enqueue_scripts', 'wp_adding_script');
}

/**
 * Charge lorsque le plugin est désactivé
 */
register_deactivation_hook( __FILE__, 'reset_option' );

/**
 * Ajoute le widget wphal à l'initialisation des widgets
 */
add_action('widgets_init','wphal_init');

/**
 * Ajoute le menu à l'initialisation du menu admin
 */
add_action( 'admin_menu', 'wphal_menu' );

/**
 * Fonction de création du menu
 */
function wphal_menu() {
    add_menu_page( 'Options', 'Hal', 'manage_options', 'wp-hal.php', 'wphal_option' , '', 21);

    add_action( 'admin_init', 'register_settings' );
}


/**
 * Initialise le nouveau widget
 */
function wphal_init(){
    register_widget("wphal_widget");
}

/***********************************************************************************************************************
 * PLUGIN WIDGET
 **********************************************************************************************************************/

/**
 * Classe du widget wphal
 */

class wphal_widget extends WP_widget{


    /**
     * Défini les propriétés du widget
     */
    function wphal_widget(){
        $options = array(
            "classname" => "wphal-publications",
            "description" => __("Afficher les dernières publications d'un auteur ou d'une structure.", 'wp-hal')
        );

        parent::__construct(
            'hal-publications',
            __("Publications récentes", 'wp-hal'),
            $options
        );
    }

    /**
     * Crée le widget
     * @param $args
     * @param $instance
     */
    function widget($args, $instance){
        if ( !function_exists('curl_init' ) ) {
            $content = 'Please check the <a href="https://wordpress.org/plugins/hal/faq/" target="_blank" id="FAQ">FAQ</a> with the code : CURL';
            extract($args);
            echo $before_widget;
            echo $before_title . $instance['titre'] . $after_title;
            echo $content;
            echo $after_widget;
        } else {
            $instance['idhal'] = verifSolr($instance['idhal']);

            $url = api . '?q=*:*&fq=' . $instance['select'] . ':' . urlencode($instance['idhal']) . '&fl=uri_s,'. $instance['typetext'] .'&sort=' . producedDateY . '&rows=' . $instance['nbdoc'] . '&wt=json';

            $ch = curl_init($url);
            // Options
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                CURLOPT_TIMEOUT => 10,
                CURLOPT_USERAGENT => "HAL Plugin Wordpress " . version
            );

            // Bind des options et de l'objet cURL que l'on va utiliser
            curl_setopt_array($ch, $options);
            // Récupération du résultat JSON
            $json = json_decode(curl_exec($ch));
            curl_close($ch);

            $content = '<ul class="widhal-ul">';
            for ($i = 0; $i < $instance['nbdoc']; $i++) {
                if ($instance['typetext']=='citationRef_s') {
                    $typetext = $json->response->docs[$i]->citationRef_s;
                } else {
                    $typetext = $json->response->docs[$i]->title_s[0];
                }
                $content .= '<li class="widhal-li"><a href="' . $json->response->docs[$i]->uri_s . '" target="_blank">' . $typetext . '</a></li>';
            }
            $content .= '</ul>';

            extract($args);
            echo $before_widget;
            echo $before_title . $instance['titre'] . $after_title;
            echo $content;
            echo $after_widget;
        }
    }

    /**
     * Sauvegarde des données
     * @param $new
     * @param $old
     */
    function update($new, $old){
        return $new;
    }

    /**
     * Formulaire du widget
     * @param $instance
     */
    function form($instance){

        $defaut = array(
            'titre' => __("Publications récentes", 'wp-hal'),
            'select' => "authIdHal_s",
            'typetext' => "title_s",
            'nbdoc' => 5
        );
        $instance = wp_parse_args($instance,$defaut);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id("titre");?>"><?php echo __('Titre','wp-hal') .' :'?></label>
            <input value="<?php echo $instance['titre'];?>" name="<?php echo $this->get_field_name("titre");?>" id="<?php echo $this->get_field_id("titre");?>" class="widefat" type="text"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("nbdoc");?>"><?php echo __("Nombre de documents affichés",'wp-hal') .' :'?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id("nbdoc");?>" name="<?php echo $this->get_field_name("nbdoc");?>" type="number" step="1" min="1" max="10" value="<?php echo $instance['nbdoc'];?>" size="3">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("typetext");?>"><?php echo __("Type d'affichage",'wp-hal') .' :'?></label>
            <select id="<?php echo $this->get_field_id("typetext");?>" name="<?php echo $this->get_field_name("typetext");?>">
                <option id="<?php echo $this->get_field_id("Title");?>" value="title_s" <?php echo ($instance["typetext"] == "title_s")?'selected':''; ?>><label for="<?php echo $this->get_field_id("Title");?>"><?php echo __("Titre", 'wp-hal')?></label></option>
                <option id="<?php echo $this->get_field_id("Citation");?>" value="citationRef_s" <?php echo ($instance["typetext"] == "citationRef_s")?'selected':''; ?>><label for="<?php echo $this->get_field_id("Citation");?>"><?php echo __("Citation", 'wp-hal')?></label></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("select");?>"><?php echo __("Type d'Id",'wp-hal') .' :'?></label>
            <select id="<?php echo $this->get_field_id("select");?>" name="<?php echo $this->get_field_name("select");?>">
                <option id="<?php echo $this->get_field_id("Idhal");?>" value="authIdHal_s" <?php echo ($instance["select"] == "authIdHal_s")?'selected':''; ?>><label for="<?php echo $this->get_field_id("Idhal");?>">Id Hal</label><span style="font-style: italic;"> <?php echo __('(Exemple : laurent-capelli)','wp-hal');?></span></option>
                <option id="<?php echo $this->get_field_id("StructId");?>" value="structId_i" <?php echo ($instance["select"] == "structId_i")?'selected':''; ?>><label for="<?php echo $this->get_field_id("StructId");?>">Struct Id</label><span style="font-style: italic;"> <?php echo __('(Exemple : 413106)','wp-hal');?></span></option>
                <option id="<?php echo $this->get_field_id("AuthorStructId");?>" value="authStructId_i" <?php echo ($instance["select"] == "authStructId_i")?'selected':''; ?>><label for="<?php echo $this->get_field_id("AuthorStructId");?>">AuthorStruct Id</label><span style="font-style: italic;"> <?php echo __('(Exemple : 413106)','wp-hal');?></span></option>
                <option id="<?php echo $this->get_field_id("AuthorId");?>" value="authId_i" <?php echo ($instance["select"] == "authId_i")?'selected':''; ?>><label for="<?php echo $this->get_field_id("AuthorId");?>">Author Id</label><span style="font-style: italic;"> <?php echo __('(Exemple : 413106)','wp-hal');?></span></option>
                <option id="<?php echo $this->get_field_id("Anrproject");?>" value="anrProjectId_i" <?php echo ($instance["select"] == "anrProjectId_i")?'selected':''; ?>><label for="<?php echo $this->get_field_id("Anrproject");?>">anrProject Id</label><span style="font-style: italic;"> <?php echo __('(Exemple : 1646)','wp-hal');?></span></option>
                <option id="<?php echo $this->get_field_id("Europeanproject");?>" value="europeanProjectId_i" <?php echo ($instance["select"] == "europeanProjectId_i")?'selected':''; ?>><label for="<?php echo $this->get_field_id("Europeanproject");?>">europeanProject Id</label><span style="font-style: italic;"> <?php echo __('(Exemple : 17877)','wp-hal');?></span></option>
                <option id="<?php echo $this->get_field_id("Collection");?>" value="collCode_s" <?php echo ($instance["select"] == "collCode_s")?'selected':''; ?>><label for="<?php echo $this->get_field_id("Collection");?>">Collection</label><span style="font-style: italic;"> <?php echo __('(Exemple : TICE2014)','wp-hal');?></span></option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("idhal");?>"><?php echo __("Id",'wp-hal') .' :'?></label>
            <input value="<?php echo $instance['idhal'];?>" name="<?php echo $this->get_field_name("idhal");?>" id="<?php echo $this->get_field_id("idhal");?>" type="text"/>
        </p>
    <?php
    }
}


function register_settings() {
    register_setting( 'wphal_option', 'option_choix' );
    register_setting( 'wphal_option', 'option_type' );
    register_setting( 'wphal_option', 'option_groupe' );
    register_setting( 'wphal_option', 'option_idhal' );
    register_setting( 'wphal_option', 'option_lang' );
    register_setting( 'wphal_option', 'option_infocontact' );
    register_setting( 'wphal_option', 'option_email' );
    register_setting( 'wphal_option', 'option_tel' );
    register_setting( 'wphal_option', 'option_social0' );
    register_setting( 'wphal_option', 'option_social1' );
    register_setting( 'wphal_option', 'option_social2' );
    register_setting( 'wphal_option', 'option_social3' );
}

/**
 * Crée le menu d'option du plugin
 */
function wphal_option() {

    if (get_option('option_type')==''){
        update_option('option_type', 'authIdHal_s');
    }
    if (get_option('option_groupe')==''){
        update_option('option_groupe', 'paginer');
    }
    ?>
    <div class="wrap">
        <h2><?php echo __('Plugin HAL','wp-hal');?></h2>
        <form method="post" enctype="multipart/form-data" action="options.php">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <?php settings_fields( 'wphal_option' ); ?>
                        <?php do_settings_sections( 'wphal_option' ); ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row" style="font-size: 18px;"><?php echo __('Paramètre de la page :','wp-hal');?></th>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php echo __('Type d\'Id','wp-hal');?></th>
                                <td><select name="option_type">
                                        <option id="Idhal" value="authIdHal_s" <?php echo (get_option('option_type') == "authIdHal_s")?'selected':''; ?>><label for="Idhal">Id Hal</label><span style="font-style: italic;"> <?php echo __('(Exemple : laurent-capelli)','wp-hal');?></span></option>
                                        <option id="StructId" value="structId_i" <?php echo (get_option('option_type') == "structId_i")?'selected':''; ?>><label for="StructId">Struct Id</label><span style="font-style: italic;"> <?php echo __('(Exemple : 413106)','wp-hal');?></span></option>
                                        <option id="AuthorStructId" value="authStructId_i" <?php echo (get_option('option_type') == "authStructId_i")?'selected':''; ?>><label for="AuthorStructId">AuthorStruct Id</label><span style="font-style: italic;"> <?php echo __('(Exemple : 413106)','wp-hal');?></span></option>
                                        <option id="AuthorId" value="authId_i" <?php echo (get_option('option_type') == "authId_i")?'selected':''; ?>><label for="AuthorId">Author Id</label><span style="font-style: italic;"> <?php echo __('(Exemple : 413106)','wp-hal');?></span></option>
                                        <option id="Anrproject" value="anrProjectId_i" <?php echo (get_option('option_type') == "anrProjectId_i")?'selected':''; ?>><label for="Anrproject">anrProject Id</label><span style="font-style: italic;"> <?php echo __('(Exemple : 1646)','wp-hal');?></span></option>
                                        <option id="Europeanproject" value="europeanProjectId_i" <?php echo (get_option('option_type') == "europeanProjectId_i")?'selected':''; ?>><label for="Europeanproject">europeanProject Id</label><span style="font-style: italic;"> <?php echo __('(Exemple : 17877)','wp-hal');?></span></option>
                                        <option id="Collection" value="collCode_s" <?php echo (get_option('option_type') == "collCode_s")?'selected':''; ?>><label for="Collection">Collection</label><span style="font-style: italic;"> <?php echo __('(Exemple : TICE2014)','wp-hal');?></span></option>
                                    </select>
                                    <input type="text" name="option_idhal" id="option_idhal" value="<?php echo get_option('option_idhal'); ?>"/>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php echo __('Affichage des documents','wp-hal');?></th>
                                <td><input type="radio" name="option_groupe" id="paginer" value="paginer" <?php echo (get_option('option_groupe') == "paginer")?'checked':''; ?>><label for="paginer"><?php echo __('Documents avec pagination','wp-hal');?></label><br>
                                    <input type="radio" name="option_groupe" id="grouper" value="grouper" <?php echo (get_option('option_groupe') == "grouper")?'checked':''; ?>><label for="grouper"><?php echo __('Documents groupés par type','wp-hal');?></label><br>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php echo __('Choix des éléments menu','wp-hal');?></th>
                                <td><input type="checkbox" name="option_choix[1]" id="Contact" value="contact" <?php echo (get_option('option_choix')[1] == "contact")?'checked':''; ?>><label for="Contact"><?php echo __('Contact','wp-hal');?></label><br/>
                                    <input type="checkbox" name="option_choix[2]" id="Disciplines" value="disciplines" <?php echo (get_option('option_choix')[2] == "disciplines")?'checked':''; ?>><label for="Disciplines"><?php echo __('Disciplines','wp-hal');?></label><br/>
                                    <input type="checkbox" name="option_choix[3]" id="Mots-clefs" value="mots-clefs" <?php echo (get_option('option_choix')[3] == "mots-clefs")?'checked':''; ?>><label for="Mots-clefs"><?php echo __('Mots-clefs','wp-hal');?></label><br/>
                                    <input type="checkbox" name="option_choix[4]" id="Auteurs" value="auteurs" <?php echo (get_option('option_choix')[4] == "auteurs")?'checked':''; ?>><label for="Auteurs"><?php echo __('Auteurs','wp-hal');?></label><br/>
                                    <input type="checkbox" name="option_choix[5]" id="Revues" value="revues" <?php echo (get_option('option_choix')[5] == "revues")?'checked':''; ?>><label for="Revues"><?php echo __('Revues','wp-hal');?></label><br/>
                                    <input type="checkbox" name="option_choix[6]" id="Annee" value="annee" <?php echo (get_option('option_choix')[6] == "annee")?'checked':''; ?>><label for="Annee"><?php echo __('Année de production','wp-hal');?></label><br/>
                                    <input type="checkbox" name="option_choix[7]" id="Institution" value="institution" <?php echo (get_option('option_choix')[7] == "institution")?'checked':''; ?>><label for="Institution"><?php echo __('Institutions','wp-hal');?></label><br/>
                                    <input type="checkbox" name="option_choix[8]" id="Laboratoire" value="laboratoire" <?php echo (get_option('option_choix')[8] == "laboratoire")?'checked':''; ?>><label for="Laboratoire"><?php echo __('Laboratoires','wp-hal');?></label><br/>
                                    <input type="checkbox" name="option_choix[9]" id="Departement" value="departement" <?php echo (get_option('option_choix')[9] == "departement")?'checked':''; ?>><label for="Departement"><?php echo __('Départements','wp-hal');?></label><br/>
                                    <input type="checkbox" name="option_choix[10]" id="Equipe" value="equipe" <?php echo (get_option('option_choix')[10] == "equipe")?'checked':''; ?>><label for="Equipe"><?php echo __('Équipes de recherche','wp-hal');?></label>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row" style="font-size: 18px;"><?php echo __('Contact :','wp-hal');?></th>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo __("Afficher les informations d'un chercheur ayant un IdHal ?",'wp-hal');?></th>
                                <td><input type="radio" name="option_infocontact" id="wphal-yes" value="yes" <?php echo (get_option('option_infocontact') == "yes")?'checked':''; ?>><label for="wphal-yes"><?php echo __("Oui",'wp-hal')?></label><br>
                                    <input type="radio" name="option_infocontact" id="wphal-no" value="no" <?php echo (get_option('option_infocontact') ==  "no")?'checked':''; ?>><label for="wphal-no"><?php echo __("Non",'wp-hal')?></label><br>
                                </td>
                            <tr>
                                <th scope="row"><?php echo __('Email','wp-hal');?></th>
                                <td><input type="text" style="width:300px;" placeholder="Exemple : hi@mail.com" name="option_email" id="option_email" value="<?php echo get_option('option_email'); ?>"/><img alt="email" src="<?php echo plugin_dir_url( __FILE__ )  ?>img/mail.svg" style="vertical-align:middle; width:32px; margin-left:2px; margin-right:2px;"/></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo __('Téléphone','wp-hal');?></th>
                                <td><input type="text" style="width:300px;" placeholder="Exemple : 06-01-02-03-04" name="option_tel" id="option_tel" value="<?php echo get_option('option_tel');?>"/><img alt="phone" src="<?php echo plugin_dir_url( __FILE__ )  ?>img/phone.svg" style="vertical-align:middle; width:32px; margin-left:2px; margin-right:2px;"/></td>
                            </tr>
                            <tr>
                                <th>Facebook (http://www.facebook.com/)</th>
                                <td><input type="text" style="width:300px;" placeholder="Exemple : fa.book" name="option_social0" id="option_social0" value="<?php echo get_option('option_social0'); ?>"/><img alt="facebook" src="<?php echo plugin_dir_url( __FILE__ )  ?>img/facebook.svg" style="vertical-align:middle; width:32px; margin-left:2px; margin-right:2px;"/></td>
                            </tr>
                            <tr>
                                <th>Twitter (http://www.twitter.com/)</th>
                                <td><input type="text" style="width:300px;" placeholder="Exemple : tweet_heure" name="option_social1" id="option_social1" value="<?php echo get_option('option_social1'); ?>"/><img alt="twitter" src="<?php echo plugin_dir_url( __FILE__ )  ?>img/twitter.svg" style="vertical-align:middle; width:32px; margin-left:2px; margin-right:2px;"/></td>
                            </tr>
                            <tr>
                                <th>Google + (https://plus.google.com/u/0/+)</th>
                                <td><input type="text" style="width:300px;" placeholder="Exemple : goo.plus" name="option_social2" id="option_social2" value="<?php echo get_option('option_social2'); ?>"/><img alt="google" src="<?php echo plugin_dir_url( __FILE__ )  ?>img/google-plus.svg" style="vertical-align:middle; width:32px; margin-left:2px; margin-right:2px;"/></td>
                            </tr>
                            <tr>
                                <th>LinkedIn (https://www.linkedin.com/in/)</th>
                                <td><input type="text" style="width:300px;" placeholder="Exemple : link.dine" name="option_social3" id="option_social3" value="<?php echo get_option('option_social3'); ?>"/><img alt="linkedin" src="<?php echo plugin_dir_url( __FILE__ )  ?>img/linkedin.svg" style="vertical-align:middle; width:32px; margin-left:2px; margin-right:2px;"/></td>
                            </tr>
                        </table>
                        <?php
                        submit_button(__('Enregistrer','wp-hal'), 'primary large', 'submit', true); ?>
                    </div>
                    <div id="postbox-container-1" class="postbox-container">

                    </div>
                </div>
                <br class="clear"><br/>
            </div>
        </form>

    </div>

<?php
}


/**
 * Reset les données Hal
 */
function reset_option() {
    delete_option('option_choix');
    delete_option('option_type');
    delete_option('option_groupe');
    delete_option('option_idhal');
    delete_option('option_lang');
    delete_option('option_infocontact');
    delete_option('option_email');
    delete_option('option_tel');
    delete_option('option_social0');
    delete_option('option_social1');
    delete_option('option_social2');
    delete_option('option_social3');
}
?>