import requests
import json

import googlemaps

gmaps = googlemaps.Client(key='AIzaSyA--9vUmlsek7U7NsjGFXkMwJRIc9bUdq0')
# geoapi = 'https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyA--9vUmlsek7U7NsjGFXkMwJRIc9bUdq0'
start_location = '1600 Amphitheatre Parkway, Mountain View, CA'
start_geocode = gmaps.geocode(start_location)
start_latitude = (json.dumps(start_geocode[0]['geometry']['location']['lat'], indent=4))
start_longitude = (json.dumps(start_geocode[0]['geometry']['location']['lng'], indent=4))

end_location = 'san jose state university'
end_geocode = gmaps.geocode(end_location)
end_latitude = (json.dumps(end_geocode[0]['geometry']['location']['lat'], indent=4))
end_longitude = (json.dumps(end_geocode[0]['geometry']['location']['lng'], indent=4))

print('Starting location : ' + start_location)
print('final destination : ' + end_location)

### lyft
headers_lyft = {
    "Authorization": "bearer " + "gAAAAABYQLOc7dRiJIkl7YPOBrv7lSI4yZ0Zy2ybntDy3ZIitCsVHD6YTs751NHNLGOijqLQoElTTbmtZP6ZQ6AEWMmpr9TCoJ-FYxKi8DcCJGYghZaGaLUpo6ECwe13LwV-ilqDbJC7DxiUrSNLSiwNrfkOpBwiY743mGg4bJLwBE2Fv-7gDcU="}
parameters_lyft = {"start_lat": start_latitude, "start_lng": start_longitude, "end_lat": end_latitude,
                   "end_lng": end_longitude}

sort = True
indents = 4

# Make a get request with the parameters.
json_data_lyft = requests.get("https://api.lyft.com/v1/cost", params=parameters_lyft, headers=headers_lyft).json()
lyft_max = json.dumps(json_data_lyft['cost_estimates'][1]['estimated_cost_cents_max'], indent=4)
lyft_max = float(lyft_max) / 100

lyft_min = (json.dumps(json_data_lyft['cost_estimates'][1]['estimated_cost_cents_min'], indent=4))
lyft_min = float(lyft_min) / 100

#print('estimated price for lyft line : $' + str(lyft_min) + '-' + str(lyft_max))

# g = open('lyft.txt', 'w')
#
# g.close()




### uber
url = 'https://api.uber.com//v1/estimates/price'
sort = True
indents = 4

parameters = {
    'server_token': 'O2dVlmYXiHMaHrULveKNRQC-2_HouwMLTnxG9q-S',
    'start_latitude': start_latitude,
    'end_latitude': end_latitude,
    'start_longitude': start_longitude,
    'end_longitude': end_longitude
}

uber_json_data = requests.get(url, params=parameters).json()

# f = open('out.txt', 'w')

min_obj = min(uber_json_data["prices"], key=lambda ev: ev['high_estimate'])
resp = json.dumps(uber_json_data['prices'][0]['estimate'], sort_keys=True, indent=4)
#print ('estimated price for uber pool : ' + resp)
# print(json.dumps(json_data_lyft, indent=4))
# print json.dumps(json_data_lyft['cost_estimates'][1], indent=4)
final = {"providers":[{"name": min_obj["display_name"], "maximum_costs_by_cheapest_car_types": min_obj["high_estimate"],
         'currency_code': min_obj['currency_code'],
         'total_duration': min_obj['duration'],
         'duration_unit': 'seconds',
         'total_distance': min_obj['distance'],
         'distance_unit': 'mile'}, {"name": json_data_lyft['cost_estimates'][1]['ride_type'], "maximum_costs_by_cheapest_car_types": lyft_max,
                                    'currency_code': json_data_lyft['cost_estimates'][1]['currency'],
                                    'total_duration': json_data_lyft['cost_estimates'][1]['estimated_duration_seconds'],
                                    'duration_unit': 'seconds',
                                    'total_distance': json_data_lyft['cost_estimates'][1]['estimated_distance_miles'],
                                    'distance_unit': 'mile'}]}
# uber_final = json.loads(uber_final)
# lyft_final = json.loads(lyft_final)
# print uber_final
# print lyft_final
final = json.dumps(final, indent=4)
print (final)
