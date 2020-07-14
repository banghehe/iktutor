<?php
/**
* Plugin Name: III Notepad
* Plugin URI: http://3i.com.vn
* Description: Notepad plugin.
* Version: 1.0.0
* Author: Nguyen Hieu Trung
* Author URI: http://3i.com.vn
* Text Domain: iii-notepad
*/
define('III_NOTEPAD_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('III_NOTEPAD_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));

if (!function_exists('iii_notepad_custom_page_template')) {
	function iii_notepad_custom_page_template($page_template) {
		if (is_home()) {
			$page_template = III_NOTEPAD_PLUGIN_DIR_PATH . '/notepad.php';
		}

		return $page_template;
	}

	//add_filter('template_include', 'iii_notepad_custom_page_template');
}

//add_action('iii_notepad_enqueue_scripts_header', 'wp_print_scripts', 5);
//add_action('iii_notepad_enqueue_scripts_header', 'wp_print_styles', 5);
//add_action('iii_notepad_enqueue_scripts_header', 'wp_enqueue_scripts', 5);
//add_action('iii_notepad_enqueue_scripts_header', 'wp_print_head_scripts', 5);

add_action('iii_notepad_enqueue_scripts_footer', 'wp_print_footer_scripts', 5);

if (!function_exists('iii_notepad_enqueue_style')) {
	function iii_notepad_enqueue_style() {
		//style
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_style('iii-bootstrap', III_NOTEPAD_PLUGIN_DIR_URL . 'assets/css/bootstrap.min.css', array());
		wp_enqueue_style('iii-customscrollbar', III_NOTEPAD_PLUGIN_DIR_URL . 'assets/css/customscrollbar.min.css', array());
		wp_enqueue_style('iii-fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array());
		wp_enqueue_style('iii-style1', III_NOTEPAD_PLUGIN_DIR_URL . 'assets/css/styles1.css', array());
		wp_enqueue_style('iii-minicolor', III_NOTEPAD_PLUGIN_DIR_URL . 'js/jquery.minicolors.css', array());
		wp_enqueue_style('iii-selectBoxIt', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.8.0/jquery.selectBoxIt.css', array());

		wp_enqueue_style('iii-mediaelement', III_NOTEPAD_PLUGIN_DIR_URL . 'assets/css/mediaelement.css', array());
		wp_enqueue_style('iii-wp-mediaelement', III_NOTEPAD_PLUGIN_DIR_URL . 'assets/css/wp-mediaelement.css', array());

		wp_enqueue_style('iii-editor', III_NOTEPAD_PLUGIN_DIR_URL . 'assets/css/editor.css', array());
	}

	add_action('iii_notepad_enqueue_scripts_header', 'iii_notepad_enqueue_style');
}

if (!function_exists('iii_notepad_enqueue_script_header')) {
	function iii_notepad_enqueue_script_header() {
		//script
		wp_enqueue_script('iii-jquery', III_NOTEPAD_PLUGIN_DIR_URL . 'js/jquery-1.11.1.js', array());
		wp_enqueue_script('iii-bootstrap', III_NOTEPAD_PLUGIN_DIR_URL . 'js/bootstrap.min.js', array());
		wp_enqueue_script('iii-jquery-ui', III_NOTEPAD_PLUGIN_DIR_URL . 'js/jquery-ui.js', array());
		wp_enqueue_script('iii-touch-punch', III_NOTEPAD_PLUGIN_DIR_URL . 'js/touch-punch.min.js', array());
		wp_enqueue_script('iii-minicolors', III_NOTEPAD_PLUGIN_DIR_URL . 'js/jquery.minicolors.js', array());
		wp_enqueue_script('iii-bootbox', III_NOTEPAD_PLUGIN_DIR_URL . 'js/bootbox.min.js', array());
		wp_enqueue_script('iii-customscrollbar', III_NOTEPAD_PLUGIN_DIR_URL . 'js/customscrollbar.min.js', array());
		wp_enqueue_script('iii-countdown', III_NOTEPAD_PLUGIN_DIR_URL . 'js/jquery.countdown.js', array());

		wp_enqueue_script('amy-fancyselect', III_NOTEPAD_PLUGIN_DIR_URL . 'js/amyui-fancy-select.js', array());

		wp_enqueue_script('iii-mediaelement', III_NOTEPAD_PLUGIN_DIR_URL . 'js/mediaelement.js', array());
		wp_enqueue_script('iii-mediaelement-migrate', III_NOTEPAD_PLUGIN_DIR_URL . 'js/mediaelement-migrate.js', array());

		wp_enqueue_script('iii-selectBoxIt', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.selectboxit/3.8.0/jquery.selectBoxIt.min.js', array());

		wp_enqueue_script('iii-editor', III_NOTEPAD_PLUGIN_DIR_URL . 'js/editor.js', array());

		//if IE9
		wp_enqueue_script('iii-selectBoxIt', 'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js', array());

		//Websync
		wp_enqueue_script('iii-websync-fm', III_NOTEPAD_PLUGIN_DIR_URL . 'icelink/Scripts/fm.js', array());
		wp_enqueue_script('iii-websync-fm-websync', III_NOTEPAD_PLUGIN_DIR_URL . 'icelink/Scripts/fm.websync.js', array());
		wp_enqueue_script('iii-websync-fm-subscribers', III_NOTEPAD_PLUGIN_DIR_URL . 'icelink/Scripts/fm.websync.subscribers.js', array());
		wp_enqueue_script('iii-websync-fm-chat', III_NOTEPAD_PLUGIN_DIR_URL . 'icelink/Scripts/fm.websync.chat.js', array());

		//Icelink
		wp_enqueue_script('iii-icelink-fm', III_NOTEPAD_PLUGIN_DIR_URL . 'icelink/Scripts/fm.icelink.js', array());
		wp_enqueue_script('iii-icelink-fm-webrtc', III_NOTEPAD_PLUGIN_DIR_URL . 'icelink/Scripts/fm.icelink.webrtc.js', array());
		wp_enqueue_script('iii-icelink-fm-websync', III_NOTEPAD_PLUGIN_DIR_URL . 'icelink/Scripts/fm.icelink.websync.js', array());
		wp_enqueue_script('iii-icelink-app', III_NOTEPAD_PLUGIN_DIR_URL . 'icelink/app.js', array());
		wp_enqueue_script('iii-icelink-localMedia', III_NOTEPAD_PLUGIN_DIR_URL . 'icelink/localMedia.js', array());
		wp_enqueue_script('iii-icelink-signalling', III_NOTEPAD_PLUGIN_DIR_URL . 'icelink/signalling.js', array());

		wp_enqueue_script('iii-socket', 'https://notepad.iktutor.com:3000/socket.io/socket.io.js', array());
		wp_enqueue_script('iii-script3', III_NOTEPAD_PLUGIN_DIR_URL . 'assets/js/script3.js', array());
		wp_enqueue_script('iii-script2', III_NOTEPAD_PLUGIN_DIR_URL . 'assets/js/script2.js', array());

		wp_localize_script('iii-script2', 'iii_script', array(
			'site_url'				=> site_url('/'),
			'plugin_url'			=> III_NOTEPAD_PLUGIN_DIR_URL,
			'ajax_url'				=> admin_url('admin-ajax.php'),
			'buy_time_fail'			=> esc_html__('You dont have enough point to buy time', 'iii-notepad'),
			'buy_time_done'			=> esc_html__('You buy time done', 'iii-notepad'),
			'empty_video_url'		=> esc_html__('Please enter video url', 'iii-notepad'),
			'empty_layer'			=> esc_html__('Please chosen layer', 'iii-notepad'),
			'question_title'		=> esc_html__('Question', 'iii-notepad'),
			'answer_title'			=> esc_html__('Answer', 'iii-notepad'),
			'multi_answer_title'	=> esc_html__('Multiple Choice  Answer', 'iii-notepad'),
			'choice_text'			=> esc_html__('Choice', 'iii-notepad'),
			'ws_title'				=> esc_html__('Worksheet Title:', 'iii-notepad'),
			'ic_btn_video'			=> esc_html__('Insert', 'iii-notepad'),
			'ic_btn_video_button'	=> esc_html__('Check', 'iii-notepad'),
			'ic_btn_text'			=> esc_html__('Insert', 'iii-notepad'),
			'save_question'			=> esc_html__('Save', 'iii-notepad'),
			'add_other_question'	=> esc_html__('Add Another Question', 'iii-notepad'),
			'ic_btn_image'			=> esc_html__('Insert', 'iii-notepad'),
			'ws_notice_clear'		=> esc_html__('Do you want to clear texts and selections from the screen?', 'iii-notepad'),
			'ws_notice_delete'		=> esc_html__('Do you want to permanently delete current worksheet?', 'iii-notepad'),
			'ws_notice_question'	=> esc_html__('Do you want to delete a question page?', 'iii-notepad'),
			'ws_notice_insert_video'	=> esc_html__('Youtube link is invalid', 'iii-notepad'),
		));
	}

	add_action('iii_notepad_enqueue_scripts_header', 'iii_notepad_enqueue_script_header');
}

if (!function_exists('iii_notepad_enqueue_script_footer')) {
	function iii_notepad_enqueue_script_footer() {

	}

	add_action('iii_notepad_enqueue_scripts_footer', 'iii_notepad_enqueue_script_footer');
}

if (!function_exists('iii_notepad_purchase_time_by_point')) {
	function iii_notepad_purchase_time_by_point() {
		$student_id 	= $_POST['student_id'];
		$teacher_id		= $_POST['teacher_id'];
		$sid			= $_POST['sid'];

		$user_point		= get_user_meta($student_id, 'user_points', true);
		$note			= esc_html__('Purchase Notepad', 'iii-notepad');
		$required_point = 15;
		$time_increase	= 30;

		if ($user_point < $required_point) {
			echo json_encode('0');
			exit;
		} else {
			update_user_meta($student_id, 'user_points', $user_point - $required_point);

			global $wpdb;
			$wpdb->insert("{$wpdb->prefix}dict_user_point_transactions", array(
				'user_id'						=> $student_id,
				'point_transaction_type_id'		=> '3',
				'grading_worksheet_txn_id'		=> '0',
				'purchasing_worksheet_txn_id'	=> '0',
				'amount'						=> '15',
				'transaction_date'				=> current_time('mysql'),
				'note'							=> $note
			));

			$wpdb->query("UPDATE {$wpdb->prefix}dict_tutoring_plan SET total_time = (total_time +  " . $time_increase . ") WHERE id_user = '" . $student_id . "' AND tutor_id = '" . $teacher_id . "' AND id = '" . $sid . "'");

			echo json_encode('1');
			exit;
		}
	}

	add_action('wp_ajax_iii_notepad_purchase_time', 'iii_notepad_purchase_time_by_point');
	add_action('wp_ajax_nopriv_iii_notepad_purchase_time', 'iii_notepad_purchase_time_by_point');
}

if (!function_exists('iii_notepad_user_login')) {
	function iii_notepad_user_login() {
		$user1_emal		= $_POST['user1'];
		$user2_email	= $_POST['user2'];

		if ($user1_emal == '' || $user2_email == '') {
			$msg = esc_html__('Please enter email', 'iii-notepad');
			echo json_encode($msg);
			exit;
		}

		$user1 = get_user_by('email', $user1_emal);
		$user2 = get_user_by('email', $user2_email);

		if (!$user1) {
			$msg = esc_html__('Email 1 is wrong', 'iii-notepad');
			echo json_encode($msg);
			exit;
		}

		if (!$user2) {
			$msg = esc_html__('Email 2 is wrong', 'iii-notepad');
			echo json_encode($msg);
			exit;
		}

		$user1_id 	= $user1->ID;
		$user2_id	= $user2->ID;

		$result = array(
			'user1_id'	=> $user1_id,
			'user2_id'	=> $user2_id
		);

		echo json_encode($result);
		exit;
	}

	add_action('wp_ajax_iii_notepad_user_login', 'iii_notepad_user_login');
	add_action('wp_ajax_nopriv_iii_notepad_user_login', 'iii_notepad_user_login');
}

if (!function_exists('iii_notepad_worksheet_save_question')) {
	function iii_notepad_worksheet_save_question() {
		$wsid 		= $_POST['wsid'];
		$ws_title 	= $_POST['ws_title'];
		$qid		= $_POST['qid'];

		unset($_POST['wsid']);
		unset($_POST['ws_title']);
		unset($_POST['qid']);
		unset($_POST['action']);

		global $wpdb;

		if ($wsid != '') {
			$query = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}dict_sheets WHERE id = '" . $wsid . "'");

			$question = $query->questions;
			$question = json_decode($question);

			$v_name = 'qid' . $qid;

			if (is_array($question->$v_name)) {
				$question->$v_name = $_POST;
			} else {
				$question->$v_name = $_POST;
			}

			$wpdb->update("{$wpdb->prefix}dict_sheets", array('questions' => json_encode($question), 'sheet_name' => $ws_title), array('id' => $wsid));

			$result = array(
				'sheet_id'	=> $wsid,
				'code'		=> 2
			);

			echo json_encode($result);
			exit;
		} else {
			$q['qid' . $qid] = $_POST;

			$wpdb->insert("{$wpdb->prefix}dict_sheets", array(
				'assignment_id'		=> '4',
				'homework_type_id'	=> '3',
				'category_id'		=> '1',
				'trivia_exclusive'	=> '0',
				'ws_default'		=> '0',
				'grade_id'			=> '1',
				'sheet_name'		=> $ws_title,
				'grading_price'		=> '0',
				'dictionary_id'		=> '1',
				'questions'			=> json_encode($q),
				'passages'			=> '',
				'description'		=> '',
				'created_by'		=> '7',
				'private'			=> '0',
				'created_on'		=> date('Y-m-d', time()),
				'answer_time_limit'	=> '0',
				'show_answer_after'	=> '0',
				'lang'				=> 'en',
			));

			$sheet_id = $wpdb->insert_id;

			$wpdb->insert("{$wpdb->prefix}dict_my_library_sheet", array(
				'library_id'	=> '498',
				'sheet_id'		=> $sheet_id,
				'category_id'	=> '1',
				'created_on'	=> current_time('mysql'),
			));

			$result = array(
				'sheet_id'	=> $sheet_id,
				'code'		=> 1
			);

			echo json_encode($result);
			exit;
		}
		exit;
	}

	add_action('wp_ajax_iii_notepad_worksheet_save_question', 'iii_notepad_worksheet_save_question');
	add_action('wp_ajax_nopriv_iii_notepad_worksheet_save_question', 'iii_notepad_worksheet_save_question');
}


if (!function_exists('iii_notepad_worksheet_save_worksheet')) {
	function iii_notepad_worksheet_save_worksheet() {
		$wsid 		= $_POST['wsid'];
		$ws_title 	= $_POST['ws_title'];
		$question	= $_POST['question'];

		global $wpdb;

		if ($wsid != '') {
			$wpdb->update("{$wpdb->prefix}dict_sheets", array('questions' => json_encode($question), 'sheet_name' => $ws_title), array('id' => $wsid));

			$result = array(
				'sheet_id'	=> $wsid,
				'code'		=> 2
			);

			echo json_encode($result);
			exit;
		} else {
			$wpdb->insert("{$wpdb->prefix}dict_sheets", array(
				'assignment_id'		=> '4',
				'homework_type_id'	=> '3',
				'category_id'		=> '1',
				'trivia_exclusive'	=> '0',
				'ws_default'		=> '0',
				'grade_id'			=> '1',
				'sheet_name'		=> $ws_title,
				'grading_price'		=> '0',
				'dictionary_id'		=> '1',
				'questions'			=> json_encode($question),
				'passages'			=> '',
				'description'		=> '',
				'created_by'		=> '7',
				'private'			=> '0',
				'created_on'		=> date('Y-m-d', time()),
				'answer_time_limit'	=> '0',
				'show_answer_after'	=> '0',
				'lang'				=> 'en',
			));

			$sheet_id = $wpdb->insert_id;

			$wpdb->insert("{$wpdb->prefix}dict_my_library_sheet", array(
				'library_id'	=> '498',
				'sheet_id'		=> $sheet_id,
				'category_id'	=> '1',
				'created_on'	=> current_time('mysql'),
			));

			$result = array(
				'sheet_id'	=> $sheet_id,
				'code'		=> 1
			);

			echo json_encode($result);
			exit;
		}
		exit;
	}

	add_action('wp_ajax_iii_notepad_worksheet_save_worksheet', 'iii_notepad_worksheet_save_worksheet');
	add_action('wp_ajax_nopriv_iii_notepad_worksheet_save_worksheet', 'iii_notepad_worksheet_save_worksheet');
}