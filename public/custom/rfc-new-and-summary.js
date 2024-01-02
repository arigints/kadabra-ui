function showChartPrefix(reqData) {
	am4core.useTheme(am4themes_animated);
	var chart = am4core.create('chartNewRegistrant', am4charts.XYChart)
	chart.colors.step = 2;

	chart.legend = new am4charts.Legend()
	chart.legend.position = 'top'
	chart.legend.paddingBottom = 20
	chart.legend.labels.template.maxWidth = 95

	var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
	xAxis.dataFields.category = 'date'
	xAxis.renderer.cellStartLocation = 0.1
	xAxis.renderer.cellEndLocation = 0.9
	xAxis.renderer.grid.template.location = 0;

	var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
	yAxis.min = 0;

	function createSeries(value, name) {
		var series = chart.series.push(new am4charts.ColumnSeries())
		series.dataFields.valueY = value
		series.dataFields.categoryX = 'date'
		series.name = name
		series.columns.template.tooltipText = name+"({categoryX}) : [bold]{valueY}[/]";

		series.events.on("hidden", arrangeColumns);
		series.events.on("shown", arrangeColumns);

		var bullet = series.bullets.push(new am4charts.LabelBullet())
		bullet.interactionsEnabled = false
		bullet.dy = 30;
		bullet.label.text = '{valueY}'
		bullet.label.fill = am4core.color('#ffffff')

		return series;
	}

	var url = "";
	if (reqData == "1d"){
		url = APP_URL+"/get/prefix-rfc/1d";
		$(".title-rs-graph").html("Graph New Prefix RFC Today");
	}else if (reqData == "7d"){
		url = APP_URL+"/get/prefix-rfc/7d";
		$(".title-rs-graph").html("Graph New Prefix RFC Last 7 Day");
	}else if(reqData == "30d"){
		url = APP_URL+"/get/prefix-rfc/30d";
		$(".title-rs-graph").html("Graph New Prefix RFC Last 30 Day");
	}else if(reqData == "range"){
		var startDate = $("#startDateRS").val();
		var endDate = $("#endDateRS").val();
		var startRS = startDate.split("/").reverse().join("-");
		var endRS = endDate.split("/").reverse().join("-");
		url = APP_URL+"/get/prefix-rfc/"+startRS+"/"+endRS;

		$(".title-rs-graph").html("Graph New Prefix RFC From "+startDate+" to "+endDate);
	}

	$.ajax({
		type:"GET",
		url: url,
		header:{"Content-Type" : "application/json; charset=UTF-8"},
		cache:false,
		success: function(result){
			chart.data = result;
		}
	});


	createSeries('new_ip_v4', 'New IPv4');
	createSeries('new_ip_v6', 'New IPv6');

	chart.events.on("ready", function () {
		chart.fontSize="10px";
		chart.exporting.menu = new am4core.ExportMenu();
		chart.exporting.menu.align = "right";
		chart.exporting.menu.verticalAlign = "top";
		chart.exporting.filePrefix = "Kadabra New Prefix Report"; 
	});

	function arrangeColumns() {

		var series = chart.series.getIndex(0);

		var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
		if (series.dataItems.length > 1) {
			var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
			var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
			var delta = ((x1 - x0) / chart.series.length) * w;
			if (am4core.isNumber(delta)) {
				var middle = chart.series.length / 2;

				var newIndex = 0;
				chart.series.each(function(series) {
					if (!series.isHidden && !series.isHiding) {
						series.dummyData = newIndex;
						newIndex++;
					}
					else {
						series.dummyData = chart.series.indexOf(series);
					}
				})
				var visibleCount = newIndex;
				var newMiddle = visibleCount / 2;

				chart.series.each(function(series) {
					var trueIndex = chart.series.indexOf(series);
					var newIndex = series.dummyData;

					var dx = (newIndex - trueIndex + middle - newMiddle) * delta

					series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
					series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
				})
			}
		}
	}
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
    chart.exporting.filePrefix = "Kadabra Summary Prefix RFC Report"; 
  });

  var chartData = [];
  var firstDate = new Date();

  var url = "";
  if(reqData == "1d"){
    url = APP_URL+"/get/prefix-rfc-summary/1d";
    $(".title-rs-graph").html("Graph Summary Prefix RFC Today");
  }else if(reqData == "7d"){
    url = APP_URL+"/get/prefix-rfc-summary/7d";
    $(".title-rs-graph").html("Graph Summary Prefix RFC Last 7 Day");
  }else if(reqData == "30d"){
    url = APP_URL+"/get/prefix-rfc-summary/30d";
    $(".title-rs-graph").html("Graph Summary Prefix RFC Last 30 Day");
  }else if(reqData == "range"){
    var startDate = $("#startDateRS").val();
    var endDate = $("#endDateRS").val();
    var startRS = startDate.split("/").reverse().join("-");
    var endRS = endDate.split("/").reverse().join("-");
    url = APP_URL+"/get/prefix-rfc-summary/"+startRS+"/"+endRS;

    $(".title-rs-graph").html("Graph Summary Prefix RFC From "+startDate+" to "+endDate);
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
	showChartSMPrefix('7d');
	showChartPrefix('7d');

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

function setGraphRFC(req){
	showChartPrefix(req);
	showChartSMPrefix(req);
}


