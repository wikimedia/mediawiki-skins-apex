<?php

/**
 * SkinTemplate class for Apex skin
 * @ingroup Skins
 */
class SkinApex extends SkinTemplate {

	/** @var string[] */
	protected static $bodyClasses = [ 'apex-animateLayout' ];

	/** @inheritDoc */
	public $skinname = 'apex';
	/** @inheritDoc */
	public $stylename = 'apex';
	/** @inheritDoc */
	public $template = 'ApexTemplate';

	/**
	 * Initializes output page and sets up skin-specific parameters
	 * @param OutputPage $out OutputPage object to initialize
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		// Append CSS which includes IE only behavior fixes for hover support -
		// this is better than including this in a CSS fille since it doesn't
		// wait for the CSS file to load before fetching the HTC file.
		$min = $this->getRequest()->getFuzzyBool( 'debug' ) ? '' : '.min';
		$out->addHeadItem( 'csshover',
			'<!--[if lt IE 7]><style type="text/css">body{behavior:url("' .
				htmlspecialchars( $this->getConfig()->get( 'LocalStylePath' ) ) .
				"/{$this->stylename}/csshover{$min}.htc\")}</style><![endif]-->"
		);
		$out->addHeadItem( 'ie9-gradient',
			'<!--[if gte IE 9]><style type="text/css">' .
				'.gradient { filter: none; }</style><![endif]-->'
		);

		$out->addModules( 'skins.apex' );
	}

	/**
	 * Adds classes to the body element.
	 *
	 * @param OutputPage $out OutputPage object
	 * @param Skin $sk
	 * @param array &$bodyAttrs Array of attributes that will be set on the body element
	 */
	public static function onOutputPageBodyAttributes( OutputPage $out, Skin $sk, &$bodyAttrs ) {
		if ( isset( $bodyAttrs['class'] ) && strlen( $bodyAttrs['class'] ) > 0 ) {
			$bodyAttrs['class'] .= ' ' . implode( ' ', static::$bodyClasses );
		} else {
			$bodyAttrs['class'] = implode( ' ', static::$bodyClasses );
		}
	}
}
