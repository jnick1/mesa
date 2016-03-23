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
function show_signin_dialogbox(){
    $("#wpg").addClass("ui-popup-background-effect2");
    $("#in-signin-wrapper").addClass("ui-popup-active");
    $("#in-evt-signin-email").focus();
}
function hide_signin_dialogbox(){
    $("#wpg").removeClass("ui-popup-background-effect2");
    $("#in-signin-wrapper").removeClass("ui-popup-active");
}
function reset_registration(){
    $("#in-register-notification-email").addClass("wpg-nodisplay").html("");
    $("#in-register-notification-confpassword").addClass("wpg-nodisplay").html("");
    $("#in-register-notification-password").addClass("wpg-nodisplay");
    $("#in-evt-register-email,#in-evt-register-confpassword,#in-evt-register-password").val("");
}
function reset_signin(){
    $("#in-signin-notification-email").addClass("wpg-nodisplay").html("");
    $("#in-signin-notification-password").addClass("wpg-nodisplay");
    $("#in-evt-signin-email,#in-evt-signin-password").val("");
}

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
    if($(this).val()!=="") { //need to implement real password strength checker here
        var temp = Math.floor(Math.random()*3)+1;
        $("#in-register-notification-password").removeClass("wpg-nodisplay").html(temp===1?"Weak":temp===2?"Medium":"Hard");
    } else {
        $("#in-register-notification-password").addClass("wpg-nodisplay");
    }
});

$(document).on("click keyup", "#in-register-btn-done", function(event){
    if(event.type === "click" || (event.type === "keyup" && (event.which===13))) {
        if(validate_email($("#in-evt-register-email").val()) && $("#in-evt-register-password").val()===$("#in-evt-register-confpassword").val()) {
            post("#",{
                "register":true,
                "in-evt-register-email":$("#in-evt-register-email").val(),
                "in-evt-register-password":$("#in-evt-register-password").val()
            }, "POST");
        } else {
            $("#in-register-notification-email").removeClass("wpg-nodisplay").html("Please enter a valid email address");
        }
    }
});



$(document).on("click", "#wpg-header-btn-signin", function() {
    show_signin_dialogbox();
    $("#in-signin-dialogbox").center();
});

$(document).on("click", "#in-signin-x, #in-signin-btn-cancel", function() {
    hide_signin_dialogbox();
    reset_signin();
});

$(document).on("blur","#in-evt-signin-email,#in-evt-signin-password", function(){
    switch($(this).attr("id")){
        case "in-evt-signin-email":
            var goodemail = validate_email($(this).val());
            if(!goodemail && $("#in-evt-signin-email").val()!==""){
                $("#in-signin-notification-email").removeClass("wpg-nodisplay").html("Please enter a valid email address");
            } else {
                $("#in-signin-notification-email").addClass("wpg-nodisplay").html("");
            }
            break;
        case "in-evt-signin-password":
            $("#in-signin-notification-password").addClass("wpg-nodisplay");
            break;
    }
});

$(document).on("click keyup", "#in-signin-btn-done", function(event){
    if(event.type === "click" || (event.type === "keyup" && (event.which===13))) {
        if(validate_email($("#in-evt-signin-email").val())) {
            post("#",{
                "signin":true,
                "in-evt-signin-email":$("#in-evt-signin-email").val(),
                "in-evt-signin-password":$("#in-evt-signin-password").val()
            }, "POST");
        } else {
            $("#in-signin-notification-email").removeClass("wpg-nodisplay").html("Please enter a valid email address");
        }
    }
});
