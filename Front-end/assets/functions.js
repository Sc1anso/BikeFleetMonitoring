// Popup
function close_popup() {
  if(new_rack) {
    input_new_feature.placeholder = "Nome della rastrelliera";
    document.getElementById("map").style.cursor = "default";
  }
  else if(new_geofence) {
    input_new_feature.placeholder = "Nome del geofence";
  }
  new_rack = false;
  new_geofence = false;
  tmp_geofence = undefined;
  popupOverlay.setPosition(undefined);
  closer_popup.blur();
  input_new_feature.value = "";
  flag_evtPropagation = 0;
  if(input_new_feature.classList.contains("new_feature")) {
    input_new_feature.classList.remove("new_feature");
  }
  if(form_geofence.classList.contains("d-none")) {
    form_geofence.classList.remove("d-none");
  }
  document.removeEventListener("click", click_to_close_popup);
}

function click_to_close_popup(e) {
  flag_evtPropagation += 1;
  if(flag_evtPropagation == 1) {
    return;
  }
  var popup = document.getElementById("popup");
  if(popupOverlay.getPosition() != undefined && !popup.contains(e.target) && !add_new_rack.contains(e.target) && !add_new_geofence.contains(e.target)) {
    if(new_geofence) {
      draw_source.removeFeature(tmp_geofence);
    }
    close_popup();
  }
}

// Rent
function removeRents(){
  document.getElementById("tabRent");
  while(tabRent.firstChild){
    tabRent.firstChild.remove();
  }
  selectedRents_list = [];
  vectorLine.clear();
}

function drawRoute(bike, n_rent) {
  var locs = bike.history[n_rent-1].slice();
  for (var i = 0; i < locs.length; i++) {
    locs[i] = ol.proj.transform(locs[i], 'EPSG:4326', 'EPSG:3857');
  }
  var rent = {
    "id_bike": selectedBike,
    "n_rent": parseInt(n_rent)
  };
  var featureLine = new ol.Feature({
    geometry: new ol.geom.LineString(locs)
  });
  featureLine.setId(JSON.stringify(rent));
  featureLine.set("type", "path");
  featureLine.setStyle(rent_Style);
  vectorLine.addFeature(featureLine);
}

function place_selectRent() {
  var bikeRents_coordinates = document.getElementById("bikeRents").getBoundingClientRect();
  selectRent.style.position = "absolute";
  selectRent.style.top = String(parseFloat(bikeRents_coordinates.top) - 3) + "px";
  selectRent.style.left = String(parseFloat(bikeRents_coordinates.left) + 190) + "px";
  selectRent.style.width = "50px";
  viewRent.style.position = "absolute";
  viewRent.style.top = String(parseFloat(bikeRents_coordinates.top) - 3) + "px";
  viewRent.style.left = String(parseFloat(bikeRents_coordinates.left) + 250) + "px";
}

// Style

function set_SelectedBikeStyle(feature) {
  var radius = feature.getStyle().getImage().getRadius();
  var fill = feature.getStyle().getImage().getFill();
  feature.setStyle(
    new ol.style.Style({
      image: new ol.style.Circle({
          radius: radius,
          fill: fill,
          stroke: selected_bikeStroke
        })
    })
  );
}

function set_OutsideBikeStyle(feature) {
  var stroke = feature.getStyle().getImage().getStroke();
  var radius = feature.getStyle().getImage().getRadius();
  feature.setStyle(
    new ol.style.Style({
      image: new ol.style.Circle({
          stroke: stroke,
          radius: radius,
          fill: outside_bikeFill
        })
    })
  );
}

// POI
function check_poi_duplicate(name) {
  var exists = false;
  poiVector.getSource().forEachFeature(el => {
    if(el.get("name") == name) {
      exists = true;
      return exists;
    }
  });
  return exists;
}

function get_poi_by_name(name) {
  var feature;
  poiVector.getSource().forEachFeature(el => {
    if(el.get("name") == name) {
      feature = el;
      return feature;
    }
  });
  return feature;
}

// Forbidden Area
function check_fa_duplicate(name) {
  var exists = false;
  faVector.getSource().forEachFeature(el => {
    if(el.get("name") == name) {
      exists = true;
      return exists;
    }
  });
  return exists;
}

