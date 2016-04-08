/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function show_register_dialogbox(){
    $("#wpg").addClass("ui-popup-background-effect2");
    $("#in-register-wrapper").addClass("ui-popup-active");
    $("#in-evt-register-email").focus();
}
function hide_register_dialogbox(){
    $("#wpg").removeClass("ui-popup-background-effect2");
    $("#in-register-wrapper").removeClass("ui-popup-active");
}

function show_resetpassword_dialogbox() {
    $("#wpg, #wpg-signin-wrapper, #wpg-forgotpassword-wrapper, #in-register-wrapper").addClass("ui-popup-background-effect2");
    $("#in-resetpassword-wrapper").addClass("ui-popup-active");
    $("#in-evt-resetpassword-password").focus();
    $("#in-resetpassword-dialogbox").center();
}
function hide_resetpassword_dialogbox() {
    $("#wpg, #wpg-signin-wrapper, #wpg-forgotpassword-wrapper, #in-register-wrapper").removeClass("ui-popup-background-effect2");
    $("#in-resetpassword-wrapper").remove();
}

function reset_registration(){
    $("#in-register-notification-email").addClass("wpg-nodisplay").html("");
    $("#in-register-notification-confpassword").addClass("wpg-nodisplay").html("");
    $("#in-register-notification-password").addClass("wpg-nodisplay");
    $("#in-evt-register-email,#in-evt-register-confpassword,#in-evt-register-password").val("");
}

$(document).ready(function() {
    if($("#in-resetpassword-wrapper").length !== 0 ) {
        show_resetpassword_dialogbox();
    }
});

$(window).on("resize", function() {
    $("#in-register-dialogbox").center();
});

$(document).keydown(function(event) {
    if (event.keyCode === 27) {
        hide_register_dialogbox();
        reset_registration();
        
    }
});

$(document).on("click", "#in-btn-register", function() {
    show_register_dialogbox();
    $("#in-register-dialogbox").center();
});

$(document).on("click", "#in-register-x, #in-register-btn-cancel", function() {
    hide_register_dialogbox();
    reset_registration();
});

$(document).on("blur","#in-evt-register-email,#in-evt-register-confpassword,#in-evt-register-password", function(){
    switch($(this).attr("id")){
        case "in-evt-register-email":
            var goodemail = validate_email($(this).val());
            if(!goodemail && $("#in-evt-register-email").val()!==""){
                $("#in-register-notification-email").removeClass("wpg-nodisplay").html("Please enter a valid email address");
            } else {
                $("#in-register-notification-email").addClass("wpg-nodisplay").html("");
            }
            break;
        case "in-evt-register-confpassword":
            if($(this).val()!==$("#in-evt-register-password").val()){
                $("#in-register-notification-confpassword").removeClass("wpg-nodisplay").html("Please ensure your passwords match");
            } else {
                $("#in-register-notification-confpassword").addClass("wpg-nodisplay").html("");
            }
            break;
        case "in-evt-register-password":
            $("#in-register-notification-password").addClass("wpg-nodisplay");
            break;
    }
});

$(document).on("keyup","#in-evt-register-password",function() {
    if($(this).val()!=="") {
        var entropy = validate_Rentropy($("#in-evt-register-password").val());
        var weak = "<span style=\"color: #f00\">Weak</span>";
        var medium = "<span style=\"color: #ffa600\">Medium</span>";
        var strong = "<span style=\"color: #289f28\">Strong</span>";
        var veryStrong = "<span style=\"color: #0080ff\">Very strong</span>";
        $("#in-register-notification-password").removeClass("wpg-nodisplay").html(entropy<40?weak:entropy<60?medium:entropy<90?strong:veryStrong);
    } else {
        $("#in-register-notification-password").addClass("wpg-nodisplay");
    }
});

$(document).on("click keyup", "#in-register-btn-done", function(event){
    if(event.type === "click" || (event.type === "keyup" && (event.which===13))) {
        if(validate_email($("#in-evt-register-email").val()) && $("#in-evt-register-password").val()===$("#in-evt-register-confpassword").val()) {
            post((location.protocol + '//' + location.host + location.pathname),{
                "register":true,
                "in-evt-register-email":$("#in-evt-register-email").val(),
                "in-evt-register-password":$("#in-evt-register-password").val()
            }, "POST");
        } else {
            $("#in-register-notification-email").removeClass("wpg-nodisplay").html("Please enter a valid email address");
        }
    }
});


$(document).on("click", "#in-resetpassword-x, #in-resetpassword-btn-cancel", function() {
    hide_resetpassword_dialogbox();
});

$(document).on("blur","#in-evt-resetpassword-confpassword, #in-evt-resetpassword-password", function(){
    switch($(this).attr("id")){
        case "in-evt-resetpassword-confpassword":
            if($(this).val()!==$("#in-evt-resetpassword-password").val()){
                $("#in-resetpassword-notification-confpassword").removeClass("wpg-nodisplay").html("Please ensure your passwords match");
            } else {
                $("#in-resetpassword-notification-confpassword").addClass("wpg-nodisplay").html("");
            }
            break;
        case "in-evt-resetpassword-password":
            $("#in-resetpassword-notification-password").addClass("wpg-nodisplay");
            break;
    }
});

$(document).on("keyup","#in-evt-resetpassword-password",function() {
    if($(this).val()!=="") {
        var entropy = validate_Rentropy($("#in-evt-resetpassword-password").val());
        var weak = "<span style=\"color: #f00\">Weak</span>";
        var medium = "<span style=\"color: #ffa600\">Medium</span>";
        var strong = "<span style=\"color: #289f28\">Strong</span>";
        var veryStrong = "<span style=\"color: #0080ff\">Very strong</span>";
        $("#in-resetpassword-notification-password").removeClass("wpg-nodisplay").html(entropy<40?weak:entropy<60?medium:entropy<90?strong:veryStrong);
    } else {
        $("#in-resetpassword-notification-password").addClass("wpg-nodisplay");
    }
});

$(document).on("click keyup", "#in-resetpassword-btn-done", function(event){
    if(event.type === "click" || (event.type === "keyup" && (event.which===13))) {
        if($("#in-evt-resetpassword-password").val()===$("#in-evt-resetpassword-confpassword").val()) {
            var txTokenid = $("#in-resetpassword-dialogbox").attr("data-token");
            var password = $("#in-evt-resetpassword-password").val();
            hide_resetpassword_dialogbox();
            post((location.protocol + '//' + location.host + location.pathname),{
                "resetpassword":true,
                "txTokenid":txTokenid,
                "in-evt-resetpassword-password":password
            }, "POST");
        }
    }
});

$(document).on("keyup", "#in-evt-resetpassword-confpassword", function(event){
    if(event.which===13) {
        if($("#in-evt-resetpassword-password").val()===$("#in-evt-resetpassword-confpassword").val()) {
            var txTokenid = $("#in-resetpassword-dialogbox").attr("data-token");
            var password = $("#in-evt-resetpassword-password").val();
            hide_resetpassword_dialogbox();
            post((location.protocol + '//' + location.host + location.pathname),{
                "resetpassword":true,
                "txTokenid":txTokenid,
                "in-evt-resetpassword-password":password
            }, "POST");
        }
    }
});
