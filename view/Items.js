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
        GetItems();
}



function GetItems ()
{
    ButtonCancel();
    datos = {"id":"",
             "cliente":""};
    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Items.php",
            type: "GET",
            dataType:'json',
            data: datos
        }).done(

        function(respuesta)
        {
            tableOpen="";

            $("#Title").html("#"+respuesta[0].NPROYECTO+" - "+respuesta[0].PRODESCRIPCION);

            if(respuesta[0].PERFIL==="1")
            {
                $("#Back").attr("href","Proyectos.html");
                
            }

            if (respuesta[0].NITEM=="")
            {
                $("#PanelTable").addClass("Hide");
            }
            else 
            {
                $("#PanelTable").removeClass("Hide");
                
                

                $("#GeneratePDF").attr("href",'model/GeneratePDF.php?proyecto='+respuesta[0].NPROYECTO+'&cliente='+respuesta[0].NCLIENTE);
                for(i=0;i<respuesta.length;i++)
                {
                    if(respuesta[i].PERFIL==="1")
                    {
                        $("#Columns").html("<th>N° Item</th><th>Item</th><th>Descripcion</th><th>Horas</th><th>Cotización</th><th>Usuario Asignado</th><th>Estado</th><th>Acción</th>");
                        tableOpen += "<tr><td>"+respuesta[i].NITEM+"</td><td>"+respuesta[i].ITEM+"</td><td>"+respuesta[i].DESCRIPCION+"</td><td>"+respuesta[i].HORAS+"</td><td>$"+respuesta[i].PRECIO+"</td><td>"+respuesta[i].USUARIO+"</td><td>"+respuesta[i].ESTADO+"</td><td><a href='#page-top' onclick='ModifyProjects("+respuesta[i].NITEM+")'  class='btn btn-warning btn-circle'><i class='fas fa-eye'></i></a><a href='#' id='btn-confirm' onclick='DeleteItems("+respuesta[i].NITEM+")' data-toggle='modal' data-target='#DeleteItemModal' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></a></td></tr>";
                        
                    }
                    else
                    {
                        $("#Columns").html("<th>N° Item</th><th>Item</th><th>Descripcion</th><th>Horas</th><th>Cotización</th><th>Usuario Asignado</th><th>Estado</th>");
                
                        tableOpen += "<tr><td>"+respuesta[i].NITEM+"</td><td>"+respuesta[i].ITEM+"</td><td>"+respuesta[i].DESCRIPCION+"</td><td>"+respuesta[i].HORAS+"</td><td>$"+respuesta[i].PRECIO+"</td><td>"+respuesta[i].USUARIO+"</td><td>"+respuesta[i].ESTADO+"</td></tr>";
                        $("#find").addClass("invisible");
                        $("#AddInit").addClass("Hide");
                    }
                };

                $("#TableProjects").html(tableOpen);
            }
            
            
        });
}

function ModifyProjects(id)
{
    ButtonUpdate();

    datos = {"id":id};
    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Items.php",
            type: "POST",
            dataType:'json',
            data: datos
        }).done(

        function(respuesta)
        {

            for(i=0;i<respuesta.length;i++)
            {
                if(respuesta[i].NITEM==id)
                {
                    console.log(respuesta[i]);
                    Item=respuesta[i].ITEM;
                    Horas=respuesta[i].HORAS;
                    Descripcion=respuesta[i].DESCRIPCION;
                    Estado=respuesta[i].ESTADO;
                    id=respuesta[i].NITEM;

                    $("#id").val(id);
                    $("#Item").val(Item);
                    $("#Horas").val(Horas);
                    $("#Descripcion").val(Descripcion);
                    $("#Estado").val(Estado);
                }
            }
        });
}

function UpdateItems()
{
    type="UpdateItems";
    Item=$("#Item").val();
    Horas=$("#Horas").val();
    Descripcion=$("#Descripcion").val();
    Estado=$("#Estado").val();
    id=$("#id").val();
    
    datos = {
        "type":type,
        "id":id,
        "Item":Item,
        "Horas":Horas,
        "Descripcion":Descripcion,
        "Estado":Estado
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
            GetItems();
        });
}

function DeleteItems(id)
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
          
        type="DeleteItems";

        datos = {
            "type":type,
            "id":id
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
                    GetItems();
                });
    
        }else{
            
        }
      });

}

function InsertItem ()
{
    type="InsertItems";
    Item=$("#Item").val();
    Horas=$("#Horas").val();
    Descripcion=$("#Descripcion").val();
    Estado=$("#Estado").val();
    
    datos = {
        "type":type,
        "Item":Item,
        "Horas":Horas,
        "Descripcion":Descripcion,
        "Estado":Estado
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
            
            GetItems();
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
    $("#Item").val("");
    $("#Horas").val("");
    $("#Descripcion").val("");
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

    $("#Item").focus();
}
