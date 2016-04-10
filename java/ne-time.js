/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//set datepickers
$(function(){
    $("#ne-evt-date-start").datepicker({ dateformat: "mm/dd/yy"});
    $("#ne-evt-date-end").datepicker({ dateformat: "mm/dd/yy"});
});

var time_start = "";
var time_end = "";
var date_start = "";
var date_end = "";

function time_parser(string){
    //format is mm/dd/yyyy h(h):mm[a/p]m
    var regex = /(\d{2})\/(\d{2})\/(\d{4})\s+(\d{1,2}):(\d{2})([ap]m)/;
    var outstart = string.match(regex);
    var output = new Date(
            parseInt(outstart[3]), parseInt(outstart[1]-1), 
            parseInt(outstart[2]), (((outstart[4]==="12" && outstart[6]==="am")?0:parseInt(outstart[4]))+(outstart[6]==="pm" && outstart[4]!=="12"?12:0)),
            parseInt(outstart[5]),0);
            
    return output;
}
function client_time(){
    var time = Math.floor(Date.now()/1000);
    var UTS_start = Math.ceil(time/(30*60))*(30*60);
    var UTS_end = Math.ceil((time+3600)/(30*60))*(30*60);
    
    var start = new Date(UTS_start*1000);
    var end = new Date(UTS_end*1000);
    
    var date_start_month = start.getMonth()+1;
    var date_start_day = start.getDate();
    var date_start_year = start.getFullYear();
    
    var date_end_month = end.getMonth()+1;
    var date_end_day = end.getDate();
    var date_end_year = end.getFullYear();
    
    var hours_start = start.getHours();
    var hours_end = end.getHours();
    var minutes = start.getMinutes();
    
    date_start_month<10?date_start_month="0"+date_start_month:"";
    date_end_month<10?date_end_month="0"+date_end_month:"";
    date_start_day<10?date_start_day="0"+date_start_day:"";
    date_end_day<10?date_end_day="0"+date_end_day:"";

    var suffix_start = "am";
    var suffix_end = "am";

    if (hours_start >= 12) {
        suffix_start = "pm";
        hours_start -= 12;
    }
    if (hours_start === 0) {
        hours_start = 12;
    }
    
    if(hours_end >= 12) {
        suffix_end = "pm";
        hours_end -= 12;
    }
    if (hours_end === 0) {
        hours_end = 12;
    }
    
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    
    $("#ne-evt-time-start").val(hours_start + ":" + minutes + suffix_start); //hours1 + ":" + minutes + suffix
    $("#ne-evt-time-end").val(hours_end + ":" + minutes + suffix_end);
    
    $("#ne-evt-date-start").val(date_start_month + "/" + date_start_day + "/" + date_start_year);
    $("#ne-evt-date-end").val(date_end_month + "/" + date_end_day + "/" + date_end_year);
    
    time_start = hours_start + ":" + minutes + suffix_start;
    time_end = hours_end + ":" + minutes + suffix_end;
    date_start = date_start_month + "/" + date_start_day + "/" + date_start_year;
    date_end = date_end_month + "/" + date_end_day + "/" + date_end_year;
}
function compare_time(first, second){
    var a = time_parser(first);
    var b = time_parser(second);
    if(a.getTime()>b.getTime()){
        return 1;
    } else if (a.getTime()===b.getTime()){
        return 0;
    } else {
        return -1;
    }
}
function duration_maintenance(){
    
    var start = time_parser(date_start + " " + time_start);
    var end = time_parser(date_end + " " + time_end);
    var diff = end.getTime()-start.getTime();
    
    var newstart = time_parser($("#ne-evt-date-start").val() + " " + $("#ne-evt-time-start").val());
    var newend = new Date(newstart.getTime()+diff);
    
    var newendtext = (newend.getHours()>12?newend.getHours()-12:newend.getHours()===0?"12":newend.getHours())+":"+(newend.getMinutes()<10?"0"+newend.getMinutes():newend.getMinutes())+(newend.getHours()>=12?"pm":"am");
    var newenddate = ((newend.getMonth()+1)<10?("0"+(newend.getMonth()+1)):(newend.getMonth()+1))+"/"+(newend.getDate()<10?"0"+newend.getDate():newend.getDate())+"/"+newend.getFullYear();
    
    $("#ne-evt-time-end").val(newendtext);
    $("#ne-evt-date-end").val(newenddate);
    
    time_start = $("#ne-evt-time-start").val();
    time_end = $("#ne-evt-time-end").val();
    date_start = $("#ne-evt-date-start").val();
    date_end = $("#ne-evt-date-end").val();
}
function hide(event) {

    // In some cases we don't hide them
    var targetGroup = event ? $(event.target).parents().addBack() : null;

    // Are we clicking anywhere in a jq-dropdown?
    if (targetGroup && targetGroup.is('.jq-dropdown')) {
        // Is it a jq-dropdown menu?
        if (targetGroup.is('.jq-dropdown-menu')) {
            // Did we click on an option? If so close it.
            if (!targetGroup.is('A')) return;
        } else {
            // Nope, it's a panel. Leave it open.
            return;
        }
    }

    // Hide any jq-dropdown that may be showing
    $(document).find('.jq-dropdown:visible').each(function () {
        var jqDropdown = $(this);
        jqDropdown
            .hide()
            .removeData('jq-dropdown-trigger')
            .trigger('hide', { jqDropdown: jqDropdown });
    });

    // Remove all jq-dropdown-open classes
    $(document).find('.jq-dropdown-open').removeClass('jq-dropdown-open');

};
function generate_end_times(){
    var end_time_html = "";
    for(var i=0;i<48;i++){
        var flr = Math.floor(i/2);
        var time = (i<24?(flr===0?"12":flr):(flr-12===0?"12":flr-12))+":"+(i%2===0?"0":"")+((i%2)*30)+(i<24?"am":"pm");
        end_time_html += "<div class=\"ui-dropdown-item ne-dropdown-timeend-item\">"+time+"</div>\n";
    }
    $("#ne-dropdown-timeend-panel").html(end_time_html);
}

