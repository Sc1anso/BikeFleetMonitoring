// Rack Style
var bikeStyle = new ol.style.Style({
  image: new ol.style.Icon({
    scale: 0.08,
    src: "media/bike.jpeg"
  })
});

// Forbidden Style
var forbiddenStroke = new ol.style.Stroke({
  color : 'rgba(255,0,0,1)',
  width : 1    
});

var forbiddenFill = new ol.style.Fill({
  color: 'rgba(255,0,0,0.4)'
});

var forbiddenStyle = new ol.style.Style({
  stroke : forbiddenStroke,
  fill : forbiddenFill
})

// POI Area Style
var POIStroke = new ol.style.Stroke({
  color : 'rgba(34, 167, 240, 1)',
  width : 1    
});

var POIFill = new ol.style.Fill({
  color: 'rgba(34, 167, 240, 0.4)'
});

var POIStyle = new ol.style.Style({
  stroke : POIStroke,
  fill : POIFill
})

// Bikes Style
const available_bikeFill = new ol.style.Fill({
  color: 'blue'
});

const moving_bikeFill = new ol.style.Fill({
  color: 'red'
});

const outside_bikeFill = new ol.style.Fill({
  color: 'purple'
});

const selected_bikeStroke = new ol.style.Stroke({
  color: '#cc33ff',
  width: 3
});

const bikeStroke = new ol.style.Stroke({
  color: 'black',
  width: 1
});

const availableBike = new ol.style.Circle({
  radius: 4,
  fill: available_bikeFill,
  stroke: bikeStroke
});

const movingBike = new ol.style.Circle({
  radius: 5,
  fill: moving_bikeFill,
  stroke: bikeStroke
});

const availableBike_Style = new ol.style.Style({
  image: availableBike
});

const movingBike_Style = new ol.style.Style({
  image: movingBike
});

const rent = new ol.style.Stroke({
  color: '#339933',
  width: 3
});

const rent_Style = new ol.style.Style({
  stroke: rent
});

const bike_styleFunction = function(feature){
  let bikeId = feature.getId();
  var index = bikes.findIndex(el => el.id == bikeId);
  var bike = bikes[index];
  if(bike.onService){
    feature.setStyle(movingBike_Style);
  }
  else{
    feature.setStyle(availableBike_Style);
  }
  if(bikes_out_of_range.includes(bike.id)) {
    set_OutsideBikeStyle(feature);
  }
  if(bike.id == selectedBike) {
    set_SelectedBikeStyle(feature);
  }
  return feature.getStyle();
};