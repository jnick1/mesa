/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var repeatset = false;
var pageload = false;
var repeatstate = {};

$(function() {
    $("#ne-evt-endson-date").datepicker({ dateformat: "mm/dd/yy"});
});

$(document).ready(function() {
    if($("#wpg").attr("data-eventid")){
        var RRule = $("#ne-repeat-summary-display").html();
        var splitRules = RRule.split(";");
        var rules = {};
        for(var i=0;i<splitRules.length;i++){
            rules[splitRules[i].split("=")[0]] = splitRules[i].split("=")[1];
        }
        switch(rules["FREQ"]){
            case "DAILY":
                $("#ne-evt-repeat-repeats").val("0");
                $("#ne-evt-repeat-repeatevery").val(rules["INTERVAL"]);
                $("#ne-label-repeat-repeatevery").html("days");
                $("#ne-repeat-table-2,#ne-repeat-table-3").addClass("wpg-nodisplay");
                $("#ne-evt-repeat-repeatby-dayofmonth").prop("checked",true);
                if("UNTIL" in rules) {
                    $("#ne-evt-endson-on").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", true).val("");
                    var until = rules["UNTIL"].substring(0,4)+"/"+rules["UNTIL"].substring(4,6)+"/"+rules["UNTIL"].substring(6,8)+" "+
                            rules["UNTIL"].substring(9,11)+":"+rules["UNTIL"].substring(11,13)+":"+rules["UNTIL"].substring(13,15)+" UTC";
                    var until = new Date(until);
                    $("#ne-evt-endson-date").prop("disabled", false).val(((until.getMonth()+1)<10?"0"+(until.getMonth()+1):(until.getMonth()+1))+"/"+
                            (until.getDate()<10?"0"+until.getDate():until.getDate())+"/"+
                            until.getFullYear());
                } else if("COUNT" in rules) {
                    $("#ne-evt-endson-after").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", false).val(rules["COUNT"]);
                    $("#ne-evt-endson-date").prop("disabled", true).val("");
                } else {
                    $("#ne-evt-endson-never").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", true).val("");
                    $("#ne-evt-endson-date").prop("disabled", true).val("");
                }
                break;
            case "WEEKLY":
                if("INTERVAL" in rules) {
                    $("#ne-evt-repeat-repeats").val("4");
                    $("#ne-evt-repeat-repeatevery").val(rules["INTERVAL"]);
                    $("#ne-label-repeat-repeatevery").html("weeks");
                    $("#ne-repeat-table-3").addClass("wpg-nodisplay");
                    var days = rules["BYDAY"].split(",");
                    for(var i=0;i<days.length;i++){
                        if(days[i] === "SU") {
                            $("#ne-evt-repeat-repeatson-0").prop("checked", true);
                        } else if(days[i] === "MO") {
                            $("#ne-evt-repeat-repeatson-1").prop("checked", true);
                        } else if(days[i] === "TU") {
                            $("#ne-evt-repeat-repeatson-2").prop("checked", true);
                        } else if(days[i] === "WE") {
                            $("#ne-evt-repeat-repeatson-3").prop("checked", true);
                        } else if(days[i] === "TH") {
                            $("#ne-evt-repeat-repeatson-4").prop("checked", true);
                        } else if(days[i] === "FR") {
                            $("#ne-evt-repeat-repeatson-5").prop("checked", true);
                        } else if(days[i] === "SA") {
                            $("#ne-evt-repeat-repeatson-6").prop("checked", true);
                        }
                    }
                } else {
                    switch(rules["BYDAY"]){
                        case "MO,TU,WE,TH,FR":
                            $("#ne-evt-repeat-repeats").val("1");
                            break;
                        case "MO,WE,FR":
                            $("#ne-evt-repeat-repeats").val("2");
                            break;
                        case "TU,TH":
                            $("#ne-evt-repeat-repeats").val("3");
                            break;
                    }
                    $("#ne-evt-repeat-repeatevery").val("1");
                    $("#ne-repeat-table-1,#ne-repeat-table-2,#ne-repeat-table-3").addClass("wpg-nodisplay");
                }
                $("#ne-evt-repeat-repeatby-dayofmonth").prop("checked",true);
                if("UNTIL" in rules) {
                    $("#ne-evt-endson-on").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", true).val("");
                    var until = rules["UNTIL"].substring(0,4)+"/"+rules["UNTIL"].substring(4,6)+"/"+rules["UNTIL"].substring(6,8)+" "+
                            rules["UNTIL"].substring(9,11)+":"+rules["UNTIL"].substring(11,13)+":"+rules["UNTIL"].substring(13,15)+" UTC";
                    var until = new Date(until);
                    $("#ne-evt-endson-date").prop("disabled", false).val(((until.getMonth()+1)<10?"0"+(until.getMonth()+1):(until.getMonth()+1))+"/"+
                            (until.getDate()<10?"0"+until.getDate():until.getDate())+"/"+
                            until.getFullYear());
                } else if("COUNT" in rules) {
                    $("#ne-evt-endson-after").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", false).val(rules["COUNT"]);
                    $("#ne-evt-endson-date").prop("disabled", true).val("");
                } else {
                    $("#ne-evt-endson-never").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", true).val("");
                    $("#ne-evt-endson-date").prop("disabled", true).val("");
                }
                break;
            case "MONTHLY":
                $("#ne-evt-repeat-repeats").val("5");
                $("#ne-evt-repeat-repeatevery").val(rules["INTERVAL"]);
                $("#ne-label-repeat-repeatevery").html("months");
                $("#ne-repeat-table-2").addClass("wpg-nodisplay");
                if("BYDAY" in rules){
                    $("#ne-evt-repeat-repeatby-dayofweek").prop("checked",true);
                } else {
                    $("#ne-evt-repeat-repeatby-dayofmonth").prop("checked",true);
                }
                if("UNTIL" in rules) {
                    $("#ne-evt-endson-on").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", true).val("");
                    var until = rules["UNTIL"].substring(0,4)+"/"+rules["UNTIL"].substring(4,6)+"/"+rules["UNTIL"].substring(6,8)+" "+
                            rules["UNTIL"].substring(9,11)+":"+rules["UNTIL"].substring(11,13)+":"+rules["UNTIL"].substring(13,15)+" UTC";
                    var until = new Date(until);
                    $("#ne-evt-endson-date").prop("disabled", false).val(((until.getMonth()+1)<10?"0"+(until.getMonth()+1):(until.getMonth()+1))+"/"+
                            (until.getDate()<10?"0"+until.getDate():until.getDate())+"/"+
                            until.getFullYear());
                } else if("COUNT" in rules) {
                    $("#ne-evt-endson-after").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", false).val(rules["COUNT"]);
                    $("#ne-evt-endson-date").prop("disabled", true).val("");
                } else {
                    $("#ne-evt-endson-never").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", true).val("");
                    $("#ne-evt-endson-date").prop("disabled", true).val("");
                }
                break;
            case "YEARLY":
                $("#ne-evt-repeat-repeats").val("6");
                $("#ne-evt-repeat-repeatevery").val(rules["INTERVAL"]);
                $("#ne-label-repeat-repeatevery").html("years");
                $("#ne-repeat-table-2,#ne-repeat-table-3").addClass("wpg-nodisplay");
                $("#ne-evt-repeat-repeatby-dayofmonth").prop("checked",true);
                if("UNTIL" in rules) {
                    $("#ne-evt-endson-on").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", true).val("");
                    var until = rules["UNTIL"].substring(0,4)+"/"+rules["UNTIL"].substring(4,6)+"/"+rules["UNTIL"].substring(6,8)+" "+
                            rules["UNTIL"].substring(9,11)+":"+rules["UNTIL"].substring(11,13)+":"+rules["UNTIL"].substring(13,15)+" UTC";
                    var until = new Date(until);
                    $("#ne-evt-endson-date").prop("disabled", false).val(((until.getMonth()+1)<10?"0"+(until.getMonth()+1):(until.getMonth()+1))+"/"+
                            (until.getDate()<10?"0"+until.getDate():until.getDate())+"/"+
                            until.getFullYear());
                } else if("COUNT" in rules) {
                    $("#ne-evt-endson-after").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", false).val(rules["COUNT"]);
                    $("#ne-evt-endson-date").prop("disabled", true).val("");
                } else {
                    $("#ne-evt-endson-never").prop("checked", true);
                    $("#ne-evt-endson-occurances").prop("disabled", true).val("");
                    $("#ne-evt-endson-date").prop("disabled", true).val("");
                }
                break;
        }
        $("#ne-evt-repeat-startson").val($("#ne-evt-date-start").val());
        repeatset = true;
        generate_summary();
        pageload = true;
        $("#ne-repeat-summary-display").html($("#ne-repeat-summary").html());
        save_state("#ne-repeat-wrapper",repeatstate);
    } else {
        $("#ne-evt-repeatbox").prop("checked", false);
        repeat_options_reset();
        save_state("#ne-repeat-wrapper",repeatstate);
    }
});

