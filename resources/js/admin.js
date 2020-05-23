function datesBetween(startDt, endDt) {
    var between = [];
    var currentDate = new Date(startDt);
    var end = new Date(endDt);
    while (currentDate <= end) {
        between.push($.datepicker.formatDate('mm/dd/yy', new Date(currentDate)));
        currentDate.setDate(currentDate.getDate() + 1);
    }

    return between;
}

//base.js

function _createModal(options) {
    const modal = document.createElement('div')
    modal.classList.add('vmodal')
    modal.insertAdjacentHTML('afterbegin', `
    <div class="modal-overlay">
      <div class="modal-window">
        <div class="modal-header">
           <h3 class="about__title">${options.modalHeaderText || 'Header'}</h3>

          <span class="modal-close">${options.closable ? `<span class="modal-close" data-close="true">&times;</span>` : ''}</span>
        </div>
        <div class="modal-body">
          <p></p>
          <p>${options.modalBodyText || 'Text'}</p>
        </div>
        <div class="modal-footer">
          <a href="${options.href || '#'}" class="btn px-4 m-3  w-50 choice__button">${options.modalButtonText || 'Button'}</a>

        </div>
      </div>
    </div>
  `)
    document.body.appendChild(modal)

    return modal
}


$$.modal = function (options) {
    const ANIMATION_SPEED = 200
    const $modal = _createModal(options)
    let closing = false

    const modal = {
        open() {
            !closing && $modal.classList.add('open')
        },
        close() {
            closing = true
            $modal.classList.remove('open')
            $modal.classList.add('hide')
            setTimeout(() => {
                $modal.classList.remove('hide')
                closing = false
            }, ANIMATION_SPEED)
        },
    };


    $modal.addEventListener('click', e => {
        if (e.target.dataset.close) {
            modal.close()
        }

    })
    return modal;

}


var Ajax = {

    get: function (url, success, data = null, beforeSend = null) {

        $.ajax({

            cache: false,
            url: base_url + '/' + url,
            type: "GET",
            data: data,
            success: function (response) {

                App[success](response);

            },
            beforeSend: function () {

                if (beforeSend)
                    App[beforeSend]();

            }

        });
    },

    set: function (data = {}, url, success = null) {

        $.ajax({

            cache: false,
            url: base_url + '/' + url,
            type: "GET",
            dataType: "json",
            data: data,
            success: function (response) {

                if (success)
                    App[success](response);

            }

        });
    }


};

