import mysql.connector
import json
from concurrent.futures import ThreadPoolExecutor
from selenium.webdriver.common.by import By
from Base import BaseSeleniumDriver


class MySQLConnection:
    def __init__(self, host='127.0.0.1', port='3306', user='root', password='', database='facebook'):
        self.cnx = mysql.connector.connect(
            host=host,
            port=port,
            user=user,
            password=password,
            database=database
        )
        self.cursor = self.cnx.cursor(dictionary=True)

    def get_accounts(self):
        query = "SELECT * FROM accounts"
        self.cursor.execute(query)
        return self.cursor.fetchall()

    def update_account_status(self, account_id, status, cookies=None):
        query = f"UPDATE accounts SET status = '{status}'"
        if cookies:
            query += f", cookie = '{cookies}'"
        query += f" WHERE id = {account_id}"
        self.cursor.execute(query)
        self.cnx.commit()

    def close(self):
        self.cursor.close()
        self.cnx.close()


class checkAccount(BaseSeleniumDriver):
    def __init__(self, email, password, position, browser_options=None):
        super().__init__(browser_options)
        self.email = email
        self.password = password
        self.setup_driver()
        # Set window size to mobile size
        self.driver.set_window_size(360, 640)

        # Position the window
        self.driver.set_window_position(position[0], position[1])

    def login(self):
        self.get("https://mbasic.facebook.com/")
        email_input = self.find_element(By.NAME, "email")
        self.mimic_human_typing(email_input, self.email)

        password_input = self.find_element(By.NAME, "pass")
        self.mimic_human_typing(password_input, self.password)

        login_button = self.find_element(By.NAME, "login")
        self.click_element(login_button)
        self.random_delay(min_delay=2, max_delay=5)

        if "save-device" in self.driver.current_url:
            self.driver.execute_script(
                'document.querySelector("#root > table > tbody > tr > td > div > form > div > input").click();')
            self.random_delay(min_delay=2, max_delay=5)
            print("Login successful")
            return True, self.driver.get_cookies()
        else:
            print("Login failed")
            return False, None


def handle_account(account, position):
    fb = checkAccount(account['account'], account['password'], position)
    logged_in, cookies = fb.login()
    print(cookies)
    if logged_in:
        db = MySQLConnection()
        db.update_account_status(account['id'], 'active', json.dumps(cookies))
        db.close()
    fb.quit()


# Main script
db = MySQLConnection()
accounts = db.get_accounts()
db.close()

positions = [(i * 400, 0) for i in
             range(len(accounts))]  # each new window will be 400px to the right of the previous one
with ThreadPoolExecutor(max_workers=5) as executor:  # limit max concurrent tasks to 5
    executor.map(handle_account, accounts, positions)