function repeat_options_reset(){
    
    //this code is included from the function "client_time()" in time.js because without it
    //it, the code in this function would cause $(document).ready(...) to fail due to
    //a TypeError. This was caused by an attempt to retrieve the value of #ne-evt-time-start
    //and #ne-evt-date-start before they had been instantiated. This only occured when first
    //loading the page, but it would cripple the page. SOOO, this code has been included.
    var time_start = "";
    var date_start = "";
    
    if(!pageload){
        var time = new Date(Math.ceil((Math.floor(Date.now()/1000))/(30*60))*(30*60)*1000);

        var month = time.getMonth()+1;
        var day = time.getDate();
        var year = time.getFullYear();

        var hours = time.getHours();
        var minutes = time.getMinutes();

        var suffix = "am";

        month<10?month="0"+month:"";
        day<10?day="0"+day:"";
        hours>=12?(suffix="pm", hours-=12):"";
        hours===0?hours=12:"";
        minutes<10?minutes="0"+minutes:"";
        
        time_start = (hours + ":" + minutes + suffix); //hours1 + ":" + minutes + suffix
        date_start = (month + "/" + day + "/" + year);
        pageload = true;
    } else {
        time_start = $("#ne-evt-time-start").val();
        date_start = $("#ne-evt-date-start").val();
    }
    
    //reset "Repeats:"
    $("#ne-evt-repeat-repeats").val("0");
    //reset "Repeat every:"
    $("#ne-evt-repeat-repeatevery").val("1");
    //reset "Repeats on:"
    var day = new Date();
    day = time_parser(date_start + " " + time_start);
    day = day.getDay();
    
    for(var i=0;i<7;i++){
        $("#ne-evt-repeat-repeatson-"+i).prop("checked", false);
    }
    $("#ne-evt-repeat-repeatson-"+day).prop("checked", true);
    //reset "Repeat by:"
    $("#ne-evt-repeat-repeatby-dayofmonth").prop("checked", true);
    $("#ne-repeat-table-2").addClass("wpg-nodisplay");
    $("#ne-repeat-table-3").addClass("wpg-nodisplay");
    //reset "Starts on"
    $("#ne-evt-repeat-startson").val(date_start);
    //reset "Ends:"
    $("#ne-evt-endson-never").prop("checked", true);
    $("#ne-evt-endson-occurances").prop("disabled", true).val("");
    $("#ne-evt-endson-date").prop("disabled", true).val("");
    //reset "Summary:"
    $("#ne-repeat-summary").html("Daily");
}
function repeat_occurance_reset(){
    if(!validate_natural_number($("#ne-evt-endson-occurances").val())){
        if($("#ne-evt-repeat-repeats").val()==="0" || $("#ne-evt-repeat-repeats").val()==="0") {
            $("#ne-evt-endson-occurances").val("5");
        } else {
            $("#ne-evt-endson-occurances").val("35");
        }
        generate_summary();
    }
}
function repeat_days_reset(){
    var oneActive = false;
    for(var i = 0;i<7;i++){
        if($("#ne-evt-repeat-repeatson-"+i).is(":checked")){
            oneActive = true;
            break;
        }
    }
    if(!oneActive){
        var time_start = "";
        var date_start = "";
        if(!pageload){
            var time = new Date(Math.ceil((Math.floor(Date.now()/1000))/(30*60))*(30*60)*1000);

            var month = time.getMonth()+1;
            var day = time.getDate();
            var year = time.getFullYear();

            var hours = time.getHours();
            var minutes = time.getMinutes();

            var suffix = "am";

            month<10?month="0"+month:"";
            day<10?day="0"+day:"";
            hours>=12?(suffix="pm", hours-=12):"";
            hours===0?hours=12:"";
            minutes<10?minutes="0"+minutes:"";

            time_start = (hours + ":" + minutes + suffix); //hours1 + ":" + minutes + suffix
            date_start = (month + "/" + day + "/" + year);
            pageload = true;
        } else {
            time_start = $("#ne-evt-time-start").val();
            date_start = $("#ne-evt-date-start").val();
        }

        var day = new Date();
        day = time_parser(date_start + " " + time_start);
        day = day.getDay();

        $("#ne-evt-repeat-repeatson-"+day).prop("checked", true);
    }
}
function getNth(dat) {
    var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday","Saturday"];
    var nth  = ["first", "second", "third", "fourth", "last"];
    var d    = dat ? dat instanceof Date ? dat : new Date(dat) : new Date();
    var date = d.getDate();
    var day  = d.getDay();
    var n    = Math.ceil(date / 7);

    return nth[n-1] + ' ' + days[day];
}
function array_true(elem) {
    return elem;
}
function array_false(elem){
    return !elem;
}
function generate_summary() {
    var summary = "";
    var repeats = parseInt($("#ne-evt-repeat-repeats").val());
    var repeatevery = parseInt($("#ne-evt-repeat-repeatevery").val());
    var startdate = new Date();
    
    var starttime = "";
    var endtime = "";
    if($("#wpg").attr("data-eventid") && !pageload){
        var times = $(".ne-top-time");
        var parsedtimes = {};
        times.each(function(index, elem){
            parsedtimes[$(elem).attr("id")] = $(elem).val();
        });
        for(var time in parsedtimes) {
            var newtime;
            var date;
            if(time==="ne-evt-time-start") {
                var dateO = $("#ne-evt-date-start").val();
                date = new Date($("#ne-evt-date-start").val()+" "+$("#ne-evt-time-start").val()+":00 UTC");
                newtime = new Date(dateO.substring(6)+"/"+dateO.substring(0,2)+"/"+dateO.substring(3,5)+" "+parsedtimes[time]+":00 UTC ");
            } else if(time==="ne-evt-time-end") {
                var dateO = $("#ne-evt-date-end").val();
                date = new Date($("#ne-evt-date-end").val()+" "+$("#ne-evt-time-end").val()+":00 UTC");
                newtime = new Date(dateO.substring(6)+"/"+dateO.substring(0,2)+"/"+dateO.substring(3,5)+" "+parsedtimes[time]+":00 UTC ");
            }

            var hours = newtime.getHours();
            var minutes = newtime.getMinutes();

            var suffix = "am";

            if (hours >= 12) {
                suffix = "pm";
                hours -= 12;
            }
            if (hours === 0) {
                hours = 12;
            }

            if (minutes < 10) {
                minutes = "0" + minutes;
            }

            if(time==="ne-evt-time-start"){
                starttime = (hours + ":" + minutes + suffix); //hours1 + ":" + minutes + suffix
            } else if(time==="ne-evt-time-end") {
                endtime = (hours + ":" + minutes + suffix); //hours1 + ":" + minutes + suffix
            }
        }
    } else {
        starttime = $("#ne-evt-time-start").val();
        endtime = $("#ne-evt-time-start").val();
    }
    
    startdate = time_parser($("#ne-evt-date-start").val()+" "+starttime);
    var repeatson = [];
    for(var i=0;i<7;i++){
        repeatson.push($("#ne-evt-repeat-repeatson-"+i).is(":checked"));
    }
    var dayofmonth = $("#ne-evt-repeat-repeatby-dayofmonth").is(":checked");
    var end = $("#ne-evt-endson-never").is(":checked")?"never":$("#ne-evt-endson-after").is(":checked")?"after":"on";
    var occurances = validate_natural_number($("#ne-evt-endson-occurances").val())?parseInt($("#ne-evt-endson-occurances").val()):(repeats===0 || repeats===6)?5:35;
    var enddate = new Date();
    if($("#ne-evt-endson-date").val()!==""){
        enddate = time_parser($("#ne-evt-endson-date").val()+" "+endtime);
    }
    var parsedenddate = "";
    var parsedstartdate = "";
    var parsedstartday = "";
    
    if(end!=="after" || (end==="after" && occurances!==1)){
    
    if($("#ne-evt-endson-date").val()!==""){
        var months = ["Jan ", "Feb ", "Mar ", "Apr ", "May ", "Jun ", "Jul ", "Aug ", "Sep ", "Oct ", "Nov ", "Dec "];
        parsedenddate += months[enddate.getMonth()] + enddate.getDate() + ", " + enddate.getFullYear();
    }
    if(repeats===6){
        var months = ["January ", "February ", "March ", "April ", "May ", "June ", "July ", "August ", "September ", "October ", "November ", "December "];
        parsedstartdate += months[startdate.getMonth()] + startdate.getDate();
    }
    if(repeats===4) {
        var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        parsedstartday = days[startdate.getDay()];
    }
    
    switch(repeats){
        case 0:
            if(repeatevery<2){
                summary += "Daily";
            } else {
                summary += "Every "+repeatevery+" days";
            }
            break;
        case 1:
            summary += "Weekly on weekdays";
            break;
        case 2:
            summary += "Weekly on Monday, Wednesday, Friday";
            break;
        case 3:
            summary += "Weekly on Tuesday, Thursday";
            break;
        case 4:
            if(repeatevery<2){
                summary += "Weekly";
            } else {
                summary += "Every "+repeatevery+" weeks";
            }
            if(repeatson.every(array_true)){
                summary += " on all days";
            } else if(repeatson.every(array_false)){
                summary += " on " + parsedstartday;
            } else if(!repeatson[0] && repeatson[1] && repeatson[2] && repeatson[3] && repeatson[4] && repeatson[5] && !repeatson[6]) {
                summary += " on weekdays";
            } else {
                var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
                var first = false;
                summary += " on ";
                for(var i=0;i<7;i++){
                    if(repeatson[i] && !first){
                        first = true;
                        summary += days[i];
                    } else if(repeatson[i]){
                        summary += ", " + days[i];
                    }
                }
            }
            break;
        case 5:
            if(repeatevery<2){
                summary += "Monthly";
            } else {
                summary += "Every "+repeatevery+" months";
            }
            if(dayofmonth){
                summary += " on day "+startdate.getDate();
            } else {
                summary += " on the "+getNth(startdate);
            }
            break;
        case 6:
            if(repeatevery<2){
                summary += "Annually on "+parsedstartdate;
            } else {
                summary += "Every "+repeatevery+" years on "+parsedstartdate;
            }
            break;
    }
    switch(end){
        case "after":
            summary += ", "+occurances+" times";
            break;
        case "on":
            summary += ", until "+parsedenddate;
            break;
    }
    
    } else {
        summary = "Once";
    }
    
    $("#ne-repeat-summary").html(summary);
}
function generate_end_date(){
    var start = new Date();
    start = time_parser($("#ne-evt-repeat-startson").val() + " " + $("#ne-evt-time-start").val());
    var preset = parseInt($("#ne-evt-repeat-repeats").val());
    var inc = parseInt($("#ne-evt-repeat-repeatevery").val());
    
    var defaultinc = 0;
    var end = start.getTime()/1000;
    
    switch(preset){
        case 0:
            defaultinc = 86400*5*inc;
            break;
        case 4:
            defaultinc = 604800*5*inc;
            break;
        case 5:
            defaultinc = 2592000*35*inc;
            break;
        case 6:
            defaultinc = 31536000*5*inc;
            break;
        default:
            defaultinc = 604800*5;
    }
    
    end += defaultinc;
    
    var output = new Date(end*1000);
    
    for(var i = start.getFullYear();i<output.getFullYear();i++){
        if(i%4===0 && !(i===start.getFullYear() && (start.getMonth()+1)>=3)){
            end += 86400;
        }
    }
    output = new Date(end*1000);
    
    var date_end_month = output.getMonth()+1;
    var date_end_day = output.getDate();
    var date_end_year = output.getFullYear();
    date_end_month<10?date_end_month="0"+date_end_month:"";
    date_end_day<10?date_end_day="0"+date_end_day:"";
    
    $("#ne-evt-endson-date").val(date_end_month + "/" + date_end_day + "/" + date_end_year);
}
function show_repeat_dialogbox(){
    $("#wpg").addClass("ui-popup-background-effect");
    $("#ne-repeat-wrapper").addClass("ui-popup-active");
}
function hide_repeat_dialogbox(){
    $("#wpg").removeClass("ui-popup-background-effect");
    $("#ne-repeat-wrapper").removeClass("ui-popup-active");
    if(repeatset){
        if($("#ne-evt-endson-after").is(":checked")){
            repeat_occurance_reset();
        }
        repeat_days_reset();
    }
}

