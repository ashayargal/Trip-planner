import requests
import json
from flask import jsonify
import googlemaps

gmaps = googlemaps.Client(key='AIzaSyA--9vUmlsek7U7NsjGFXkMwJRIc9bUdq0')
#geoapi = 'https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyA--9vUmlsek7U7NsjGFXkMwJRIc9bUdq0'

start_geocode = gmaps.geocode('1600 Amphitheatre Parkway, Mountain View, CA')
start_latitude = (json.dumps(start_geocode[0]['geometry']['location']['lat'], indent=4))
start_longitude = (json.dumps(start_geocode[0]['geometry']['location']['lng'], indent=4))

end_geocode = gmaps.geocode('san jose state university')
end_latitude = (json.dumps(end_geocode[0]['geometry']['location']['lat'], indent=4))
end_longitude = (json.dumps(end_geocode[0]['geometry']['location']['lng'], indent=4))



url = 'https://api.uber.com//v1/estimates/price'
sort=True
indents=4

parameters = {
    'server_token': 'O2dVlmYXiHMaHrULveKNRQC-2_HouwMLTnxG9q-S',
    'start_latitude': start_latitude,
    'end_latitude': end_latitude,
    'start_longitude':start_longitude,
    'end_longitude': end_longitude
}

json_data = requests.get(url, params=parameters).json()


f = open('out.txt', 'w')

min_obj= min(json_data["prices"],key= lambda ev:ev['low_estimate'])
resp = json.dumps(json_data['prices'][0]['estimate'], sort_keys=True, indent=4)
print ('Estimated Lowest price for uber : '+resp)

f.close()
