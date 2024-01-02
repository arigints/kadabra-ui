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
	if (reqData == "7d"){
		url = APP_URL+"/get/prefix/7d";
		$(".title-rs-graph").html("Graph New Prefix Last 7 Day");
	}else if(reqData == "30d"){
		url = APP_URL+"/get/prefix/30d";
		$(".title-rs-graph").html("Graph New Prefix Last 30 Day");
	}else if(reqData == "range"){
		var startDate = $("#startDateRS").val();
		var endDate = $("#endDateRS").val();
		var startRS = startDate.split("/").reverse().join("-");
		var endRS = endDate.split("/").reverse().join("-");
		url = APP_URL+"/get/prefix/"+startRS+"/"+endRS;

		$(".title-rs-graph").html("Graph New Prefix From "+startDate+" to "+endDate);
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

function showChartASN(reqData) {
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
		bullet.label.fontSize = "20px";
		bullet.label.fill = am4core.color('#ffffff')

		return series;
	}

	var url = "";
	if (reqData == "7d"){
		url = APP_URL+"/get/as/7d";
		$(".title-rs-graph").html("Graph New AS Number Last 7 Day");
	}else if(reqData == "30d"){
		url = APP_URL+"/get/as/30d";
		$(".title-rs-graph").html("Graph New AS Number Last 30 Day");
	}else if(reqData == "range"){
		var startDate = $("#startDateRS").val();
		var endDate = $("#endDateRS").val();
		var startRS = startDate.split("/").reverse().join("-");
		var endRS = endDate.split("/").reverse().join("-");
		url = APP_URL+"/get/as/"+startRS+"/"+endRS;

		$(".title-rs-graph").html("Graph New AS Number From "+startDate+" to "+endDate);
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


	createSeries('new_as', 'New AS Number');

	chart.events.on("ready", function () {
		chart.fontSize="10px";
		chart.exporting.menu = new am4core.ExportMenu();
		chart.exporting.menu.align = "right";
		chart.exporting.menu.verticalAlign = "top";
		chart.exporting.filePrefix = "Kadabra New AS Number Report"; 
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

$(document).ready(function(){
	$("#customRadio1").prop("checked",true);
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

function setGraphRS(req){
	var data = $("[name='newRegistrantRadio']:checked").val();
	var dataSM = $("[name='summaryRadio']:checked").val();
	if(data == "prefix"){
		showChartPrefix(req);
	}else{
		showChartASN(req);
	}

	if(dataSM == "prefix"){
		showChartSMPrefix(req);
	}else{
		showChartSMASN(req);
	}
}

$("[name='newRegistrantRadio']").on("change",function(){
	var val = $(this).val();
	if(val == "prefix"){
		showChartPrefix("7d");
	}else{
		showChartASN("7d");
	}
});
