import RPi.GPIO as GPIO
import time, math
import MySQLdb
import _mysql
import datetime

db=_mysql.connect(host="localhost", user='logger', passwd ='Shotput322397', db='temperatures')

pin = 17
count = 0

def calculate_speed(r_cm, time_sec):
    global count
    circ_cm = (2 * math.pi) * r_cm
    rot = count / 2.0
    dist_km = (circ_cm * rot) / 100000.0 # convert to kilometres
    km_per_sec = dist_km / time_sec
    km_per_hour = km_per_sec * 3600 # convert to distance per hour
    adj_km_per_hour = km_per_hour * 1.18
    miles_per_hour = adj_km_per_hour / 1.609344
    return miles_per_hour

def spin(channel):
    global count
    count += 1
    print (count)

GPIO.setmode(GPIO.BCM)
GPIO.setup(pin, GPIO.IN, GPIO.PUD_UP)
GPIO.add_event_detect(pin, GPIO.FALLING, callback=spin)

interval = 15




while True:
    i = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    dateandtime = ("%s" % i)
    count = 0
    time.sleep(interval)
    speed = calculate_speed(9.0, interval)
    speed_mph_rounded = round(speed, 6)
    print dateandtime
    print speed_mph_rounded
    db.query ("INSERT INTO wind_speed_data SET wind_speed_dateandtime='%s',wind_speed='%s'" % (dateandtime,speed_mph_rounded))