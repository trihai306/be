from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.service import Service
from selenium.common.exceptions import TimeoutException
from selenium import webdriver
from webdriver_manager.chrome import ChromeDriverManager
import time
import random
from selenium.webdriver.chrome.options import Options
from selenium.webdriver import DesiredCapabilities

class BaseSeleniumDriver:

    def __init__(self, browser_options=None):
        self.browser_options = browser_options if browser_options is not None else Options()
        self.browser_options.add_experimental_option("prefs", {
            "profile.default_content_setting_values.notifications": 2
        })

        self.driver = None
        self.action_chains = None

    def setup_driver(self):
        if not self.driver:
            capabilities = DesiredCapabilities.CHROME.copy()
            capabilities['acceptSslCerts'] = True
            capabilities['acceptInsecureCerts'] = True

            self.browser_options.set_capability("goog:chromeOptions", capabilities)

            self.driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()),
                                           options=self.browser_options)
            self.driver.execute_script("Object.defineProperty(navigator, 'webdriver', {get: () => undefined})")
            self.action_chains = ActionChains(self.driver)

    def random_delay(self, min_delay=0.5, max_delay=3):
        time.sleep(random.uniform(min_delay, max_delay))

    def move_to_element(self, element):
        self.action_chains.move_to_element(element).perform()
        self.random_delay()

    def mimic_human_typing(self, element, text):
        for character in text:
            element.send_keys(character)
            self.random_delay(min_delay=0.05, max_delay=0.25)

    def mimic_human_typing_with_error(self, element, text, error_rate=0.05):
        for character in text:
            if random.random() < error_rate:
                # Make a typo
                element.send_keys(chr(random.randint(ord('a'), ord('z'))))
                self.random_delay(min_delay=0.05, max_delay=0.25)
                # Correct the typo
                element.send_keys(Keys.BACKSPACE)
                self.random_delay(min_delay=0.05, max_delay=0.25)
            element.send_keys(character)
            self.random_delay(min_delay=0.05, max_delay=0.25)

    def click_element(self, element):
        self.move_to_element(element)
        element.click()
        self.random_delay()

    def get(self, url):
        self.driver.get(url)
        self.random_delay()

    def quit(self):
        if self.driver:
            self.driver.quit()

    def find_element(self, by, value):
        try:
            element = WebDriverWait(self.driver, 10).until(EC.presence_of_element_located((by, value)))
            return element
        except TimeoutException:
            print(f"Timed out waiting for element with {by} = {value} to load.")
            return None

    def find_elements(self, by, value):
        try:
            elements = WebDriverWait(self.driver, 10).until(EC.presence_of_all_elements_located((by, value)))
            return elements
        except TimeoutException:
            print(f"Timed out waiting for elements with {by} = {value} to load.")
            return None

    def scroll_to_element(self, element):
        self.driver.execute_script("arguments[0].scrollIntoView();", element)
        self.random_delay()

    def execute_script(self, script, *args):
        self.driver.execute_script(script, *args)
        self.random_delay()

    def random_scroll(self, num_scrolls=5):
        for _ in range(num_scrolls):
            # Choose a random fraction of the page to scroll
            fraction_of_page = random.uniform(0.1, 1.0)

            # Choose whether to scroll up or down
            direction = random.choice([-1, 1])

            # Calculate the amount to scroll
            scroll_amount = direction * fraction_of_page * self.driver.execute_script(
                "return document.body.scrollHeight;")

            # Scroll the page
            self.driver.execute_script(f"window.scrollBy(0, {scroll_amount});")
            self.random_delay()

        # After the random scrolling, scroll to the bottom of the page
        self.driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        self.random_delay()
