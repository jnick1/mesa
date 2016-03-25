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
    $("#ne-evt-repeatbox").prop("checked", false);
    repeat_options_reset();
    save_state("#ne-repeat-wrapper",repeatstate);
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
    startdate = time_parser($("#ne-evt-date-start").val()+" "+$("#ne-evt-time-start").val());
    var repeatson = [];
    for(var i=0;i<7;i++){
        repeatson.push($("#ne-evt-repeat-repeatson-"+i).is(":checked"));
    }
    var dayofmonth = $("#ne-evt-repeat-repeatby-dayofmonth").is(":checked");
    var end = $("#ne-evt-endson-never").is(":checked")?"never":$("#ne-evt-endson-after").is(":checked")?"after":"on";
    var occurances = validate_natural_number($("#ne-evt-endson-occurances").val())?parseInt($("#ne-evt-endson-occurances").val()):(repeats===0 || repeats===6)?5:35;
    var enddate = new Date();
    if($("#ne-evt-endson-date").val()!==""){
        enddate = time_parser($("#ne-evt-endson-date").val()+" "+$("#ne-evt-time-end").val());
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
        repeat_occurance_reset();
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
        }
    } else if(!$("#ne-evt-repeatbox").is(":checked") && repeatset){
        $("#ne-repeat-edit").addClass("wpg-nodisplay");
        $("#ne-repeat-summary-display").addClass("wpg-nodisplay");
        $("#ne-label-repeatbox").html("Repeat...");
        $("#ne-settings-repetition-annotation").removeClass("wpg-nodisplay").addClass("ui-container-block");
        $("#ne-evt-settings-repeatgate").prop("checked",false).prop("disabled",true);
    }
    save_state("#ne-settings-wrapper", settingsstate);
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
    $("#ne-evt-repeat-startson").val($("#ne-evt-date-start").val());
    $("#ne-settings-dialogbox").center();
});
