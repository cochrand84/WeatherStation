#!/usr/lib/python3
import RPi.GPIO as GPIO
import datetime
import time
import MySQLdb
import _mysql

db=_mysql.connect(host="localhost", user='logger', passwd ='Shotput322397', db='temperatures')

# this many mm per bucket tip
calibration = 0.2794
# which GPIO pin the gauge is connected to
pin = 27

GPIO.setmode(GPIO.BCM)  
GPIO.setup(pin, GPIO.IN, pull_up_down=GPIO.PUD_UP)

# variable to keep track of how much rain
rain = 0
raininches = 0

# the call back function for each bucket tip
def cb(channel):
	global rain
	global raininches
	rain = rain + calibration
	raininches = round((rain * 0.039370),3)



# register the call back for pin interrupts
GPIO.add_event_detect(pin, GPIO.FALLING, callback=cb, bouncetime=300)

i = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
dateandtime = ("%s" % i)

# display and log results
while True:
	i = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
	dateandtime = ("%s" % i)
	print dateandtime
	print rain
	print raininches
	db.query ("INSERT INTO rain_data SET rain_dateandtime='%s',rain_metered='%s'" % (dateandtime,raininches))
	rain = 0
	raininches = 0
	time.sleep(30)
	
	
	



