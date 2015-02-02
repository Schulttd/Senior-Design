import serial
import time
import datetime

#Open the serial connection
ser = serial.Serial(
    port='COM13',\
    baudrate=9600,\
    parity=serial.PARITY_NONE,\
    stopbits=serial.STOPBITS_ONE,\
    bytesize=serial.EIGHTBITS,\
    timeout=0)

#Print port connected to
print("connected to: " + ser.portstr)

#Open output file
with open("output.txt", 'a') as f:
  while True:
      #Read in the serial data and Decode data as ASCII
      line = ser.readline()
      line = line.decode()

      #If Data is not blank or equal to 0
      if line != "" and line !="0": 
        #Create time stamp for read data
        ts = time.time()
        st = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
        #Write line to file, flush output buffer, and print to command window
        f.write(line+st+"\n")
        f.flush()
        print(line+st)
#Close Serial Connection
ser.close()