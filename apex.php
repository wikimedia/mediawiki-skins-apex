<?php

if ( function_exists( 'wfLoadSkin' ) ) {
	wfLoadSkin( 'Apex' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['Apex'] = __DIR__ . '/i18n';
	/* wfWarn(
		'Deprecated PHP entry point used for Apex skin. Please use wfLoadSkin instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	); */
	return true;
} else {
	die( 'This version of the Apex skin requires MediaWiki 1.25+' );
}
