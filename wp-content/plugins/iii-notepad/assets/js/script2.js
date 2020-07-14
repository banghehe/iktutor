var url = 'https://notepad.iktutor.com:3000/';
var plugin_url = iii_script.plugin_url;

//var url = window.location.hostname;
var stanza = iii_variable.roomid;
// if (location.href.indexOf('#') != -1) {
//     stanza = location.href.substring(location.href.indexOf('#') + 1);
// }

var controlpencil = true;
var controlrubber = false;
var positionx = '0';
var positiony = '0';
var lastEmit = $.now();
var touchX, touchY;
var iniziotocco = true;

var doc = $(document),
    divrubber = $('#divrubber');
var color = getColor();
var spessremo = getPencil();
// A flag for drawing activity
var drawing = false;
var clients = {};
var cursors = {};
var dragging = false;

//  funzione richiesta di nick name   
var id = username = Math.round($.now() * Math.random());
if (!username) {
    username = prompt("Hey there, insert your nick name, please", "");
}
var totalSeconds = 0;
var idtempo;
var redo_list = [];
var undo_list = [];
var $state      = [];

var history = function() {};
var iStep   = -1;

history.saveState = function () {
    iStep++;

    if (iStep < undo_list.length) {
        undo_list.length = iStep;
    }

    var cnt = getCanvas();
    var can = $('#math' + cnt);

    undo_list.push(can[0].toDataURL());
};

history.undo = function () {
    if (iStep > 0) {
        iStep--;

        history.restoreState();
    }
};

history.redo = function () {
    if (iStep < undo_list.length - 1) {
        iStep++;

        history.restoreState();
    }
};

history.restoreState = function() {
    var cnt     = getCanvas();
    var can     = $('#math' + cnt);
    var ctxcan  = can[0].getContext('2d');
    ctxcan.clearRect(0, 0, can[0].width, can[0].height);

    var imgdaclient = new Image();
    imgdaclient.src = undo_list[iStep];
    imgdaclient.onload = function() {
        ctxcan.drawImage(imgdaclient, 0, 0);
    }
};
var click_event	= document.ontouchstart ? 'touchstart' : 'click';

var webSyncHandleUrl = 'https://websync.s-work.vn/websync.ashx';
fm.websync.client.enableMultiple = true;
var clients = new fm.websync.client(webSyncHandleUrl);
var testichat = document.getElementById('testichat');
var cnt = 0;

loadChat('Tutor', stanza, clients, testichat);
getSubscribe(clients, stanza, testichat);


