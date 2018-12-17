<?php
/**
 * Created by PhpStorm.
 * User: baptiste
 * Date: 26/05/14
 * Time: 10:10
 */

// Constante pour gérer certaines facet
define('delimiter', '_FacetSep_');

// Constante pour l'api utilisé
define('api', 'http://api.archives-ouvertes.fr/search/hal/');

// Constante pour le webservice des autheurs utilisé
define('urlauthor', 'http://api.archives-ouvertes.fr/ref/author/');

// Constante pour le CV HAL d'un auteur ayant un IdHAl
define('cvhal', 'http://cv.archives-ouvertes.fr/');

// Constante pour la redirection vers le site halv3 onglet recherche
define('halv3', 'https://hal.archives-ouvertes.fr/search/index/');

// Constante pour la redirection vers le site halv3 onglet accueil
define('site', 'https://hal.archives-ouvertes.fr/');

// Constante pour le tri par date
define('producedDateY', urlencode('producedDateY_i desc'));

// Constante de langue
define('locale', get_locale());

// Constante de Version USERAGENT
define('version', '2.0.6');