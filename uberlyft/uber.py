# GET /v1/estimates/price
# Store and print json
# Create a server and test the application_uri(environ)
# Read API and gather additional details
# Make a document

import requests
import logging
import json

from collections import namedtuple

url = 'https://api.uber.com//v1/estimates/price'
sort=True
indents=4
Prices= namedtuple('prices','currency_code','display_name','distance','duration','estimate','high_estimate','low_estimate','surge_multiplier')


parameters = {
    'server_token': 'O2dVlmYXiHMaHrULveKNRQC-2_HouwMLTnxG9q-S',
    'start_latitude': 37.338208,
    'end_latitude': 37.774929,
    'start_longitude':-121.886329,
    'end_longitude': -122.419416
}


response = requests.get(url, params=parameters)

data = response.json()

f = open('out.txt', 'w')
print >> f,json.dumps(data, sort_keys=sort, indent=indents) 
f.close()

prices=[Prices(**k) for k in data["prices"]]


print min(prices['high_estimate'])
#print(json.dumps(data, sort_keys=sort, indent=indents))

