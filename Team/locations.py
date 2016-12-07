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
#from sqlalchemy.ext.declarative import DeclarativeMeta


#from sqlalchemy import create_engine

app = Flask(__name__)
CORS(app)

#app.config['SQLALCHEMY_DATABASE_URI']='sqlite:///expenses.sqlite3'
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_DB'] = 'googlemaps1'
#app.config['SQLALCHEMY_DATABASE_URI']='mysql+pymysql://root:admin@172.17.0.2/cmpe273'

app.config['SQLALCHEMY_DATABASE_URI']='mysql+pymysql://root:admin@localhost/googlemaps1'


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

class locations(db.Model):
    id=db.Column('id',db.Integer, autoincrement=True,primary_key=True)
    name=db.Column('name',db.String(50))
    address=db.Column('address',db.String(100))
    city=db.Column('city',db.String(20))
    state=db.Column('state',db.String(10))
    zip=db.Column('zip',db.String(6))
    lat=db.Column('latitude',db.Numeric(asdecimal=False))
    lon=db.Column('longitude',db.Numeric(asdecimal=False))

    def serialize(self):
            d = Serializer.serialize(self)
            return d

    def __init__(self,name,address,city,state,zip,lat,lon):
                self.name= name
                self.address=address
                self.city=city
                self.state=state
                self.zip=zip
                self.lat=lat
                self.lon=lon
    

	
    @app.route('/locations',methods=['POST','OPTIONS'])
    def save_locations():
            
                #args=request.args
                args=request.get_json(force=True)
                #args=request.data

                pos= getPosition(args)

                location=locations(name=args.get('name'),address=args.get('address'),city=args.get('city'),state=args.get('state'),zip=args.get('zip'),lat=pos['lat'],lon=pos['lng'])
                db.session.add(location)
                db.session.commit()
                return jsonify(location.serialize()),status.HTTP_201_CREATED,{'Content-Type': 'application/json'}

    @app.route('/locations/<int:location_id>', methods = ['PUT'])
    def edit_location(location_id):
            try:
                args=request.get_json(force=True)
                pos= getPosition(args)
              
                old_location=locations.query.filter_by(id = location_id).first()
                new_location=locations(name=args.get('name'),address=args.get('address'),city=args.get('city'),state=args.get('state'),zip=args.get('zip'),lat=pos['lat'],lon=pos['lng'])
                copy_location(old_location, new_location)
                db.session.commit()
                return '',status.HTTP_202_ACCEPTED,{'Content-Type': 'application/json'}
            except AttributeError:
                return 'No such location found',status.HTTP_404_NOT_FOUND,{'Content-Type': 'application/json'}


    @app.route('/locations/<int:location_id>', methods = ['DELETE'])
    def delete_location(location_id):
            try:
                location=locations.query.filter_by(id = location_id)
                db.session.delete(location.first())
                db.session.commit()
                return '',status.HTTP_204_NO_CONTENT,{'Content-Type': 'application/json'}
            except exc.SQLAlchemyError:
                    return 'No such location found',status.HTTP_404_NOT_FOUND,{'Content-Type': 'application/json'}

    @app.route('/locations/<int:location_id>',methods=['GET'])
    def show_one(location_id):
            try:
        #return render_template('show_one.html',expenses=expenses.query.filter_by(id=expense_id))
                location=locations.query.filter_by(id=location_id).first()
                return jsonify(Serializer.serialize(location)),status.HTTP_200_OK,{'Content-Type': 'application/json'}
            except exc.SQLAlchemyError:
                return 'No such location found',status.HTTP_404_NOT_FOUND,{'Content-Type': 'application/json'}

    @app.route('/locations',methods=['GET'])
    def show_all():
           # try:
        #return render_template('show_one.html',expenses=expenses.query.filter_by(id=expense_id))
                location=locations.query.all()
                print location
                return jsonify([e.serialize() for e in location]),status.HTTP_200_OK,{'Content-Type': 'application/json'}
            #except exc.SQLAlchemyError:
             #   return 'No such location found',status.HTTP_404_NOT_FOUND,{'Content-Type': 'application/json'}


def copy_location(old_location,new_location):
    if new_location.name is not None:
            old_location.name= new_location.name
    if new_location.address is not None:
            old_location.address=new_location.address
    if new_location.city is not None:
            old_location.city=new_location.city
    if new_location.state is not None:
            old_location.state=new_location.state
    if new_location.zip is not None:
            old_location.zip=new_location.zip
    if new_location.lat is not None:
            old_location.lat=new_location.lat
    if new_location.lon is not None:
            old_location.lon=new_location.lon

def getPosition(args):
    address=args.get('address')+args.get('city')+args.get('state')+args.get('zip')
                
    parameters = {
        'address': address,
        'sensor': 'false'
    }

    response = requests.get(geocode_url, params=parameters).json()
    pos= response['results'][0]['geometry']['location']

    return pos        

if __name__ == "__main__":
	#time.sleep(120)
#	CreateDB()    	
	db.create_all()
	app.run(debug=True,host='localhost',port=5000)