<?php

/**
 * QuickTemplate class for Apex skin
 * @ingroup Skins
 */
class ApexTemplate extends BaseTemplate {

	/* Functions */

	/**
	 * Outputs the entire contents of the (X)HTML page
	 */
	public function execute() {
		global $wgSitename, $wgApexLogo, $wgStylePath;

		// Build additional attributes for navigation urls
		$nav = $this->data['content_navigation'];
		$mode = $this->getSkin()->getUser()->isWatched( $this->getSkin()->getRelevantTitle() ) ?
			'unwatch' : 'watch';
		if ( isset( $nav['actions'][$mode] ) ) {
			$nav['views'][$mode] = $nav['actions'][$mode];
			$nav['views'][$mode]['primary'] = true;
			unset( $nav['actions'][$mode] );
		}

		// TODO: Move defining the logo path to a resource loader module with media queries to add
		// support for high DPI displays - this will also improve caching situation
		$this->data['logopath-1x'] = $wgApexLogo['1x'] ?
			$wgApexLogo['1x'] : "{$wgStylePath}/apex/images/logos/mediawiki-1x.png";
		$this->data['logopath-2x'] = $wgApexLogo['2x'] ?
			$wgApexLogo['2x'] : "{$wgStylePath}/apex/images/logos/mediawiki-2x.png";

		$xmlID = '';
		foreach ( $nav as $section => $links ) {
			foreach ( $links as $key => $link ) {
				if ( $section == 'views' && !( isset( $link['primary'] ) && $link['primary'] ) ) {
					$link['class'] = rtrim( 'apex-nav-stashable ' . $link['class'], ' ' );
				}

				$xmlID = isset( $link['id'] ) ? $link['id'] : 'ca-' . $xmlID;
				$nav[$section][$key]['attributes'] =
					' id="' . Sanitizer::escapeId( $xmlID ) . '"';
				if ( $link['class'] ) {
					$nav[$section][$key]['attributes'] .=
						' class="' . htmlspecialchars( $link['class'] ) . '"';
					unset( $nav[$section][$key]['class'] );
				}
				if ( isset( $link['tooltiponly'] ) && $link['tooltiponly'] ) {
					$nav[$section][$key]['key'] =
						Linker::tooltip( $xmlID );
				} else {
					$nav[$section][$key]['key'] =
						Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( $xmlID ) );
				}
			}
		}
		$this->data['namespace_urls'] = $nav['namespaces'];
		$this->data['view_urls'] = $nav['views'];
		$this->data['action_urls'] = $nav['actions'];
		$this->data['variant_urls'] = $nav['variants'];

