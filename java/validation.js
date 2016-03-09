/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validate_date(string) {
    return /\d{2}\/\d{2}\/\d{4}/.test(string);
}
function validate_natural_number(string){
    return /^[1-9]\d*$/.test(string);
}
function validate_time(string){
    return /\d{1,2}:\d{2}[ap]m/.test(string);
}

$(document).ready(function validate_no_id_overlap(){
    $('[id]').each(function(){
        var ids = $('[id="'+this.id+'"]');
        if(ids.length>1 && ids[0]==this)
            alert('Multiple IDs #'+this.id);
    });
});

