<?php
$link_list_group = get_option_name_link();
//some function at home
if (!empty($_POST['data-join'])) {
    MWDB::lang_join_group($_POST);
}
$link_current = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (strpos($link_current, '/en/') !== false) {
    $enlanguage = 1;
} elseif (strpos($link_current, '/ja/') !== false) {
    $enlanguage = 2;
} elseif (strpos($link_current, '/ko/') !== false) {
    $enlanguage = 3;
} elseif (strpos($link_current, '/vi/') !== false) {
    $enlanguage = 4;
} elseif (strpos($link_current, '/zh/') !== false) {
    $enlanguage = 5;
} elseif (strpos($link_current, '/zh-tw/') !== false) {
    $enlanguage = 5;
}
$current_user = wp_get_current_user();
$is_user_logged_in = is_user_logged_in();
if($is_user_logged_in)
    $link = '?r=ajax/logged/'.$current_user->ID.'/'.session_id();
else
    $link = '';
?>
<?php get_header(); ?>	
<?php
$URL = $_SERVER['REQUEST_URI'];
$segment = explode('/', $URL);
if ($segment[2] == 'mathteacher') {
    $pagehome = 1;
    include 'math_teacher.php';
} elseif ($segment[2] == 'englishteacher') {
    $pagehome = 2;
    include 'english_teacher.php';
} else {
    $pagehome = 0;
    ?>
    <main class="home home-pc-tablet" id="home" >
        <div class="row">
            <div class="container">
                <div class="wrapper-content">
                    <div class="col-md-6 col-sm-6 col-xs-6 body-tab boxshadow-tab" onclick="location.href = 'https://iktutor.com/ikteach/en/<?php echo $link ?>'">
                        <div class="class-to-ikteacher">
                            <div class="wrapp-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/library/images/MainPic_Teacher.jpg" name="ikteacher" class="image-tab">
                                <div class="icon-next-page"><a href="https://iktutor.com/ikteach/en/"><img src="<?php echo get_template_directory_uri(); ?>/library/images/Icon_Arrow.png" name="ikteacher"></a></div>
                                <button class="btn-blue btn-group border-ras" style="width: 419px;">TEACHERS & TUTORS</button>
                            </div>
                            <div class="intro-page">
                                <h3>Online Tutoring & Classroom Management Software</h3>
                                <ul class="intro-item">
                                    <li><img src="<?php echo get_template_directory_uri(); ?>/library/images/Icon_Check_Gray.png" name="ikteacher">Tutor Students Online (opportunity to earn money)</li>
                                    <li><img src="<?php echo get_template_directory_uri(); ?>/library/images/Icon_Check_Gray.png" name="ikteacher">Use Classroom Management System</li>
                                    <li><img src="<?php echo get_template_directory_uri(); ?>/library/images/Icon_Check_Gray.png" name="ikteacher">Use Math and English Library to Teach Students</li>
                                </ul>
                                <div class="form-group">
                                    <button class="form-control btn-radius btn-blue-text btn-home">let's start!</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6 body-tab" onclick="location.href = 'http://iklearn.local/en/<?php echo $link ?>'; location.reload();">
                        <div class="class-to-ikstudy">

                            <div class="wrapp-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/library/images/MainPic_Student.jpg" name="ikteacher" class="image-tab">
                                <div class="icon-next-page"><a href="https://iktutor.com/iklearn/en/"><img src="<?php echo get_template_directory_uri(); ?>/library/images/Icon_Arrow.png" name="ikteacher"></a></div>
                               <button class="btn-orange btn-group border-ras " style="width: 419px;">STUDENTS</button>
                            </div>
                            <div class="intro-page">
                                <h3>Select a Tutor or Join an Online Class</h3>
                                <ul class="intro-item">
                                    <li><img src="<?php echo get_template_directory_uri(); ?>/library/images/Icon_Check_Gray.png" name="ikteacher">Select a Tutor for One on One Help</li>
                                    <li><img src="<?php echo get_template_directory_uri(); ?>/library/images/Icon_Check_Gray.png" name="ikteacher">Join Various Online Classes Taught by Teachers</li>
                                    <li><img src="<?php echo get_template_directory_uri(); ?>/library/images/Icon_Check_Gray.png" name="ikteacher">Complete Math and English Learning</li>
                                </ul>
                                <div class="form-group">
                                    <button class="form-control btn-radius btn-orange-text btn-home">let's start!</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </main>
    </div>



    <script type="text/javascript">
        jQuery(function ($) {
            $(".btn-pref .btn").click(function () {
                $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
                // $(".tab").addClass("active"); // instead of this do the below 
                $(this).removeClass("btn-default").addClass("btn-primary");
            });
            $("#manage-btn-mobile").click(function () {
                document.getElementById("home").style.background = "url(http://ikteacher.moe/wp-content/themes/ik-learn/library/images/phonemain21.png)";
                document.getElementsByClassName("navbar-tab-mobile-content")[0].style["background"] = "#ffba5a";
                document.getElementById("manage-btn-mobile").style["boxShadow"] = "-5px 12px 10px #ECAD50";
                document.getElementById("tutoring-btn-mobile").style["boxShadow"] = "5px 12px 10px #ECAD50";
            });
            $("#tutoring-btn-mobile").click(function () {
                document.getElementById("home").style.background = "url(http://ikteacher.moe/wp-content/themes/ik-learn/library/images/phonemain22.png)";
                document.getElementsByClassName("navbar-tab-mobile-content")[0].style["background"] = "#04c2cc";
                document.getElementById("manage-btn-mobile").style["boxShadow"] = "-5px 12px 10px #05B3BE";
                document.getElementById("tutoring-btn-mobile").style["boxShadow"] = "5px 12px 10px #05B3BE";
            });
        });
    </script>

    <?php
}
?>  		

