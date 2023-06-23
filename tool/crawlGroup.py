import json

from selenium.common import NoSuchElementException
from selenium.webdriver.common.by import By
from Base import BaseSeleniumDriver


class crawlGroup(BaseSeleniumDriver):
    def __init__(self, email, password, group_url, browser_options=None):
        super().__init__(browser_options)
        self.group_url = group_url
        self.email = email
        self.password = password
        self.setup_driver()
        self.login()
        self.listUserIds = []

    def login(self):
        self.get("https://mbasic.facebook.com/")
        initial_cookies = self.driver.get_cookies()

        email_input = self.find_element(By.NAME, "email")
        self.mimic_human_typing(email_input, self.email)

        password_input = self.find_element(By.NAME, "pass")
        self.mimic_human_typing(password_input, self.password)

        login_button = self.find_element(By.NAME, "login")
        self.click_element(login_button)
        self.random_delay(min_delay=2, max_delay=5)

        if "save-device" in self.driver.current_url:
            # Using JavaScript to click on the OK button
            self.driver.execute_script('document.querySelector("#root > table > tbody > tr > td > div > form > div > input").click();')
            self.random_delay(min_delay=2, max_delay=5)

        if self.driver.current_url != "https://mbasic.facebook.com/home.php" or initial_cookies == self.driver.get_cookies():
            print("Login failed")
            return False

        print("Login successful")
        return True

    def scrape_group(self):
        self.get(self.group_url)
        self.random_delay(min_delay=2, max_delay=5)
        for i in range(2):
            self.random_scroll(num_scrolls=3)
            self.random_delay(min_delay=2, max_delay=3)
        listUser = self.find_elements(By.XPATH, '//a[contains(@href, "/groups/1112864558746406/user/")]')
        for user in listUser:
            if 'contributions' not in user.get_attribute("href"):
                parts = user.get_attribute("href").split("/")
                user_id = parts[-2]
                if user_id not in self.listUserIds:
                    self.listUserIds.append(user_id)

    def get_profile(self, user_id):
        self.get(f"https://mbasic.facebook.com/{user_id}")
        self.random_delay(min_delay=2, max_delay=5)
        if self.find_element(By.ID, "living"):
            info_elements = self.find_elements(By.XPATH, "//div[@id='living']//table/tbody/tr")
            for element in info_elements:
                try:
                    info_label = element.find_element(By.XPATH, "./td[1]//span").text
                    info_value = element.find_element(By.XPATH, "./td[2]//a").text
                    print(f"{info_label}: {info_value}")
                except NoSuchElementException:
                    print("Element not found in this row")

        if self.find_element(By.ID, "contact-info"):
            contact_info_elements = self.find_elements(By.XPATH, "//div[@id='contact-info']//table")
            for element in contact_info_elements:
                contact_info_label = element.find_element(By.XPATH, "./tbody/tr/td[1]//span").text
                contact_info_value = element.find_element(By.XPATH, "./tbody/tr/td[2]/div").text
                print(f"{contact_info_label}: {contact_info_value}")
        else:
            print("Khong co thong tin")
    def get_user_info(self):
        self.listUserIds = list(set(self.listUserIds))
        for user_id in self.listUserIds:
            self.get_profile(user_id)

    def quit(self):
        self.driver.quit()


# Use the crawlGroup class
fb_group = crawlGroup("huongvinh2021@gmail.com", "0965142566a", "https://www.facebook.com/groups/tinchuan/members")
fb_group.scrape_group()
fb_group.get_user_info()

fb_group.quit()
