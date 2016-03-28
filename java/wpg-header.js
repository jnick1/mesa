/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function show_signin_dialogbox(){
    $("#wpg").addClass("ui-popup-background-effect2");
    $("#wpg-signin-wrapper").addClass("ui-popup-active");
    $("#wpg-evt-signin-email").focus();
}
function hide_signin_dialogbox(){
    $("#wpg").removeClass("ui-popup-background-effect2");
    $("#wpg-signin-wrapper").removeClass("ui-popup-active");
}

function show_account_dialogbox(){
    if($(location).attr("pathname").endsWith("newevent.php")) {
        $("#wpg").addClass("ui-popup-background-effect");
    } else {
        $("#wpg").addClass("ui-popup-background-effect2");
    }
    $("#wpg-account-wrapper").addClass("ui-popup-active");
}
function hide_account_dialogbox(){
    $("#wpg").removeClass("ui-popup-background-effect2 ui-popup-background-effect");
    $("#wpg-account-wrapper").removeClass("ui-popup-active");
}

function show_account_delete_dialogbox(){
    if($(location).attr("pathname").endsWith("newevent.php")) {
        $("#wpg-account-wrapper").addClass("ui-popup-background-effect");
    } else {
        $("#wpg-account-wrapper").addClass("ui-popup-background-effect2");
    }
    $("#wpg-account-delete-wrapper").addClass("ui-popup-active");
}
function hide_account_delete_dialogbox(){
    $("#wpg-account-wrapper").removeClass("ui-popup-background-effect2 ui-popup-background-effect");
    $("#wpg-account-delete-wrapper").removeClass("ui-popup-active");
}

function reset_signin(){
    $("#wpg-signin-notification-email").addClass("wpg-nodisplay").html("");
    $("#wpg-signin-notification-password").addClass("wpg-nodisplay");
    $("#wpg-evt-signin-email,#wpg-evt-signin-password").val("");
}

$(window).on("resize", function(){
    $("#wpg-signin-dialogbox").center();
    $("#wpg-account-dialogbox").center();
    $("#wpg-account-delete-dialogbox").center();
});

$(document).keydown(function(event) {
    if (event.keyCode === 27) {
        hide_signin_dialogbox();
        hide_account_dialogbox();
        hide_account_delete_dialogbox();
        reset_signin();
    }
});



$(document).on("click", "#wpg-header-myaccount", function(){
    show_account_dialogbox();
    $("#wpg-account-dialogbox").center();
});

$(document).on("click", "#wpg-account-x, #wpg-account-btn-cancel", function() {
    hide_account_dialogbox();
});

$(document).on("click keyup", "#wpg-account-btn-changeemail", function(event) {
    if(event.type === "click" || (event.type === "keyup" && (event.which===13))) {
        if(validate_email($("#wpg-evt-account-email").val())){
            var parameters = {
                "changeemail":true,
                "wpg-evt-account-email":$("#wpg-evt-account-email").val()
            };
            post("#",parameters,"POST");
        } else {
            $("#wpg-signin-notification-email").removeClass("wpg-nodisplay").html("Please enter a valid email address");
        }
    }
    
});

$(document).on("click keyup", "#wpg-account-btn-resetpassword", function(event) {
    if(event.type === "click" || (event.type === "keyup" && (event.which===13))) {
        if($("#wpg-evt-account-newpassword").val()===$("#wpg-evt-account-confirmnewpassword").val()) {
            post("#",{
                "changepassword":true,
                "wpg-evt-account-password":$("#wpg-evt-account-password").val(),
                "wpg-evt-account-newpassword":$("#wpg-evt-account-newpassword").val()
            }, "POST");
        } else {
            $("#wpg-account-notification-confirmnewpassword").removeClass("wpg-nodisplay").html("Please ensure your passwords match");
        }
    }
});

