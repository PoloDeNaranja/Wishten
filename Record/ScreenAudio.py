from moviepy.editor import VideoFileClip, AudioFileClip

#tomo los dos archivos que se han grabado
video_clip = VideoFileClip("output.avi")
audio_clip = AudioFileClip("audio.wav")
final_clip = video_clip.set_audio(audio_clip)#Unimos al video el audio y finalmente creo el nuevo archivo
final_clip.write_videofile("final.mp4")