$("#ne-evt-date-start").datepicker({
  onSelect: function() {
    $(this).change();
  }
});
$("#ne-evt-date-end").datepicker({
  onSelect: function() {
    $(this).change();
  }
});

$(document).ready(function (){
    if($("#wpg").attr("data-eventid")) {
        var times = $(".ne-top-time");
        var parsedtimes = {};
        times.each(function(index, elem){
            parsedtimes[$(elem).attr("id")] = $(elem).val();
        });
        for(var time in parsedtimes) {
            var newtime;
            if(time==="ne-evt-time-start") {
                var dateO = $("#ne-evt-date-start").val();
                newtime = new Date(dateO.substring(6)+"/"+dateO.substring(0,2)+"/"+dateO.substring(3,5)+" "+parsedtimes[time]+":00 UTC ");
            } else if(time==="ne-evt-time-end") {
                var dateO = $("#ne-evt-date-end").val();
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

            $("#"+time).val(hours + ":" + minutes + suffix); //hours1 + ":" + minutes + suffix
            
            if(time==="ne-evt-time-start"){
                time_start = hours + ":" + minutes + suffix;
                $("#ne-evt-date-start").removeAttr("value");
                $("#ne-evt-date-start").datepicker("setDate",newtime);
                date_start = $("#ne-evt-date-start").val();
            } else if(time==="ne-evt-time-end") {
                time_end = hours + ":" + minutes + suffix;
                $("#ne-evt-date-end").removeAttr("value");
                $("#ne-evt-date-end").datepicker("setDate",newtime);
                date_end =  $("#ne-evt-date-end").val();
            }
        }
    } else {
        client_time();
    }
});

$(document).on("click", "#ne-evt-time-end", generate_end_times);
  
$(document).on("click", ".ne-dropdown-timestart-item", function set_start_time() {
    $("#ne-evt-time-start").val($(this).html());
    hide("jq-dropdown");
    duration_maintenance();
});

$(document).on("change", "#ne-evt-date-start", function(){
    duration_maintenance();
});

$(document).on("change", "#ne-evt-date-end", function(){
    date_end = $("#ne-evt-date-end").val();
});

$(document).on("click", ".ne-dropdown-timeend-item", function set_end_time() {
    $("#ne-evt-time-end").val($(this).html());
    hide("jq-dropdown");
    time_end = $("#ne-evt-time-end").val();
    });

$(document).on("change", "#ne-evt-date-end", function time_confliction(){
    var end = time_parser($("#ne-evt-date-end").val() + " " + $("#ne-evt-time-end").val());
    var start = time_parser($("#ne-evt-date-start").val() + " " + $("#ne-evt-time-start").val());
            
    if(end<start) {
        $("#ne-evt-date-end").addClass("ne-time-conflict");
        $("#ne-evt-time-end").addClass("ne-time-conflict");
    } else {
        $("#ne-evt-date-end").removeClass("ne-time-conflict");
        $("#ne-evt-time-end").removeClass("ne-time-conflict");
    }
});

$(document).on("keydown", "#ne-evt-time-start", function(e){
    var code = e.which;
    if(code===13||code===9){
        generate_end_times();
    }
});