$(document).keydown(function(event) {
    if (event.keyCode === 27) {
        hide_repeat_dialogbox();
        hide_settings_dialogbox();
        if(!repeatset) {
            $("#ne-evt-repeatbox").prop("checked", false);
        }
        if(!settingsset){
            $("#ne-evt-settingsbox").prop("checked", false);
        }
    }
});

$(document).on("click", "#ne-evt-repeatbox", function(){
    if($("#ne-evt-repeatbox").is(":checked") && !repeatset){
        reset_state("#ne-repeat-wrapper",repeatstate);
        show_repeat_dialogbox();
    } else if($("#ne-evt-repeatbox").is(":checked") && repeatset) {
        $("#ne-repeat-edit").removeClass("wpg-nodisplay");
        $("#ne-repeat-summary-display").removeClass("wpg-nodisplay");
        $("#ne-label-repeatbox").html("Repeat: ");
        if(!$("#ne-evt-settings-usedefault").is(":checked")) {
            $("#ne-evt-settings-repeatgate").prop("disabled",false);
            $("#ne-settings-repetition-annotation").addClass("wpg-nodisplay").removeClass("ui-container-block");
            save_state("#ne-settings-wrapper", settingsstate);
        }
    } else if(!$("#ne-evt-repeatbox").is(":checked") && repeatset){
        $("#ne-repeat-edit").addClass("wpg-nodisplay");
        $("#ne-repeat-summary-display").addClass("wpg-nodisplay");
        $("#ne-label-repeatbox").html("Repeat...");
        $("#ne-settings-repetition-annotation").removeClass("wpg-nodisplay").addClass("ui-container-block");
        $("#ne-evt-settings-repeatgate").prop("checked",false).prop("disabled",true);
        $("#ne-settings-repeats-table").addClass("wpg-nodisplay");
        var gates = $("#ne-evt-settings-attendancegate:checked,#ne-evt-settings-blacklistgate:checked,#ne-evt-settings-daygate:checked,"+
        "#ne-evt-settings-durationgate:checked,#ne-evt-settings-locationgate:checked,#ne-evt-settings-repeatgate:checked,"+
        "#ne-evt-settings-timegate:checked");
        if(gates.length === 0) {
            settingsset = false;
            reset_settings();
        }
        save_state("#ne-settings-wrapper", settingsstate);
    }
    save_state("#ne-repeat-wrapper", repeatstate);
    $("#ne-repeat-dialogbox").center();
});