$(function() {
    var sidemenu    = $('.opacitySideMenu');
    var tray_menu   = $('.menu-tray');
    var $task_wrap  = $('.taskbar-notepad');

    $task_wrap.find('.tool-btn').on('click', function() {
        var $this = $(this);

        var cnt     = getCanvas();
        $('#panel').find('.typing-input').remove();
        $('#add-type-box').removeClass('active');
        $('#math' + cnt).unbind(click_event, TypingCreatTextarea);
        $('#math' + cnt)[0].removeEventListener('touchstart', TypingCreatTextareaTouchDevice);


        if ($this.hasClass('active')) {
            $this.removeClass('active');
            $this.next('.tool-submenu').addClass('hidden');

            tray_menu.removeClass('has-submenutool');
            sidemenu.removeClass('has-submenutool');

            // tray_menu.css('margin-top', '0');
            // sidemenu.css('margin-top', '0');
        } else {
            $task_wrap.find('.tool-btn').removeClass('active');
            $task_wrap.find('.tool-submenu').addClass('hidden');

            $this.addClass('active');
            $this.next('.tool-submenu').removeClass('hidden');

            // tray_menu.css('margin-top', '40px');
            // sidemenu.css('margin-top', '40px');
            tray_menu.addClass('has-submenutool');
            sidemenu.addClass('has-submenutool');
        }
    });

    $('#change-eraser').on('click', function () {
        $('#divrubber').css({ "display": "block", "width": "30px", "height": "30px", "visibility": "visible" });
        $('#controlrubber').addClass('css-cursor-30');
        $("#erasers-body").find(`[data-eraser='30']`).addClass('active');

        canEraser();
    });

    $('#change-size-pencil').on('click', function () {
        var cnt = getCanvas();

        $("#erasers-body li").removeClass('active');
        $('#divrubber').css("display", "none");
        canDraw();

        if (parseInt($(this).attr('data-layer')) === (cnt - 3)) {
            return;
        }

        $(this).attr('data-layer', cnt - 3);

        // $('.hello').removeClass("hidden");
        // $('.hello .text-popup-close').text('Layer #' + (cnt - 3) + ' is selected');
        // $(".close-popup-close").click(function() {
        //     $('.hello').addClass("hidden");
        //     $('.hello').css("z-index","2");
        // });
    });

    //display screenshots
    $("#icon-screenshot").click(function() {
        var check = $('.screenshot-class').hasClass("hidden");
        if (check == true) {
            $('.screenshot-class').removeClass("hidden");
        } else {
            $('.screenshot-class').addClass("hidden");
        }
    });

    // onscreen typing tool
    $("#add-type-box").on(click_event, function () {
        var cnt     = getCanvas();
        var next    = (parseInt(cnt) + 1);

        // if ($('#math' + cnt).hasClass('has-image') && $('#math' + next).length && $('#math' + next).hasClass('active')) {
        //     cnt = next;
        // }

        $('#math' + cnt).unbind(click_event, TypingCreatTextarea);
        $('#math' + cnt)[0].removeEventListener('touchstart', TypingCreatTextareaTouchDevice);

        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $('#math' + cnt).bind(click_event, TypingCreatTextarea);
            $('#math' + cnt)[0].addEventListener('touchstart', TypingCreatTextareaTouchDevice);
        } else {
            $(this).removeClass('active');
            $('#math' + cnt).unbind(click_event, TypingCreatTextarea);
            $('#math' + cnt)[0].removeEventListener('touchstart', TypingCreatTextareaTouchDevice);
            $('#panel').find('.typing-input').remove();
        }
    });

    $('body').on(click_event, function() {
        var cnt = getCanvas();
        var can = $('#math' + cnt);
        var ctxcan = can[0].getContext('2d');

        $('#panel').find('.typing-input').each(function () {
           var $this        = $(this),
                position    = $this.position(),
                left        = position.left,
                top         = position.top + 10;

            var arrLine = $this.val().split('\n');
            var $i = 1;
            $.each(arrLine, function(index, item) {
                var item_top = top + $i * 10;
                ctxcan.fillText(item, left, item_top);
                $i++;
            });

            if ($('#panel').find('.typing-input').length > 1) {
                $this.remove();
            }
        });
    });

    $("select").selectBoxIt();

    //event close session	  
    $("#close-session").on('click', function() {
        $('.close-session').removeClass("hidden");
    });

    $(".close-popup-close").click(function() {
        $('.close-class').addClass("hidden");
    });
    //p2

    // Event opacitySideMenu side menu
    var slider = document.getElementById("bgopacity");
    var output = document.getElementById("rangevalue");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    };

    $('#bgopacity').on('input', function () {
        $(this).parents('.opacitySideMenu').addClass('on-change');
    });

    $('#bgopacity').on('change', function() {
        // if ($('#bgopacity').val() <= 100 && $('#bgopacity').val() >= 70) {
        //     //$('#canvas').css("z-index", "-20");
        //     $('.wrap-sidebar-left').css("z-index", "1");
        // } else {
        //     $('#canvas').css("z-index", "-19");
        //     $('#canvas').css("background", "transparent");
        //     $('.wrap-sidebar-left').css("z-index", "-20");
        // }
        $('.wrap-sidebar-left').css({
            opacity: $(this).val() * '.01'
        });

        $(this).parents('.opacitySideMenu').removeClass('on-change');
    });

    var studentlist = 0;
    var mess = 0;
    // Event click for button list student
    $(".student_list").on('click', function() {
        var $actionOnRight  = $(".menu-tray"),
            $parent         = $('.attend-list'),
            $this           = $(this);

        if ($actionOnRight.hasClass('show-both')) {
            updateStatus($this, 'both', 'chat-only', $parent);
        } else if ($actionOnRight.hasClass('student-only')) {
            updateStatus($this, 'me', 'student-only', $parent);
        } else if ($actionOnRight.hasClass('chat-only')) {
            updateStatus($this, 'other', 'chat-only', $parent);
            ResizeWhenShowBoth();
        } else {
            updateStatus($this, 'remove', 'student-only', $parent);
        }
    });

    ResizeWhenShowBoth();

    $(".pop-chat").on('click', function() {
        var $actionOnRight = $(".menu-tray"),
            $parent         = $('.chat_box'),
            $this           = $(this);

        if ($actionOnRight.hasClass('show-both')) {
            updateStatus($this, 'both', 'student-only', $parent);
        } else if ($actionOnRight.hasClass('student-only')) {
            updateStatus($this, 'other', 'student-only', $parent);
            ResizeWhenShowBoth();
        } else if ($actionOnRight.hasClass('chat-only')) {
            updateStatus($this, 'me', 'chat-only', $parent);
        } else {
            updateStatus($this, 'remove', 'chat-only', $parent);
        }
    });

    function updateStatus($el, $status, $class, $parent) {
        var $wrapper = $('.menu-tray');

        if ($status === 'remove') {
            $el.addClass('active');
            $wrapper.css('display', 'block');
            $parent.css('display', 'block');
            $wrapper.addClass($class);

            $('.opactiyPercentage').css('display', 'flex');
            $('.editBar').css('display', 'block');
            $('.closeSideMenu .hideSideMenu').removeClass('hidden');
            $('.closeSideMenu .showSideMenu').addClass('hidden');
            ShowsideMenu();
        } else if ($status === 'me') {
            $el.removeClass('active');
            $wrapper.css('display', 'none').removeClass($class);
            $parent.css('display', 'none');

            $(".hideSideMenu").addClass("hidden");
            $(".showSideMenu").removeClass("hidden");
            $(".opactiyPercentage").hide();
            $(".editBar").hide();
            $('.showSideMenu').unbind('click');
        } else if ($status === 'other') {
            $el.addClass('active');
            $wrapper.css('display', 'block');
            $parent.css('display', 'block');
            $wrapper.removeClass($class).addClass('show-both');

            $('.opactiyPercentage').css('display', 'flex');
            $('.editBar').css('display', 'block');
            $('.closeSideMenu .hideSideMenu').removeClass('hidden');
            $('.closeSideMenu .showSideMenu').addClass('hidden');

            ShowsideMenu();
        } else if ($status === 'both') {
            $el.removeClass('active');
            $parent.css('display', 'none');
            $wrapper.removeClass('show-both').addClass($class);

            ShowsideMenu();
        }
    }

    function ResizeWhenShowBoth() {
        $('.chat_box').resizable({
            minHeight: 150,
            handles: {
                's': '.ui-resizable-n'
            },
            start: function(e, ui) {

            }
        }).on("resize", function(event, ui) {
            var hBottom = ui.size.height,
                hTop = $(window).height() - hBottom;

            $('.chat_box').height(hBottom);
            $('.attend-list').height(hTop);
        });
    }

    var video_chat = 0;
    $("#toggleVideoMute").click(function() {
        video_chat++;
        if (video_chat % 2 != 0) {
            $("#toggleVideoMute").removeClass("active");
            $("#videoAndMic").css("display", "block");
            $("#videoAndMic").removeClass("hidden");
            $(".turnVideo").removeClass("hidden");
            $(".On_Video").removeClass("hidden");
            $(".Off_Video").addClass("hidden");
            $(".turnMic").addClass("hidden");
            $('#videoChat').removeClass('hidden');
            $(".video_list").addClass('active');
            setTimeout('$("#videoAndMic").hide()', 3000);

        } else {
            $(".video_list").removeClass("active");
            $(".On_Video").addClass("hidden");
            $(".Off_Video").removeClass("hidden");
            $("#videoAndMic").show();
            $('#videoChat').addClass('hidden');
            $(".video_list").removeClass('active');
            setTimeout('$("#videoAndMic").hide()', 3000);


        }
    });
    var mic_chat = 0;;
    $("#toggleAudioMute").click(function() {
        mic_chat++;
        if (mic_chat % 2 != 0) {
            $("#videoAndMic").css("display", "block");
            $("#videoAndMic").removeClass("hidden");
            $(".turnVideo").addClass("hidden");
            $(".turnMic").removeClass("hidden");
            $(".On_Mic").removeClass("hidden");
            $(".Off_Mic").addClass("hidden");
            setTimeout('$("#videoAndMic").hide()', 3000);
        } else {
            $(".On_Mic").addClass("hidden")
            $(".Off_Mic").removeClass("hidden");
            $("#videoAndMic").show();
            setTimeout('$("#videoAndMic").hide()', 3000);

        }
    });

    // Event hide/show side menu popup

    $(".hideSideMenu").click(function() {

        $(".menu-tray").hide();
        $(".hideSideMenu").addClass("hidden");
        $(".showSideMenu").removeClass("hidden");
        $(".opactiyPercentage").hide();
        $(".editBar").hide();

    });
    // Event click for hidden & show bottom-menu
    // menu bottom

    $(".clickToHideBottom").click(function() {
        $(".bottom-menu").fadeOut(300);
        $(".clickToShowBottom").css("display", "block");
        $(".clickToHideBottom").css("display", "none");
        $(".message-send").css("bottom", 0);
        $('.menu-tray').addClass('no-bottommenu');

    });
    $(".clickToShowBottom").click(function() {
        $(".bottom-menu").fadeIn(300);
        $(".clickToShowBottom").css("display", "none");
        $(".clickToHideBottom").css("display", "block");
        $(".message-send").css("bottom", 33);
        $('.menu-tray').removeClass('no-bottommenu');
    });

    // Event custom scrollbar
    $('.style-scrollbar').mCustomScrollbar();

    // Event start tutoring
    $check_start = true;
    $('.start-tutoring').on('click', function () {
        if ($check_start == true) {
            $('body').removeClass('none-active');
            CountdownTime(iii_variable.time_ranger);
        }

        $check_start = false;
    });

    // Event click for button video_list
    var video_list = 0;
    $(".video_list").click(function() {
        video_list++;
        if ($("#videoChat").hasClass('hidden')) {
            $("#videoChat").removeClass("hidden");
            $(this).addClass('active');
        } else {
            $("#videoChat").addClass("hidden");
            $(this).removeClass('active');
        }
    });


    $(".attend-video-list").scroll(function() {
        $('.handle img').css("box-shadow", "0px -4px 0px rgb(186,186,186,0.3)");
        $('.handle hr').css("box-shadow", "0px -3px 0px rgb(186,186,186,0.3)")
    });

    $(".status-selector").click(function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('.status-selector-bar').hide();
        } else {
            $(this).addClass('active');
            $('.status-selector-bar').show();
        }
    });

    $('.status-selector-bar > ul > li').on('click', function () {
        var $val = $(this).data('type');
        $('#emoji').val($val);

        var image_patch = plugin_url + 'assets/Images/Icons/';
        var image;

        switch ($val) {
            case 'fast':
                image = '56_Status_TooFast.png';
                break;
            case 'confused':
                image = '55_Status_Confused.png';
                break;
            case 'understand':
                image = '54_Status_Good.png';
                break;
        }

        $('.status-selector img').attr('src', '' + image_patch + image + '');
        $('.status-selector-bar').hide();
        $('.status-selector').removeClass('active');
    });

    $('#file-input').change(function(e) {
        $('#panel').find('.typing-input').remove();

        var file = e.target.files[0],
            imageType = /image.*/;
        if (!file.type.match(imageType))
            return;

        var reader = new FileReader();
        reader.onload = fileOnload;
        reader.readAsDataURL(file);

        var cnt = getCanvas();
        var can = $('#math' + cnt);
        can.addClass('has-image');
    });

    $('#divrubber').draggable();

    // Event purchase
    $('.purchase-cancel').on('click', function () {
         $('.popup-purcharse').addClass('hidden');
    });

    $('.purchase-accept').on('click', function () {
        var data = {
          'action': 'iii_notepad_purchase_time',
          'student_id': iii_variable.user_id,
          'teacher_id': iii_variable.teacher_id,
          'sid': iii_variable.sid
        };

        $.ajax({
            method: 'POST',
            url: iii_script.ajax_url,
            data: data,
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                if (response === '0') {
                    alert(iii_script.buy_time_fail);
                } else if (response === '1') {
                    alert(iii_script.buy_time_done);
                    CountdownTime(1800);
                    $('.block-status-tutor').removeClass('off');
                    $('.popup-purcharse').addClass('hidden');
                    $('.block-status-tutor').unbind('click');
                    $('body').removeClass('none-active');
                }
            }
        });
    });

    //Countdown Time
    function CountdownTime($time) {
        var $clock = $('.time-class');

        var min = new Date(new Date().valueOf() + $time * 1000);
        $clock.countdown(min, function(event) {
            $(this).html(event.strftime('00:%M:%S'));

            if (event.type == 'finish') {
                $('.block-status-tutor').addClass('off');
                $('body.notepad-on').addClass('none-active');
                $('.start-tutoring').addClass('hidden');

                $('.block-status-tutor.off').on('click', function () {
                    $('.popup-purcharse').removeClass('hidden');
                });
            };
        });
    }

    $(document).on('click', '#btn-undo', function() {
        history.undo();
    });

    $(document).on('click', '#btn-redo', function() {
        history.redo();
    });

    $('#icon-video').on('click', function () {
       if ($('.video-popup-class').hasClass('hidden')) {
            $('.video-popup-class').removeClass('hidden')
       } else {
        $('.video-popup-class').addClass('hidden')
       }
    });

    $('#yotubeVideo .item-video video').mediaelementplayer();

    $('.video-btn').on('click', function () {
        var $this   = $(this);
        var $url    =  $this.parents('.video-popup-class').find('.video-url').val();
        var cnt     = getCanvas();

        $('#yotubeVideo .item-video').addClass('hiden');

        if ($url === '') {
            alert(iii_script.empty_video_url);
        } else {
            if ($('#video-' + cnt).length < 1) {
                createVideo($url);
                $('#yotubeVideo').removeClass('hidden');
            } else if ($('#video-' + cnt).find('source').attr('src') !== $url) {
                $('#video-' + cnt).remove();
                createVideo($url);
            }
        }
    });

    function createVideo($url) {
        var cnt     = getCanvas();

         var $div  = $('<div/>', {
            class: 'item-video',
            id: 'video-' + cnt
        }).appendTo('#yotubeVideo');

        var video = $('<video/>', {}).appendTo($div);

        var source = $('<source/>', {
            src: $url,
            type: 'video/youtube',
            width: 200,
            height: 200
        }).appendTo(video);

        video.mediaelementplayer();
    }

    // Event User Login
    var ctrlFlag = false;
    $(document).keydown(function(e) {
        var code = e.keyCode || e.which;

        if (code == 17) {
            ctrlFlag = true;
        } else if (code === 53 && ctrlFlag) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            $('.user-login-form').removeClass('hidden');
        }
    });

    $(document).keyup(function () {
        ctrlFlag = false;
    });

    $('.userFormSubmit').on('click', function() {
        console.log();
        var data = $('.userLoginForm').serialize();

        $.ajax({
            method: 'POST',
            url: iii_script.ajax_url,
            data: data + '&action=iii_notepad_user_login',
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                if (typeof(response) === 'string') {
                    alert(response);
                } else if (typeof (response) === 'object') {
                    window.location.href = iii_script.site_url + '?uid1=' + response.user1_id + '&uid2=' + response.user2_id
                }
            }
        });
    });

    createCanvas();
    initDraw();
    addLayer();
    deleteLayer();
    clearState();
    initChat();
    activeTab();
    initWorksheet();
    initVideo();
});

function ShowsideMenu() {
    $(".showSideMenu").click(function() {
        $(".menu-tray").show();

        $(".hideSideMenu").removeClass("hidden");
        $(".showSideMenu").addClass("hidden");
        $(".opactiyPercentage").show();
        $(".editBar").show();
    });
}

function TypingCreatTextarea(e) {
    e.preventDefault();

    var textarea = $('<textarea/>', {
        class: 'typing-input'
    }).appendTo('#panel');

    var top = e.clientY - 70;

    textarea.css({
        top: top + 'px',
        left: e.clientX + 'px'
    });
}

function TypingCreatTextareaTouchDevice(e) {
    e.preventDefault();

    var textarea = $('<textarea/>', {
        class: 'typing-input'
    }).appendTo('#panel');

    if (e.touches) {
        if (e.touches.length == 1) {
            var touch = e.touches[0];

            var top = touch.pageY - 70;

            textarea.css({
                top: top + 'px',
                left: touch.pageX + 'px'
            });
        }
    }
}

