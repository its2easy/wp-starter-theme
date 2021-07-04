import $ from 'jquery';
//import "bootstrap/js/dist/modal";
import Alert from "bootstrap/js/dist/modal";

document.addEventListener("DOMContentLoaded", function(event) {

    //$('#modal-callback').modal('show');

    // Callback modal
    $('.js__callback-modal').on('click', function (e) {
        e.preventDefault();
        $('.modal-callback').modal('show');
    });


    // Sending simple form
    $('.js__simple-form').on('submit',function(e) {
        e.preventDefault();
        var form = $(this);
        //var dataToSend = form.serialize();
        var dataToSend = new FormData(this);
        dataToSend.append('action', 'theme_form');
        var button = form.find('.js__submit');
        //dataToSend += '&source=' + encodeURIComponent(form.data('source')); //extend dataToSend

        // Form reaction on sending
        button.attr('disabled',true);
        //button.text('Отправка...');
        form.find('input, textarea').attr('disabled',true);
        form.find('.js__form-messages').empty();

        // Send
        $.ajax({
            url:      ajax_object.ajax_url,
            type:     "POST",
            dataType: "html",
            data: dataToSend,
            //enctype: 'multipart/form-data', // for files
            processData: false,
            contentType: false,
            success: function(response) {
                button.prop('disabled', false);
                form.find('input, textarea').attr('disabled',false);
                form.trigger( 'reset' );
                form.find('.js__form-messages').append(
                    $("<div class='alert alert-success mb-3 mt-3'>Заявка успешно отправлена!</div>")
                );
            },
            error: function(response) {
                console.log(response);
                form.find('input, textarea').attr('disabled',false);
                button.prop('disabled', false);
                form.find('.js__form-messages').append(
                    $("<div class='alert alert-danger mb-3 mt-3'>Ошибка при отправке</div>")
                );
            }
        });

        return false;
    });

});

// function clickOutsideSearchHandler(e){
//     var searchBlock = document.querySelector('.header__search-block');
//     var isClickedInside = searchBlock.contains(e.target);
//     if (!isClickedInside) closeSearchBlock();
// }
