/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on("click", "#ne-evt-visibility-default", function(){
    $("#details-visibility-info-default").removeClass("details-visibility-info-hidden");
    $("#details-visibility-info-public").addClass("details-visibility-info-hidden");
    $("#details-visibility-info-private").addClass("details-visibility-info-hidden");
});

$(document).on("click", "#ne-evt-visibility-public", function(){
    $("#details-visibility-info-default").addClass("details-visibility-info-hidden");
    $("#details-visibility-info-public").removeClass("details-visibility-info-hidden");
    $("#details-visibility-info-private").addClass("details-visibility-info-hidden");
});

$(document).on("click", "#ne-evt-visibility-private", function(){
    $("#details-visibility-info-default").addClass("details-visibility-info-hidden");
    $("#details-visibility-info-public").addClass("details-visibility-info-hidden");
    $("#details-visibility-info-private").removeClass("details-visibility-info-hidden");
});