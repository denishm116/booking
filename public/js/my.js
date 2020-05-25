//Лодочка
$(document).ready(function () {
    const card = document.querySelector('.rotate-container');
    const cardItem = this.querySelector('.rotate-card');
    const halfHeight = cardItem.offsetHeight / 2;
    card.addEventListener('mousemove', rotate)
    card.addEventListener('mouseout', rotate0)

    function rotate(event) {

        cardItem.style.transform = 'rotateX(' + -(event.offsetY - halfHeight) / 120 + 'deg) rotateY(' + (event.offsetX - halfHeight) / 85 + 'deg)'
    }


    function rotate0() {
        cardItem.style.transform = 'rotateX(0deg) rotateY(0deg)'
    }


});

//Кнопка вверх
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() != 0) {
                $('#toTop').fadeIn();
            } else {
                $('#toTop').fadeOut();
            }
        });
        $('#toTop').click(function () {
            $('body,html').animate({scrollTop: 0}, 800);
        });
    });


$.datepicker.setDefaults($.datepicker.regional['ru']);
let myTempVar = false;
let width=document.body.clientWidth; // ширина
let numberOfMonth = 2;
if (width < 600)
    numberOfMonth = 1;

$("#check_in, #check_out").datepicker({
    minDate: 0,
    range: 'period',
    numberOfMonths: numberOfMonth,
    dateFormat: "dd-mm-yy",


    onSelect: function (dateText, inst, extensionRange) {

        // extensionRange - объект расширения
        $('[name=checkin]').val(extensionRange.startDateText);
        $('[name=checkout]').val(extensionRange.endDateText);

        document.querySelector('#check_in').onfocus = () => myTempVar = false;
        if (!myTempVar) {
            document.querySelector('#check_out').focus()
            myTempVar = true;
        }
        if (myTempVar && extensionRange.startDateText < extensionRange.endDateText)
            setTimeout(function () {
                $("#check_in, #check_out").datepicker('hide')
            }, 1000)
    }
});


function guests() {
    let choiceVisible = document.querySelector('.choice-visible');
    let guestsWrapper = document.querySelector('.guests-wrapper');
    let adultsPlus = document.querySelector('.adult-plus');
    let adultsMinus = document.querySelector('.adult-minus');
    let childrenPlus = document.querySelector('.children-plus');
    let childrenMinus = document.querySelector('.children-minus');
    let adultsCounter = document.querySelector('.adults-counter');
    let adultsVisible = document.querySelector('.adults-visible');
    let childrenCounter = document.querySelector('.children-counter');
    let childrenVisible = document.querySelector('.children-visible');
    let select = document.querySelector('.selected-guest');
    let gotovo = document.querySelector('.gotovo');

    gotovo.onclick = function () {
        guestsWrapper.classList.add('anim');

    }
    //Появление меню
    choiceVisible.onclick = function () {
        guestsWrapper.classList.toggle('anim');

        this.classList.toggle('border-gray');
        this.classList.toggle('border-orange');
    };

    adultsPlus.onclick = function () {
        let zz = adultsCounter.innerHTML;
        zz++;
        if (zz > 10) zz = 10;
        adultsCounter.innerHTML = zz;
        adultsVisible.innerHTML = zz;
        write();
    };


    adultsMinus.onclick = function () {
        let mm = adultsCounter.innerHTML;
        mm--;
        if (mm <= 1) mm = 1;
        adultsCounter.innerHTML = mm;
        adultsVisible.innerHTML = mm;
        write();
    };


    childrenPlus.onclick = function () {
        let bb = childrenCounter.innerHTML;
        bb++;
        if (bb > 10) bb = 10;
        childrenCounter.innerHTML = bb;
        childrenVisible.innerHTML = bb;
        write();
    };


    childrenMinus.onclick = function () {
        let mm = childrenCounter.innerHTML;
        mm--;
        if (mm <= 0) mm = 0;
        childrenCounter.innerHTML = mm;
        childrenVisible.innerHTML = mm;
        write();
    }

    function write() {
        let sumGuests = +adultsCounter.innerHTML + +childrenCounter.innerHTML;
        select.options[0].value = sumGuests;
        select.options[0].text = sumGuests;

    }


    window.addEventListener('click', function (e) {
        if (!guestsWrapper.contains(e.target) && !choiceVisible.contains(e.target)) {
            // Ниже код, который нужно выполнить при срабатывании события.
            guestsWrapper.classList.add('anim');

        }
    });

}
guests();

