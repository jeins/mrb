
$(function() {
    "use strict";

    /* jQueryKnob */
    $(".knob").knob();

    //The Calender
    $("#calendar").datepicker();

    /* The todo list plugin */
    $(".todo-list").todolist({
        onCheck: function(ele) {
            //alert("The element has been checked")
        },
        onUncheck: function(ele) {
            //alert("The element has been unchecked")
        }
    });


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