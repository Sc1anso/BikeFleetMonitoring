from flask import Flask, request
import psycopg2
from flask_cors import CORS
import json

app = Flask(__name__)
CORS(app)

# Connect to your postgres DB
conn = psycopg2.connect(
    host="localhost",
    port = "5432",
    database="postgres",
    user="postgres",
    #password="xxxxxxxxxx"
)

cur = conn.cursor()

# @app.route("/login", methods = ["POST"])
# def login():
#   user = request.form["username"]
#   psw = request.form["userPassword"]
#   sql_string = "SELECT CASE WHEN EXISTS ( SELECT * FROM mobike.user WHERE (username = '" + str(user) + "' OR email = '" + str(user) + "') AND password = '" + str(psw)  + "') THEN 'True' ELSE 'False' END"
#   cur.execute(sql_string)
#   data = cur.fetchall()

#   print(str(user) + " " + str(psw) + str(data))

#   return json.dumps(data[0][0])


# @app.route("/get_users")
# def get_users():
#     sql_string = "SELECT * FROM mobike.user"

#     # Execute a query
#     cur.execute(sql_string)

#     records = cur.fetchall()

#     #conn.commit()

#     #cur.close()
#     #conn.close()

#     #print(records)
#     #print(json.dumps(records))
#     return json.dumps(records)

@app.route("/get_poi")
def get_poi():
    sql_string = "SELECT * FROM mobike.poi"

    cur.execute(sql_string)

    records = cur.fetchall()

    data = []

    for poi in records:
        new_poi = {}
        new_poi["id"] = poi[0]
        new_poi["name"] = poi[1]
        new_poi["coordinates"] = json.loads(poi[2].replace("][", "],[").replace("{", "[").replace("}", "]"))
        data.append(new_poi)

    return json.dumps(data)

@app.route("/get_fa")
def get_fa():
    sql_string = "SELECT * FROM mobike.aree_vietate"

    cur.execute(sql_string)

    records = cur.fetchall()

    data = []

    for fa in records:
        new_poi = {}
        new_poi["id"] = fa[0]
        new_poi["name"] = fa[1]
        new_poi["coordinates"] = json.loads(fa[2].replace("][", "],[").replace("{", "[").replace("}", "]"))
        data.append(new_poi)

    return json.dumps(data)

