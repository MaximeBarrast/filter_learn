/**
 * Filter Learn Driver for Markasjunk2 plugin for Roundcube
 *
 * Plugin drivers that adds a client-side e-mail filtering to the MarkasJunk2 button. 
 * Spam button => a new filter blocking the sender's email is created.
 * Ham button => the filter related to the sender's email is deleted.
 *
 * @version 1.0
 * @author Maxime Barrast <maximebarrast@free.fr>
 *
 */

BEFORE you install this drivers you need:
1- Markasjunk2 plugin installed ( http://plugins.roundcube.net/packages/johndoh/markasjunk2 )
2- Filters plugin byRoberto Zarrelli installed ( https://github.com/eagle00789/RC_Filters )

To install the plugin you have to:
1- Download zip-archive;
2- Unzip downloaded zip-archive;  
3- Rename unziped file to 'filter_learn.php';
4- Move this file to Roundcube/plugins/markasjunk2/drivers folder;
5- Add "filter_learn" in the driver section of the markasjunk2 configuration (/plugins/markasjunk2/config.inc.php) :
$config['markasjunk2_learning_driver'] = 'filter_learn';

