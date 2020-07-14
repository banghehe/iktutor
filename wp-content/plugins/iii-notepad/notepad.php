<?php
if (!isset($_GET['user_id']) || !isset($_GET['teacher_id']) || !isset($_GET['sid'])) {
	//return;
}

$current_user_id_wp = get_current_user_id();
$student_id 		= $_GET['user_id'];
$teacher_id 		= $_GET['teacher_id'];
$sid 				= $_GET['sid'];
$type_id			= $_GET['type'];

if ($current_user_id_wp != $student_id && $current_user_id_wp != $teacher_id) {
	//return;
}

$uid1 	= $_GET['uid1'];
$uid2	= $_GET['uid2'];
$roomid	= ($uid1 && $uid2) ? 'r' . $uid1 . '_' . $uid2 . 'm' : 'public';


if ($student_id && $teacher_id) {
	$roomid	= 'r' . $student_id . '_' . $teacher_id . 'm';
}

$roomid = $roomid . 'iii';
$roomid	= substr($roomid, 0, 6);

global $wpdb;

$student_plan 		= $wpdb->get_row("SELECT * FROM {$wpdb->prefix}dict_tutoring_plan WHERE id_user = '" . $student_id . "' AND tutor_id = '" . $teacher_id . "' AND id = '" . $sid . "'");
$private_subject 	= is_object($student_plan) ? $student_plan->private_subject : esc_html__('Bussiness English Conversation', 'iii-notepad');

//time
$time				= is_object($student_plan) ? $student_plan->time : '';
$time				= str_replace(':am', ' AM', $time);
$time				= str_replace(':pm', ' PM', $time);
$time_arr			= explode('~', $time);
$time_ranger		= 1800;

if (!empty($time_arr) && $time_arr[0] != '') {
	$time_ranger = strtotime($time_arr[1]) - strtotime($time_arr[0]);
}

//point
$point_required 	= 15;

?>
<html>
<head>
	<meta name="google-site-verification" content="WC9FfWNfVRyJn8pWPXTHM4uCe_p-U13-iz0dV8A6puk"/>
	<meta charset="utf-8"/>
	<meta property="og:site_name"
		  content="Real time white board for drawing on line, share photo and capture image from webcam"/>
	<meta property="og:type" content="article"/>
	<meta property="og:url" content="https://vrobbi-nodedrawing.herokuapp.com"/>
	<meta property="fb:admins" content="100004633505284"/>
	<meta property="og:title" content="Real time whiteboard collaborative with chat in html5 and websocket"/>
	<meta property="fb:app_id" content="508864332486444"/>
	<meta name="keywords"
		  content="lavagna collaborativa, disegnare on line, applicazione real time, multiuser whiteboard, realtime application, drawing on line, drawing game, html5, web 2.0, software, internet, image capture, webcam"/>
	<meta name="description"
		  content="lavagna multiutente condivisa in tempo reale, multiuser whiteboard real time application, draw on line and share your draw with all on the net"/>

	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Notepad and Chating</title>

	<?php do_action('iii_notepad_enqueue_scripts_header'); ?>
</head>

