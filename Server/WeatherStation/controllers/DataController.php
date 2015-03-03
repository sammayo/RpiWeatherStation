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
        $this->layout = 'data_plot';

        $logPath = realpath(Yii::$app->basePath . '/../dataLog');
        $jsonArray = file($logPath);
        $sensorData = [[]];
        $humidity = '[';
        $temperature = '[';
        foreach($jsonArray as $line_num => $line)
        {
            $jsonData = json_decode($line, true);
            
            $date = $jsonData['date'];

            $sensorData[$line_num][0] = $jsonData['date'];
            $sensorData[$line_num][1] = $jsonData['humidity'];
            $humidity .= '[' . $jsonData['date'] . ', ' . $jsonData['humidity'] . '], ';
            $temperature .= '[' . $jsonData['date'] . ', ' . $jsonData['temp'] . '], ';
            $temperatureArray[$line_num][2] = $jsonData['temp'];
        }
        $humidity = substr($humidity, 0, -2);
        $humidity .= ']';
        $temperature = substr($temperature, 0, -2);
        $temperature .= ']';

        return $this->render('plot', [
            'humidity_data' => $humidity,
            'temperature_data' => $temperature
        ]);
    }
}
