import serial
import os
import time
import sys
import MySQLdb
import smtplib
import string

port = "NULL"
ser = serial.Serial(port,NULL,timeout=10)
ser.readline()

def email(temp):
	SUBJECT = "The Temperature in the server room has reached a dangerous level"
	TO = "foo@bar.com"
	FROM = "warn@bar.com"
	text = "This is a report of the temperature in the server room inside the server room. This room has a substantial amount of expensive computing equipment and keeping the temperatures below 30 C/ 86 F is important. The temperature is now " + temp + " degrees C"
	BODY = string.join((
		"From: %s" % FROM,
		"To: %s" % TO,
		"Subject: %s" % SUBJECT ,
		"",
		text
		), "\r\n")
	server = smtp.SMTP("mail.foo.com")
	server.sendmail(FROM, TO, BODY)
	server.quit()


def getData():
	sensor = ser.readline().split()
#	print sensor
	conn = db.connect (host = "NULL", user = "NULL", passwd = "NULL", db = "NULL")
	cursor = conn.cursor ()

	command = "INSERT INTO `NULL`.`NULL` (`id`, `sensor_id`, `time`, `temp`) VALUES (NULL, '%s', CURRENT_TIMESTAMP, '%s');" % (sensor[0], sensor[1])
#added sensor[2] and changed for i in range from 2 to 3	
#	print command;
	if 30.0 <= float(sensor[1]): 
		email(sensor[1])
	cursor.execute(command);
	cursor.close ()
	conn.close ()
	return
#for i in range(2):
getData()

ser.close()

