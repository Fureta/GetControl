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
                
            }
            $("#find").removeClass("invisible");
        });    
        GetClients();
}
function GetClients ()
{
    ButtonCancel();
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
            console.log(respuesta);
            tableOpen="";
            
            
            for(i=0;i<respuesta.length;i++)
            {
                tableOpen += "<tr><td>"+respuesta[i].NCLIENTE+"</td><td>"+respuesta[i].EMPRESA+"</td><td>"+respuesta[i].CUIL+"</td><td>"+respuesta[i].DIRECCION+"</td><td>"+respuesta[i].MAIL_FACTURACION+"</td><td><a href='#Empresa' onclick='ModifyClients("+respuesta[i].NCLIENTE+")'  class='btn btn-warning btn-circle'><i class='fas fa-eye'></i></a><a href='#' id='btn-confirm' onclick='DeleteClients("+respuesta[i].NCLIENTE+")' data-toggle='modal' data-target='#DeleteItemModal' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></a></td></tr>";
                
                $("#find").addClass("invisible");
            };

            $("#TableProjects").html(tableOpen);
            
        });
}

function ModifyClients(id)
{
    ButtonUpdate();
    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Clients.php",
            type: "POST",
            dataType:'json'
        }).done(

        function(respuesta)
        {
            for(i=0;i<respuesta.length;i++)
            {
                if(respuesta[i].NCLIENTE==id)
                {
                    
                    Empresa=respuesta[i].EMPRESA;
                    Cuil=respuesta[i].CUIL;
                    Direccion=respuesta[i].DIRECCION;
                    MailFacturacion=respuesta[i].MAIL_FACTURACION;
                    id=respuesta[i].NCLIENTE;

                    $("#Empresa").val(Empresa);
                    $("#Cuil").val(Cuil);
                    $("#Direccion").val(Direccion);
                    $("#MailFacturacion").val(MailFacturacion);
                    $("#id").val(id);
                }
            }
        });
}
function UpdateClients()
{
    type="UpdateClients";
    Empresa=$("#Empresa").val();
    Cuil=$("#Cuil").val();
    Direccion=$("#Direccion").val();
    MailFacturacion=$("#MailFacturacion").val();
    Contrato=$("#Contrato").val();
    HorasContratadas=$("#HorasContratadas").val();
    id=$("#id").val();

    datos = {
        "id":id,
        "type":type,
        "Empresa":Empresa,
        "Cuil":Cuil,
        "Direccion":Direccion,
        "MailFacturacion":MailFacturacion,
        "Contrato":Contrato,
        "HorasContratadas":HorasContratadas
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
            console.log(respuesta);

            ButtonAdd();
            GetClients();
        });
}

function DeleteClients(id)
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
          
        type="DeleteClients";
    
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
                console.log(respuesta);
                GetClients();
            });
        }
      });

}
function InsertClients()
{
    type="InsertClients";
    Empresa=$("#Empresa").val();
    Cuil=$("#Cuil").val();
    Direccion=$("#Direccion").val();
    MailFacturacion=$("#MailFacturacion").val();
    Contrato=$("#Contrato").val();
    HorasContratadas=$("#HorasContratadas").val();

    datos = {
        "type":type,
        "Empresa":Empresa,
        "Cuil":Cuil,
        "Direccion":Direccion,
        "MailFacturacion":MailFacturacion,
        "Contrato":Contrato,
        "HorasContratadas":HorasContratadas
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
            console.log(respuesta);
            GetClients();
        });
}
function ButtonAdd()
{
    
    $("#AddInit").addClass("Hide");

    $("#FormAdd").removeClass("Hide");
    
    $("#Insert").removeClass("Hide");
    $("#Update").addClass("Hide");

    $("#Item").focus();
}

function ButtonCancel()
{
    $("#Nombre").val("");
    $("#Clientes").val("");
    $("#Perfil").val("");

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
