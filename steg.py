import wave
import struct
import sys

def watermark_to_bits(watermark, nbits=8):
    watermark_bits = []
    for byte in watermark:
        for i in range(0,nbits):
            watermark_bits.append( (byte & (2 ** i)) >> i )
    return watermark_bits

def lsb_watermark(cover_filepath, watermark_data, watermarked_output_path):
    
    watermark_str = str(watermark_data)
    watermark = struct.unpack("%dB" % len(watermark_str), watermark_str)
    
    watermark_size = len(watermark)
    watermark_bits = watermark_to_bits((watermark_size,), 32)
    watermark_bits.extend(watermark_to_bits(watermark))
    
    cover_audio = wave.open(cover_filepath, 'rb') 
    
    (nchannels, sampwidth, framerate, nframes, comptype, compname) = cover_audio.getparams()
    frames = cover_audio.readframes (nframes * nchannels)
    samples = struct.unpack_from ("%dh" % nframes * nchannels, frames)

    if len(samples) < len(watermark_bits):
        raise OverflowError("The watermark data provided is too big to fit into the cover audio! Tried to fit %d bits into %d bits of space." % (len(watermark_bits), len(samples))) 
    
    print "Watermarking %s (%d samples) with %d bits of information." % (cover_filepath, len(samples), len(watermark_bits))
    
    encoded_samples = []
    
    watermark_position = 0
    n = 0
    for sample in samples:
        encoded_sample = sample
        
        if watermark_position < len(watermark_bits):
            encode_bit = watermark_bits[watermark_position]
            if encode_bit == 1:
                encoded_sample = sample | encode_bit
            else:
                encoded_sample = sample
                if sample & 1 != 0:
                    encoded_sample = sample - 1
                    
            watermark_position = watermark_position + 1
            
        encoded_samples.append(encoded_sample)
            
    encoded_audio = wave.open(watermarked_output_path, 'wb')
    encoded_audio.setparams( (nchannels, sampwidth, framerate, nframes, comptype, compname) )

    encoded_audio.writeframes(struct.pack("%dh" % len(encoded_samples), *encoded_samples))

def embed_file(cover_audio, hidden_file, output):
    f = open(hidden_file)
    hidden_data = f.read()
    lsb_watermark(cover_audio, hidden_data, output)


mess = "giau file ki thuat";
input_audio = "audio/"+sys.argv[1]
output_audio = input_audio + "_enc"
lsb_watermark(input_audio , mess , output_audio)
