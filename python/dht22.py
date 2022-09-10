#!/usr/bin/python

import Adafruit_DHT
import datetime
import MySQLdb
import _mysql
import sys
import numpy as np

db=_mysql.connect(host="localhost", user='logger', passwd ='Shotput322397', db='temperatures')

sensor = Adafruit_DHT.DHT22

pin = 22

humidity, temperature = Adafruit_DHT.read_retry(sensor, pin)

i = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
a = 17.271
b = 237.7
T = temperature
RH = humidity

def dewpoint_approximation(T,RH):
 
    Td = (b * gamma(T,RH)) / (a - gamma(T,RH))
 
    return Td
	
def gamma(T,RH):
 
    g = (a * T / (b + T)) + np.log(RH/100.0)
 
    return g

Td = dewpoint_approximation(T,RH)
time = ("%s" % i)

temperatureF = ((temperature * (9.0 / 5.0) +32))
dewpointF = (Td * (9.0 / 5.0) +32)

tempround = round(temperatureF,2)
humidityround = round(humidity,2)
dewpointround = round(dewpointF,2)
linecolor = ('#0000ff')

if humidity is not None and temperature is not None:
	db.query ("INSERT INTO outside_temp_data SET outside_dateandtime='%s',outside_temp='%s', outside_humidity='%s', outside_dewpoint='%s', outside_line_color='%s'" % (time,tempround,humidityround,dewpointround,linecolor))
print temperature
print tempround
print humidityround
print dewpointround