<body class="none-active notepad-on">
<div id="online-learning">
	<div class="container-fluid">
		<!-- Menu-top Begin -->
		<div id="menu-top">
			<div class="row">
				<div class="logo fl">
					<a href="#"><img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/49_ik_Logo.png"
									 alt="Iklearn">
					</a>
				</div>
				<div class="fl">
					<span><?php echo esc_attr($private_subject); ?></span>
				</div>
				<?php
					$ws_mode 	= ($type_id == '2') ? 'on' : '';
					$n_mode		= ($type_id == '2') ? '' : 'on';
				?>
				<div class="actions-r">
					<div class="notepad-mode r-mode <?php echo esc_attr($n_mode); ?>" data-type="notepad">
						<p>
							<img class="mode-on" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_33_Notepad_Mode_ON.png" alt="notepadMode"/>
							<img class="mode-off" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_32_Notepad_Mode_OFF.png" alt="notepadMode"/>
						</p>
					</div>
					<div class="worksheet-mode r-mode <?php echo esc_attr($ws_mode); ?>" data-type="worksheet">
						<?php if (($current_user_id_wp == $teacher_id && $teacher_id != '') || !$teacher_id) : ?>
						<p>
							<img class="mode-on" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_35_Create_Mode_ON.png" alt="notepadMode"/>
							<img class="mode-off" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_34_Create_Mode_OFF.png" alt="notepadMode"/>
						</p>
						<?php endif; ?>
					</div>
					<div class="closeNav fr" id="close-session">
						<p id="hideTiming" class="">
							<img class="img-fluid fr"
								 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/58_Close_for_SideMenu.png"
								 alt="closeTime">
						</p>
					</div>
				</div>
				<div class="hidden close-class style-popup-close close-session">
					<div class="col-md-6 text-popup-close">
						<?php echo esc_html__('End current session?', 'iii-notepad'); ?>
					</div>
					<div class="col-md-6 no-padding">
						<button type="button" class="red-btn end-session-now">
							<?php echo esc_html__('End Now', 'iii-notepad'); ?>
						</button>
						<button type="button" class="cancel-btn close-popup-close">
							<?php echo esc_html__('Cancel', 'iii-notepad'); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Menu-top End -->

		<!-- Menu-main Begin -->
		<div id="menu-main">
			<div class="row">
				<div class="no-padding border-r">
					<?php if (($current_user_id_wp == $teacher_id && $teacher_id != '') || !$teacher_id) : ?>
					<div class="row taskbar-worksheet hidden r-taskbar">
						<div class="block-control">