var App = {

    timestamp: null,

    idsOfNotShownNotifications: [],


    GetReservationData: function (id, calendar_id, date) {

        App.calendar_id = calendar_id;
        Ajax.get('ajaxGetReservationData?fromWebApp=1', 'AfterGetReservationData', {
            room_id: id,
            date: date
        }, 'BeforeGetReservationData');
    },


    BeforeGetReservationData: function () {


        $('.loader_' + App.calendar_id).hide();
        $('.hidden_' + App.calendar_id).show();


    },
    AfterGetReservationData: function (response) {


        $('.hidden_' + App.calendar_id + " .reservation_data_room_number").html(response.room_number);

        $('.hidden_' + App.calendar_id + " .reservation_data_day_in").html(response.day_in);
        $('.hidden_' + App.calendar_id + " .reservation_data_day_out").html(response.day_out);
        $('.hidden_' + App.calendar_id + " .reservation_data_person").html(response.reservationNumber);

        // $('.hidden_' + App.calendar_id + " .reservation_data_person").attr('href', response.userLink);
        $('.hidden_' + App.calendar_id + " .reservation_data_delete_reservation").attr('href', response.deleteResLink);
        $('.hidden_' + App.calendar_id + " .reservation_data_delete_reservation_admin").attr('href', response.deleteResLink); /* Lecture 33 */
        $('.hidden_' + App.calendar_id + " .reservation_data_delete_reservation_admin").html('<i class="fas fa-trash"></i>'); /* Lecture 33 */
        /* Lecture 33 */
        if (response.status) {
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").html('Подтверждено');
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation_wait").html('Подтверждено');
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").removeAttr('href');
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").removeClass('confirm__button');
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation_wait").removeClass('rotate-hourglass');

            $('.hidden_' + App.calendar_id + " .reservation_data_delete_reservation").removeAttr('href');
            // $('.hidden_' + App.calendar_id + " .reservation_data_delete_reservation i").removeClass('fas fa-trash');
            $('.hidden_' + App.calendar_id + " .reservation_data_delete_reservation").html("Удаление через администрацию");

            $('.hidden_' + App.calendar_id + " .reservation_data_price").html("<b>Цена: </b>" + response.price + " &#8381;"); /* Lecture 33 */
            $('.hidden_' + App.calendar_id + " .reservation_data_comission").html("<b>Комиссия: </b>" + response.reward + " &#8381;"); /* Lecture 33 */
            $('.hidden_' + App.calendar_id + " .reservation_data_reward").html("<b>Остаток: </b>" + (response.price - response.reward) + " &#8381;"); /* Lecture 33 */
            $('.hidden_' + App.calendar_id + " .reservation_data_description").html("<b>Дополнительно: </b>" + response.description); /* Lecture 33 */

        } else {
            // $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation_wait").html('Подтвердить');
            // $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation_wait").html("Ожидает подтверждения");
            // $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation_wait i").addClass('rotate-hourglass');
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").addClass('confirm__button');
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").attr('href', response.confirmResLink);

            $('.hidden_' + App.calendar_id + " .reservation_data_delete_reservation").html('<i class="fas fa-trash"></i>');

            $('.hidden_' + App.calendar_id + " .reservation_data_price").html("<b>Цена: </b>" + response.price + " &#8381;"); /* Lecture 33 */
            $('.hidden_' + App.calendar_id + " .reservation_data_comission").html("<b>Комиссия: </b>" + response.reward + " &#8381;"); /* Lecture 33 */
            $('.hidden_' + App.calendar_id + " .reservation_data_reward").html("<b>Остаток: </b>" + (response.price - response.reward) + " &#8381;"); /* Lecture 33 */
            $('.hidden_' + App.calendar_id + " .reservation_data_description").html("<b>Дополнительно: </b>" + response.description); /* Lecture 33 */
        }


    },

    /* Lecture 50 */
    SetReadNotification: function (id) {

        Ajax.set({id: id}, 'ajaxSetReadNotification?fromWebApp=1');
    },


    /* Lecture 50 */
    GetNotShownNotifications: function () {

        /* Lecture 51 */
        Ajax.get("ajaxGetNotShownNotifications?fromWebApp=1&timestamp=" + App.timestamp, 'AfterGetNotShownNotifications');

    },

    /* Lecture 51 */
    AfterGetNotShownNotifications: function (response) {

        var json = JSON.parse(response); /* Lecture 52 */

        App.timestamp = json['timestamp']; /* Lecture 52 */
        setTimeout(App.GetNotShownNotifications(), 100); /* Lecture 52 */


        /* Lecture 52 */
        if (jQuery.isEmptyObject(json['notifications']))
            return;


        $('#app-notifications-count').show(); /* Lecture 52 */
        $('#app-notifications-count').removeClass('hidden'); /* Lecture 52 */


        /* Lecture 52 */
        for (var i = 0; i <= json['notifications'].length - 1; i++) {
            App.idsOfNotShownNotifications.push(json['notifications'][i].id);

            $('#app-notifications-count').html(parseInt($('#app-notifications-count').html()) + 1);
            $("#app-notifications-list").append('<li class="unread_notification"><a href="' + json['notifications'][i].id + '">' + json['notifications'][i].content + '</a></li>');
        }


        App.SetShownNotifications(App.idsOfNotShownNotifications); /* Lecture 52 */


    },


    /* Lecture 52 */
    SetShownNotifications: function (ids) {

        Ajax.set({idsOfNotShownNotifications: ids}, 'ajaxSetShownNotifications?fromWebApp=1');

    }


};


/* Lecture 34 */
$(document).on('click', '.dropdown', function (e) {
    e.stopPropagation();
});


/* Lecture 50 */
$(document).on("click", ".unread_notification", function (event) {

    event.preventDefault();

    $(this).removeClass('unread_notification');

    var ncount = parseInt($('#app-notifications-count').html());

    if (ncount > 0) {
        $('#app-notifications-count').html(ncount - 1);

        if (ncount == 1)
            $('#app-notifications-count').hide();
    }

    var idOfNotification = $(this).children().attr('href');
    $(this).children().removeAttr('href');
    App.SetReadNotification(idOfNotification);

});


/* Lecture 50 */
$(function () {

    App.GetNotShownNotifications();

});

//Создание бронирования в админке
//


