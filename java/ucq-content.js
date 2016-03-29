/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    $("#ucq-calendar-dialogbox").center(window);
});

$(window).on("resize", function(){
    $("#ucq-calendar-dialogbox").center(window);
});

$(document).on("click", "#ucq-calendar-btn-cancel", function() {
    window.location.href = "../../index.php";
});

$(document).on("click", "#ucq-calendar-btn-done", function() {
    var chosen = $(".checkboxvar:checked");
    var parameters = {};
    parameters["checkboxvar"] = [];
    for(var cal in chosen){
        parameters["checkboxvar"].push(cal.attr("id"));
    }
    post("#",parameters,"POST");
});