<?php
	'skins.apex' => array(
		'styles' => array(
			'common/commonElements.css' => array( 'media' => 'screen' ),
			'common/commonContent.css' => array( 'media' => 'screen' ),
			'common/commonInterface.css' => array( 'media' => 'screen' ),
			'apex/screen.css' => array( 'media' => 'screen' ),
			'apex/screen-narrow.css' => array( 'media' => 'screen and (max-width: 700px)' ),
			'apex/screen-wide.css' => array( 'media' => 'screen and (min-width: 982px)' ),
		),
		'scripts' => 'apex/apex.js',
		'remoteBasePath' => $GLOBALS['wgStylePath'],
		'localBasePath' => $GLOBALS['wgStyleDirectory'],
	),
