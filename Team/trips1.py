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

#app.config['SQLALCHEMY_DATABASE_URI']='sqlite:///expenses.sqlite3'
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_DB'] = 'googlemaps'
#app.config['SQLALCHEMY_DATABASE_URI']='mysql+pymysql://root:admin@172.17.0.2/cmpe273'
app.config['SQLALCHEMY_DATABASE_URI']='mysql+pymysql://root:admin@localhost/googlemaps'

#app.config['SECRET_KEY']='ash'
db=SQLAlchemy(app)
#engine = create_engine('mysql+pymysql://root:admin@172.17.0.3/CMPE273')
#conn=engine.connect();

#query="""CREATE TABLE expenses (  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50), email VARCHAR(30),category VARCHAR(20),
#		"description VARCHAR(50),link VARCHAR(50),
#		"estimated_costs VARCHAR(50), submit_date VARCHAR(50), status VARCHAR(50),decision_date VARCHAR(50));"""

#class CreateDB(): 
#	def __init__(self): 
#				import sqlalchemy 
#				engine=sqlalchemy.create_engine('mysql+pymysql://root:admin@172.17.0.2/cmpe273')  
#				engine.execute("CREATE DATABASE IF NOT EXISTS %s "%("expenses")) 
				#engine.execute(query)
geocode_url= 'http://maps.google.com/maps/api/geocode/json'

class Serializer(object):
	@staticmethod
	def serialize(object):
		return {c: getattr(object, c) for c in inspect(object).attrs.keys()}

	@staticmethod
	def serialize_list(l):
		return [m.serialize() for m in l]

class trips(db.Model):
    id=db.Column('id',db.Integer, autoincrement=True,primary_key=True)
    name=db.Column('name',db.String(50))
    location_id=db.Column('location_id',db.Integer())
    is_start=db.Column('is_start',db.Boolean())
    is_end=db.Column('is_end',db.Boolean())
    
    def serialize(self):
            d = Serializer.serialize(self)
            return d

    def __init__(self,name,location_id,is_start,is_end):
        if name is not None:
                self.name= name
        if location_id is not None:
                    self.location_id=location_id
        if is_start is not None:
                self.is_start=is_start
        if is_end is not None:
                self.is_end=is_end
        
	
    @app.route('/trips',methods=['POST'])
    def save_locations():
            
                #args=request.args
                args=request.get_json(force=True)
                #args=request.data
                
                #pos= getPosition(args)
                print args.get('name')
                print args.get('is_start')
                print args.get('is_end')
                print args.get('location_id')

                trip=trips(name=args.get('name'),location_id=args.get('location_id'),is_start=args.get('is_start'),is_end=args.get('is_end'))
                
                db.session.add(trip)
                db.session.commit()
                return jsonify(trip.serialize()),status.HTTP_201_CREATED,{'Content-Type': 'application/json'}

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

def copy_trip(old_trip,new_trip):
    if new_trip.name is not None:
            old_trip.name= new_trip.name
    if new_trip.location_id is not None:
            old_trip.location_id=new_trip.location_id
    if new_trip.is_start is not None:
            old_trip.is_start=new_trip.is_start
    if new_trip.is_end is not None:
            old_trip.is_end=new_trip.is_end
    

if __name__ == "__main__":
	#time.sleep(120)
#	CreateDB()    	
	db.create_all()
	app.run(debug=True,host='localhost',port=5001)