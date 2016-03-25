/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function show_delete_dialogbox(){
    $("#wpg").addClass("ui-popup-background-effect2");
    $("#el-delete-wrapper").addClass("ui-popup-active");
}
function hide_delete_dialogbox(){
    $("#wpg").removeClass("ui-popup-background-effect2");
    $("#el-delete-wrapper").removeClass("ui-popup-active");
}

$(document).keydown(function(event) {
    if (event.keyCode === 27) {
        hide_delete_dialogbox();
    }
});

$(document).on("click", ".el-content-event-x", function(){
    show_delete_dialogbox();
    $("#el-delete-dialogbox").center();
    $("#el-delete-btn-yes").addClass($(this).attr("id")).focus();
});

$(document).on("click", "#el-delete-x, #el-delete-btn-cancel", function() {
    hide_delete_dialogbox();
    $("#el-delete-btn-yes").removeClass();
});

$(document).on("click keyup", "#el-delete-btn-yes", function(event) {
    if(event.type === "click" || (event.type === "keyup" && (event.which===13))) {
        post("#",{
            "delete":true,
            "pkEventid":$(this).attr("class").substring(13)
        }, "POST");
    }
});

$(document).on("click", ".el-btn-edit", function() {
    post("newevent.php",{
        "edit":true,
        "pkEventid":$(this).attr("id").substring(11)
    },
    "POST")
});