function get_fa_by_name(name) {
  var feature;
  faVector.getSource().forEachFeature(el => {
    if(el.get("name") == name) {
      feature = el;
      return feature;
    }
  });
  return feature;
}

// Geofences
function update_geofence(geojson) {
  return new Promise((resolve, reject) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      resolve();
    }
    xhttp.onerror = function() {
      console.log("Errore di connessione con il Back-End durante update_geofence");
      reject("Qualcosa è andato storto");
    }
    xhttp.open("POST", "http://127.0.0.1:5000/add_geofence");
    xhttp.send(geojson);
  })
}

function remove_geofence(geojson) {
  return new Promise((resolve, reject) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      resolve();
    }
    xhttp.onerror = function() {
      console.log("Errore di connessione con il Back-End durante remove_geofence");
      reject("Qualcosa è andato storto");
    }
    xhttp.open("POST", "http://127.0.0.1:5000/remove_geofence");
    xhttp.send(geojson);
  })
}

function get_geofence_coords(geojson) {
  return new Promise((resolve, reject) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      resolve(this.response);
    }
    xhttp.onerror = function() {
      console.log("Errore di connessione con il Back-End durante get_geofence_coords");
      reject("Qualcosa è andato storto");
    }
    xhttp.open("POST", "http://127.0.0.1:5000/get_geofence_coords");
    xhttp.send(JSON.stringify(geojson));
  })
}

function change_name_geofence(geojson) {
  return new Promise((resolve, reject) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      resolve(this.response);
    }
    xhttp.onerror = function() {
      console.log("Errore di connessione con il Back-End durante change_name_geofence");
      reject("Qualcosa è andato storto");
    }
    xhttp.open("POST", "http://127.0.0.1:5000/change_name_geofence");
    xhttp.send(JSON.stringify(geojson));
  })
}

async function modify_geofence(geojson) {
  if(geojson["type_change"]) {
    var remove_geojson = {
      "name": geojson["old_name"],
      "type": geojson["old_type"]
    };
    var coords = await get_geofence_coords(remove_geojson);
    await remove_geofence(JSON.stringify(remove_geojson));
    var new_geofence = {
      "name": geojson["name"],
      "type": geojson["type"],
      "coords": JSON.parse(coords)
    }
    await update_geofence(JSON.stringify(new_geofence));
  }
  else {
    await change_name_geofence(geojson);
  }
  return;
}

// Racks 
function check_rack_duplicate(name) {
  var exists = false;
  racksVector.getSource().forEachFeature(el => {
    if(el.get("name") == name) {
      exists = true;
      return exists;
    }
  });
  return exists;
}

function get_rack_by_name(name) {
  var feature;
  racksVector.getSource().forEachFeature(el => {
    if(el.get("name") == name) {
      feature = el;
      return feature;
    }
  });
  return feature;
}

function update_rack(geojson) {
  return new Promise((resolve, reject) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      resolve();
    }
    xhttp.onerror = function() {
      console.log("Errore di connessione con il Back-End durante update_rack");
      reject("Qualcosa è andato storto");
    }
    xhttp.open("POST", "http://127.0.0.1:5000/add_rack");
    xhttp.send(geojson);
  })
}

function remove_rack(name) {
  return new Promise((resolve, reject) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      resolve();
    }
    xhttp.onerror = function() {
      console.log("Errore di connessione con il Back-End durante remove_rack");
      reject("Qualcosa è andato storto");
    }
    xhttp.open("POST", "http://127.0.0.1:5000/remove_rack");
    xhttp.send(String(name));
  })
}

function modify_rack(geojson) {
  return new Promise((resolve, reject) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      resolve();
    }
    xhttp.onerror = function() {
      console.log("Errore di connessione con il Back-End durante modify_rack");
      reject("Qualcosa è andato storto");
    }
    xhttp.open("POST", "http://127.0.0.1:5000/modify_rack");
    xhttp.send(geojson);
  })
}

