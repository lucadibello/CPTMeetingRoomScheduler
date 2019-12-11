# Import config loader
from modules import Config
CONFIG_PATH = "config.json"

# Load logging lib
import logging

# Create and setup logger
LOGGER_FORMAT = "[%(name)s] %(levelname)s -  %(asctime)s: %(message)s"
logging.basicConfig(format=LOGGER_FORMAT, filename='fetcher.log')
logger = logging.getLogger("FETCHER")

# Module usefull for scheduled operations
import sched
import time


def fetcher(config: dict):
    print("Yolino")

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
