/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    var times = $(".el-content-event-time");
    var parsedtimes = {};
    times.each(function(index, elem){
        parsedtimes[$(elem).attr("id")] = $(elem).html().trim();
    });
    var today = new Date();
    for(var time in parsedtimes) {
        var newtime = new Date(today.getUTCFullYear()+"/"+(today.getUTCMonth()+1)+"/"+today.getUTCDate()+" "+parsedtimes[time]+":00 UTC ");

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

        $("#"+time).html(hours + ":" + minutes + suffix); //hours1 + ":" + minutes + suffix
    }
    
//    var times = $(".el-content-event-time");
//    times.each(function(){
//        var start_date = $(this).prev(".el-content-event-date");
//        var end_date = $(this).next(".el-content-event-date");
//        var newtime = new Date();
//        if(start_date.length !== 0) {
//            if(/^d{1}/.test($(this).val())){
//                $(this).val("0"+$(this).val());
//            }
//            newtime = new Date(start_date + " " + $(this).val() + ":00 UTC");
//        } else if(end_date.length !== 0) {
//            if(/^d{1}/.test($(this).val())){
//                $(this).val("0"+$(this).val());
//            }
//            newtime = new Date(end_date + " " + $(this).val() + ":00 UTC");
//        }
//        
//        var year = newtime.getFullYear();
//        var month = newtime.getMonth();
//        var date = newtime.getDate();
//        var hours = newtime.getHours();
//        var minutes = newtime.getMinutes();
//
//        var suffix = "am";
//        if(month < 10) {
//            month = "0" + month;
//        }
//        if(date < 10) {
//            date = "0" + date;
//        }
//
//        if (hours >= 12) {
//            suffix = "pm";
//            hours -= 12;
//        }
//        if (hours === 0) {
//            hours = 12;
//        }
//
//        if (minutes < 10) {
//            minutes = "0" + minutes;
//        }
//
//        $(this).html(hours + ":" + minutes + suffix); //hours1 + ":" + minutes + suffix
//        if(start_date.length !== 0) {
//            start_date.html(month + "/" + date + "/" + year);
//        } else if(end_date.length !== 0) {
//            end_date.html(month + "/" + date + "/" + year);
//        }
//    });
    
});