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


app = Flask(__name__)
CORS(app)


class CheckLocationService():
	
    @app.route('/checklocations/<string:keywords>',methods=['GET','OPTIONS'])
    def checklocations(keywords):
        url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=%s&key=AIzaSyDM0NDXnVwJjancQ-b1oXCLvxVC9sD3NZE" %(keywords)
        data = requests.get(url, timeout=20).json()
        try:
            temp = data["results"][0]["photos"][0]["photo_reference"]
        except:
            temp='0'
        return temp

if __name__ == "__main__":
	app.run(debug=True,host='localhost',port=5002)