<!--							<p class="img-height" id="btn-ws-save">-->
<!--								<img src="--><?php //echo III_NOTEPAD_PLUGIN_DIR_URL; ?><!--assets/Images/worksheet/icon_04_SAVE.png"-->
<!--									 alt="Save">-->
<!--							</p>-->
							<p class="img-height active" id="btn-ws-edit">
								<img class="white" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Mode_01_Edit_white.png"
									 alt="Save">
								<img class="dark" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Mode_01_Edit_dark.png"
									 alt="Save">
							</p>
							<p class="img-height" id="btn-ws-preview">
								<img class="white" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Mode_02_Preview_white.png"
									 alt="Save">
								<img class="dark" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Mode_02_Preview_dark.png"
									 alt="Save">
							</p>
						</div>
						<div class="block-control">
							<p class="img-height" id="btn-ws-add-single">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_05_Create_Single_Worksheet.png"
									 alt="AddSingleQuestion">
							</p>
							<p class="img-height" id="btn-ws-add-multi">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_06_Create_Multiple_Worksheet.png"
									 alt="AddMultiQuestions">
							</p>
						</div>
						<div class="block-control">
							<p class="img-height" id="btn-ws-open-list">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_Open_Worksheet_List.png"
									 alt="Undo">
							</p>
							<p class="img-height" id="btn-ws-undo">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/01_Redo.png"
									 alt="Undo">
							</p>
							<p class="img-height" id="btn-ws-redo">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/02_Undo.png"
									 alt="Redo">
							</p>
							<p id="btn-ws-add-type-box">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/16_Text_Box.png"
									 alt="Upload">
							</p>
							<p id="btn-ws-add-image">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/18_Upload_Image.png"
									 alt="Upload">
							</p>
							<p id="btn-ws-add-video">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/20_Upload_Video_Player.png"
									 alt="ScreenShots">
							</p>
						</div>
						<div class="block-control block-right">
							<?php if (is_user_logged_in()) : ?>
								<?php $current_user = wp_get_current_user(); ?>
								<div class="ws-user-info">
									<span>
										<?php echo $current_user->display_name; ?>
									</span>
									<a href="<?php echo esc_url(wp_logout_url()); ?>">
										<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_Login_ON.png" />
									</a>
								</div>
							<?php else : ?>
								<div class="ws-login">
									<span>
										<?php echo esc_html__('Login', 'iii-notepad'); ?>
									</span>
									<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_Login_OFF.png"
										 alt="ScreenShots">
								</div>
								<div class="ws-popup-login">
									<div class="ws-popup-login-inner">
										<h3 class="wspl-title">
											<?php echo esc_html__('Login', 'iii-notepad'); ?>
										</h3>
										<div class="wspl-form">
											<?php
												$form = wp_login_form(array(
													'label_username'	=> false,
													'label_password'	=> false,
													'remember'			=> false,
													'echo'				=> false,
												));

												$form = str_replace('name="log"', 'name="log" placeholder="' . esc_html__('Username (Email address):') . '"', $form);
												$form = str_replace('name="pwd"', 'name="pwd" placeholder="' . esc_html__('Password:') . '"', $form);

												echo $form;
											?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>
					<div class="row taskbar-notepad r-taskbar">
						<div class="block-control fl">
							<p class="img-height" id="btn-undo">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/01_Redo.png"
									 alt="Undo">
							</p>
							<p class="img-height" id="btn-redo">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/02_Undo.png"
									 alt="Redo">
							</p>
							<p id="change-size-pencil" class="tool-btn" data-layer="1">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/03_Pen.png"
									 alt="Pencil">
							</p>
							<div class="hidden pencil-class style-popup-pencil tool-submenu">
								<ul id="pencils-body">
									<li class="icon-layer close-popup-pencil">
										<span style="line-height: 0;" class="icon-layer close-popup-pencil">Pen</span>
									</li>
									<li class="icon-layer btn-pencil hr1 active" data-pencil="1">
										<!-- <hr style="height: 1px;"> -->
										<img style="width: 5px;height: 5px"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/32_Size_1.png"
											 alt="">
									</li>
									<li class="icon-layer btn-pencil hr2" data-pencil="2">
										<!-- <hr style="height: 2px;"> -->
										<img style="width: 8px;height: 8px"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/31_Size_2.png"
											 alt="">
									</li>
									<li class="icon-layer btn-pencil hr3" data-pencil="3">
										<!-- <hr style="height: 3px;"> -->
										<img style="width: 11px;height: 11px"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/30_Size_3.png"
											 alt="">
									</li>
									<li class="icon-layer btn-pencil hr4" data-pencil="4">
										<!-- <hr style="height: 4px;"> -->
										<img style="width: 14px;height: 14px"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/29_Size_4.png"
											 alt="">
									</li>
									<li class="icon-layer btn-pencil hr5" data-pencil="5">
										<!-- <hr style="height: 5px;"> -->
										<img style="width: 18px;height: 18px"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/28_Size_5.png"
											 alt="">
									</li>
								</ul>
							</div>
							<!-- message -->
							<div class="hidden  hello close-class style-popup-close">
								<div class="col-md-9 text-popup-close">
									<?php echo esc_html__('No layer is selected', 'iii-notepad'); ?>
								</div>
								<div class="col-md-3 no-padding">
									<button type="button" class="red-btn scel-btn close-popup-close">
										<?php echo esc_html__('Cancel', 'iii-notepad'); ?>
									</button>
								</div>
							</div>
							<!-- end -->
							<p class="tool-btn" id="change-eraser">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/04_Eraser.png"
									 alt="Eraser">
							</p>
							<div class="hidden eraser-class style-popup-eraser tool-submenu">
								<ul id="erasers-body">
									<li class="icon-layer close-popup-eraser">
										<span>
											<?php echo esc_html__('Eraser', 'iii-notepad'); ?>
										</span>
									</li>
									<li class="icon-layer btn-eraser active" data-eraser="30">
										<img style="width: 5px;height: 5px;"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/32_Size_1.png">
									</li>
									<li class="icon-layer btn-eraser" data-eraser="50">
										<img style="width: 8px;height: 8px;"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/32_Size_1.png">
									</li>
									<li class="icon-layer btn-eraser" data-eraser="70">
										<img style="width: 11px;height: 11px;"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/32_Size_1.png">
									</li>
									<li class="icon-layer btn-eraser" data-eraser="90">
										<img style="width: 14px;height: 14px;"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/32_Size_1.png">
									</li>
									<li class="icon-layer btn-eraser" data-eraser="100">
										<img style="width: 18px;height: 18px;"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/32_Size_1.png">
									</li>
									<li class="icon-layer btn-eraser-clear border-bottom">
										<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/04_Eraser-ALL.png">
									</li>

								</ul>
							</div>
							<p class="tool-btn" id="change-color">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/06_Color_Black.png"
									 alt="Colors">
							</p>
							<div class="hidden color-class style-popup-color tool-submenu">
								<ul id="colors-body">
									<li class="icon-layer close-popup-color">
										<span>
											<?php echo esc_html__('Color', 'iii-notepad'); ?>
										</span>
									</li>
									<li class="icon-layer btn-color" data-color="#ffffff" data-image-url="05_Color_White.png"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/icon_Color_white.png">
									</li>
									<li class="icon-layer btn-color active" data-color="#000000" data-image-url="06_Color_Black.png"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/icon_Color_black.png">
									</li>
									<li class="icon-layer btn-color" data-color="#0000FF" data-image-url="07_Color_Blue.png"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/icon_Color_blue.png">
									</li>
									<li class="icon-layer btn-color" data-color="#FF0000" data-image-url="08_Color_Red.png"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/icon_Color_red.png">
									</li>
									<li class="icon-layer btn-color" data-color="#008000" data-image-url="09_Color_Green.png"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/icon_Color_green.png">
									</li>
									<li class="icon-layer btn-color" data-color="#C500AF" data-image-url="10_Color_RedPurple.png"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/icon_Color_light_purple.png">
									</li>
									<li class="icon-layer btn-color" data-color="#FF8D15" data-image-url="11_Color_Orange.png"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/icon_Color_orange.png">
									</li>
									<li class="icon-layer btn-color" data-color="#8E3AFF" data-image-url="12_Color_Purple.png"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/icon_Color_purple.png">
									</li>
								</ul>
							</div>
							<!-- <div class="block-layer fl" > -->
							<p class="block-layer tool-btn" id="add-layer">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/14_Layers.png"
									 alt="Layers">
							</p>
							<div class="hidden layer-class style-popup-layer tool-submenu">
								<ul id="layers-body">
									<li class="close-popup-layer">
										<p id="layer-span">
											<?php echo esc_html__('Layers', 'iii-notepad'); ?>
										</p>
									</li>
									<li class="icon-layer btn-add-layer">
										<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/33_Layer_Add.png">
									</li>
									<li class="icon-layer btn-delete-layer border-bottom">
										<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/34_Layer_Delete.png">
									</li>
									<li class="icon-layer icon-selector active">
										<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/35_Layer1.png">
									</li>
								</ul>
							</div>
							<!-- </div> -->
							<!-- <div class="block-grid fl"> -->
							<p class="block-grid tool-btn" id="icon-grid">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/15_Grids.png"
									 alt="Grid">
							</p>
							<div class="hidden grid-class style-popup-grid tool-submenu">
								<ul id="grids-body">
									<li class="icon-layer close-popup-grid">
										<span>
											<?php echo esc_html__('Grid', 'iii-notepad'); ?>
										</span>
									</li>
									<li class="icon-layer btn-color-grid active" data-color="#FFFFFF"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/42_Grid_White.png">
									</li>
									<li class="icon-layer btn-color-grid" data-color="#DDDDDD"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/43_Grid_Gray.png">
									</li>
									<li class="icon-layer btn-color-grid" data-color="#fffdbf"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/44_Grid_Yellow.png">
									</li>
									<li class="icon-layer btn-color-grid border-bottom" data-color="#d1fffe"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/45_Grid_Blue.png">
									</li>
									<li class="icon-layer btn-grid" data-grid="1"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/46_Grid_Type1.png">
									</li>
									<li class="icon-layer btn-grid" data-grid="2"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/47_Grid_Type2.png">
									</li>
								</ul>
							</div>
							<!-- </div> -->
						</div>
						<div class="block-image fl">
							<p id="add-type-box" class="">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/16_Text_Box.png"
									 alt="Upload">
								<!-- <input id="file-input" class="form-control inputfile input-sm" type="file"> -->
							</p>
							<p>
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/17_Upload_Worksheet.png"
									 alt="Upload">
								<!-- <input id="file-input" class="form-control inputfile input-sm" type="file"> -->
							</p>
							<p>
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/18_Upload_Image.png"
									 alt="Upload">
								<input id="file-input" class="form-control inputfile input-sm" type="file">
							</p>
							<p id="icon-screenshot">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/19_ScreenShot.png"
									 alt="ScreenShots">
							</p>
							<div class="hidden screenshot-class style-popup-screenshot">
								<p class="name-popup">
									<?php echo esc_html__('Capture Images', 'iii-notepad'); ?>
								</p>
								<ul>
									<li class="item-screenshot" style=" padding-right: 20px">
										<input type="checkbox" class="checkbox-style" id="screenshot-check" value=""
											   name="screenshot">
									</li>
									<li class="item-screenshot" style=" width: 100px;">
										<form method="get">
											<select class="select-box-it form-control" id="select-screenshot">
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="4">4</option>
												<option value="8">8</option>
												<option value="20">20</option>
												<option value="60">60</option>
												<option value="120">120</option>
												<option value="300">300</option>
												<option value="600">600</option>
											</select><span class="style-sec">Sec.</span>
										</form>
									</li>
								</ul>
								<div class="clearfix"></div>
							</div>
							<p id="icon-video">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/20_Upload_Video_Player.png"
									 alt="ScreenShots">
							</p>
							<div class="video-popup-class style-popup-video hidden">
								<p class="name-popup">
									<?php echo esc_html__('Enter Video Url', 'iii-notepad'); ?>
								</p>
								<div class="content-popup">
									<input type="text" class="video-url" name="video-url" />
									<button class="video-btn">
										<?php echo esc_html__('Add Video', 'iii-notepad'); ?>
									</button>
								</div>
							</div>
						</div>

						<div class="block-right">
							<div class="block-status-tutor">
								<span class="text-on">
									<?php echo esc_html__('Tutor On', 'iii-notepad'); ?>
								</span>
								<span class="text-off">
									<?php echo esc_html__('Tutor Off', 'iii-notepad'); ?>
								</span>
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/Icon_TutorON.png" class="img-tutor-on"/>
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/Icon_TutorOFF.png" class="img-tutor-off"/>
							</div>
							<!-- <div class="block-time fl"> -->
							<p class="block-time hidden">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/icons/icon_Timer.png" alt="Timer">
							</p>
							<span class="time-class fr">
								<?php echo sprintf('%02d:%02d:%02d', ($time_ranger/3600),($time_ranger/60%60), $time_ranger%60); ?>
							</span>
							<div class="expire-class style-popup-extime popup-purcharse hidden">
								<div class="purchase-notice">
									<span>
										<?php echo esc_html__('Continuing requires ', 'iii-notepad') . $point_required . esc_html__(' points', 'iii-notepad'); ?>
									</span>
									<span>
										<?php echo esc_html__('You will extend session for another 30 minutes', 'iii-notepad'); ?>
									</span>
								</div>
								<div class="purchase-actions">
									<div class="purchase-btn purchase-accept">
										<?php echo esc_html__('Accept', 'iii-notepad'); ?>
									</div>
									<div class="purchase-btn purchase-cancel">
										<?php echo esc_html__('Cancel', 'iii-notepad'); ?>
									</div>
								</div>
							</div>
						</div>
						<!-- </div> -->
						<!-- </div> -->
						<!-- </div> -->
					</div>
				</div>
			</div>
		</div>
		<!-- Menu-main End -->

		<!-- wrapper_contend Begin -->
		<?php
			$ws_content = ($type_id == '2') ? 'active' : 'hidden';
			$n_content	= ($type_id == '2') ? 'hidden' : 'active';
		?>
		<div class="row wrapper_contend" id="wrapper">
			<?php if (($current_user_id_wp == $teacher_id && $teacher_id != '') || !$teacher_id) : ?>
				<div class="col-md-8 main-content main-worksheet <?php echo esc_attr($ws_content); ?>">
				<div id="w-panel">
					<div class="ws-notice hidden">
						<div class="ws-notice-inner">
							<div class="wsn-left">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Icon_Warning.png" class="" />
								<p class="wsn-text"></p>
								<input type="hidden" class="wsn-type" />
							</div>
							<div class="wsn-right">
								<div class="wsn-btn">
									<span class="wsn-btn-yes wsn-btn-only-yes">
										<?php echo esc_html__('Yes', 'iii-notepad'); ?>
									</span>
									<span class="wsn-btn-yes wsn-btn-ok">
										<?php echo esc_html__('Ok', 'iii-notepad'); ?>
									</span>
									<span class="wsn-btn-no">
										<?php echo esc_html__('No', 'iii-notepad'); ?>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="ws-actions-top">
						<div class="ws-mode">
							<input type="hidden" class="ws-mode-input">
							<div class="btn-ws-mode practice-mode active" data-type="practice">
								<img class="on" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_07_Practice_ON.png">
								<img class="off" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_08_Practice_OFF.png">
							</div>
							<div class="btn-ws-mode test-mode" data-type="test">
								<img class="on" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_09_Test_ON.png">
								<img class="off" src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_10_Test_OFF.png">
							</div>
						</div>
						<div class="ws-action">
							<div class="ws-clear">
								<span>
									<?php echo esc_html__('Clear', 'iii-notepad'); ?>
								</span>
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_12_Clear_Page.png">
							</div>
							<div class="ws-delete">
								<span>
									<?php echo esc_html__('Delete', 'iii-notepad'); ?>
								</span>
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/icon_11_Delete_Worksheet.png">
							</div>
						</div>
					</div>
					<div class="ws-title-subject">
						<div class="ws-title">
							<input type="text" name="ws-title" class="ws-title-input" placeholder="<?php echo esc_html__('Worksheet Title:', 'iii-notepad'); ?>"/>
							<input type="hidden" class="wsid" name="wsid" />
							<span class="ws-title-clear">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Title_01_Clear_Title.png" />
							</span>
						</div>
						<div class="ws-subject">
							<select class="iii-select">
								<option value="1">
									<?php echo esc_html__('Select Subject', 'iii-notepad'); ?>
								</option>
								<option value="2">
									<?php echo esc_html__('English: Conversation for Foreign Students', 'iii-notepad'); ?>
								</option>
								<option value="3">
									<?php echo esc_html__('English: Grammar', 'iii-notepad'); ?>
								</option>
							</select>
						</div>
					</div>

					<div class="ws-questions-number">
						<div class="wsq-arrow wsq-arrow-left">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Question_03_Left_Arrow.png" />
							</div>
						<ul>
						</ul>
						<div class="wsq-actions">
							<div class="wsq-insert-single">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Pages_Single_Insert.png" />
							</div>
							<div class="wsq-insert-multi">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Pages_Multiple_Insert.png" />
							</div>
							<div class="wsq-delete-current">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Question_02_Delete.png" />
							</div>
							<div class="wsq-arrow wsq-arrow-right">
								<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/worksheet/Question_04_Right_Arrow.png" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<div class="col-8 main-content main-notepad <?php echo esc_attr($n_content); ?>">
				<div id="cursors">
					<!-- The mouse pointers will be created here -->
				</div>
				<div id="panel" class="panel">

				</div>
				<div id="divrubber" title="drag to erase with checkbox signed" alt="drag to erase with checkbox signed">
					<div id="controlrubber" class="css-img-erase"></div>
				</div>
				<div id="videoChat" class="hidden" style="display: block;">
					<!--<img id="closeVideo" src="assets/icons/icon_CLOSE.png" alt="Close">-->
					<div id="closeVideo"></div>
					<div id="loading"></div>
					<div id="video" style="width: 100%; height: 100%"></div>
					<!--<div class="people-list">
						<div class="people-list-inner">
							<div class="teacher">
								<p>
									<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/people/teacher.png"/>
								</p>
							</div>
							<div class="student-list">
								<div class="student-item">
									<p>
										<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/people/student-1.png"/>
									</p>
								</div>
								<div class="student-item">
									<p>
										<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/people/student-2.png"/>
									</p>
								</div>
								<div class="student-item">
									<p>
										<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/people/student-3.png"/>
									</p>
								</div>
								<div class="student-item">
									<p>
										<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/people/student-4.png"/>
									</p>
								</div>
							</div>
						</div>
					</div>-->
				</div>
				<div id="yotubeVideo" class="hidden"></div>
			</div>
			<div class="col-4">
				<!-- opacitySideMenu Begin -->

				<div class="opacitySideMenu">
					<div class="opacitySideMenu-inner">
						<div class="opactiyPercentage">
							<p id="rangevalue"></p><span>%</span>
						</div>
						<div class="editBar">

							<input type="range" class="slider" name="bgopacity" id="bgopacity" value="100" min="0"
								   max="100" step="1">

						</div>
						<div class="closeSideMenu">
							<p>
								<img class="img-fluid fr hideSideMenu"
									 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets\Images\Icons\58_Close_for_SideMenu.png" alt="close">
							</p>
							<p>
								<img class="img-fluid fr showSideMenu hidden"
									 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets\Images\Icons\63_Open_for_SideMenu.png" alt="open">
							</p>
						</div>
					</div>

				</div>
				<!-- opacitySideMenu End -->
				<div id="videoAndMic" class="hidden">
					<div class="turnVideo hidden">
						<p class="On_Video hidden"><img
									src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/51_Video_Chat_ON.png"
									alt=""> <span><?php echo esc_html__('Video Is On', 'iii-notepad'); ?></span></p>
						<p class="Off_Video hidden"><img
									src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/50_Video_Chat_OFF.png"
									alt=""><span><?php echo esc_html__('Video Is Off', 'iii-notepad'); ?></span></p>
					</div>
					<div class="turnMic hidden">
						<p class="On_Mic hidden"><img
									src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/51_Video_Chat_ON.png"
									alt=""> <span><?php echo esc_html__('Mic Is On', 'iii-notepad'); ?></span></p>
						<p class="Off_Mic hidden"><img
									src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/50_Video_Chat_OFF.png"
									alt=""> <span><?php echo esc_html__('Mic Is Off', 'iii-notepad'); ?></span></p>
					</div>
				</div>
				<!-- wrap-sidebar-left Begin -->
				<div class="wrap-sidebar-left">
					<!-- Sidebar Begin -->
					<div class="menu-tray show-both" style="display: block">
						<!-- Participants sidebar Begin -->
						<div class="attend-list style-scrollbar" style="display: block">
							<div class="row">
								<p class="tit-head"><?php echo esc_html__('Participants', 'iii-notepad'); ?> <span>(6)<span></p>
							</div>
							<div class="row list_participants">
								<?php
									$default_image	= III_NOTEPAD_PLUGIN_DIR_URL . 'assets\Images\Icons\62_Profile_User.png';

									$student_data 	= get_user_by('id', $student_id);
									$student_name	= $student_data->data->display_name;
									$student_avatar	= get_avatar_url($student_id);

									$teacher_data 	= get_user_by('id', $teacher_id);
									$teacher_name	= $teacher_data->data->display_name;
									$teacher_avatar	= get_avatar_url($teacher_id);
								?>
								<ul>
									<li class="item-list">
										<div class="avatar-attend">
											<img src="<?php echo esc_url($teacher_avatar); ?>" alt="Attendee List">
										</div>
										<p class="text-overfl">
											<?php echo esc_attr($teacher_name); ?>
										</p>
									</li>

									<li class="item-list">
										<div class="avatar-attend">
											<img src="<?php echo esc_url($student_avatar); ?>" alt="Attendee List">
										</div>
										<p class="text-overfl">
											<?php echo esc_attr($student_name); ?>
										</p>
									</li>
								</ul>
							</div>

							<div class="clearfix"></div>
						</div>
						<!-- Participants sidebar End -->

						<!-- Video_list sidebar Begin -->
						<div class="attend-video-list">
							<div class="row">
								<div class="col-md-12">
									<div class="participantLowerBottom">
										<img class="img-fluid"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/56_Status_TooFast.png"
											 alt="">
									</div>
									<div class="participantLowerBottom">
										<img class="img-fluid"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/56_Status_TooFast.png"
											 alt="">
									</div>
									<div class="participantLowerBottom">
										<img class="img-fluid"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/56_Status_TooFast.png"
											 alt="">
									</div>
									<div class="participantLowerBottom">
										<img class="img-fluid"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/56_Status_TooFast.png"
											 alt="">
									</div>
									<div class="participantLowerBottom">
										<img class="img-fluid"
											 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/56_Status_TooFast.png"
											 alt="">
									</div>
								</div>
							</div>
						</div>
						<!-- Video_list sidebar End -->

						<!-- Chat_box sidebar Begin -->
						<div class="chat_box" style="display: block">
							<div class="ui-resizable-handle ui-resizable-n"></div>
							<div id="chat" class="message-list">
								<ul id="testichat" class="inbox-message">
								</ul>
							</div>
							<div class="start-tutoring">
								<span>
									<?php echo esc_html__('Start Tutoring', 'iii-notepad'); ?>
								</span>
							</div>
							<div class="message-send">
								<div class="float-left message-input">
									<input type="text" id="scrivi" rows="1" name="message-input"
										   placeholder="<?php echo esc_html__('Type Your Message Here...', 'iii-notepad'); ?>"></input>
									<input type="hidden" id="emoji" name="emoji" value="understand"/>
								</div>

								<div class="button-send float-left">
									<div id="btn-send"><img
												src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets\Images\Icons\52_Send_Arrow_Icon.png"
												alt="Chat Button"></div>
									<div class="status-selector">
										<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/53_Status_Defualt.png"
											 alt="Emoji_Understand">
									</div>
								</div>
								<div class="status-selector-bar" style="display: none;">
									<ul>
										<li class="ic-fast" data-type="fast"><p>Too Fast</p><img
													src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets\Images\Icons\56_Status_TooFast.png"
													alt="Emoji_Too_Fast">
										</li>
										<li class="ic-confused" data-type="confused"><p>Confused</p><img
													src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets\Images\Icons\55_Status_Confused.png"
													alt="Emoji_Confused"></li>
										<li class="ic-understand" data-type="understand"><p>Good</p><img
													src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets\Images\Icons\54_Status_Good.png"
													alt="Emoji_Understand"></li>
									</ul>
								</div>
							</div>
						</div>
						<!-- Chat_box sidebar End -->
					</div>
				</div>
				<!-- wrap-sidebar-left End -->
			</div>
		</div>
		<!-- wrapper_contend End -->

		<div class="row bottom-menu">

			<div class="actionOnRight fr">
				<div class="block-chat">
					<p class="student_list active">
						<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/21_Participants.png"
							 alt="List">
					</p>
					<p class="pop-chat active">
						<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/23_Chat.png" alt="Chat">
					</p>
					<p class="video_list">
						<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/22_Video_Chat.png"
							 alt="Video">
					</p>

					<p id="catturacam" class="hidden">
						<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/icon_Tutor_Video.png"
							 alt="Studentst">
					</p>
				</div>
				<div class="stl-border">

				</div>
				<div class="block-video">
					<!--                     <p>
                                                <img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/24_Video_ON.png" alt="Video">
                                            </p> -->
					<p class="switch" id="toggleVideoMute">
						<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/25_Video_OFF.png"
							 alt="Video">
					</p>
				</div>
				<div class="block-voice">
					<!--                     <p>
                                                <img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/icon_VOICE.png" alt="Voice">
                                            </p> -->
					<p class="switch" id="toggleAudioMute">
						<img src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/27_Mike_OFF.png"
							 alt="Voice">
					</p>
				</div>
			</div>
		</div>
		<div class="popUpBtn">
			<p>
				<img class="fl img-fluid clickToHideBottom"
					 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/59_Bottom_Menu_Close.png"
					 alt="Hide">
			</p>
			<p>
				<img class="fl img-fluid clickToShowBottom"
					 src="<?php echo III_NOTEPAD_PLUGIN_DIR_URL; ?>assets/Images/Icons/60_Bottom_Menu_Open.png"
					 alt="Show">
			</p>
		</div>
	</div>
