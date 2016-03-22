/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function show_register_dialogbox(){
    $("#wpg").addClass("ui-popup-background-effect2");
    $("#in-register-wrapper").addClass("ui-popup-active");
}
function hide_register_dialogbox(){
    $("#wpg").removeClass("ui-popup-background-effect2");
    $("#in-register-wrapper").removeClass("ui-popup-active");
}
function reset_registration(){
    $("#in-register-notification-email").addClass("wpg-nodisplay").html("");
    $("#in-register-notification-confpassword").addClass("wpg-nodisplay").html("");
    $("#in-register-notification-password").addClass("wpg-nodisplay");
    $("#in-evt-register-email,#in-evt-register-confpassword,#in-evt-register-password").val("");
}

$(document).on("click", "#in-btn-register", function() {
    show_register_dialogbox();
    $("#in-register-dialogbox").center();
});

$(document).on("click", "#in-register-x, #in-register-btn-cancel", function() {
    hide_register_dialogbox();
    reset_registration();
});

$(document).on("blur","#in-evt-register-email,#in-evt-register-confpassword", function(){
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