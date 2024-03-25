$(document).ready(function () {
    new_date_picker();
    subscribe();
    ask_question();

});

function  send_email(subject,body,email) {

    $.ajax({
        url: Drupal.settings.basePath + 'ajax',
        data: {act:'send_email',subject:subject,body:body,to:email},
        async: true,
        type: "POST",
        success: function (resp) {
            console.log(resp);
        }});
}

function subscribe() {
    $('#btn_subscribe').click(function () {
        var content = $('#content_subscribe').val();
        var subject = 'subscribe';
        var email = $('#admin_email').val();
        if(email != '' && subject != '' && content != '') {
            send_email(subject,content,email);
        }

        console.log('subscribe');
    });
}

function  ask_question() {
    $('#btn_ask_question').click(function () {
        var name = $('.page-contactus #name').val();
        var email = $('.page-contactus #email').val();
        var phone = $('.page-contactus #phone').val();
        var message = $('.page-contactus #message').val();

        if(name != '' && email != '' && phone != '' && message != '') {

            var body = '<table width="100%" cellpadding="5" border="0"><tr><td>Fullname: </td><td>'+name+'</td></tr>';
            body += '<tr><td>Email: </td><td>'+email+'</td></tr>';
            body += '<tr><td>Phone: </td><td>'+phone+'</td></tr>';
            body += '<tr><td>Message: </td><td>'+message+'</td></tr></table>';

            var subject = 'Ask question';
            var email = $('#admin_email').val();

            if(email != '' && subject != '' && body != '') {
                $('.msg').removeClass('hidden');
                setTimeout(function() {
                    $('.msg').addClass('hidden');
                    $('.contactUs__form input').val('');
                    $('.contactUs__form textarea').val('');
                }, 3000);
                send_email(subject,body,email);

            }
        }


        console.log('ask_question');
    });
}
//NEW DATEPICKER
function new_date_picker() {
    var number = 2;
    if( screen.width <= 480 ) {    number = 1; }
    $(".datepickerInput").datepicker({
        changeMonth:true,
        minDate:0,
        numberOfMonths:[1,number],
        dateFormat: "dd-mm-yy",
        onSelect: async function () {
            $('.searchBox__input.duration_label .suggestion').addClass('open');
            var searchType = '#' + $(this).parents('.search_type').attr('id');
            var thisDate = $(this).val().split('-');
            if($(this).attr('id') == 'datepickerGo'){

                var dt2 = $('#datepickerReturn');
                var startDate = $(this).datepicker('getDate');
                var minDate = $(this).datepicker('getDate');

                startDate.setDate(startDate.getDate() + 365);

                //sets dt2 maxDate to the last day of 30 days window
                await dt2.datepicker('option', 'maxDate', startDate);
                await dt2.datepicker('option', 'minDate', minDate);
                $('input[name=day_go]').val(thisDate[2]+'-'+thisDate[1]+'-'+thisDate[0]);
                $('input[name=day_return]').val(thisDate[2]+'-'+thisDate[1]+'-'+thisDate[0]);
                if($('input[name=type_flight]').val() == 2){
                    await $(searchType + ' .datepicker #datepickerReturn').datepicker('show');
                }

            }else if($(this).attr('id') == 'datepickerReturn'){
                $('input[name=day_return]').val(thisDate[2]+'-'+thisDate[1]+'-'+thisDate[0]);
            }else {
                var idx = parseInt($(this).parents('.searchBox__form').attr('num'));

                var dt2 = $('#datepickerGo'+(idx+1));

                var startDate = $(this).datepicker('getDate');

                var minDate = $(this).datepicker('getDate');

                startDate.setDate(startDate.getDate() + 365);

                //sets dt2 maxDate to the last day of 30 days window
                dt2.datepicker('option', 'maxDate', startDate);
                dt2.datepicker('option', 'minDate', minDate);

                $('input[name=day_go_'+ idx+']').val(thisDate[2]+'-'+thisDate[1]+'-'+thisDate[0]);
            }
        }
    });
    $('.searchBox__input.duration_label .suggestion__list').click(function (){
        $('.searchBox__input.searchBox_passenger .suggestion').addClass('open');
    });
    $('#btnOneWay').click(function () {
        $('.searchBox__date.boxCheckOut').addClass('disableCheckOut');
    });
    $('#btnRoundTrip').click(function () {
        $('.searchBox__date.boxCheckOut').removeClass('disableCheckOut');
    });
    $('.tabHeader__close').click(function () {
        $(this).parents('section').find('.homeLeft').removeClass('open');
    });
}
function scroll_top(cls,h) {

    $('html, body').animate({
        scrollTop: $('.' + cls).offset().top - h
    }, 1000);
}