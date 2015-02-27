#!/usr/bin/env python

import sys
import Adafruit_DHT

if __name__ == '__main__':
    PIN = sys.argv[1]
    SENSOR = Adafruit_DHT.DHT22

    humidity, temperature = Adafruit_DHT.read_retry(SENSOR, PIN)
    print humidity, temperature