function initWorksheet() {
    var $panel = $('#w-panel');

    $('.actions-r .r-mode').on('click', function() {
        let $this = $(this);
        let $type = $this.data('type');

        $('.actions-r').find('.r-mode').removeClass('on');
        $('.main-content').addClass('hidden').removeClass('active');
        $('.r-taskbar').addClass('hidden').removeClass('active');

        if ($this.hasClass('on')) {
            $this.removeClass('on');
            $('.main-' + $type).addClass('hidden').removeClass('active');
            $('.taskbar-' + $type).addClass('hidden').removeClass('active');
            $('body').removeClass($type + '-on');
            $('html').removeClass($type + '-on');
        } else {
            $this.addClass('on');
            $('.main-' + $type).addClass('active').removeClass('hidden');
            $('.taskbar-' + $type).addClass('active').removeClass('hidden');
            $('body').removeClass('worksheet-on notepad-on').addClass($type + '-on');
            $('html').removeClass('worksheet-on notepad-on').addClass($type + '-on');
        }
    });

    WsCreateQuestionSingleAnswer();

    $('.ws-title-clear').on('click', function () {
        $('.ws-title-input').val('');
    });

    $('.ws-delete').on('click', function () {
        $('.ws-notice').removeClass('hidden');
        $('.ws-notice').find('.wsn-text').text(iii_script.ws_notice_delete);
        $('.ws-notice').find('.wsn-type').val('delete');
    });

    $('.ws-clear').on('click', function () {
        $('.ws-notice').removeClass('hidden');
        $('.ws-notice').find('.wsn-text').text(iii_script.ws_notice_clear);
        $('.ws-notice').find('.wsn-type').val('clear');
    });

    $('.wsq-delete-current').on('click', function () {
        $('.ws-notice').removeClass('hidden');
        $('.ws-notice').find('.wsn-text').text(iii_script.ws_notice_question);
        $('.ws-notice').find('.wsn-type').val('question');
    });

    $('.wsn-btn-yes').on('click', function () {
        var $this           = $(this),
            $notice_parent  = $this.parents('.ws-notice'),
            $type           = $notice_parent.find('.wsn-type').val();

            if ($type == 'clear') {
                $('#w-panel').find('.item-ws .ic-image .ic-image-value').empty();
                $('#w-panel').find('.item-ws .ic-image .ic-image-input').val('');
                $('#w-panel').find('.item-ws .ic-image .ic-image-input-val').attr('src', '');

                $('#w-panel').find('.item-ws .ic-video .ic-video-value').empty();
                $('#w-panel').find('.item-ws .ic-video .ic-video-input').val('');
                $('#w-panel').find('.item-ws .ic-video .ic-popup-video').addClass('hidden');
                $('#w-panel').find('.item-ws .ic-video .ic-popup-video input').val('');

                $('#w-panel').find('.item-ws .ic-text .ic-text-value').empty();
                $('#w-panel').find('.item-ws .ic-text .ic-text-input').val('');
                $('#w-panel').find('.item-ws .ic-text .ic-popup-text textarea').val('');
                $('#w-panel').find('.item-ws .ic-text .ic-popup-text').addClass('hidden');

                $('#w-panel').find('.item-ws .txtEditor').each(function () {
                    $(this).Editor('setText', '');
                });

                $('#w-panel').find('.multi-choice .choice-text textarea').val('');
            } else if ($type == 'delete') {
                $('.ws-title-input').val('');
                $('.ws-questions-number ul').find('li').remove();
                $('#w-panel').find('.item-ws').remove();
            } else if ($type == 'question') {
                var $index = $('.ws-questions-number ul').find('.active').attr('data-index');

                if ($index > 1) {
                    var $new_index = parseInt($index) - 1;
                } else {
                    var $new_index = parseInt($index) + 1;
                }

                $('.ws-questions-number ul').find("[data-index='" + $index + "']").remove();
                $('#ws' + $index).remove();

                $('.ws-questions-number ul').find('li').removeClass('active');
                $('.ws-questions-number ul').find("[data-index='" + $new_index + "']").addClass('active');
                $('#w-panel').find('.item-ws').addClass('hidden');
                $('#ws' + $new_index).removeClass('hidden');
            }

            $('.ws-notice').addClass('hidden').removeClass('wsn-insert-video');
            $notice_parent.find('.wsn-type').val('');
    });

    $('.wsn-btn-no').on('click', function () {
        $('.ws-notice').addClass('hidden').removeClass('wsn-insert-video');
    });

    $('#btn-ws-add-type-box').on('click', function () {
        let $ws = $('#w-panel .item-ws').not('.hidden');

        createComponentText($ws);
        EventButtonOrder();
    });

    $('#btn-ws-add-video').on('click', function () {
        let $ws = $('#w-panel .item-ws').not('.hidden');

        createComponentVideo($ws);
        EventButtonOrder();
    });

    $('#btn-ws-add-image').on('click', function () {
        let $ws = $('#w-panel .item-ws').not('.hidden');

        createComponentImage($ws);
        EventButtonOrder();
    });

    $('.ws-login').on('click', function () {
        WorkSheetUserLogin();
    });

    function WorkSheetUserLogin() {
        if ($('.ws-popup-login').hasClass('active')) {
            $('.ws-popup-login').removeClass('active');
        } else {
            $('.ws-popup-login').addClass('active');
        }
    }

    function makeTextEditor($el) {
        $el.Editor({
            'indent': false,
            'outdent': false,
            'print': false,
            'rm_format': false,
            'status_bar': false,
            'strikeout': false,
            'splchars': false,
            'fonteffects': false,
            'actions': false,
            'fonts': false,
            'font_size': false,
            'insert_table': false,
            'select_all': false,
            'togglescreen': false,
            'undo': false,
            'redo': false,
        });
    }

    function activeTabQuestion() {
        $('.ws-questions-number ul').find('li').on('click', function () {
            $('.ws-questions-number ul').find('li').removeClass('active');
            $(this).addClass('active');
            $('#w-panel').find('.item-ws').addClass('hidden');
            $('#ws' + $(this).attr('data-index')).removeClass('hidden');
        });
    }

    function createComponent($item) {
        createComponentText($item);
        createComponentVideo($item);
        createComponentImage($item);
        
        EventButtonOrder();
    }

    function createComponentImage($component) {
        var $index = $panel.find('.item-ws').length;
        var $wrapper_image   = $('<div/>', {class: 'item-component ic-image'});

        $component.prepend($wrapper_image);

        var $image_content = [
            '<div class="ic-inner">',
            '<div class="ic-left">',
            '<div class="ic-btn-image ic-btn"><img src="' + plugin_url + 'assets/Images/worksheet/icon_15_Insert_Image.png " />' + iii_script.ic_btn_image + '</div>',
            '<div class="ic-image-value" > </div>',
            '<input type="file" class="ic-image-input" id="input'+$index+'" accept="image/*" style="display: none;"/> ',
            '<img id="output'+$index+'" src="#" hidden class="ic-image-input-val"/>',
            '</div>',
            '<div class="ic-right ic-move">',
            '</div>',
            '</div>'

        ];

        $($image_content.join('')).appendTo($wrapper_image);
        var $input = $("#input"+$index);

        $('.ic-btn-image').click(function () {
            $($input).click();
        });

        $($input).unbind('change').bind('change', function (input) {
                var file = input.target.files;
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#output'+$index).attr("src", e.target.result);
                };
                for(var i = 0; i < file.length; i++){
                    reader.readAsDataURL(file[i]);
                    var f = file[i];
                    var $name = f.name;
                }
                var $this  = $(this);
                $this.siblings('.ic-image-value').empty().html($name);
            });

        createComponentButtonMove($wrapper_image.find('.ic-move'));
    };

    function createComponentVideo($component) {
        var $wrapper_video   = $('<div/>', {class: 'item-component ic-video'});

        $component.prepend($wrapper_video);

        var $video_content = [
            '<div class="ic-inner">',
            '<div class="ic-left">',
            '<div class="ic-btn-video ic-btn"><img src="' + plugin_url + 'assets/Images/worksheet/icon_16_Insert_Video.png" />' + iii_script.ic_btn_video + '</div>',
            '<div class="hidden ic-popup-video"><button>' + iii_script.ic_btn_video_button + '</button><input type="text" name="" /></div>',
            '<div class="ic-video-value"></div>',
            '<input type="hidden" class="ic-video-input" />',
            '</div>',
            '<div class="ic-right ic-move">',
            '</div>',
            '</div>'
        ];

        $($video_content.join('')).appendTo($wrapper_video);

        $('.ic-btn-video').on('click', function () {
           $(this).siblings('.ic-popup-video').removeClass('hidden');
           $(this).siblings('.ic-video-value').empty();
        });

        $('.ic-popup-video button').on('click', function () {
            var $this    = $(this);
            var $popup   = $this.parents('.ic-popup-video');
            var $val     = $this.siblings('input').val();

            console.log($val);

            if ($val.indexOf('https://www.youtube.com/') != -1) {
                $popup.addClass('hidden');
                $popup.siblings('.ic-video-value').empty().html($val);
                $popup.siblings('.ic-video-input').val($val);
            } else {
                $('.ws-notice').removeClass('hidden').addClass('wsn-insert-video');
                $('.ws-notice').find('.wsn-text').text(iii_script.ws_notice_insert_video);
                $('.ws-notice').find('.wsn-type').val('insert_video');
            }
        });

        createComponentButtonMove($wrapper_video.find('.ic-move'));
    }

    function createComponentText($component) {
        var $wrapper_text   = $('<div/>', {class: 'item-component ic-text'});

        $component.prepend($wrapper_text);

        var $text_content = [
            '<div class="ic-inner">',
            '<div class="ic-left">',
            '<div class="ic-btn-text ic-btn"><img src="' + plugin_url + 'assets/Images/worksheet/icon_17_Insert_Text.png" />' + iii_script.ic_btn_text + '</div>',
            '<div class="hidden ic-popup-text"><textarea class="autoExpand"></textarea></div>',
            '<div class="ic-text-value"></div>',
            '<input type="hidden" class="ic-text-input" />',
            '</div>',
            '<div class="ic-right ic-move">',
            '</div>',
            '</div>'
        ];

        $($text_content.join('')).appendTo($wrapper_text);

        $(document).one('focus.autoExpand', 'textarea.autoExpand', function(){
            var savedValue = this.value;
            this.value = '';
            this.baseScrollHeight = this.scrollHeight;
            this.value = savedValue;
        }).on('input.autoExpand', 'textarea.autoExpand', function(){
            var minRows = 1;
            this.rows = minRows;
            var rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 18);

            if (rows === -0) {
                this.rows = 1;
            } else {
                this.rows = rows;
            }

            console.log(rows);

            if (rows > 1) {
                $(this).parents('.ic-text').find('.ic-inner').css({
                    'height': $(this).height() + 20,
                    'align-items': 'flex-start',
                });

                $(this).css({
                    'height': 'auto',
                    'border-left': 'none',
                });

                $(this).parents('.ic-text').find('.ic-inner .ic-left').css({
                    'align-items': 'flex-start',
                });

                $(this).parents('.ic-text').find('.ic-inner .ic-right').css({
                    'padding-top': '5',
                });
            } else if (rows === 1 || rows === -0) {
                $(this).parents('.ic-text').find('.ic-inner').css({
                    'height': 'auto',
                });
            }
        });

        $('.ic-btn-text').on('click', function () {
           $(this).siblings('.ic-popup-text').removeClass('hidden');
           $(this).siblings('.ic-text-value').empty();
        });

        // $('.ic-popup-text button').on('click', function () {
        //    var $this    = $(this);
        //    var $popup   = $this.parents('.ic-popup-text');
        //    var $val     = $this.siblings('input').val();
        //
        //    $popup.addClass('hidden');
        //    $popup.siblings('.ic-text-value').empty().html($val);
        //    $popup.siblings('.ic-text-input').val($val);
        // });

        $('.ic-popup-text textarea').on('keypress', function (e) {
           var $this    = $(this);
           var $popup   = $this.parents('.ic-popup-text');
           var $val     = $this.val();

            if (e.keyCode === 13) {
                e.preventDefault();

                $popup.addClass('hidden');
                $popup.siblings('.ic-text-value').empty().html($val);
                $popup.siblings('.ic-text-input').val($val);
            }

        });

        createComponentButtonMove($wrapper_text.find('.ic-move'));

    }

    function createComponentButtonMove($el) {
        var $btn_content = [
            '<div class="ic-move-up ic-move-btn"><img src="' + plugin_url + 'assets/Images/worksheet/icon_01_MoveUP.png" /></div>',
            '<div class="ic-move-down ic-move-btn"><img src="' + plugin_url + 'assets/Images/worksheet/icon_02_MoveDOWN.png" /></div>',
            '<div class="ic-move-delete ic-move-btn"><img src="' + plugin_url + 'assets/Images/worksheet/icon_03_Delete.png" /></div>',
        ];

        $($btn_content.join('')).appendTo($el);
    }

    function EventButtonOrder() {
        $('.ic-move-up').unbind('click').bind('click', function() {
            var $com        = $(this).parents('.item-component');

            $com.insertBefore($com.prev());
        });

        $('.ic-move-down').unbind('click').bind('click', function () {
            var $com        = $(this).parents('.item-component');

            $com.insertAfter($com.next());
        });

        $('.ic-move-delete').unbind('click').bind('click', function () {
            var $com        = $(this).parents('.item-component');

            $com.remove();
        });
    }

    $('.btn-ws-mode').on('click', function() {
        var $this   = $(this);
        var $val    = $this.attr('data-type');
        var $p      = $this.parents('.ws-mode');
        var $input  = $p.find('.ws-mode-input');

        $p.find('.btn-ws-mode').removeClass('active');
        $this.addClass('active');
        $input.val($val);
    });

    $('#btn-ws-add-single').on('click', function() {
        WsCreateQuestionSingleAnswer();
    });

    $('.wsq-insert-single').on('click', function () {
        WsCreateQuestionSingleAnswer();
    });

    $('#btn-ws-add-multi').on('click', function () {
        WsCreateQuestionMultiAnswer();
    });

    $('.wsq-insert-multi').on('click', function () {
        WsCreateQuestionMultiAnswer();
    });

    $('.wsq-arrow-left').on('click', function () {
        var $index = $('.ws-questions-number ul').find('.active').attr('data-index');

        if ($index > 1) {
            var $new_index = parseInt($index) - 1;

            $('.ws-questions-number ul').find('li').removeClass('active');
            $('.ws-questions-number ul').find("[data-index='" + $new_index + "']").addClass('active');
            $('#w-panel').find('.item-ws').addClass('hidden');
            $('#ws' + $new_index).removeClass('hidden');
        }
    });

     $('.wsq-arrow-right').on('click', function () {
        var $index = $('.ws-questions-number ul').find('.active').attr('data-index');

        if ($index < $('.ws-questions-number ul').find('li').length) {
            var $new_index = (parseInt($index) + 1);

            $('.ws-questions-number ul').find('li').removeClass('active');
            $('.ws-questions-number ul').find("[data-index='" + $new_index + "']").addClass('active');
            $('#w-panel').find('.item-ws').addClass('hidden');
            $('#ws' + $new_index).removeClass('hidden');
        }
    });

    function WsCreateQuestionSingleAnswer() {
        var $index = $panel.find('.item-ws').length;

        $panel.find('.item-ws').addClass('hidden');
        $('.ws-questions-number ul').find('li').removeClass('active');
        $('.ws-questions-number ul').append('<li class="active" data-index="' + ($index + 1) + '">' + ($index + 1) + '</li>');


        var $item       = $('<div/>', {class: 'item-ws', id: 'ws' + ($index + 1)}).appendTo($panel);
        var $qa         = $('<div/>', {class: 'item-component item-qa'}).appendTo($item);

        var $question           = $('<div/>', {class: 'item-question'}).appendTo($qa);
        var $question_title     = $('<div/>', {class: 'item-title q-title', html: iii_script.question_title + '<div class="ic-move"></div>'}).appendTo($question);
        var $question_input     = $('<input/>', {class: 'txtEditor', name: 'q-txt'}).appendTo($question);

        var $answer             = $('<div/>', {class: 'item-answer'}).appendTo($qa);
        var $answer_title       = $('<p/>', {class: 'item-title a-title', text: iii_script.answer_title}).appendTo($answer);
        var $answer_input       = $('<input/>', {class: 'txtEditor', name: 'a-txt'}).appendTo($answer);

        makeTextEditor($question_input);
        makeTextEditor($answer_input);

        activeTabQuestion();
        createComponent($item);
        createButtonBottomQuestion($item);
        createComponentButtonMove($qa.find('.q-title .ic-move'));
        EventButtonOrder();
    }

    function WsCreateQuestionMultiAnswer() {
        var $index = $panel.find('.item-ws').length;

        $panel.find('.item-ws').addClass('hidden');
        $('.ws-questions-number ul').find('li').removeClass('active');
        $('.ws-questions-number ul').append('<li class="active" data-index="' + ($index + 1) + '">' + ($index + 1) + '</li>');

        var $item       = $('<div/>', {class: 'item-ws', id: 'ws' + ($index + 1)}).appendTo($panel);
        var $qa         = $('<div/>', {class: 'item-component item-qa'}).appendTo($item);

        var $question           = $('<div/>', {class: 'item-question'}).appendTo($qa);
        var $question_title     = $('<div/>', {class: 'item-title q-title', html: iii_script.question_title + '<div class="ic-move"></div>'}).appendTo($question);
        var $question_input     = $('<input/>', {type: 'text', class: 'txtEditor', name: 'q-txt'}).appendTo($question);

        makeTextEditor($question_input);

        var $answer             = $('<div/>', {class: 'item-answer multi-choice'}).appendTo($qa);
        var $answer_title       = $('<p/>', {class: 'item-title a-title', text: iii_script.multi_answer_title}).appendTo($answer);

        var i = null;

        for (i = 1; i <= 6; i++) {
            var $child_answer   = $('<div/>', {id: 'ac-' + i, class: 'item-child'}).appendTo($answer);

            var $switch_answer = [
                '<div class="choice-switch">',
                '<label class="on-off-switch">',
                '<input type="checkbox" />',
                '<span class="on-off-slider"><img src="' + plugin_url + '/assets/Images/worksheet/icon_19_Incorrect_Answer_Switch.png" class="off" /><img class="on" src="' + plugin_url + '/assets/Images/worksheet/icon_18_Correct_Answer_Switch.png" /></span>',
                '</label>',
                '</div>'
            ];

            $($switch_answer.join('')).appendTo($child_answer);

            var $texarea = [
                '<div class="choice-text">',
                '<label>' + iii_script.choice_text + ' ' + i + ':</label>',
                '<textarea></textarea>',
                '</div>'
            ];

            $($texarea.join('')).appendTo($child_answer);


        }

        activeTabQuestion();
        createComponent($item);
        createButtonBottomQuestion($item);
        createComponentButtonMove($qa.find('.q-title .ic-move'));
        EventButtonOrder();
    }

    function createButtonBottomQuestion($item) {
        var $button   = $('<div/>', {class: 'item-btn-bottom'}).appendTo($item);

        var $btn_save_question = [
            '<div class="item-btn-save-question">',
            '<span>' + iii_script.save_question + '</span>',
            '</div>'
        ];

        $($btn_save_question.join('')).appendTo($button);

        // var $btn_add_other_question = [
        //     '<div class="item-btn-add-o-question">',
        //     '<span>' + iii_script.add_other_question + '</span>',
        //     '</div>'
        // ];
        //
        // $($btn_add_other_question.join('')).appendTo($button);

        WordSheetSaveQuestion();
    }
    
    function WordSheetGetDataEachQuestion($wrapper, data) {
        $wrapper.find('.item-component').each(function () {
            var $index = $(this).index();

            if ($(this).find('.ic-text-input').length) {
                data['text_' + $index] = $(this).find('.ic-text-input').val();
            }

            if ($(this).find('.ic-image-input-val').length) {
                data['image_' + $index] = $(this).find('.ic-image-input-val').attr('src');
            }

            if ($(this).find('.ic-video-input').length) {
                data['video_' + $index] = $(this).find('.ic-video-input').val();
            }

            if ($(this).find('.item-question').length) {
                data['question_' + $index] = $(this).find('.item-question .txtEditor').Editor('getText');
            }

            if ($(this).find('.multi-choice').length) {
                var $m = [];

                $(this).find('.multi-choice .item-child').each(function() {
                    if ($(this).find('.choice-switch input').is(':checked')) {
                        $m['choice_' + $(this).index()] = 0;
                    } else {
                        $m['choice_' + $(this).index()] = 1;
                    }

                    $m['text_' + $(this).index()] = $(this).find('.choice-text textarea').val();
                });

                data['multi_choice_' + $index] = $m;
            } else {
                if ($(this).find('.item-answer').length) {
                    data['single_answer_' + $index] = $(this).find('.item-answer .txtEditor').Editor('getText');
                }
            }
        });

        return data;
    }
    
    function WordSheetSaveQuestion() {
        // $('.item-btn-save-question').unbind('click').bind('click', function() {
        //     var $this       = $(this),
        //         $wrapper    = $this.parents('.item-ws');
        //
        //     var data = {};
        //
        //     data = WordSheetGetDataEachQuestion($wrapper, data);
        //
        //     data['action']      = 'iii_notepad_worksheet_save_question';
        //     data['wsid']        = $('.wsid').val();
        //     data['ws_title']    = $('.ws-title-input').val();
        //
        //     var $wrapepr_id     = $wrapper.attr('id');
        //
        //     data['qid']         = $wrapepr_id.replace('ws', '');
        //
        //     $.ajax({
        //         method: 'POST',
        //         url: iii_script.ajax_url,
        //         data: data,
        //         dataType: 'json',
        //         beforeSend: function () {
        //
        //         },
        //         success: function (response) {
        //             if (response.code === 1) {
        //                 alert('Save Question Done');
        //                 $('.wsid').val(response.sheet_id);
        //             } else if (response.code === 2) {
        //                 alert('Update Question Done');
        //             }
        //         }
        //     });
        // });
    }

    $('.item-btn-save-question').on('click', function () {
        var data = {};
        var q   = {};

        $('#w-panel').find('.item-ws').each(function () {
            var each_data = {};

            each_data = WordSheetGetDataEachQuestion($(this), each_data);

            var $wrapepr_id = $(this).attr('id');
            var qid         = $wrapepr_id.replace('ws', '');
            q['qid' + qid]  = each_data;
        });

        data['action']      = 'iii_notepad_worksheet_save_worksheet';
        data['wsid']        = $('.wsid').val();
        data['ws_title']    = $('.ws-title-input').val();
        data['question']    = q;

        $.ajax({
            method: 'POST',
            url: iii_script.ajax_url,
            data: data,
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                if (response.code === 1) {
                    alert('Save Worksheet Done');
                    $('.wsid').val(response.sheet_id);
                } else if (response.code === 2) {
                    alert('Update Worksheet Done');
                }
            }
        });
    });
}

