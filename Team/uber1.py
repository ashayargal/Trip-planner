# GET /v1/estimates/price
# Store and print json
# Create a server and test the application_uri(environ)
# Read API and gather additional details
# Make a document

import requests
import logging
import json
import jsontree
from collections import OrderedDict
from collections import namedtuple
#Prices= namedtuple('prices','currency_code,display_name,distance,duration,estimate,high_estimate,low_estimate,surge_multiplier,product_id,localized_display_name,minimum')

#temp = OrderedDict()
url = 'https://api.uber.com//v1/estimates/price'
sort=True
indents=4

parameters = {
    'server_token': 'O2dVlmYXiHMaHrULveKNRQC-2_HouwMLTnxG9q-S',
    'start_latitude': 37.338208,
    'end_latitude': 37.774929,
    'start_longitude':-121.886329,
    'end_longitude': -122.419416
}

json_data = requests.get(url, params=parameters).json()
print json.dumps(min_obj, sort_keys=sort, indent=indents)
#data=jsontree.loads(json_data);
f = open('out.txt', 'w')
#print >> f,json.dumps(json_data, sort_keys=sort, indent=indents) 

#prices=[Prices(**k) for k in json_data["prices"]]


#print >> f, json.dumps(prices,sort_keys=sort,indent=indents)
#print >> f, json.dumps(prices[6])

#print(json.dumps(data, sort_keys=sort, indent=indents))
#prices=json_data["prices"]
#print min(prices["high_estimate"])
min_obj= min(json_data["prices"],key= lambda ev:ev['low_estimate'])
print >> f,json.dumps(min_obj, sort_keys=sort, indent=indents)

f.close()
