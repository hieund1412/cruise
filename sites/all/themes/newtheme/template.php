<?php

/**
 * Override of theme_breadcrumb().
 */
function newtheme_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

    $output .= '<div class="breadcrumb">' . implode(' › ', $breadcrumb) . '</div>';
    return $output;
  }
}

/**
 * Override or insert variables into the maintenance page template.
 */
function newtheme_preprocess_maintenance_page(&$variables) {
  // While markup for normal pages is split into page.tpl.php and html.tpl.php,
  // the markup for the maintenance page is all in the single
  // maintenance-page.tpl.php template. So, to have what's done in
  // newtheme_preprocess_html() also happen on the maintenance page, it has to be
  // called here.
  newtheme_preprocess_html($variables);
}

/**
 * Override or insert variables into the html template.
 */
function newtheme_preprocess_html(&$variables) {
  // Toggle fixed or fluid width.
  if (theme_get_setting('newtheme_width') == 'fluid') {
    $variables['classes_array'][] = 'fluid-width';
  }
  // Add conditional CSS for IE6.
  drupal_add_css(path_to_theme() . '/fix-ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lt IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
}

/**
 * Override or insert variables into the html template.
 */
function newtheme_process_html(&$variables) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_html_alter($variables);
  }
  
  
  $payment_succ = false;
   if(arg(0) == 'payment' && arg(1) == 'finish' && arg(2) != '' && arg(3) == 'success' ) {
	   $payment_succ = true;
   }
  //all page
  $element_google_manager_script = "
  	<!-- Google tag (gtag.js) -->
		<script async src='https://www.googletagmanager.com/gtag/js?id=G-4KCW82LT1Y'></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-4KCW82LT1Y');
		</script>
  
  ";
  
  
	$element_google_manager = array(
          '#type' => 'markup',
          '#markup' => $element_google_manager_script,
      );
	  $variables['scripts'] .= drupal_render($element_google_manager);
  
  

   
   
   
   
   //success
    if($payment_succ) {
		$payment_succ_script = "
			
			<!-- Event snippet for Halong - Conversion conversion page -->
				<script>
				  gtag('event', 'conversion', {
					  'send_to': 'AW-682631360/Cv2XCOTune0YEMDBwMUC',
					  'value': 1.0,
					  'currency': 'USD',
					  'transaction_id': ''
				  });
				</script>
			
			";

        $element_succ = array(
            '#type' => 'markup',
            '#markup' => $payment_succ_script,
        );
        $variables['scripts'] .= drupal_render($element_succ);

    }
	
	
}

/**
 * Override or insert variables into the page template.
 */
function newtheme_preprocess_page(&$variables) {
  // Move secondary tabs into a separate variable.
  $variables['tabs2'] = array(
    '#theme' => 'menu_local_tasks',
    '#secondary' => $variables['tabs']['#secondary'],
  );
  unset($variables['tabs']['#secondary']);

  if (isset($variables['main_menu'])) {
    $variables['primary_nav'] = theme('links__system_main_menu', array(
      'links' => $variables['main_menu'],
      'attributes' => array(
        'class' => array('links', 'inline', 'main-menu'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $variables['primary_nav'] = FALSE;
  }
  if (isset($variables['secondary_menu'])) {
    $variables['secondary_nav'] = theme('links__system_secondary_menu', array(
      'links' => $variables['secondary_menu'],
      'attributes' => array(
        'class' => array('links', 'inline', 'secondary-menu'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $variables['secondary_nav'] = FALSE;
  }

  // Prepare header.
  $site_fields = array();
  if (!empty($variables['site_name'])) {
    $site_fields[] = $variables['site_name'];
  }
  if (!empty($variables['site_slogan'])) {
    $site_fields[] = $variables['site_slogan'];
  }
  $variables['site_title'] = implode(' ', $site_fields);
  if (!empty($site_fields)) {
    $site_fields[0] = '<span>' . $site_fields[0] . '</span>';
  }
  $variables['site_html'] = implode(' ', $site_fields);

  // Set a variable for the site name title and logo alt attributes text.
  $slogan_text = $variables['site_slogan'];
  $site_name_text = $variables['site_name'];
  $variables['site_name_and_slogan'] = $site_name_text . ' ' . $slogan_text;
}

/**
 * Override or insert variables into the node template.
 */
function newtheme_preprocess_node(&$variables) {
  $variables['submitted'] = $variables['date'] . ' — ' . $variables['name'];
}

/**
 * Override or insert variables into the comment template.
 */
function newtheme_preprocess_comment(&$variables) {
  $variables['submitted'] = $variables['created'] . ' — ' . $variables['author'];
}

/**
 * Override or insert variables into the block template.
 */
function newtheme_preprocess_block(&$variables) {
  $variables['title_attributes_array']['class'][] = 'title';
  $variables['classes_array'][] = 'clearfix';
}

/**
 * Override or insert variables into the page template.
 */
function newtheme_process_page(&$variables) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($variables);
  }

    $metatag_description = array(
        '#type' => 'html_tag',
        '#tag' => 'meta',
        '#attributes' => array(
            'name' => 'viewport',
            'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0',
        )
    );

    drupal_add_html_head($metatag_description, 'viewport');
}

/**
 * Override or insert variables into the region template.
 */
function newtheme_preprocess_region(&$variables) {
  if ($variables['region'] == 'header') {
    $variables['classes_array'][] = 'clearfix';
  }
}
