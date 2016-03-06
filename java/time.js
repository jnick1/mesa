/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//set datepickers
$(function(){
    $("#ne-evt-date-start").datepicker({ dateformat: "m/dd/yy"});
    $("#ne-evt-date-end").datepicker({ dateformat: "m/dd/yy"});
});

function time_parser(string){
    //format is mm/dd/yyyy h(h):mm[a/p]m
    var regex = /(\d{2})\/(\d{2})\/(\d{4})\s+(\d{1,2}):(\d{2})([ap]m)/;
    var outstart = string.match(regex);
    var output = new Date(
            parseInt(outstart[3]), parseInt(outstart[1]-1), 
            parseInt(outstart[2]), (((outstart[4]==="12" && outstart[6]==="am")?0:parseInt(outstart[4]))+(outstart[6]==="pm"?12:0)),
            parseInt(outstart[5]),0);
            
    return output;
}

$(document).ready(function client_time(){
    var time = Math.floor(Date.now()/1000);
    var UTS_start = Math.ceil(time/(30*60))*(30*60);
    var UTS_end = Math.ceil((time+3600)/(30*60))*(30*60);
    
    var time_start = new Date(UTS_start*1000);
    var time_end = new Date(UTS_end*1000);
    
    var date_start_month = time_start.getMonth()+1;
    var date_start_day = time_start.getDate();
    var date_start_year = time_start.getFullYear();
    
    var date_end_month = time_end.getMonth()+1;
    var date_end_day = time_end.getDate();
    var date_end_year = time_end.getFullYear();
    
    var hours_start = time_start.getHours();
    var hours_end = time_end.getHours();
    var minutes = time_start.getMinutes();
    
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
    if (hours_start == 0) {
        hours_start = 12;
    }
    
    if(hours_end >= 12) {
        suffix_end = "pm";
        hours_end -= 12;
    }
    if (hours_end == 0) {
        hours_end = 12;
    }
    
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    
    $("#ne-evt-time-start").val(hours_start + ":" + minutes + suffix_start); //hours1 + ":" + minutes + suffix
    $("#ne-evt-time-end").val(hours_end + ":" + minutes + suffix_end);
    
    $("#ne-evt-date-start").val(date_start_month + "/" + date_start_day + "/" + date_start_year);
    $("#ne-evt-date-end").val(date_end_month + "/" + date_end_day + "/" + date_end_year);

});

$(document).on("click", ".ne-dropdown-timestart-item", function duration_maintenance(){
    
    var start = time_parser($("#ne-evt-date-start").val() + " " + $("#ne-evt-time-start").val());
    var end = time_parser($("#ne-evt-date-end").val() + " " + $("#ne-evt-time-end").val());
    var diff = end.getTime()-start.getTime();
    
    var newstart = time_parser($("#ne-evt-date-start").val() + " " + $(this).html());
    var newend = new Date(newstart.getTime()+diff);
    
    var newendtext = (newend.getHours()>12?newend.getHours()-12:newend.getHours()===0?"12":newend.getHours())+":"+(newend.getMinutes()<10?"0"+newend.getMinutes():newend.getMinutes())+(newend.getHours()>=12?"pm":"am");
    var newenddate = ((newend.getMonth()+1)<10?("0"+(newend.getMonth()+1)):(newend.getMonth()+1))+"/"+(newend.getDate()<10?"0"+newend.getDate():newend.getDate())+"/"+newend.getFullYear();
    
    $("#ne-evt-time-end").val(newendtext);
    $("#ne-evt-date-end").val(newenddate);
});

$(document).on("click", "#ne-evt-time-end", function generate_end_times(){
        var end_time_html = "";
        for(var i=0;i<48;i++){
            var flr = Math.floor(i/2);
            var time = (i<24?(flr===0?"12":flr):(flr-12===0?"12":flr-12))+":"+(i%2===0?"0":"")+((i%2)*30)+(i<24?"am":"pm");
            end_time_html += "<div class=\"ui-dropdown-item ne-dropdown-timeend-item\">"+time+"</div>\n";
        }
        $("#ne-dropdown-timeend-panel").html(end_time_html);
    });
  
$(document).on("click", ".ne-dropdown-timestart-item", function set_start_time() {
    $("#ne-evt-time-start").val($(this).html());
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
    $(document).on("click", ".ne-dropdown-timestart-item", hide("jq-dropdown"));
    
    });

$(document).on("click", ".ne-dropdown-timeend-item", function set_end_time() {
    $("#ne-evt-time-end").val($(this).html());
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
    $(document).on("click", ".ne-dropdown-timeend-item", hide("jq-dropdown"));
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

$(document).on("keyup", "#ne-evt-time-end", function(e){
    var code = e.which;
    if(code===13||code===9){
        generate_end_times();
    }
});