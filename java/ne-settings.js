/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var settingsset = false;

$(function(){
    $("#ne-evt-settings-maxdate").datepicker({ dateformat: "mm/dd/yy"});
});

jQuery.fn.center = function(parent) {
    if (parent) {
        parent = this.parent();
    } else {
        parent = window;
    }
    this.css({
        "position": "absolute",
        "top": ((($(parent).height() - this.outerHeight()) / 2) + $(parent).scrollTop() + "px"),
        "left": ((($(parent).width() - this.outerWidth()) / 2) + $(parent).scrollLeft() + "px")
    });
return this;
};

function show_settings_dialogbox(){
    $("#wpg").addClass("ui-popup-background-effect");
    $("#ne-settings-wrapper").addClass("ui-popup-active");
    $("#ne-settings-dialogbox").center();
}
function hide_settings_dialogbox(){
    $("#wpg").removeClass("ui-popup-background-effect");
    $("#ne-settings-wrapper").removeClass("ui-popup-active");
    if(settingsset){
//        settings_reset();
    }
}
function toggle_settings_extensions(){
    if($(this).is(":checked")) {
        $(this).parent().siblings("table").removeClass("wpg-nodisplay");
    } else {
        $(this).parent().siblings("table").addClass("wpg-nodisplay");
    }
    $("#ne-settings-dialogbox").center();
}
function reset_settings(){
    $("#ne-evt-settingsbox").prop("checked", false);
    $("#ne-evt-settings-usedefault").prop("checked", true);
    $("#ne-evt-settings-attendancegate,#ne-evt-settings-blacklistgate,#ne-evt-settings-daygate,"+
        "#ne-evt-settings-durationgate,#ne-evt-settings-locationgate,#ne-evt-settings-repeatgate,"+
        "#ne-evt-settings-timegate").prop("checked", false).prop("disabled", true);
    $("#ne-evt-settings-attendeesallow,#ne-evt-settings-dayallow,#ne-evt-settings-durationallow,"+
        "#ne-evt-settings-locationallow,#ne-evt-settings-repeatsallow,#ne-evt-settings-timeallow").prop("checked", true);
    $("#ne-evt-settings-blacklistdays-0,#ne-evt-settings-blacklistdays-1,#ne-evt-settings-blacklistdays-2,"+
            "#ne-evt-settings-blacklistdays-3,#ne-evt-settings-blacklistdays-4,#ne-evt-settings-blacklistdays-5,"+
            "#ne-evt-settings-blacklistdays-6").prop("checked", false);
    $("#ne-settings-attendees-table,#ne-settings-blacklist-table,#ne-settings-day-table,"+
            "#ne-settings-duration-table,#ne-settings-location-table,#ne-settings-repeats-table,"+
            "#ne-settings-time-table").addClass("wpg-nodisplay");
    $("#ne-evt-settings-repeatsmin").val("1");
    $("#ne-evt-settings-minduration").val("00:30");
    $("#ne-evt-settings-blackliststart").val("12:00am");
    $("#ne-evt-settings-blacklistend").val("11:59pm");
}

$(document).ready(function(){
    reset_settings();
});

$(document).on("click", "#ne-evt-settingsbox", function(){
    if($("#ne-evt-settingsbox").is(":checked") && !settingsset){
        reset_settings();
        show_settings_dialogbox();
    } else if($("#ne-evt-settingsbox").is(":checked") && settingsset) {
        $("#ne-settings-edit").removeClass("wpg-nodisplay");
        $("#ne-settings-display").removeClass("wpg-nodisplay");
        $("#ne-label-settingsbox").html("Advanced settings: ");
    } else if(!$("#ne-evt-settingsbox").is(":checked") && settingsset){
        $("#ne-settings-edit").addClass("wpg-nodisplay");
        $("#ne-settings-display").addClass("wpg-nodisplay");
        $("#ne-label-settingsbox").html("Advanced settings");
    }
    
});

$(document).on("click", "#ne-settings-x, #ne-settings-btn-cancel", function(){
    hide_settings_dialogbox();
    if(!settingsset){
        $("#ne-evt-settingsbox").prop("checked", false);
    }
});

