import requests
import json
from flask import jsonify
import googlemaps
from collections import OrderedDict
from collections import namedtuple


gmaps = googlemaps.Client(key='AIzaSyA--9vUmlsek7U7NsjGFXkMwJRIc9bUdq0')
#geoapi = 'https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyA--9vUmlsek7U7NsjGFXkMwJRIc9bUdq0'
start_location = '1600 Amphitheatre Parkway, Mountain View, CA'
start_geocode = gmaps.geocode(start_location)
start_latitude = (json.dumps(start_geocode[0]['geometry']['location']['lat'], indent=4))
start_longitude = (json.dumps(start_geocode[0]['geometry']['location']['lng'], indent=4))

end_location = 'san jose state university'
end_geocode = gmaps.geocode(end_location)
end_latitude = (json.dumps(end_geocode[0]['geometry']['location']['lat'], indent=4))
end_longitude = (json.dumps(end_geocode[0]['geometry']['location']['lng'], indent=4))

print('Starting location : '+start_location)
print('final destination : '+end_location)

### lyft
headers_lyft = {
    "Authorization": "bearer " + "gAAAAABYJq5fB3QX_UamA5MoMFAX0fA4VfHBZS45qAaR3yy9JjeYzZR7lSxbKZsxJW2HNJ88m77skhxQbkncg0LDzXuTI2NU2nj0gQ1MmLgSQXxxNC-mtDafM3nuBTXHUkzJDuOf822COBqmjUv-QsX-quYzh87k9ZvveQ-poz-eRtgVDPD8JP_2LbvdaOkfsYaO2oCgycoPtSkd8kW6P0QCZulylTjKQA=="}
parameters_lyft={"start_lat": start_latitude, "start_lng": start_longitude, "end_lat": end_latitude, "end_lng": end_longitude}

sort=True
indents=4

# Make a get request with the parameters.
json_data_lyft = requests.get("https://api.lyft.com/v1/cost", params=parameters_lyft, headers=headers_lyft).json()
lyft_max = json.dumps(json_data_lyft['cost_estimates'][1]['estimated_cost_cents_max'], indent=4)
lyft_max = float(lyft_max)/100

lyft_min = (json.dumps(json_data_lyft['cost_estimates'][1]['estimated_cost_cents_min'], indent=4))
lyft_min = float(lyft_min)/100

print('estimated price for lyft line : $'+str(lyft_min)+'-'+str(lyft_max))

# g = open('lyft.txt', 'w')
#
# g.close()




### uber
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


#f = open('out.txt', 'w')

min_obj= min(json_data["prices"],key= lambda ev:ev['high_estimate'])
resp = json.dumps(json_data['prices'][0]['estimate'], sort_keys=True, indent=4)
print ('estimated price for uber pool : '+resp)

#f.close()
