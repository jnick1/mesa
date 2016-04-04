/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validate_date(string) {
    return /^\d{2}\/\d{2}\/\d{4}&/.test(string);
}
function validate_natural_number(string){
    return /^[1-9]\d*$/.test(string);
}
function validate_time(string){
    return /^\d{1,2}:\d{2}[ap]m$/.test(string);
}
function validate_email(email) {
    var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regex.test(email);
}
function validate_duration(string){
    return /^\d{2}:\d{2}$/.test(string);
}

function save_state(scope, saveloc){
    for(var id in saveloc) {
        if(id.endsWith("nodisplay") && !$(id.substring(0,id.length-9)).hasClass("wpg-nodisplay")) {
            delete saveloc[id];
        } else {
            continue;
        }
    }
    $(scope+" input, "+scope+" select").each(function(){
        var state;
        switch($(this).prop("tagName").toLowerCase()+$(this).attr("type")){
            case "inputcheckbox":
            case "inputradio":
                state = $(this).is(":checked");
                break;
            case "inputtext":
            case "inputemail":
            case "select":
            default:
                state = $(this).val();
        }
        saveloc["#"+$(this).attr("id")] = state;
        saveloc["#"+$(this).attr("id")+"disabled"] = $(this).prop("disabled");
    });
    $(scope).find(".wpg-nodisplay").each(function(){
        saveloc["#"+$(this).attr("id")+"nodisplay"] = true;
    });
}
function reset_state(scope, saveloc){
    for(var id in saveloc){
        if(!id.endsWith("disabled") && !id.endsWith("nodisplay")){
            switch($(id).prop("tagName").toLowerCase()+$(id).attr("type")){
                case "inputcheckbox":
                case "inputradio":
                    $(id).prop("checked", saveloc[id]);
                    break;
                case "inputtext":
                case "inputemail":
                case "select":
                default:
                    $(id).val(saveloc[id]);
            }
            $(id).prop("disabled", saveloc[id+"disabled"]);
        } else if(id.endsWith("nodisplay") && saveloc[id]===true){
            $(id.substring(0,id.length-9)).addClass("wpg-nodisplay");
        }
    }
}

function post(path, parameters, method) {
    var form = $('<form></form>');
    method = method || "POST";

    form.attr("method", method);
    form.attr("action", path);

    $.each(parameters, function(key, value) {
        var field = $('<input></input>');

        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", value);

        form.append(field);
    });
    
    $(document.body).append(form);
    form.submit();
}
jQuery.fn.center = function(parent, direction) {
    if (parent) {
        parent = this.parent();
    } else {
        parent = window;
    }
    if(direction==="leftright") {
        this.css({
            "position": "absolute",
            "left": ((($(parent).width() - this.outerWidth()) / 2) + $(parent).scrollLeft() + "px")
        });
    } else if(direction==="topbottom"){
        this.css({
            "position": "absolute",
            "top": ((($(parent).height() - this.outerHeight()) / 2) + $(parent).scrollTop() + "px"),
        });
    } else {
        this.css({
            "position": "absolute",
            "top": ((($(parent).height() - this.outerHeight()) / 2) + $(parent).scrollTop() + "px"),
            "left": ((($(parent).width() - this.outerWidth()) / 2) + $(parent).scrollLeft() + "px")
        });
    }
    
return this;
};

$(document).ready(function validate_no_id_overlap(){
    $('[id]').each(function(){
        var ids = $('[id="'+this.id+'"]');
        if(ids.length>1 && ids[0]==this)
            alert('Multiple IDs #'+this.id);
    });
});