@app.route("/initbikes")
def get_bikes():

    #sql_string = "WITH all_dist(id_bici, history_bici, onservice_bici, rack_bici, lat_bici, lon_bici, id_rent, name_rent, goeg_rent, dist, lat_rent, lon_rent) AS (SELECT a.id, a.history, a.onservice, a.rack, a.lat, a.lon, b.id, b.name, b.geog, ST_Distance(ST_Point(a.lon, a.lat), b.geog) as dist, b.lat, b.lon FROM mobike.bikes a, mobike.rastrelliere b ORDER BY a.id, dist asc) SELECT m.id_bici, m.history_bici, m.onservice_bici, m.rack_bici, m.lat_bici, m.lon_bici, t.dist, m.id_rent, m.name_rent, m.lat_rent, m.lon_rent FROM ( SELECT id_bici, MIN(dist) as dist FROM all_dist GROUP BY id_bici) t JOIN all_dist m ON (t.id_bici = m.id_bici AND t.dist = m.dist)"
    #sql_string = "WITH all_dist(id_bici, history_bici, onservice_bici, rack_bici, lat_bici, lon_bici, id_rent, name_rent, goeg_rent, dist, lat_rent, lon_rent, geom) AS (SELECT a.id, a.history, a.onservice, a.rack, a.lat, a.lon, b.id, b.name, b.geog, ST_Distance(a.geog, b.geog) as dist, b.lat, b.lon, a.geom FROM mobike.bikes a, mobike.rastrelliere b ORDER BY a.id, dist asc), min_dist(id_bici, history_bici, onservice_bici, rack_bici, lat_bici, lon_bici, dist, id_rent, name_rent, lat_rent, lon_rent, geom) AS (SELECT m.id_bici, m.history_bici, m.onservice_bici, m.rack_bici, m.lat_bici, m.lon_bici, t.dist, m.id_rent, m.name_rent, m.lat_rent, m.lon_rent, m.geom FROM (SELECT id_bici, MIN(dist) as dist FROM all_dist GROUP BY id_bici) t JOIN all_dist m ON (t.id_bici = m.id_bici AND t.dist = m.dist)), in_f(id_bici, history_bici, onservice_bici, rack_bici, lat_bici, lon_bici, dist, id_rent, name_rent, lat_rent, lon_rent, geom, in_forbidden) AS (SELECT a.id_bici, a.history_bici, a.onservice_bici, a.rack_bici, a.lat_bici, a.lon_bici, a.dist, a.id_rent, a.name_rent, a.lat_rent, a.lon_rent, a.geom, t.in_forbidden::bool FROM (SELECT m.id, MAX(ST_Within(m.geom, n.geom)::int) as in_forbidden FROM mobike.bikes as m, mobike.aree_vietate as n GROUP BY m.id) t JOIN min_dist a ON (a.id_bici = t.id)) SELECT a.id_bici, a.history_bici, a.onservice_bici, a.rack_bici, a.lat_bici, a.lon_bici, a.dist, a.id_rent, a.name_rent, a.lat_rent, a.lon_rent, a.geom, a.in_forbidden, t.in_poi::bool FROM (SELECT m.id, MAX(ST_Within(m.geom, n.geom)::int) as in_poi FROM mobike.bikes as m, mobike.poi as n GROUP BY m.id) t JOIN in_f a ON (a.id_bici = t.id)"
    sql_string = """
        WITH all_dist(id_bike, history_bike, onservice_bike, reserved_bike, lat_bike, lon_bike, id_rack, name_rack, goeg_rack, dist, lat_rack, lon_rack) 
        AS (
            SELECT a.id, a.history, a.onservice, a.reserved, a.lat, a.lon, b.id, b.name, b.geog, ST_Distance(ST_Point(a.lon, a.lat), b.geog) as dist, b.lat, b.lon 
            FROM mobike.bikes a, mobike.racks b ORDER BY a.id, dist asc) 
            SELECT m.id_bike, m.history_bike, m.onservice_bike, m.reserved_bike, m.lat_bike, m.lon_bike, t.dist, m.id_rack, m.name_rack, m.lat_rack, m.lon_rack 
            FROM (
                SELECT id_bike, MIN(dist) as dist 
                FROM all_dist 
                GROUP BY id_bike
            ) t JOIN all_dist m ON (t.id_bike = m.id_bike AND t.dist = m.dist)
        """

    cur.execute(sql_string)

    records = cur.fetchall()

    data = []

    for bike in records:
        new_bike = {}
        new_bike["id"] = bike[0]
        new_bike["history"] = json.loads(bike[1].replace("\"", "").replace("(", "[").replace(")", "]").replace("{", "[").replace("}", "]"))
        new_bike["onService"] = bike[2]
        new_bike["reserved"] = bike[3]
        new_bike["lat"] = bike[4]
        new_bike["lon"] = bike[5]
        new_bike["closer_rack_dist"] = bike[6]
        new_bike["closer_rack_id"] = bike[7]
        new_bike["closer_rack_name"] = bike[8]
        new_bike["closer_rack_lat"] = bike[9]
        new_bike["closer_rack_lon"] = bike[10]
        #new_bike["in_forbidden"] = bike[12]
        #new_bike["in_poi"] = bike[13]
        data.append(new_bike)

    return json.dumps(data)

