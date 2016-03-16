/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function sizechange(){
    
    var notifCounter = 2;
    var activeCounter = 1;
    
    $("#details-notifications-addlink").click(function(){
        
        var activeString = ""
                +$("#details-notifications-1").length
                +$("#details-notifications-2").length
                +$("#details-notifications-3").length
                +$("#details-notifications-4").length
                +$("#details-notifications-5").length;
        notifCounter = activeString.indexOf("0")+1;
        
        var content = "<div id=\"details-notifications-"+(notifCounter)+"\" class=\"details-notifications\">"
                +"\n    <select id=\"ne-evt-notifications-"+(notifCounter)+"\" name=\"ne-evt-notifications-"+(notifCounter)+"\" class=\"ui-select\" title=\"Notification type\">"
                +"\n        <option value=\"1\">Pop-up</option>"
                +"\n        <option value=\"3\">Email</option>"
                +"\n    </select>"
                +"\n    <input id=\"ne-evt-notifications-time-"+(notifCounter)+"\" name=\"ne-evt-notifications-time-"+(notifCounter)+"\" class=\"details-notifications-remindertime ui-textinput\" value=\"10\" title=\"Reminder time\">"
                +"\n    <select id=\"ne-evt-notifications-timetype-"+(notifCounter)+"\" name=\"ne-evt-notifications-timetype-"+(notifCounter)+"\" class=\"ui-select\" title=\"Reminder time\">"
                +"\n        <option value=\"60\">minutes</option>"
                +"\n        <option value=\"3600\">hours</option>"
                +"\n        <option value=\"86400\">days</option>"
                +"\n        <option value=\"604800\">weeks</option>"
                +"\n    </select>"
                +"\n    <div id=\"details-notifications-x-"+(notifCounter)+"\" class=\"details-notifications-x\" title=\"Remove notification\"></div>"
                +"\n</div>\n";
        
        $("#wrapper-notifications").append(content);
        
        activeCounter = $(".details-notifications").length;
        
        if(activeCounter===5){
            $("#details-notifications-add").addClass("details-notifications-hidden");
        }
        $("#details-notifications-none").addClass("details-notifications-hidden");
        
        
    });
    
    $(document).on("click", ".details-notifications-x", function(){
        $(this).parent().remove();
        activeCounter = $(".details-notifications-x").length;
        if(activeCounter===0){
            $("#details-notifications-none").removeClass("details-notifications-hidden");
        } else if(activeCounter<5){
            $("#details-notifications-add").removeClass("details-notifications-hidden");
        } 
        
    });
    
});