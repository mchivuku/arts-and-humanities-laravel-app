/**
 * Created on 4/14/16.
 */

$(document).foundation('reveal', 'reflow');

$(document).ready(function(){

    jQuery.fn.exists = function(){return this.length>0;}


    // close alert box -
    $('.alert-box  > a.close').click(function() { $(this).closest('#alert').fadeOut(); });

    $('.table-up').click(function () {
        var $row = $(this).parents('tr');
        if ($row.index() === 1) return;
        $row.prev().before($row.get(0));
    });

    $('.table-down').click(function () {
        var $row = $(this).parents('tr');
        $row.next().after($row.get(0));
    });


    $('#edit-order').click(function(){

        $('td.disabled').removeClass('disabled');

        $(this).hide();
        $('#save-order').show();
    });

    $('#save-order').click(function(event){
        event.preventDefault();
        $('form.sortOrder').submit();
    });

    $('.modal').click(function(event){
        event.preventDefault();
        $.get($(this).attr('href'),
            function(response){
                $('#viewModal').empty().html(response);
            });
    });

});


function loadModalWindow(value){
    $.get($(value).attr('href'),function(data){
        $('#viewModal').empty().html(data);
    });
}

/** Modal Window **/
ModalWindow = {

    settings: {
        button: $('a.modal'),
        destinationDiv: $("#viewModal")
    },

    init: function() {
        s = this.settings;
        this.bindUIActions();
    },

    bindUIActions: function() {
        s.button.on("click", function(event) {
            event.preventDefault();
            var link = $(this).attr('href');
            ModalWindow.loadModalWindow(link);
        });
    },

    loadModalWindow: function(link) {
         $.get(link,function(data){
            $("#viewModal").empty().html(data);
        });
    }

};


