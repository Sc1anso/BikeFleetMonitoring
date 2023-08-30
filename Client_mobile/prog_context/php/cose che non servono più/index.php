<?php
  include "db_conn.php";
  //include "populateDB.php";
  //include "populatePOIDB.php";
  //include "populateRastrDB.php";

  //echo "ciao";
  $getpaths = "select st_x(a.geom) as x, st_y(a.geom) as y, max_bici, name from rastrelliere as a;";

  $result = pg_query($db_connection, $getpaths);

  $dbres = array();
  $dbres = pg_fetch_all($result);
  while ($row = pg_fetch_row($result)) {
    //$dbres[] = $row;
  //echo "long: $row[0]  lat: $row[1]   max bici: $row[2]   name: $row[3]";
  //echo "<br />\n";
  }
  //echo json_encode($dbres);

  //echo "RISULTATO QUERY ".$result;
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Benvenuto su Idromardi, il servizio di lettura acqua online veloce e facile da usare.">
    <meta property="og:url" content="www.idromardi.it">
    <meta property="og:description" content="Idromardi offre un servizio online ai sui clienti per tenerli sempre aggiornati sul loro consumo. Essi, possono inoltre inviare richieste di letture nel caso non siano in casa il giorno della lettura! ">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="icon" href="pics/website.png" type="image/gif" sizes="16x16">
	<title>GeoTrend Admin Page</title>


	<!-- Google font -->
    	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round" rel="stylesheet">
    	 <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.1.1/css/ol.css" type="text/css">

    	<!-- Bootstrap -->
    	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    	 <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
    	 <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

    	<!-- Font Awesome Icon -->
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
	    <!-- Custom stlylesheet -->
		<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.1.1/build/ol.js"></script>

		<link rel="stylesheet" href=" https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">


    <style>
      .map {
        height: 80vh;
        width: 90%;
        margin:0 auto;
        text-align: center;
      }
      object
      {
      	  height: 60vh;
        width: 70%;
        margin:0 auto;
        text-align: center;
      }
      h2
      {
      	color:grey;
      }
    </style>
</head>

<body style='background: url("pics/ab.jpg") ;background-size: auto;'>

	<div style='width:80%;margin:0 auto;text-align: center'>

		<h2>Pannello di Controllo - GeoTrend V1</h2>

		<br>
		<br>
		<br>

		<div style='width:60%;margin:0 auto;text-align: center;background-color:#298fca;opacity: 0.9; border-radius: 10px;height:250px;' ><br>
			<div style='margin:0 auto;text-align: center;'><legend style="color:black;">Registered Users</legend>
				<select style='border-radius: 5px;' onchange="loadPathOfUser(this.value)" id='users'><?php echo $users; ?></select> <br> <br>
		    </div>
		    <div style='margin:0 auto;text-align: center; background-color:white; width:95%; border-radius:10px;'>
		    	<br><legend>Option Menu</legend>
		    	<button class='btn btn-primary' id='Pusers' onclick='loadPOI()'>POI</button> &nbsp;&nbsp;
				<button class='btn btn-primary' id='Pusers' onclick='loadRastr()'>Rastrelliere</button> &nbsp;&nbsp;
				<button class='btn btn-success' id='Kmeans' onclick='displayKmeans()' >K-MEANS CLUSTER (K=2) </button>&nbsp;&nbsp;
				<button class='btn btn-success' id='Kmeans' onclick='loadFences()'>Aree vietate</button>
        <input type="button" value="Say hello" onClick="showAndroidToast('Hello Android!')" />

				 <br> <br>
		    </div>
		</div>
		<br> <br><br> <br>
		<div id="map" class="map"></div>
		<br>
		<br>
	</div>

</body>
<script type="text/javascript">

