<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class DataController extends Controller
{
    public function actionSavedynamic()
    {
        $jsonData = Yii::$app->request->get('data');
        $logPath = realpath(Yii::$app->basePath . '/../dynamicDataLog');
        $logFile = fopen($logPath, 'a');
        fwrite($logFile, $jsonData);
        fwrite($logFile, "\n");
        fclose($logFile);
    }

    public function actionSavestatic()
    {
        $jsonData = Yii::$app->request->get('data');
        $logPath = realpath(Yii::$app->basePath . '/../staticDataLog');
        $logFile = fopen($logPath, 'w');
        fwrite($logFile, $jsonData);
        fwrite($logFile, "\n");
        fclose($logFile);
    }

    public function actionReset()
    {
        $logPath = realpath(Yii::$app->basePath . '/../dynamicDataLog');
        $logFile = fopen($logPath, 'w');
        fclose($logFile);
        $logPath = realpath(Yii::$app->basePath . '/../staticDataLog');
        $logFile = fopen($logPath, 'w');
        fclose($logFile);
    }

    protected function loadDynamicData()
    {
        $logPath = realpath(Yii::$app->basePath . '/../dynamicDataLog');
        $jsonArray = file($logPath);
        $humidity = '[';
        $temperature = '[';
        $pressure = '[';
        foreach($jsonArray as $line_num => $line)
        {
            $jsonData = json_decode($line, true);
            $date = $jsonData['date'];
            $humidity .= '["' . $jsonData['date'] . '", ' . $jsonData['humidity'] . '], ';
            $temperature .= '["' . $jsonData['date'] . '", ' . $jsonData['temp'] . '], ';
            $pressure .= '["' . $jsonData['date'] . '", ' . $jsonData['pressure'] . '], ';
        }
        if ($humidity != '[')
            $humidity = substr($humidity, 0, -2);
        else
            $humidity .= '[]';
        $humidity .= ']';

        if ($temperature != '[')
            $temperature = substr($temperature, 0, -2);
        else
            $temperature .= '[]';
        $temperature .= ']';

        if ($pressure != '[]')
            $pressure = substr($pressure, 0, -2);
        else
            $pressure .= '[]';
        $pressure .= ']';

        return [
            'humidity_data' => $humidity,
            'temperature_data' => $temperature,
            'pressure_data' => $pressure
        ];
    }

    protected function loadStaticData()
    {
        $logPath = realpath(Yii::$app->basePath . '/../staticDataLog');
        $jsonArray = file($logPath);

        $jsonData = json_decode($jsonArray[0], true);
        $altitude = $jsonData['altitude'];
        $sealevelPressure = $jsonData['sealevel_pressure'];

        return [
            'altitude_data' => $altitude,
            'sealevel_pressure_data' => $sealevelPressure
        ];
    }

    public function actionShow()
    {
        $this->layout = 'data_plot';

        return $this->render(
            'plot',
            array_merge(
                $this->loadStaticData(),
                $this->loadDynamicData()
            )
        );
    }
}
