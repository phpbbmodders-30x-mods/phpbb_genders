<?php
/**
*
* @package phpBB3
* @copyright (c) 2011 phpBBmodders.net
* @copyright (c) 2007, 2008 evil3
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Get user gender
 *
 * @author eviL3
 * @param int $user_gender User's gender
 * @param bool $use_text Returns text if true or image if false
 * @return string Gender
 */
function get_user_gender($user_gender, $use_text = false)
{
	global $user, $config;

	switch ($user_gender)
	{
		case GENDER_M:
			$gender = 'gender_m';
		break;

		case GENDER_F:
			$gender = 'gender_f';
		break;

		default:
			$gender = 'gender_x';
	}

	if ($use_text)
	{
		$gender = $user->lang[strtoupper($gender)];
	}
	else
	{
		$gender = $user->img('icon_' . $gender, strtoupper($gender));
	}

	return $gender;
}

/**
 * Extract a title (for gender rank)
 * Modified by evil3 for sexyness (regex)
 *
 * @param string $titles a string with all title concatained with separator '|'
 * @param number $index index of title to retrieve
 * @return string the title for the index
 */
function get_user_gender_rank($titles, $index)
{
	// thanks davidmj
	$titles_ary = preg_split('#(?<!\\\\)\|#', $titles);

	return !empty($titles_ary[$index]) ? $titles_ary[$index] : $titles_ary[GENDER_X];
}

/**
 * Escape user ranks for db entry
 */
function escape_user_gender_rank($title)
{
	return str_replace('|', '\\|', $title);
}
?>