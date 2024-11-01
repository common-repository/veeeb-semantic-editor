<?php
/*
Plugin Name: veeeb's veeebeditor For Wordpress
Plugin URI: http://www.veeeb.com/blog/veeebeditor-wordpress-plugin/
Description: This plugin extends the default Wordpress editor with <a href="http://www.veeeb.com/">veeeb editor</a>. veeeb analyzes your text and allows you to search for media by clicking and and add them via drag and drop to your article.

Version: 2.2.1
Author: Christoph Diefenthal, Jan Strohhecker
Author URI: http://www.veeeb.com
*/
require_once('veeebs_veeebeditor_class.php');
require_once('veeeb_xmlrpc.php');

//add_action('admin_head', array(&$veeebs_veeebeditor, 'add_admin_head'));

add_action('edit_form_advanced', array(&$veeebs_veeebeditor, 'load_veeebeditor'));
add_action('edit_page_form', array(&$veeebs_veeebeditor, 'load_veeebeditor'));
add_action('simple_edit_form', array(&$veeebs_veeebeditor, 'load_veeebeditor'));

add_filter('xmlrpc_methods', 'xml_add_method');

register_activation_hook(basename(dirname(__FILE__)).'/' . basename(__FILE__), array(&$veeebs_veeebeditor, 'activate'));
register_deactivation_hook(basename(dirname(__FILE__)).'/' . basename(__FILE__), array(&$veeebs_veeebeditor, 'deactivate'));
?>