$(document).on("click", "#ne-repeat-x, #ne-repeat-btn-cancel", function(){
    hide_repeat_dialogbox();
    if(!repeatset){
        $("#ne-evt-repeatbox").prop("checked", false);
    }
    if(Object.keys(repeatstate).length!==0){
        reset_state("#ne-repeat-wrapper", repeatstate);
    }
});

$(document).on("click", "#ne-evt-endson-never", function(){
    if($("#ne-evt-endson-never").is(":checked")){
        $("#ne-evt-endson-occurances").prop("disabled", true).val("");
        $("#ne-evt-endson-date").prop("disabled", true).val("");
    }
});

$(document).on("click", "#ne-evt-endson-after", function(){
    if($("#ne-evt-endson-after").is(":checked")){
        $("#ne-evt-endson-date").prop("disabled", true).val("");
        switch($("#ne-evt-repeat-repeats").val()){
            case "0":
            case "6":
                $("#ne-evt-endson-occurances").prop("disabled", false).val("5");
                break;
            default:
                $("#ne-evt-endson-occurances").prop("disabled", false).val("35");
        }
    }
});

$(document).on("click", "#ne-evt-endson-on", function(){
    if($("#ne-evt-endson-on").is(":checked")){
        $("#ne-evt-endson-occurances").prop("disabled", true).val("");
        $("#ne-evt-endson-date").prop("disabled", false);
        generate_end_date();
    }
});

