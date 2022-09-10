#!/usr/bin/python
from Adafruit_BMP085 import BMP085
import datetime
import MySQLdb
import _mysql
db=_mysql.connect(host="localhost", user='logger', passwd ='Shotput322397', db='temperatures')
i = datetime.datetime.now()

# Initialise the BMP085 and use STANDARD mode (default value)
# bmp = BMP085(0x77, debug=True)
bmp = BMP085(0x77)
 
# To specify a different operating mode, uncomment one of the following:
# bmp = BMP085(0x77, 0)  # ULTRALOWPOWER Mode
# bmp = BMP085(0x77, 1)  # STANDARD Mode
# bmp = BMP085(0x77, 2)  # HIRES Mode
# bmp = BMP085(0x77, 3)  # ULTRAHIRES Mode


temp = bmp.readTemperature()
pressure = bmp.readPressure()
time = ("%s" % i)

print time
print (pressure * 0.00029529980164712)
print (temp * (9.0 / 5.0) +32)

db.query ("INSERT INTO inside_temp_data SET inside_dateandtime='%s',inside_temp='%s', inside_pressure='%s'" % ((time),(temp * (9.0 / 5.0) +32),(round(pressure * 0.00029529980164712,2))))