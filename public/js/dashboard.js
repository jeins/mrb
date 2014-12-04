
$(function() {
    "use strict";

    /* jQueryKnob */
    $(".knob").knob();

    $(".editamalan-tilawah, .editamalan-hafalan").on('click', function(){
        if(this.className == 'tools editamalan-tilawah'){
            $('.form-edittilawah').show();
            $('.amalan-tilawah').hide();
        } else if(this.className == 'tools editamalan-hafalan'){
            $('.form-edithafalan').show();
            $('.amalan-hafalan').hide();
        }
    });
});