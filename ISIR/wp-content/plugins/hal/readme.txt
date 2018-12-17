=== HAL ===
Contributors: friz, ccsd
Tags: publication, HAL, archive
Requires at least: 4.0
Tested up to: 5.0
Stable tag: 2.0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create a page with publications of an author or a structure in relation with HAL and a widget of recent publications of an author or a structure.

== Description ==

This is the first plugin of HAL.
The HAL plugin allows authors or structures to display in their own blog their publications.
HAL plugin data are directly related to HAL website (http://hal.archives-ouvertes.fr/).

== Installation ==

= Requires : =
* PHP 5.5 or higher
* WordPress 4.0 or higher
* cURL extension on php.ini

= Installation procedure : =

1. Desactivate plugin if you have the previous version installed.
2. Unzip "HAL" archive and put all files into a folder like "/wp-content/plugins/hal" directory.
3. Activate "HAL" plugin via 'Plugins' menu in WordPress admin menu.

= For the page : =

4. Go to the "Hal" menu item and select parameters to display options needed in your blog.
5. Create your page and add the shortcode [cv-hal] to see publications and metadata.

= For the widget : =

4. Go to the menu "Appearance", "Widgets" to configure the widget "Lastest Publications".

== Frequently Asked Questions ==

= How can I contact the support ? =

You can contact the support at this address : http://support.ccsd.cnrs.fr/

Or you can contact the developer at this address : baptiste.blondelle@ccsd.cnrs.fr

= How to display the page on the site ? =

You need to create your own page with wordpress and put the shortcode [cv-hal] on the content.

= What can i do to personalize my page ? =

You can display multiple page with different IDs with parameters on the shortcode, example : [cv-hal id=184 type=authStructId_i]

Type of identifier are :

* IdHal = authIdHal_s
* Structure Id = structId_i
* AuthorStructure Id = authStructId_i
* Author Id = authId_i
* ANR Project Id = anrProjectId_i
* European Project Id = europeanProjectId_i
* Collection Id = collCode_s

You can add in the shortcode "contact=yes" or "contact=no" to recover HAL Contact.

You can add a new shortcode [nb-doc] to display the number of documents.

= Error Code =

* CURL : You need to enable extension PHP php_curl. You can do it through the repository **Apache/bin** and edit the file **php.ini** then uncomment the line **;extension=php_curl.dll**

== Screenshots ==

1. Screenshot page settings in admin menu
2. Screenshot widget settings in admin menu
3. Screenshot example page client

== Changelog ==

= 2.0.6 =
*Release Date - 28 September 2018*

Page & Widget :

* Add the identifier authId_i for author


= 2.0.5 =
*Release Date - 14 February 2017*

Code :

* Code modification

= 2.0.4 =
*Release Date - 3 February 2017*

Page :

* Add/Change type of Id : Struct Id = structId_i (all structures) / AuthorStruct Id = authStructId_i (structures directly linked with the author)
If you had some questions about this modification, contact the developer.

= 2.0.3 =
*Release Date - 24 January 2017*

Page :

* CSS modifications

= 2.0.2 =
*Release Date - 07 December 2016*

Page :

* Libraries jQplot and PieRenderer are load if the metadata "Disciplines" is checked !

= 2.0.1 =
*Release Date - 28 July 2016*

General :

* Fix minor bugs

= 2.0 =
*Release Date - 23 March 2016*

General :

* **New** Add a shortcode [nb-doc] who return number of documents (same utilisation as [cv-hal])

Page :

* Add possibility to display in "Contact" informations about a researcher with an IdHAL


= 1.4.4 =
*Release Date - 18 March 2016*

Page :

* **Important :** Fix bug Publications with DocType !
* Add class CSS for each DocType block (Example : grp-div-ART)

= 1.4.3 =
*Release Date - 16 March 2016*

Page :

* Fix bug about synchronisation of metadata with HAL
* Fix bug about button with theme Sixteen (CSS)

= 1.4.2 =
*Release Date - 7 March 2016*

Page :

* Delete the curl request to the API for DocType
* Create new repository JSON with DocType => Improving performance

= 1.4.1 =
*Release Date - 17 February 2016*

Widget :

* Citation Full change to Citation Ref (shorter)

Page :

* **Important :** Now you can give parameters to the shortcode [cv-hal] to display multiple pages on your website with different IDs. If the shortcode doesn't have parameters, he will take parameters from the settings page of the plugin. 
Example : [cv-hal] => Settings Page Plugin ; [cv-hal id=184 type=authStructId_i] => Identifier Structure 184

* Bug fixed on link URL in Metadata
* Improve the performance of the page

= 1.4 =
*Release Date - 9 February 2016*

Widget :

* Add a verification about curl extension in php config
* New interface to personalize your widget : Number of documents to show, Display type (Title or Citation)
* Multiple Ids are allowed (separated by ",")

Page :

* Add a verification about curl extension in php config
* Minor change on the interface "Publications"
* Add traduction on Typdoc
* Typdoc in the good order (ART, COMM, etc...)
* Add class or id for each item
* You can add a stylesheet in the repository "css" and call it "cvhal.css" to surcharge the css of the plugin and personalize your page. **Deleted**

= 1.3 =
*Release Date - 21 January 2016*

* Add USER_AGENT for curl
* Add conditions to call the API HAL

= 1.2 =
*Release Date - 15 January 2016*

* Correct some bugs

= 1.1 =
*Release Date - 7 September 2015*

* Bootstrap library deleted
* New appearance for the plugin

== Upgrade Notice ==

Nothing for the moment...