		// Reverse horizontally rendered navigation elements
		if ( $this->data['rtl'] ) {
			$this->data['view_urls'] =
				array_reverse( $this->data['view_urls'] );
			$this->data['namespace_urls'] =
				array_reverse( $this->data['namespace_urls'] );
			$this->data['personal_urls'] =
				array_reverse( $this->data['personal_urls'] );
		}
		// Output HTML Page
		$this->html( 'headelement' );
?>
		<div class="apex-content-wrapper">
			<div id="content" class="mw-body">
				<a id="top"></a>
				<div id="mw-js-message" style="display:none;"<?php $this->html( 'userlangattributes' ) ?>></div>
				<?php if ( $this->data['sitenotice'] ): ?>
				<div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
				<?php endif; ?>
				<h1 id="firstHeading" class="firstHeading"><?php $this->html( 'title' ) ?></h1>
				<div id="bodyContent">
					<?php if ( $this->data['isarticle'] ): ?>
					<div id="siteSub"><?php $this->msg( 'tagline' ) ?></div>
					<?php endif; ?>
					<div id="contentSub"<?php $this->html( 'userlangattributes' ) ?>><?php $this->html( 'subtitle' ) ?></div>
					<?php if ( $this->data['undelete'] ): ?>
					<div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
					<?php endif; ?>
					<?php if ( $this->data['newtalk'] ): ?>
					<div class="usermessage"><?php $this->html( 'newtalk' )  ?></div>
					<?php endif; ?>
					<?php if ( $this->data['showjumplinks'] ): ?>
					<div id="jump-to-nav" class="mw-jump">
						<?php $this->msg( 'jumpto' ) ?>
						<a href="#mw-head"><?php $this->msg( 'jumptonavigation' ) ?></a><?php $this->msg( 'comma-separator' ) ?>
						<a href="#p-search"><?php $this->msg( 'jumptosearch' ) ?></a>
					</div>
					<?php endif; ?>
					<?php $this->html( 'bodycontent' ) ?>
					<?php if ( $this->data['printfooter'] ): ?>
					<div class="printfooter">
					<?php $this->html( 'printfooter' ); ?>
					</div>
					<?php endif; ?>
					<?php if ( $this->data['catlinks'] ): ?>
					<?php $this->html( 'catlinks' ); ?>
					<?php endif; ?>
					<?php if ( $this->data['dataAfterContent'] ): ?>
					<?php $this->html( 'dataAfterContent' ); ?>
					<?php endif; ?>
					<div class="visualClear"></div>
					<?php $this->html( 'debughtml' ); ?>
				</div>
			</div>
		</div>
		<div id="mw-head" class="noprint">
			<div id="p-logo"><a style="background-image: url(<?php $this->text( 'logopath-1x' ) ?>);" href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>" <?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) ) ?>><span><?php echo $wgSitename ?></span></a></div>
			<?php $this->renderNavigation( [ 'SEARCH', 'PERSONAL' ] ); ?>
			<div class="apex-nav">
				<div class="apex-nav-primary">
					<?php $this->renderNavigation( [ 'NAMESPACES', 'VARIANTS' ] ); ?>
				</div>
				<div class="apex-nav-secondary">
					<?php $this->renderNavigation( [ 'VIEWS', 'ACTIONS' ] ); ?>
				</div>
			</div>
		</div>
		<div id="mw-panel" class="noprint">
			<div class="apex-flyout-pull"></div>
			<?php $this->renderPortals( $this->data['sidebar'] ); ?>
		</div>
		<div id="footer"<?php $this->html( 'userlangattributes' ) ?>>
			<?php foreach ( $this->getFooterLinks() as $category => $links ): ?>
				<ul id="footer-<?php echo $category ?>">
					<?php foreach ( $links as $link ): ?>
						<li id="footer-<?php echo $category ?>-<?php echo $link ?>">
							<?php $this->html( $link ) ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endforeach; ?>
			<?php $footericons = $this->getFooterIcons( "icononly" );
			if ( count( $footericons ) > 0 ): ?>
				<ul id="footer-icons" class="noprint">
					<?php foreach ( $footericons as $blockName => $footerIcons ): ?>
					<li id="footer-<?php echo htmlspecialchars( $blockName ); ?>ico">
						<?php foreach ( $footerIcons as $icon ): ?>
						<?php echo $this->getSkin()->makeFooterIcon( $icon ); ?>
						<?php endforeach; ?>
					</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<div style="clear:both"></div>
		</div>
		<?php $this->printTrail(); ?>
	</body>
</html>
<?php
	}

	/**
	 * Render a series of portals
	 *
	 * @param array $portals
	 */
	protected function renderPortals( $portals ) {
		// Force the rendering of the following portals
		if ( !isset( $portals['SEARCH'] ) ) {
			$portals['SEARCH'] = true;
		}
		if ( !isset( $portals['TOOLBOX'] ) ) {
			$portals['TOOLBOX'] = true;
		}
		if ( !isset( $portals['LANGUAGES'] ) ) {
			$portals['LANGUAGES'] = true;
		}
		// Render portals
		foreach ( $portals as $name => $content ) {
			if ( $content === false ) {
				continue;
			}
			switch ( $name ) {
				case 'SEARCH':
					break;
				case 'TOOLBOX':
					$this->renderPortal( 'tb', $this->getToolbox(), 'toolbox', 'SkinTemplateToolboxEnd' );
					break;
				case 'LANGUAGES':
					if ( $this->data['language_urls'] ) {
						$this->renderPortal( 'lang', $this->data['language_urls'], 'otherlanguages' );
					}
					break;
				default:
					$this->renderPortal( $name, $content );
				break;
			}
		}
	}

	/**
	 * @param string $name
	 * @param array $content
	 * @param null|string $msg
	 * @param null|string|array $hook
	 */
	protected function renderPortal( $name, $content, $msg = null, $hook = null ) {
		if ( $msg === null ) {
			$msg = $name;
		}
		?>
<div class="portal" id='<?php echo Sanitizer::escapeId( "p-$name" ) ?>'<?php echo Linker::tooltip( 'p-' . $name ) ?>>
	<h5<?php $this->html( 'userlangattributes' ) ?>><?php
		$msgObj = wfMessage( $msg );
		echo htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $msg );
	?></h5>
	<div class="body">
<?php
		if ( is_array( $content ) ): ?>
		<ul>
<?php
			foreach ( $content as $key => $val ): ?>
			<?php echo $this->makeListItem( $key, $val ); ?>

<?php
			endforeach;
			if ( $hook !== null ) {
				// Avoid PHP 7.1 warning of passing $this by reference
				$template = $this;
				Hooks::run( $hook, [ &$template, true ] );
			}
			?>
		</ul>
<?php
		else: ?>
		<?php echo $content; /* Allow raw HTML block to be defined by extensions */ ?>
<?php
		endif; ?>
	</div>
