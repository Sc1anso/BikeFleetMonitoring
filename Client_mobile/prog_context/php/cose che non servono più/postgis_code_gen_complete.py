import json
from random import seed
from random import randint

data_output = ""
data_insert = "INSERT INTO mobike.rastrelliere (id, name, max_bici, bike_lst, lat, lon, geog, geom)"

data_insert_poi = "INSERT INTO mobike.poi (id, name, coords, geog, geom)"

data_insert_aree = "INSERT INTO mobike.aree_vietate (id, name, coords, geog, geom)"

prog = 1
max_bici = 5

def generate_output(data_output, data_insert, prog, max_bici):
	bike_list_used = []
	f = open("res/rastrelliere.json")
	data = json.load(f)
	seed(1)
	for feature in data["features"]:
		row = data_insert
		name = feature["properties"]["Nome"]
		if "'" in name:
			name = name.replace("'", "''")
		name = "'" + name + "'"
		bike_lst = "'["
		for i in range(0, max_bici):
			val = randint(1, 680)
			while val in bike_list_used:
				val = randint(1, 680)
			bike_lst += str(val)
			if i < (max_bici - 1):
				bike_lst += ", "
			bike_list_used.append(val)
		bike_lst += "]'"
		#print(bike_lst + "\n")
		lat = str(feature["geometry"]["coordinates"][1])
		lon = str(feature["geometry"]["coordinates"][0])
		geog = "'POINT(" + lon + " " + lat + ")'"
		geom = "ST_GeomFromText('POINT(" + lon + " " + lat + ")')"
		values = "VALUES ('" + str(prog) + "', " + name + ", '" + str(max_bici) + "', " + bike_lst + ", '" + lat + "', '" + lon + "', " + geog + ", " + geom + ");\n"
		row += " " + values
		data_output += row
		prog += 1
	f.close()
	print(data_output)

def generate_output_poi(data_output, data_insert_poi, prog, max_bici):
	f = open("res/poi_geofence.geojson")
	data = json.load(f)
	for feature in data["features"]:
		row = data_insert_poi
		name = feature["properties"]["name"]
		p_list = ""
		p_list_aux = ""
		print(name)
		if "'" in name:
			name = name.replace("'", "''")
		name = "'" + name + "'"
		lat = str(feature["geometry"]["coordinates"])
		lon = str(feature["geometry"]["coordinates"])
		for i in range(len(feature["geometry"]["coordinates"][0])):
			#print(feature["geometry"]["coordinates"][0][i])
			lat = str(feature["geometry"]["coordinates"][0][i][1])
			lon = str(feature["geometry"]["coordinates"][0][i][0])
			p_list_aux += "[" + str(lon) + ", " + str(lat) + "]"
			if i == len(feature["geometry"]["coordinates"][0]) - 1:
				p_list += str(lon) + " " + str(lat)
				p_list_aux += "[" + str(lon) + ", " + str(lat) + "]"
			else:
				p_list += str(lon) + " " + str(lat) + ", "
				p_list_aux += "[" + str(lon) + ", " + str(lat) + "], "

		print(p_list)
		p_list_aux = "'{" + p_list_aux + "}'"
		#print(p_list_aux)
		geog = "'POLYGON((" + p_list + "))'"
		geom = "ST_GeomFromText('POLYGON((" + p_list + "))')"
		values = "VALUES (" + str(prog) + ", " + name + ", " + p_list_aux + ", " + geog + ", " + geom + ");\n"
		row += " " + values
		data_output += row
		prog += 1
	f.close()
	print(data_output)


def generate_output_aree(data_output, data_insert_poi, prog, max_bici):
	f = open("res/areevietate_geofence.geojson")
	data = json.load(f)
	for feature in data["features"]:
		row = data_insert_poi
		name = feature["properties"]["name"]
		p_list = ""
		p_list_aux = ""
		print(name)
		if "'" in name:
			name = name.replace("'", "''")
		name = "'" + name + "'"
		lat = str(feature["geometry"]["coordinates"])
		lon = str(feature["geometry"]["coordinates"])
		for i in range(len(feature["geometry"]["coordinates"][0])):
			#print(feature["geometry"]["coordinates"][0][i])
			lat = str(feature["geometry"]["coordinates"][0][i][1])
			lon = str(feature["geometry"]["coordinates"][0][i][0])
			p_list_aux += "[" + str(lon) + ", " + str(lat) + "]"
			if i == len(feature["geometry"]["coordinates"][0]) - 1:
				p_list += str(lon) + " " + str(lat)
				p_list_aux += "[" + str(lon) + ", " + str(lat) + "]"
			else:
				p_list += str(lon) + " " + str(lat) + ", "
				p_list_aux += "[" + str(lon) + ", " + str(lat) + "], "

		print(p_list)
		p_list_aux = "'{" + p_list_aux + "}'"
		#print(p_list_aux)
		geog = "'POLYGON((" + p_list + "))'"
		geom = "ST_GeomFromText('POLYGON((" + p_list + "))')"
		values = "VALUES (" + str(prog) + ", " + name + ", " + p_list_aux + ", " + geog + ", " + geom + ");\n"
		row += " " + values
		data_output += row
		prog += 1
	f.close()
	print(data_output)


generate_output(data_output, data_insert, prog, max_bici)
#generate_output_poi(data_output, data_insert_poi, prog, max_bici)
#generate_output_aree(data_output, data_insert_aree, prog, max_bici)




# INSERT INTO mobike.rastrelliere (id, name, max_bici, lat, lon, geog, geom) 
# VALUES (1, '12 Giugno 3', 10, 44.48761, 11.344264, 'POINT(11.34426 44.48761)', ST_GeomFromText('POINT(11.34426 44.48761)'));