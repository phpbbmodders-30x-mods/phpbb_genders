<?php
/**
 * @package phpBB3
 * @copyright (c) 2007 eviL3
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
* @ignore
*/
define('IN_PHPBB', true);
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// auth check
if ($user->data['user_type'] != USER_FOUNDER)
{
	trigger_error('NOT_AUTHORISED');
}

// include db_tools
include($phpbb_root_path . 'includes/db/db_tools.' . $phpEx);

// perform schema changes
$db_tools = new phpbb_db_tools($db);
$db_tools->sql_column_add(USERS_TABLE, 'user_gender', array('TINT:1', 1));

// confirm
trigger_error('Genders installed successfully.<br /><br />Make sure you delete this file from your server.');

?>