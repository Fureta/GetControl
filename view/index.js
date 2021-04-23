$(document).ready(Getinfo);

$(window).scroll(function() {    
    posicionarMenu();
});
 
function posicionarMenu() {
    
    var altura_del_menu = $(window).scrollTop();
    
    $('#accordionSidebar').css('margin-top', (altura_del_menu) + 'px');
    
}
 
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
            if (respuesta.res==="no")
            {
                location = "login.html";
            }
            else 
            {
                window.meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                
                mesActual = new Date();
                mesActual=mesActual.getMonth()+1;
                window.mesPasado=window.mesActual-1;
                
                if (mesPasado==0)
                {
                    mesPasado=12;
                }
                
                generatePDF="model/GeneratePDF.php?proyecto=&cliente="+respuesta[0].CLIENTE+"&mes="+mesPasado;
                
                document.getElementById('GeneratePDF').setAttribute('href',generatePDF);
                
                $("#GeneratePDF").html("<i class='fas fa-download fa-sm text-white-50'></i> Extracto Horas "+meses[mesPasado-1]);

                $("#SearchProjects").html("Proyectos del mes de "+meses[mesActual-1]);
                $("#Mes").val(mesActual);
        
                $("#name").html(respuesta[0].NOMBRE);
                
                
                if (respuesta[0].PERFIL === "1") 
                {
                    $("#AdminBar").removeClass("Hide");
                    $("#find").removeClass("invisible");
                    $("#AdminBar").html("<!-- Nav Item - Dashboard --><li class='nav-item active'> <a class='nav-link' href='Cliente.html'><i class='fas fa-handshake'></i> <span>Clientes</span></a> </li> <!--Divider --><hr class='sidebar-divider my-0'><!-- Nav Item - Dashboard -->  <li class='nav-item active'><a class='nav-link' href='Contrato.html'><i class='fas fa-file-signature'></i>            <span>Contratos</span></a>  </li>  <!-- Divider --><hr class='sidebar-divider my-0'>          <li class='nav-item active'>        <a class='nav-link' href='Usuarios.html'> <i class='fas fa-user-astronaut'></i>           <span>Usuarios</span></a>     </li> <!-- Divider --><hr class='sidebar-divider my-0'>    <li class='nav-item active'>   <a class='nav-link' href='Proyectos.html'>  <i class='fas fa-clipboard-list'></i>   <span>Proyectos</span></a>          </li>         <hr class='sidebar-divider my-0'>   <li class='nav-item active'>  <a class='nav-link' href='Encuestas.html'>  <i class='fas fa-question'></i>      <span>Encuestas</span></a>      </li>   <hr class='sidebar-divider my-0'>");
                }
                FindClient();
                GetClients();
                GetCharts();
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
                if(respuesta[i].EMPRESA!="FindControl")
                {
                    tableOpen += "<option value='"+respuesta[i].NCLIENTE+"'>"+respuesta[i].EMPRESA+"</option>";
                }        
            }

            $("#client").html(tableOpen);
            $("#clientmobile").html(tableOpen);
            
        });
}
function FindClient ()
{
    mesActual = new Date();
    mesActual=mesActual.getMonth()+1;


    cliente=$("#client").val();
    generatePDF="model/GeneratePDF.php?proyecto=&cliente="+cliente+"&mes="+window.mesPasado;
    document.getElementById('GeneratePDF').setAttribute('href',generatePDF);

    datos = {"cliente":cliente};
    /// TRAIGO LAS CARDS SEGUN EL PERFIL
    $.ajax(
        {
            url: "model/Configuration.php",
            type: "POST",
            dataType:'json',
            data: datos
        }).done(
    
        function(respuesta)
        {   
            
            if (respuesta.res!="NoContract")
            {

                if (respuesta.CANTIDAD_HORAS>"0")
                {
                    $("#horastotales").html(respuesta.HORASTOTALES+"/"+(respuesta.CANTIDAD_HORAS*3));
                }
                else
                {
                    $("#horastotales").html(respuesta.HORASTOTALES);
                }
                $("#TituloHoraMes").html("Horas Mes "+window.meses[mesActual-1]);
                $("#horasmes").html(respuesta.HORASMESCURSO);

                $("#TituloSaldo").html("Saldo Mes "+window.meses[mesActual-1]);
                $("#saldomes").html("$"+respuesta.SALDOMESPASADO);

                $("#items").html(respuesta.TAREAS);
            
                $("#itemsBar").html("<div class='progress-bar bg-danger' role='progressbar' style='width:"+respuesta.TAREAS+"%' aria-valuenow='' aria-valuemin='0' aria-valuemax='50'></div>");
            }
            
            if (respuesta.res=="NoHours")
            {
                $("#horasmes").html(0);
                $("#horastotales").html(0);
                $("#saldomes").html("$0");
                $("#items").html("0");
                    
                $("#ModalHoras").modal('show');

            }
            else if (respuesta.res=="NoContract")
            {
                $("#horasmes").html(0);
                $("#horastotales").html(0);
                $("#saldomes").html("$0");
                $("#items").html("0");

                $("#ModalSaldo").modal('show');
            }
            var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            mesActual = new Date();
            mesActual=mesActual.getMonth()+1;
    
            $("#SearchProjects").html("Proyectos del mes de "+meses[mesActual-1]);
            $("#Mes").val(mesActual);
    
            GetCharts();
            GetProjects();
        });

        
        
}

