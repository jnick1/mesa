/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * THIS CODE NEEDS TO ONLY RUN WHEN A GUEST HAS BEEN SUCCESSFULLY ADDED
 */

var addguestclick = false;

$(document).on("click", "#ne-guests-addbutton", function add_guest(){
    
    if(addguestclick) {
        return false;
    }
    addguestclick = true;
    $("#ne-guests-guestaddedtext").animate({opacity: 1}, 500).delay(2500).animate({opacity: 0}, 750, function(){addguestclick = false;});
    $("#ne-guests-emailinput").val("").focus();
});

function see_guest_list_checked(){
    if($("#ne-evt-guests-seeguestlist").is(":checked")){
        $("#ne-guests-invitewarning").css("display", "none");
    } else {
        $("#ne-guests-invitewarning").css("display", "block");
    }
}
$(document).on("click", "#ne-evt-guests-seeguestlist", see_guest_list_checked);
$(document).ready(see_guest_list_checked);

function modify_event_checked(){
    if($("#ne-evt-guests-modifyevent").is(":checked")) { 
        $("#ne-evt-guests-inviteothers").prop("disabled",true);
        $("#ne-evt-guests-inviteothers").prop("checked",true);
        $("#ne-evt-guests-seeguestlist").prop("disabled",true);
        $("#ne-evt-guests-seeguestlist").prop("checked",true);
        see_guest_list_checked();
    } else {
        $("#ne-evt-guests-seeguestlist").removeAttr("disabled");
        $("#ne-evt-guests-inviteothers").removeAttr("disabled");
    }
}
$(document).on("click", "#ne-evt-guests-modifyevent", modify_event_checked);
$(document).ready(modify_event_checked);