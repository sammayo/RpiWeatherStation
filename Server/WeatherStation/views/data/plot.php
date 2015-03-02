<?php
//use Yii;
?>

<script>
<?php
$dist = realpath(Yii::$app->basePath . "/views/data/dist");
echo "var dist = " . $dist;
?>
</script>

<!--[if lt IE 9]><script language="javascript" type="text/javascript" src=<?php echo realpath($dist . "/excanvas.js"); ?>></script><![endif]-->
<script language="javascript" type="text/javascript" src=<?php echo realpath($dist . "/jquery.min.js"); ?>></script>
<script language="javascript" type="text/javascript" src=<?php echo realpath($dist . "/jquery.jqplot.min.js"); ?>></script>
<link rel="stylesheet" type="text/css" href=<?php echo realpath($dist . "/jquery.jqplot.css"); ?> />

<div id="plotDiv" style="height:400px;width:300px;"></div>

<script>
<?php
$js_array = json_encode($pointsArray);
echo "var pointsArray = " . $js_array . ";";
//var_dump($js_array);
?>
</script>

<script>
$(document).ready(function(){
    $.jqplot("plotDiv", pointsArray, { title: 'Temperature and Humidity' });
});
</script>
