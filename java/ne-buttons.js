/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on("click", "#ne-btn-save", function save_evt_request() {
    
    var nmTitle = $("#ne-evt-title").val();
    var dtStart = time_parser($("#ne-evt-date-start").val()+" "+$("#ne-evt-time-start").val());
    var dtEnd = time_parser($("#ne-evt-date-end").val()+" "+$("#ne-evt-time-end").val());
    var txLocation = $("#ne-evt-where").val();
    var txDescription = $("#ne-evt-description").val();
    var txRRule = "";
    var nColorid = 0;
    var blSettings = {};
    var blAttendees = {};
    var blNotifications = {};
    var isGuestInvite = $("#ne-evt-guests-inviteothers").is(":checked");
    var isGuestList = $("#ne-evt-guests-seeguestlist").is(":checked");
    var enVisibility = $("#ne-evt-visibility-public").is(":checked")?"public":$("#ne-evt-visibility-private").is(":checked")?"private":"default";
    var isBusy = $("#ne-evt-busy").is(":checked");
    
    //parsing for nColorid
    
    
    //parsing for txRRule
    
    
    //parsing for blNotifications
    
    
    //parsing for blAttendees
    
    
    //parsing for blSettings
    
    
    post("eventlist.php",{
        "nmTitle":nmTitle
    },"POST");
});
$(document).on("click", "#ne-btn-send", function send_evt_request() {
    alert("Placeholder");
});
$(document).on("click", "#ne-btn-back", function back_evt_request() {
    window.location = "eventlist.php";
});