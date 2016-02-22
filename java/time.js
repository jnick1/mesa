/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function client_time(){
    var time = Math.floor(Date.now()/1000);
    var UTS_start = Math.ceil(time/(30*60))*(30*60);
    var UTS_end = Math.ceil((time+3600)/(30*60))*(30*60);
    
    var time_start = new Date(UTS_start*1000);
    var time_end = new Date(UTS_end*1000);
    
    var date_start_month = time_start.getMonth()+1;
    var date_start_day = time_start.getDate();
    var date_start_year = time_start.getFullYear();
    
    var date_end_month = time_end.getMonth()+1;
    var date_end_day = time_end.getDate();
    var date_end_year = time_end.getFullYear();
    
    var hours_start = time_start.getHours();
    var hours_end = time_end.getHours();
    var minutes = time_start.getMinutes();

    var suffix_start = "am";
    var suffix_end = "am";

    if (hours_start >= 12) {
        suffix_start = "pm";
        hours_start -= 12;
    }
    if (hours_start == 0) {
        hours_start = 12;
    }
    
    if(hours_end >= 12) {
        suffix_end = "pm";
        hours_end -= 12;
    }
    if (hours_end == 0) {
        hours_end = 12;
    }
    
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    
    $("#ne-evt-time-start").val(hours_start + ":" + minutes + suffix_start); //hours1 + ":" + minutes + suffix
    $("#ne-evt-time-end").val(hours_end + ":" + minutes + suffix_end);
    
    $("#ne-evt-date-start").val(date_start_month + "/" + date_start_day + "/" + date_start_year);
    $("#ne-evt-date-end").val(date_end_month + "/" + date_end_day + "/" + date_end_year);

});

/*
 * <?php
    for($i=0;$i<48;$i++){
        $time = date("g:ia", strtotime((floor($i/2)).":".(($i%2)*30)));
        echo "<div class=\"ui-dropdown-item\">".$time."</div>";
    }
    ?>
 * 
 */

//$(document).ready(function end_time(){
//    $(".ui-dropdown-item").click(function(){
//        $("#details-dropdown-timeend-panel").html(function(){
//            
//        });
//    });
//    
//    
//});

$(document).ready(function set_start_time(){
    $(".ui-dropdown-item").click(function() {
        $("#ne-evt-time-start").val($(this).html());
        function hide(event) {

        // In some cases we don't hide them
        var targetGroup = event ? $(event.target).parents().addBack() : null;

        // Are we clicking anywhere in a jq-dropdown?
        if (targetGroup && targetGroup.is('.jq-dropdown')) {
            // Is it a jq-dropdown menu?
            if (targetGroup.is('.jq-dropdown-menu')) {
                // Did we click on an option? If so close it.
                if (!targetGroup.is('A')) return;
            } else {
                // Nope, it's a panel. Leave it open.
                return;
            }
        }

        // Hide any jq-dropdown that may be showing
        $(document).find('.jq-dropdown:visible').each(function () {
            var jqDropdown = $(this);
            jqDropdown
                .hide()
                .removeData('jq-dropdown-trigger')
                .trigger('hide', { jqDropdown: jqDropdown });
        });

        // Remove all jq-dropdown-open classes
        $(document).find('.jq-dropdown-open').removeClass('jq-dropdown-open');

    };
    $(document).on('click.ui-dropdown-item', hide("jq-dropdown"));
    });
});

$(document).ready(function set_end_time(){
    $(".ui-dropdown-item").click(function() {
        $("#ne-evt-time-start").val($(this).html());
        function hide(event) {

        // In some cases we don't hide them
        var targetGroup = event ? $(event.target).parents().addBack() : null;

        // Are we clicking anywhere in a jq-dropdown?
        if (targetGroup && targetGroup.is('.jq-dropdown')) {
            // Is it a jq-dropdown menu?
            if (targetGroup.is('.jq-dropdown-menu')) {
                // Did we click on an option? If so close it.
                if (!targetGroup.is('A')) return;
            } else {
                // Nope, it's a panel. Leave it open.
                return;
            }
        }

        // Hide any jq-dropdown that may be showing
        $(document).find('.jq-dropdown:visible').each(function () {
            var jqDropdown = $(this);
            jqDropdown
                .hide()
                .removeData('jq-dropdown-trigger')
                .trigger('hide', { jqDropdown: jqDropdown });
        });

        // Remove all jq-dropdown-open classes
        $(document).find('.jq-dropdown-open').removeClass('jq-dropdown-open');

    };
    $(document).on('click.ui-dropdown-item', hide("jq-dropdown"));
    });
});