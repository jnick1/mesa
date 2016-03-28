/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var addguestclick = false;

function add_guest_animation(){
    if(addguestclick) {
        return false;
    }
    addguestclick = true;
    $("#ne-guests-guestaddedtext").html("Guest added");
    $("#ne-guests-guestaddedtext").animate({color: "#080"}, 500).delay(2500).animate({color: "#fff"}, 750, function(){addguestclick = false;});
}
function add_conflict_animation(email) {
    if(addguestclick){
        return false;
    }
    addguestclick = true;
    $("#ne-guests-guestaddedtext").html("Guest already invited");
    $("#ne-guests-guestaddedtext").animate({color: "#c11"}, 500).delay(2500).animate({color: "#fff"}, 750, function(){addguestclick = false;});
    email = email.split("@").join("\\@").replace(".","\\.");
    $("#"+email).animate({"background-color": "#fe8"}, 500).animate({"background-color": "#fff"}, 500).animate({"background-color": "#fe8"}, 500).delay(1500).animate({"background-color": "#fff"}, 750, function(){addguestclick = false;});
}
function guest_conflict(){
    var email = $("#ne-guests-emailinput").val();
    email = email.replace("@", "\\@").replace(".","\\.");
    if($("#"+email).length!==0){
        return true;
    }
    return false;
}
function add_guest(){
    var email = $("#ne-guests-emailinput").val();
    if(email!=="" && validate_email(email)){
        if($("#ne-guests-container-list").hasClass("wpg-nodisplay")){
            $("#ne-guests-container-list").removeClass("wpg-nodisplay");
        }
        if(!guest_conflict()){
            add_guest_animation();
        $("#wpg-header-warning").html("");
        $("#wpg-header-errordisplay-warningwrapper").addClass("wpg-nodisplay");
        var content = "<div id=\""+email+"\" class=\"ne-evt-guest\" data-required=\"true\" title=\""+email+"\">"+
                      "    <div class=\"ne-guests-guestdata\">"+
                      "        <div class=\"ne-guests-guestdata-content ui-container-inline\">"+
                      "            <span class=\"goog-icon goog-icon-guest-required ui-container-inline ne-guest-required\" title=\"Click to mark this attendee as optional\"></span>"+
                      "            <div class=\"ui-container-inline ne-guest-response-icon-wrapper\">"+
                      "                <div class=\"ne-guest-response-icon\"></div>"+
                      "            </div>"+
                      "            <div id=\""+email+"@display\" class=\"ui-container-inline ne-guest-name-wrapper\">"+
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
            add_conflict_animation(email+"@display");
        }
    } else {
        $("#wpg-header-warning").append("<div><span class=\"ui-icon ui-icon-info wpg-header-errordisplay-icon\"></span>\n<b>Warning: </b>Invalid email address supplied; please enter a valid email.</div>");
        $("#wpg-header-errordisplay-warningwrapper").removeClass("wpg-nodisplay");
    }
}

$(document).on("click", "#ne-guests-addbutton", add_guest);

$(document).on("click", ".ne-guest-delete", function remove_guest(){
    $(this).parents(".ne-evt-guest").remove();
    if($("#ne-guests-table-body").html().trim()===""){
        $("#ne-guests-container-list").addClass("wpg-nodisplay");
    }
});

$(document).on("click", ".ne-guest-required", function change_required(){
    if($(this).hasClass("goog-icon-guest-required")){
        $(this).removeClass("goog-icon-guest-required");
        $(this).addClass("goog-icon-guest-optional");
        $(this).parents(".ne-evt-guest").attr("data-required", "false");
    } else if($(this).hasClass("goog-icon-guest-optional")){
        $(this).removeClass("goog-icon-guest-optional");
        $(this).addClass("goog-icon-guest-required");
        $(this).parents(".ne-evt-guest").attr("data-required", "true");
    }
});