function createCanvas() {
    $("#layers-body li").each(function(i) {
        $(this).addClass("item" + (i + 1));
        $(this).attr("data-cnt", (i + 1));
        $(this).find('span').text((i + 1));

        if ($(this).hasClass('active')) {
            var canvas = cloneCanvas((i + 1), true);

            $('#panel').append(canvas);
            canDraw();
        } else {
            var canvas = cloneCanvas((i + 1));
            $('#panel').append(canvas);
        }
    });
}

function initDraw() {
    $(document).on('click', '.icon-selector', function() {
        var cnt = $(this).attr('data-cnt');

        $('#panel').find('.typing-input').remove();
        $('#add-type-box').removeClass('active');
        $('#math' + cnt).unbind(click_event, TypingCreatTextarea);
        $('#math' + cnt)[0].removeEventListener('touchstart', TypingCreatTextareaTouchDevice);

        if (!$(this).hasClass('active') && !$(this).hasClass('none-visiable')) {
            $("#layers-body li").removeClass('active');
            $(this).addClass('active');
            $('#divrubber').css("visibility", "hidden");
            $("#erasers-body li").removeClass('active');
            //$("#pencils-body li.hr1").addClass('active');

            canDraw();

            $('#yotubeVideo .item-video').addClass('hidden');
            $('#yotubeVideo #video-' + cnt).removeClass('hidden');

            drawVideo();

            $('canvas').removeClass('selected');
            $('#math' + cnt).addClass('active selected');
            $('#math' + cnt).css('visibility', 'visible');
            //$('#math' + cnt).css('z-index', 10);

            if ($('.icon-layer.btn-grid').hasClass('active')) {
                var grid    = $('.icon-layer.btn-grid.active').attr('data-grid');
                var cnv     = $('#math' + cnt);
                var ctxcan  = cnv[0].getContext('2d');


                var bg = getBg();
                if (bg != '') {
                    $('#panel').css('background-color', bg);
                }

                if (grid) {
                    $('#panel').css('background-image', 'url('+ plugin_url + '/assets/Images/grid-' + grid + '.png)')
                }
            }
        } else if ($(this).hasClass('active')) {
            $(this).removeClass('active').addClass('none-visiable');
            $(this).find('img').attr('src', plugin_url + '/assets/Images/Layer_' + (cnt - 3) + '_Not_Visible.png');

            $('#math' + cnt).css('visibility', 'hidden');
            $('#math' + cnt).removeClass('active').addClass('no-visiable');
            //$('#math' + cnt).css('z-index', cnt);
        } else if ($(this).hasClass('none-visiable')) {
            $("#layers-body li").removeClass('active');
            $(this).find('img').attr('src', plugin_url + 'assets/Images/Icons/' + (35 + (cnt - 4)) + '_Layer' + (cnt - 3) + '.png');
            $(this).removeClass('none-visiable').addClass('active');

            $('#math' + cnt).css('visibility', 'visible');
            $('#math' + cnt).removeClass('no-visiable').addClass('active');
            //$('#math' + cnt).css('z-index', cnt);
        }
    });

    $(document).on('click', '.btn-color', function() {
        var cnt     = getCanvas();
        $('#panel').find('.typing-input').remove();
        $('#add-type-box').removeClass('active');
        $('#math' + cnt).unbind(click_event, TypingCreatTextarea);
        $('#math' + cnt)[0].removeEventListener('touchstart', TypingCreatTextareaTouchDevice);

        if (!$(this).hasClass('active')) {
            $("#colors-body li").removeClass('active');
            $(this).addClass('active');
            $('#divrubber').css("display", "none");
            $("#erasers-body li").removeClass('active');
            //$("#pencils-body li.hr1").addClass('active');
            $('#change-color img').attr('src', plugin_url + '/assets/Images/Icons/' + $(this).attr('data-image-url'));
            canDraw();
        }
    });

    $(document).on('click', '.btn-pencil', function() {
        var cnt     = getCanvas();
        $('#panel').find('.typing-input').remove();
        $('#add-type-box').removeClass('active');
        $('#math' + cnt).unbind(click_event, TypingCreatTextarea);
        $('#math' + cnt)[0].removeEventListener('touchstart', TypingCreatTextareaTouchDevice);

        if (!$(this).hasClass('active')) {
            $("#pencils-body li").removeClass('active');
            $("#erasers-body li").removeClass('active');
            $(this).addClass('active');
            $('#divrubber').css("display", "none");
            canDraw();
        }
    });

    $('.btn-eraser').on('click', function () {
        var cnt     = getCanvas();
        $('#panel').find('.typing-input').remove();
        $('#add-type-box').removeClass('active');
        $('#math' + cnt).unbind(click_event, TypingCreatTextarea);
        $('#math' + cnt)[0].removeEventListener('touchstart', TypingCreatTextareaTouchDevice);

        var $this = $(this);

        $("#erasers-body li").removeClass('active');
        //$("#pencils-body li").removeClass('active');
        $this.addClass('active');

        var val = $this.attr('data-eraser');

        $('#divrubber').css({ "display": "block", "width": val + "px", "height": val + "px" });
        $('#controlrubber').removeClass('css-cursor-30 css-cursor-50 css-cursor-70 css-cursor-90 css-cursor-100');
        $('#controlrubber').addClass('css-cursor-' + val);

        canEraser();
    });

    var $z;
    $(document).on('click', '.btn-color-grid', function() {
        var bg      = $(this).attr('data-color');
        var cnt     = getCanvas();
        var can     = $('#math' + cnt);
        var ctxcan  = can[0].getContext('2d');

        $('#panel').find('.typing-input').remove();
        $('#add-type-box').removeClass('active');
        $('#math' + cnt).unbind(click_event, TypingCreatTextarea);
        $('#math' + cnt)[0].removeEventListener('touchstart', TypingCreatTextareaTouchDevice);

        var $x      = $("#grids-body .btn-color-grid.active").length;

        if (!$(this).hasClass('active')) {
            $("#grids-body .btn-color-grid").removeClass('active');
            $(this).addClass('active');

            if ($x === 0) {
                //
            }
            //ctxcan.globalCompositeOperation = "destination-over";
            $('#panel').css('background-color', bg);
            //console.log($z);

            //ctxcan.fillStyle = bg;
            //ctxcan.fillRect(0, 0, can[0].width, can[0].height);
            //ctxcan.globalCompositeOperation = "source-over";
            //ctxcan.globalCompositeOperation = "destination-over";
            var grid = getGrid();
            if (grid != '') {
               //drawGrid(can, parseInt(grid), bg);
               $('#panel').css('background-image', 'url('+ plugin_url + '/assets/Images/grid-' + grid + '.png)');
               //$('canvas').css('background-image', 'url('+ plugin_url + '/assets/Images/grid-' + grid + '.png)');
            }

            //ctxcan.globalCompositeOperation = "source-over";
        }
    });

    $stepGrid = -1;

    $(document).on('click', '.btn-grid', function() {
        var cnt = getCanvas();
        var cnv = $('#math' + cnt);
        var ctxcan = cnv[0].getContext('2d');

        $('#panel').find('.typing-input').remove();
        $('#add-type-box').removeClass('active');
        $('#math' + cnt).unbind(click_event, TypingCreatTextarea);
        $('#math' + cnt)[0].removeEventListener('touchstart', TypingCreatTextareaTouchDevice);

        // $stepGrid++;
        //
        // if ($stepGrid < $state.length) {
        //     $state.length = $stepGrid;
        // }
        //
        // if (!$('.btn-grid').hasClass('active')) {
        //     $state['grid-' + $stepGrid] = cnv[0].toDataURL();
        // }

        // ctxcan.clearRect(0, 0, cnv[0].width, cnv[0].height);
        var bg = getBg();
        if (bg != '') {
            $('#panel').css('background-color', bg);
        }

        if (!$(this).hasClass('active')) {
            $("#grids-body .btn-grid").removeClass('active');
            $(this).addClass('active');

            var grid = $(this).attr('data-grid');
            // ctxcan.globalCompositeOperation = "destination-over";
            // drawGrid(cnv, grid, bg);
            $('#panel').css('background-image', 'url('+ plugin_url + '/assets/Images/grid-' + grid + '.png)');
            //$('canvas').css('background-image', 'url('+ plugin_url + '/assets/Images/grid-' + grid + '.png)');
        } else {
            $(this).removeClass('active');
            $('#panel').css('background-image', '');
            //$('canvas').css('background-image', '');
        }

        // var imgdaclient = new Image();
        // imgdaclient.src = $state['draw'];
        //
        // imgdaclient.onload = function() {
        //     ctxcan.drawImage(imgdaclient, 0, 0);
        // };
        //
        // ctxcan.globalCompositeOperation = "source-over";
    });


    $(document).on('change','#screenshot-check', function(ev) {
    	if (document.getElementById('screenshot-check').checked) {
    		$("#select-screenshot").selectBoxIt('disable');
    		var val = $('#select-screenshotSelectBoxItText').attr('data-val') * 1000;
	    	idtempo = setInterval(function() {
                takepicture();
            }, val);
	    }else{
	    	clearInterval(idtempo);
	    	$("#select-screenshot").selectBoxIt('enable');
	    }
    });
}

