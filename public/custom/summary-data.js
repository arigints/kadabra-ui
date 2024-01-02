function showChartSMASN(reqData){
    am4core.useTheme(am4themes_animated);

  // Create chart instance
  var chart = am4core.create("chartSummary", am4charts.XYChart);

  // Create axes
  var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
  dateAxis.renderer.grid.template.location = 0;
  dateAxis.renderer.minGridDistance = 50;
  dateAxis.renderer.labels.template.location = 0.0001;

  var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

  // Create series
  function createSeries(field, name) {
    var series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.valueY = field;
    series.dataFields.dateX = "date";
    series.name = name;
    series.tooltipText = "{dateX}: [b]{valueY}[/]";
    series.strokeWidth = 2;
    
    var bullet = series.bullets.push(new am4charts.CircleBullet());
    bullet.circle.stroke = am4core.color("#fff");
    bullet.circle.strokeWidth = 2;
  }

  createSeries("asn", "AS Number");

  chart.legend = new am4charts.Legend();
  chart.cursor = new am4charts.XYCursor();

  chart.events.on("ready", function () {
    chart.fontSize="10px";
    chart.exporting.menu = new am4core.ExportMenu();
    chart.exporting.menu.align = "right";
    chart.exporting.menu.verticalAlign = "top";
    chart.exporting.filePrefix = "Kadabra Summary Prefix Report"; 
  });

  var chartData = [];
  var firstDate = new Date();

  var url = "";
  if (reqData == "7d"){
    url = APP_URL+"/get/as-summary/7d";
    $(".title-rs-graph").html("Graph Summary AS Number Last 7 Day");
  }else if(reqData == "30d"){
    url = APP_URL+"/get/as-summary/30d";
    $(".title-rs-graph").html("Graph Summary AS Number Last 30 Day");
  }else if(reqData == "range"){
    var startDate = $("#startDateRS").val();
    var endDate = $("#endDateRS").val();
    var startRS = startDate.split("/").reverse().join("-");
    var endRS = endDate.split("/").reverse().join("-");
    url = APP_URL+"/get/as-summary-date/"+startRS+"/"+endRS;

    $(".title-rs-graph").html("Graph Summary AS Number From "+startDate+" to "+endDate);
  }

  $.ajax({
    type:"GET",
    url: url,
    header:{"Content-Type" : "application/json; charset=UTF-8"},
    cache:false,
    success: function(result){
      $.each(result, function(k, item) {
        var newDate = new Date(item.date);
        chartData.push({
          date: newDate,
          asn: item.new_as,
        });
      });

      chart.data = chartData;
    }
  });
}

function showChartSMPrefix(reqData){
  am4core.useTheme(am4themes_animated);

  // Create chart instance
  var chart = am4core.create("chartSummary", am4charts.XYChart);

  // Create axes
  var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
  dateAxis.renderer.grid.template.location = 0;
  dateAxis.renderer.minGridDistance = 50;
  dateAxis.renderer.labels.template.location = 0.0001;

  var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

  // Create series
  function createSeries(field, name) {
    var series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.valueY = field;
    series.dataFields.dateX = "date";
    series.name = name;
    series.tooltipText = "{dateX}: [b]{valueY}[/]";
    series.strokeWidth = 2;
    
    var bullet = series.bullets.push(new am4charts.CircleBullet());
    bullet.circle.stroke = am4core.color("#fff");
    bullet.circle.strokeWidth = 2;
  }

  createSeries("ipv4", "Ipv4");
  createSeries("ipv6", "Ipv6");

  chart.legend = new am4charts.Legend();
  chart.cursor = new am4charts.XYCursor();

  chart.events.on("ready", function () {
    chart.fontSize="10px";
    chart.exporting.menu = new am4core.ExportMenu();
    chart.exporting.menu.align = "right";
    chart.exporting.menu.verticalAlign = "top";
    chart.exporting.filePrefix = "Kadabra Summary Prefix Report"; 
  });

  var chartData = [];
  var firstDate = new Date();

  var url = "";
  if (reqData == "7d"){
    url = APP_URL+"/get/prefix-summary/7d";
    $(".title-rs-graph").html("Graph Summary Prefix Last 7 Day");
  }else if(reqData == "30d"){
    url = APP_URL+"/get/prefix-summary/30d";
    $(".title-rs-graph").html("Graph Summary Prefix Last 30 Day");
  }else if(reqData == "range"){
    var startDate = $("#startDateRS").val();
    var endDate = $("#endDateRS").val();
    var startRS = startDate.split("/").reverse().join("-");
    var endRS = endDate.split("/").reverse().join("-");
    url = APP_URL+"/get/prefix-summary-date/"+startRS+"/"+endRS;

    $(".title-rs-graph").html("Graph Summary Prefix From "+startDate+" to "+endDate);
  }

  $.ajax({
    type:"GET",
    url: url,
    header:{"Content-Type" : "application/json; charset=UTF-8"},
    cache:false,
    success: function(result){
      $.each(result, function(k, item) {
        var newDate = new Date(item.date);

        chartData.push({
          date: newDate,
          ipv4: item.new_ip_v4,
          ipv6: item.new_ip_v6
        });
      });

      chart.data = chartData;
    }
  });
}

$(document).ready(function(){
  $("#customRadio3").prop("checked",true);
  showChartSMPrefix('7d');

  $('#start-dr-rs .input-group.date').datepicker({
    format: 'dd/mm/yyyy',
    todayBtn: 'linked',
    todayHighlight: true,
    autoclose: true,        
  });

  $('#end-dr-rs .input-group.date').datepicker({
    format: 'dd/mm/yyyy',
    todayBtn: 'linked',
    todayHighlight: true,
    autoclose: true,        
  });
});

$("[name='summaryRadio']").on("change",function(){
  var val = $(this).val();
  if(val == "prefix"){
    showChartSMPrefix("7d");
  }else{
    showChartSMASN("7d");
  }
});