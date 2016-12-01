
from flask import Flask, request, flash, url_for, redirect, render_template,jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_api import status
from sqlalchemy.inspection import inspect
from flaskext.mysql import MySQL
import time



#from sqlalchemy import create_engine

app = Flask(__name__)
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
    address=db.Column('address',db.String(20))
    city=db.Column('city',db.String(20))
    state=db.Column('state',db.String(4))
    zip=db.Column('zip',db.String(6))

    def serialize(self):
            d = Serializer.serialize(self)
            return d

    def __init__(self,name,address,city,state,zip):
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

	
    @app.route('/locations',methods=['POST'])
    def save_locations():
            
                #args=request.args
                args=request.get_json(force=True)
                #args=request.data
                location=locations(name=args.get('name'),address=args.get('address'),city=args.get('city'),state=args.get('state'),zip=args.get('zip'))
                db.session.add(location)
                db.session.commit()
                return jsonify(location.serialize()),status.HTTP_201_CREATED,{'Content-Type': 'application/json'}

    @app.route('/location/<int:location_id>', methods = ['PUT'])
    def edit_location(location_id):
                args=request.get_json(force=True)
                old_location=locations.query.filter_by(id = location_id).first()
                if(old_location is None):
                    return '',status.HTTP_404_NOT_FOUND,{'Content-Type': 'application/json'}
                else:
                    new_location=locations(name=args.get('name'),address=args.get('address'),city=args.get('city'),state=args.get('state'),zip=args.get('zip'))
                    
                    copy_location(old_location, new_location)

                    db.session.commit()
                    return '',status.HTTP_202_ACCEPTED,{'Content-Type': 'application/json'}

    @app.route('/locations/<int:location_id>', methods = ['DELETE'])
    def delete_location(location_id):

                location=locations.query.filter_by(id = location_id).first()
                if(location is None):
                    return '',status.HTTP_404_NOT_FOUND,{'Content-Type': 'application/json'}
                else: 
                    db.session.delete(location)
                    db.session.commit()
                    return '',status.HTTP_204_NO_CONTENT,{'Content-Type': 'application/json'}

    @app.route('/locations/<int:location_id>',methods=['GET'])
    def show_one(location_id):

        #return render_template('show_one.html',expenses=expenses.query.filter_by(id=expense_id))
                location=locations.query.filter_by(id=location_id).first()
                if(location is None):
                    return jsonify(location),status.HTTP_404_NOT_FOUND,{'Content-Type': 'application/json'}
                else:
                    return jsonify(Serializer.serialize(location)),status.HTTP_200_OK,{'Content-Type': 'application/json'}

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
            

if __name__ == "__main__":
	#time.sleep(120)
#	CreateDB()    	
	db.create_all()
	app.run(debug=True,host='localhost')