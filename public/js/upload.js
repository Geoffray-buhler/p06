const all_btn = document.querySelectorAll("[data-name]");
const all_rem_btn = document.querySelectorAll(".btn-danger-pos");

all_btn.forEach(element => {
    element.addEventListener('click',(e)=>{
        let popup = document.querySelector(`div[data-name = ${e.target.dataset.name}]`);
        popup.classList.toggle('hide');
    })
});

all_rem_btn.forEach(element => {
  element.addEventListener('click',(e)=>{
    e.target.parentElement.parentElement.classList.add('hide');
  })
});

const input = document.querySelectorAll('.input');
input.forEach(element => {
  element.addEventListener('change', function (e){
    e.preventDefault();
    let datatype = element.dataset.name;
    Sending(e.target.value,datatype);
  });
});

const Sending = (value,typedata) => {
    let inits = { method: 'POST',
    body: {
      'type':typedata,
      'value':value
    },
    mode: 'no-cors',
    cache: 'default' };
  
    fetch(`/profil/editUser/${value}/${typedata}`,inits )
    .then(function(response) {
      check = document.querySelector(`#${typedata}`);
      check.classList.toggle('hide');
      window.setTimeout( ()=>{
        check.classList.toggle('hide');
      }, 5000);
    })
  }