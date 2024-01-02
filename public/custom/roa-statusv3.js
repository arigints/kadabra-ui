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

function generateChartData() {
  var chartData = [];
  var url = APP_URL+"/get/roa/1d";

  $.ajax({type:"GET",url: url,header:{"Content-Type" : "application/json; charset=UTF-8"},cache:false,
    success: function(result){
     $.each(result, function(i, item) {
      $.each(item.roa_stats, function(i, roaItem) {
         $.each(LIST_RC, function(k, item) {
          if(item.name == roaItem.rc){
           chartData.push({
            name:item.alias+" ("+roaItem.rc+")",
            children:[{
              name:'Valid',value:roaItem.stats.valid
            },
            {
              name:'Invalid',value:roaItem.stats.invalid
            },
            {
              name:'Unknown',value:roaItem.stats.unknown
            },
            ]
          });
         }
       });
      });
    });

    networkSeries.data = chartData;
   }
 })
}

}); // end am4core.ready()