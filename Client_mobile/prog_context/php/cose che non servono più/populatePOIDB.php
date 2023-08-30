<?php
  include "db_conn.php";

  $path_walk_data = '{"type":"FeatureCollection","features":[{"type":"Feature","properties":{"name":"Bici Sport"},"geometry":{"type":"Polygon","coordinates":[[[11.34737491607666,44.48778047986505],[11.352696418762207,44.485729184996416],[11.353425979614258,44.48695384732689],[11.354670524597168,44.48891325357624],[11.350765228271484,44.49053583705292],[11.34737491607666,44.48778047986505]]]}},{"type":"Feature","properties":{"name":"ProntoAssistenza Bici"},"geometry":{"type":"Polygon","coordinates":[[[11.332311630249023,44.49264818941406],[11.335272789001465,44.49215837539017],[11.3358736038208,44.493260451158825],[11.332955360412598,44.49387270647577],[11.332311630249023,44.49264818941406]]]}},{"type":"Feature","properties":{"name":"BikeHelp"},"geometry":{"type":"Polygon","coordinates":[[[11.342267990112305,44.50152535558826],[11.341795921325684,44.50063769978638],[11.341924667358398,44.49913783686027],[11.34239673614502,44.49913783686027],[11.343469619750977,44.501494746992485],[11.342267990112305,44.50152535558826]]]}},{"type":"Feature","properties":{"name":"BikeUNIBO"},"geometry":{"type":"Polygon","coordinates":[[[11.353511810302734,44.497117552342864],[11.35462760925293,44.49650533109345],[11.353983879089355,44.49552576372451],[11.356472969055176,44.49503597386932],[11.356086730957031,44.49831136529107],[11.353511810302734,44.497117552342864]]]}},{"type":"Feature","properties":{"name":"SportBologna"},"geometry":{"type":"Polygon","coordinates":[[[11.340036392211914,44.491209349012244],[11.339735984802246,44.4885458699182],[11.342353820800781,44.48796417439378],[11.342740058898926,44.49133180489651],[11.340036392211914,44.491209349012244]]]}}]}';

  $data = json_decode($path_walk_data, true); //con true la funzione ritorna un array invece di un oggetto

  foreach ($data['features'] as $item) {
    $shape = $item['geometry'];
    $type = $item['geometry']['type'];
    $coord = $item['geometry']['coordinates'][0];
    $name = $item['properties']['name'];

    /*echo "shape: ".json_encode($shape)."<br>";
    echo "type: ".$type."<br>";*/
    //echo "coord: ".json_encode($coord)."<br>";
    /*echo "mes: ".$mes."<br>";*/

    $to_json_coord = array();
    $to_json_coord[] = array('type' => $type, 'coordinates' => array($coord));
    $coord = json_encode($coord);

    //$coord = trim($coord, '[]');
    $insert_query = "INSERT INTO poi(nome, point) VALUES ('$name', '$coord');";

    echo $insert_query."<br><br>";

    $res = pg_query($db_connection, $insert_query);

    if ($res){
      echo "DB popolato <br>";
    }
  }
?>

<script>
  let data = '<?php echo $path_walk_data;?>'
  console.log(JSON.parse(data).features)
</script>