</div>
<?php
	}

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 *
	 * @param array $elements
	 */
	protected function renderNavigation( $elements ) {
		// If only one element was given, wrap it in an array, allowing more
		// flexible arguments
		if ( !is_array( $elements ) ) {
			$elements = [ $elements ];
		// If there's a series of elements, reverse them when in RTL mode
		} elseif ( $this->data['rtl'] ) {
			$elements = array_reverse( $elements );
		}
		// Render elements
		foreach ( $elements as $element ) {
			switch ( $element ) {
				case 'NAMESPACES':
?>
<div id="p-namespaces" class="apex-tabs<?php
	if ( count( $this->data['namespace_urls'] ) == 0 ) {
		echo ' emptyPortlet';
	} ?>">
	<h5><?php $this->msg( 'namespaces' ) ?></h5>
	<ul<?php $this->html( 'userlangattributes' ) ?>>
		<?php foreach ( $this->data['namespace_urls'] as $link ): ?>
			<li <?php echo $link['attributes'] ?>><span><a href="<?php echo htmlspecialchars( $link['href'] ) ?>" <?php echo $link['key'] ?>><?php echo htmlspecialchars( $link['text'] ) ?></a></span></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php
				break;
				case 'VARIANTS':
?>
<div id="p-variants" class="apex-menu<?php
	if ( count( $this->data['variant_urls'] ) == 0 ) {
		echo ' emptyPortlet';
	} ?>">
	<h4>
	<?php foreach ( $this->data['variant_urls'] as $link ): ?>
		<?php if ( stripos( $link['attributes'], 'selected' ) !== false ): ?>
			<?php echo htmlspecialchars( $link['text'] ) ?>
		<?php endif; ?>
	<?php endforeach; ?>
	</h4>
	<h5><span><?php $this->msg( 'variants' ) ?></span><a href="#"></a></h5>
	<div class="menu">
		<ul>
			<?php foreach ( $this->data['variant_urls'] as $link ): ?>
				<li<?php echo $link['attributes'] ?>><a href="<?php echo htmlspecialchars( $link['href'] ) ?>" lang="<?php echo htmlspecialchars( $link['lang'] ) ?>" hreflang="<?php echo htmlspecialchars( $link['hreflang'] ) ?>" <?php echo $link['key'] ?>><?php echo htmlspecialchars( $link['text'] ) ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php
				break;
				case 'VIEWS':
?>
<div id="p-views" class="apex-tabs<?php
	if ( count( $this->data['view_urls'] ) == 0 ) {
		echo ' emptyPortlet';
	} ?>">
	<h5><?php $this->msg( 'views' ) ?></h5>
	<ul<?php $this->html( 'userlangattributes' ) ?>>
		<?php foreach ( $this->data['view_urls'] as $link ): ?>
			<li<?php echo $link['attributes'] ?>><span><a href="<?php echo htmlspecialchars( $link['href'] ) ?>" <?php echo $link['key'] ?>><?php
				// $link['text'] can be undefined - bug 27764
				if ( array_key_exists( 'text', $link ) ) {
					echo array_key_exists( 'img', $link ) ? '<img src="' . $link['img'] . '" alt="' . $link['text'] . '" />' : htmlspecialchars( $link['text'] );
				}
				?></a></span></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php
				break;
				case 'ACTIONS':
?>
<div id="p-cactions" class="apex-menu<?php
	if ( count( $this->data['action_urls'] ) == 0 ) {
		echo ' emptyPortlet';
	} ?>">
	<h5><span><?php $this->msg( 'actions' ) ?></span><a href="#"></a></h5>
	<div class="apex-menu-popup">
		<ul<?php $this->html( 'userlangattributes' ) ?>>
			<?php foreach ( $this->data['action_urls'] as $link ): ?>
				<li<?php echo $link['attributes'] ?>><span><a href="<?php echo htmlspecialchars( $link['href'] ) ?>" <?php echo $link['key'] ?>><?php echo htmlspecialchars( $link['text'] ) ?></span></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php
				break;
				case 'PERSONAL':
?>
<div id="p-personal" class="<?php
	if ( count( $this->data['personal_urls'] ) == 0 ) {
		echo ' emptyPortlet';
	} ?>">
	<h5><?php $this->msg( 'personaltools' ) ?></h5>
	<ul<?php $this->html( 'userlangattributes' ) ?>>
		<?php foreach ( $this->getPersonalTools() as $key => $item ): ?>
			<?php if ( $key === 'userpage' ): ?>
			<?php echo $this->makeListItem( $key, $item ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<ul<?php $this->html( 'userlangattributes' ) ?> class="apex-menu-popup">
		<?php foreach ( $this->getPersonalTools() as $key => $item ): ?>
			<?php if ( $key !== 'userpage' ): ?>
			<?php echo $this->makeListItem( $key, $item ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>
<?php
				break;
				case 'SEARCH':
?>
<div id="p-search">
	<h5<?php $this->html( 'userlangattributes' ) ?>><label for="searchInput"><?php $this->msg( 'search' ) ?></label></h5>
	<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
		<div id="simpleSearch">
			<?php echo $this->makeSearchInput( [ 'id' => 'searchInput', 'type' => 'text' ] ); ?>
			<?php echo $this->makeSearchButton( 'image', [ 'id' => 'searchButton', 'src' => $this->getSkin()->getSkinStylePath( 'images/icons/search.png' ), 'width' => '12', 'height' => '13' ] ); ?>
			<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
		</div>
	</form>
</div>
<?php
				break;
			}
		}
	}
}
