<?php
/**
 * Apex - Modern version of Vector with fresh look and many usability
 * improvements.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Apex',
	'namemsg' => 'skinname-apex',
	'descriptionmsg' => 'apex-desc',
	'url' => 'https://www.mediawiki.org/wiki/Skin:Apex',
	'author' => array( 'Trevor Parscal' ),
	'license-name' => 'GPLv2+',
);

// Register files
$wgAutoloadClasses['SkinApex'] = __DIR__ . '/SkinApex.php';
$wgAutoloadClasses['ApexTemplate'] = __DIR__ . '/ApexTemplate.php';
$wgMessagesDirs['apex'] = __DIR__ . '/i18n';

// Register skin
$wgValidSkinNames['apex'] = 'Apex';

// Configuration options
$wgApexLogo = array(
	"1x" => false,
	"2x" => false
);

// Register modules
$wgResourceModules['skins.apex'] = array(
	'styles' => array(
		'resources/screen.css' => array( 'media' => 'screen' ),
		'resources/screen-narrow.css' => array( 'media' => 'screen and (max-width: 700px)' ),
		'resources/screen-wide.css' => array( 'media' => 'screen and (min-width: 982px)' ),
	),
	'scripts' => 'resources/apex.js',
	'remoteSkinPath' => 'apex',
	'localBasePath' => __DIR__,
);