</div>
<script type="text/javascript">
	var iii_variable = {
		'roomid': '<?php echo esc_attr($roomid); ?>',
		'time_ranger': '<?php echo esc_attr($time_ranger); ?>',
		'user_id': '<?php echo esc_attr($student_id); ?>',
		'teacher_id': '<?php echo esc_attr($teacher_id); ?>',
		'sid': '<?php echo esc_attr($sid); ?>',
	};
</script>
<?php do_action('iii_notepad_enqueue_scripts_footer'); ?>
<div class="wrapper-bg"></div>
<div class="user-login-form hidden">
	<div class="userForm">
		<div class="userForm-inner">
			<form class="userLoginForm">
				<div class="user-1 form-section">
					<p>
						<?php echo esc_html__('Login 1', 'iii-notepad'); ?>
					</p>
					<label>
						<?php echo esc_html__('Username (email address', 'iii-notepad'); ?>
					</label>
					<input type="text" name="user1" class="user1"/>
				</div>

				<div class="user-2 form-section">
					<p>
						<?php echo esc_html__('Login 2', 'iii-notepad'); ?>
					</p>
					<label>
						<?php echo esc_html__('Username (email address', 'iii-notepad'); ?>
					</label>
					<input type="text" name="user2" class="user2"/>
				</div>
				<div class="form-section">
					<button type="button" class="userFormSubmit">
						<?php echo esc_html__('Login', 'iii-notepad'); ?>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>