<div id="new-to-our-product-dialog" class="modal fade modal-white" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" aria-hidden="true" class="close2"></a>
            </div>
            <div class="modal-body visible-md visible-lg">
                <ul>
                    <li><a class="view-sub-modal" href="#" data-img="<?php echo get_info_tab_cloud_url('Popup_info_3.jpg') ?>"><?php _e('How to help teachers in the classroom', 'iii-dictionary') ?></a></li>
                    <li><a class="view-sub-modal" href="#" data-img="<?php echo get_info_tab_cloud_url('Popup_info_4.jpg') ?>"><?php _e('If you want to improve your Englsih writing...', 'iii-dictionary') ?></a></li>
                    <li><a class="view-sub-modal" href="#" data-img="<?php echo get_info_tab_cloud_url('Popup_info_5.jpg') ?>"><?php _e('Complete review of Grammar and Vocab', 'iii-dictionary') ?></a></li>
                    <li><a class="view-sub-modal" href="#" data-img="<?php echo get_info_tab_cloud_url('Popup_info_6.jpg') ?>"><?php _e('SAT test preparation', 'iii-dictionary') ?></a></li>
                </ul>
            </div>
            <a href="#" data-dismiss="modal" aria-hidden="true" class="btn green dismiss-modal"><?php _e('Got it', 'iii-dictionary') ?></a>
        </div>
    </div>
</div>

<div id="why-merriam-dialog" class="modal fade modal-white" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" aria-hidden="true" class="close2"></a>
            </div>
        </div>
    </div>
</div>

<div id="about-teacher-dialog" class="modal fade modal-white" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" aria-hidden="true" class="close2"></a>
            </div>
        </div>
    </div>
</div>

<div id="about-student-dialog" class="modal fade modal-white" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" aria-hidden="true" class="close2"></a>
            </div>
        </div>
    </div>
</div>

<div id="made-teacher-dialog" class="modal fade modal-white" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" aria-hidden="true" class="close"></a>
            </div>
            <a href="#" data-dismiss="modal" aria-hidden="true" class="btn orange dismiss-modal"><span class="icon-switch"></span> <?php _e('Go back', 'iii-dictionary') ?></a>
        </div>
    </div>
</div>

<div id="popup-info-dialog" class="modal fade modal-white modal-no-padding" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <a href="#" data-dismiss="modal" aria-hidden="true" class="close-transp"></a>
                <img id="popup-info-img" src="#" alt="">
            </div>
        </div>
    </div>
