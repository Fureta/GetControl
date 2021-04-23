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
            
        });    
        GetContracts();
        GetClients();
}


function GetContracts ()
{
    ButtonCancel();
    type="GetContracts";
    cliente=$("#client").val();
    
    datos = {"type":type};

    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Contracts.php",
            type: "POST",
            dataType:'json',
            data: datos
        }).done(

        function(respuesta)
        {
            console.log(respuesta);
            window.tableOpen="";

            if (window.tableOpen) {
                window.tableOpen.clear();
                window.tableOpen.destroy();
            }
            
            for(i=0;i<respuesta.length;i++)
            {
                
                if (cliente==="")
                {
                    tableOpen += "<tr><td>"+respuesta[i].NCLIENTE+"</td><td>"+respuesta[i].EMPRESA+"</td><td>"+respuesta[i].OC+"</td><td>"+respuesta[i].FECHAINICIO+"</td><td>"+respuesta[i].FECHAFIN+"</td><td>"+respuesta[i].VALORHORACON+"</td><td>"+respuesta[i].HORASCONTRATADAS+"</td><td>"+respuesta[i].ESTADO+"</td><td>"+respuesta[i].EXCEDENTE+"</td><td><a href='#Empresa' onclick='ModifyContracts("+respuesta[i].NCONTRATO+")'  class='btn btn-warning btn-circle'><i class='fas fa-eye'></i></a><a href='#' id='btn-confirm' onclick='DeleteContracts("+respuesta[i].NCONTRATO+")' data-toggle='modal' data-target='#DeleteItemModal' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></a></td></tr>";
                }
                else if (respuesta[i].NCLIENTE==cliente)
                {
                    tableOpen += "<tr><td>"+respuesta[i].NCLIENTE+"</td><td>"+respuesta[i].EMPRESA+"</td><td>"+respuesta[i].OC+"</td><td>"+respuesta[i].FECHAINICIO+"</td><td>"+respuesta[i].FECHAFIN+"</td><td>"+respuesta[i].VALORHORACON+"</td><td>"+respuesta[i].HORASCONTRATADAS+"</td><td>"+respuesta[i].ESTADO+"</td><td>"+respuesta[i].EXCEDENTE+"</td><td><a href='#Empresa' onclick='ModifyContracts("+respuesta[i].ID+")'  class='btn btn-warning btn-circle'><i class='fas fa-eye'></i></a><a href='#' id='btn-confirm' onclick='DeleteContracts("+respuesta[i].NCONTRATO+")' data-toggle='modal' data-target='#DeleteItemModal' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></a></td></tr>";
                } 
            };

            $("#TableContracts").html(tableOpen);
            
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
            
            $("#Clientes").html(Clientes);
            $("#client").html(Clientes);
        });
}



function ModifyContracts(id)
{
    ButtonUpdate();
    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Contracts.php",
            type: "POST",
            dataType:'json'
        }).done(

        function(respuesta)
        {
            for(i=0;i<respuesta.length;i++)
            {
                if(respuesta[i].NCONTRATO==id)
                {
                    empresa=respuesta[i].NCLIENTE;
                    oc=respuesta[i].OC;
                    valorhora=respuesta[i].VALORHORACON;
                    horascontratadas=respuesta[i].HORASCONTRATADAS;
                    estado=respuesta[i].ESTADOMOD;
                    fechaini=respuesta[i].FECINIMOD;
                    fechafin=respuesta[i].FECFINMOD;
                    

                    $("#Clientes").val(empresa);
                    $("#OC").val(oc);
                    $("#ValorHora").val(valorhora);
                    $("#PackHoras").val(horascontratadas);
                    $("#Estado").val(estado);
                    $("#FecIni").val(fechaini);
                    $("#FecFin").val(fechafin);
                    $("#id").val(id);
                }
            }
        });
}
function UpdateContracts()
{
    type="UpdateContracts";
    cliente=$("#Clientes").val();
    oc=$("#OC").val();
    valorhora=$("#ValorHora").val();
    packhoras=$("#PackHoras").val();
    estado=$("#Estado").val();
    fecini=$("#FecIni").val();
    fecfin=$("#FecFin").val();
    id=$("#id").val();

    datos = {
        "type":type,
        "id":id,
        "cliente":cliente,
        "oc":oc,
        "valorhora":valorhora,
        "packhoras":packhoras,
        "estado":estado,
        "fecini":fecini,
        "fecfin":fecfin
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
            GetContracts();
        });
}

function DeleteContracts(id)
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
          
        type="DeleteContracts";
    
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
                
                GetContracts();
            });
        }
      });

}
function InsertContracts()
{
    type="InsertContracts";
    cliente=$("#Clientes").val();
    oc=$("#OC").val();
    valorhora=$("#ValorHora").val();
    packhoras=$("#PackHoras").val();
    estado=$("#Estado").val();
    fecini=$("#FecIni").val();
    fecfin=$("#FecFin").val();
    
    datos = {
        "type":type,
        "cliente":cliente,
        "oc":oc,
        "valorhora":valorhora,
        "packhoras":packhoras,
        "estado":estado,
        "fecini":fecini,
        "fecfin":fecfin
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
            
            GetContracts();
        });
}

function ButtonAdd()
{
    
    $("#AddInit").addClass("Hide");

    $("#FormAdd").removeClass("Hide");
    
    $("#Insert").removeClass("Hide");
    $("#Update").addClass("Hide");

    $("#Clientes").focus();
}

function ButtonCancel()
{
    $("#Clientes").val("");
    $("#OC").val("");
    $("#ValorHora").val("");
    $("#PackHoras").val("");
    $("#Estado").val("");

    $("#FormAdd").addClass("Hide");
    $("#AddInit").removeClass("Hide");
    
}

function ButtonUpdate()
{
    $("#FormAdd").removeClass("Hide");

    $("#AddInit").addClass("Hide");

    $("#Update").removeClass("Hide");
    $("#Insert").addClass("Hide");

    $("#Clientes").focus();
}
