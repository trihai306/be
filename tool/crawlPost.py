import json
from selenium import webdriver

from Base import BaseSeleniumDriver


class SeleniumFacebookScrapper(BaseSeleniumDriver):
    def __init__(self):
        super().__init__()

    def fetch_data(self, url):
        self.setup_driver()
        self.get(url)

        data_element = self.find_element(By.TAG_NAME, 'body')
        data = json.loads(data_element.text)

        self.quit()

        return data

    def save_to_file(self, data, filename):
        with open(filename, 'w') as f:
            json.dump(data, f)

# URL bạn muốn truy cập
url = "https://graph.facebook.com/100057815212669/posts?access_token=EAAGNO4a7r2wBAHLhOE76tmZCI194vsqyc6gf1CZARbCypbE6zHR4OIHAJTdIAYUwmZBBomWTDZCmbV5YPZCrDZANt1B5YxDlP9KcV66LRzZBm7SZCrebxYJHH6ATZA54wTvukBMCmMLrMG97eI1DwxZCB7ASlcL3Fzy33FteGsIBZCJN2mRKHRJq0I8"

scraper = SeleniumFacebookScrapper()

data = scraper.get_data(url)

# Lưu dữ liệu vào file json
with open('data.json', 'w') as f:
    json.dump(data, f)

scraper.close()
