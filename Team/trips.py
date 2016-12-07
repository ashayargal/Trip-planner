from flask import Flask, request, flash, url_for, redirect, render_template,jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_api import status
from sqlalchemy.inspection import inspect
from flaskext.mysql import MySQL
from sqlalchemy import exc
from sqlalchemy.orm.exc import NoResultFound
import time
import requests
from flask_cors import CORS, cross_origin



#from sqlalchemy import create_engine

app = Flask(__name__)
CORS(app)

app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_DB'] = 'googlemaps'
app.config['SQLALCHEMY_DATABASE_URI']='mysql+pymysql://root@localhost/googlemaps'

#app.config['SECRET_KEY']='ash'
db=SQLAlchemy(app)
#engine = create_engine('mysql+pymysql://root:admin@172.17.0.3/CMPE273')
#conn=engine.connect();


geocode_url= 'http://maps.google.com/maps/api/geocode/json'

class Serializer(object):
	@staticmethod
	def serialize(object):
		return {c: getattr(object, c) for c in inspect(object).attrs.keys()}

	@staticmethod
	def serialize_list(l):
		return [m.serialize() for m in l]

class locations(db.Model):
    id=db.Column('id',db.Integer, autoincrement=True,primary_key=True)
    name=db.Column('name',db.String(50))
    address=db.Column('address',db.String(100))
    city=db.Column('city',db.String(20))
    state=db.Column('state',db.String(10))
    zip=db.Column('zip',db.String(6))
    latitude=db.Column('latitude',db.Numeric(asdecimal=False))
    longitude=db.Column('longitude',db.Numeric(asdecimal=False))
    trip_order=db.Column('trip_order',db.Integer)
    trip_name=db.Column('trip_name',db.String(45))

    def serialize(self):
            d = Serializer.serialize(self)
            return d

    def __init__(self,name,address,city,state,zip,latitude,longitude,trip_order,trip_name):
        if name is not None:
                self.name= name
        if address is not None:
                    self.address=address
        if city is not None:
                self.city=city
        if state is not None:
                self.state=state
        if zip is not None:
                self.zip=zip
        if latitude is not None:
                self.latitude=latitude
        if longitude is not None:
                self.longitude=longitude
        if trip_order is not None:
                self.trip_order=trip_order
        if trip_name is not None:
                self.trip_name=trip_name

    @app.route('/trips',methods=['POST'])
    def save_locations():
            
                args=request.get_json(force=True)
            
                name= args.get('name')
                #print name

                location_id= args.get('location_id')
                print 'Name:' + name
                print 'Location:'+ location_id

                old_location=locations.query.filter_by(id = int(location_id)).first()
                #print old_location.name
                new_location=locations(name=None,address=None,city=None,state=None,zip=None,latitude=None,longitude=None,trip_order=1,trip_name=name)
                #print new_location.trip_name
                
                copy_location(old_location,new_location)
                #print old_location.name
                print old_location.trip_name
                db.session.commit()
                return jsonify('OK'),status.HTTP_201_CREATED,{'Content-Type': 'application/json'}

    @app.route('/trips/<int:trip_id>', methods = ['PUT'])
    def edit_location(trip_id):
            try:
                args=request.get_json(force=True)
                #pos= getPosition(args)
              
                old_trip=trips.query.filter_by(id = trip_id).first()
                new_trip=trips(name=args.get('name'),location_id=args.get('location_id'),is_start=args.get('is_start'),is_end=args.get('is_end'))
                copy_trip(old_trip, new_trip)
                db.session.commit()
                return '',status.HTTP_202_ACCEPTED,{'Content-Type': 'application/json'}
            except AttributeError:
                return 'No such trip found',status.HTTP_404_NOT_FOUND,{'Content-Type': 'application/json'}


    @app.route('/trips/<int:trip_id>', methods = ['DELETE'])
    def delete_trip(trip_id):
            try:
                trip=trips.query.filter_by(id = trip_id)
                db.session.delete(trip.first())
                db.session.commit()
                return '',status.HTTP_204_NO_CONTENT,{'Content-Type': 'application/json'}
            except exc.SQLAlchemyError:
                    return 'No such location found',status.HTTP_404_NOT_FOUND,{'Content-Type': 'application/json'}

    @app.route('/trips/<int:trip_id>',methods=['GET'])
    def show_one(trip_id):
            try:
        #return render_template('show_one.html',expenses=expenses.query.filter_by(id=expense_id))
                trip=trips.query.filter_by(id=trip_id).first()
                return jsonify(Serializer.serialize(trip)),status.HTTP_200_OK,{'Content-Type': 'application/json'}
            except exc.SQLAlchemyError:
                return 'No such location found',status.HTTP_404_NOT_FOUND,{'Content-Type': 'application/json'}

def copy_location(old_location,new_location):
            print 'Inside copy'
            print old_location.name
            print old_location.city 
            old_location.trip_name=new_location.trip_name
    

if __name__ == "__main__":
	#time.sleep(120)
#	CreateDB()    	
	db.create_all()
	app.run(debug=True,host='localhost',port=5001)