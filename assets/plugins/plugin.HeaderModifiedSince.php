<?php
if (!defined('MODX_BASE_PATH')) { die('HACK???'); }

/**
 * HeaderModifiedSince
 *
 * Return header &quot;HTTP/1.0 304 Not Modified&quot; if HTTP_IF_MODIFIED_SINCE
 *
 * @license     GNU General Public License (GPL), http://www.gnu.org/copyleft/gpl.html
 * @author      Sergey Davydov <webmaster@sdcollection.com>
 * @version     0.1
 * @internal    @events         OnWebPagePrerender
 * @internal    @legacy_names   HeaderModifiedSince
 * @internal    @modx_category  Content
 * @internal    @installset base, sample
*/ 


if (in_array($modx->event->name, explode(",",'OnWebPagePrerender'))) {

	$modified = date("r", $modx->documentObject["editedon"]);

	header("Last-Modified: $modified");
	header('Expires: ' . date("r", time() + 3600));

	if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
		$lastMod = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
		$qtime = isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])?$_SERVER['HTTP_IF_MODIFIED_SINCE']:'';
		// header("Cache-control: private, max-age = 3600");

		if (strtotime($qtime) >= strtotime($modified)) {
			header("HTTP/1.1 304 Not Modified ");
			// header("Expires: " . date("r", time() + 3600));
			exit();
		}
	}
}
return;
?>