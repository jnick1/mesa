/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    $('[id]').each(function(){
        var ids = $('[id="'+this.id+'"]');
        if(ids.length>1 && ids[0]==this)
            alert('Multiple IDs #'+this.id);
    });
});

