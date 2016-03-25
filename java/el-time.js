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
        var newtime = new Date(today.getFullYear()+"/"+(today.getMonth()+1)+"/"+today.getDate()+" "+parsedtimes[time]+":00 UTC ");

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
});