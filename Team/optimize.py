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


session = create_session()

def get_addr(query):
    rs = query.execute()
    for row in rs:
        complete_trip.append(row[2])

def optimize(trip_name):


    s = locations.select(locations.c.trip_name == trip_name).order_by(locations.c.trip_order)
    get_addr(s)
    waypoints = complete_trip[:]
    del waypoints[0]
    del waypoints[-1]
    # print complete_trip[0]
    # print waypoints

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

    r = directions(gmaps_directions, complete_trip[0], complete_trip[len(complete_trip) - 1], waypoints=waypoints)
    orig_addr = complete_trip[0]
    dest_addr = complete_trip[len(complete_trip) - 1]

   for i in range(len(r)):
    r[i] += 2
  r.insert(0,1)
  r.append(len(r)+1)
  print(r)
