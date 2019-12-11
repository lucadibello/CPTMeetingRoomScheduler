# Load all Flask needed modules
from flask import Flask, render_template

# http request lib
import requests

# JSON lib
import json

# Load all personal modules
from modules import Config

# Config filepath
_CONFIG_FILE_PATH = "config.json"

# Config dict
CONFIG = {}

# Setup app name
app = Flask(__name__)


@app.route('/')
def hello():
    # Read json from APIs
    data = requests.post(CONFIG["api_url"], data={"token": CONFIG["api_token"]}).content
    # Parse json
    bookings = json.loads(data)
    
    for booking in bookings.items:
        print(booking)

def _load_config(path):
    return Config(path).get_settings()

if __name__ == '__main__':
    # Load config
    CONFIG = _load_config(_CONFIG_FILE_PATH)
    print("[!] Config loaded correctly")

    # Start flask app
    app.run(debug=True,port=CONFIG["port"])
