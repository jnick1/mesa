/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var settingsset = false;
var settingsstate = {};

$(function(){
    $("#ne-evt-settings-maxdate").datepicker({ dateformat: "mm/dd/yy"});
});

function show_settings_dialogbox(){
    $("#wpg").addClass("ui-popup-background-effect");
    $("#ne-settings-wrapper").addClass("ui-popup-active");
    $("#ne-settings-dialogbox").center();
}
function hide_settings_dialogbox(){
    $("#wpg").removeClass("ui-popup-background-effect");
    $("#ne-settings-wrapper").removeClass("ui-popup-active");
}
function toggle_settings_extensions(){
    if($(this).is(":checked")) {
        $(this).parent().siblings("table").removeClass("wpg-nodisplay");
    } else {
        $(this).parent().siblings("table").addClass("wpg-nodisplay");
    }
    $("#ne-settings-dialogbox").center();
}
function toggle_inner_settings(){
    if($(this).is(":checked")) {
        $(this).parent().parent().parent().siblings("tr").removeClass("wpg-nodisplay");
    } else {
        $(this).parent().parent().parent().siblings("tr").addClass("wpg-nodisplay");
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
    $("#ne-settings-supertable table table").addClass("wpg-nodisplay");
    $("#ne-settings-supertable table table tr").removeClass("wpg-nodisplay");
    $("#ne-evt-settings-repeatsmin").val("1");
    $("#ne-evt-settings-repeatsconstant").prop("checked",false);
    $("#ne-evt-settings-minduration").val("00:30");
    $("#ne-evt-settings-blackliststart").val("12:00am");
    $("#ne-evt-settings-blacklistend").val("11:59pm");
    $("#ne-evt-settings-attendeesnomiss").val("1");
    $("#ne-evt-settings-maxdate").val("");
    $("input[id$='prior-low'").prop("checked",true);
    $("#ne-settings-repetition-annotation").addClass("wpg-nodisplay").removeClass("ui-container-block");
    $("#ne-settings-display").addClass("wpg-nodisplay");
    $("#ne-settings-edit").addClass("wpg-nodisplay");
    $("#ne-label-settingsbox").html("Advanced settings");
}

$(document).ready(function(){
    if($("#wpg").attr("data-eventid")) {
        settingsset = true;
        save_state("#ne-settings-wrapper", settingsstate);
    } else {
        reset_settings();
        save_state("#ne-settings-wrapper", settingsstate);
    }
});

$(document).on("click", "#ne-evt-settingsbox", function(){
    if($("#ne-evt-settingsbox").is(":checked") && !settingsset){
        reset_state("#ne-settings-wrapper", settingsstate);
        $("#ne-settings-repetition-annotation").removeClass("ui-container-block");
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
    if(Object.keys(settingsstate).length!==0){
        reset_state("#ne-settings-wrapper", settingsstate);
    }
});

$(document).on("click", "#ne-settings-btn-done", function(){
    var gates = $("#ne-evt-settings-attendancegate:checked,#ne-evt-settings-blacklistgate:checked,#ne-evt-settings-daygate:checked,"+
        "#ne-evt-settings-durationgate:checked,#ne-evt-settings-locationgate:checked,#ne-evt-settings-repeatgate:checked,"+
        "#ne-evt-settings-timegate:checked");
    if(!$("#ne-evt-settings-usedefault").is(":checked") && gates.length !== 0) {
        settingsset = true;
        $("#ne-evt-settingsbox").prop("checked", true);
        $("#ne-settings-edit").removeClass("wpg-nodisplay");
        $("#ne-settings-display").removeClass("wpg-nodisplay");
        $("#ne-label-settingsbox").html("Advanced settings: ");
    } else {
        settingsset = false;
        $("#ne-evt-settings-usedefault").prop("checked",true);
        $("#ne-evt-settingsbox").prop("checked", false);
        $("#ne-settings-edit").addClass("wpg-nodisplay");
        $("#ne-settings-display").addClass("wpg-nodisplay");
        $("#ne-label-settingsbox").html("Advanced settings");
    }
    save_state("#ne-settings-wrapper", settingsstate);
    hide_settings_dialogbox();
});

$(document).on("click", "#ne-evt-settings-usedefault", function(){
    if($(this).is(":checked")){
        $("#ne-evt-settings-attendancegate,#ne-evt-settings-blacklistgate,#ne-evt-settings-daygate,"+
        "#ne-evt-settings-durationgate,#ne-evt-settings-locationgate,#ne-evt-settings-repeatgate,"+
        "#ne-evt-settings-timegate").prop("checked", false).prop("disabled", true).change();
        $("#ne-settings-repetition-annotation").addClass("wpg-nodisplay").removeClass("ui-container-block");
    } else {
        $("#ne-evt-settings-attendancegate,#ne-evt-settings-blacklistgate,#ne-evt-settings-daygate,"+
        "#ne-evt-settings-durationgate,#ne-evt-settings-locationgate,#ne-evt-settings-timegate").prop("disabled", false);
        if($("#ne-evt-repeatbox").is(":checked")) {
            $("#ne-evt-settings-repeatgate").prop("disabled", false);
            $("#ne-settings-repetition-annotation").addClass("wpg-nodisplay").removeClass("ui-container-block");
        } else {
            $("#ne-settings-repetition-annotation").removeClass("wpg-nodisplay").addClass("ui-container-block");
        }
    }
});

$(document).on("change", "#ne-evt-settings-attendancegate,#ne-evt-settings-blacklistgate,#ne-evt-settings-daygate,"+
                        "#ne-evt-settings-durationgate,#ne-evt-settings-locationgate,#ne-evt-settings-repeatgate,"+
                        "#ne-evt-settings-timegate", toggle_settings_extensions);
                
$(document).on("change", "#ne-evt-settings-timeallow,#ne-evt-settings-dayallow,#ne-evt-settings-durationallow,"+
        "#ne-evt-settings-repeatsallow,#ne-evt-settings-locationallow,#ne-evt-settings-attendeesallow", toggle_inner_settings);

$(document).on("click", "#ne-settings-edit", function(){
    show_settings_dialogbox();
});

$(document).on("blur", "#ne-evt-settings-maxdate,#ne-evt-settings-minduration,#ne-evt-settings-repeatsmin,"+
        "#ne-evt-settings-blackliststart,#ne-evt-settings-blacklistend,#ne-evt-settings-attendeesnomiss", function(){
    switch($(this).attr("id")){
        case "ne-evt-settings-maxdate":
            if(!validate_date($(this).val())) {
                $(this).val("");
            }
            break;
        case "ne-evt-settings-minduration":
            if(!validate_duration($(this).val())) {
                $(this).val("00:30");
            }
            break;
        case "ne-evt-settings-repeatsmin":
        case "ne-evt-settings-attendeesnomiss":
            if(!validate_natural_number($(this).val())) {
                $(this).val("1");
            }
            break;
        case "ne-evt-settings-blackliststart":
            if(!validate_time($(this).val())) {
                $(this).val("12:00am");
            }
            break;
        case "ne-evt-settings-blacklistend":
            if(!validate_time($(this).val())) {
                $(this).val("11:59pm");
            }
            break;
    }
});

$(document).on("click", "#ne-evt-settings-attendancegate", function(){
    var maxguests = $(".ne-evt-guest").length;
    $("#ne-evt-settings-attendeesnomiss").html("");
    for(var i=1;i<=maxguests;i++){
        $("#ne-evt-settings-attendeesnomiss").append("<option value=\""+i+"\">"+i+"</option>\n");
    }
});