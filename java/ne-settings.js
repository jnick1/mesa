/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var settingsset = false;

function show_settings_dialogbox(){
    $("#wpg").addClass("ui-popup-background-effect");
    $("#ne-settings-wrapper").addClass("ui-popup-active");
}
function hide_settings_dialogbox(){
    $("#wpg").removeClass("ui-popup-background-effect");
    $("#ne-settings-wrapper").removeClass("ui-popup-active");
    if(settingsset){
//        settings_reset();
    }
}
function reset_settings(){
    $("#ne-evt-settingsbox").prop("checked", false);
    $("#ne-evt-settings-usedefault").prop("checked", true);
}

$(document).ready(function(){
    reset_settings();
});

$(document).on("click", "#ne-evt-settingsbox", function(){
    if($("#ne-evt-settingsbox").is(":checked") && !settingsset){
        reset_settings();
        show_settings_dialogbox();
    } else if($("#ne-evt-settingsbox").is(":checked") && settingsset) {
        show_settings_dialogbox();
    }
});

$(document).on("click", "#ne-settings-x", function(){
    hide_settings_dialogbox();
    if(!settingsset){
        $("#ne-evt-settingsbox").prop("checked", false);
    }
});