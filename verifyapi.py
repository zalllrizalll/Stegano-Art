from flask import Flask, request, jsonify
from flask_cors import CORS
from Crypto.Cipher import AES
from Crypto.Util.Padding import unpad
from PIL import Image

app = Flask(__name__)
CORS(app)


def decrypt_data(ciphertext, key):
    cipher = AES.new(key, AES.MODE_ECB)
    decrypted_data = unpad(cipher.decrypt(ciphertext), AES.block_size)
    return decrypted_data.decode()


def decode_lsb(img, decryption_key):
    img_data = list(img.getdata())

    binary_message = ''
    for pixel in img_data:
        for value in pixel:
            binary_message += str(value & 1)

    # Find the end delimiter and separate the message
    delimiter_index = binary_message.find('1111111111111110')
    binary_message = binary_message[:delimiter_index]

    # Split binary_message into parts for owner_name, creation_year, email, and social_media_url
    owner_name_size = 128  # Assuming 128 bits for owner_name
    creation_year_size = 128  # Assuming 128 bits for creation_year
    email_size = 256  # Assuming 256 bits for email
    social_media_url_size = 256  # Assuming 256 bits for social_media_url

    owner_name_binary = binary_message[:owner_name_size]
    creation_year_binary = binary_message[owner_name_size:(
        owner_name_size + creation_year_size)]
    email_binary = binary_message[(
        owner_name_size + creation_year_size):(owner_name_size + creation_year_size + email_size)]
    social_media_url_binary = binary_message[(
        owner_name_size + creation_year_size + email_size):]

    # Decrypt owner_name, creation_year, email, and social_media_url
    decrypted_owner_name = decrypt_data(
        int(owner_name_binary, 2).to_bytes(16, byteorder='big'), decryption_key)
    decrypted_creation_year = decrypt_data(
        int(creation_year_binary, 2).to_bytes(16, byteorder='big'), decryption_key)
    decrypted_email = decrypt_data(
        int(email_binary, 2).to_bytes(32, byteorder='big'), decryption_key)
    decrypted_social_media_url = decrypt_data(
        int(social_media_url_binary, 2).to_bytes(32, byteorder='big'), decryption_key)

    return decrypted_owner_name, int(decrypted_creation_year), decrypted_email, decrypted_social_media_url


@app.route('/decrypt', methods=['POST'])
def decrypt_image():
    try:
        # Get the input data from the request
        image_file = request.files['image']
        img = Image.open(image_file)
        decryption_key_hex = request.form['decryption_key']
        decryption_key = bytes.fromhex(decryption_key_hex)

        # Decrypt the image
        decrypted_owner_name, decrypted_creation_year, decrypted_email, decrypted_social_media_url = decode_lsb(
            img, decryption_key)

        return jsonify({
            "status": "success",
            "message": {
                "decrypted_owner_name": decrypted_owner_name,
                "decrypted_creation_year": decrypted_creation_year,
                "decrypted_email": decrypted_email,
                "decrypted_social_media_url": decrypted_social_media_url
            }
        })
    except Exception as e:
        return jsonify({"status": "error", "message": str(e)})


if __name__ == '__main__':
    app.run(debug=True, port=5001)
