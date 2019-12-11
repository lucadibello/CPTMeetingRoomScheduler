# Import config loader
from modules import Config
CONFIG_PATH = "config.json"

# Load logging lib
import logging

# Create and setup logger
LOGGER_FORMAT = "[%(name)s] %(levelname)s -  %(asctime)s: %(message)s"
logging.basicConfig(format=LOGGER_FORMAT, filename='fetcher.log', level=logging.DEBUG)
logger = logging.getLogger("FETCHER")

# Module usefull for scheduled operations
import sched
import time

# Os lib for directories management
import os

# Lib for http requests
import requests


def fetcher(config: dict):
    logger.info("Starting update process...")

    # Fix data path is necessary
    _fix_filepath(config.get("booking_data_path"))

    # Update local data
    with open(config.get("booking_data_path"), 'w+') as f:
        # Read booking data from APIs
        data = requests.post(config.get("api_url"), data={"token": config.get("api_token")}).text
        logger.debug("Read data: %s bytes", len(data))
        f.write(data)
        logger.info("Booking data saved locally")


def _fix_filepath(filepath):
    if not os.path.exists(os.path.dirname(filepath)):
        logger.warning("Data filepath not found")
        try:
            os.makedirs(os.path.dirname(filepath))
            logger.info("Data filepath fixed")
        except OSError as exc:  # Guard against race condition
            logger.warning(exc)

if __name__ == '__main__':
    # Load config from config file
    config = (Config(CONFIG_PATH)).get_settings()
    logger.debug("Config file loaded correctly")

    # Create scheduler object
    s = sched.scheduler(time.time, time.sleep)
    logger.debug("Scheduler created")


    # Create schedule using config file values
    s.enter(config["fetch_delay_seconds"], priority=1, action=fetcher(config))
    logger.debug("Set fetch schedule every %d seconds", config["fetch_delay_seconds"])

    # Start schedule (blocking mode enabled by default)
    s.run()
    logger.info("Scheduler started")