function takepicture(e) {
    var cnt     = getCanvas();
    var can     = $('#math' + cnt);
    var datacam = can[0].toDataURL('image/png');
    var socket  = io.connect(url);

    socket.emit('camperaltri', {
        'id': id,
        'positionx': positionx,
        'positiony': positiony,
        'camperaltridati': datacam,
        'room': stanza
    });
}

function drawVideo() {
    var mediaSource = "http://www.youtube.com/watch?v=nOEw9iiopwI";

    var muted = true;

    var cnt     = getCanvas();
    var can     = $('#math' + cnt);
    var ctx     = can[0].getContext("2d");

    var videoContainer;
    var video = $('<video/>', {
        id: '3itest',
    });

    var source = $('<source/>', {
        src: mediaSource,
        type: 'video/youtube'
    }).appendTo(video);

    //video.autoPlay  = false;
   // video.loop      = true;
    //video.muted     = muted;

    videoContainer = {
         video : video,
         ready : false,
    };

    video.appendTo($('body'));

    video.oncanplay = readyToPlayVideo;

    function readyToPlayVideo(event){
        videoContainer.scale = Math.min(4, 3);
        videoContainer.ready = true;

        requestAnimationFrame(updateCanvas);
    }

    function updateCanvas() {
        ctx.clearRect(0,0,can.width,can.height);

        if(videoContainer !== undefined && videoContainer.ready){
            // find the top left of the video on the canvas
            video.muted = muted;
            var scale = videoContainer.scale;
            var vidH = videoContainer.video.videoHeight;
            var vidW = videoContainer.video.videoWidth;
            var top = 200;
            var left = 300;

            // now just draw the video the correct size
            ctx.drawImage(videoContainer.video, left, top, vidW * scale, vidH * scale);
            if(videoContainer.video.paused){ // if not playing show the paused screen
                drawPayIcon();
            }
        }

        // all done for display
        // request the next frame in 1/60th of a second
        requestAnimationFrame(updateCanvas);
    }

    function drawPayIcon(){
         ctx.fillStyle = "black";
         ctx.globalAlpha = 0.5;
         ctx.fillRect(0,0,can.width,can.height);
         ctx.fillStyle = "#DDD";
         ctx.globalAlpha = 0.75;
         ctx.beginPath();
         var size = (can.height / 2) * 0.5;
         ctx.moveTo(can.width/2 + size/2, can.height / 2);
         ctx.lineTo(can.width/2 - size/2, can.height / 2 + size);
         ctx.lineTo(can.width/2 - size/2, can.height / 2 - size);
         ctx.closePath();
         ctx.fill();
         ctx.globalAlpha = 1;
    }

    function playPauseClick(){
         if(videoContainer !== undefined && videoContainer.ready){
              if(videoContainer.video.paused){
                    videoContainer.video.play();
              }else{
                    videoContainer.video.pause();
              }
         }
    }

    can[0].addEventListener("click",playPauseClick);
}

