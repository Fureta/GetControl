$(document).ready(Getinfo);

function Getinfo()
{

    /// TRAIGO LA INFORMACION DEL USUARIO QUE SE LOGEA Y LO MUESTRO EN PANTALLA
    $.ajax(
        {
            url: "model/Encuestas.php",
            type: "POST"
        }).done(
    
        function(respuesta)
        {
            if (respuesta[0].PREGUNTA1!="")
            {
                $("#InsertEncuestas").addClass("Hide");
                $("#Gracias").removeClass("Hide");
            }
            console.log(respuesta);
            $("#Proyecto").val(respuesta[0].DESCRIPCION);
            $("#Empresa").val(respuesta[0].EMPRESA);
            $("#Nombre").val(respuesta[0].NOMBRE);

            $("#id").val(respuesta[0].NPROYECTO);
            $("#cliente").val(respuesta[0].NCLIENTE);

            $("#Pregunta1").val(respuesta[0].PREGUNTA1);
            $("#Pregunta2").val(respuesta[0].PREGUNTA2);
            $("#Pregunta3").val(respuesta[0].PREGUNTA3);
            $("#Pregunta4").val(respuesta[0].PREGUNTA4);
            $("#Pregunta5").val(respuesta[0].PREGUNTA5);
        }); 
        
}

function InsertEncuestas()
{
    Proyecto=$("#id").val();
    Cliente=$("#cliente").val();
    Nombre=$("#Nombre").val();

    Pregunta1=$("#Pregunta1").val();
    Pregunta2=$("#Pregunta2").val();
    Pregunta3=$("#Pregunta3").val();
    Pregunta4=$("#Pregunta4").val();
    Pregunta5=$("#Pregunta5").val();
    type="InsertEncuestas";

    if (Nombre=="" || Pregunta1=="" || Pregunta2=="" || Pregunta3=="" || Pregunta4=="" )
    {
        
        $("#CompletarCampos").modal('show');
           
        return false;
    }
    datos = {
        "type":type,
        "Proyecto":Proyecto,
        "Cliente":Cliente,
        "Nombre":Nombre,
        "Pregunta1":Pregunta1,
        "Pregunta2":Pregunta2,
        "Pregunta3":Pregunta3,
        "Pregunta4":Pregunta4,
        "Pregunta5":Pregunta5
    };
    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "controller/Insert.php",
            type: "POST",
            dataType:'json',
            data: datos
        }).done(

        function(respuesta)
        {
            console.log("OK");
            $("#InsertEncuestas").addClass("Hide");
            $("#Gracias").removeClass("Hide");
        }
        );
}
