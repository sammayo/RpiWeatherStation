<?php
//use Yii;
?>
<div id="plotDiv" style="height:400px;width:300px;"></div>

<script type="text/javascript">
    var humidityData = <?php echo $humidity_data; ?>;
    var temperatureData = <?php echo $temperature_data; ?>;
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var plot = $.jqplot(
            "plotDiv", 
            [humidityData, temperatureData], 
            { title: 'Temperature and Humidity' }
        );
    });
</script>