// Map
function set_NewSelectedBike(feature, bike) {
  var previous_selectedBike = selectedBike;
  set_SelectedBikeStyle(feature);

  var radius = feature.getStyle().getImage().getRadius();
  var fill = feature.getStyle().getImage().getFill();
  if(previous_selectedBike > 0){
    vectorSource.getFeatureById(previous_selectedBike).getStyle().setImage(
      new ol.style.Circle({
        radius: radius,
        fill: fill,
        stroke: bikeStroke
      })
    );
  }
  selectedBike = bike.id;
}

function update_center_map(lon, lat) {
  map.getView().setCenter(ol.proj.fromLonLat([lon, lat]));
}

// WidgetUI
async function update_WidgetUI(index) {
  if(index < 0){
    msgError.classList.remove("d-none");
    place_selectRent();
    throw "Numero di bici non valido";
  }
  else {
    msgError.classList.add("d-none");
    var bike = bikes[index];
    if(input_bici.value != bike.id) {
      input_bici.value = bike.id;
    }
    document.getElementById("bikeId_value").textContent = bike.id;
    let status = bike.onService;
    if(!status){
      document.getElementById("bikeStartRack").classList.add("d-none");
      document.getElementById("bikeStartRack_value").classList.add("d-none");
      document.getElementById("bikeStatus_value").textContent = "Disponibile";
    }
    else{
      document.getElementById("bikeStartRack").classList.remove("d-none");
      document.getElementById("bikeStartRack_value").classList.remove("d-none");
      document.getElementById("bikeStatus_value").textContent = "In uso";
      document.getElementById("bikeStartRack_value").textContent = bike.rack;
    }
    document.getElementById("bikeRents_value").textContent = bike.history.length;
    try{
      var address = await reverseGeocoding(bike.lat, bike.lon);
      document.getElementById("bikeLocation_value").textContent = address;
    } catch(error){
      console.log(error);
    }
    document.getElementById("bikeList").classList.remove("d-none");

    //populate and set position of #selectRent AND set position of #viewRent
    while(selectRent.firstChild){
      selectRent.firstChild.remove();
    }
    for(var i = 0; i < bike["history"].length; i++){
      const opt = document.createElement("option");
      opt.setAttribute("value", i+1);
      const opt_text = document.createTextNode(i+1);
      opt.appendChild(opt_text);
      selectRent.appendChild(opt);
    }
    if(selectRent.hasChildNodes()) {
      selectRent.lastChild.selected = true;
    }
    place_selectRent();
  }
}

function alertDistance(goesOut, bike) {
  // goesOut: 
  //  true if bike gets out, 
  //  false if bike gets in
  if(goesOut){
    // update bike out-of-range Array
    bikes_out_of_range.push(bike.id);
    //update Widget_UI
    const li = document.createElement("li");
    let li_id = "li-" + String(bike.id);
    li.setAttribute("id", li_id);
    li.classList.add("out-of-range");
    var row = document.createElement("div");
    row.classList.add("row");
    var col = document.createElement("div");
    col.classList.add("col");
    var b = document.createElement("b");
    var p = document.createElement("p");

    const header_row = row.cloneNode();
    
    const id_label = col.cloneNode();
    id_label.classList.add("col-2");
    const id_label_title = b.cloneNode();
    id_label_title.textContent = "ID";
    id_label.appendChild(id_label_title);
    header_row.appendChild(id_label);

    const dist_label = col.cloneNode();
    dist_label.classList.add("col-4");
    const dist_label_title = b.cloneNode();
    dist_label_title.textContent = "Distanza";
    dist_label.appendChild(dist_label_title);
    header_row.appendChild(dist_label);

    const rack_label = col.cloneNode();
    rack_label.classList.add("col-6");
    const rack_label_title = b.cloneNode();
    rack_label_title.textContent = "Rastrelliera";
    rack_label.appendChild(rack_label_title);
    header_row.appendChild(rack_label);

    const values_row = row.cloneNode();

    const id_value = col.cloneNode();
    id_value.classList.add("col-2");
    const id_value_title = p.cloneNode();
    id_value_title.classList.add("ofr-id");
    id_value_title.textContent = bike.id;
    id_value.appendChild(id_value_title);
    values_row.appendChild(id_value);

    const dist_value = col.cloneNode();
    dist_value.classList.add("col-4");
    const dist_value_title = p.cloneNode();
    dist_value_title.textContent = String(parseInt(bike.closer_rack_dist)) + " m";
    dist_value.appendChild(dist_value_title);
    values_row.appendChild(dist_value);

    const rack_value = col.cloneNode();
    rack_value.classList.add("col-6");
    const rack_value_title = p.cloneNode();
    rack_value_title.classList.add("text-truncate");
    rack_value_title.textContent = bike.closer_rack_name;
    rack_value.appendChild(rack_value_title);
    values_row.appendChild(rack_value);

    li.appendChild(header_row);
    li.appendChild(values_row);
    document.getElementById("bikesOut_list").appendChild(li);
  }
  else {
    // update bike out-of-range Array
    let index = bikes_out_of_range.findIndex(el => el == bike.id);
    bikes_out_of_range.splice(index, 1);
    // update Widget_UI
    let li_id = "li-" + String(bike.id);
    document.getElementById(li_id).remove();
  }
}