$(document).on("keyup", "#ne-guests-emailinput", function(e){ 
    var code = e.which;
    if(code===13)e.preventDefault();
    if(code===32||code===13||code===188||code===186){
        add_guest();
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

$(document).on("click", "#ne-btn-email", function(){
    if($("#wpg").attr("data-eventid")) {
        var parameters = {
            "request":true,
            "pkEventid":$("#wpg").attr("data-eventid")
        };
        post("eventlist.php",parameters,"POST");
    } else {
        var nmTitle = $("#ne-evt-title").val();
        if(nmTitle === "") {
            $("#wpg-header-warning").append("<div><span class=\"ui-icon ui-icon-info wpg-header-errordisplay-icon\"></span>\n<b>Warning: </b>"+"Your event must have a title to be sent."+"</div>");
            $("#wpg-header-errordisplay-warningwrapper").removeClass("wpg-nodisplay");
            return;
        }
        if($(".ne-evt-guest").length === 0){
            $("#wpg-header-warning").append("<div><span class=\"ui-icon ui-icon-info wpg-header-errordisplay-icon\"></span>\n<b>Warning: </b>"+"Your event must have at least 1 attendee to be sent."+"</div>");
            $("#wpg-header-errordisplay-warningwrapper").removeClass("wpg-nodisplay");
            return;
        }
        var dtStart = "";
        var dtEnd = "";
        var txLocation = $("#ne-evt-where").val();
        var txDescription = $("#ne-evt-description").val();
        var txRRule = "";
        var nColorid = 0;
        var blSettings = {};
        var blAttendees = [];
        var blNotifications = {};
        var isGuestInvite = $("#ne-evt-guests-inviteothers").is(":checked")?1:0;
        var isGuestList = $("#ne-evt-guests-seeguestlist").is(":checked")?1:0;
        var enVisibility = $("#ne-evt-visibility-public").is(":checked")?"public":$("#ne-evt-visibility-private").is(":checked")?"private":"default";
        var isBusy = $("#ne-evt-busy").is(":checked")?1:0;

        //parsing for dtStart
        var start = new Date();
        start = time_parser($("#ne-evt-date-start").val()+" "+$("#ne-evt-time-start").val());
        start = start.getUTCFullYear()+"/"+
                ((start.getUTCMonth()+1)<10?"0"+(start.getUTCMonth()+1):(start.getUTCMonth()+1))+"/"+
                (start.getUTCDate()<10?"0"+start.getUTCDate():start.getUTCDate())+" "+
                (start.getUTCHours()<10?"0"+start.getUTCHours():start.getUTCHours())+":"+
                (start.getUTCMinutes()<10?"0"+start.getUTCMinutes():start.getUTCMinutes())+":00";
        dtStart = start;
        //parsing for dtEnd
        var end = new Date();
        end = time_parser($("#ne-evt-date-end").val()+" "+$("#ne-evt-time-end").val());
        end = end.getUTCFullYear()+"/"+
                ((end.getUTCMonth()+1)<10?"0"+(end.getUTCMonth()+1):(end.getUTCMonth()+1))+"/"+
                (end.getUTCDate()<10?"0"+end.getUTCDate():end.getUTCDate())+" "+
                (end.getUTCHours()<10?"0"+end.getUTCHours():end.getUTCHours())+":"+
                (end.getUTCMinutes()<10?"0"+end.getUTCMinutes():end.getUTCMinutes())+":00";
        dtEnd = end;
        //parsing for nColorid
        var colorids = {
        "blue":1,
        "boldblue":9,
        "boldgreen":10,
        "boldred":11,
        "default":0,
        "gray":8,
        "green":2,
        "orange":6,
        "purple":3,
        "red":4,
        "turquoise":7,
        "yellow":5
        };
        nColorid = colorids[$(".details-eventcolors-selected").attr("id").substring(13)];
        //parsing for txRRule
        if($("#ne-evt-repeatbox").is(":checked")) {
            switch($("#ne-evt-repeat-repeats").val()){
                case "0":
                    txRRule += "FREQ=DAILY;";
                    txRRule += "INTERVAL="+$("#ne-evt-repeat-repeatevery").val()+";";
                    break;
                case "1":
                    txRRule += "FREQ=WEEKLY;";
                    txRRule += "BYDAY=MO,TU,WE,TH,FR;";
                    break;
                case "2":
                    txRRule += "FREQ=WEEKLY;";
                    txRRule += "BYDAY=MO,WE,FR;";
                    break;
                case "3":
                    txRRule += "FREQ=WEEKLY;";
                    txRRule += "BYDAY=TU,TH;";
                    break;
                case "4":
                    txRRule += "FREQ=WEEKLY;";
                    txRRule += "INTERVAL="+$("#ne-evt-repeat-repeatevery").val()+";";
                    txRRule += "BYDAY=";
                    var days = ["SU,","MO,","TU,","WE,","TH,","FR,","SA,"];
                    for(var i = 0;i<7;i++){
                        if($("#ne-evt-repeat-repeatson-"+i).is(":checked")){
                            txRRule += days[i];
                        }
                    }
                    txRRule = txRRule.slice(0,-1)+";";
                    break;
                case "5":
                    txRRule += "FREQ=MONTHLY;";
                    txRRule += "INTERVAL="+$("#ne-evt-repeat-repeatevery").val()+";";
                    if($("#ne-evt-repeat-repeatby-dayofmonth").is(":checked")) {
                        var date = time_parser($("#ne-evt-date-start").val()+" "+$("#ne-evt-time-start").val());
                        txRRule += "BYMONTHDAY="+date.getDate()+";";
                    } else {
                        var days = ["SU","MO","TU","WE","TH","FR","SA"];
                        var d    = time_parser($("#ne-evt-date-start").val()+" "+$("#ne-evt-time-start").val());
                        var date = d.getDate();
                        var n    = Math.ceil(date / 7);

                        txRRule += "BYDAY="+n+days[d.getDay()]+";";
                    }
                    break;
                case "6":
                    txRRule += "FREQ=YEARLY;";
                    txRRule += "INTERVAL="+$("#ne-evt-repeat-repeatevery").val()+";";
                    break;
            }
            if($("#ne-evt-endson-after").is(":checked")) {
                txRRule += "COUNT="+$("#ne-evt-endson-occurances").val()+";";
            } else if($("#ne-evt-endson-on").is(":checked")) {
                var until = new Date();
                until = time_parser($("#ne-evt-endson-date").val()+" "+$("#ne-evt-time-start").val());

                var temp = (until.getUTCMonth()+1)<10?"0"+(until.getUTCMonth()+1):(until.getUTCMonth()+1);
                txRRule += "UNTIL="+until.getUTCFullYear()+temp;

                temp = (until.getUTCDate())<10?"0"+(until.getUTCDate()):(until.getUTCDate());
                txRRule += temp+"T";

                temp = (until.getUTCHours())<10?"0"+(until.getUTCHours()):(until.getUTCHours());
                txRRule += temp;

                temp = (until.getUTCMinutes())<10?"0"+(until.getUTCMinutes()):(until.getUTCMinutes());
                txRRule += temp+"00;";
            }
        }
        //parsing for blNotifications
        var reminders =  {
            "useDefault": false,
            "overrides": []
        };
        for(var i=1;i<=5;i++){
            var notifications = $("#details-notifications-"+i);
            if(notifications.length!==0){
                reminders.overrides.push({
                    "method":$("#ne-evt-notifications-"+i).val(),
                    "minutes":""+(parseInt($("#ne-evt-notifications-time-"+i).val())*parseInt($("#ne-evt-notifications-timetype-"+i).val()))
                });
            }
        }
        blNotifications = reminders;
        //parsing for blAttendees
        var emails = $(".ne-evt-guest");
        var attendees = [];
        emails.each(function(){
            attendees.push({
                "email":$(this).attr("id"),
                "optional":($(this).data("required"))===true?false:true,
                "responseStatus":"needsAction"
            });
        });
        blAttendees = attendees;
        //parsing for blSettings
        if($("#ne-evt-settings-usedefault").is(":checked") || !$("#ne-evt-settingsbox").is(":checked")){
            blSettings = {
                "useDefault":true
            };
        } else {
            var temp = {};
            blSettings = {
                "useDefault":false
            };
            if($("#ne-evt-settings-timegate").is(":checked")) {
                temp["timeallow"] = $("#ne-evt-settings-timeallow").is(":checked");
                var prior = $("#ne-evt-settings-time-prior-low").is(":checked")?1:$("#ne-evt-settings-time-prior-med").is(":checked")?10:100;
                temp["prioritization"] = prior;
                blSettings["time"] = temp;
            } else {
                blSettings["time"] = false;
            }
            temp = {};
            if($("#ne-evt-settings-daygate").is(":checked")) {
                temp["dateallow"] = $("#ne-evt-settings-dayallow").is(":checked");
                var prior = $("#ne-evt-settings-date-prior-low").is(":checked")?1:$("#ne-evt-settings-date-prior-med").is(":checked")?10:100;
                temp["prioritization"] = prior;
                temp["furthest"] = $("#ne-evt-settings-maxdate").val();
                blSettings["date"] = temp;
            } else {
                blSettings["date"] = false;
            }
            temp = {};
            if($("#ne-evt-settings-durationgate").is(":checked")) {
                temp["durationallow"] = $("#ne-evt-settings-durationallow").is(":checked");
                var prior = $("#ne-evt-settings-duration-prior-low").is(":checked")?1:$("#ne-evt-settings-duration-prior-med").is(":checked")?10:100;
                temp["prioritization"] = prior;
                temp["minduration"] = $("#ne-evt-settings-minduration").val()+":00";
                blSettings["duration"] = temp;
            } else {
                blSettings["duration"] = false;
            }
            temp = {};
            if($("#ne-evt-settings-repeatgate").is(":checked")) {
                temp["repeatallow"] = $("#ne-evt-settings-repeatsallow").is(":checked");
                var prior = $("#ne-evt-settings-repeats-prior-low").is(":checked")?1:$("#ne-evt-settings-repeats-prior-med").is(":checked")?10:100;
                temp["prioritization"] = prior;
                temp["minrepeats"] = parseInt($("#ne-evt-settings-repeatsmin").val());
                temp["repeatconstant"] = $("#ne-evt-settings-repeatsconstant").is(":checked");
                blSettings["repeat"] = temp;
            } else {
                blSettings["repeat"] = false;
            }
            temp = {};
            if($("#ne-evt-settings-blacklistgate").is(":checked")) {
                var earliest = time_parser($("#ne-evt-date-start").val()+" "+$("#ne-evt-settings-blackliststart").val());
                temp["earliest"] = (earliest.getUTCHours()<10?"0"+earliest.getUTCHours():earliest.getUTCHours())+":"+(earliest.getUTCMinutes()<10?"0"+earliest.getUTCMinutes():earliest.getUTCMinutes())+":00";
                var latest = time_parser($("#ne-evt-date-end").val()+" "+$("#ne-evt-settings-blacklistend").val());
                temp["latest"] = (latest.getUTCHours()<10?"0"+latest.getUTCHours():latest.getUTCHours())+":"+(latest.getUTCMinutes()<10?"0"+latest.getUTCMinutes():latest.getUTCMinutes())+":00";
                temp["days"] = "";
                var days = ["SU,","MO,","TU,","WE,","TH,","FR,","SA,"];
                for(var i=0;i<7;i++){
                    if($("#ne-evt-settings-blacklistdays-"+i).is(":checked")){
                        temp["days"] += days[i];
                    }
                }
                temp["days"] = temp["days"].slice(0,-1);
                blSettings["blacklist"] = temp;
            } else {
                blSettings["blacklist"] = false;
            }
            temp = {};
            if($("#ne-evt-settings-locationgate").is(":checked")) {
                temp["locationallow"] = $("#ne-evt-settings-locationallow").is(":checked");
                var prior = $("#ne-evt-settings-location-prior-low").is(":checked")?1:$("#ne-evt-settings-location-prior-med").is(":checked")?10:100;
                temp["prioritization"] = prior;
                blSettings["location"] = temp;
            } else {
                blSettings["location"] = false;
            }
            temp = {};
            if($("#ne-evt-settings-attendancegate").is(":checked")) {
                temp["attendeesallow"] = $("#ne-evt-settings-attendeesallow").is(":checked");
                var prior = $("#ne-evt-settings-attendees-prior-low").is(":checked")?1:$("#ne-evt-settings-attendees-prior-med").is(":checked")?10:100;
                temp["prioritization"] = prior;
                temp["minattendees"] = parseInt($("#ne-evt-settings-attendeesnomiss").val());
                blSettings["attendees"] = temp;
            } else {
                blSettings["attendees"] = false;
            }
        }

        var parameters = {
            "createrequest":true,
            "nmTitle":nmTitle,
            "dtStart":dtStart,
            "dtEnd":dtEnd,
            "txLocation":txLocation,
            "txDescription":txDescription,
            "txRRule":txRRule,
            "nColorid":nColorid,
            "blSettings":JSON.stringify(blSettings),
            "blAttendees":JSON.stringify(blAttendees),
            "blNotifications":JSON.stringify(blNotifications),
            "isGuestInvite":isGuestInvite,
            "isGuestList":isGuestList,
            "enVisibility":enVisibility,
            "isBusy":isBusy
        };
        post("eventlist.php",parameters,"POST");
    }
});