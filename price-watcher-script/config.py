from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager


def get_chrome_options():

    chrome_options = Options()

    # Masquer Selenium
    user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36"
    chrome_options.add_argument('--headless')
    chrome_options.add_argument(f"user-agent={user_agent}")
    chrome_options.add_argument('--disable-blink-features=AutomationControlled')
    chrome_options.add_experimental_option('excludeSwitches', ['enable-automation'])
    chrome_options.add_experimental_option('useAutomationExtension', False)
    return chrome_options

def get_chrome_service():
    return Service(ChromeDriverManager().install())