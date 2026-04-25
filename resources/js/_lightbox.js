import GLightbox from 'glightbox'

document.querySelectorAll('[data-lightbox]').forEach(lightbox => {
    GLightbox({ selector: `[data-lightbox="${lightbox.dataset.lightbox}"]` })
})