function drawGrid(cnv, grid, bg) {

    if (bg == '#DEDEDE')
        var border = '#c2c2c2';
    else
        var border = '#c2c2c2';

    if (grid == 1) {
        var gridOptions = {
            minorLines: {
                separation: 45,
                color: border
            }
        };
        drawGridLines(cnv, gridOptions.minorLines);
    } else if (grid == 2) {
        var gridOptions = {
            minorLines: {
                separation: 22,
                color: border
            }
        };
        drawGridLines(cnv, gridOptions.minorLines);
    } else {
        var gridOptions = {
            minorLines: {
                separation: 11,
                color: border
            },
            majorLines: {
                separation: 44,
                color: '#B1B1B1'
            }
        };
        drawGridLines(cnv, gridOptions.minorLines);
        drawGridLines(cnv, gridOptions.majorLines);
    }
    return;
}

function drawGridLines(cnv, lineOptions) {
    var iWidth = cnv[0].width;
    var iHeight = cnv[0].height;

    var ctx = cnv[0].getContext('2d');

    ctx.strokeStyle = lineOptions.color;
    ctx.strokeWidth = 1;
    ctx.lineWidth   = 1;

    ctx.beginPath();

    var iCount = null;
    var i = null;
    var x = null;
    var y = null;

    iCount = Math.floor(iWidth / lineOptions.separation);

    for (i = 1; i <= iCount; i++) {
        x = (i * lineOptions.separation);
        ctx.moveTo(x, 0);
        ctx.lineTo(x, iHeight);
        ctx.stroke();
    }

    iCount = Math.floor(iHeight / lineOptions.separation);

    for (i = 1; i <= iCount; i++) {
        y = (i * lineOptions.separation);
        ctx.moveTo(0, y);
        ctx.lineTo(iWidth, y);
        ctx.stroke();
    }

    ctx.closePath();

    return;
}

function addLayer() {
    $(".btn-add-layer").click(function() {
        $('#panel').find('.typing-input').remove();
        var len = $("#layers-body li").length;
        if (len <= 8) {
            $('#layers-body').append('<li class="icon-layer icon-selector item' + (len + 1)
                + '" data-cnt="' + (len + 1) + '"><img src="' + plugin_url + 'assets/Images/Icons/' + (35 + len - 3) + '_Layer' + (len - 2) + '.png"></li>');

            var canvas = cloneCanvas((len + 1));
            $('#panel').append(canvas);

            $('#math' + (len + 1)).css('z-index', (len + 1));

            canDraw();
        }
    });
}

function deleteLayer() {
    $(".btn-delete-layer").click(function() {
        var len = $("#layers-body li").length;
        if (len > 4) {
            $("#math" + len).remove();
            $(".item" + len).remove();
        }
    });
}

function clearState() {
    $(document).on('click', '.btn-eraser-clear', function() {
        $("canvas").each(function(i) {
            if ($(this).hasClass('active')) {
                var can = $(this);
                var ctxcan = can[0].getContext('2d');
                ctxcan.clearRect(0, 0, can[0].width, can[0].height);

                //$("#pencils-body li.hr1").addClass('active');
                $("#erasers-body li").removeClass('active');
                $('#divrubber').css("display", "none");
                canDraw();
            } else {
                $('#divrubber').css("display", "none");
                $("#erasers-body li").removeClass('active');
            }
        });
    });
}

function pad(val) {
    var valString = val + "";
    if (valString.length < 2) {
        return "0" + valString;
    } else {
        return valString;
    }
}

function setTime() {
    ++totalSeconds;
    var time = '-' + pad(parseInt(totalSeconds / 65)) + ':' + pad(totalSeconds % 65);
    $('.time-class').text(time);
}

function fileOnload(e) {
    var img = $('<img>', {
        src: e.target.result
    });
    var socket = io.connect(url);
    var cnt = getCanvas();
    var can = $('#math' + cnt);
    var ctxcan = can[0].getContext('2d');

    // alert(img.src.value);
    // var canvas1 = $('#paper')[0];
    // var context1 = canvas1.getContext('2d');
    img.on('load', function() {
        ctxcan.drawImage(this, positionx, positiony);
        socket.emit('fileperaltri', {
            'id': id,
            'positionx': positionx,
            'positiony': positiony,
            'fileperaltri': e.target.result,
            'room': stanza
        });
    });
}

function canEraser() {
    //username = username.substr(0, 20);
    var socket = io.connect(url);
    var cnt = getCanvas();
    var can = $('#math' + cnt);
    var ctxcan = can[0].getContext('2d');

    can.off();

    divrubber.on('mouseup mouseleave', function(e) {
        drawing = false;
        controlrubber = false;
        dragging = true;
    });

    divrubber.on('mousemove', function(e) {
        var rubbersize = getEraser();

        if (dragging) {
            ctxcan.clearRect(divrubber.position().left, divrubber.position().top, rubbersize + 4, rubbersize + 4);
            controlrubber = true;

            socket.emit('rubber', {
                'x': divrubber.position().left,
                'y': divrubber.position().top,
                'id': id,
                'usernamerem': username,
                'controlrubber': controlrubber,
                'width': rubbersize + 4,
                'height': rubbersize + 4,
                'room': stanza
            });
        }
    });

    divrubber.on('mousedown', function(e) {
        drawing = false;
        dragging = true;
    });
}

function canDraw() {
    var socket = io.connect(url);
    var cnt = getCanvas();
    var can = $('#math' + cnt);
    var ctxcan = can[0].getContext('2d');

    var prev = {};

    // ctx setup
    ctxcan.lineCap = "round";
    ctxcan.lineJoin = "round";
    ctxcan.lineWidth = getPencil();
    ctxcan.font = "20px Tahoma";

    if (ctxcan) {
        $(window).on('resize', function () {
            resizecanvas(can, ctxcan);
        });

        $(window).on('orientationchange', function () {
            resizecanvas(can, ctxcan);
        });
    }

    socket.emit('setuproom', {
        'room': stanza,
        'id': username,
        'usernamerem': username
    });

    socket.on('setuproomserKO', function(data) {
        stanza = data.room;
    });

    socket.on('setuproomser', function(data) {
        stanza = data.room;
    });

    socket.on('doppioclickser', function(data) {
        ctxcan.fillStyle = data.color;
        ctxcan.font = data.fontsizerem + "px Tahoma";
        ctxcan.fillText(data.scrivi, data.x, data.y);
    });

    socket.on('fileperaltriser', function(data) {
        var imgdaclient = new Image();
        imgdaclient.src = data.fileperaltri;
        imgdaclient.onload = function() {
            //	imgdaclient.src = data.fileperaltri;
            ctxcan.drawImage(imgdaclient, data.positionx, data.positiony);
        }
    });

    socket.on('moving', function(data) {
        // if (!(data.id in clients)) {
        //     // a new user has come online. create a cursor for them
        //     cursors[data.id] = $('<div class="cursor"><div class="identif">' + data.usernamerem + '</div>').appendTo('#cursors');
        // }

        // Move the mouse pointer
        // cursors[data.id].css({
        //     'left': data.x,
        //     'top': data.y
        // });

        // Is the user drawing?
        if (data.drawing && clients[data.id]) {
            // Draw a line on the canvas. clients[data.id] holds
            // the previous position of this user's mouse pointer
            ctxcan.strokeStyle = data.color;
            //  drawLinerem(clients[data.id].x, clients[data.id].y, data.x, data.y,data.spessremo,data.color);
            drawLinerem(clients[data.id].x, clients[data.id].y, data.x, data.y, data.spessremo, data.color, ctxcan);
        }

        // Saving the current client state
        clients[data.id] = data;
        clients[data.id].updated = $.now();
    });

    socket.on('toccomoving', function(data) {

        // if (!(data.id in clients)) {
        //     // a new user has come online. create a cursor for them
        //     cursors[data.id] = $('<div class="cursor"><div class="identif">' + data.usernamerem + '</div>').appendTo('#cursors');
        // }

        // Move the mouse pointer
        // Is the user drawing?
        if (data.drawing && clients[data.id]) {

            // cursors[data.id].css({
            //     'left': data.x,
            //     'top': data.y
            // });

            // Draw a line on the canvas. clients[data.id] holds
            // the previous position of this user's mouse pointer
            ctx.strokeStyle = data.color;
            //  drawLinerem(clients[data.id].x, clients[data.id].y, data.x, data.y,data.spessremo,data.color);
            drawLinerem(clients[data.id].x, clients[data.id].y, data.x, data.y, data.spessremo, data.color, ctxcan);
        }

        // Saving the current client state
        clients[data.id] = data;
        clients[data.id].updated = $.now();
    });

    socket.on('rubberser', function(data) {

        // if (!(data.id in clients)) {
        //     // a new user has come online. create a cursor for them
        //     cursors[data.id] = $('<div class="cursor"><div class="identif">' + data.usernamerem + '</div>').appendTo('#cursors');
        // }

        // Move the mouse pointer
        // Is the user drawing?
        if (data.controlrubber && clients[data.id]) {

            cursors[data.id].css({
                'left': data.x,
                'top': data.y
            });
            ctxcan.clearRect(data.x, data.y, data.width, data.height);
        }

        // Saving the current client state
        clients[data.id] = data;
        clients[data.id].updated = $.now();
    });

    //  code to draw on canvas
    $('#panel').on('touchstart', function(e) {
        e.preventDefault();
        getTouchPos();

        socket.emit('mousemove', {
            'x': touchX,
            'y': touchY,
            'drawing': drawing,
            'color': getColor(),
            'id': id,
            'usernamerem': username,
            'spessremo': getPencil(),
            'room': stanza
        });
        $(".cursor").css("zIndex", 6);
        drawing = true;
    }, false);

    $('#panel').on('touchend', function(e) {
        e.preventDefault();
        drawing = false;
        $(".cursor").css("zIndex", 8);
    }, false);

    $('#panel').on('touchmove', function(e) {
        var cnt = getCanvas();
        var can = $('#math' + cnt);
        var ctxcan = can[0].getContext('2d');

        e.preventDefault();
        if ($.now() - lastEmit > 25) {
            if (controlpencil) {
                prev.x = touchX;
                prev.y = touchY;
                getTouchPos();

                drawLineMultiCanvas(prev.x, prev.y, touchX, touchY, ctxcan);

                lastEmit = $.now();
                socket.emit('mousemove', {
                    'x': touchX,
                    'y': touchY,
                    'drawing': drawing,
                    'color': getColor(),
                    'id': id,
                    'usernamerem': username,
                    'spessremo': getPencil(),
                    'room': stanza
                });
            }
        }

    }, false);

    $('#panel').on('mousedown', function(e) {
        e.preventDefault();
        prev.x = e.pageX + 5;
        prev.y = e.pageY - 55;
        socket.emit('mousemove', {
            'x': prev.x,
            'y': prev.y,
            'drawing': drawing,
            'color': getColor(),
            'id': id,
            'usernamerem': username,
            'spessremo': getPencil(),
            'room': stanza
        });
        drawing = true;
        $(".cursor").css("zIndex", 6);
    });

    $('#panel').on('mouseup mouseleave', function(e) {
        if (drawing) {
            drawing = false;
            $(".cursor").css("zIndex", 8);
            history.saveState();

            if (!$('.btn-grid').hasClass('active')) {
                $state['draw'] = can[0].toDataURL();
            }
        }
    });

    $('#panel').on('mousemove', function(e) {
        var cnt = getCanvas();
        var can = $('#math' + cnt);
        var ctxcan = can[0].getContext('2d');

        posmousex = e.pageX + 5;
        posmousey = e.pageY - 65;
        if ($.now() - lastEmit > 25) {
            if (drawing && (controlpencil)) {
                //     ctx.strokeStyle = document.getElementById('minicolore').value;
                drawLineMultiCanvas(prev.x, prev.y, e.pageX + 5, e.pageY - 65, ctxcan);
                prev.x = e.pageX + 5;
                prev.y = e.pageY - 65;
                lastEmit = $.now();
                socket.emit('mousemove', {
                    'x': prev.x,
                    'y': prev.y,
                    'drawing': drawing,
                    'color': getColor(),
                    'id': id,
                    'usernamerem': username,
                    'spessremo': getPencil(),
                    'room': stanza
                });

            }
        }
        // Draw a line for the current user's movement, as it is
        // not received in the socket.on('moving') event above
    });
}

