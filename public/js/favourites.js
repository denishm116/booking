$(document).ready(function () {
    /* Избранное */
    let favouritesButton = document.querySelectorAll('.favourites-button');

    function setFavouritesHeader() {
        let length = JSON.parse(localStorage.getItem('favourites')).length
        let counter = document.querySelector('.favourites')
        if (length > 0) {
            counter.innerHTML = `<i class="header-heart fas fa-heart"> </i>  Избранное (${length})`
        } else {
            counter.innerHTML = `<i class="header-heart far fa-heart"> </i>  Избранное`
        }
    }

    function setFavourites(dataAttribute) {
        let storage = JSON.parse(localStorage.getItem('favourites'))
        if (storage.length == 0) {
            storage.push(dataAttribute)
            localStorage.setItem('favourites', JSON.stringify(storage))
            setFavouritesHeader();
        } else {
            storage.forEach(function (item, index) {
                if (item == dataAttribute) {
                    storage.splice(index, 1)
                } else if (item != dataAttribute && storage.length == (index + 1)) {
                    storage.push(dataAttribute)
                }
                localStorage.setItem('favourites', JSON.stringify(storage))
                setFavouritesHeader();
            })
        }
    }

    function setFavouritesColor(item, dataAttribute, storage) {
        storage.forEach(function (roomId) {
            if (roomId == dataAttribute)
                item.innerHTML = `<i class="fas fa-heart"> </i> в избранном`
        })
    }

    function toggleColor(item) {
        if (item.innerHTML === '<i class="fas fa-heart"> </i> в избранном')
            item.innerHTML = `<i class="far fa-heart"> </i> в избранноe`
        else
            item.innerHTML = `<i class="fas fa-heart"> </i> в избранном`
    }

    function favouritesButtonFunction(favouritesButton) {
        favouritesButton.forEach(function (item) {
            let dataAttribute = item.getAttribute('data');
            let storage = JSON.parse(localStorage.getItem('favourites'))
            setFavouritesColor(item, dataAttribute, storage)
            item.addEventListener('click', function (e) {
                e.preventDefault();
                if (dataAttribute) {
                    toggleColor(item);
                    setFavourites(dataAttribute);
                }
            })
        })
    }

    function getFavourites() {
        let roomsArray = [];
        if (localStorage.getItem('favourites')) {
            setFavouritesHeader();
            favouritesButtonFunction(favouritesButton);
        } else {
            localStorage.setItem('favourites', JSON.stringify(roomsArray))
            favouritesButtonFunction(favouritesButton);
        }
    }

    getFavourites();
    // /* Избранное */
    let favouritesHeaderButton = document.querySelector('.favourites');
    favouritesHeaderButton.addEventListener('click', function (e) {
        e.preventDefault()
        // this.setAttribute('href', '/favourites/'+JSON.parse(localStorage.getItem('favourites')))
        document.location.href = '/favourites/favourite/' + JSON.parse(localStorage.getItem('favourites'));
    })
    document.querySelectorAll('.favorite-delete').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault()

            setFavourites(this.getAttribute('data'))
            document.location.href = '/favourites/favourite/' + JSON.parse(localStorage.getItem('favourites'));
        })
    })


});
