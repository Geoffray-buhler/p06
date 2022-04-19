let arrow = document.querySelector('#arrow');
window.addEventListener('scroll', function() {
	let elements = document.querySelectorAll('.card');
    let nav = document.querySelector('nav');

    elements.forEach(element => {
        let position = element.getBoundingClientRect();

        if(position.top >= 0 && position.bottom <= window.innerHeight) {
            arrow.href = '#nav';
            arrow.classList.add('return180');
            arrow.classList.remove('return0');
        }
    });

    let positionNav = nav.getBoundingClientRect();
    if (positionNav.top >= 0 && positionNav.bottom <= window.innerHeight) {
        arrow.href = '#tricksContainer';
        arrow.classList.add('return0');
        arrow.classList.remove('return180');
    }
});