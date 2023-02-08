import pyaudio
import wave
import keyboard


chunk = 1024  # Record in chunks of 1024 samples
sample_format = pyaudio.paInt16  # 16 bits per sample
channels = 1 #uso uno solo si uso más la voz se va saturando, si pongo 2 se esccha muy ronca la voz
rate1 = 44100  # Record at 44100 samples per second
audio = pyaudio.PyAudio()
stream = audio.open(format=sample_format, channels=channels, rate=rate1, frames_per_buffer=chunk, input=True)
list=[]

while True:
        var = stream.read(1024)
        list.append(var)
        if keyboard.is_pressed("q"): #Aquí en verdad sería el boton que haya en la aplicación que tengamos en la web
            break
#cierro el captural el flujo y el audio
stream.stop_stream()
stream.close()
audio.terminate()

file = wave.open("audio.wav","wb")# aqui en verdad sería el que decidamos al final guardar para cada usuario
#cogemos los parametros y los metemos en el fichero de audio
file.setnchannels(1)
file.setsampwidth(audio.get_sample_size(pyaudio.paInt16))
file.setframerate(44100)
file.writeframes(b''.join(list)) #lee del bufer list y lo une todo
file.close()