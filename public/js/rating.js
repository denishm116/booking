function setRating() {

    const radio = document.querySelectorAll('.auth')
    console.log(radio)
    const objectId = document.querySelector('.ob-id').innerHTML;
    for (var i = 0; i < radio.length; i++) {
        radio[i].addEventListener('change', function (e) {
            axios.get('/ajax/changeRating/' + objectId + '/' + (+e.target.value))
                .then(function (response) {
                    let tmp = document.querySelector('.rat_text')
                    tmp.innerHTML = 'Ваша оценка ' + (+e.target.value)
                    tmp.removeAttribute('class');
                    // e.preventDefault();
                }).catch(function (error) {

            });
        })

    }

}

setRating()
