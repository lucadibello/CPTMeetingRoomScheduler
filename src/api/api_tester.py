import requests
_TOKEN = "058c24b04169e44528ff2be1ac83f5dd787aa2109ad64fdcf142538f4d8617b5832e532a7c4a004398c3a3b4f12d1eac47423680fd71c02105d33c77cae12d5d"
r = requests.post("http://localhost:8080/api/calendar", data={'token': _TOKEN})
print("Server response:")
print(r.text)