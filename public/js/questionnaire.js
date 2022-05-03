let container = document.querySelector('#new_trick_Youtube');
const btnadd = document.querySelector('#btnadd');
let youtubelink = [];

const createInput = (id)=>{
    container = document.querySelector('#new_trick_Youtube');
    container.innerHTML += `<input id="new_trick_${id}" class="youtube" type="text" placeholder="Mettre le lien ici !" value type="text" name="new_trick[Youtube][${id}]">`;
    majInput();
}

const majInput = () => {
    youtubelink = document.querySelectorAll('.youtube');
    youtubelink.forEach(element => {
        element.addEventListener('input',(e)=>{
            if (e.target.value.includes('https://www.youtube.com/')) {
                e.target.classList.add('ok');
            }else{
                e.target.classList.remove('ok');
            }
        })
    });
}

btnadd.addEventListener('click',() => {
    youtubelink = document.querySelectorAll('.youtube');
    let nbr = youtubelink.length;
    if (nbr+1 < 6) {
        createInput(nbr+1);
    }
})

createInput(1);
majInput()

youtubelink = document.querySelectorAll('.youtube')