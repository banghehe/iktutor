<?php 
$current_user = wp_get_current_user();
$is_user_logged_in = is_user_logged_in();
if($is_user_logged_in){
    $status_login = get_user_meta($current_user->ID, 'status_login', true);
    if($status_login == '0'){
        update_user_meta($current_user->ID, 'status_login', '1');
        wp_logout();
    };

}
if($is_user_logged_in){
   add_user_meta($current_user->ID,'status_login_2','1');
   update_user_meta($current_user->ID, 'status_login_2', '1');

};

if(isset($_GET['key']) && isset($_GET['login']) && !$is_user_logged_in) {
    $rp_login = esc_html( stripslashes($_GET['login']) );
    $rp_key   = esc_html( $_GET['key'] );
    $user = check_password_reset_key( $rp_key, $rp_login );
    $checkpass = 1;
}
else if(isset($_POST['rp_key']) && isset($_POST['rp_login']) && !$is_user_logged_in) {
    $rp_login = esc_html( stripslashes($_POST['rp_login']) );
    $rp_key   = esc_html( $_POST['rp_key'] );
    $user = check_password_reset_key( $rp_key, $rp_login );
    $checkpass = 1;
}
else {
    $user = $checkpass = 0;
}
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
    <?php wp_title(''); ?>
    </title>
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
    <meta name="msapplication-TileColor" content="#f01d4f">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
    <meta name="theme-color" content="#121212">
    <meta http-equiv="cache-control" content="max-age=0">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">
    <script src="<?php echo get_template_directory_uri(); ?>/library/js/jquery.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/library/js/detect-zoom.js"></script>
    <!-- <script src="<?php echo get_template_directory_uri(); ?>/library/js/bootstrap.js"></script> 
    <script src="<?php echo get_template_directory_uri(); ?>/library/js/iktutor.js"></script>-->

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/library/css/font-awesome.min.css">
    <?php wp_head(); ?>
</head>

