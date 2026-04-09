import Swiper from 'swiper'
import { Autoplay, Navigation, Pagination, EffectFade, EffectFlip } from 'swiper/modules'

document.querySelectorAll('[data-scroller]').forEach(scroller => {
    var options = {
        modules: [Navigation, Pagination, Autoplay, EffectFade, EffectFlip],
        createElements: true,
        loop: true,
        navigation: true,
        speed: 300,
        // autoHeight: true,
    }

    // autoplay
    const autoplay = scroller.dataset.autoplay || "true"
    const pagination = scroller.dataset.pagination || "true"

    if (autoplay === "true") {
        var delay = scroller.dataset.delay || 3000
        // not sure why, but parseInt(data-delay="0") fails
        if (delay === "0") {
            delay = 0
        } else {
            delay = parseInt(delay)
        }
        const pause = scroller.dataset.pause || "true"
        options.autoplay = {
            delay: delay,
        }

        if (pause === 'true') {
            options.autoplay.pauseOnMouseEnter = true
        } else {
            options.allowTouchMove = false
        }
    }

    // pagination
    if (pagination === "true") {
        options.pagination = {
            el: ".swiper-pagination",
            clickable: true,
        }
    }

    // loop
    if (scroller.dataset.loop === "false") {
        options.loop = false
    }

    // navigation
    if (scroller.dataset.navigation === "false") {
        options.navigation = false
    }

    // speed
    const speed = parseInt(scroller.dataset.speed) || 300
    options.speed = speed

    // slides per view
    const perView = parseInt(scroller.dataset.perView) || 1
    if (perView !== 1) {
        options.slidesPerView = perView
    }

    // slides per group
    const perGroup = parseInt(scroller.dataset.perGroup) || 1
    if (perGroup !== 1) {
        options.slidesPerGroup = perGroup
    }

    // space between
    const spaceBetween = parseInt(scroller.dataset.spaceBetween) || 0
    if (spaceBetween !== 0) {
        options.spaceBetween = spaceBetween
    }

    // breakpoints for multiple slides per view
    const breakpoints = scroller.dataset.breakpoints
    if (breakpoints) {
        options.breakpoints = JSON.parse(breakpoints)
    }

    // effect
    if (scroller.dataset.effect) {
        options.effect = scroller.dataset.effect
        if (scroller.dataset.effect === 'fade') {
            options.fadeEffect = {
                crossFade: true,
            }
        }
    }

    // console.log(options)
    new Swiper(scroller, options)
})
