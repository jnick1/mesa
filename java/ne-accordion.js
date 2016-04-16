/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on("click", ".ne-opti-table-accordion-header", function(){
    if($(this).next().hasClass("ne-opti-table-accordion-hidden")) {
        $(this).addClass("ne-opti-table-accordion-header-open");
        $(".ne-opti-table-accordion-content").addClass("wpg-hidden");
        $(this).next().removeClass("ne-opti-table-accordion-hidden");
        $(this).children("div").addClass("goog-icon-dropdown-arrow-down")
        $(this).children("div").removeClass("goog-icon-dropdown-arrow-right")
    } else {
        $(this).removeClass("ne-opti-table-accordion-header-open");
        $(this).next().addClass("ne-opti-table-accordion-hidden");
        $(this).children("div").removeClass("goog-icon-dropdown-arrow-down")
        $(this).children("div").addClass("goog-icon-dropdown-arrow-right")
    }
});

$(document).on("click", ".ne-opti-table-accordion-attendees-header", function(){
    if($(this).next().hasClass("ne-opti-table-accordion-attendees-hidden")) {
        $(this).addClass("ne-opti-table-accordion-header-open");
        $(".ne-opti-table-accordion-attendees-content").addClass("wpg-hidden");
        $(this).next().removeClass("ne-opti-table-accordion-attendees-hidden");
        $(this).children("div").addClass("goog-icon-dropdown-arrow-down")
        $(this).children("div").removeClass("goog-icon-dropdown-arrow-right")
    } else {
        $(this).removeClass("ne-opti-table-accordion-attendees-header-open");
        $(this).next().addClass("ne-opti-table-accordion-attendees-hidden");
        $(this).children("div").removeClass("goog-icon-dropdown-arrow-down")
        $(this).children("div").addClass("goog-icon-dropdown-arrow-right")
    }
});