<?php
//use Yii;
?>
<div id="tempPlotDiv" style="height:400px;width:1000px;"></div>
<div id="humidityPlotDiv" style="height:400px;width:1000px;"></div>
<div id="pressurePlotDiv" style="height:400px;width:1000px;"></div>

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
                        interval: '1 month'
                    }
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
                }
            }
        );
    });
</script>
