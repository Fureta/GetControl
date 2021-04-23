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
           
        GetProjects();
        GetClients();
}


function GetProjects ()
{
    ButtonCancel();
    cliente=$("#client").val();
    datos = {"cliente":cliente};
    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Projects.php",
            type: "POST",
            dataType:'json',
            data: datos
        }).done(

        function(respuesta)
        {
            tableOpen="";
            
            for(i=0;i<respuesta.length;i++)
            {
                tableOpen += "<tr><td>"+respuesta[i].EMPRESA+"</td><td>"+respuesta[i].NPROYECTO+"</td><td>"+respuesta[i].DESCRIPCION+"</td><td>"+respuesta[i].USUARIO+"</td><td>"+respuesta[i].ESTADO+"</td><td>"+respuesta[i].FECHA+"</td><td>"+respuesta[i].FECHA_ENTREGA+"</td><td>"+respuesta[i].HORAS+"</td><td>$"+respuesta[i].PRECIO+"</td><td><a href='#page-top' onclick='ModifyProjects("+respuesta[i].NPROYECTO+")'  class='btn btn-warning btn-circle'><i class='fas fa-eye'></i></a><a href='./model/Items.php?id="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"'  class='btn btn-success btn-circle'><i class='fas fa-list-alt'></i></a><a href='model/GeneratePDF.php?proyecto="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"' class='btn btn-primary btn-circle'><i class='fas fa-download'></i></a><a href='#' onclick='DeleteProjects("+respuesta[i].NPROYECTO+")' data-toggle='modal' data-target='#DeleteItemModal' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></a></td></tr>";

            };

            $("#TableProjects").html(tableOpen);
            
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
            
            Clientes="<option value=''></option>";
            
            for(i=0;i<respuesta.length;i++)
            {
                if(respuesta[i].EMPRESA!="FindControl")
                {
                    Clientes += "<option value='"+respuesta[i].NCLIENTE+"'>"+respuesta[i].EMPRESA+"</option>";
                }        
            };
            
            $("#client").html(Clientes);
            $("#Clientes").html(Clientes);
            
        });
}

function ModifyProjects(id)
{
    ButtonUpdate();
    cliente=$("#client").val();
    datos = {"cliente":cliente};
    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Projects.php",
            type: "POST",
            dataType:'json',
            data: datos
        }).done(

        function(respuesta)
        {
            for(i=0;i<respuesta.length;i++)
            {
                if(respuesta[i].NPROYECTO==id)
                {
                    console.log(respuesta);
                    Descripcion=respuesta[i].DESCRIPCION;
                    DeadLine=respuesta[i].DEADLINE;
                    Fecha=respuesta[i].FECHAMOD;
                    Clientes=respuesta[i].NCLIENTE;

                    $("#Descripcion").val(Descripcion);
                    $("#DeadLine").val(DeadLine);
                    $("#Fecha").val(Fecha);
                    $("#Clientes").val(Clientes);
                    $("#id").val(id);
                }
            }
        });
}

function UpdateProjects()
{
    type="UpdateProjects";
    id=$("#id").val();
    Descripcion=$("#Descripcion").val();
    DeadLine=$("#DeadLine").val();
    Fecha=$("#Fecha").val();
    Clientes=$("#Clientes").val();
    ProyectoSingular=$("#ProyectoSingular").val();

    datos = {
        "id":id,
        "type":type,
        "Descripcion":Descripcion,
        "DeadLine":DeadLine,
        "Fecha":Fecha,
        "Clientes":Clientes,
        "ProyectoSingular":ProyectoSingular
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
            GetProjects();
        });
}

function DeleteProjects(id)
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
          
        type="DeleteProjects";
    
        datos = {
            "id":id,
            "type":type
        };
        /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
        $.ajax(
            {
                url: "controller/Delete.php",
                type: "POST",
                data: datos
            }).done(

            function(respuesta)
            {
                
                GetProjects();
            });
        }
      });

}


function InsertProjects ()
{
    Descripcion=$("#Descripcion").val();
    Fecha=$("#Fecha").val();
    DeadLine=$("#DeadLine").val();
    Clientes=$("#Clientes").val();
    ProyectoSingular=$("#ProyectoSingular").val();
    type="InsertProjects";

    datos = {
        "type":type,
        "Descripcion":Descripcion,
        "DeadLine":DeadLine,
        "Fecha":Fecha,
        "Clientes":Clientes,
        "ProyectoSingular":ProyectoSingular
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
            
            GetProjects();
        });
}

function ButtonAdd()
{
    $("#AddInit").addClass("Hide");

    $("#FormAdd").removeClass("Hide");
    
    $("#Insert").removeClass("Hide");
    $("#Update").addClass("Hide");

    $("#Descripcion").focus();

    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth()+1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var ano = fecha.getFullYear(); //obteniendo año
    if(dia<10)
        dia='0'+dia; //agrega cero si el menor de 10
    if(mes<10)
        mes='0'+mes //agrega cero si el menor de 10
    document.getElementById('Fecha').value=ano+"-"+mes+"-"+dia;
    
}

function ButtonCancel()
{
    $("#Descripcion").val("");
    $("#DeadLine").val("");
    $("#Clientes").val("");

    $("#FormAdd").addClass("Hide");
    $("#AddInit").removeClass("Hide");
    
}

function ButtonUpdate()
{
    $("#FormAdd").removeClass("Hide");

    $("#AddInit").addClass("Hide");

    $("#Update").removeClass("Hide");
    $("#Insert").addClass("Hide");

    $("#Descripcion").focus();
}
