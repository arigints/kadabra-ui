function showChartRoa(reqData){
  am4core.useTheme(am4themes_animated);

    // Create chart instance
    var chartRoa = am4core.create("chartRoa", am4charts.XYChart);
    generateChartData(reqData);
    // Create axes
    var dateAxis = chartRoa.xAxes.push(new am4charts.DateAxis());
    dateAxis.renderer.grid.template.location = 0;

    var valueAxis = chartRoa.yAxes.push(new am4charts.ValueAxis());

    // Create series
    function createSeries(field, name) {
      var series = chartRoa.series.push(new am4charts.LineSeries());
      series.dataFields.valueY = field;
      series.dataFields.dateX = "date";
      series.name = name;
      series.tooltipText = "{name}: [b]{valueY}[/]";
      series.strokeWidth = 2;
      
      var bullet = series.bullets.push(new am4charts.CircleBullet());
      bullet.circle.stroke = am4core.color("#fff");
      bullet.circle.strokeWidth = 2;
      
      return series;
    }

    var series1 = createSeries("valid", "Valid");
    var series2 = createSeries("invalid", "Invalid");
    var series3 = createSeries("unknown", "Unknown");

    chartRoa.legend = new am4charts.Legend();
    chartRoa.cursor = new am4charts.XYCursor();

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


  var chartData = [];
  let mapTRoa = new Map();
  let mapNmRC = new Map();
  let dataResult = [];

  function generateChartData(reqData) {
    chartData = [];
    mapTRoa = new Map();
    mapNmRC = new Map();
    dataResult = [];

    var url = "";
    if (reqData == "7d"){
      url = APP_URL+"/get/roa/7d";
      $(".title-roa-graph").html("Graph Roa Status Last 7 Day");
    }else if(reqData == "30d"){
      url = APP_URL+"/get/roa/30d";
      $(".title-roa-graph").html("Graph Roa Status Last 30 Day");
    }else if(reqData == "range"){
      var startDate = $("#startDateRoa").val();
      var endDate = $("#endDateRoa").val();
      var startReverse = startDate.split("/").reverse().join("-");
      var endReverse = endDate.split("/").reverse().join("-");
      url = APP_URL+"/get/roa/"+startReverse+"/"+endReverse;

      $(".title-roa-graph").html("Graph Roa Status From "+startDate+" to "+endDate);
    }

    $(".title-roa-graph").append('<br/> <select class="form-control" id="selectRC"><option>-- Select RC --</option></select>');

    var LIST_RC = [];
    $.ajax({
      type:"GET",
      url: API_URL+"/route-collector/list-data",
      dataType: "JSON",
      success: function(data){
        $.each(data, function(k, it) {
          LIST_RC.push({
            "name": it.name,
            "alias" : it.alias
          });
        });
      }
    });
    
    $.ajax({
      type:"GET",
      url: url,
      cache:false,
      dataType: "JSON",
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
             $.each(LIST_RC, function(k, item) {
              if(item.name == roaItem.rc){
                $("#selectRC").append("<option value='"+roaItem.rc+"'>"+item.alias+" ("+roaItem.rc+")</option>");
              }
            });
           }
         });
        });

        chartRoa.data = chartData;
      }
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
