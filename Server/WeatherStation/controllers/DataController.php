<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class DataController extends Controller
{
    public function actionSave()
    {
	$jsonData = Yii::$app->request->get('data');
	$logPath = realpath(Yii::$app->basePath . '/../dataLog');
	$logFile = fopen($logPath, 'a');
	fwrite($logFile, $jsonData);
	fwrite($logFile, "\n");
	fclose($logFile);
    }

    public function actionReset()
    {
	$logPath = realpath(Yii::$app->basePath . '/../dataLog');
	$logFile = fopen($logPath, 'w');
	fclose($logFile);
    }

    public function actionShow()
    {
	$logPath = realpath(Yii::$app->basePath . '/../dataLog');
	$jsonArray = file($logPath);
        $pointsArray = [];
        $humidityArray = [[]];
        $temperatureArray = [[]];
	foreach($jsonArray as $line_num => $line)
	{
	    $jsonData = json_decode($line, true);
	    //var_dump($jsonData);
	    //echo '<br>';

            $date = $jsonData['date'];


            $humidityArray[$line_num][0] = $jsonData['date'];
            $humidityArray[$line_num][1] = $jsonData['humidity'];

            $temperatureArray[$line_num][0] = $jsonData['date'];
            $temperatureArray[$line_num][1] = $jsonData['temp'];
        }
        array_push($pointsArray, $humidityArray, $temperatureArray);
        //var_dump($pointsArray);
        $js_array = json_encode($pointsArray);
        //echo '<br><br><br>';
        //var_dump($js_array);
        return $this->render('plot', ['pointsArray' => $pointsArray]);
    }
}
