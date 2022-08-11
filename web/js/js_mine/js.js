//Range of date in result. File:clienteReporte.html.twig
var fecha_ingreso = document.getElementById("interval_fecha_ingreso");
var fecha_pago = document.getElementById("interval_fecha_pago");
if (fecha_ingreso !== null && fecha_ingreso !== undefined){
    document.getElementById("date_pay_start").innerHTML="ingreso";
}
else if (fecha_pago !== null && fecha_pago !== undefined){
    document.getElementById("date_pay_start").innerHTML="pago";
}
else {
    document.getElementById("date_pay_start").innerHTML="---";
}


function date_pay(){
    var fecha_ingreso = document.getElementById("interval_fecha_ingreso");
    var fecha_pago = document.getElementById("interval_fecha_pago");
    if (fecha_ingreso !== null && fecha_ingreso !== undefined){
        document.getElementById("date_pay_start").innerHTML="ingreso";
    }
    else if (fecha_pago !== null && fecha_pago !== undefined){
        document.getElementById("date_pay_start").innerHTML="pago";
    }
    else {
        document.getElementById("date_pay_start").innerHTML="nada";
    }


}
function date_start(){
    document.getElementById("date_pay_start").innerHTML="ingreso";

}

//Change the icon of genero. The Result in the right side.
var genero = document.getElementById("genero_result");
var icono_genero = document.getElementById("icono_genero");
// genero.style.backgroundColor="red";
if(genero.textContent === "Femenino"){
    icono_genero.setAttribute("class", "fa fa-female yellow-bg");
}
if(genero.textContent === "Masculino"){
    icono_genero.setAttribute("class", "fa fa-male yellow-bg");
}

