import requests
import json
from sqlalchemy import *
from sqlalchemy import table, column, select, true, update, insert
import googlemaps
from googlemaps import convert
from sqlalchemy.orm import mapper, sessionmaker, create_session
from flask import Flask, request, flash, url_for, redirect, render_template,jsonify
from flask_cors import CORS, cross_origin
from flaskext.mysql import MySQL
from flask_sqlalchemy import SQLAlchemy
import MySQLdb

# trip_id = 1
trip_name = 'sanjose'

gmaps = googlemaps.Client(key='AIzaSyA--9vUmlsek7U7NsjGFXkMwJRIc9bUdq0')
gmaps_directions = googlemaps.Client(key='AIzaSyDkPohgHqVLp0iaqYl7YpjgSQ6RbXViL4U')
complete_trip = []

db = create_engine('mysql+pymysql://root@localhost/googlemaps')
db.echo = False
Session = sessionmaker(bind=db)

session = Session()
metadata = MetaData(db)
locations = Table('locations', metadata, autoload=True)
estimate = Table('provider_estimate', metadata, autoload=True)



class Location(object):
    pass


class Estimate(object):
    pass


locationmapper = mapper(Location, locations)
estimatemapper = mapper(Estimate, estimate)


session = create_session()

# def extract(stmt,column):
#     rs = stmt.execute()
#     for row in rs:
#         return row[column]


def get_addr(query):
    rs = query.execute()
    for row in rs:
        complete_trip.append(row[2])


s = locations.select(locations.c.trip_name == trip_name).order_by(locations.c.trip_order)
get_addr(s)
# print complete_trip
waypoints = complete_trip[:]
del waypoints[0]
del waypoints[-1]
# print complete_trip[0]
print waypoints
# print complete_trip[len(complete_trip)-1]
def directions(client, origin, destination,
               mode=None, waypoints=None, alternatives=False, avoid=None,
               language=None, units=None, region=None, departure_time=None,
               arrival_time=None, optimize_waypoints=True, transit_mode=None,
               transit_routing_preference=None, traffic_model=None):

    params = {
        "origin": convert.latlng(origin),
        "destination": convert.latlng(destination)
    }

    if mode:
        # NOTE(broady): the mode parameter is not validated by the Maps API
        # server. Check here to prevent silent failures.
        if mode not in ["driving", "walking", "bicycling", "transit"]:
            raise ValueError("Invalid travel mode.")
        params["mode"] = mode

    if waypoints:
        waypoints = convert.location_list(waypoints)
        if optimize_waypoints:
            waypoints = "optimize:true|" + waypoints
        params["waypoints"] = waypoints

    if alternatives:
        params["alternatives"] = "true"

    if avoid:
        params["avoid"] = convert.join_list("|", avoid)

    if language:
        params["language"] = language

    if units:
        params["units"] = units

    if region:
        params["region"] = region

    if departure_time:
        params["departure_time"] = convert.time(departure_time)

    if arrival_time:
        params["arrival_time"] = convert.time(arrival_time)

    if departure_time and arrival_time:
        raise ValueError("Should not specify both departure_time and"
                         "arrival_time.")

    if transit_mode:
        params["transit_mode"] = convert.join_list("|", transit_mode)

    if transit_routing_preference:
        params["transit_routing_preference"] = transit_routing_preference

    if traffic_model:
        params["traffic_model"] = traffic_model

    return client._get("/maps/api/directions/json", params)["routes"][0]['waypoint_order']
r = directions(gmaps_directions,complete_trip[0],complete_trip[len(complete_trip)-1],waypoints=waypoints)
orig_addr = complete_trip[0]
dest_addr = complete_trip[len(complete_trip)-1]

print(r)



total_cost_uber = 0
total_cost_lyft = 0
total_distance_uber = 0
total_distance_lyft = 0
total_time_uber = 0
total_time_lyft = 0

