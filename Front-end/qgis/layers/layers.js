var wms_layers = [];

var format_poi_density_0 = new ol.format.GeoJSON();
var features_poi_density_0 = format_poi_density_0.readFeatures(json_poi_density_0, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_poi_density_0 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_poi_density_0.addFeatures(features_poi_density_0);
var lyr_poi_density_0 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_poi_density_0, 
                style: style_poi_density_0,
                interactive: true,
    title: 'poi_density<br />\
    <img src="styles/legend/poi_density_0_0.png" /> 0 - 0<br />\
    <img src="styles/legend/poi_density_0_1.png" /> 0 - 1<br />\
    <img src="styles/legend/poi_density_0_2.png" /> 1 - 2<br />'
        });
var format_fa_density_1 = new ol.format.GeoJSON();
var features_fa_density_1 = format_fa_density_1.readFeatures(json_fa_density_1, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_fa_density_1 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_fa_density_1.addFeatures(features_fa_density_1);
var lyr_fa_density_1 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_fa_density_1, 
                style: style_fa_density_1,
                interactive: true,
    title: 'fa_density<br />\
    <img src="styles/legend/fa_density_1_0.png" /> 0 - 0<br />\
    <img src="styles/legend/fa_density_1_1.png" /> 0 - 1<br />'
        });
var format_kmeans_2 = new ol.format.GeoJSON();
var features_kmeans_2 = format_kmeans_2.readFeatures(json_kmeans_2, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_kmeans_2 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_kmeans_2.addFeatures(features_kmeans_2);
var lyr_kmeans_2 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_kmeans_2, 
                style: style_kmeans_2,
                interactive: true,
    title: 'kmeans<br />\
    <img src="styles/legend/kmeans_2_0.png" /> 0<br />\
    <img src="styles/legend/kmeans_2_1.png" /> 1<br />\
    <img src="styles/legend/kmeans_2_2.png" /> 2<br />\
    <img src="styles/legend/kmeans_2_3.png" /> 3<br />\
    <img src="styles/legend/kmeans_2_4.png" /> 4<br />\
    <img src="styles/legend/kmeans_2_5.png" /> <br />'
        });

lyr_poi_density_0.setVisible(true);lyr_fa_density_1.setVisible(true);lyr_kmeans_2.setVisible(true);
var layersList = [lyr_poi_density_0,lyr_fa_density_1,lyr_kmeans_2];
lyr_poi_density_0.set('fieldAliases', {'_uid_': '_uid_', 'id': 'id', 'name': 'name', 'entries': 'entries', });
lyr_fa_density_1.set('fieldAliases', {'_uid_': '_uid_', 'id': 'id', 'name': 'name', 'entries': 'entries', });
lyr_kmeans_2.set('fieldAliases', {'_uid_': '_uid_', 'CLUSTER_ID': 'CLUSTER_ID', 'CLUSTER_SIZE': 'CLUSTER_SIZE', });
lyr_poi_density_0.set('fieldImages', {'_uid_': 'TextEdit', 'id': 'TextEdit', 'name': 'TextEdit', 'entries': 'TextEdit', });
lyr_fa_density_1.set('fieldImages', {'_uid_': 'TextEdit', 'id': 'TextEdit', 'name': 'TextEdit', 'entries': 'TextEdit', });
lyr_kmeans_2.set('fieldImages', {'_uid_': '', 'CLUSTER_ID': '', 'CLUSTER_SIZE': '', });
lyr_poi_density_0.set('fieldLabels', {'_uid_': 'no label', 'id': 'no label', 'name': 'no label', 'entries': 'no label', });
lyr_fa_density_1.set('fieldLabels', {'_uid_': 'no label', 'id': 'no label', 'name': 'no label', 'entries': 'no label', });
lyr_kmeans_2.set('fieldLabels', {'_uid_': 'no label', 'CLUSTER_ID': 'no label', 'CLUSTER_SIZE': 'no label', });
lyr_kmeans_2.on('precompose', function(evt) {
    evt.context.globalCompositeOperation = 'normal';
});