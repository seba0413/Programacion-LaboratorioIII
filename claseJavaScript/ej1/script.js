// function Saludar(){
//    // document.write("Hola Mundo");
//     console.log("Escribo en la consola");
//     window.alert("Hola Pepe");    
// }

// document.getElementById("p1").innerHTML = "Esto es un parrafo";

// document.getElementById("midiv").innerHTML = "<h2> Esto es un titulo</h2>";


// document.getElementById('p1').addEventListener('click', function(){
//     this.innerHTML = "Hola mundo";
// });

window.addEventListener('load', inicializarEventos);

function inicializarEventos(){
    miParrafo = document.getElementById('p1');

    miParrafo.addEventListener('click', function(){
        this.innerHTML = 'Hola';
    })
}

//Forma corta
window.addEventListener('load', function(){
    document.getElementById('p1').addEventListener('click', function(){
        this.innerHTML = "Hola";
    })
});

