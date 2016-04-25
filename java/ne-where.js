/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on("click", "#ne-where-maplink", function(){
    $(this).attr("href", "https://maps.google.com/?q="+$("#ne-evt-where").val());
});