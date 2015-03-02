#!/usr/bin/env python

from config import *
from datetime import datetime
import sys
import json
import urllib2
import Adafruit_DHT
import Adafruit_BMP.BMP085 as BMP085


def readHumidityTemp(sensor, pin):
    '''
    Returns humidity and temperature read from raspberry pi as a tuple.
       
    Arguments:
        sensor -- Sensor model number.
        pin -- RPi GPIO pin over which the sensor data is sent.

    Return: tuple
    '''
    return Adafruit_DHT.read_retry(sensor, pin)


def readBarometerData(_busnum):
    '''
    Returns pressure and altitude read from raspberry pi.

    Return: tuple
    '''
    barometer = BMP085.BMP085(busnum=_busnum)
    pressure = barometer.read_pressure()
    altitude = barometer.read_altitude()
    sealevel_pressure = barometer.read_sealevel_pressure()

    return (pressure, altitude, sealevel_pressure)

def sendToServer(data, url):
    '''
    Sends humidity and temperature data to the server as a json string.
    
    Arguments:
        data -- Humidity, temperature, and barometer data tuple.
        url -- Url of request to save data.
    '''
    time = datetime.now()
    date = time.strftime("%y-%m-%d")
    jsonData = json.dumps({'date:': date,'humidity': data[0], 'temp': data[1], 'pressure': data[2], 'altitude': data[3], 'sealevel_pressure': data[4]})
    url += urllib2.quote(jsonData)
    print url
    urllib2.urlopen(url)


def checkArgs():
    '''
    Validates command line arguments.
    '''
    if len(sys.argv) < 2:
        print argsErrorString
        sys.exit(-1)
    try:
        int(sys.argv[1])
        if len(sys.argv) <= 3:
            int(sys.argv[2])
            bus_num = sys.argv[2]
    except ValueError:
        print argsErrorString
        sys.exit(-1)


if __name__ == '__main__':
    checkArgs()
    PIN = sys.argv[1]
    SENSOR = Adafruit_DHT.DHT22
    URL = baseUrl + 'save/'

    dataTuple = readHumidityTemp(SENSOR, PIN) + readBarometerData(bus_num)

    sendToServer(dataTuple, URL)