function getCanvas() {
    var cnt = '1';
    $("#layers-body li").each(function(i) {
        if ($(this).hasClass('active')) {
            cnt = $(this).attr('data-cnt');
        }
    });
    return cnt;
}

function getColor() {
    var color = '#000000';
    $("#colors-body li").each(function(i) {
        if ($(this).hasClass('active')) {
            color = $(this).attr('data-color');
        }
    });
    return color;
}

function getPencil() {
    var pencil = '1';
    $("#pencils-body li").each(function(i) {
        if ($(this).hasClass('active')) {
            pencil = $(this).attr('data-pencil');
        }
    });
    return pencil;
}

function getEraser() {
    var eraser = 0;
    $("#erasers-body li").each(function(i) {
        if ($(this).hasClass('active')) {
            eraser = parseInt($(this).attr('data-eraser'));
        }
    });
    return eraser;
}

function getBg() {
    var bg = '';
    $("#grids-body .btn-color-grid").each(function(i) {
        if ($(this).hasClass('active')) {
            bg = $(this).attr('data-color');
        }
    });
    return bg;
}

function getGrid() {
    var grid = '';
    $("#grids-body .btn-grid").each(function(i) {
        if ($(this).hasClass('active')) {
            grid = parseInt($(this).attr('data-grid'));
        }
    });
    return grid;
}

function getTab() {
    var tab = 0;
    $("#tab-chat li").each(function(i) {
        if ($(this).hasClass('active')) {
            tab = parseInt($(this).attr('data-id'));
        }
    });
    return tab;
}

function cloneCanvas(index, active = false) {
    //create a new canvas
    var newCanvas = document.createElement('canvas');
    var context = newCanvas.getContext('2d');

    //set dimensions
    newCanvas.width = $('.main-notepad').width();
    newCanvas.height = $('.main-notepad').height();
    newCanvas.id = "math" + index;

    if (active) {
        newCanvas.className = "math-panel active";
        newCanvas.style.visibility = "visible";
    } else {
        newCanvas.className = "math-panel";
        newCanvas.style.visibility = "hidden";
    }


    //return the new canvas
    return newCanvas;
}

function drawLinerem(fromx, fromy, tox, toy, spessore, colorem, ctx) {
    ctx.strokeStyle = colorem;
    ctx.lineWidth = spessore;
    ctx.beginPath();
    ctx.moveTo(fromx, fromy);
    ctx.lineTo(tox, toy);
    ctx.stroke();
    fromx = tox;
    fromy = toy;
}

function drawLineMultiCanvas(fromx, fromy, tox, toy, ctx) {
    ctx.strokeStyle = getColor();
    ctx.lineWidth = getPencil();
    ctx.beginPath();
    ctx.moveTo(fromx, fromy);
    ctx.lineTo(tox, toy);
    ctx.stroke();
}

function resizecanvas(can, ctxcan) {
    var imgdata = ctxcan.getImageData(0, 0, can[0].width, can[0].height);
    can[0].width = window.innerWidth;
    can[0].height = window.innerHeight + 65;
    ctxcan.putImageData(imgdata, 0, 0);
}

function getTouchPos(e) {
    if (!e)
        var e = event;

    if (e.touches) {
        if (e.touches.length == 1) { // Only deal with one finger
            var touch = e.touches[0]; // Get the information for finger #1
            // touchX=touch.pageX-touch.target.offsetLeft;
            // touchY=touch.pageY-touch.target.offsetTop;
            touchX = touch.pageX - 17;
            touchY = touch.pageY - 95;
        }
    }
}

//Functions of Chat
function initChat() {
    var socket = io.connect(url);

    $(".btn-student").dblclick(function() {
        var id = $(this).attr('data-id');
        var tab = getTab();
        var channels = [];

        $("#tab-chat li").each(function(i) {
            var room = $(this).attr('data-room');
            channels.push('/' + room);
        });
        if (id != tab && cnt < 1) {
            cnt = cnt + 1;
            $('.inbox-message').css("display", "none");

            var username = $(this).attr('data-name');
            var stanza = roomid = 'private' + id;
            var ul = document.createElement('ul');
            ul.id = "testichat" + id;
            ul.className = "inbox-message style-scrollbar";

            var img = document.createElement('img');
            img.id = "closePrivate" + id;
            img.className = "close-private";
            img.src = plugin_url + "assets/icons/icon_CLOSE.png";
            $('#chat').append(img);
            $('#chat').append(ul);

            var testichats = document.getElementById('testichat' + id);

            loadChat(username, roomid, clients, testichats);
            getSubscribe(clients, roomid, testichats);
            if (channels.length) unSubscribe(clients, channels);

            socket.emit('privatemessage', {
                'id': id,
                'roomid': roomid,
                'studentid': id,
                'studentname': username,
                'room': stanza
            });

            $('.all-message').removeClass('active');
            $('.mess-private').removeClass('active');
            $('<li class="item-stt-message mess-private active" data-id="' + id + '" data-name="' + username + '" data-room="' + roomid + '"><p class="text-overfl">' + username + '</p></li>').insertAfter(".all-message");
        }
    });

    $('.prev-message').click(function() {
        var $prev = $('#tab-chat .active').prev();
        if ($prev.length) {
            $('#tab-chat').animate({
                scrollLeft: $prev.position().left
            }, 'slow');
        }
    });

    $('.next-message').click(function() {
        var $next = $('#tab-chat .active').next();
        if ($next.length) {
            $('#tab-chat').animate({
                scrollLeft: $next.position().left
            }, 'slow');
        }
    });

    socket.on('privatecreate', function(data) {
        var channels = [];

        $("#tab-chat li").each(function(i) {
            var room = $(this).attr('data-room');
            channels.push('/' + room);
        });

        $('.inbox-message').css("display", "none");

        var ul = document.createElement('ul');
        ul.id = "testichat" + data.studentid;
        ul.className = "inbox-message style-scrollbar";
        $('#chat').append(ul);
        stanza = data.roomid;

        var testichats = document.getElementById('testichat' + data.studentid);

        loadChat('Tutor', data.roomid, clients, testichats);
        getSubscribe(clients, data.roomid, testichats);
        if (channels.length) unSubscribe(clients, channels);

        $('.all-message').removeClass('active');
        $('.mess-private').removeClass('active');
        $('<li class="item-stt-message mess-private active" data-id="' + data.studentid + '" data-name="' + data.studentname + '" data-room="' + data.roomid + '"><p class="text-overfl">' + data.studentname + '</p></li>').insertAfter(".all-message");
    });
}

function activeTab() {
    $(document).on('click', '.item-stt-message', function() {
        var id = $(this).attr('data-id');
        var channels = [];
        $('.item-stt-message').removeClass('active');
        $('.inbox-message').css("display", "none");
        $(this).addClass('active');
        $("#tab-chat li").each(function(i) {
            if (!$(this).hasClass('active')) {
                var room = $(this).attr('data-room');
                channels.push('/' + room);
            }
        });
        if (id == 0) {
            getSubscribe(clients, stanza, testichat);
            if (channels.length) unSubscribe(clients, channels);
            $('#testichat').css("display", "block");
        } else {
            var username = $(this).attr('data-name');
            var stanza = roomid = $(this).attr('data-room');
            var testichats = document.getElementById('testichat' + id);
            getSubscribe(clients, roomid, testichats);
            if (channels.length) unSubscribe(clients, channels);
            $('#testichat' + id).css("display", "block");
        }
    });
}

