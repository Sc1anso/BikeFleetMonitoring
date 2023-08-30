import json

data_output = ""
data_insert = "INSERT INTO mobike.rastrelliere (id, name, max_bici, lat, lon, geog, geom)"

prog = 1
max_bici = 5

def generate_output(data_output, data_insert, prog, max_bici):
	f = open("rastrelliere.json")
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
		values = "VALUES (" + str(prog) + ", " + name + ", " + str(max_bici) + ", " + lat + ", " + lon + ", " + geog + ", " + geom + ");\n"
		row += " " + values
		data_output += row
		prog += 1
	f.close()
	print(data_output)

generate_output(data_output, data_insert, prog, max_bici)




# INSERT INTO mobike.rastrelliere (id, name, max_bici, lat, lon, geog, geom) 
# VALUES (1, '12 Giugno 3', 10, 44.48761, 11.344264, 'POINT(11.34426 44.48761)', ST_GeomFromText('POINT(11.34426 44.48761)'));