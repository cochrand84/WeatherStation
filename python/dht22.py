#!/usr/bin/python
# -*- coding: utf-8 -*-

import time
import board
import adafruit_dht
import datetime
# import MySQLdb
# import _mysql
import sys
import numpy as np

# db=_mysql.connect(host="localhost", user='logger', passwd ='Shotput322397', db='temperatures')

dhtDevice = adafruit_dht.DHT22(board.D4)

temperature = dhtDevice.temperature
humidity = dhtDevice.humidity

while True:
    try:

        i = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        a = 17.271
        b = 237.7
        T = temperature
        RH = humidity

        
        timeread = '%s' % i



        def gamma(T, RH):

            g = a * T / (b + T) + np.log(RH / 100.0)
            return g

        def dewpoint_approximation(T, RH):

            Td = b * gamma(T, RH) / (a - gamma(T, RH))
            return Td

        Td = dewpoint_approximation(T, RH)
        temperatureF = temperature * (9.0 / 5.0) + 32
        dewpointF = Td * (9.0 / 5.0) + 32
        tempround = round(temperatureF, 2)
        humidityround = round(humidity, 2)
        dewpointround = round(dewpointF, 2)

        
        T2 = pow(temperatureF, 2)
        T3 = pow(temperatureF, 3)
        H2 = pow(humidity, 2)
        H3 = pow(humidity, 3)
            
        # Coefficients for the calculations
        C1 = [ -42.379, 2.04901523, 10.14333127, -0.22475541, -6.83783e-03, -5.481717e-02, 1.22874e-03, 8.5282e-04, -1.99e-06]
        C2 = [ 0.363445176, 0.988622465, 4.777114035, -0.114037667, -0.000850208, -0.020716198, 0.000687678, 0.000274954, 0]
        C3 = [ 16.923, 0.185212, 5.37941, -0.100254, 0.00941695, 0.00728898, 0.000345372, -0.000814971, 0.0000102102, -0.000038646, 0.0000291583, 0.00000142721, 0.000000197483, -0.0000000218429, 0.000000000843296, -0.0000000000481975]
            
        # Calculating heat-indexes with 3 different formula
        heatindex1 = C1[0] + (C1[1] * temperatureF) + (C1[2] * humidity) + (C1[3] * temperatureF * humidity) + (C1[4] * T2) + (C1[5] * H2) + (C1[6] * T2 * humidity) + (C1[7] * temperatureF * H2) + (C1[8] * T2 * H2)
        heatindex2 = C2[0] + (C2[1] * temperatureF) + (C2[2] * humidity) + (C2[3] * temperatureF * humidity) + (C2[4] * T2) + (C2[5] * H2) + (C2[6] * T2 * humidity) + (C2[7] * temperatureF * H2) + (C2[8] * T2 * H2)
        heatindex3 = C3[0] + (C3[1] * temperatureF) + (C3[2] * humidity) + (C3[3] * temperatureF * humidity) + (C3[4] * T2) + (C3[5] * H2) + (C3[6] * T2 * humidity) + (C3[7] * temperatureF * H2) + (C3[8] * T2 * H2) + (C3[9] * T3) + (C3[10] * H3) + (C3[11] * T3 * humidity) + (C3[12] * temperatureF * H3) + (C3[13] * T3 * H2) + (C3[14] * T2 * H3) + (C3[15] * T3 * H3)

        heatindexround = round(heatindex1, 2)


# if humidity is not None and temperature is not None:
# db.query ("INSERT INTO outside_temp_data SET outside_dateandtime='%s',outside_temp='%s', outside_humidity='%s', outside_dewpoint='%s'" % (timeread,tempround,humidityround,dewpointround))
        print(
            "Time: {}  Temp: {:.1f}F  Humidity: {}%  Dewpoint: {}F  HeatIndex: {}F".format(
                timeread, tempround, humidityround, dewpointround, heatindexround
            )
        )
    except RuntimeError as error:
    # Errors happen fairly often, DHT's are hard to read, just keep going
        print(error.args[0])
        time.sleep(30)
        continue
    except Exception as error:
        dhtDevice.exit()
        raise error

    time.sleep(30)