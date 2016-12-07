from flask import Flask, request, flash, url_for, redirect, render_template, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_api import status
from sqlalchemy.inspection import inspect
from flaskext.mysql import MySQL
from sqlalchemy import exc
from sqlalchemy.orm.exc import NoResultFound
import time
import requests
from flask_cors import CORS, cross_origin
import requests
import json
from sqlalchemy import *
from sqlalchemy import table, column, select, true, update, insert
import googlemaps
from googlemaps import convert
from sqlalchemy.orm import mapper, sessionmaker, create_session
from flask import Flask, request, flash, url_for, redirect, render_template, jsonify
from flask_cors import CORS, cross_origin
from flaskext.mysql import MySQL
from flask_sqlalchemy import SQLAlchemy
import MySQLdb

app = Flask(__name__)
CORS(app)

app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_DB'] = 'googlemaps'
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+pymysql://root@localhost/googlemaps'

# app.config['SECRET_KEY']='ash'
db = SQLAlchemy(app)
# engine = create_engine('mysql+pymysql://root:admin@172.17.0.3/CMPE273')
# conn=engine.connect();


geocode_url = 'http://maps.google.com/maps/api/geocode/json'

gmaps = googlemaps.Client(key='AIzaSyA--9vUmlsek7U7NsjGFXkMwJRIc9bUdq0')
gmaps_directions = googlemaps.Client(key='AIzaSyDkPohgHqVLp0iaqYl7YpjgSQ6RbXViL4U')
complete_trip = []

dba = create_engine('mysql+pymysql://root@localhost/googlemaps')
dba.echo = False
Session = sessionmaker(bind=dba)

session = Session()
metadata = MetaData(dba)
locati = Table('locations', metadata, autoload=True)
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


@app.route('/trips', methods=['POST'])

def api_call():
    args = request.get_json(force=True)
    name = args['name']
    print name
    s = locati.select(locati.c.trip_name == name).order_by(locati.c.trip_order)
    get_addr(s)
    total_cost_uber = 0
    total_cost_lyft = 0
    total_distance_uber = 0
    total_distance_lyft = 0
    total_time_uber = 0
    total_time_lyft = 0
    for i in range(len(complete_trip)):
        if i + 1 < len(complete_trip):
            print '*** trip {} api call***'.format(i + 1)

            start_location = complete_trip[i]
            start_geocode = gmaps.geocode(start_location)
            start_latitude = (json.dumps(start_geocode[0]['geometry']['location']['lat'], indent=4))
            start_longitude = (json.dumps(start_geocode[0]['geometry']['location']['lng'], indent=4))

            end_location = complete_trip[i + 1]
            end_geocode = gmaps.geocode(end_location)
            end_latitude = (json.dumps(end_geocode[0]['geometry']['location']['lat'], indent=4))
            end_longitude = (json.dumps(end_geocode[0]['geometry']['location']['lng'], indent=4))

            # print('Starting location : ' + start_location)
            # print('final destination : ' + end_location)

            ### lyft
            headers_lyft = {
                "Authorization": "bearer " + "gAAAAABYQLOc7dRiJIkl7YPOBrv7lSI4yZ0Zy2ybntDy3ZIitCsVHD6YTs751NHNLGOijqLQoElTTbmtZP6ZQ6AEWMmpr9TCoJ-FYxKi8DcCJGYghZaGaLUpo6ECwe13LwV-ilqDbJC7DxiUrSNLSiwNrfkOpBwiY743mGg4bJLwBE2Fv-7gDcU="}
            parameters_lyft = {"start_lat": start_latitude, "start_lng": start_longitude, "end_lat": end_latitude,
                               "end_lng": end_longitude}

            sort = True
            indents = 4

            # Make a get request with the parameters.
            json_data_lyft = requests.get("https://api.lyft.com/v1/cost", params=parameters_lyft,
                                          headers=headers_lyft).json()
            lyft_max = json.dumps(json_data_lyft['cost_estimates'][1]['estimated_cost_cents_max'], indent=4)
            lyft_max = float(lyft_max) / 100

            lyft_min = (json.dumps(json_data_lyft['cost_estimates'][1]['estimated_cost_cents_min'], indent=4))
            lyft_min = float(lyft_min) / 100

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

            min_obj = min(uber_json_data["prices"], key=lambda ev: ev['high_estimate'])
            resp = json.dumps(uber_json_data['prices'][0]['estimate'], sort_keys=True, indent=4)
            total_cost_uber += min_obj["high_estimate"]
            total_cost_lyft += lyft_max
            total_distance_uber += min_obj['distance']
            total_distance_lyft += json_data_lyft['cost_estimates'][1]['estimated_distance_miles']
            total_time_uber += min_obj['duration']
            total_time_lyft += json_data_lyft['cost_estimates'][1]['estimated_duration_seconds']

            final = {
                "providers": [
                    {"name": min_obj["display_name"], "maximum_costs_by_cheapest_car_types": min_obj["high_estimate"],
                     'currency_code': min_obj['currency_code'],
                     'total_duration': min_obj['duration'],
                     'duration_unit': 'seconds',
                     'total_distance': min_obj['distance'],
                     'distance_unit': 'mile'}, {"name": json_data_lyft['cost_estimates'][1]['ride_type'],
                                                "maximum_costs_by_cheapest_car_types": lyft_max,
                                                'currency_code': json_data_lyft['cost_estimates'][1]['currency'],
                                                'total_duration': json_data_lyft['cost_estimates'][1][
                                                    'estimated_duration_seconds'],
                                                'duration_unit': 'seconds',
                                                'total_distance': json_data_lyft['cost_estimates'][1][
                                                    'estimated_distance_miles'],
                                                'distance_unit': 'mile'}]}

            final = json.dumps(final, indent=4)
            # print (final)

    total_time_lyft /= 60
    total_time_uber /= 60
    i = estimate.insert()
    i.execute(name=name, uber_cost=total_cost_uber, uber_duration=total_time_uber,
              uber_distance=total_distance_uber, lyft_cost=total_cost_lyft,
              lyft_duration=total_time_lyft, lyft_distance=total_distance_lyft)

    return 0


if __name__ == "__main__":
    # time.sleep(120)
    #	CreateDB()
    db.create_all()
    app.run(debug=True, host='localhost', port=5002)