$(document).on("change", "#ne-evt-repeat-repeats", function(){
    switch($("#ne-evt-repeat-repeats").val()) {
        case "0":
            $("#ne-repeat-table-1").removeClass("wpg-nodisplay");
            $("#ne-repeat-table-2, #ne-repeat-table-3").addClass("wpg-nodisplay");
            $("#ne-repeat-repeatevery-label").html("days");
            break;
        case "1":
        case "2":
        case "3":
            $("#ne-repeat-table-1, #ne-repeat-table-2, #ne-repeat-table-3").addClass("wpg-nodisplay");
            break;
        case "4":
            $("#ne-repeat-table-1, #ne-repeat-table-2").removeClass("wpg-nodisplay");
            $("#ne-repeat-table-3").addClass("wpg-nodisplay");
            $("#ne-label-repeat-repeatevery").html("weeks");
            break
        case "5":
            $("#ne-repeat-table-1, #ne-repeat-table-3").removeClass("wpg-nodisplay");
            $("#ne-repeat-table-2").addClass("wpg-nodisplay");
            $("#ne-label-repeat-repeatevery").html("months");
            break;
        case "6":
            $("#ne-repeat-table-1").removeClass("wpg-nodisplay");
            $("#ne-repeat-table-2, #ne-repeat-table-3").addClass("wpg-nodisplay");
            $("#ne-label-repeat-repeatevery").html("years");
            break;
    }
});

