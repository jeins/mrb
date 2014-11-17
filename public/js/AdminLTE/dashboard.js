/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function() {
    "use strict";

    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
    //jQuery UI sortable for the todo list
    $(".todo-list").sortable({
        placeholder: "sort-highlight",
        handle: ".handle",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    ;

    /* jQueryKnob */
    $(".knob").knob();

    //The Calender
    $("#calendar").datepicker();

    //SLIMSCROLL FOR CHAT WIDGET
    $('#chat-box').slimScroll({
        height: '250px'
    });

    /* Morris.js Charts */
    // Sales chart
        var area = new Morris.Area({
            element: 'revenue-chart',
            resize: true,
            data: [
                {y: '17 Senin', item1: 12, item2: 13},
                {y: '18-11-2014', item1: 1, item2: 11},
                {y: '19-11-2014', item1: 6, item2: 10},
                {y: '20-11-2014', item1: 4, item2: 14},
                {y: '21-11-2014', item1: 8, item2: 12},
                {y: '22-11-2014', item1: 9, item2: 11},
                {y: '23-11-2014', item1: 10, item2: 8},
                {y: '24-11-2014', item1: 11, item2: 6},
                {y: '25-11-2014', item1: 16, item2: 9},
                {y: '26-11-2014', item1: 3, item2: 11},
                {y: '27-11-2014', item1: 2, item2: 12}
            ],
            xkey: 'y',
            ykeys: ['item1', 'item2'],
            labels: ['Item 1', 'Item 2'],
            lineColors: ['#a0d0e0', '#3c8dbc'],
            hideHover: 'auto'
        });

    /* The todo list plugin */
    $(".todo-list").todolist({
        onCheck: function(ele) {
            //console.log("The element has been checked")
        },
        onUncheck: function(ele) {
            //console.log("The element has been unchecked")
        }
    });

});