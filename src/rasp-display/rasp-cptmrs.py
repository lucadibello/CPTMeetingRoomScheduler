# Load all Flask needed modules
from flask import Flask, render_template, request, escape

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
    name = request.args.get("name", "World")
    return f'Hello, {escape(name)}!'


def _load_config(path):
    return Config(path).get_settings()

if __name__ == '__main__':
    CONFIG = _load_config(_CONFIG_FILE_PATH)
    
    # Start flask app
    app.run(debug=True,port=CONFIG["port"])