@app.route("/update_bikes", methods = ["POST", "GET"])
def update_bikes():
    # request.data = [
    #     {
    #         "id": 1
    #         "lat": 44.453431,
    #         "lon": 11.343432,
    #         "rent": [[xx.xxxxx, yy.yyyyyy], ... , [11.343432, 44.453431]]
    #     },
    #     .
    #     .
    #     .
    # ]
    data = json.loads(request.data)
    #print(data)
    updated_rows = 0
    for bike in data:
        lat = bike["lat"]
        lon = bike["lon"]
        bike_id = bike["id"]
        onService = bike["onService"]
        current_rent = bike["rent"]
        new_path = False
        if(len(current_rent) < 1):
            new_path = True
        current_rent.append([lon, lat])
        current_rent = str(current_rent).replace("[", "(").replace("]", ")").replace("((", "(").replace("))", ")")
        
        new_data = {}
        new_data["lat"] = lat
        new_data["lon"] = lon
        new_data["geog"] = "'POINT(" + str(lon) + " " + str(lat) + ")'"
        new_data["geom"] = "ST_GeomFromText(" + new_data["geog"] + ")"

        sql_string = ""
        if(new_path):
            sql_string = "UPDATE mobike.bikes SET history = array_append(history, PATH('" + current_rent + "')), onservice = " + str(onService) + ", lat = " + str(lat) + ", lon = " + str(lon) + ", geog = " + new_data["geog"] + ", geom = " + new_data["geom"] + " WHERE id = " + str(bike_id)
        else:
            sql_string = "UPDATE mobike.bikes SET history[array_upper(history, 1)] = PATH('" + current_rent + "'), onservice = " + str(onService) + ", lat = " + str(lat) + ", lon = " + str(lon) + ", geog = " + new_data["geog"] + ", geom = " + new_data["geom"] + " WHERE id = " + str(bike_id)
        cur.execute(sql_string)
    conn.commit()
    updated_rows = cur.rowcount

    return json.dumps(updated_rows)

@app.route("/add_rack", methods = ["POST", "GET"])
def add_rack():
    # request.data = {
    #     "name": "via XXX",
    #     "lat": 44.453431,
    #     "lon": 11.343432,
    # }
    data = json.loads(request.data)
    updated_rows = 0

    name = "'" + str(data["name"]) + "'"
    lat = data["lat"]
    lon = data["lon"]
    geog = "'POINT(" + str(lon) + " " + str(lat) + ")'"
    geom = "ST_GeomFromText(" + geog + ")"

    sql_string = "INSERT INTO mobike.racks (name, lat, lon, geog, geom, bike_lst) VALUES (" + name + ", " + str(lat) + ", " + str(lon) + ", " + geog + ", " + geom + ", '[]') RETURNING id"
    cur.execute(sql_string)
    conn.commit()
    updated_rows = cur.rowcount

    return json.dumps(updated_rows)

@app.route("/remove_rack", methods = ["POST", "GET"])
def remove_rack():
    name = request.data.decode('UTF-8')
    updated_rows = 0

    sql_string = "DELETE FROM mobike.racks WHERE name = '" + name + "'"
    cur.execute(sql_string)
    conn.commit()
    updated_rows = cur.rowcount

    return json.dumps(updated_rows)

@app.route("/modify_rack", methods = ["POST", "GET"])
def modify_rack():
    data = json.loads(request.data)

    name = "'" + str(data["name"]) + "'"
    lat = data["lat"]
    lon = data["lon"]
    geog = "'POINT(" + str(lon) + " " + str(lat) + ")'"
    geom = "ST_GeomFromText(" + geog + ")"
    old_name = "'" + str(data["old_name"]) + "'"
    updated_rows = 0

    sql_string = "UPDATE mobike.racks SET name = " + name + ", lat = " + str(lat) + ", lon = " + str(lon) + ", geog = " + geog + ", geom = " + geom + " WHERE name = " + old_name
    cur.execute(sql_string)
    conn.commit()
    updated_rows = cur.rowcount

    return json.dumps(updated_rows)

@app.route("/add_geofence", methods = ["POST", "GET"])
def add_geofence():
    # request.data = {
    #     "name": "via XXX",
    #     "type": "poi",
    #     "coords": [
    #                     [xx.xxxx, yy.yyyy],
    #                     .
    #                     .
    #                     .
    #                     [xx.xxxx, yy.yyyy]
    #                ]
    # }
    data = json.loads(request.data)
    updated_rows = 0

    geo_type = str(data["type"])
    if(geo_type == "fa"):
        geo_type = "aree_vietate"

    name = "'" + str(data["name"]) + "'"
    coords = str(data["coords"]).replace("[[", "'{[").replace("]]", "]}'")
    tmp_coords = ""
    for idx, latlon in enumerate(data["coords"]):
        lat = str(latlon[1])
        lon = str(latlon[0])
        new_string = ""
        if(idx == len(data["coords"]) - 1):
            new_string = lon + " " + lat
        else:
            new_string = lon + " " + lat + ", "
        tmp_coords += new_string


    geog = "'POLYGON((" + tmp_coords + "))'"
    geom = "ST_GeomFromText(" + geog + ")"

    sql_string = "INSERT INTO mobike." + geo_type + " (name, coords, geog, geom) VALUES (" + name + ", " + coords + ", " + geog + ", " + geom + ") RETURNING id"
    cur.execute(sql_string)
    conn.commit()
    updated_rows = cur.rowcount

    return json.dumps(updated_rows)

