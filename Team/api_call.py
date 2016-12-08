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

# from sqlalchemy import create_engine

app = Flask(__name__)
CORS(app)
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_DB'] = 'googlemaps'
app.config['SQLALCHEMY_DATABASE_URI']='mysql+pymysql://root@localhost/googlemaps'
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
    c_trip = []
    rs = query.execute()
    for row in rs:
        c_trip.append(row[2])
    return c_trip


def optimize(trip_name):
    s = locati.select(locati.c.trip_name == trip_name).order_by(locati.c.trip_order)
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
    r.insert(0, 1)
    r.append(len(r) + 1)
    print(r)

    # new_estimate = provider_estimate(name='sanjose', trip_id=2, uber_cost=total_cost_uber, uber_duration=total_time_uber,
    #                                  uber_distance=total_distance_uber, lyft_cost=total_cost_lyft,
    #                                  lyft_dureation=total_time_lyft, lyft_distance=total_distance_lyft)
    #
    # session.add(new_estimate)
    # session.commit()



class Serializer(object):
    @staticmethod
    def serialize(object):
        return {c: getattr(object, c) for c in inspect(object).attrs.keys()}

    @staticmethod
    def serialize_list(l):
        return [m.serialize() for m in l]


class locations(db.Model):
    id = db.Column('id', db.Integer, autoincrement=True, primary_key=True)
    name = db.Column('name', db.String(50))
    address = db.Column('address', db.String(100))
    city = db.Column('city', db.String(20))
    state = db.Column('state', db.String(10))
    zip = db.Column('zip', db.String(6))
    latitude = db.Column('latitude', db.Numeric(asdecimal=False))
    longitude = db.Column('longitude', db.Numeric(asdecimal=False))
    trip_order = db.Column('trip_order', db.Integer)
    trip_name = db.Column('trip_name', db.String(45))

    def serialize(self):
        d = Serializer.serialize(self)
        return d

    def __init__(self, name, address, city, state, zip, latitude, longitude, trip_order, trip_name):
        if name is not None:
            self.name = name
        if address is not None:
            self.address = address
        if city is not None:
            self.city = city
        if state is not None:
            self.state = state
        if zip is not None:
            self.zip = zip
        if latitude is not None:
            self.latitude = latitude
        if longitude is not None:
            self.longitude = longitude
        if trip_order is not None:
            self.trip_order = trip_order
        if trip_name is not None:
            self.trip_name = trip_name

    @app.route('/trips', methods=['POST'])
    def save_locations():
        
        args = request.get_json(force=True)
        name = args['name']
        print name
        s = locati.select(locati.c.trip_name == name).order_by(locati.c.trip_order)
        comp_trip = get_addr(s)
        print comp_trip
        total_cost_uber = 0
        total_cost_lyft = 0
        total_distance_uber = 0
        total_distance_lyft = 0
        total_time_uber = 0
        total_time_lyft = 0

        # print complete_trip
        for i in range(len(comp_trip)):
            if i + 1 < len(comp_trip):
                print '*** trip {} api call***'.format(i + 1)

                start_location = comp_trip[i]
                start_geocode = gmaps.geocode(start_location)
                start_latitude = (json.dumps(start_geocode[0]['geometry']['location']['lat'], indent=4))
                start_longitude = (json.dumps(start_geocode[0]['geometry']['location']['lng'], indent=4))

                end_location = comp_trip[i + 1]
                end_geocode = gmaps.geocode(end_location)
                end_latitude = (json.dumps(end_geocode[0]['geometry']['location']['lat'], indent=4))
                end_longitude = (json.dumps(end_geocode[0]['geometry']['location']['lng'], indent=4))

                # print('Starting location : ' + start_location)
                # print('final destination : ' + end_location)

                ### lyft
                headers_lyft = {
                    "Authorization": "bearer " + "gAAAAABYQLOc7dRiJIkl7YPOBrv7lSI4yZ0Zy2ybntDy3ZIitCsVHD6YTs751NHNLGOijqLQoElTTbmtZP6ZQ6AEWMmpr9TCoJ-FYxKi8DcCJGYghZaGaLUpo6ECwe13LwV-ilqDbJC7DxiUrSNLSiwNrfkOpBwiY743mGg4bJLwBE2Fv-7gDcU="}
                parameters_lyft = {"start_lat": start_latitude, "start_lng": start_longitude,
                                   "end_lat": end_latitude,
                                   "end_lng": end_longitude}

                sort = True
                indents = 4

                # Make a get request with the parameters.
                json_data_lyft = requests.get("https://api.lyft.com/v1/cost", params=parameters_lyft,
                                              headers=headers_lyft).json()
                lyft_max = json.dumps(json_data_lyft['cost_estimates'][2]['estimated_cost_cents_max'], indent=4)
                lyft_max = float(lyft_max) / 100

                lyft_min = (json.dumps(json_data_lyft['cost_estimates'][2]['estimated_cost_cents_min'], indent=4))
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


                min_obj = uber_json_data["prices"][1]
                resp = json.dumps(uber_json_data['prices'][1]['estimate'], sort_keys=True, indent=4)

                total_cost_uber += min_obj["high_estimate"]
                total_cost_lyft += lyft_max
                total_distance_uber += min_obj['distance']
                total_distance_lyft += json_data_lyft['cost_estimates'][2]['estimated_distance_miles']
                total_time_uber += min_obj['duration']
                total_time_lyft += json_data_lyft['cost_estimates'][2]['estimated_duration_seconds']

                final = {
                    "providers": [
                        {"name": min_obj["display_name"],
                         "maximum_costs_by_cheapest_car_types": min_obj["high_estimate"],
                         'currency_code': min_obj['currency_code'],
                         'total_duration': min_obj['duration'],
                         'duration_unit': 'seconds',
                         'total_distance': min_obj['distance'],
                         'distance_unit': 'mile'}, {"name": json_data_lyft['cost_estimates'][2]['ride_type'],
                                                    "maximum_costs_by_cheapest_car_types": lyft_max,
                                                    'currency_code': json_data_lyft['cost_estimates'][2][
                                                        'currency'],
                                                    'total_duration': json_data_lyft['cost_estimates'][2][
                                                        'estimated_duration_seconds'],
                                                    'duration_unit': 'seconds',
                                                    'total_distance': json_data_lyft['cost_estimates'][2][
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


        return jsonify('OK'), status.HTTP_201_CREATED, {'Content-Type': 'application/json'}

    @app.route('/trips/<int:trip_id>', methods=['PUT'])
    def edit_location(trip_id):
        try:
            args = request.get_json(force=True)
            # pos= getPosition(args)

            old_trip = trips.query.filter_by(id=trip_id).first()
            new_trip = trips(name=args.get('name'), location_id=args.get('location_id'), is_start=args.get('is_start'),
                             is_end=args.get('is_end'))
            copy_trip(old_trip, new_trip)
            db.session.commit()
            return '', status.HTTP_202_ACCEPTED, {'Content-Type': 'application/json'}
        except AttributeError:
            return 'No such trip found', status.HTTP_404_NOT_FOUND, {'Content-Type': 'application/json'}

    @app.route('/trips/<int:trip_id>', methods=['DELETE'])
    def delete_trip(trip_id):
        try:
            trip = trips.query.filter_by(id=trip_id)
            db.session.delete(trip.first())
            db.session.commit()
            return '', status.HTTP_204_NO_CONTENT, {'Content-Type': 'application/json'}
        except exc.SQLAlchemyError:
            return 'No such location found', status.HTTP_404_NOT_FOUND, {'Content-Type': 'application/json'}

    @app.route('/trips/<int:trip_id>', methods=['GET'])
    def show_one(trip_id):
        try:
            # return render_template('show_one.html',expenses=expenses.query.filter_by(id=expense_id))
            trip = trips.query.filter_by(id=trip_id).first()
            return jsonify(Serializer.serialize(trip)), status.HTTP_200_OK, {'Content-Type': 'application/json'}
        except exc.SQLAlchemyError:
            return 'No such location found', status.HTTP_404_NOT_FOUND, {'Content-Type': 'application/json'}


def copy_location(old_location, new_location):
    print 'Inside copy'
    print old_location.name
    print old_location.city
    old_location.trip_name = new_location.trip_name


def api_call(trip_name):
    s = locati.select(locati.c.trip_name == trip_name).order_by(locati.c.trip_order)
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
            lyft_max = json.dumps(json_data_lyft['cost_estimates'][2]['estimated_cost_cents_max'], indent=4)
            lyft_max = float(lyft_max) / 100

            lyft_min = (json.dumps(json_data_lyft['cost_estimates'][2]['estimated_cost_cents_min'], indent=4))
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
            total_distance_lyft += json_data_lyft['cost_estimates'][2]['estimated_distance_miles']
            total_time_uber += min_obj['duration']
            total_time_lyft += json_data_lyft['cost_estimates'][2]['estimated_duration_seconds']

            final = {
                "providers": [
                    {"name": min_obj["display_name"], "maximum_costs_by_cheapest_car_types": min_obj["high_estimate"],
                     'currency_code': min_obj['currency_code'],
                     'total_duration': min_obj['duration'],
                     'duration_unit': 'seconds',
                     'total_distance': min_obj['distance'],
                     'distance_unit': 'mile'}, {"name": json_data_lyft['cost_estimates'][2]['ride_type'],
                                                "maximum_costs_by_cheapest_car_types": lyft_max,
                                                'currency_code': json_data_lyft['cost_estimates'][2]['currency'],
                                                'total_duration': json_data_lyft['cost_estimates'][2][
                                                    'estimated_duration_seconds'],
                                                'duration_unit': 'seconds',
                                                'total_distance': json_data_lyft['cost_estimates'][2][
                                                    'estimated_distance_miles'],
                                                'distance_unit': 'mile'}]}

            final = json.dumps(final, indent=4)
            # print (final)

    total_time_lyft /= 60
    total_time_uber /= 60


if __name__ == "__main__":
    # time.sleep(120)
    #	CreateDB()
    db.create_all()
    app.run(debug=True, host='localhost', port=5002)