function GetProjects ()
{
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
                   
            window.tableOpen="";
            window.tableClose="";

            if (window.tableClose) {
                window.tableClose.clear();
                window.tableClose.destroy();
            }

            if (window.tableOpen) {
                window.tableOpen.clear();
                window.tableOpen.destroy();
            }

           
            Fecha = new Date();
            anio=Fecha.getFullYear();
            nombreMes=$("#Mes").val();
            
            $("#SearchProjects").html("Proyectos del mes de "+window.meses[nombreMes-1]);
            
            mes=$("#Mes").val()+anio;

            
            for(i=0;i<respuesta.length;i++)
            {
                if (respuesta[i].PERFIL==="1")
                {
                    if ((respuesta[i].ESTADO==="Abierto" || respuesta[i].ESTADO==="Pendiente") )
                    {
                        window.tableOpen += "<tr><td>"+respuesta[i].EMPRESA+"</td><td>"+respuesta[i].NPROYECTO+"</td><td>"+respuesta[i].DESCRIPCION+"</td><td>"+respuesta[i].USUARIO+"</td><td>"+respuesta[i].ESTADO+"</td><td>"+respuesta[i].FECHA+"</td><td>"+respuesta[i].FECHA_ENTREGA+"</td><td>"+respuesta[i].HORAS+"</td><td>$"+respuesta[i].PRECIO+"</td><td><a href='./model/Items.php?id="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"'  class='btn btn-warning btn-circle'><i class='fas fa-eye'></i></a><a href='model/GeneratePDF.php?proyecto="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"' class='btn btn-primary btn-circle'><i class='fas fa-download'></i></a><a href='#' onclick='DeleteProjects("+respuesta[i].NPROYECTO+")' data-toggle='modal' data-target='#DeleteItemModal' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></a></td></td><tr>";
                    }
                    else if ((respuesta[i].ESTADO==="Cerrado") && (respuesta[i].MES===mes))
                    {
                        window.tableClose += "<tr><td>"+respuesta[i].EMPRESA+"</td><td>"+respuesta[i].NPROYECTO+"</td><td>"+respuesta[i].DESCRIPCION+"</td><td>"+respuesta[i].USUARIO+"</td><td>"+respuesta[i].ESTADO+"</td><td>"+respuesta[i].FECHA+"</td><td>"+respuesta[i].FECHA_ENTREGA+"</td><td>"+respuesta[i].HORAS+"</td><td>$"+respuesta[i].PRECIO+"</td><td><a href='./model/Items.php?id="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"'   class='btn btn-warning btn-circle'><i class='fas fa-eye'></i></a><a href='model/GeneratePDF.php?proyecto="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"'  class='btn btn-primary btn-circle'><i class='fas fa-download'></i></a><a href='#' onclick='DeleteProjects("+respuesta[i].NPROYECTO+")' data-toggle='modal' data-target='#DeleteItemModal' class='btn btn-danger btn-circle'><i class='fas fa-trash'></i></a><a href='model/Encuestas.php?id="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"' class='btn btn-dark btn-circle'><i class='fas fa-question'></i></a></td></td><tr>";
                    }
                }else
                {   
                    if ((respuesta[i].ESTADO==="Abierto" || respuesta[i].ESTADO==="Pendiente") )
                    {
                        window.tableOpen += "<tr><td>"+respuesta[i].EMPRESA+"</td><td>"+respuesta[i].NPROYECTO+"</td><td>"+respuesta[i].DESCRIPCION+"</td><td>"+respuesta[i].USUARIO+"</td><td>"+respuesta[i].ESTADO+"</td><td>"+respuesta[i].FECHA+"</td><td>"+respuesta[i].FECHA_ENTREGA+"</td><td>"+respuesta[i].HORAS+"</td><td>$"+respuesta[i].PRECIO+"</td><td></a><a href='./model/Items.php?id="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"'  class='btn btn-warning btn-circle'><i class='fas fa-eye'></i></a><a href='model/GeneratePDF.php?proyecto="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"'  class='btn btn-primary btn-circle'><i class='fas fa-download'></i></a></td></td><tr>";
                    }
                    else if ((respuesta[i].ESTADO==="Cerrado") && (respuesta[i].MES===mes))
                    {                 
                        window.tableClose += "<tr><td>"+respuesta[i].EMPRESA+"</td><td>"+respuesta[i].NPROYECTO+"</td><td>"+respuesta[i].DESCRIPCION+"</td><td>"+respuesta[i].USUARIO+"</td><td>"+respuesta[i].ESTADO+"</td><td>"+respuesta[i].FECHA+"</td><td>"+respuesta[i].FECHA_ENTREGA+"</td><td>"+respuesta[i].HORAS+"</td><td>$"+respuesta[i].PRECIO+"</td><td><a href='./model/Items.php?id="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"'  class='btn btn-warning btn-circle'><i class='fas fa-eye'></i></a><a href='model/GeneratePDF.php?proyecto="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"'  class='btn btn-primary btn-circle'><i class='fas fa-download'></i></a><a href='model/Encuestas.php?id="+respuesta[i].NPROYECTO+"&cliente="+respuesta[i].NCLIENTE+"' class='btn btn-dark btn-circle'><i class='fas fa-question'></i></a></td></td><tr>";
                    }
                }
            }
            

            if (window.tableOpen==="")
            {
                $("#ProjectsOpen").addClass("Hide");
                
            }
            else 
            {
                $("#ProjectsOpen").removeClass("Hide");
                $("#TableProjects").html(tableOpen);
            }   

            if (window.tableClose==="")
            {
                $("#ProjectsClose").addClass("Hide");
            }
            else 
            {
                $("#ProjectsClose").removeClass("Hide");
                $("#TableProjectsClose").html(tableClose);
            }
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
                dataType:'json',
                data: datos
            }).done(

            function(respuesta)
            {
                
                GetProjects();
                FindClient();
                GetCharts();
            });
        }
      });

}

