<?php

    /*
    Plugin Name: Lists Impay
    Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
    Description: A brief description of the Plugin.
    Version: 1.0
    Author: Aleksandr Abramov
    Author URI: http://URI_Of_The_Plugin_Author
    License: A "Slug" license name e.g. GPL2
    */

	require __DIR__."/functions.php";
	require __DIR__."/ImpayListsDb.php";
	require __DIR__."/lists/ImpayLists.php";
	require __DIR__."/lists/ImpayListsSanctionsList.php";

	add_filter( 'block_categories', 'my_plugin_block_categories', 10, 2 );

	add_action('enqueue_block_editor_assets', 'impay_lists_block_assets');

	add_filter( 'the_content', 'impay_lists_get_content');

	if (defined('DOING_AJAX')){
		add_action('wp_ajax_impay_lists', 'impay_lists_ajax');
		add_action('wp_ajax_nopriv_impay_lists', 'impay_lists_ajax');
	}

