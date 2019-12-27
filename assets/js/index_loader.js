document.querySelector(".first").addEventListener('mouseenter', e => {
    $('.first').dimmer('hide');
    $('.second').dimmer('show');
});

document.querySelector(".second").addEventListener('mouseenter', e => {
    $('.first').dimmer('show');
    $('.second').dimmer('hide');
});


document.querySelector(".first").addEventListener("mouseleave", e => {
    $('.first').dimmer('hide');
    $('.second').dimmer('hide');
});

document.querySelector(".second").addEventListener('mouseleave', e => {
    $('.first').dimmer('hide');
    $('.second').dimmer('hide');
});