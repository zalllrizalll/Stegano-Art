import qrcode
from PIL import Image
from Crypto.Cipher import AES
from Crypto.Util.Padding import pad
from Crypto.Random import get_random_bytes
from flask import Flask, request, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app)


def encrypt_data(data, key):  # Fungsi untuk mengenkripsi data dengan AES
    cipher = AES.new(key, AES.MODE_ECB)
    ciphertext = cipher.encrypt(pad(data.encode(), AES.block_size))
    return ciphertext


def encode_QR(img, owner_name, creation_year, email, social_media_url):
    # Ukuran QR Code adalah 30% dari ukuran gambar
    qr_size = int(min(img.size) * 0.3)

    # Data yang akan diencode ke dalam QR Code
    qr_data = f"Name: {owner_name}\nYear: {creation_year}\nEmail: {email}\nSocial Media: {social_media_url}"

    qr = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_L,
        box_size=5,  # Atur ukuran QR Code
        border=1,
    )
    qr.add_data(qr_data)
    qr.make(fit=True)

    qr_img = qr.make_image(fill_color="black", back_color="white").resize(
        (qr_size, qr_size))  # Resize QR Code agar sesuai ukuran
    img.paste(
        qr_img, (img.width - qr_img.size[0], img.height - qr_img.size[1]))  # Paste QR Code ke gambar
    return img


def encode_lsb(img, owner_name, creation_year, email, social_media_url, encryption_key):

    # Enkripsi owner_name, creation_year, email, dan social_media_url
    encrypted_owner_name = encrypt_data(owner_name, encryption_key)
    encrypted_creation_year = encrypt_data(str(creation_year), encryption_key)
    encrypted_email = encrypt_data(email, encryption_key)
    encrypted_social_media_url = encrypt_data(social_media_url, encryption_key)

    # Mengonversi data terenkripsi ke dalam bentuk bit
    binary_owner_name = ''.join(format(byte, '08b')
                                for byte in encrypted_owner_name)
    binary_creation_year = ''.join(format(byte, '08b')
                                   for byte in encrypted_creation_year)
    binary_email = ''.join(format(byte, '08b') for byte in encrypted_email)
    binary_social_media_url = ''.join(
        format(byte, '08b') for byte in encrypted_social_media_url)

    # Menambahkan bit '1111111111111110' di akhir pesan untuk menandakan akhir pesan
    binary_message = binary_owner_name + binary_creation_year + \
        binary_email + binary_social_media_url + '1111111111111110'

    # Mendapatkan data piksel gambar
    img_data = list(img.getdata())

    # Menyisipkan bit pesan ke dalam bit paling tidak signifikan (LSB)
    data_index = 0
    for i in range(len(img_data)):
        pixel = list(img_data[i])
        for j in range(3):  # Loop untuk R, G, B
            if data_index < len(binary_message):
                pixel[j] = pixel[j] & ~1 | int(binary_message[data_index])
                data_index += 1

        img_data[i] = tuple(pixel)

    # Menyimpan hasil gambar yang telah diencode
    encoded_img = Image.new('RGB', img.size)
    encoded_img.putdata(img_data)

    return encoded_img


# Routing untuk endpoint /encode dengan metode POST
@app.route('/encode', methods=['POST'])
def encode_image():
    try:
        # Get the input data from the request
        image_file = request.files['image']
        img = Image.open(image_file)
        owner_name = request.form['owner_name']
        creation_year = request.form['creation_year']
        email = request.form['email']
        social_media_url = request.form['social_media_url']
        encryption_key = get_random_bytes(16)

        # Encode the image
        encoded_img = encode_lsb(
            img, owner_name, creation_year, email, social_media_url, encryption_key)
        qr_img = encode_QR(
            img, owner_name, creation_year, email, social_media_url
        )

        # Convert encryption_key to hexadecimal string
        encryption_key_hex = encryption_key.hex()

        # Save the encoded image
        encoded_img.save(f"./imgEncode/encoded_{image_file.filename}")
        qr_img.save(f"./imgEncode/qr_{image_file.filename}")

        # Mengembalikan response berupa JSON yang berisi status, pesan, path gambar yang telah diencode, dan kunci enkripsi
        return jsonify({
            "status": "success",
            "message": "Image successfully steganographically encoded.",
            "path": f"./imgEncode/encoded_{image_file.filename}",
            "qr_path": f"./imgEncode/qr_{image_file.filename}",
            "encryption_key w/ HEX": encryption_key_hex
        })
    except Exception as e:  # Jika terjadi error, mengembalikan response berupa JSON yang berisi status dan pesan error
        return jsonify({"status": "error", "message": str(e)})


# Menjalankan aplikasi Flask pada port 5000, dengan adanya debug mode
if __name__ == '__main__':
    app.run(debug=True)
