/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function sizechange(){
    
    
    $("#details-notifications-addlink").click(function(){
        
        var id1Visible = !$("#details-notifications-1").hasClass("details-notifications-hidden");
        var id2Visible = !$("#details-notifications-2").hasClass("details-notifications-hidden");
        var id3Visible = !$("#details-notifications-3").hasClass("details-notifications-hidden");
        var id4Visible = !$("#details-notifications-4").hasClass("details-notifications-hidden");
        var id5Visible = !$("#details-notifications-5").hasClass("details-notifications-hidden");
        var mostVisible = id4Visible?4:id3Visible?3:id2Visible?2:id1Visible?1:0;
        var allVisible = id5Visible && id4Visible && id3Visible && id2Visible && id1Visible;
        
        var link = $("#details-notifications-add");
        
        $("#details-notifications-none").addClass("details-notifications-hidden");
        
        switch(mostVisible){
            case 1:
                $("#details-notifications-2").removeClass("details-notifications-hidden");
                break;
            case 2:
                $("#details-notifications-3").removeClass("details-notifications-hidden");
                break;
            case 3:
                $("#details-notifications-4").removeClass("details-notifications-hidden");
                break;
            case 4:
                $("#details-notifications-5").removeClass("details-notifications-hidden");
                $("#details-notifications-add").addClass("details-notifications-hidden");
                break;
            default:
                $("#details-notifications-1").removeClass("details-notifications-hidden");
                break;
        }
    });
    
    $(".details-notifications-x").click(function(){
        
        var id1Visible = !$("#details-notifications-1").hasClass("details-notifications-hidden");
        var id2Visible = !$("#details-notifications-2").hasClass("details-notifications-hidden");
        var id3Visible = !$("#details-notifications-3").hasClass("details-notifications-hidden");
        var id4Visible = !$("#details-notifications-4").hasClass("details-notifications-hidden");
        var id5Visible = !$("#details-notifications-5").hasClass("details-notifications-hidden");
        var allVisible = (id5Visible && id4Visible && id3Visible && id2Visible && id1Visible);
        
        if(!allVisible){
            $("details-notifications-none").removeClass("details-notifications-hidden");
        }
        
        $("#details-notifications-x-1").click(function(){
            $("#details-notifications-1").addClass("details-notifications-hidden");
            if($("#details-notifications-add").hasClass("details-notifications-hidden")){
                $("#details-notifications-add").removeClass("details-notifications-hidden");
            }

        });
        $("#details-notifications-x-2").click(function(){
            $("#details-notifications-2").addClass("details-notifications-hidden");
            if($("#details-notifications-add").hasClass("details-notifications-hidden")){
                $("#details-notifications-add").removeClass("details-notifications-hidden");
            }
        });
        $("#details-notifications-x-3").click(function(){
            $("#details-notifications-3").addClass("details-notifications-hidden");
            if($("#details-notifications-add").hasClass("details-notifications-hidden")){
                $("#details-notifications-add").removeClass("details-notifications-hidden");
            }
        });
        $("#details-notifications-x-4").click(function(){
            $("#details-notifications-4").addClass("details-notifications-hidden");
            if($("#details-notifications-add").hasClass("details-notifications-hidden")){
                $("#details-notifications-add").removeClass("details-notifications-hidden");
            }
        });
        $("#details-notifications-x-5").click(function(){
        $("#details-notifications-5").addClass("details-notifications-hidden");
        if($("#details-notifications-add").hasClass("details-notifications-hidden")){
            $("#details-notifications-add").removeClass("details-notifications-hidden");
        }
    });
    });
    
});