<body <?php body_class( 'body-math'); ?> itemscope itemtype="http://schema.org/WebPage">
    <!--modal-->
    <div class="modal fade" id="signup-modal" class="signup-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="boxshadow">
                <div class="row">
                    <div class="container">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title signup-title">SIGN UP <span>(It is FREE to Create an Account)</span></h4>
                            </div>
                            <div class="modal-body" id="signup-input">
                                <form method="post" action="" name="registerform" class="input-stl" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-9 col-md-9 refreshclass">
                                            <div class="form-group">
                                                <label for="user_login">
                                                    <?php _e('Username (E-mail Address)', 'iii-dictionary') ?>
                                                </label>
                                                <input id="user_login_signup" class="form-control" name="user_login" type="text" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3">
                                            <div class="tooltip tooltip-manage-a-classroom col-xs-12 col-sm-12">

                                                <a href="#" id="check-availability" class="check-availability">
                                                    <img style="height: 15px;" src="<?php echo get_template_directory_uri(); ?>/library/images/Icon_Questions.png">
                                                    Find out availability
                                                    <span class="icon-loading"></span>

                                                </a>
                                                <div>
                                                    <button class="form-control border-ras btn-group btn-green btn-available sethidden" style="width: 64%; font-size: 15px;">Available</button>
                                                </div>
                                                <div>
                                                    <button class="form-control border-ras btn-group btn-orange btn-notavailable sethidden" style="width: 64%; font-size: 15px;">Not Available</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 refreshclass">
                                            <div class="form-group">
                                                <label for="user_password">
                                                    <?php _e('Create Password', 'iii-dictionary') ?>
                                                </label>
                                                <input id="user_password_signup" class="form-control border-ras" name="user_password" type="password" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 refreshclass">
                                            <div class="form-group">
                                                <label for="confirm_password">
                                                    <?php _e('Confirm Password', 'iii-dictionary') ?>
                                                </label>
                                                <input id="confirm_password" class="form-control border-ras" name="confirm_password" type="password" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 refreshclass">
                                            <div class="form-group">
                                                <label for="first_name">
                                                    <?php _e('First Name', 'iii-dictionary') ?>
                                                </label>
                                                <input id="first_name" class="form-control" name="first_name" type="text" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 refreshclass">
                                            <div class="form-group">
                                                <label for="last_name">
                                                    <?php _e('Last Name', 'iii-dictionary') ?>
                                                </label>
                                                <input id="last_name" class="form-control" name="last_name" type="text" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <?php _e('Date of Birth', 'iii-dictionary') ?> <small>(month/day/year)</small></label>
                                                <div class="row tiny-gutter">
                                                    <div class="col-xs-12 col-sm-4 col-md-4 border-ras selectbox-stl" id="month">
                                                        <select id="birth_m" class="select-box-it form-control" name="birth-m">
                                                            <?php 
                                                            for ($i = 1; $i <= 12; $i++) :
                                                                $pad_str = str_pad($i, 2, '0', STR_PAD_LEFT) ?>
                                                                <option value="<?php echo $pad_str ?>">
                                                                    <?php echo $pad_str ?>
                                                                </option>
                                                            <?php endfor ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-4 col-md-4 border-ras selectbox-stl" id="date">
                                                        <select id="birth_d" class="select-box-it form-control" name="birth-d">
                                                            <?php for ($i = 1; $i <= 31; $i++) : ?>
                                                                <?php $pad_str = str_pad($i, 2, '0', STR_PAD_LEFT) ?>
                                                                    <option value="<?php echo $pad_str ?>">
                                                                        <?php echo $pad_str ?>
                                                                    </option>
                                                                    <?php endfor ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-4 col-md-4 refreshclass">
                                                        <input id="birth_y" class="form-control" name="birth-y" type="text" value="" placeholder="Year" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-pic refreshclass" style="clear: both;">
                                            <label class="img-profile">Profile Picture (optional)</label>
                                            <div class="col-sm-1 col-md-1">
                                                <div class="form-group">

                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/Profile_Image.png" alt="Profile Picture">
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-md-5">
                                                <div class="form-group" style="margin-top: 21px;">

                                                    <input class="form-control input-file" type="file" id="input-avatar" value="" />
                                                    <div class="form-group">

                                                        <button class="btn-dark btn-group border-ras" type="button" name="upload" onclick="document.getElementById('input-avatar').click();">
                                                            <?php _e('Browse and Upload', 'iii-dictionary') ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 nopadding-l">
                                                <div class="form-group">
                                                    <input class="form-control input-path" id="profile-avatar" type="text">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 refreshclass">
                                            <label>
                                                <?php _e('Language', 'iii-dictionary') ?>
                                            </label>
                                            <div class="form__boolean" id="checkBoxSearch" style="margin-bottom: 10px;">
                                                <div class="col-md-2 col-xs-4 cb-type2 nopadding-l">
                                                    <label>
                                                        <input type="checkbox" class="checkbox-stl" value="en" name="cb-lang" /> English
                                                    </label>
                                                </div>
                                                <div class="col-md-2 col-xs-4 cb-type2 nopadding-l">
                                                    <label>
                                                        <input type="checkbox" class="checkbox-stl" value="ja" name="cb-lang" /> Japanese
                                                    </label>
                                                </div>
                                                <div class="col-md-2 col-xs-4 cb-type2 nopadding-l">
                                                    <label>
                                                        <input type="checkbox" class="checkbox-stl" value="ko" name="cb-lang" /> Korean
                                                    </label>
                                                </div>
                                                <div class="col-md-2 col-xs-4 cb-type2 nopadding-l">
                                                    <label>
                                                        <input type="checkbox" class="checkbox-stl" value="zh" name="cb-lang" /> Chinese
                                                    </label>
                                                </div>
                                                <div class="col-md-2 col-xs-4 cb-type2 nopadding-l">
                                                    <label>
                                                        <input type="checkbox" class="checkbox-stl" value="zh-tw" name="cb-lang" /> Traditional Chinese
                                                    </label>
                                                </div>
                                                <div class="col-md-2 col-xs-4 cb-type2 nopadding-l">
                                                    <label>
                                                        <input type="checkbox" class="checkbox-stl" value="vi" name="cb-lang" /> Vietnamese
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer row">
                                <div class="col-xs-12 col-sm-8 col-md-8 nopadding-l">
                                    <div class="form-group">
                                        <button class="btn-orange btn-group border-ras" id="create-acc" type="button" name="wp-submit">
                                            <?php _e('Create Account', 'iii-dictionary') ?>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 nopadding-r">
                                    <div class="form-group">
                                        <button class="btn-grey btn-group border-ras" data-dismiss="modal">
                                            <?php _e('Cancel', 'iii-dictionary') ?>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--modal login-->
    <div class="modal fade" id="login-modal" class="login-modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="row boxshadow">
                <div class="container">
                    <div class="modal-content">
                        <div class="login-modal-body" id="login-modal-body">
                            <div class="modal-header">
                                <h4 class="modal-title">LOGIN</h4>
                            </div>
                            <form action="<?php echo locale_home_url() ?>/?r=login" name="loginform" method="post">
                                <div class="modal-body" id="login-input" class="login-input">
                                    <div class="from-group input-stl">
                                        <div class="col-md-6 col-sm-6 col-xs-12 nopadding-l">
                                            <label for="login-user">User Name (Email Address)</label>
                                            <input type="text" name="log" id="login-user" class="form-control border-ras">
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 nopadding-r">
                                            <label for="login-pass">Password</label>
                                            <input type="password" name="pwd" id="login-pass" class="form-control border-ras">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer row">
                                    <div class="col-xs-12 col-sm-6 col-md-6 nopadding-l">
                                        <div class="form-group">
                                            <button class="btn-orange btn-group border-ras" id="login-btn" type="button" name="wp-submit">
                                                <?php _e('Login', 'iii-dictionary') ?>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-3 col-md-3 nopadding-r create-padding">
                                        <div class="form-group">
                                            <button class="btn-grey btn-group border-ras" type="button" id="create-acc-login">
                                                <?php _e('Create Account', 'iii-dictionary') ?>
                                            </button>

                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-3 col-md-3 nopadding-r">
                                        <div class="form-group">
                                            <button class="btn-grey btn-group border-ras" data-dismiss="modal">
                                                <?php _e('Cancel', 'iii-dictionary') ?>
                                            </button>

                                        </div>
                                    </div>
                                    <?php if(get_subdomain() != 'admin'){ ?>
                                    <div class="go-lostpass" id="go-lostpass"><span>Lost Password?</span></div>
                                    <?php } ?>
                                </div>
                                <input name="redirect_to" value="<?php echo locale_home_url() ?>" type="hidden">
                            </form>
                        </div>
                        <div class="getpass-modal-body hidden" id="getpass-modal-body">
                            <div class="modal-header">
                                <h4 class="modal-title">FORGOT PASSWORD</h4>
                            </div>
                            <div class="modal-body" class="login-input">
                                <div class="from-group input-stl">
                                    <div class="col-md-12 nopadding-r nopadding-l">
                                        <label for="email-getpass-input">Enter the Email Address You Registered With</label>
                                        <input type="text" name="email-getpass" id="email-getpass-input" class="form-control border-ras">
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-xs-12 col-sm-8 col-md-8 nopadding-l">
                                    <div class="form-group">
                                        <button class="btn-orange btn-group border-ras" id="getpass-btn" type="button" name="wp-submit">
                                            <?php _e('Request New Password', 'iii-dictionary') ?>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 nopadding-r">
                                    <div class="form-group">
                                        <button class="btn-grey btn-group border-ras cancel-modal" data-dismiss="modal">
                                            <?php _e('Cancel', 'iii-dictionary') ?>
                                        </button>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="resetpass-modal-body hidden" id="resetpass-modal-body">
                            <div class="modal-header">
                                <h4 class="modal-title">NEW PASSWORD</h4>
                            </div>
                            <div class="modal-body" class="login-input">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group input-stl">
                                            <label for="pass1"><?php _e('New password', 'iii-dictionary') ?></label>
                                            <input type="password" name="pass1" id="pass1" class="form-control border-ras" size="20" value="">
                                        </div>
                                    </div>
                                
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group input-stl">
                                            <label for="pass2"><?php _e('Confirm new password', 'iii-dictionary') ?></label>
                                            <input type="password" name="pass2" id="pass2" class="form-control border-ras" size="20" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="rp_key" value="<?php echo $rp_key ?>">
                                <input type="hidden" name="rp_login" value="<?php echo $rp_login ?>">
                                <div class="col-xs-12 col-sm-8 col-md-8 nopadding-l">
                                    <div class="form-group">
                                        <button class="btn-orange btn-group border-ras" id="newpass-btn" type="button" name="wp-submit">
                                            <?php _e('Reset Password', 'iii-dictionary') ?>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 nopadding-r">
                                    <div class="form-group">
                                        <button class="btn-grey btn-group border-ras cancel-modal" data-dismiss="modal">
                                            <?php _e('Cancel', 'iii-dictionary') ?>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--end modal login-->
    <!--end modal-->
    <div class="modal modal-red-brown" id="error-messages-modal" tabindex="-1" role="dialog" aria-hidden="true" style="padding-right: 17px; display: none;z-index: 3000;">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top: 42px;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-11" id="error-edit-class">

                        </div>
                        <img class="icon-close-classes-created" id="icon-close"  aria-hidden="true" style="top: 25%" src="<?php echo get_template_directory_uri(); ?>/library/images/close_white.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-red-brown" id="top-popup-message" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;z-index: 3000;">
        <div class="modal-dialog">
            <div class="modal-contents" style="margin-top: 0;">
                <div class="modal-body">
                    <div id="popup-message">

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="wrapper-body">

        <header class="header header-math-new" itemscope itemtype="http://schema.org/WPHeader">
            <div class="top-nav" id="myTopnav">
                <div class="container">
                    <div class="wrapper-nav">
                        <div class="col-md-3 col-sm-3 col-xs-3 logo-stl">
                            <h1><a href="<?php echo locale_home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/library/images/ikTutor_Logo.png"></a></h1></div>
                        <?php 
                        if (!$is_user_logged_in){ 
                        ?>
                        <div class="col-md-offset-5 col-md-2 col-xs-6 sign-up-cls">
                            <a id="signup"><span>SIGN UP</span><img src="<?php echo get_template_directory_uri(); ?>/library/images/Icon_Create.png"></a>
                        </div>
                        <div class="col-md-2 col-sm-3 col-xs-3 login-nav">
                            <a id="login-icon">Login<img src="<?php echo get_template_directory_uri(); ?>/library/images/icon_login.png"></a>
                        </div>
                        <?php 
                        }else{ 
                            $display_name = get_user_meta($current_user->ID, 'display_name', true);
                            $first_name = get_user_meta($current_user->ID, 'first_name', true);
                            $last_name = get_user_meta($current_user->ID, 'last_name', true);
                            $row_user = get_user_by('id', $current_user->ID);
                            if (!empty($display_name) && $display_name != '')
                                $user_name = $display_name;
                            else if((!empty($first_name) && $first_name != '') || (!empty($last_name) && $last_name != ''))
                                $user_name = $first_name.' '.$last_name;
                            else
                                $user_name = $row_user->display_name;
                        ?>
                        <div class="col-md-7 col-sm-6 col-xs-6 sign-up-cls">
                            <a class="display-name view-my-account">[<?php echo $user_name; ?>]</a>
                        </div>
                        <div class="col-md-2 col-sm-3 col-xs-3 login-nav">
                            <a class="logout-link" href="<?php echo wp_logout_url(locale_home_url()) ?>" title="<?php _e('Logout', 'iii-dictionary') ?>"><?php _e('Logout', 'iii-dictionary') ?><span class="login-icon"></span></a>
                        </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                (function($) {
                    $(function() {
                        var user = <?php echo $checkpass ?>;
                        var home_url = "<?php echo locale_home_url() ?>";
                        $(".sethidden").hide();

                        function isValidEmail(emailText) {
                            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                            return pattern.test(emailText);
                        };
                        var availability_checking = false;
                        var redirect = '';

                        if(user){
                            $("#login-modal-body").addClass("hidden");
                            $("#resetpass-modal-body").removeClass("hidden");
                            $("#getpass-modal-body").addClass("hidden");

                            if($("#signup-modal").hasClass("in")){
                                $("#signup-modal").modal("hide");
                            }
                            if($("#login-modal").hasClass("in")==false){
                                $("#login-modal").modal('show');
                            }else{
                                $("#login-modal").modal('hide');
                            }
                        }

                        $("#signup").click(function(){
                            if($("#login-modal").hasClass("in")){
                                $("#login-modal").modal("hide");
                            }
                            if($("#signup-modal").hasClass("in")==false){
                            $("#signup-modal").modal('show');}
                            else {$("#signup-modal").modal('hide');}
                        });
                        
                        $("#login-icon").click(function(){
                            if($("#signup-modal").hasClass("in")){
                                $("#signup-modal").modal("hide");
                            }
                            if($("#login-modal").hasClass("in")==false){
                            $("#login-modal").modal('show');}
                            else {$("#login-modal").modal('hide');}

                            $("#login-modal-body").removeClass("hidden");
                            $("#getpass-modal-body").addClass("hidden");
                            $("#resetpass-modal-body").addClass("hidden");
                        });
                        
                        $("#create-acc-login").click(function(){
                            if($("#login-modal").hasClass("in")){
                                $("#login-modal").modal("hide");
                            }
                            if($("#signup-modal").hasClass("in")==false){
                            $("#signup-modal").modal('show');}
                            else {$("#signup-modal").modal('hide');}
                        });
                        
                        $("#go-lostpass").click(function(){
                            $("#login-modal-body").addClass("hidden");
                            $("#resetpass-modal-body").addClass("hidden");
                            $("#getpass-modal-body").removeClass("hidden");
                        });

                        $("#check-availability").click(function (e) {
                            e.preventDefault();
                            if (availability_checking) {
                                return;
                            }
                            var tthis = $(this);
                            var user_login = $("#user_login_signup").val().trim();
                            if (user_login != "") {
                                tthis.popover("destroy");
                                availability_checking = true;
                                tthis.find(".icon-loading").fadeIn();
                                $.getJSON(home_url + "/?r=ajax/availability/user", {user_login: user_login}, function (data) {
                                    if (isValidEmail(user_login)) {

                                        if (data [0] == 0) {
                                            var p_c = '<span class="popover-alert"><?php _e('Not Available', 'iii-dictionary') ?></span>';
                                        } else {
                                            var p_c = '<span class="popover-alert"><?php _e('Available', 'iii-dictionary') ?></span>';
                                        }
                                    } else {
                                        var p_c = '<span class="popover-alert"><?php _e('Invalid', 'iii-dictionary') ?></span>';
                                    }
                                    tthis.find(".icon-loading").fadeOut();
                                    tthis.popover({
                                        placement: "bottom",
                                        content: p_c,
                                        trigger: "click",
                                        html: true
                                    }).popover("show");
                                    setTimeout(function () {
                                        tthis.popover("hide")
                                    }, 3000);
                                    availability_checking = false;
                                });
                            }
                        });
                        $('#create-acc').click(function() {
                            var user_name = $('#user_login_signup').val();
                            var user_password = $('#user_password_signup').val();
                            var confirm_password = $('#confirm_password').val();
                            var first_name = $('#first_name').val();
                            var last_name = $('#last_name').val();
                            var birth_m = $('#birth_m').val();
                            var birth_d = $('#birth_d').val();
                            var birth_y = $('#birth_y').val();
                            var profile_avatar = $('#profile-avatar').val();
                            var cb_lang = [];
                            $('input[name="cb-lang"]:checked').each(function() {
                                cb_lang.push(this.value);
                            });
                            $.post(home_url + "/?r=ajax/create_account", {
                                user_name: user_name,
                                user_password: user_password,
                                confirm_password: confirm_password,
                                first_name: first_name,
                                last_name: last_name,
                                birth_m: birth_m,
                                birth_d: birth_d,
                                birth_y: birth_y,
                                cb_lang: cb_lang,
                                profile_avatar: profile_avatar
                            }, function(data) {
                                if ($.trim(data) == '1') {
                                    if (redirect == '')
                                        window.location.reload();
                                    else
                                        document.location.href = redirect;
                                } else {
                                    $('#popup-message').html('<p class="text-used">' + data + '</p><button id="got-it" type="button" class="btn-orange form-control nopadding-r border-btn">OK</button>');
                                    $('#top-popup-message').css("display", "block");
                                }

                            });
                        });
                        $("#input-avatar").change(function() {
                            var file_data = $('#input-avatar').prop('files')[0];
                            var type = file_data.type;
                            var match = ["image/gif", "image/png", "image/jpg", ];
                            var form_data = new FormData();
                            form_data.append('file', file_data);
                            $.ajax({
                                url: home_url + "/?r=ajax/upload_avatar",
                                dataType: 'text',
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: form_data,
                                type: 'post',
                                success: function(res) {
                                    if ($.trim(res) != '0') {
                                        $("#profile-avatar").val($.trim(res));
                                    } else {
                                        $('#popup-message').html('<p class="text-used">Error: There was an error uploading your file</p><button id="got-it" type="button" class="btn-orange form-control nopadding-r border-btn">OK</button>');
                                        $('#top-popup-message').css("display", "block");
                                    }
                                }
                            });
                        });
                        
                        $('#login-btn').click(function () {
                            var username = $('#login-user').val();
                            var password = $('#login-pass').val();
                            $.post(home_url + "/?r=ajax/login_account", {
                                user_name: username,
                                user_password: password
                             }, function (data) {
                                if ($.trim(data) == '1') {
                                   document.location.href = home_url;
                                } else if ($.trim(data) == '0') {
                                    $('#login-modal').css("display", "none");
                                } else {
                                    $('#popup-message').html('<p class="text-used">' + data + '</p><button id="got-it" type="button" class="btn-orange form-control nopadding-r border-btn" style="height: 40px !important ">OK</button><span class="sign-up sign-pass">Register now?</span><br><span class="forgot-pass sign-pass" >Forgot password?</span>');
                                $('#top-popup-message').css("display", "block");
                                }
                            });
                        });

                        $('#getpass-btn').click(function () {
                            var email = $('#email-getpass-input').val();
                            $.post(home_url + "/?r=ajax/forgotpassword", {
                                email: email
                             }, function (data) {
                                $('#popup-message').html('<p class="text-used">' + data + '</p><button id="got-it" type="button" class="btn-orange form-control nopadding-r border-btn">OK</button>');
                                    $('#top-popup-message').css("display", "block");
                            });
                        });

                        $('.logout-link').click(function (e) {
                            localStorage.clear();
                            var status_login_2 = '0';
                            $.post(home_url + "/?r=ajax/status_login_2", {
                                status_login_2: status_login_2,
                                type: "update"
                            });

                        });

                        $('#newpass-btn').click(function () {
                            var pass1 = $('#pass1').val();
                            var pass2 = $('#pass2').val();
                            var rp_key = '<?php if(isset($rp_key)) echo $rp_key ?>';
                            var rp_login = '<?php if(isset($rp_login)) echo $rp_login ?>';
                            $.post(home_url + "/?r=ajax/newpassword", {
                                pass1: pass1,
                                pass2:pass2,
                                rp_key:rp_key,
                                rp_login:rp_login
                             }, function (data) {
                                if ($.trim(data) == '1') {
                                    $('#popup-message').html('<p class="text-used">Your password has been reset.</p><button id="got-newpass" type="button" class="btn-orange form-control nopadding-r border-btn">OK</button>');
                                    $('#top-popup-message').css("display", "block");
                                } else if($.trim(data) == 'expired_key') {
                                    $('#popup-message').html('<p class="text-used">Sorry, that key has expired. Please try again.</p><button id="got-newpass" type="button" class="btn-orange form-control nopadding-r border-btn">OK</button>');
                                    $('#top-popup-message').css("display", "block");
                                } else if($.trim(data) == 'invalidkey') {
                                    $('#popup-message').html('<p class="text-used">Sorry, that key does not appear to be valid.</p><button id="got-newpass" type="button" class="btn-orange form-control nopadding-r border-btn">OK</button>');
                                    $('#top-popup-message').css("display", "block");
                                }else{
                                    $('#popup-message').html('<p class="text-used">The passwords do not match.</p><button id="got-it" type="button" class="btn-orange form-control nopadding-r border-btn">OK</button>');
                                    $('#top-popup-message').css("display", "block");
                                }
                            });
                        });
                        
                        $("#got-it").live("click", function () {
                            $('#popup-message').html();
                            $('#top-popup-message').css("display", "none");
                        });

                        $("#got-newpass").live("click", function () {
                            document.location.href = home_url;
                        });
                        function getStatusLogin(){
                        $.post(home_url + "/?r=ajax/get_status_login",{}, function (data) {
                                data = JSON.parse(data);
                                if ($.trim(data) == '0') {
                                   location.reload();};
                            });
                       
                    }setInterval(getStatusLogin, 1000);
                    });
                $('body').on('click', '.sign-up', function () {
                   if($("#login-modal").hasClass("in")){
                                $("#login-modal").modal("hide");
                            }
                            if($("#signup-modal").hasClass("in")==false){
                            $("#signup-modal").modal('show');}
                            else {$("#signup-modal").modal('hide');}
                    $("#top-popup-message").css("display","none");

                });
                
                
                })(jQuery);
                
            $('body').on('click','.forgot-pass', function () {
                        $("#login-modal-body").addClass("hidden");
                            $("#resetpass-modal-body").addClass("hidden");
                            $("#getpass-modal-body").removeClass("hidden");
                    
                        $("#top-popup-message").css("display","none");
                    });

            </script>
        </header>