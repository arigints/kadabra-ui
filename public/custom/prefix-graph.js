  // ******* START DEFINE DATA ******* 
  var currentRange = "7d";

  $(document).ready(function() {
    $("#customRadioPrefix1").prop("checked",true);
    createChartPrefix(currentRange);

    $('#start-dr-prefix .input-group.date').datepicker({
      format: 'dd/mm/yyyy',
      todayBtn: 'linked',
      todayHighlight: true,
      autoclose: true,        
    });

    $('#end-dr-prefix .input-group.date').datepicker({
      format: 'dd/mm/yyyy',
      todayBtn: 'linked',
      todayHighlight: true,
      autoclose: true,        
    });
  });

  function setChartPrefix(range){
    currentRange = range;
    createChartPrefix(range);
  }

  $("[name='typeResultPrefix']").on("click", function(){
    createChartPrefix(currentRange);
  });

  $("#prefixOption").on("change", function(val){
    createChartPrefix(currentRange);
  });

  function createChartPrefix(rangeData) {
    $("#chartPrefix").remove();
    $(".div-prefix").append('<div id="chartPrefix"></div>');
    var type_result = $("[name='typeResultPrefix']:checked").val(); // new_registrant,summary
    var labelPrefix = $("#prefixOption option:selected").val(); // ipv4,ipv6,all

    var root = am5.Root.new("chartPrefix");
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
      am5themes_Animated.new(root)
    ]);


    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
      panX: true,
      panY: false,
      wheelX: "panX",
      wheelY: "zoomX",
      layout: root.verticalLayout
    }));

    chart.get("colors").set("step", 2);


    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    // when axes are in opposite side, they should be added in reverse order
    var volumeAxisRenderer = am5xy.AxisRendererY.new(root, {
      opposite: true
    });
    volumeAxisRenderer.labels.template.setAll({
      centerY: am5.percent(100),
      maxPosition: 0.98
    });
    var volumeAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
      renderer: volumeAxisRenderer,
      height: am5.percent(30),
      layer: 5
    }));
    volumeAxis.axisHeader.set("paddingTop", 10);
    volumeAxis.axisHeader.children.push(am5.Label.new(root, {
      text: "Total",
      fontWeight: "bold",
      paddingTop: 5,
      paddingBottom: 5
    }));

    var valueAxisRenderer = am5xy.AxisRendererY.new(root, {
      opposite: true,
      pan: "zoom"
    });
    valueAxisRenderer.labels.template.setAll({
      centerY: am5.percent(100),
      maxPosition: 0.98
    });
    var valueAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
      renderer: valueAxisRenderer,
      height: am5.percent(70),
      maxDeviation: 1
    }));
    valueAxis.axisHeader.children.push(am5.Label.new(root, {
      text: "Value",
      fontWeight: "bold",
      paddingBottom: 5,
      paddingTop: 5
    }));



    var dateAxisRenderer = am5xy.AxisRendererX.new(root, {
      pan: "zoom"
    });
    dateAxisRenderer.labels.template.setAll({
      minPosition: 0.01,
      maxPosition: 0.99
    });
    var dateAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
      groupData: true,
      maxDeviation:0.5,
      baseInterval: {
        timeUnit: "day",
        count: 1
      },
      renderer: dateAxisRenderer
    }));
    dateAxis.set("tooltip", am5.Tooltip.new(root, {}));

    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var valueSeries1;
    var valueSeries2;
    if(type_result == "new_registrant"){
      var IDNICColor = am5.color(0x303f9f);
      valueSeries1 = chart.series.push(am5xy.LineSeries.new(root, {
        name: labelPrefix+" Prefix IDNIC",
        valueYField: "prefix_idnic",
        calculateAggregates: true,
        valueXField: "date",
        xAxis: dateAxis,
        yAxis: valueAxis,
        legendValueText: "{valueY}",
        stroke:IDNICColor,
        fill: IDNICColor,
      }));

      var nonIDNICColor = am5.color(0xef6c00);
      valueSeries2 = chart.series.push(am5xy.LineSeries.new(root, {
        name: labelPrefix+" Prefix Non IDNIC",
        valueYField: "prefix_non_idnic",
        calculateAggregates: true,
        valueXField: "date",
        xAxis: dateAxis,
        yAxis: valueAxis,
        legendValueText: "{valueY}",
        stroke:nonIDNICColor,
        fill: nonIDNICColor,
      }));

      var valueTooltip = valueSeries1.set("tooltip", am5.Tooltip.new(root, {
        getFillFromSprite: false,
        getStrokeFromSprite: true,
        getLabelFillFromSprite: true,
        autoTextColor: false,
        pointerOrientation: "horizontal",
        labelText: "{name}: {valueY}"
      }));
      valueTooltip.get("background").set("fill", root.interfaceColors.get("background"));

      var valueTooltip2 = valueSeries2.set("tooltip", am5.Tooltip.new(root, {
        getFillFromSprite: false,
        getStrokeFromSprite: true,
        getLabelFillFromSprite: true,
        autoTextColor: false,
        pointerOrientation: "horizontal",
        labelText: "{name}: {valueY}"
      }));
      valueTooltip2.get("background").set("fill", root.interfaceColors.get("background"));
    }else{
      var IDNICColor = am5.color(0x303f9f);
      valueSeries1 = chart.series.push(am5xy.LineSeries.new(root, {
        name: labelPrefix+" Prefix IDNIC",
        valueYField: "prefix_idnic",
        calculateAggregates: true,
        valueYShow: "valueYChangeSelectionPercent",
        valueXField: "date",
        xAxis: dateAxis,
        yAxis: valueAxis,
        legendValueText: "{valueY}",
        stroke:IDNICColor,
        fill: IDNICColor,
      }));

      var nonIDNICColor = am5.color(0xef6c00);
      valueSeries2 = chart.series.push(am5xy.LineSeries.new(root, {
        name: labelPrefix+" Prefix Non IDNIC",
        valueYField: "prefix_non_idnic",
        calculateAggregates: true,
        valueYShow: "valueYChangeSelectionPercent",
        valueXField: "date",
        xAxis: dateAxis,
        yAxis: valueAxis,
        legendValueText: "{valueY}",
        stroke:nonIDNICColor,
        fill: nonIDNICColor,
      }));

      var valueTooltip = valueSeries1.set("tooltip", am5.Tooltip.new(root, {
        getFillFromSprite: false,
        getStrokeFromSprite: true,
        getLabelFillFromSprite: true,
        autoTextColor: false,
        pointerOrientation: "horizontal",
        labelText: "{name}: {valueY} {valueYChangePercent.formatNumber('[#00ff00]+#,###.##|[#ff0000]#,###.##|[#999999]0')}%"
      }));
      valueTooltip.get("background").set("fill", root.interfaceColors.get("background"));

      var valueTooltip2 = valueSeries2.set("tooltip", am5.Tooltip.new(root, {
        getFillFromSprite: false,
        getStrokeFromSprite: true,
        getLabelFillFromSprite: true,
        autoTextColor: false,
        pointerOrientation: "horizontal",
        labelText: "{name}: {valueY} {valueYChangePercent.formatNumber('[#00ff00]+#,###.##|[#ff0000]#,###.##|[#999999]0')}%"
      }));
      valueTooltip2.get("background").set("fill", root.interfaceColors.get("background"));
    }

    var totalColor = am5.color(0x880e4f);
    var volumeSeries = chart.series.push(am5xy.ColumnSeries.new(root, {
      name: "Total Prefix",
      fill: totalColor,
      stroke: totalColor,
      valueYField: "total",
      valueXField: "date",
      valueYGrouped: "sum",
      xAxis: dateAxis,
      yAxis: volumeAxis,
      legendValueText: "{valueY}",
      tooltip: am5.Tooltip.new(root, {
        labelText: "{valueY}"
      })
    }));
    volumeSeries.columns.template.setAll({
      strokeWidth: 0.2,
      strokeOpacity: 1,
      stroke: am5.color(0xffffff)
    });


    // Add legend to axis header
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/axis-headers/
    // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
    var valueLegend = valueAxis.axisHeader.children.push(
      am5.Legend.new(root, {
        useDefaultMarker: true
      })
    );
    valueLegend.data.setAll([valueSeries1,valueSeries2]);

    var volumeLegend = volumeAxis.axisHeader.children.push(
      am5.Legend.new(root, {
        useDefaultMarker: true
      })
      );
    volumeLegend.data.setAll([volumeSeries]);


    // Stack axes vertically
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/#Stacked_axes
    chart.rightAxesContainer.set("layout", root.verticalLayout);


    // Add cursor
    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
    chart.set("cursor", am5xy.XYCursor.new(root, {}))


    // Add scrollbar
    // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
    var scrollbar = chart.set("scrollbarX", am5xy.XYChartScrollbar.new(root, {
      orientation: "horizontal",
      height: 50
    }));

    var sbDateAxis = scrollbar.chart.xAxes.push(am5xy.DateAxis.new(root, {
      groupData: true,
      groupIntervals: [{
        timeUnit: "week",
        count: 1
      }],
      baseInterval: {
        timeUnit: "day",
        count: 1
      },
      renderer: am5xy.AxisRendererX.new(root, {})
    }));

    var sbValueAxis = scrollbar.chart.yAxes.push(
      am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
      })
      );

    var sbSeries = scrollbar.chart.series.push(am5xy.LineSeries.new(root, {
      valueYField: "prefix_idnic",
      valueXField: "date",
      xAxis: sbDateAxis,
      yAxis: sbValueAxis
    }));

    sbSeries.fills.template.setAll({
      visible: true,
      fillOpacity: 0.3
    });
    
    // Get and set data on series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/#Setting_data
    var data = [];
    var url = "";
    var source = labelPrefix.toLowerCase(); // ipv4,ipv6,all

    if (rangeData == "7d"){
      if(type_result == "new_registrant"){
        url = APP_URL+"/get/prefix/7d/"+source;
      }else{
        url = APP_URL+"/get/prefix-summary/7d/"+source;
      }
      $(".title-prefix-graph").html("Graph "+labelPrefix.toUpperCase()+" Prefix Last 7 Day");
    }else if(rangeData == "30d"){
      if(type_result == "new_registrant"){
        url = APP_URL+"/get/prefix/30d/"+source;
      }else{
        url = APP_URL+"/get/prefix-summary/30d/"+source;
      }
      $(".title-prefix-graph").html("Graph "+labelPrefix.toUpperCase()+" Prefix Last 30 Day");
    }else if(rangeData == "range"){
      var startDate = $("#startDatePrefix").val();
      var endDate = $("#endDatePrefix").val();
      var startRS = startDate.split("/").reverse().join("-");
      var endRS = endDate.split("/").reverse().join("-");

      if(type_result == "new_registrant"){
        url = APP_URL+"/get/prefix/"+startRS+"/"+endRS+"/"+source;
      }else{
        url = APP_URL+"/get/prefix-summary-date/"+startRS+"/"+endRS+"/"+source;
      }

      $(".title-prefix-graph").html("Graph "+labelPrefix.toUpperCase()+" Prefix From "+startDate+" to "+endDate);
    }else if(rangeData == "all"){
      if(type_result == "new_registrant"){
        url = APP_URL+"/get/prefix/all/"+source;
      }else{
        url = APP_URL+"/get/prefix-summary/all/"+source;
      }
      $(".title-prefix-graph").html("Graph "+labelPrefix.toUpperCase()+" Prefix All Day");
    }

    $.ajax({
      type:"GET",
      url: url,
      header:{"Content-Type" : "application/json; charset=UTF-8"},
      cache:false,
      dataType: "JSON",
      success: function(result){
        // each data to convert string-date to javascript-date

        $.each(result, function(i,val){
          data.push({
            date: new Date(val.date).getTime(),
            prefix_idnic: val.prefix_idnic,
            prefix_non_idnic: val.prefix_non_idnic,
            total: val.total
          });
        });

        valueSeries1.data.setAll(data);
        valueSeries2.data.setAll(data);

        volumeSeries.data.setAll(data);
        sbSeries.data.setAll(data);

        sbSeries = scrollbar.chart.series.push(am5xy.LineSeries.new(root, {
          valueYField: "prefix_idnic",
          valueXField: "date",
          xAxis: sbDateAxis,
          yAxis: sbValueAxis
        }));

        sbSeries.fills.template.setAll({
          visible: true,
          fillOpacity: 0.3
        });

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        chart.appear(1000, 100);
      }
    });
  }