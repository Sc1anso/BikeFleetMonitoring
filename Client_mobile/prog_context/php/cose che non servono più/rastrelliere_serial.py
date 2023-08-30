import json

data_output = ""
data_insert = "INSERT INTO mobike.rastrelliere (name, lat, lon, geog, geom)"

def generate_output(data_output, data_insert):
	f = open("res/rastrelliere.json")
	data = json.load(f)
	for feature in data["features"]:
		row = data_insert
		name = feature["properties"]["Nome"]
		if "'" in name:
			name = name.replace("'", "''")
		name = "'" + name + "'"
		lat = str(feature["geometry"]["coordinates"][1])
		lon = str(feature["geometry"]["coordinates"][0])
		geog = "'POINT(" + lon + " " + lat + ")'"
		geom = "ST_GeomFromText('POINT(" + lon + " " + lat + ")')"
		values = "VALUES (" + name + ", " + lat + ", " + lon + ", " + geog + ", " + geom + ") RETURNING id;\n"
		row += " " + values
		data_output += row
	f.close()
	print(data_output)

generate_output(data_output, data_insert)




# INSERT INTO mobike.rastrelliere (id, name, max_bici, lat, lon, geog, geom) 
# VALUES (1, '12 Giugno 3', 10, 44.48761, 11.344264, 'POINT(11.34426 44.48761)', ST_GeomFromText('POINT(11.34426 44.48761)'));