/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var addguestclick = false;

function validate_email(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function add_guest_animation(){
    if(addguestclick) {
        return false;
    }
    addguestclick = true;
    $("#ne-guests-guestaddedtext").html("Guest added");
    $("#ne-guests-guestaddedtext").animate({color: 080}, 500).delay(2500).animate({color: fff}, 750, function(){addguestclick = false;});
}
function add_conflict_animation() {
    if(addguestclick){
        return false;
    }
    addguestclick = true;
    $("#ne-guests-guestaddedtext").html("Guest already invited");
    $("#ne-guests-guestaddedtext").animate({color: c11}, 500).delay(2500).animate({color: fff}, 750, function(){addguestclick = false;});
}
function guest_conflict(){
    var email = $("#ne-guests-emailinput").val();
    email = email.replace("@", "\\\\@");
    if($("#"+email).length!==0){
        return true;
    }
    return false;
}
$(document).on("click", "#ne-guests-addbutton", function add_guest(){
    var email = $("#ne-guests-emailinput").val();
    if(email!=="" && validate_email(email)){
        if(!guest_conflict()){
            add_guest_animation();
        $("#wpg-header-warning").html("");
        $("#wpg-header-errordisplay-warningwrapper").addClass("wpg-nodisplay");
        var content = "<div id=\""+email+"\" class=\"ne-evt-guest\" required=\"true\" title=\""+email+"\">"+
                      "    <div class=\"ne-guests-guestdata\">"+
                      "        <div class=\"ne-guests-guestdata-content ui-container-inline\">"+
                      "            <span class=\"goog-icon goog-icon-guest-required ui-container-inline ne-guest-required\" title=\"Click to mark this attendee as optional\"></span>"+
                      "            <div class=\"ui-container-inline ne-guest-response-icon-wrapper\">"+
                      "                <div class=\"ne-guest-response-icon\"></div>"+
                      "            </div>"+
                      "            <div class=\"ui-container-inline ne-guest-name-wrapper\">"+
                      "                <span class=\"ne-guest-name ui-unselectabletext\">"+email+"</span>"+
                      "            </div>"+
                      "            <div class=\"ui-container-inline ne-guest-delete\">"+
                      "                <div class=\"goog-icon goog-icon-x-small\" title=\"Remove this guest from the event\"></div>"+
                      "            </div>"+
                      "        </div>"+
                      "    </div>"+
                      "</div>";
        $("#ne-guests-table-body").append(content);
        $("#ne-guests-emailinput").val("").focus();
        } else {
            $("#ne-guests-emailinput").val("").focus();
            add_conflict_animation();
        }
    } else {
        $("#wpg-header-warning").append("<div><span class=\"ui-icon ui-icon-info wpg-header-errordisplay-icon\"></span>\n<b>Warning: </b>Invalid email address supplied; please enter a valid email.</div>");
        $("#wpg-header-errordisplay-warningwrapper").removeClass("wpg-nodisplay");
    }
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