#!/usr/bin/env python

import config
from datetime import datetime
import time
import json
import urllib2
import Adafruit_DHT
import Adafruit_BMP.BMP085 as BMP085


def readHumidityTemp(pin):
    '''
    Returns humidity and temperature read from raspberry pi as a tuple.
       
    Arguments:
        pin -- RPi GPIO pin over which the sensor data is sent.

    Return: tuple
    '''
    sensor = Adafruit_DHT.DHT22
    return Adafruit_DHT.read_retry(sensor, pin)

def readBarometerData(busnum):
    '''
    Returns pressure and altitude read from raspberry pi.

    Return: tuple
    '''
    barometer = BMP085.BMP085(busnum)
    pressure = barometer.read_pressure()
    altitude = barometer.read_altitude()
    sealevel_pressure = barometer.read_sealevel_pressure()

    return pressure, altitude, sealevel_pressure


def sendStaticData(data, url):
    '''
    Sends static data to the server as a json string.
    
    Argument:
        data -- Humidity, temperature, and barometer data tuple.
        url -- Url of request to save static data.
    '''
    jsonData = json.dumps({
        'altitude': data[3],
        'sealevel_pressure': data[4]
    })
    url += urllib2.quote(jsonData)
    urllib2.urlopen(url)


def sendDynamicData(data, url):
    '''
    Sends dynamic humidity, temperature, and pressure data to the server as a json string.
    
    Arguments:
        data -- Humidity, temperature, and barometer data tuple.
        url -- Url of request to save data.
    '''
    time = datetime.now()
    date = time.strftime("%y-%m-%d")
    jsonData = json.dumps({
        'date': date,
        'humidity': data[0],
        'temp': data[1],
        'pressure': data[2]
    })
    url += urllib2.quote(jsonData)
    urllib2.urlopen(url)


if __name__ == '__main__':
    TEMP_HUMIDITY_PIN = config.temp_humidity_pin
    BAROMETER_BUS_NUM = config.barometer_bus_num
    
    SAVE_DYNAMIC_URL = config.base_url + 'savedynamic/'
    SAVE_STATIC_URL = config.base_url + 'savestatic/'
    
    dataTuple = readHumidityTemp(TEMP_HUMIDITY_PIN) + readBarometerData(BAROMETER_BUS_NUM)
    
    sendStaticData(dataTuple, SAVE_STATIC_URL)
    
    while True:
        sendDynamicData(dataTuple, SAVE_DYNAMIC_URL)
        time.pause(config.readout_interval_secs)
        dataTuple = readHumidityTemp(TEMP_HUMIDITY_PIN) + readBarometerData(BAROMETER_BUS_NUM)
