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
if($is_user_logged_in){
    $link = '?r=ajax/logged/'.$current_user->ID.'/'.session_id();
    $linkss = '?r=ajax/logged/'.$current_user->ID.'/'.session_id();
}else{
    $link = '#login';
    $linkss = '';
}
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
                    <div class="col-md-6 col-sm-6 col-xs-12 body-tab boxshadow-tab" >
                        <div class="class-to-ikteacher">
                            <div class="wrapp-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/library/images/MainPic_Teacher.jpg" name="ikteacher" class="image-tab">
                                <button id="ikteach" class="btn-blue btn-group border-ras">TEACHERS & TUTORS</button>
                            </div>
                            <div id="tutor-page" class="intro-page">
                                
                                <div class="title-intro">Use Your Skill to Earn Money. Register Now!</div>
                                    

                               
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-2 mt-top-14">
                                        <img class="intro-img" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Tutor_1section.png">
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-10 mt-top-24 pd-lf-5">
                                        <div class="main-section" data-name="tutor-online">
                                            <span>Become a Tutor Online and Earn Money</span>
                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/icon_arrow_static.png">
                                        </div>
                                        <a>Regiter as an online teacher</a>
                                    </div>                                   

                                </div>
                                <div class="row" style="height:  130px">
                                    <div class="col-md-2 col-sm-2 col-xs-2 mt-top-34">
                                        <img class="intro-img" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Tutor_2section.png">
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-10 mt-top-24 pd-lf-5">
                                        <div class="main-section" data-name="tutor-create">
                                            <span>Create Your Online Course and Offer for a Price</span>
                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/icon_arrow_static.png">
                                        </div>
                                        <a>Regiter as an online teacher</a>
                                    </div>                                   

                                </div>
                            </div>
                            <div id="tutor-online" class="hidden">
                                <div class="list-step">
                                    <div class="intro-page">
                                        <div class="row" >
                                            <div class="col-md-2 col-sm-2 col-xs-2 mt-top-4">
                                                <img class="intro-img" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Tutor_1section.png">
                                            </div>
                                            <div class="col-md-10 col-sm-10 col-xs-10 mt-top-24">
                                                <div class="main-section" data-name="close">
                                                    <span>Become a Tutor Online and Earn Money</span>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/icon_arrow_opened.png">
                                                </div>
                                                <a>Regiter as an online teacher</a>
                                            </div>                                   

                                        </div>
                                    </div>
                                    <ul style="padding-left: 26px">
                                        <li class="step-show" data-name="onl-step1" data-type="tutor">
                                            <span class="step">Step 1</span>
                                            <span class="step-name">Select the subject(s) you wish to tutor.</span>
                                        </li>
                                        <li class="step-show" data-name="onl-step2" data-type="tutor">
                                             <span class="step">Step 2</span>
                                            <span class="step-name">Introduce yourself to students with the tutor sheet. </span>
                                        </li>
                                        <li class="step-show" data-name="onl-step3" data-type="tutor">
                                             <span class="step">Step 3</span>
                                            <span class="step-name">Utilize calendar functions to offer tutoring sessions.</span>
                                        </li>
                                        <li class="step-show" data-name="onl-step4" data-type="tutor">
                                             <span class="step">Step 4</span>
                                            <span class="step-name">Start tutoring.</span>
                                        </li>
                                        <li class="step-show" data-name="onl-step5" data-type="tutor">
                                             <span class="step">Step 5</span>
                                            <span class="step-name">Analyze your performance through student comments, accumulate payment balance, and get paid. </span>
                                        </li>
                                    </ul>
                                </div>
                                <div id="onl-step1" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 1</span>
                                        <span class="step-n">Select the subject(s) you wish to tutor.</span>
                                        <span class="step-close" data-type="step" data-name="onl-step1"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_1st_setp1.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Offer one-on-one tutoring, group tutoring, or both</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Set your own price</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Select subjects to tutor: English, Math, Science, and others</span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="onl-step2" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 2</span>
                                        <span class="step-n">Introduce yourself to students with the tutor sheet.</span>
                                        <span class="step-close" data-type="step" data-name="onl-step2"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_1st_setp2.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Tell why you like to tutor and teach</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Tell about your academic experience</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Tell about your educational background</span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="onl-step3" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 3</span>
                                        <span class="step-n">Utilize calendar functions to offer tutoring sessions.</span>
                                        <span class="step-close" data-type="step" data-name="onl-step3"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_1st_setp3.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>a flexible tutoring schedule based on your availability</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Plan easily with built in calendar</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Customize each time slot with price, type, and subject preferences</span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="onl-step4" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 4</span>
                                        <span class="step-n">Start tutoring</span>
                                        <span class="step-close" data-type="step" data-name="onl-step4"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_1st_setp4.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Tutoring session can be extended if more time is needed</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Tutor students using chat function, white board, and video chat</span>
                                            </li>
                                            
                                            <li style="padding-top: 6px">
                                                <span class="let-start">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="onl-step5" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 5</span>
                                        <span class="step-n">Analyze your performance through student comments, accumulate payment balance, and get paid.</span>
                                        <span class="step-close" data-type="step" data-name="onl-step5"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_1st_setp5.jpg">
                                        <ul class="list-of-step">
                                            <li style="padding-bottom: 0;">
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Check your performance from student reviews</span>
                                            </li>
                                            <li style="padding-bottom: 0;">
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Earn money with each tutoring session</span>
                                            </li>
                                            <li style="padding-bottom: 0;">
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Get paid when you accumulate a set balance</span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div id="tutor-create" class="hidden">
                                <div class="list-step">
                                    <div class="intro-page">
                                        <div class="row" >
                                            <div class="col-md-2 col-sm-2 col-xs-2 mt-top-34">
                                                <img class="intro-img" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Tutor_2section.png">
                                            </div>
                                            <div class="col-md-10 col-sm-10 col-xs-10 mt-top-24">
                                                <div class="main-section" data-name="close">
                                                    <span>Create Your Online Course and Offer for a Price</span>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/icon_arrow_opened.png">
                                                </div>
                                                <a>Regiter as an online teacher</a>
                                            </div>                                   

                                        </div>
                                    </div>
                                    <ul style="padding-left: 26px">
                                        <li class="step-show" data-name="create-step1" data-type="tutor">
                                            <span class="step">Step 1</span>
                                            <span class="step-name">Create your course with worksheets made by you.</span>
                                        </li>
                                        <li class="step-show" data-name="create-step2" data-type="tutor">
                                             <span class="step">Step 2</span>
                                            <span class="step-name">Organize your course and set the price. </span>
                                        </li>
                                        <li class="step-show" data-name="create-step3" data-type="tutor">
                                             <span class="step">Step 3</span>
                                            <span class="step-name">Option to offer ‘interactive mode’ such as editing student writing. </span>
                                        </li>
                                        <li class="step-show" data-name="create-step4" data-type="tutor">
                                             <span class="step">Step 4</span>
                                            <span class="step-name">Analyze your performance through student comments, accumulate payment balance, and get paid.</span>
                                        </li>                                    
                                    </ul>
                                </div>

                                 <div id="create-step1" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 1</span>
                                        <span class="step-n">Create your course with worksheets made by you.</span>
                                        <span class="step-close" data-type="step" data-name="create-step1"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_2nd_setp1.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Make custom worksheets with easy-to-use online worksheet creator</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Make your own courses with the worksheets</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Make as many as courses and worksheets as you want</span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="create-step2" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 2</span>
                                        <span class="step-n">Organize your course and set the price.</span>
                                        <span class="step-close" data-type="step" data-name="create-step2"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_2nd_setp2.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Set the prices for your courses</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>An efficient system for organizing your courses</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Students can easily view your course options</span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="create-step3" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 3</span>
                                        <span class="step-n">Option to offer ‘interactive mode’ such as editing student writing.</span>
                                        <span class="step-close" data-type="step" data-name="create-step3"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_2nd_setp3.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Courses can include ‘interactive mode’ where you help students in real time through online chat function</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>‘Interactive mode’ can be used for English, Math, Science, and other subjects</span>
                                            </li>
                                            
                                            <li style="padding-top: 6px">
                                                <span class="let-start">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="create-step4" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 4</span>
                                        <span class="step-n">Analyze your performance through student comments, accumulate payment balance, and get paid.</span>
                                        <span class="step-close" data-type="step" data-name="create-step4"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_2nd_setp4.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Check your performance from student reviews</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Get paid when you accumulate a set balance</span>
                                            </li>
                                            
                                            <li style="padding-top: 6px">
                                                <span class="let-start">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 body-tab" >
                        <div class="class-to-ikstudy">

                            <div class="wrapp-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/library/images/MainPic_Student.jpg" name="ikteacher" class="image-tab">
                               <button class="btn-orange btn-group border-ras " id="iklearn" >STUDENTS</button>
                            </div>
                            <div id="student-page" class="intro-page">
                                <div class="title-intro">Register Now and Start Your Online Learning!</div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-2 mt-top-24">
                                        <img class="intro-img" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Student_1section.png">
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-10 mt-top-24 pd-lf-5">
                                        <div class="main-section" data-name="student-online">
                                            <span>How to Get an Online Tutor</span>
                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/icon_arrow2_static.png">
                                        </div>
                                        <a>Register first to get online tutor for English, Math and English Conversation</a>
                                    </div>                                   

                                </div>
                                <div class="row" style="height:  130px">
                                    <div class="col-md-2 col-sm-2 col-xs-2 mt-top-24">
                                        <img class="intro-img" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Student_2section.png">
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-10 mt-top-24 pd-lf-5">
                                        <div class="main-section" data-name="student-create">
                                            <span>Student Online by Yourself</span>
                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/icon_arrow2_static.png">
                                        </div>
                                        <a>Regiter as a student</a>
                                    </div>
                                </div>
                            </div>
                            <div id="student-online" class="hidden">
                                <div class="list-step-st">
                                    <div class="intro-page">
                                        <div class="row" >
                                            <div class="col-md-2 col-sm-2 col-xs-2 mt-top-24">
                                                <img class="intro-img" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Student_1section.png">
                                            </div>
                                            <div class="col-md-10 col-sm-10 col-xs-10 mt-top-24">
                                                <div class="main-section" data-name="close-st">
                                                    <span>How to Get an Online Tutor</span>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/icon_arrow2_opened.png">
                                                </div>
                                                <a>Register first to get online tutor for English, Math and English Conversation</a>
                                            </div>                                   

                                        </div>
                                    </div>
                                    <ul style="padding-left: 26px">
                                        <li class="step-show" data-name="onl-step11" data-type="student">
                                            <span class="step">Step 1</span>
                                            <span class="step-name">Get enough points to pay for a tutor you select.</span>
                                        </li>
                                        <li class="step-show" data-name="onl-step22" data-type="student">
                                             <span class="step">Step 2</span>
                                            <span class="step-name">Work with a calendar to schedule a tutor.</span>
                                        </li>
                                        <li class="step-show" data-name="onl-step33" data-type="student">
                                             <span class="step">Step 3</span>
                                            <span class="step-name">Selecting the right tutor.</span>
                                        </li>
                                        <li class="step-show" data-name="onl-step44" data-type="student">
                                             <span class="step">Step 4</span>
                                            <span class="step-name">Tutor shows up online at the time you scheduled. </span>
                                        </li>
                                        
                                    </ul>
                                </div>
                                <div id="onl-step11" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 1</span>
                                        <span class="step-n">Get enough points to pay for a tutor you select.</span>
                                        <span class="step-close" data-type="step-st" data-name="onl-step11"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Student_1st_Setp-1.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>You will spend points for schedulings</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>1 point = $ 1 dollar</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>When short on points, you can recharge them </span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start-st">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow - student.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="onl-step22" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 2</span>
                                        <span class="step-n">Works with a calendar to schedule a tutor.</span>
                                        <span class="step-close" data-type="step-st" data-name="onl-step22"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                        
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Student_1st_Setp-2.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Find a tutor through “Find Tutor Page” or through “Calendar”</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>When date is selected from calendar, it will direct to schedule page</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Check tutor’s calendar for availability </span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start-st">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow - student.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="onl-step33" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 3</span>
                                        <span class="step-n">Selecting the right tutor.</span>
                                        <span class="step-close" data-type="step-st" data-name="onl-step33"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                        
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_1st_setp3.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Select suitable tutor from available list or searched list</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Check tutor’s resume from their detail page</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Review is also a good place to check the suitability </span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start-st">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow - student.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="onl-step44" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 4</span>
                                        <span class="step-n">Tutor shows up online at the time you scheduled.</span>
                                        <span class="step-close" data-type="step-st" data-name="onl-step44"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                        
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Tutor_1st_setp4.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>When tutor finalize the schedule, both tutor and student will meet through online teaching platform</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>All schedule status can be checked from “Schedule detailed page” </span>
                                            </li>
                                            
                                            <li style="padding-top: 6px">
                                                <span class="let-start-st">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow - student.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                            <div id="student-create" class="hidden">
                                <div class="list-step-st">
                                    <div class="intro-page">
                                        <div class="row" >
                                            <div class="col-md-2 col-sm-2 col-xs-2 mt-top-24">
                                                <img class="intro-img" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Student_2section.png">
                                            </div>
                                            <div class="col-md-10 col-sm-10 col-xs-10 mt-top-24">
                                                <div class="main-section" data-name="close-st">
                                                    <span>Study Online by Yourself </span>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/icon_arrow2_opened.png">
                                                </div>
                                                <a>Regiter as a studen</a>
                                            </div>                                   

                                        </div>
                                    </div>
                                    <ul style="padding-left: 26px">
                                        <li class="step-show" data-name="create-step11" data-type="student">
                                            <span class="step">Step 1</span>
                                            <span class="step-name">Check out free online courses for English and Math. You get a Vocabulary Builder tool free! </span>
                                        </li>
                                        <li class="step-show" data-name="create-step22" data-type="student">
                                             <span class="step">Step 2</span>
                                            <span class="step-name">Check Math self-study (Math tutoring plan).</span>
                                        </li>
                                        <li class="step-show" data-name="create-step33" data-type="student">
                                             <span class="step">Step 3</span>
                                            <span class="step-name">Check SAT test preparation for English and Math 1 and 2</span>
                                        </li>
                                        <li class="step-show" data-name="create-step44" data-type="student">
                                             <span class="step">Step 4</span>
                                            <span class="step-name">Check TOEFL and TOEIC Test Preparation   </span>
                                        </li>
                                        
                                    </ul>
                                </div>
                                <div id="create-step11" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 1</span>
                                        <span class="step-n">Check out free online courses for English and Math. You get a Vocabulary Builder tool free! </span>
                                        <span class="step-close" data-type="step-st" data-name="create-step11"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Student_2nd_Setp-1.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Get free online courses with basic registration</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Study vocabulary with free vocabulary builder</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>When ready, subscribe to our various online courses</span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start-st">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow - student.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="create-step22" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 2</span>
                                        <span class="step-n">Check Math self-study (Math tutoring plan).</span>
                                        <span class="step-close" data-type="step-st" data-name="create-step22"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                        
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Student_2nd_Setp-2.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>We have huge library of math subjects along with tutoring plan when you need help</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Math worksheets are easy to follow and manage</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Check you progress with student progress page </span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start-st">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow - student.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="create-step33" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 3</span>
                                        <span class="step-n">Check SAT test Preparation for English and Math 1 and 2.</span>
                                        <span class="step-close" data-type="step-st" data-name="create-step33"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                        
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Student_2nd_Setp-3.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Test your knowledge with SAT Preparation tests</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>There are many SAT Preps. For you to study</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>SAT Tutorings are available as well </span>
                                            </li>
                                            <li style="padding-top: 6px">
                                                <span class="let-start-st">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow - student.png">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="create-step44" class="hidden">
                                    <div style="  padding-top: 20px;">
                                        <span class="step-z">step 4</span>
                                        <span class="step-n">Check TOEFL and TOEIC Test Preparation.</span>
                                        <span class="step-close" data-type="step-st" data-name="create-step44"><img style="height: 12px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_step_close.png"></span>
                                        
                                    </div>
                                    <div style="padding-top: 20px">
                                        <img style="width: 148px; float: left;" src="<?php echo get_template_directory_uri(); ?>/library/images/Student_2nd_Setp-4.jpg">
                                        <ul class="list-of-step">
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Practice with different sections</span>
                                            </li>
                                            <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>There are many simulated tests to take</span>
                                            </li>
                                             <li>
                                                <img style="width: 7px;" src="<?php echo get_template_directory_uri(); ?>/library/images/03_Icon_Sub-menu.png">
                                                <span>Audio for listening comprehension sections </span>
                                            </li>
                                            
                                            <li style="padding-top: 6px">
                                                <span class="let-start-st">LET'S START</span>
                                                <img style="width: 14px;" src="<?php echo get_template_directory_uri(); ?>/library/images/icon_Lets_Start_Arrow - student.png">
                                            </li>
                                        </ul>
                                    </div>
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
            $('.main-section').click(function(){
                var name = $(this).attr('data-name');
                if(name == "tutor-online"){
                    $('#tutor-page').addClass('hidden');
                    $('#tutor-online').removeClass('hidden');
                }else if(name == "close"){
                    $('#tutor-page').removeClass('hidden');
                    $('#tutor-online, #tutor-create').addClass('hidden');
                }else if(name =="tutor-create"){
                     $('#tutor-page').addClass('hidden');
                     $('#tutor-create').removeClass('hidden');
                }else if(name == "student-online"){
                    $('#student-page').addClass('hidden');
                    $('#student-online').removeClass('hidden');
                }else if(name == "close-st"){
                    $('#student-page').removeClass('hidden');
                    $('#student-online, #student-create').addClass('hidden');
                }else if(name == "student-create"){
                    $('#student-page').addClass('hidden');
                    $('#student-create').removeClass('hidden');
                }
            });
            $('.step-show').click(function(){
                var name = $(this).attr('data-name');
                var step = $('#'+name);
                var type = $(this).attr('data-type');

                if(type == "tutor"){
                    $('.list-step').addClass('hidden');
                    
                }else{
                    $('.list-step-st').addClass('hidden');
                   
                }
                step.removeClass('hidden');

            });
            $('.step-close').click(function(){
                    var name = $(this).attr('data-name');
                    var step = $('#'+name);
                    var type = $(this).attr('data-type');
                    if(type == 'step'){
                        $('.list-step').removeClass('hidden');
                    
                    }else{
                        $('.list-step-st').removeClass('hidden');
                    }
                    step.addClass('hidden');
            });
            $('#ikteach').click(function(){
                var link = '<?php echo $linkss; ?>';
                if (link !='') {
                    window.location='https://iktutor.com/ikteach/en'+link;
            }else{
                window.location='https://iktutor.com/ikteach/en/';      
            }
            });
            $('#iklearn').click(function(){
                var link = '<?php echo $link; ?>';
                if (link !='') {
                    window.location='https://iktutor.com/iklearn/en'+link;
            }else{
                window.location='https://iktutor.com/iklearn/en/';      
            }
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