// Other
function checkDistance(bike){
  // Case 1. Bike goes OUT of range
  if((bike.closer_rack_dist >= maxDist) && (!(bikes_out_of_range.includes(bike.id)))) {
    alertDistance(true, bike);
  }
  // Case 2. Bike goes BACK IN the range
  else if((bike.closer_rack_dist < maxDist) && (bikes_out_of_range.includes(bike.id))) {
    alertDistance(false, bike);
  }
}

function print(data) {
  data.getSource().forEachFeature(el => {
    console.log(el.get("name"));
  });
}

function reverseGeocoding(lat, lon) {
  return new Promise((resolve, reject) => {
    fetch("https://nominatim.openstreetmap.org/reverse?lat="+lat+"&lon="+lon+"&format=json")
      .then(response => response.json())
      .then(data => {
        var address = "";
        if(data.address.road != undefined){
          address += data.address.road;
          if(data.address.house_number != undefined){
            address += ", " + data.address.house_number;
          }
        }
        else {
          address += "Indirizzo sconosciuto";
        }
        resolve(address);
      })
      .catch(error => {
        console.log("Errore di acquisizione indirizzo");
        reject("Qualcosa è andato storto");
      });
  })
}

// Test functions

function getPOI() {
  return new Promise((resolve, reject) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      pois = [...JSON.parse(this.response)];
      pois.forEach(el => {
        let newFeature = {
          "type": "Feature",
          "properties": {
            "name": el["name"]
          },
          "geometry": {
            "type": "Polygon",
            "coordinates": [el["coordinates"]]
          }
        };
        tmp_pois["features"].push(newFeature);
      });
      resolve();
    }
    xhttp.onerror = function() {
      console.log("Errore di connessione con il Back-End durante getpoi");
      reject("Qualcosa è andato storto");
    }
    xhttp.open("GET", "http://127.0.0.1:5000/get_poi");
    xhttp.send();
  })
}

async function initPOI() {
  try {
    await getPOI();
    poiSource = new ol.source.Vector({
      features: new ol.format.GeoJSON({featureProjection:"EPSG:3857"}).readFeatures(tmp_pois)
    });
    poiVector.setSource(poiSource);
  } catch(error) {
    console.log(error);
  }
}

function getFA() {
  return new Promise((resolve, reject) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      fas = [...JSON.parse(this.response)];
      fas.forEach(el => {
        let newFeature = {
          "type": "Feature",
          "properties": {
            "name": el["name"]
          },
          "geometry": {
            "type": "Polygon",
            "coordinates": [el["coordinates"]]
          }
        };
        tmp_fa["features"].push(newFeature);
      });
      resolve();
    }
    xhttp.onerror = function() {
      console.log("Errore di connessione con il Back-End durante getfa");
      reject("Qualcosa è andato storto");
    }
    xhttp.open("GET", "http://127.0.0.1:5000/get_fa");
    xhttp.send();
  })
}

async function initFA() {
  try {
    await getFA();
    faSource = new ol.source.Vector({
      features: new ol.format.GeoJSON({featureProjection:"EPSG:3857"}).readFeatures(tmp_fa)
    });
    faVector.setSource(faSource);
  } catch(error) {
    console.log(error);
  }
}