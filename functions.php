<?php

	/**
	 * Функция для создания категории добавляемых блоков Гутенберга в админке
	 * @param $categories lists-impay/sanctions-list
	 * @param $post
	 * @return array
	 */
	function my_plugin_block_categories( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'impay-lists',
					'title' => __( 'IMPAY LISTS', 'impay-lists' ),
					'icon'  => 'wordpress',
				),
			)
		);
	}

	/**
	 * Подключение собственных блоков Гутенберга
	 */
	function impay_lists_block_assets(){
		wp_enqueue_script(
			'impay-list-block-assets',
			plugin_dir_url(__FILE__) . '/js/block-assets.js',
			array('wp-blocks','wp-editor'),
			true
		);

	}

	/**
	 * Добавление списков в контент
	 * @param $content
	 * @return string
	 */
	function impay_lists_get_content($content){

		if (is_admin() OR $_SERVER['REQUEST_METHOD'] == 'POST') return $content;
		$lists = require __DIR__."\configs\lists.conf.php";

		global $post;

		foreach ( $lists as $key => $val ) {
			if (!preg_match("!\<\!\-\- wp:lists-impay/$key \-\-\>(.*?)\<\!\-\- /wp:lists-impay/$key \-\-\>!si",
				$post->post_content , $matches)) continue;
			include __DIR__."/lists/$val.php";
			$list = new $val();
			$string = impay_lists_get_include_contents($key, $list);
			impay_lists_set_scripts($key);
			$content = str_replace($matches[1], $string, $post->post_content);
			break;
		}

		return $content;
	}

	/**
	 * Служебная
	 * преобразование подключаемого файла в строке
	 * @param string $filename
	 * @param ImpayLists $list
	 * @return false|string
	 */
	function impay_lists_get_include_contents($filename, $list) {
		$filename = __DIR__."/templates/$filename.php";
		if (is_file($filename)) {
			ob_start();
			include __DIR__."/templates/impay_list_general_block.php";
			return ob_get_clean();
		}
		return false;
	}

	/**
	 * Служебная
	 * подключение скриптов и стилей
	 */
	function impay_lists_set_scripts($list_name){
		wp_enqueue_script(
			'impay-list-script', // название файла в системе
			plugins_url('/js/impay-list-script.js', __FILE__),
			array('jquery'),
			true,
			false
		);
		wp_enqueue_style(
			'impay-list-style',
			plugins_url('/css/impay-list-style.css', __FILE__)
		);
		wp_localize_script(
			'impay-list-script',
			"impayListsData",
			[
				'url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('impay-list-nonce'),
				'list_name' => $list_name,
                'loader' => plugins_url('/img/loading.gif', __FILE__),
			]
		);
	}

	/**
	 * Обработка AJAX
	 */
	function impay_lists_ajax(){
		if( ! wp_verify_nonce( $_POST['nonce'], 'impay-list-nonce' ) ) wp_die('');
		$lists = require __DIR__."\configs\lists.conf.php";

		if (empty($lists[$_POST['list_name']]))  wp_die('');

		$listClassName = $lists[$_POST['list_name']];

		require __DIR__."/lists/$listClassName.php";
		$list = new $listClassName();

		$filename = __DIR__."/templates/{$_POST['list_name']}.php";
		if (is_file($filename)) include $filename;

		wp_die('');
	}