@app.route("/remove_geofence", methods = ["POST", "GET"])
def remove_geofence():
    data = json.loads(request.data.decode('UTF-8'))
    name = "'" + str(data["name"]) + "'"
    geo_type = str(data["type"])
    if(geo_type == "POI"):
        geo_type = "poi"
    elif(geo_type == "Aree vietate" or geo_type == "fa"):
        geo_type = "aree_vietate"

    sql_string = "DELETE FROM mobike." + geo_type + " WHERE name = " +  name
    cur.execute(sql_string)
    conn.commit()
    updated_rows = cur.rowcount

    return json.dumps(updated_rows)

@app.route("/change_name_geofence", methods = ["POST", "GET"])
def change_name_geofence():
    data = json.loads(request.data)
    name = "'" + str(data["name"]) + "'"
    old_name = "'" + str(data["old_name"]) + "'"
    geo_type = str(data["type"])
    if(geo_type == "fa"):
        geo_type = "aree_vietate"
    sql_string = "UPDATE mobike." + geo_type + " SET name = " + name + " WHERE name = " + old_name
    cur.execute(sql_string)
    conn.commit()
    updated_rows = cur.rowcount

    return json.dumps(updated_rows)

@app.route("/get_geofence_coords", methods = ["POST", "GET"])
def get_geofence_coords():
    data = json.loads(request.data)
    name = "'" + str(data["name"]) + "'"
    geo_type = str(data["type"])
    if(geo_type == "fa"):
        geo_type = "aree_vietate"
    
    sql_string = "SELECT coords FROM mobike." + geo_type + " WHERE name = " + name
    cur.execute(sql_string)
    coords = cur.fetchone()
    new_data = json.loads(coords[0].replace("{[", "[[").replace("]}", "]]"))

    return json.dumps(new_data)


# @app.route("/modify_geofence", methods = ["POST", "GET"])
# def modify_geofence():
#     data = json.loads(request.data)
#     name = "'" + str(data["name"]) + "'"
#     old_name = "'" + str(data["old_name"]) + "'"
#     geo_type = str(data["type"])
#     old_table = ""
#     if(geo_type == "fa")
#         geo_type = "aree_vietate"

#     if(data["type_change"]):
#         if(geo_type == "poi"):
#             old_table = "aree_vietate"
#         elif(geo_type == "aree_vietate"):
#             old_table = "poi"
#         sql_string_delete = "DELETE FROM mobike." + old_table + " WHERE name = " + old_name
#         cur.execute(sql_string)
#         conn.commit()
    
#     sql_string = "UPDATE mobike." + geo_type + " SET name = " + name + " WHERE"

#     updated_rows = cur.rowcount
#     return json.dumps(updated_rows)

# @app.route("/geofence_msg", methods = ["POST"])
# def send_geofence_msg():
#     obj = json.loads(request.data)
#     bike_id = obj["bike_id"]
#     msg = obj["msg"]
#     timestamp = obj["timestamp"]

# @app.route("/get_dist", methods = ["POST", "GET"])
# def get_dist():

#     lat = json.loads(request.data)["lat"]
#     lon = json.loads(request.data)["lon"]

#     sql_string = "SELECT id, name, lat, lon, ST_Distance(ST_Point(" + str(lon) + ", " + str(lat) + "), geog) as dist FROM mobike.rastrelliere ORDER BY dist asc LIMIT 1"

#     cur.execute(sql_string)

#     data = cur.fetchone()

#     bike_rent = {
#         "id": data[0],
#         "name": data[1],
#         "lat": data[2],
#         "lon": data[3],
#         "dist": data[4]
#     }

#     return json.dumps(bike_rent)




