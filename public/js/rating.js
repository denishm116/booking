function setRating() {

    const radio = document.querySelectorAll('.rating__input')
    for (var i = 0; i < radio.length; i++) {
        radio[i].addEventListener('change', function (e) {
            console.log(+e.target.value+1)
        })

    }
}

setRating()