$(document).on("blur","#wpg-evt-account-email,#wpg-evt-account-newpassword,#wpg-evt-account-confirmnewpassword", function(){
    switch($(this).attr("id")){
        case "wpg-evt-account-email":
            var goodemail = validate_email($(this).val());
            if(!goodemail && $("#wpg-evt-account-email").val()!==""){
                $("#wpg-account-notification-email").removeClass("wpg-nodisplay").html("Please enter a valid email address");
            } else {
                $("#wpg-account-notification-email").addClass("wpg-nodisplay").html("");
            }
            break;
        case "wpg-evt-account-confirmnewpassword":
            if($(this).val()!==$("#wpg-evt-account-newpassword").val()){
                $("#wpg-account-notification-confirmnewpassword").removeClass("wpg-nodisplay").html("Please ensure your passwords match");
            } else {
                $("#wpg-account-notification-confirmnewpassword").addClass("wpg-nodisplay").html("");
            }
            break;
        case "wpg-evt-account-newpassword":
            $("#wpg-account-notification-newpassword").addClass("wpg-nodisplay");
            break;
    }
});

$(document).on("keyup","#wpg-evt-account-newpassword",function() {
    if($(this).val()!=="") { //need to implement real password strength checker here
        var temp = Math.floor(Math.random()*3)+1;
        $("#wpg-account-notification-newpassword").removeClass("wpg-nodisplay").html(temp===1?"Weak":temp===2?"Medium":"Hard");
    } else {
        $("#wpg-account-notification-newpassword").addClass("wpg-nodisplay");
    }
});



$(document).on("click", "#wpg-header-btn-signout", function() {
    post("#",{
        "signout":true
    }, "POST");
});

$(document).on("click", "#wpg-header-btn-signin", function() {
    show_signin_dialogbox();
    $("#wpg-signin-dialogbox").center();
});

$(document).on("click", "#wpg-signin-x, #wpg-signin-btn-cancel", function() {
    hide_signin_dialogbox();
    reset_signin();
});

$(document).on("blur","#wpg-evt-signin-email,#wpg-evt-signin-password", function(){
    switch($(this).attr("id")){
        case "in-evt-signin-email":
            var goodemail = validate_email($(this).val());
            if(!goodemail && $("#wpg-evt-signin-email").val()!==""){
                $("#wpg-signin-notification-email").removeClass("wpg-nodisplay").html("Please enter a valid email address");
            } else {
                $("#wpg-signin-notification-email").addClass("wpg-nodisplay").html("");
            }
            break;
        case "in-evt-signin-password":
            $("#wpg-signin-notification-password").addClass("wpg-nodisplay");
            break;
    }
});

$(document).on("click keyup", "#wpg-signin-btn-done", function(event){
    if(event.type === "click" || (event.type === "keyup" && (event.which===13))) {
        if(validate_email($("#wpg-evt-signin-email").val())) {
            post("#",{
                "signin":true,
                "in-evt-signin-email":$("#wpg-evt-signin-email").val(),
                "in-evt-signin-password":$("#wpg-evt-signin-password").val()
            }, "POST");
        } else {
            $("#wpg-signin-notification-email").removeClass("wpg-nodisplay").html("Please enter a valid email address");
        }
    }
});



$(document).on("click", "#wpg-account-delete-link", function(){
    show_account_delete_dialogbox();
    $("#wpg-account-delete-dialogbox").center();
});

$(document).on("click", "#wpg-account-delete-x, #wpg-account-delete-btn-cancel", function(){
    hide_account_delete_dialogbox();
});

$(document).on("click", "#wpg-account-delete-btn-yes", function() {
    var parameters = {
        "deleteaccount":true
    };
    post("#",parameters,"POST");
});

/*
//for My Events dropdown arrow
//$(document).on("mouseenter mouseleave","#wpg-header-myevents", function() {
//    var arrow = $("#wpg-header-myevents-dropdown-arrow");
//    if(arrow.hasClass("goog-icon-dropdown-arrow-left")) {
//        arrow.removeClass("goog-icon-dropdown-arrow-left").addClass("goog-icon-dropdown-arrow-down");
//    } else {
//        arrow.removeClass("goog-icon-dropdown-arrow-down").addClass("goog-icon-dropdown-arrow-left");
//    }
//});*/