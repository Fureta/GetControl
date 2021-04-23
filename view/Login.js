$(document).ready(LoginUser);

function LoginUser()
{   
    
    $("#user").focus();
    var user=$("#user").val();
    var password=$("#password").val();

    datos = 
    {
        "user":user, 
        "password":password
    };

    $.ajax(
    {
        url: "model/ValidateUser.php",
        type: "POST",
        data: datos
    }).done(

    function(respuesta)
    {
        
        if (respuesta.res === "ok") 
        {
            location = "index.html";
        }
        else if (respuesta.res==="noPass")
        {   
            $("#titleModal").html("Contraseña incorrecta.");
            $("#descriptionModal").html("Su contraseña es incorrecta, favor intente nuevamente.")
            $("#Noregistrado").modal('show');
            $("#user").val("");
            $("#password").val("");
            
        }else
        {
            $("#titleModal").html("Usuario no registrado.");
            $("#descriptionModal").html("El usuario no está registrado en nuestra base de datos.")
            $("#Noregistrado").modal('show');
            $("#user").val("");
            $("#password").val("");
        }
    });
}