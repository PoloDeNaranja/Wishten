import cv2
import numpy as np
import pyautogui
import keyboard

# display screen resolution, get it using pyautogui itself
SCREEN_SIZE = tuple(pyautogui.size())# cogemos el tamñano de la pantalla
fourcc = cv2.VideoWriter_fourcc(*"XVID") # libreria que te comprime y descomprime los videos usamos xvid porque es sw libre
fps = 12.0 #frames por segundo que queremos que grabe si se sube va muy rapido
out = cv2.VideoWriter("output.avi", fourcc, fps, (SCREEN_SIZE))# guardo el video 

while True: #Hasta que el usuario que este grabando su pantalla decida parar de grabar
    img = pyautogui.screenshot()# saco capturas de la pantalla
    frame = np.array(img)# guardo todas las capturas en un array para luego pasarselo en la funcion write
    frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)# convierto de  BGR to RGB porque c2v usa BGR def
    out.write(frame)#escribes cada frame que hay en el array 
    if keyboard.is_pressed("q"): #Aquí en verdad sería el boton que haya en la aplicación que tengamos en la web
        break

out.release()      
cv2.destroyAllWindows() #cierro todo 


