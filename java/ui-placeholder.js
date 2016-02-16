/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    $('.ui-placeholder').focus(
    function(){
        $(this).attr("placeholder", "");
    });

    $('.ui-placeholder').blur(
    function(){
        $(this).attr("placeholder", "Untitled event");
    });
});