# for i in range(len(complete_trip)):
#     if i + 1 < len(complete_trip):
#         print '*** trip {} ***'.format(i + 1)
#
#         start_location = complete_trip[i]
#         start_geocode = gmaps.geocode(start_location)
#         start_latitude = (json.dumps(start_geocode[0]['geometry']['location']['lat'], indent=4))
#         start_longitude = (json.dumps(start_geocode[0]['geometry']['location']['lng'], indent=4))
#
#         end_location = complete_trip[i + 1]
#         end_geocode = gmaps.geocode(end_location)
#         end_latitude = (json.dumps(end_geocode[0]['geometry']['location']['lat'], indent=4))
#         end_longitude = (json.dumps(end_geocode[0]['geometry']['location']['lng'], indent=4))
#
#         # print('Starting location : ' + start_location)
#         # print('final destination : ' + end_location)
#
#         ### lyft
#         headers_lyft = {
#             "Authorization": "bearer " + "gAAAAABYQLOc7dRiJIkl7YPOBrv7lSI4yZ0Zy2ybntDy3ZIitCsVHD6YTs751NHNLGOijqLQoElTTbmtZP6ZQ6AEWMmpr9TCoJ-FYxKi8DcCJGYghZaGaLUpo6ECwe13LwV-ilqDbJC7DxiUrSNLSiwNrfkOpBwiY743mGg4bJLwBE2Fv-7gDcU="}
#         parameters_lyft = {"start_lat": start_latitude, "start_lng": start_longitude, "end_lat": end_latitude,
#                            "end_lng": end_longitude}
#
#         sort = True
#         indents = 4
#
#         # Make a get request with the parameters.
#         json_data_lyft = requests.get("https://api.lyft.com/v1/cost", params=parameters_lyft,
#                                       headers=headers_lyft).json()
#         lyft_max = json.dumps(json_data_lyft['cost_estimates'][1]['estimated_cost_cents_max'], indent=4)
#         lyft_max = float(lyft_max) / 100
#
#         lyft_min = (json.dumps(json_data_lyft['cost_estimates'][1]['estimated_cost_cents_min'], indent=4))
#         lyft_min = float(lyft_min) / 100
#
#         ### uber
#         url = 'https://api.uber.com//v1/estimates/price'
#         sort = True
#         indents = 4
#
#         parameters = {
#             'server_token': 'O2dVlmYXiHMaHrULveKNRQC-2_HouwMLTnxG9q-S',
#             'start_latitude': start_latitude,
#             'end_latitude': end_latitude,
#             'start_longitude': start_longitude,
#             'end_longitude': end_longitude
#         }
#
#         uber_json_data = requests.get(url, params=parameters).json()
#
#         min_obj = min(uber_json_data["prices"], key=lambda ev: ev['high_estimate'])
#         resp = json.dumps(uber_json_data['prices'][0]['estimate'], sort_keys=True, indent=4)
#         total_cost_uber += min_obj["high_estimate"]
#         total_cost_lyft += lyft_max
#         total_distance_uber += min_obj['distance']
#         total_distance_lyft += json_data_lyft['cost_estimates'][1]['estimated_distance_miles']
#         total_time_uber += min_obj['duration']
#         total_time_lyft += json_data_lyft['cost_estimates'][1]['estimated_duration_seconds']
#
#         final = {
#             "providers": [
#                 {"name": min_obj["display_name"], "maximum_costs_by_cheapest_car_types": min_obj["high_estimate"],
#                  'currency_code': min_obj['currency_code'],
#                  'total_duration': min_obj['duration'],
#                  'duration_unit': 'seconds',
#                  'total_distance': min_obj['distance'],
#                  'distance_unit': 'mile'}, {"name": json_data_lyft['cost_estimates'][1]['ride_type'],
#                                             "maximum_costs_by_cheapest_car_types": lyft_max,
#                                             'currency_code': json_data_lyft['cost_estimates'][1]['currency'],
#                                             'total_duration': json_data_lyft['cost_estimates'][1][
#                                                 'estimated_duration_seconds'],
#                                             'duration_unit': 'seconds',
#                                             'total_distance': json_data_lyft['cost_estimates'][1][
#                                                 'estimated_distance_miles'],
#                                             'distance_unit': 'mile'}]}
#
#         final = json.dumps(final, indent=4)
#         # print (final)
#
# total_time_lyft /= 60
# total_time_uber /= 60
#
# # new_estimate = provider_estimate(name='sanjose', trip_id=2, uber_cost=total_cost_uber, uber_duration=total_time_uber,
# #                                  uber_distance=total_distance_uber, lyft_cost=total_cost_lyft,
# #                                  lyft_dureation=total_time_lyft, lyft_distance=total_distance_lyft)
# #
# # session.add(new_estimate)
# # session.commit()
# i = estimate.insert()
# i.execute(name=trip_name, uber_cost=total_cost_uber, uber_duration=total_time_uber,
#           uber_distance=total_distance_uber, lyft_cost=total_cost_lyft,
#           lyft_duration=total_time_lyft, lyft_distance=total_distance_lyft)
#
# print 'total cost via uber is ${} and the distance is {} miles. The journey will take {} minutes' \
#     .format(total_cost_uber, total_distance_uber, total_time_uber)
# print 'total cost via lyft is ${} and the distance is {} miles. The journey will take {} minutes' \
#     .format(total_cost_lyft, total_distance_lyft, total_time_lyft)
