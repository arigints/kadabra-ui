function showChartRoa(reqData) {

  am4core.useTheme(am4themes_animated);
  var chartRoa = am4core.create("chartRoa", am4charts.XYChart);

  chartRoa.colors.step = 2;
  generateChartData(reqData); //get data from ajax
  var dateAxis = chartRoa.xAxes.push(new am4charts.DateAxis());
  dateAxis.renderer.minGridDistance = 50;

  function createAxisAndSeries(field, name, opposite, bullet) {
    var valueAxis = chartRoa.yAxes.push(new am4charts.ValueAxis());
    if(chartRoa.yAxes.indexOf(valueAxis) != 0){
     valueAxis.syncWithAxis = chartRoa.yAxes.getIndex(0);
   }

   var series = chartRoa.series.push(new am4charts.LineSeries());
   series.dataFields.valueY = field;
   series.dataFields.dateX = "date";
   series.strokeWidth = 2;
   series.yAxis = valueAxis;
   series.name = name;
   series.tooltipText = "{name}: [bold]{valueY}[/]";
   series.tensionX = 0.8;
   series.showOnInit = true;

   var interfaceColors = new am4core.InterfaceColorSet();

   switch(bullet) {
    case "triangle":
    var bullet = series.bullets.push(new am4charts.Bullet());
    bullet.width = 12;
    bullet.height = 12;
    bullet.horizontalCenter = "middle";
    bullet.verticalCenter = "middle";

    var triangle = bullet.createChild(am4core.Triangle);
    triangle.stroke = interfaceColors.getFor("background");
    triangle.strokeWidth = 2;
    triangle.direction = "top";
    triangle.width = 12;
    triangle.height = 12;
    break;
    case "rectangle":
    var bullet = series.bullets.push(new am4charts.Bullet());
    bullet.width = 10;
    bullet.height = 10;
    bullet.horizontalCenter = "middle";
    bullet.verticalCenter = "middle";

    var rectangle = bullet.createChild(am4core.Rectangle);
    rectangle.stroke = interfaceColors.getFor("background");
    rectangle.strokeWidth = 2;
    rectangle.width = 10;
    rectangle.height = 10;
    break;
    default:
    var bullet = series.bullets.push(new am4charts.CircleBullet());
    bullet.circle.stroke = interfaceColors.getFor("background");
    bullet.circle.strokeWidth = 2;
    break;
  }
  
  valueAxis.renderer.line.strokeOpacity = 1;
  valueAxis.renderer.line.strokeWidth = 2;
  valueAxis.renderer.line.stroke = series.stroke;
  valueAxis.renderer.labels.template.fill = series.stroke;
  valueAxis.renderer.opposite = opposite;
}

createAxisAndSeries("valid", "Valid", true, "circle");
createAxisAndSeries("invalid", "Invalid", true, "triangle");
createAxisAndSeries("unknown", "Unknown", true, "rectangle");


chartRoa.legend = new am4charts.Legend();
chartRoa.cursor = new am4charts.XYCursor();


var chartData = [];
let mapTRoa = new Map();
let mapNmRC = new Map();
let dataResult = [];
// generate some random data, quite different range
function generateChartData(reqData) { 
  var url = "";
  if (reqData == "7d"){
    url = API_URL+"/stats/roa?range=7d";
    $(".title-roa-graph").html("Graph Roa Status Last 7 Day");
  }else if(reqData == "30d"){
    url = API_URL+"/stats/roa?range=30d";
    $(".title-roa-graph").html("Graph Roa Status Last 30 Day");
  }else if(reqData == "range"){
    var startDate = $("#startDateRoa").val();
    var endDate = $("#endDateRoa").val();
    var startReverse = startDate.split("/").reverse().join("-");
    var endReverse = endDate.split("/").reverse().join("-");
    url = API_URL+"/stats/roa?start="+startReverse+"&end="+endReverse;

    $(".title-roa-graph").html("Graph Roa Status From "+startDate+" to "+endDate);
  }

  $(".title-roa-graph").append('<br/> <select class="form-control" id="selectRC"><option>-- Select RC --</option></select>');

  $.ajax({type:"GET",url: url,header:{"Content-Type" : "application/json; charset=UTF-8"},cache:false,
    success: function(result){

      $.each(result, function(i, item) {
        var newDate = new Date(item.date);
        newDate.setDate(newDate.getDate());
        newDate.setHours(0, 0, 0, 0);

        $.each(item.roa_stats, function(i, roaItem) {
         if(!mapTRoa.has(item.date+roaItem.rc)){
           mapTRoa.set(item.date+roaItem.rc,true);
           dataResult.push({
            rc:roaItem.rc,
            date:newDate,
            valid:roaItem.stats.valid,
            invalid:roaItem.stats.invalid,
            unknown:roaItem.stats.unknown
          });
         }

         if(!mapNmRC.has(roaItem.rc)){
           mapNmRC.set(roaItem.rc);
           $("#selectRC").append("<option value='"+roaItem.rc+"'>"+roaItem.rc+"</option>");
         }
       });
      });

      chartRoa.data = chartData;
    }
  });
}

chartRoa.events.on("ready", function () {
 chartRoa.fontSize="10px";
 chartRoa.exporting.menu = new am4core.ExportMenu();
 chartRoa.exporting.menu.align = "right";
 chartRoa.exporting.menu.verticalAlign = "top";
 chartRoa.exporting.filePrefix = "Kadabra Roa Status Report"; 
});

$("#selectRC").on('change',function(){
  chartData = [];
  var value = $(this).val();

  $.each(dataResult, function(i, chartItem) {
    if(chartItem.rc == value){
      chartData.push({
       date:chartItem.date,
       valid:chartItem.valid,
       invalid:chartItem.invalid,
       unknown:chartItem.unknown
     });
    }
  });

  chartRoa.data = chartData;
});

}

$(document).ready(function(){
  showChartRoa('7d');

  $('#start-dr-roa .input-group.date').datepicker({
    format: 'dd/mm/yyyy',
    todayBtn: 'linked',
    todayHighlight: true,
    autoclose: true,        
  });

  $('#end-dr-roa .input-group.date').datepicker({
    format: 'dd/mm/yyyy',
    todayBtn: 'linked',
    todayHighlight: true,
    autoclose: true,        
  });
}); 

function setGraphRoa(req){
  showChartRoa(req);
}