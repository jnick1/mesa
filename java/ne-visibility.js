/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on("click", "#ne-evt-visibility-default", function(){
    $("#details-visibility-info-default").removeClass("wpg-nodisplay");
    $("#details-visibility-info-public").addClass("wpg-nodisplay");
    $("#details-visibility-info-private").addClass("wpg-nodisplay");
});

$(document).on("click", "#ne-evt-visibility-public", function(){
    $("#details-visibility-info-default").addClass("wpg-nodisplay");
    $("#details-visibility-info-public").removeClass("wpg-nodisplay");
    $("#details-visibility-info-private").addClass("wpg-nodisplay");
});

$(document).on("click", "#ne-evt-visibility-private", function(){
    $("#details-visibility-info-default").addClass("wpg-nodisplay");
    $("#details-visibility-info-public").addClass("wpg-nodisplay");
    $("#details-visibility-info-private").removeClass("wpg-nodisplay");
});