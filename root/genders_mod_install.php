<?php
/**
 *
 * @author bonelifer (William Jacoby) bonelifer@phpbbmodders.net
 * @version $Id$
 * @copyright (c) 2011 phpbbmodders.net
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/**
 * @ignore
 */
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($phpbb_root_path . 'common.' . $phpEx);
$user->session_begin();
$auth->acl($user->data);
$user->setup();


if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The language file which will be included when installing
$language_file = 'mods/umif_gender_mod';

// The name of the mod to be displayed during installation.
$mod_name = 'INSTALL_GENDERS_MOD';

/*
* The name of the config variable which will hold the currently installed version
* UMIL will handle checking, setting, and updating the version itself.
*/
$version_config_name = 'genders_version';

/*
* Optionally we may specify our own logo image to show in the upper corner instead of the default logo.
* $phpbb_root_path will get prepended to the path specified
* Image height should be 50px to prevent cut-off or stretching.
*/
//$logo_img = 'styles/prosilver/imageset/site_logo.gif';

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/
$versions = array(
	'1.0.1-a' => array(
		'custom' => 'gender_column',
		// refresh the template
		'cache_purge' => array('', 'template', 'theme', 'imageset'),		
	), 
);

// Include the UMIL Auto file, it handles the rest
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

// here is our custom function

function gender_column ($action, $version)
{
	global $db, $table_prefix, $umil;
	
	if ($action == 'install')
	{
		if ($umil->table_column_exists('phpbb_users', 'user_gender'))
		{
			return 'GENDERS_NOTHING_TO_UPDATE';
		}
		else
		{
			$umil->table_column_add('phpbb_users', 'user_gender', array('BOOL', '0'));
			return 'GENDERS_USERS_TABLE_UPDATED';
		}
	}
	
	if ($action == 'uninstall')
	{
		$umil->table_column_remove('phpbb_users', 'user_gender');
		return 'GENDERS_DB_ENTRY_REMOVED';
	}			
}
