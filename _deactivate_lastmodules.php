<?php

ob_end_clean();
error_reporting(E_ALL);
ini_set("display_errors", 1);

//chdir(dirname(__FILE__));
define('DRUPAL_ROOT', getcwd());
$base_url = 'http://'.$_SERVER['HTTP_HOST'];
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


header('Location: '.$base_url.'/admin/modules');

$module_list = array('views_ui','field_ui','devel','module_configure_links','rules_admin','backup_migrate','update','simplehtmldom','enhanced_imagelist','prod-check');


foreach ($module_list as &$singlemodule) {

	//  module_enable(array($singlemodule),TRUE);
	module_disable(array($singlemodule),TRUE);


	/*if ( drupal_uninstall_modules(array($singlemodule)) ) {
		drupal_set_message('Module disabled and uninstalled: '.$singlemodule);
	} else {
		drupal_set_message('Module disabled: '.$singlemodule,'error');
	} */

	drupal_set_message('Module disabled: '.$singlemodule);

}