$(document).on("change", "#ne-evt-repeat-repeats, #ne-evt-repeat-repeatevery, #ne-evt-repeat-repeatson-0, "+
        "#ne-evt-repeat-repeatson-1, #ne-evt-repeat-repeatson-2, #ne-evt-repeat-repeatson-3, #ne-evt-repeat-repeatson-4, "+
        "#ne-evt-repeat-repeatson-5, #ne-evt-repeat-repeatson-6, #ne-evt-repeat-repeatby-dayofmonth, "+
        "#ne-evt-repeat-repeatby-dayofweek, #ne-evt-endson-never, #ne-evt-endson-after, #ne-evt-endson-on, "+
        "#ne-evt-endson-occurances, #ne-evt-endson-date", generate_summary);

$(document).on("change", "#ne-evt-date-start", function(){
    generate_summary();
    $("#ne-repeat-summary-display").html($("#ne-repeat-summary").html());
    $("#ne-evt-repeat-startson").val($("#ne-evt-date-start").val());
    if(!repeatset){
        var time_start = $("#ne-evt-time-start").val();
        var date_start = $("#ne-evt-date-start").val();
        
        var day = new Date();
        day = time_parser(date_start + " " + time_start);
        day = day.getDay();
        
        for(var i=0;i<7;i++){
            $("#ne-evt-repeat-repeatson-"+i).prop("checked", false);
        }
        $("#ne-evt-repeat-repeatson-"+day).prop("checked", true);
    }
    save_state("#ne-repeat-wrapper", repeatstate);
});

$(document).on("click", "#ne-repeat-btn-done", function(){
    repeatset = true;
    hide_repeat_dialogbox();
    save_state("#ne-repeat-wrapper",repeatstate);
    $("#ne-repeat-edit").removeClass("wpg-nodisplay");
    $("#ne-repeat-summary-display").removeClass("wpg-nodisplay").html($("#ne-repeat-summary").html());
    if(!$("#ne-evt-settings-usedefault").is(":checked")) {
        $("#ne-evt-settings-repeatgate").prop("disabled",false);
        $("#ne-settings-repetition-annotation").addClass("wpg-nodisplay").removeClass("ui-container-block");
    }
    save_state("#ne-settings-wrapper", settingsstate);
    $("#ne-label-repeatbox").html("Repeat: ");
});

$(document).on("click", "#ne-repeat-edit", function(){
    show_repeat_dialogbox();
    $("#ne-repeat-dialogbox").center();
});
