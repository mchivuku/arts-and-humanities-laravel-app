/**
 * Created on 4/14/16.
 */

$(document).foundation('reveal', 'reflow');

$(document).ready(function(){

    jQuery.fn.exists = function(){return this.length>0;}

    if (!$('aside').exists()){
        $('main').addClass('no-section-nav');
    }else{
        $('.alert-box').parents('section').addClass('section');
    }

    ModalWindow.init();
    AjaxTabs.init();

    // close alert box -
    $('.alert-box > a.close').click(function() { $(this).closest('[data-alert]').fadeOut(); });



});


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
        $.get(link,null,function(data){
            $("#viewModal").html(data);

        });
    }

};