function showAndroidToast(toast) {
    Android.showToast(toast);
}

	 var fences = new ol.style.Style({
		        stroke: new ol.style.Stroke({
		          color: [255,0,0,0.6],
		          width: 2
		        }),
		        fill: new ol.style.Fill({
		          color: [255,0,0,0.2]
		        }),
		        zIndex: 1
      });
      var ras_color = new ol.style.Style({
   		        image: new ol.style.Circle({
                color: [255,0,0,0.2],
                fill: new ol.style.Fill({color: 'lime'}),
                radius: 5
   		        }),
   		        zIndex: 1
         });



     let x = '<?php echo (double)11.3586; ?>';
     let y = '<?php echo (double)44.4498; ?>';


	var geoLayer = null;
	var map = null;
     function loadFences()
     {
     	$("#map").html("");

		map = new ol.Map({
					target: 'map',
			        layers: [
			            new ol.layer.Tile({
			              source: new ol.source.OSM()
			            })
			        ],
			        view: new ol.View({
			            center: ol.proj.fromLonLat([parseFloat(x), parseFloat(y)]),
			            zoom: 12
			       	})
		      	 });
      if(geoLayer != null){map.removeLayer(geoLayer); }
     	geoLayer = new ol.layer.Vector({
		       title: 'GeoJSON Layer',
		       source: new ol.source.Vector({
	             projection : 'EPSG:4326',
	             url: "res/areevietate_geofence.geojson",
	             format: new ol.format.GeoJSON()
	         }),
		       style: function(feature, resolution) {
				      return fences;
				}

	      });
			map.addLayer(geoLayer);

     }

     function loadPOI()
     {
     	$("#map").html("");

		map = new ol.Map({
					target: 'map',
			        layers: [
			            new ol.layer.Tile({
			              source: new ol.source.OSM()
			            })
			        ],
			        view: new ol.View({
			            center: ol.proj.fromLonLat([parseFloat(x), parseFloat(y)]),
			            zoom: 12
			       	})
		      	 });
        if(geoLayer != null){map.removeLayer(geoLayer); }
     	  geoLayer = new ol.layer.Vector({
		       title: 'GeoJSON Layer',
		       source: new ol.source.Vector({
	             projection : 'EPSG:4326',
	             url: "res/poi_geofence.geojson",
	             format: new ol.format.GeoJSON()
	         }),
		       style: function(feature, resolution) {
				      return fences;
				}

	      });
			map.addLayer(geoLayer);

     }

     function loadRastr()
     {
     	$("#map").html("");

		map = new ol.Map({
					target: 'map',
			        layers: [
			            new ol.layer.Tile({
			              source: new ol.source.OSM()
			            })
			        ],
			        view: new ol.View({
			            center: ol.proj.fromLonLat([parseFloat(x), parseFloat(y)]),
			            zoom: 12
			       	})
		      	 });
        if(geoLayer != null){map.removeLayer(geoLayer); }
     	  geoLayer = new ol.layer.Vector({
		       title: 'GeoJSON Layer',
		       source: new ol.source.Vector({
	             projection : 'EPSG:4326',
	             url: "res/rastrelliere.json",
	             format: new ol.format.GeoJSON()
	         }),
           style:function(feature, resolution){
             //console.log("resolution" + resolution);
             return(ras_color);
				}

	      });
        //console.log("cazoooo");
			map.addLayer(geoLayer);

     }
     /*function loadPathOfUser(userP)
     {

     		if(userP != "All Users")
     		{
	     		  if(geoLayer != null){map.removeLayer(geoLayer); }

				   geoLayer = new ol.layer.Vector({
			       title: 'Paths',
			       source: new ol.source.Vector({
		             projection : 'EPSG:4326',
		             url: "Paths/"+userP+".json",
		             format: new ol.format.GeoJSON()
		         	}),
			       	style:function(feature)
			       	{
			       		return(
			       			new ol.style.Style({
								image: new ol.style.Circle({
								            radius: 5,
								            fill: new ol.style.Fill({color: 'lime'})
								})
							})
			       		);
			       	}
		       });

		      map.addLayer(geoLayer);
	  	}
	  	else
	  	{
	  		if(geoLayer != null){map.removeLayer(geoLayer); }

	  		 <?php



				/*$holder = array();
				$color  = "#FF5733"; //default color
				while($row = pg_fetch_object($result))
			    {

			    	$lastX = $row->x;
			    	$lastY = $row->y;
			    	//print_r($holder);

			    	//change color based on device_id
			    	if(count($holder) == 0)
			    	{
			    		array_push($holder, $row->device_id);

			    	}
			    	else
			    	{

			    		if($holder[0] != $row->device_id )
				    	{
				    		$color = rand_color();
				    		$holder = array();
				    		array_push($holder, $row->device_id);

				    	}

			    	}
			        //-------------------------

			        $geometry[] = [
			        	"type" => "Feature",
			        	"geometry" =>  array(
									        "type" => "Point",
									        "coordinates" => array((double)$row->x,(double)$row->y)
									    ),
			        	"properties" => array(
			        						"device_id" => $row->device_id,
			        						"marker-color" => $color
			        					)

			        ];


			    }

			    $fullgeojson=array("type"=>"FeatureCollection", "features" => $geometry);

			    $encoded = json_encode($fullgeojson, JSON_NUMERIC_CHECK );
			    $path = getcwd();
			    $path .= '/requests/all_users.json';



				if (file_exists($path))
				{
				    unlink ($path);
				    file_put_contents($path, $encoded);

				    if (file_exists($path)) {

				    } else {
				         echo "An Error occured";
				    }
				}
				else
				{
				    file_put_contents($path, $encoded);

				    if (file_exists($path)){

				    } else {
				         echo "An Error Occured";
				    }

				}*/
	  		?>

	  		 geoLayer = new ol.layer.Vector({
			       title: 'Requests',
			       source: new ol.source.Vector({
		             projection : 'EPSG:4326',
		             url: "requests/all_users.json",
		             format: new ol.format.GeoJSON()
		         	}),
			       	style: function(feature, resolution) {
			        return (new ol.style.Style({
							       image: new ol.style.Circle({
							           radius: 5,
							           fill: new ol.style.Fill({ color: feature.get('marker-color') })
							      }),
							    zIndex: 5
							})
					);
					}
		       });

		      map.addLayer(geoLayer);

	  	}
    }*/
    function displayVF()
	{
		document.getElementById("map").innerHTML='<br> <label style="color:blue;font-size:20px;">QUERY USED: select st_crosses(geometry, st_makeline(path)), st_astext(geometry) <br>from geotrend.pathwalk, geotrend.walk<br> group by geometry</label><object type="text/html"  data="requests/qgis2web_2020_02_08-17_05_18_143667/index.html" ></object>';
	}
	function displayQt()
	{
		document.getElementById("map").innerHTML='<br> <label style="color:blue;font-size:20px;">QUERY USED: select st_astext(geometry) as fence, count( distinct token) as numero_utenti <br> from geotrend.walk left join geotrend.paths on <br>st_contains(geometry, st_setsrid(point, 4326)) <br>group by geometry</label><object type="text/html"  data="requests/qgis2web_2020_02_12-17_35_06_099357/index.html" ></object>';
	}
	function displayKmeans()
	{
		document.getElementById("map").innerHTML='<object type="text/html"  data="requests/qgis2web_2020_02_12-17_52_27_043578/index.html" ></object>';
	}

    </script>
</html>
