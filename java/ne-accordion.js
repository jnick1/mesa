/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $(".ne-opti-table-accordion-header-title").children("span").each(function(){
        var timestamp = $(this).html();
        var date = new Date(parseInt(timestamp)*1000);
        var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        var month = months[date.getMonth()];
        var day = "0"+date.getDate();
        var year = date.getFullYear();
        $(this).html(month+" "+day.substr(-2)+", "+year);
    });
    $(".ne-opti-startdate").each(function(){
        var timestamp = $(this).html();
        var date = new Date(parseInt(timestamp)*1000);
        var month = "0"+(date.getMonth()+1);
        var day = "0"+date.getDate();
        var year = date.getFullYear();
        $(this).html(month.substr(-2)+"/"+day.substr(-2)+"/"+year)
    });
    $(".ne-opti-starttime").each(function(){
        var timestamp = $(this).html();
        var date = new Date(parseInt(timestamp)*1000);
        var hour = (date.getHours()+1>12?date.getHours()-11:date.getHours()+1);
        var minute = "0"+date.getMinutes();
        var suffix = (date.getHours()+1>=12?"pm":"am");
        $(this).html(hour+":"+minute.substr(-2)+suffix)
    });
    $(".ne-opti-enddate").each(function(){
        var timestamp = $(this).html();
        var date = new Date(parseInt(timestamp)*1000);
        var month = "0"+(date.getMonth()+1);
        var day = "0"+date.getDate();
        var year = date.getFullYear();
        $(this).html(month.substr(-2)+"/"+day.substr(-2)+"/"+year)
    });
    $(".ne-opti-endtime").each(function(){
        var timestamp = $(this).html();
        var date = new Date(parseInt(timestamp)*1000);
        var hour = (date.getHours()+1>12?date.getHours()-11:date.getHours()+1);
        var minute = "0"+date.getMinutes();
        var suffix = (date.getHours()+1>=12?"pm":"am");
        $(this).html(hour+":"+minute.substr(-2)+suffix)
    });
});

$(document).on("click", ".ne-opti-table-accordion-header", function(){
    if($(this).next().hasClass("ne-opti-table-accordion-hidden")) {
        $(this).addClass("ne-opti-table-accordion-header-open");
        $(".ne-opti-table-accordion-content").addClass("ne-opti-table-accordion-hidden");
        $(this).next().removeClass("ne-opti-table-accordion-hidden");
        $(this).children("div").addClass("goog-icon-dropdown-arrow-down");
        $(this).children("div").removeClass("goog-icon-dropdown-arrow-right");
    } else {
        $(this).removeClass("ne-opti-table-accordion-header-open");
        $(this).next().addClass("ne-opti-table-accordion-hidden");
        $(this).children("div").removeClass("goog-icon-dropdown-arrow-down");
        $(this).children("div").addClass("goog-icon-dropdown-arrow-right");
    }
    $("#ne-opti-dialogbox").center()
});

$(document).on("click", ".ne-opti-table-accordion-attendees-header", function(){
    if($(this).next().hasClass("ne-opti-table-accordion-attendees-hidden")) {
        $(".ne-opti-table-accordion-attendees-header").removeClass("ne-opti-table-accordion-header-open");
        $(".ne-opti-table-accordion-attendees-header").children("div").removeClass("goog-icon-dropdown-arrow-down").addClass("goog-icon-dropdown-arrow-right");
        $(this).addClass("ne-opti-table-accordion-header-open");
        $(".ne-opti-table-accordion-attendees-content").addClass("ne-opti-table-accordion-attendees-hidden");
        $(this).next().removeClass("ne-opti-table-accordion-attendees-hidden");
        $(this).children("div").addClass("goog-icon-dropdown-arrow-down").removeClass("goog-icon-dropdown-arrow-right");
    } else {
        $(this).removeClass("ne-opti-table-accordion-header-open");
        $(this).next().addClass("ne-opti-table-accordion-attendees-hidden");
        $(this).children("div").removeClass("goog-icon-dropdown-arrow-down").addClass("goog-icon-dropdown-arrow-right");
    }
    $("#ne-opti-dialogbox").center()
});