import requests
import os

url = "http://192.168.56.135:2009/profile.php/?id="

i = 100


def save_file_at_dir(dir_path, filename, file_content, mode='w'):
    os.makedirs(dir_path, exist_ok=True)
    with open(os.path.join(dir_path, filename), mode, encoding="utf-8") as f:
        f.write(file_content)


def login(url):
    data = {"uname": "test", "pw": "123"}
    req = requests.post(url, data=data)
    return req


for i in range(100):

    req = requests.get(
        url + str(i), cookies=login("http://192.168.56.135:2009/login.php").cookies)
    if "NOT FOUND" not in req.text:
        save_file_at_dir("./data", str(i)+".html", req.text)
        print(url + str(i))
