// Checked with spatie/statamic-responsive 5.2.1

// 2022-07-07
// Fixes an issue with iPad 7 where the responsive image wouldnt load.
// Uses this: https://github.com/juggle/resize-observer#switching-between-native-and-polyfilled-versions
// import { ResizeObserver as Polyfill } from '@juggle/resize-observer';
import { ResizeObserver as Polyfill } from './resize-observer/lib/exports/resize-observer';
const ResizeObserver = window.ResizeObserver || Polyfill;

// adapted from vendor/spatie/statamic-responsive-images/resources/views/responsiveImage.blade.php
window.addEventListener('load', function () {
    window.responsiveResizeObserver = new ResizeObserver((entries) => {
        entries.forEach(entry => {
            const imgWidth = entry.target.getBoundingClientRect().width;
            entry.target.parentNode.querySelectorAll('source').forEach((source) => {
                source.sizes = Math.ceil(imgWidth / window.innerWidth * 100) + 'vw';
            });
        });
    });

    document.querySelectorAll('[data-statamic-responsive-images]').forEach(responsiveImage => {
        responsiveResizeObserver.onload = null;
        responsiveResizeObserver.observe(responsiveImage);
    });
});