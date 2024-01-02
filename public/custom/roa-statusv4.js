am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartRoaLastDay", am4plugins_forceDirected.ForceDirectedTree);
chart.legend = new am4charts.Legend();
chart.legend.labels.template.text = "{name}: [bold {color}]{value}[/]";

var networkSeries = chart.series.push(new am4plugins_forceDirected.ForceDirectedSeries())
generateChartData();

networkSeries.dataFields.linkWith = "linkWith";
networkSeries.dataFields.name = "name";
networkSeries.dataFields.id = "name";
networkSeries.dataFields.value = "value";
networkSeries.dataFields.children = "children";

networkSeries.nodes.template.tooltipText = "{name} : {value}";
networkSeries.nodes.template.fillOpacity = 1;

networkSeries.nodes.template.label.text = "{value}"
networkSeries.fontSize = 13;
networkSeries.maxLevels = 2;
//networkSeries.maxRadius = am4core.percent(6);
networkSeries.minRadius = 20;
networkSeries.maxRadius = 60;
networkSeries.manyBodyStrength = -16;
networkSeries.nodes.template.label.hideOversized = true;
networkSeries.nodes.template.label.truncate = true;

chart.events.on("ready", function () {
	chart.fontSize="10px";
	chart.exporting.menu = new am4core.ExportMenu();
	chart.exporting.menu.align = "right";
	chart.exporting.menu.verticalAlign = "top";
	chart.exporting.filePrefix = "Kadabra Last ROA Status"; 
});

function connect(){
	socket = new WebSocket(WS_URL+"/ws-roa")
	socket.onopen = () => {
		console.log("Successfully connected")
	}

	socket.onmessage = (msg) => {
		var data = JSON.parse(msg.data)
		var chartData = [];
		$.each(data, function(k, item) {
			chartData.push({
				name:item.alias_name+" ("+item.rc_name+")",
				children:[{
					name:'Valid',value:item.valid
				},
				{
					name:'Invalid',value:item.invalid
				},
				{
					name:'Unknown',value:item.unknown
				},
				]
			});
		});
		
		networkSeries.data = chartData;
	}

	socket.onclose = (event) => {
		console.log("Socket closed connection : ",event)
	}

	socket.onerror = (error) => {
		console.log("Socket Error : ",error)
	}
}

// ****** call function connect *****
connect();

// refresh every 5 minutes
setTimeout(function(){
	socket.close();
	connect();
},300000);

});