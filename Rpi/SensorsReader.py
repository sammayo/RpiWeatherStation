#!/usr/bin/env python

import sys
import json
import urllib2
import Adafruit_DHT


def readHumidityTemp(sensor, pin):
    '''
    Returns humidity and temperature read from raspberry pi as a tuple.
       
    Arguments:
        sensor -- Sensor model number.
        pin -- RPi GPIO pin over which the sensor data is sent.

    Return: tuple
    '''
    return Adafruit_DHT.read_retry(sensor, pin)


def sendToServer(data, url):
    '''
    Sends humidity and temperature data to the server as a json string.
    
    Arguments:
        data -- Humidity and temperature tuple.
        url -- Url of request to save data.
    '''
    jsonData = json.dumps({'humidity': data[0], 'temp': data[1]})
    url += urllib2.quote(jsonData)
    print url
    url = 'http://markalab.org'
    urllib2.urlopen(url)


def checkArgs():
    if len(sys.argv) < 2:
        print 'Usage: python SensorsReader.py pin_number'
        sys.exit(-1)
    try:
        int(sys.argv[1])
    except ValueError:
        print 'Usage: python SensorsReader.phy pin_number'
        sys.exit(-1)


if __name__ == '__main__':
    checkArgs()
    PIN = sys.argv[1]
    SENSOR = Adafruit_DHT.DHT22
    URL = 'http://weatherstation/index.php/save/'

    sendToServer(readHumidityTemp(SENSOR, PIN), URL)
