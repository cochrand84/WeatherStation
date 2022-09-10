<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
// lets refresh the page every 5 minutes, so you can see the new data
$url1=$_SERVER['REQUEST_URI'];
header("Refresh: 300; URL=$url1");
?>

<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Current Weather</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script src="../amcharts/amcharts.js" type="text/javascript"></script>
        <script src="../amcharts/serial.js" type="text/javascript"></script>
<script>
AmCharts.loadJSON = function(url) {
  // create the request for the json, our data comes in from other php scripts using json
  if (window.XMLHttpRequest) {
    // IE7+, Firefox, Chrome, Opera, Safari
    var request = new XMLHttpRequest();
  } else {
    // code for IE6, IE5 (just in case)
    var request = new ActiveXObject('Microsoft.XMLHTTP');
  }

  // load it
  // the last "false" parameter ensures that our code will wait before the
  // data is loaded
  request.open('GET', url, false);
  request.send();

  // parse and return the output
  return eval(request.responseText);
};
  </script>
        <script>
            var chart;
            var graph;

            // here we are going to load the php file that has our json data
            var chartData3 = AmCharts.loadJSON('outside_temp_data.php');


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.marginTop = 0;
                chart.marginRight = 0;
                chart.dataProvider = chartData3;
                chart.categoryField = "outside_dateandtime";
                chart.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chart.balloon.cornerRadius = 6;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "5mm"; // our data is yearly, so we set minPeriod to YYYY
                categoryAxis.dashLength = 1;
                categoryAxis.minorGridEnabled = true;
                categoryAxis.axisColor = "#DADADA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                valueAxis.inside = true;
                chart.addValueAxis(valueAxis);
				valueAxis.title = "Outside Temperature";
								
				// GRAPH
                graph = new AmCharts.AmGraph();
				graph.type = "smoothedLine";
                graph.lineColor = "#3333ff";
                graph.negativeLineColor = "#ff0000"; // this line makes the graph to change color when it drops below 0
                graph.bullet = "round";
                graph.bulletSize = 8;
                graph.bulletBorderColor = "#FFFFFF";
				graph.useNegativeColorIfDown = true;
					
                graph.bulletBorderThickness = 2;
                graph.bulletBorderAlpha = 1;
                graph.connect = false; // this makes the graph not to connect data points if data is missing
                graph.lineThickness = 2;
                graph.valueField = "outside_temp";
                graph.balloonText = "[[category]]<br><b><span style='font-size:14px;'>[[outside_temp]] &deg;F</span></b>";
                chart.addGraph(graph);
												
                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.cursorPosition = "mouse";
                chartCursor.categoryBalloonDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chartCursor.graphBulletSize = 2;
                chart.addChartCursor(chartCursor);

                // SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
                chartScrollbar.graph = graph;
                chartScrollbar.scrollbarHeight = 30;
                chart.addChartScrollbar(chartScrollbar);
				
				chart.creditsPosition = "bottom-right";

                // WRITE
                chart.write("chartdiv");
            });
        </script>
		<script>
            var chart;
            var graph;
			// here we are going to load the php file that has our json data
            var chartData = AmCharts.loadJSON('outside_temp_data.php');


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.marginTop = 0;
                chart.marginRight = 0;
                chart.dataProvider = chartData;
                chart.categoryField = "outside_dateandtime";
                chart.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chart.balloon.cornerRadius = 6;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "5mm"; // our data is yearly, so we set minPeriod to YYYY
                categoryAxis.dashLength = 1;
                categoryAxis.minorGridEnabled = true;
                categoryAxis.axisColor = "#DADADA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                valueAxis.inside = true;
                chart.addValueAxis(valueAxis);
				valueAxis.title = "Outside Humidity";

                // GRAPH
                graph = new AmCharts.AmGraph();
				graph.useNegativeColorIfDown = true;
				graph.type = "smoothedLine";
                graph.lineColor = "#3366ff";
                graph.negativeLineColor = "#ffff99"; // this line makes the graph to change color when it drops below 0
				graph.negativeFillColor = "#ffff99";
                graph.bullet = "round";
                graph.bulletSize = 8;
                graph.bulletBorderColor = "#FFFFFF";
				graph.fillAlphas = 0.6;
				

                graph.bulletBorderThickness = 2;
                graph.bulletBorderAlpha = 1;
                graph.connect = false; // this makes the graph not to connect data points if data is missing
                graph.lineThickness = 2;
                graph.valueField = "outside_humidity";
                graph.balloonText = "[[category]]<br><b><span style='font-size:14px;'>[[outside_humidity]] &#37;</span></b>";
                chart.addGraph(graph);
												
                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.cursorPosition = "mouse";
                chartCursor.categoryBalloonDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chartCursor.graphBulletSize = 2;
                chart.addChartCursor(chartCursor);
				
				// SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
                chartScrollbar.graph = graph;
                chartScrollbar.scrollbarHeight = 30;
                chart.addChartScrollbar(chartScrollbar);

                chart.creditsPosition = "bottom-right";

                // WRITE
                chart.write("chartdiv2");
            });
        </script>
		<script>
            var chart;
            var graph;
			// here we are going to load the php file that has our json data
            var chartData2 = AmCharts.loadJSON('inside_temp_data.php');


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.marginTop = 0;
                chart.marginRight = 0;
                chart.dataProvider = chartData2;
                chart.categoryField = "inside_dateandtime";
                chart.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chart.balloon.cornerRadius = 6;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "5mm"; // our data is every 5 mins, so we set minPeriod to 5mm
                categoryAxis.dashLength = 1;
                categoryAxis.minorGridEnabled = true;
                categoryAxis.axisColor = "#DADADA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                valueAxis.inside = true;
                chart.addValueAxis(valueAxis);
				valueAxis.title = "Inside Temperature";

               // GRAPH
                graph = new AmCharts.AmGraph();
				graph.type = "smoothedLine";
                graph.lineColor = "#3333ff";
                graph.negativeLineColor = "#ff0000"; // this line makes the graph to change color when it drops below 0
                graph.bullet = "round";
                graph.bulletSize = 8;
                graph.bulletBorderColor = "#FFFFFF";
				graph.useNegativeColorIfDown = true;
					
                graph.bulletBorderThickness = 2;
                graph.bulletBorderAlpha = 1;
                graph.connect = false; // this makes the graph not to connect data points if data is missing
                graph.lineThickness = 2;
                graph.valueField = "inside_temp";
                graph.balloonText = "[[category]]<br><b><span style='font-size:14px;'>[[inside_temp]] &deg;F</span></b>";
                chart.addGraph(graph);
												
                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.cursorPosition = "mouse";
                chartCursor.categoryBalloonDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chartCursor.graphBulletSize = 2;
                chart.addChartCursor(chartCursor);
				
				// SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
                chartScrollbar.graph = graph;
                chartScrollbar.scrollbarHeight = 30;
                chart.addChartScrollbar(chartScrollbar);
				
				chart.creditsPosition = "bottom-right";

                // WRITE
                chart.write("chartdiv3");
            });
        </script>
		<script>
            var chart;
            var graph;
			// here we are going to load the php file that has our json data
            var chartData2 = AmCharts.loadJSON('inside_temp_data.php');


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.marginTop = 0;
                chart.marginRight = 0;
                chart.dataProvider = chartData2;
                chart.categoryField = "inside_dateandtime";
                chart.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chart.balloon.cornerRadius = 6;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "5mm"; // our data is every 5 mins, so we set minPeriod to 5mm
                categoryAxis.dashLength = 1;
                categoryAxis.minorGridEnabled = true;
                categoryAxis.axisColor = "#DADADA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                valueAxis.inside = true;
                chart.addValueAxis(valueAxis);
				valueAxis.title = "Barometric Pressure";

                // GRAPH
                graph = new AmCharts.AmGraph();
				graph.useNegativeColorIfDown = true;
				graph.type = "column";
                graph.lineColor = "#3366ff";
                graph.negativeLineColor = "#ffff99"; // this line makes the graph to change color when it drops below 0
				graph.negativeFillColor = "#ffff99";
                graph.bullet = "round";
                graph.bulletSize = 8;
                graph.bulletBorderColor = "#FFFFFF";
				graph.fillAlphas = 0.6;
				

                graph.bulletBorderThickness = 2;
                graph.bulletBorderAlpha = 1;
                graph.connect = false; // this makes the graph not to connect data points if data is missing
                graph.lineThickness = 2;
                graph.valueField = "inside_pressure";
                graph.balloonText = "[[category]]<br><b><span style='font-size:14px;'>[[inside_pressure]] inHg</span></b>";
                chart.addGraph(graph);
												
                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.cursorPosition = "mouse";
                chartCursor.categoryBalloonDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chartCursor.graphBulletSize = 2;
                chart.addChartCursor(chartCursor);
				
				// SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
                chartScrollbar.graph = graph;
                chartScrollbar.scrollbarHeight = 30;
                chart.addChartScrollbar(chartScrollbar);
				
				chart.creditsPosition = "bottom-right";

                // WRITE
                chart.write("chartdiv4");
            });
        </script>
		<script>
            var chart;
            var graph;
            // here we are going to load the php file that has our json data
            var chartData3 = AmCharts.loadJSON('outside_temp_data.php');


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.marginTop = 0;
                chart.marginRight = 0;
                chart.dataProvider = chartData3;
                chart.categoryField = "outside_dateandtime";
                chart.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chart.balloon.cornerRadius = 6;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "5mm"; // our data is yearly, so we set minPeriod to YYYY
                categoryAxis.dashLength = 1;
                categoryAxis.minorGridEnabled = true;
                categoryAxis.axisColor = "#DADADA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                valueAxis.inside = true;
                chart.addValueAxis(valueAxis);
				valueAxis.title = "Outside Dewpoint";
								
				// GRAPH
                graph = new AmCharts.AmGraph();
				graph.type = "smoothedLine";
                graph.lineColor = "#3333ff";
                graph.negativeLineColor = "#ff0000"; // this line makes the graph to change color when it drops below 0
                graph.bullet = "round";
                graph.bulletSize = 8;
                graph.bulletBorderColor = "#FFFFFF";
				graph.useNegativeColorIfDown = true;
					
                graph.bulletBorderThickness = 2;
                graph.bulletBorderAlpha = 1;
                graph.connect = false; // this makes the graph not to connect data points if data is missing
                graph.lineThickness = 2;
                graph.valueField = "outside_dewpoint";
                graph.balloonText = "[[category]]<br><b><span style='font-size:14px;'>[[outside_dewpoint]] &deg;F</span></b>";
                chart.addGraph(graph);
												
                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.cursorPosition = "mouse";
                chartCursor.categoryBalloonDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chartCursor.graphBulletSize = 2;
                chart.addChartCursor(chartCursor);

                // SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
                chartScrollbar.graph = graph;
                chartScrollbar.scrollbarHeight = 30;
                chart.addChartScrollbar(chartScrollbar);
				
				chart.creditsPosition = "bottom-right";

                // WRITE
                chart.write("chartdiv5");
            });
        </script>
		<script>
            var chart;
            var graph;
			// here we are going to load the php file that has our json data
            var chartData4 = AmCharts.loadJSON('rain_data.php');


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.marginTop = 0;
                chart.marginRight = 0;
                chart.dataProvider = chartData4;
                chart.categoryField = "rain_dateandtime";
                chart.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chart.balloon.cornerRadius = 6;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "30ss"; // our data is every 5 mins, so we set minPeriod to 5mm
                categoryAxis.dashLength = 1;
                categoryAxis.minorGridEnabled = true;
                categoryAxis.axisColor = "#DADADA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                valueAxis.inside = true;
                chart.addValueAxis(valueAxis);
				valueAxis.title = "Rain";

                // GRAPH
                graph = new AmCharts.AmGraph();
				graph.useNegativeColorIfDown = true;
				graph.type = "column";
                graph.lineColor = "#3366ff";
                graph.negativeLineColor = "#ffff99"; // this line makes the graph to change color when it drops below 0
				graph.negativeFillColor = "#ffff99";
                graph.bullet = "round";
                graph.bulletSize = 8;
                graph.bulletBorderColor = "#FFFFFF";
				graph.fillAlphas = 0.6;
				

                graph.bulletBorderThickness = 2;
                graph.bulletBorderAlpha = 1;
                graph.connect = false; // this makes the graph not to connect data points if data is missing
                graph.lineThickness = 2;
                graph.valueField = "rain_metered";
                graph.balloonText = "[[category]]<br><b><span style='font-size:14px;'>[[rain_metered]] inches</span></b>";
                chart.addGraph(graph);
												
                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.cursorPosition = "mouse";
                chartCursor.categoryBalloonDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chartCursor.graphBulletSize = 2;
                chart.addChartCursor(chartCursor);
				
				// SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
                chartScrollbar.graph = graph;
                chartScrollbar.scrollbarHeight = 30;
                chart.addChartScrollbar(chartScrollbar);
				
				chart.creditsPosition = "bottom-right";

                // WRITE
                chart.write("chartdiv6");
            });
        </script>
        <script>
            var chart;
            var graph;
            // here we are going to load the php file that has our json data
            var chartData5 = AmCharts.loadJSON('wind_speed_data.php');


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.marginTop = 0;
                chart.marginRight = 0;
                chart.dataProvider = chartData5;
                chart.categoryField = "wind_speed_dateandtime";
                chart.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chart.balloon.cornerRadius = 6;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
                categoryAxis.minPeriod = "15ss"; // our data is yearly, so we set minPeriod to YYYY
                categoryAxis.dashLength = 1;
                categoryAxis.minorGridEnabled = true;
                categoryAxis.axisColor = "#DADADA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                valueAxis.inside = true;
                chart.addValueAxis(valueAxis);
                valueAxis.title = "Wind Speed";

                // GRAPH
                graph = new AmCharts.AmGraph();
                graph.useNegativeColorIfDown = true;
                graph.type = "smoothedLine";
                graph.lineColor = "#3366ff";
                graph.negativeLineColor = "#ffff99"; // this line makes the graph to change color when it drops below 0
                graph.negativeFillColor = "#ffff99";
                graph.bullet = "round";
                graph.bulletSize = 8;
                graph.bulletBorderColor = "#FFFFFF";
                graph.fillAlphas = 0.6;
                

                graph.bulletBorderThickness = 2;
                graph.bulletBorderAlpha = 1;
                graph.connect = false; // this makes the graph not to connect data points if data is missing
                graph.lineThickness = 2;
                graph.valueField = "wind_speed";
                graph.balloonText = "[[category]]<br><b><span style='font-size:14px;'>[[wind_speed]] mPh</span></b>";
                chart.addGraph(graph);
                                                
                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.cursorPosition = "mouse";
                chartCursor.categoryBalloonDateFormat = "YYYY-MM-DD JJ:NN:SS";
                chartCursor.graphBulletSize = 2;
                chart.addChartCursor(chartCursor);
                
                // SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
                chartScrollbar.graph = graph;
                chartScrollbar.scrollbarHeight = 30;
                chart.addChartScrollbar(chartScrollbar);

                chart.creditsPosition = "bottom-right";

                // WRITE
                chart.write("chartdiv7");
            });
        </script>

    </head>

    <body>
	
	<div id="currentdata"><?php 
	include 'currentdata.php';
	
	?> 

    <center>for all data <a href="showall.php">click here</a></center></div>
<table border="0" style="width:100%">

  <thead>
  <tr>
    <th style="width:50%;"></th>
    <th style="width:50%;"></th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>
        <div id="chartdiv3" style="width:100%; height:300px;"></div>
    </td>
    <td>
        <div id="chartdiv4" style="width:100%; height:300px;"></div>
    </td>
  </tr>
  <tr>
    <td>
        <div id="chartdiv" style="width:100%; height:300px;"></div>
    </td>
    <td>
        <div id="chartdiv2" style="width:100%; height:300px;"></div>
    </td>
  </tr>
  <tr>
    <td>
        <div id="chartdiv6" style="width:100%; height:300px;"></div>
    </td>
    <td>
        <div id="chartdiv7" style="width:100%; height:300px;"></div>
    </td>
  </tr>
  <tr>
    <td>
        <div id="chartdiv5" style="width:100%; height:300px;"></div>
    </td>
    <td>
    </td>
  </tr>
  </tbody>  
</table>
    </body>

</html>