<?php
//use Yii;
?>

<p class="page-title">
RpiWeatherStation Data
</p>

<table class="table data-table">
    <tr>
        <th>
            ALTITUDE
        </th>
        <th>
            SEALEVEL PRESSURE
        </th>
    </tr>
    <tr>
        <td>
            <?php echo $altitude_data; ?>
        </td>
        <td>
            <?php echo $sealevel_pressure_data; ?>
        </td>
    </tr>
</table>

<br/><br/>
<div id="tempPlotDiv" class="data-graph"></div>
<br/><br/>
<div id="humidityPlotDiv" class="data-graph"></div>
<br/><br/>
<div id="pressurePlotDiv" class="data-graph"></div>
<br/><br/>

<script type="text/javascript">
    var humidityData = <?php echo $humidity_data; ?>;
    var temperatureData = <?php echo $temperature_data; ?>;
    var pressureData = <?php echo $pressure_data; ?>;
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var tempPlot = $.jqplot(
            "tempPlotDiv", 
            [temperatureData], {
                title: 'Temperature',
                axes:{
                    xaxis:{
                        renderer:$.jqplot.DateAxisRenderer,
                        tickOptions:{formatString:'%b %#d, %y'},
                        interval: '1 month',
                    }
                },
                grid: {
                    background: "rgba(255, 255, 255, 0.85)",
                }
            }
        );
        var humidityPlot = $.jqplot(
            "humidityPlotDiv", 
            [humidityData], {
                title: 'Humidity',
                axes:{
                    xaxis:{
                        renderer:$.jqplot.DateAxisRenderer,
                        tickOptions:{formatString:'%b %#d, %y'},
                        interval: '1 month'
                    }
                },
                grid: {
                    background: "rgba(255, 255, 255, 0.85)",
                }
            }
        );
        var pressurePlot = $.jqplot(
            "pressurePlotDiv", 
            [pressureData], {
                title: 'Pressure',
                axes:{
                    xaxis:{
                        renderer:$.jqplot.DateAxisRenderer,
                        tickOptions:{formatString:'%b %#d, %y'},
                        interval: '1 month'
                    }
                },
                grid: {
                    background: "rgba(255, 255, 255, 0.85)",
                }
            }
        );
    });
</script>