function GetCharts ()
{
    
    cliente=$("#client").val();
    datos = {"cliente":cliente,"Chart":"Pie"};
    /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE
    $.ajax(
        {
            url: "model/Charts.php",
            type: "POST",
            
            data: datos
        }).done(

        function(respuesta)
        {
            
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            // Pie Chart Example
            var ctx = document.getElementById("Pie");
            
            var label=Array();
            var datas=Array();
            var color=Array();
            var references="";

           for(i=0;i<respuesta.length;i++)
            {
                    label[i]=respuesta[i].DESCRIPCION;
                    color[i]=respuesta[i].COLOR;
                    datas[i]=parseInt(respuesta[i].TOTAL);
                    references+="<span class='mr-2'><i style='color:"+respuesta[i].COLOR+"' class='fas fa-circle text'></i>"+respuesta[i].DESCRIPCION+"</span>";
            }

            $("#References").html(references);

            if (window.myPieChart) {
                window.myPieChart.clear();
                window.myPieChart.destroy();
            }
            
            window.myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: label,
                    datasets: [{
                    data: datas,
                    backgroundColor: color,
                    hoverBackgroundColor: color,
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    },
                    legend: {
                    display: false
                    },
                    cutoutPercentage: 80,
                },
            });
            
        });

        datos = {"cliente":cliente,"Chart":"Bar"};
        /// TRAIGO LOS PROYECTOS SEGUN EL CLIENTE

        $.ajax(
            {
                url: "model/Charts.php",
                type: "POST",
                
                data: datos
            }).done(
                
            function(respuesta)
            {    
                // Set new default font family and font color to mimic Bootstrap's default styling
                Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#858796';

                function number_format(number, decimals, dec_point, thousands_sep) {
                // *     example: number_format(1234.56, 2, ',', ' ');
                // *     return: '1 234,56'
                number = (number + '').replace(',', '').replace(' ', '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
                }
                
                var label=Array();
                var datas=Array();
                var color=Array();
                var references="";

                
               for(i=0;i<respuesta.length;i++)
                {
                        label[i]=window.meses[respuesta[i].Mes-1];
                        color[i]=respuesta[i].COLOR;
                        datas[i]=parseInt(respuesta[i].TOTAL);
                        references+="<span class='mr-2'><i style='color:"+respuesta[i].COLOR+"' class='fas fa-circle text'></i>"+respuesta[i].DESCRIPCION+"</span>";
                }
                
                $("#references").html(references);

                if (window.myBarChart) {
                    window.myBarChart.clear();
                    window.myBarChart.destroy();
                }

                // Bar Chart Example
                var ctx = document.getElementById("Bar");
                window.myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [{
                    label: "Proyectos",
                    backgroundColor: color,
                    hoverBackgroundColor: color,
                    borderColor: "#4e73df",
                    data: datas,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 45,
                        bottom: 0
                    }
                    },
                    scales: {
                    xAxes: [{
                        time: {
                        unit: 'month'
                        },
                        gridLines: {
                        display: false,
                        drawBorder: false
                        },
                        ticks: {
                        maxTicksLimit: 12
                        },
                        maxBarThickness: 25,
                    }],
                    yAxes: [{
                        ticks: {
                        min: 0,
                        max: 250,
                        maxTicksLimit: 10,
                        padding: 5
                        },
                        gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                        }
                    }],
                    },
                    legend: {
                    display: false
                    },
                    tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,

                    },
                }
                });

                
                
            });
    }

