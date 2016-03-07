/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var repeatset = false;

$(function(){
    $("#ne-evt-endson-date").datepicker({ dateformat: "mm/dd/yy"});
});
function repeat_options_reset(){
    //reset "Repeats:"
    $("#ne-evt-repeat-repeats").val("0");
    //reset "Repeat every:"
    $("#ne-evt-repeat-repeatevery").val("1");
    //reset "Repeats on:"
    var day = new Date();
    day = time_parser($("#ne-evt-date-start").val() + " " + $("#ne-evt-time-start").val());
    day = day.getDay();
    
    for(var i=0;i<7;i++){
        $("#ne-evt-repeat-repeatson-"+i).prop("checked", false);
    }
    $("#ne-evt-repeat-repeatson-"+day).prop("checked", true);
    //reset "Repeat by:"
    $("#ne-evt-repeat-repeatby-dayofmonth").prop("checked", true);
    $("#ne-repeat-table-2").addClass("wpg-nodisplay");
    $("#ne-repeat-table-3").addClass("wpg-nodisplay");
    //reset "Ends:"
    $("#ne-evt-endson-never").prop("checked", true);
    $("#ne-evt-endson-occurances").prop("disabled", true).val("");
    $("#ne-evt-endson-date").prop("disabled", true).val("");
    //reset "Summary:"
    generate_summary();
}
function getNth(dat) {
        var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday","Saturday"],
            nth  = ["first", "second", "third", "fourth", "last"],
            d    = dat ? dat instanceof Date ? dat : new Date(dat) : new Date(),
            date = d.getDate(),
            day  = d.getDay(),
            n    = Math.ceil(date / 7);
        
        return nth[n-1] + ' ' + days[day];
    }
