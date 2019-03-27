var btnModal;
var btnCerrar;
var modal;

window.addEventListener('load', ()=>{

    btnModal = document.getElementById('btnModal');
    btnCerrar = document.getElementById('btnCerrar');
    modal = document.getElementById('modal');

    btnModal.addEventListener('click', ()=>{
        //modal.open = !modal.open;
        modal.setAttribute('open', true);
    });
    
    btnCerrar.addEventListener('click', ()=>{
    
        modal.removeAttribute('open');
    });
})


