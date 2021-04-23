$(document).ready(Getinfo);

function Getinfo()
{
    
    /// TRAIGO LA INFORMACION DEL USUARIO QUE SE LOGEA Y LO MUESTRO EN PANTALLA
    $.ajax(
        {
            url: "model/Users.php",
            type: "POST"
        }).done(
    
        function(respuesta)
        {
            $("#name").html(respuesta[0].NOMBRE);

            if (respuesta[0].PERFIL === "1") 
            {
                $("#AdminBar").removeClass("Hide");
                $("#find").removeClass("invisible");
            }
        });    
        GetUsers();
}
function GetUsers ()
{
    ButtonCancel();
    type="GetUsers";
    datos = {"type":type};

    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Users.php",
            type: "POST",
            dataType:'json',
            data: datos
        }).done(

        function(respuesta)
        {
            console.log(respuesta);
            tableOpen="";
            
            
            for(i=0;i<respuesta.length;i++)
            {
                
                tableOpen += "<tr><td>"+respuesta[i].EMPRESA+"</td><td>"+respuesta[i].NUSUARIO+"</td><td>"+respuesta[i].CLAVE+"</td><td>"+respuesta[i].NOMBRE+"</td><td>"+respuesta[i].MAIL+"</td><td>"+respuesta[i].PERFIL+"</td><td><a href='#Item' onclick='ModifyUsers("+respuesta[i].NUSUARIO+")'  class='btn btn-warning btn-circle'><i class='fas fa-eye'></i></a><a href='#' id='btn-confirm' onclick='DeleteUsers("+respuesta[i].NUSUARIO+")' data-toggle='modal' data-target='#DeleteItemModal' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></a></td></tr>";
                
                $("#find").addClass("invisible");
            };

            $("#TableProjects").html(tableOpen);
            
        });
}

function ModifyUsers(id)
{
    ButtonUpdate();
    GetClients();
    datos = {"type":"GetUsers"};
    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Users.php",
            type: "POST",
            dataType:'json',
            data: datos
        }).done(

        function(respuesta)
        {
            for(i=0;i<respuesta.length;i++)
            {
                if(respuesta[i].NUSUARIO==id)
                {
                    
                    Nombre=respuesta[i].NOMBRE;
                    
                    Clientes=respuesta[i].NCLIENTE;
                    Perfil=respuesta[i].NPERFIL;
                    Mail=respuesta[i].MAIL;
                    id=respuesta[i].NUSUARIO;

                    $("#Nombre").val(Nombre);
                    
                    $("#Mail").val(Mail);
                    $("#Clientes").val(Clientes);
                    $("#Perfil").val(Perfil);
                    $("#id").val(id);
                }
            }
        });
}


function GetClients ()
{
    
    type="GetClients";
    datos = {"type":type};

    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Clients.php",
            type: "POST",
            dataType:'json',
            data: datos
        }).done(

        function(respuesta)
        {
            
            tableOpen="<option value=''></option>";
            
            for(i=0;i<respuesta.length;i++)
            {
                
                tableOpen += "<option value='"+respuesta[i].NCLIENTE+"'>"+respuesta[i].EMPRESA+"</option>";
 
            };
            console.log(tableOpen);
            
            $("#Clientes").html(tableOpen);
        });
}
function UpdateUsers()
{
    type="UpdateUsers";
    id=$("#id").val();
    Nombre=$("#Nombre").val();
    Mail=$("#Mail").val();
    Clientes=$("#Clientes").val();
    Perfil=$("#Perfil").val();

    datos = {
        "id":id,
        "type":type,
        "Nombre":Nombre,
        "Mail":Mail,
        "Clientes":Clientes,
        "Perfil":Perfil
    };
    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "controller/Update.php",
            type: "POST",
            dataType:'json',
            data: datos
        }).done(

        function(respuesta)
        {
            
            ButtonAdd();
            GetUsers();
        });
}

function DeleteUsers(id)
{
    var modalConfirm = function(callback){
        $("#modal-btn-si").on("click", function(){
          callback(true);
          $("#DeleteItemModal").modal('hide');
        });
        
        $("#modal-btn-no").on("click", function(){
          callback(false);
          $("#DeleteItemModal").modal('hide');
        });
      };
      
      modalConfirm(function(confirm){
        if(confirm){
          
        type="DeleteUsers";
    
        datos = {
            "id":id,
            "type":type
        };
        /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
        $.ajax(
            {
                url: "controller/Delete.php",
                type: "POST",
                dataType:'json',
                data: datos
            }).done(

            function(respuesta)
            {
                
                GetUsers();
            });
        }
      });

}
function InsertUser()
{
    Nombre=$("#Nombre").val();
    
    Clientes=$("#Clientes").val();
    Perfil=$("#Perfil").val();
    Mail=$("#Mail").val();
    type="InsertUsers";

    datos = {
        "type":type,
        
        "Nombre":Nombre,
        "Clientes":Clientes,
        "Perfil":Perfil,
        "Mail":Mail
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
            
            GetUsers();
        });
}
function ButtonAdd()
{
    
    $("#AddInit").addClass("Hide");

    $("#FormAdd").removeClass("Hide");
    
    $("#Insert").removeClass("Hide");
    $("#Update").addClass("Hide");

    $("#Item").focus();

    
    GetClients();
}

function ButtonCancel()
{
    $("#Nombre").val("");
    $("#Clientes").val("");
    $("#Perfil").val("");
    $("#Mail").val("");

    $("#FormAdd").addClass("Hide");
    $("#AddInit").removeClass("Hide");
    
}

function ButtonUpdate()
{
    $("#FormAdd").removeClass("Hide");

    $("#AddInit").addClass("Hide");

    $("#Update").removeClass("Hide");
    $("#Insert").addClass("Hide");

    $("#Item").focus();
}