function generate_summary(){
    var summary = "";
    var repeats = parseInt($("#ne-evt-repeat-repeats").val());
    var repeatevery = parseInt($("#ne-evt-repeat-repeatevery").val());
    var startdate = new Date();
    startdate = time_parser($("#ne-evt-repeat-startson").val()+" 12:00am");
    var repeatson = [];
    for(var i=0;i<7;i++){
        repeatson.push($("#ne-evt-repeat-repeatson-"+i).is(":checked"));
    }
    var dayofmonth = $("#ne-evt-repeat-repeatby-dayofmonth").is(":checked");
    var end = $("#ne-evt-endson-never").is(":checked")?"never":$("#ne-evt-endson-after").is(":checked")?"after":"on";
    var occurances = $("#ne-evt-endson-occurances").val();
    var enddate = new Date();
    enddate = time_parser($("#ne-evt-endson-date").val()+" "+$("#ne-evt-time-end").val());
    var parsedenddate = "";
    var parsedstartdate = "";
    
    {
        var month = enddate.getMonth()+1;
        var date = enddate.getDate();
        var year = enddate.getFullYear();
        
        switch(month){
            case 1:
                parsedenddate += "Jan ";
                break;
            case 2:
                parsedenddate += "Feb ";
                break;
            case 3:
                parsedenddate += "Mar ";
                break;
            case 4:
                parsedenddate += "Apr ";
                break;
            case 5:
                parsedenddate += "May ";
                break;
            case 6:
                parsedenddate += "Jun ";
                break;
            case 7:
                parsedenddate += "Jul ";
                break;
            case 8:
                parsedenddate += "Aug ";
                break;
            case 9:
                parsedenddate += "Sep ";
                break;
            case 10:
                parsedenddate += "Oct ";
                break;
            case 11:
                parsedenddate += "Nov ";
                break;
            case 12:
                parsedenddate += "Dec ";
                break;
        }
        parsedenddate += date+", "+year;
    }
    {
        var month = startdate.getMonth()+1;
        var date = startdate.getDate();
        
        switch(month){
            case 1:
                parsedenddate += "January ";
                break;
            case 2:
                parsedenddate += "February ";
                break;
            case 3:
                parsedenddate += "March ";
                break;
            case 4:
                parsedenddate += "April ";
                break;
            case 5:
                parsedenddate += "May ";
                break;
            case 6:
                parsedenddate += "June ";
                break;
            case 7:
                parsedenddate += "July ";
                break;
            case 8:
                parsedenddate += "August ";
                break;
            case 9:
                parsedenddate += "September ";
                break;
            case 10:
                parsedenddate += "October ";
                break;
            case 11:
                parsedenddate += "November ";
                break;
            case 12:
                parsedenddate += "December ";
                break;
        }
        parsedstartdate += date;
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
    
    $("ne-repeat-summary").val(summary);
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
}

$(document).ready(function(){
    $("#ne-evt-repeatbox").prop("checked", false);
    repeat_options_reset();
});

$(document).on("click", "#ne-evt-repeatbox", function(){
    if($("#ne-evt-repeatbox").is(":checked") && !repeatset){
        show_repeat_dialogbox();
        $("#ne-evt-repeat-startson").val($("#ne-evt-date-start").val());
    } else if($("#ne-evt-repeatbox").is(":checked") && repeatset) {
        $("#ne-repeat-edit").removeClass("wpg-nodisplay");
        $("#ne-repeat-summary-display").removeClass("wpg-nodisplay");
        $("#ne-label-repeatbox").html("Repeat: ");
    } else if(!$("#ne-evt-repeatbox").is(":checked") && repeatset){
        $("#ne-repeat-edit").addClass("wpg-nodisplay");
        $("#ne-repeat-summary-display").addClass("wpg-nodisplay");
        $("#ne-label-repeatbox").html("Repeat...");
    }
});

$(document).on("click", "#ne-repeat-x", function(){
    hide_repeat_dialogbox();
    if(!repeatset){
        repeat_options_reset();
        $("#ne-evt-repeatbox").prop("checked", false);
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
            $("#ne-repeat-repeatevery-label").html("weeks");
            break
        case "5":
            $("#ne-repeat-table-1, #ne-repeat-table-3").removeClass("wpg-nodisplay");
            $("#ne-repeat-table-2").addClass("wpg-nodisplay");
            $("#ne-repeat-repeatevery-label").html("months");
            break;
        case "6":
            $("#ne-repeat-table-1").removeClass("wpg-nodisplay");
            $("#ne-repeat-table-2, #ne-repeat-table-3").addClass("wpg-nodisplay");
            $("#ne-repeat-repeatevery-label").html("years");
            break;
    }
});

$(document).on("change", "#ne-evt-repeat-repeats, #ne-evt-repeat-repeatevery, #ne-evt-repeat-repeatson-0, "+
        "#ne-evt-repeat-repeatson-1, #ne-evt-repeat-repeatson-2, #ne-evt-repeat-repeatson-3, #ne-evt-repeat-repeatson-4, "+
        "#ne-evt-repeat-repeatson-5, #ne-evt-repeat-repeatson-6, #ne-evt-repeat-repeatby-dayofmonth, "+
        "#ne-evt-repeat-repeatby-dayofweek, #ne-evt-endson-never, #ne-evt-endson-after, #ne-evt-endson-on, "+
        "#ne-evt-endson-occurances, #ne-evt-endson-date", generate_summary());

$(document).on("click", "#ne-repeat-btn-done", function(){
    hide_repeat_dialogbox();
    $("#ne-repeat-edit").removeClass("wpg-nodisplay");
    $("#ne-repeat-summary-display").removeClass("wpg-nodisplay").val($("ne-repeat-summary").val());
    $("#ne-label-repeatbox").html("Repeat: ");
    repeatset = true;
});

$(document).on("click", "#ne-repeat-btn-cancel", function(){
    hide_repeat_dialogbox();
    if(!repeatset){
        repeat_options_reset();
        $("#ne-evt-repeatbox").prop("checked", false);
    }
});

$(document).on("click", "#ne-repeat-edit", function(){
    show_repeat_dialogbox();
    $("#ne-evt-repeat-startson").val($("#ne-evt-date-start").val());
});