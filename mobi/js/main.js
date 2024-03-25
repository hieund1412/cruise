$(document).ready(function () {
    new_date_picker();

});

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
    $('#btnOneWay').click(function () {
        $('.searchBox__date.boxCheckOut').addClass('disableCheckOut');
    });
    $('#btnRoundTrip').click(function () {
        $('.searchBox__date.boxCheckOut').removeClass('disableCheckOut');
    });

}
