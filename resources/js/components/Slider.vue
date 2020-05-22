<template>

    <hooper pagination="yes" :centerMode="false" :itemsToShow="1" :playSpeed="5000" :hoverPause="true" :autoPlay="true">

        <slide v-for="(slide, indx) in slides" :key="indx" :index="indx">


            <div v-bind:style="{ backgroundImage:  'url('+ slide + ')' }">
                <a @click="showModal(slides, indx)" >
                    <div style="width: 100%; height: 100%"></div>

                </a>
            </div>
        </slide>


        <hooper-navigation slot="hooper-addons"></hooper-navigation>
        <hooper-pagination slot="hooper-addons"></hooper-pagination>


    </hooper>


</template>

<script>

    import {
        Hooper, Slide,
        Progress as HooperProgress,
        Pagination as HooperPagination,
        Navigation as HooperNavigation
    } from 'hooper';
    import 'hooper/dist/hooper.css';

    export default {
        components: {
            Hooper,
            Slide,
            HooperProgress,
            HooperPagination,
            HooperNavigation
        },

        props: [
            'photos',
        ],

        created() {
            this.slideArray();

        },

        data: function () {
            return {
                slides: [],
                isModalVisible: false,
                t: 0,

            }

        },


        methods: {
            slideArray: function () {
                let arr = this.photos;

                if (arr.length == 0) {
                    this.slides.push('../images/placeholder.jpg')

                } else {

                    this.photos.forEach((path) => {
                        this.slides.push(path.path);

                    });
                }

            },
            openFullScreen: function (slide) {

            },

            //-----------------------------------------------------------
            showModal(slides, indx) {
                let divWrapper = document.querySelector('.modalWindow');
                divWrapper.classList.add('fullScreenPicture')
                document.querySelector('.hide').classList.toggle('hidden')
                if (divWrapper.classList.contains('hidden'))
                    divWrapper.classList.remove('hidden')

                divWrapper.innerHTML = `<img src="${slides[indx]}" class="imgSlider"> <h4 class="back"><i class="fas fa-arrow-circle-left"></i></h4><h4 class="forward"><i class="fas fa-arrow-circle-right"></i></h4> <h4 class="closeButton"><i class="fas fa-times-circle"></i></h4>`;
                let back = document.querySelector('.back')
                let forward = document.querySelector('.forward')
                let imgSlider = document.querySelector('.imgSlider');
                imgSlider.classList.add('active');



                imgSlider.addEventListener('touchmove', () => {
                    this.next(slides, imgSlider, indx);
                });
                imgSlider.addEventListener('click', () => {
                    this.next(slides, imgSlider, indx);
                });

                forward.onclick = () => {
                    this.next(slides, imgSlider, indx);
                };

                back.onclick = () => {
                    this.prev(slides, imgSlider, indx);
                };
                //close button
                document.querySelector('.closeButton').onclick = () => {
                    divWrapper.classList.add('hidden')
                };

                divWrapper.addEventListener('click', function (e) {
                    if (!imgSlider.contains(e.target) && !back.contains(e.target) && !forward.contains(e.target)) {
                        document.querySelector('.hide').classList.toggle('hidden')
                    }
                });

            },
            next(slides, imgSlider, indx) {
                if (imgSlider.classList.contains('active')) {
                    imgSlider.setAttribute('src', slides[indx + 1]);
                    imgSlider.classList.remove('active');
                    this.t = indx;
                }
                if (this.t == slides.length - 1) {
                    this.t = 0;
                    imgSlider.setAttribute('src', slides[this.t]);
                } else {
                    imgSlider.setAttribute('src', slides[this.t + 1]);
                    this.t++;
                }
            },
            prev(slides, imgSlider, indx) {
                if (imgSlider.classList.contains('active')) {
                    imgSlider.setAttribute('src', slides[indx - 1]);
                    imgSlider.classList.remove('active');
                    this.t = indx;
                }
                if (this.t == 0) {
                    this.t = slides.length - 1;
                    imgSlider.setAttribute('src', slides[this.t]);
                } else {
                    imgSlider.setAttribute('src', slides[this.t - 1]);
                    this.t--;
                }
            },

            closeModal() {
                this.isModalVisible = false;
            }
            ,
            close(event) {
                this.$emit('close');
            }
            ,


        },
    }

</script>
<style>
    section {
        margin-top: 0;
    }

    slide {
        align-content: center;
        cursor: pointer;
    }

    .hooper {
        height: 100%;
        align-content: center;
        align-self: center;
        cursor: pointer;
    }

    .hooper-track {
        display: flex;
        box-sizing: border-box;
        align-content: center;
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
    }

    .hooper-track div {
        position: relative;
        background-position: center center;
        background-size: contain;
        background-repeat: no-repeat;
        min-height: 25rem;
        height: 100%;
        width: 100%;
    }

    .hooper-track div::before {
        position: absolute;
        content: 'krim-leto';
        color: rgb(218, 111, 91);
        font-size: 20px;
        font-weight: 900;
        left: 10px;
        bottom: 5px;
        text-shadow: 0 0 2px #fff, 0 0 4px #00d2ff,
        0 0 3px #fff, 0 0 4px #ff822f, 0 0 5px #fff,
        0 0 6px #fff, 0 0 7px #fff;
    }

    .hooper-track div::after {
        position: absolute;
        content: '.ru';
        color: #00315f;
        font-size: 20px;
        font-weight: 900;
        left: 97px;
        bottom: 5px;
        text-shadow: 0 0 2px #fff, 0 0 4px #00d2ff,
        0 0 3px #fff, 0 0 4px #00d2ff, 0 0 5px #fff,
        0 0 6px #fff, 0 0 7px #fff;
    }


</style>