</div>
<script>
    var pagehome =<?php echo $pagehome ?>;
    var LANGUAGE =<?php echo $enlanguage ?>;
    switch (pagehome) {
        case 1 :
        {
            switch (LANGUAGE) {
                case 2 :
                {
                    if ((window.matchMedia('screen and (min-width: 1200px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Ja_math.jpg)');
                        jQuery('#home').css('height', '1785');
                    } else if ((window.matchMedia('screen and (min-width: 768px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Ja_TABLET_math.jpg)');
                        jQuery('#home').css('height', '1557');
                        jQuery('#p7-link-start').css({
                            'width': '17%',
                            'bottom': '17.8%',
                        });
                        jQuery('#p8-link-start').css({
                            'width': '17%',
                            'bottom': '6.7%',
                            'left': '16.8%',
                        });
                    } else if ((window.matchMedia('screen and (min-width: 320px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Ja_PHONE_math.jpg)');
                        jQuery('#home').css('height', '2561');
                        jQuery('#p7-link-start').css({
                            'bottom': '32.8%',
                        });
                    }
                    break;
                }
                case 3:
                {
                    if ((window.matchMedia('screen and (min-width: 1200px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Kr_math.jpg)');
                        jQuery('#home').css('height', '1785');
                        jQuery('#p7-link-start').css('bottom', '29.5%');
                        jQuery('#p8-link-start').css('bottom', '3.96%');
                    } else if ((window.matchMedia('screen and (min-width: 768px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Kr_TABLET_math.jpg)');
                        jQuery('#home').css('height', '1557');
                    } else if ((window.matchMedia('screen and (min-width: 320px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Kr_PHONE_math.jpg)');
                        jQuery('#home').css('height', '2561');
                        jQuery('#p7-link-start').css({
                            'width': '55.7%',
                            'bottom': '32.7%',
                            'left': '5.8%',
                        });
                        jQuery('#p8-link-start').css({
                            'width': '55.7%',
                            'bottom': '2.2%',
                            'left': '5.8%',
                        });
                    }
                    break;
                }
                default :
                {
                    if ((window.matchMedia('screen and (min-width: 1200px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/mathtool.jpg)');
                        jQuery('#home').css('height', '1785');
//                        jQuery('#p7-link-start').css('bottom', '29.5%');
//                        jQuery('#p8-link-start').css('bottom', '3.96%');
                    } else if ((window.matchMedia('screen and (min-width: 768px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/tabletmath.jpg)');
                        jQuery('#home').css('height', '1557');
                    } else if ((window.matchMedia('screen and (min-width: 320px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/phonemath.jpg)');
                        jQuery('#home').css('height', '2561');
//                        jQuery('#p7-link-start').css({
//                            'width': '55.7%',
//                            'bottom': '32.7%',
//                            'left': '5.8%',
//                        });
//                        jQuery('#p8-link-start').css({
//                            'width': '55.7%',
//                            'bottom': '2.2%',
//                            'left': '5.8%',
//                        });
                    }
                }

            }
            break;
        }
        case 2 :
        {
            switch (LANGUAGE) {
                case 2 :
                {
                    if ((window.matchMedia('screen and (min-width: 1200px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Ja_english.jpg)');
                        jQuery('#home').css('height', '1785');
                    } else if ((window.matchMedia('screen and (min-width: 768px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Ja_TABLET_english.jpg)');
                        jQuery('#home').css('height', '1561');
                        jQuery('#p5-link-start').css({
                            'bottom': '31.5%',
                        });
                    } else if ((window.matchMedia('screen and (min-width: 320px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Ja_PHONE_english.jpg)');
                        jQuery('#home').css('height', '2537');
                        jQuery('#p5-link-start').css({
                            'width': '50.7%',
                            'bottom': '31.6%',
                            'left': '12.8%',
                        });
                        jQuery('#p6-link-start').css({
                            'bottom': '1.8%',
                            'left': '12.8%',
                        });
                    }
                    break;
                }
                case 3:
                {
                    if ((window.matchMedia('screen and (min-width: 1200px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Kr_english.jpg)');
                        jQuery('#home').css('height', '1785');
                        jQuery('#p5-link-start').css('bottom', '29.7%');
                        jQuery('#p6-link-start').css('bottom', '4.3%');
                    } else if ((window.matchMedia('screen and (min-width: 768px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Kr_TABLET_english.jpg)');
                        jQuery('#home').css('height', '1561');
                    } else if ((window.matchMedia('screen and (min-width: 320px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Kr_PHONE_english.jpg)');
                        jQuery('#home').css('height', '2537');
                        jQuery('#p5-link-start').css({
                            'width': '53.7%',
                            'bottom': '31.3%',
                        });
                        jQuery('#p6-link-start').css({
                            'width': '53.7%',
                            'bottom': '2.5%',
                        });
                    }
                    break;
                }
                default :
                {
                    if ((window.matchMedia('screen and (min-width: 1200px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/englishtool.jpg)');
                        jQuery('#home').css('height', '1785');
//                        jQuery('#p5-link-start').css('bottom', '29.7%');
//                        jQuery('#p6-link-start').css('bottom', '4.3%');
                    } else if ((window.matchMedia('screen and (min-width: 768px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/tabletenglish.jpg)');
                        jQuery('#home').css('height', '1561');
                    } else if ((window.matchMedia('screen and (min-width: 320px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/phoneenglish.jpg)');
                        jQuery('#home').css('height', '2537');
//                        jQuery('#p5-link-start').css({
//                            'width': '53.7%',
//                            'bottom': '31.3%',
//                        });
//                        jQuery('#p6-link-start').css({
//                            'width': '53.7%',
//                            'bottom': '2.5%',
//                        });
                    }
                    break;
                }

            }
            break;
        }
        case 0 :
        {
            switch (LANGUAGE) {
                case 2 :
                {
                    if ((window.matchMedia('screen and (min-width: 1200px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Ja_main.jpg)');
                        jQuery('#home').css('height', '855');
                    } else if ((window.matchMedia('screen and (min-width: 768px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Ja_TABLET_main.jpg)');
                        jQuery('#home').css('height', '987');
                    } else if ((window.matchMedia('screen and (min-width: 320px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Ja_PHONE_main.jpg)');
                        jQuery('#home').css('height', '1749');
                    }
                    break;
                }
                case 3:
                {
                    if ((window.matchMedia('screen and (min-width: 1200px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Kr_main.jpg)');
                        jQuery('#home').css('height', '855');
                    } else if ((window.matchMedia('screen and (min-width: 768px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Kr_TABLET_main.jpg)');
                        jQuery('#home').css('height', '987');
                    } else if ((window.matchMedia('screen and (min-width: 320px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/Kr_PHONE_main.jpg)');
                        jQuery('#home').css('height', '1749');
                    }
                    break;
                }
                case 4:
                {
                    if ((window.matchMedia('screen and (min-width: 1200px)').matches)) {
                        jQuery('#home').css('background-image', 'url(../wp-content/themes/ik-learn/library/images/homemain_vi.png)');
                        jQuery('#home').css('height', '855');
                    }
                }

            }
            break;
        }
    }
    (function ($) {
        $(function () {
            $(".view-sub-modal").click(function (e) {
                e.preventDefault();
                var _img = $("#popup-info-img");
                var _m = $("#popup-info-dialog");
                _img.attr("src", $(this).attr("data-img")).load(function () {
                    _m.find(".modal-dialog").width(this.width);
                });
                $("#new-to-our-product-dialog").modal("hide").one("hidden.bs.modal", function () {
                    _m.modal()
                });
            });

            $("#popup-info-dialog").on("hidden.bs.modal", function () {
                $("#new-to-our-product-dialog").modal();
            });

            $("#about-teacher-dialog").on("hidden.bs.modal", function () {
                window.location.href = home_url + "/?r=teaching";
            });

            $("#about-student-dialog").on("hidden.bs.modal", function () {
                window.location.href = home_url + "/?r=sat-preparation";
            });

        });
    })(jQuery);
</script>
<?php if (is_user_logged_in() && isset($_SESSION['newuser'])) : ?>
    <div id="signup-success-dialog" class="modal fade modal-red-brown" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-11">
                            <p><strong><?php _e('Account Created!', 'iii-dictionary') ?></strong></p>
                            <p><?php _e('Your account has been created successfully and is ready to use. Please go to My Account for what you can do. Go to', 'iii-dictionary') ?><a class="text-my-account"><?php _e(' My Account.', 'iii-dictionary') ?></a></p>
                        </div>
                        <img class="icon-close-classes-created" id="icon-close"  aria-hidden="true" style="top: 25%" src="<?php echo get_template_directory_uri(); ?>/library/images/close_white.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function ($) {
            $(function () {
                $('#signup-success-dialog').modal('show');
                $('.icon-close-classes-created').on("click", function () {
                    $(".modal-red-brown").modal('hide');
                });
            });
        })(jQuery);
    </script>
    <?php
    $_SESSION['newuser'] = null;
endif
?>
<?php
MWHtml::ik_site_messages();
get_footer()
?>