$(document).on("click", "#ne-settings-btn-done", function(){
    if(!$("#ne-evt-settings-usedefault").is(":checked")) {
        settingsset = true;
        $("#ne-evt-settingsbox").prop("checked", true);
        $("#ne-settings-edit").removeClass("wpg-nodisplay");
        $("#ne-settings-display").removeClass("wpg-nodisplay");
        $("#ne-label-settingsbox").html("Advanced settings: ");
    } else {
        settingsset = false;
        $("#ne-evt-settingsbox").prop("checked", false);
        $("#ne-settings-edit").addClass("wpg-nodisplay");
        $("#ne-settings-display").addClass("wpg-nodisplay");
        $("#ne-label-settingsbox").html("Advanced settings");
    }
    hide_settings_dialogbox();
});

$(document).on("click", "#ne-evt-settings-usedefault", function(){
    if($(this).is(":checked")){
        $("#ne-evt-settings-attendancegate,#ne-evt-settings-blacklistgate,#ne-evt-settings-daygate,"+
        "#ne-evt-settings-durationgate,#ne-evt-settings-locationgate,#ne-evt-settings-repeatgate,"+
        "#ne-evt-settings-timegate").prop("checked", false).prop("disabled", true).change();
    } else {
        $("#ne-evt-settings-attendancegate,#ne-evt-settings-blacklistgate,#ne-evt-settings-daygate,"+
        "#ne-evt-settings-durationgate,#ne-evt-settings-locationgate,#ne-evt-settings-repeatgate,"+
        "#ne-evt-settings-timegate").prop("disabled", false);
    }
});

$(document).on("change", "#ne-evt-settings-attendancegate,#ne-evt-settings-blacklistgate,#ne-evt-settings-daygate,"+
                        "#ne-evt-settings-durationgate,#ne-evt-settings-locationgate,#ne-evt-settings-repeatgate,"+
                        "#ne-evt-settings-timegate", toggle_settings_extensions);

$(document).on("click", "#ne-settings-edit", function(){
    show_settings_dialogbox();
});

$(document).on("click", "#ne-btn-test", function(){
    
    var guest = $("#ne-container-guests");
    
    var guestpos = guest.offset();
    var guestwidth = guest.width();
    var guestheight = guest.height();
    
    $("#test-top").width("100%").height(guestpos.top+"px").position({top: 0, left: 0});
    $("#test-bottom").width("100%").height("calc(100% - "+(guestpos.top+guestheight)+"px)").position({top: (guestpos.top+guestheight), left: 0});
    $("#test-left").width(guestpos.left+"px").height("100%").position({top: 0, left: 0});
    $("#test-right").width().height("100%").position({top: 0, left: (guestpos.left+guestwidth)});
    
    $("#test-top,#test-bottom,#test-left,#test-right").css("background-color", "#f00");
});

$(document).ready(function () {
    frost = function () {
        var w = $('#main-view').width();
        html2canvas(document.body, {
            onrendered: function (canvas) {
                document.body.appendChild(canvas);
                $('canvas').wrap('<div id="contain" />');
            },
            width: w,
            height: 30
        });
        $('canvas, #partial-overlay, #cover').hide();
        $('#cover').fadeIn('slow', function () {
            $('#partial-overlay').fadeIn('slow');
        });
    };

    $('body').append('<div id="cover"></div><svg id="svg-image-blur"><filter id="blur-effect-1"><feGaussianBlur stdDeviation="2"/></filter></svg>');

    $('#main-view').click(function () {
        frost();
        $('#partial-overlay').addClass('vis');
        $(window).resize(function () {
            $('canvas, #partial-overlay, #cover').hide();
        });

        function onResize() {
            if ($('#partial-overlay').hasClass('vis')) {
                frost();
            }
        }
        var timer;
        $(window).bind('resize', function () {
            timer && clearTimeout(timer);
            timer = setTimeout(onResize, 50);
        });

    });

    $('#partial-overlay').click(function () {
        $('#partial-overlay').removeClass('vis');
        $('canvas, #partial-overlay, #cover').hide();
    });
});