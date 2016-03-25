/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on("click", "#wpg-header-myevents", function(){
    var arrow = $("#wpg-header-myevents-dropdown-arrow");
    if(arrow.hasClass("goog-icon-dropdown-arrow-left")) {
        arrow.removeClass("goog-icon-dropdown-arrow-left").addClass("goog-icon-dropdown-arrow-down");
    } else {
        arrow.removeClass("goog-icon-dropdown-arrow-down").addClass("goog-icon-dropdown-arrow-left");
    }
});

$(document).on("click", "#wpg-header-btn-signout", function() {
    post("#",{
        "signout":true
    }, "POST");
});