function loadChat(username, roomid, client, testichats) {
    var name = username;
    var rooms = roomid;
    var clients = client;
    var testichat = testichats;

    fm.util.addOnLoad(function() {

        //init object chat between users a room 
        var chat = {
            alias: 'Unknown',
            clientId: 0,
            channels: {
                main: '/' + rooms
            },
            dom: {
                chat: {
                    container: document.getElementById('chat'),
                    text: document.getElementById('scrivi'),
                    send: document.getElementById('btn-send'),
                    emoji: document.getElementById('emoji'),
                    username: name,
                    roomid: rooms
                }
            },
            util: {
                start: function() {
                    //console.log(name + ':' + room);
                    chat.alias = name;
                    chat.clientId = rooms;
                    //chat.util.hide(chat.dom.prechat.container);
                    chat.util.show(chat.dom.chat.container);
                    chat.util.scroll();
                    chat.dom.chat.text.focus();
                },
                stopEvent: function(event) {
                    if (event.preventDefault) {
                        event.preventDefault();
                    } else {
                        event.returnValue = false;
                    }
                    if (event.stopPropagation) {
                        event.stopPropagation();
                    } else {
                        event.cancelBubble = true;
                    }
                },
                send: function() {
                    if (chat.util.isEmpty(chat.dom.chat.text)) {
                        chat.util.setInvalid(chat.dom.chat.text);
                    } else {
                        clients.publish({
                            retries: 0,
                            channel: '/' + rooms,
                            data: {
                                alias: chat.alias,
                                text: chat.dom.chat.text.value,
                                emoji: chat.dom.chat.emoji.value
                            },
                            onSuccess: function(args) {
                                chat.util.clear(chat.dom.chat.text);
                            }
                        });
                    }
                },
                show: function(el) {
                    el.style.display = '';
                },
                hide: function(el) {
                    el.style.display = 'none';
                },
                clear: function(el) {
                    el.value = '';
                },
                observe: fm.util.observe,
                isEnter: function(e) {
                    return (e.keyCode == 13);
                },
                isEmpty: function(el) {
                    return (el.value == '');
                },
                setInvalid: function(el) {
                    el.className = 'invalid';
                },
                clearLog: function() {
                    testichat.innerHTML = '';
                },
                logMessage: function(alias, text, me) {
                    var html = '<li';
                    if (me) {
                        html += ' class="item-message"';
                    } else {
                        html += ' class="item-message me"';
                    }
                    html += '><p class="name-sender">' + alias + ':</p><p class="content-mess">' + text + '</p></li>';
                    chat.util.log(html);
                },
                logSuccess: function(text) {
                    chat.util.log('<li class="item-message success"><p class="content-mess">' + text + '</p></li>');
                },
                logFailure: function(text) {
                    chat.util.log('<li class="item-message failure"><p class="content-mess">' + text + '</p></li>');
                },
                log: function(html) {
                    var div = document.createElement('div');
                    div.innerHTML = html;
                    testichat.appendChild(div);
                    chat.util.scroll();
                },
                scroll: function() {
                    testichat.scrollTop = testichat.scrollHeight;
                }
            }
        };

        chat.util.observe(chat.dom.chat.send, 'click', function(e) {
            chat.util.start();
            chat.util.send();
        });

        chat.util.observe(chat.dom.chat.text, 'keydown', function(e) {
            if (chat.util.isEnter(e)) {
                chat.util.start();
                chat.util.send();
                chat.util.stopEvent(e);
            }
        });

        client.setAutoDisconnect({
            synchronous: true
        });

        clients.connect({
            onSuccess: function(args) {
                chat.clientId = args.clientId;
                chat.util.clearLog();
                //chat.util.logSuccess('Connected to WebSync.');
                //chat.util.show(chat.dom.prechat.container);
                chat.util.show(chat.dom.chat.container);
            },
            onFailure: function(args) {
                //var username = args.getData().alias;
                //var content = ''

                //chat.util.logSuccess('Could not connect to WebSync.');
            }
        });
    });
}

function getSubscribe(clients, roomid, testichat) {
    clients.subscribe({
        channel: '/' + roomid,
        onSuccess: function(args) {
            //chat.util.logSuccess('Content chat.');               
            var logs = args.getExtensionValue('logs');
            if (logs != null) {
                for (var i = 0; i < logs.length; i++) {
                    logMessage(logs[i].alias, logs[i].text, false, testichat, logs[i].emoji);
                }
            }
        },
        onFailure: function(args) {
            //chat.util.logSuccess('Not connecting.');
        },
        onReceive: function(args) {
            var ch = args.getChannel();
            console.log(ch);
            logMessage(args.getData().alias, args.getData().text, args.getWasSentByMe(), testichat, args.getData().emoji);
        }
    });
}

function unSubscribe(clients, channels) {
    clients.unsubscribe({
        channels: channels,
        onFailure: function(args) {
            alert(args.error);
        }
    });
}

function logMessage(alias, text, me, testichat, emoji) {
    var html = '<li';
    if (me) {
        html += ' class="item-message"';
    } else {
        html += ' class="item-message me"';
    }
    // <p class="emoji fl">
    //         <img src="assets/Images/Icons/54_Status_Good.png" alt="emoji">
    //     </p>
    var image_patch = plugin_url + 'assets/Images/Icons/';
    var image;

    switch (emoji) {
        case 'fast':
            image = '56_Status_TooFast.png';
            break;
        case 'confused':
            image = '55_Status_Confused.png';
            break;
        case 'understand':
            image = '54_Status_Good.png';
            break;
    }

    html += '><p class="emoji fl"><img src="' + image_patch + image + '" alt="emoji"></p><p class="name-sender">' + alias + ':</p><p class="content-mess">' + text + '</p></li>';
    var div = document.createElement('div');
    div.innerHTML = html;
    testichat.appendChild(div);
    testichat.scrollTop = testichat.scrollHeight;

    if (testichat.scrollHeight > testichat.clientHeight) {
        $(testichat).mCustomScrollbar('destroy');
        $(testichat).mCustomScrollbar();
    }

}

function initVideo() {
    var videoChat = document.getElementById('videoChat');
    var loading = document.getElementById('loading');
    var video = document.getElementById('video');
    var closeVideo = document.getElementById('closeVideo');
    var toggleAudioMute = document.getElementById('toggleAudioMute');
    var toggleVideoMute = document.getElementById('toggleVideoMute');
    var joinSessionButton = document.getElementById('catturacam');

    var app = new Video(testichat);
    var start = function(sessionId, statusVideo = false, statusAudio = true) {
        if (app.sessionId) {
            return;
        }

        if (sessionId.length != 6) {
            console.log('Session ID must be 6 digits long.');
            return;
        }

        app.sessionId = sessionId;

        // Switch the UI context.
        //location.hash = app.sessionId + '&screen=' + (captureScreenCheckbox.checked ? '1' : '0');
        videoChat.style.display = 'block';

        console.log('Joining session ' + app.sessionId + '.');
        //fm.log.info('Joining session ' + app.sessionId + '.');

        // Start the signalling client.
        app.startSignalling(function(error) {
            if (error != null) {
                console.log(error);
                stop();
                return;
            }

            // Start the local media stream.
            app.startLocalMedia(video, false, statusVideo, statusAudio, function(error) {
                if (error != null) {
                    console.log(error);
                    stop();
                    return;
                }

                // Update the UI context.
                loading.style.display = 'none';
                video.style.display = 'block';

                // Enable the media controls.
                //toggleAudioMute.removeAttribute('disabled');
                toggleVideoMute.removeAttribute('disabled');

                // Start the conference.
                app.startConference(function(error) {
                    if (error != null) {
                        console.log(error);
                        stop();
                        return;
                    }

                    // Enable the leave button.
                    //leaveButton.removeAttribute('disabled');

                    //fm.log.info('<span style="font-size: 1.5em;">' + app.sessionId + '</span>');
                    console.log('<span style="font-size: 1.5em;">' + app.sessionId + '</span>');
                }, function() {
                    stop();
                });
            });
        });
    };

    var stop = function() {
        if (!app.sessionId) {
            return;
        }

        // Disable the leave button.
        // leaveButton.setAttribute('disabled', 'disabled');

        console.log('Leaving session ' + app.sessionId + '.');
        //fm.log.info('Leaving session ' + app.sessionId + '.');

        app.sessionId = '';

        $('#catturacam').removeClass('active');

        app.stopConference(function(error) {
            if (error) {
                fm.log.error(error);
            }

            // Disable the media controls.
            //toggleAudioMute.setAttribute('disabled', 'disabled');
            //toggleVideoMute.setAttribute('disabled', 'disabled');

            // Update the UI context.
            video.style.display = 'none';
            loading.style.display = 'block';

            app.stopLocalMedia(function(error) {
                if (error) {
                    fm.log.error(error);
                }

                app.stopSignalling(function(error) {
                    if (error) {
                        fm.log.error(error);
                    }
                    // Switch the UI context.
                    //sessionSelector.style.display = 'block';
                    videoChat.style.display = 'none';
                    location.hash = '';
                });
            });
        });
    };

    // Attach DOM events.
    fm.util.observe(joinSessionButton, 'click', function(evt) {
        stanza = iii_variable.roomid;

        if ($(this).hasClass('active')) {
            videoChat.style.display = 'none';
            $(this).removeClass('active');
            stop();
        } else {
            videoChat.style.display = 'block';
            $(this).addClass('active');
            $(".menu-tray").show("slide", { direction: "right" }, "slow");
            if ($('#toggleAudioMute').hasClass('active'))
                statusAudio = true;
            else
                statusAudio = false;

            if ($('#toggleVideoMute').hasClass('active'))
                statusVideo = true;
            else
                statusVideo = false;

            start(stanza, statusVideo, statusAudio);
        }
    });

    fm.util.observe(closeVideo, 'click', function(evt) {
        videoChat.style.display = 'none';
        $('#catturacam').removeClass('active');
        stop();
    });

    fm.util.observe(window, 'unload', function() {
        stop();
    });

    // function webcame
    var tooglevideomute = 0;
    fm.util.observe(toggleVideoMute, 'click', function(evt) {
        stanza = iii_variable.roomid;
        tooglevideomute++;
        if ($(this).hasClass('active')) {
            var muted = app.toggleVideoMute();
            $(this).children().attr('src', plugin_url + 'assets/Images/Icons/25_Video_OFF.png');
            $(this).removeClass('active');
            videoChat.style.display = 'none';
            $('#catturacam').removeClass('active');
        } else {
            $(this).children().attr('src', plugin_url + 'assets/Images/Icons/24_Video_ON.png');
            $(this).addClass('active');
            //  //////
            if ($('#toggleVideoMute').hasClass('active')) {
                statusVideo = true;
                start(stanza, statusVideo, true);
            } else
                statusVideo = false;


        }

    });
}

window.addEventListener("load", () => {
    function startPosition(e) {
        painting = true;
        draw(e);
    }

    function finishedPosition() {
        painting = false;
        context.beginPath();
    }

    function draw(e) {
        if (!painting) return;
        context.lineWidth = 1;
        // context.strokeStyle = "red";
        context.lineCap = "round";

        context.lineTo(e.clientX, e.clientY);
        context.stroke();
    }

    if ($('#canvas').length) {
        const canvas = document.querySelector('#canvas');
        const context = canvas.getContext("2d");
        //   resizing
        canvas.height = window.innerHeight;
        canvas.width = window.innerWidth;
        //   variables
        let painting = false;

        //   eventListeners
        canvas.addEventListener('mousedown', startPosition);
        canvas.addEventListener('mouseup', finishedPosition);
        canvas.addEventListener('mouseleave', finishedPosition);
        canvas.addEventListener('mousemove', draw);
    }
});