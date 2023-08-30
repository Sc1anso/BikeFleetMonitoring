<?php
  include "db_conn.php";

  $geof_walk_data = '{"type":"FeatureCollection","features":[{"type":"Feature","properties":{"name":"Piazza Maggiore"},"geometry":{"type":"Polygon","coordinates":[[[11.342439651489258,44.49486760765646],[11.342139244079588,44.49342882201176],[11.343705654144285,44.49327575762009],[11.34387731552124,44.49471454704115],[11.342439651489258,44.49486760765646]]]}},{"type":"Feature","properties":{"name":"BolognaCentro"},"geometry":{"type":"Polygon","coordinates":[[[11.33690357208252,44.496229829434164],[11.33690357208252,44.49567882221063],[11.346559524536133,44.49414821927133],[11.346774101257324,44.4946074043714],[11.33690357208252,44.496229829434164]]]}},{"type":"Feature","properties":{"name":"AreaMambo"},"geometry":{"type":"Polygon","coordinates":[[[11.333384513854979,44.50213752412924],[11.33565902709961,44.498556246977316],[11.338448524475098,44.49907661714579],[11.340036392211914,44.50204569925787],[11.33514404296875,44.50333123429596],[11.333384513854979,44.50213752412924]]]}},{"type":"Feature","properties":{"name":"AreaSaragozza"},"geometry":{"type":"Polygon","coordinates":[[[11.329607963562012,44.49191346683554],[11.32990837097168,44.49035215062323],[11.338105201721191,44.487168160591274],[11.339049339294434,44.49127057698653],[11.33437156677246,44.4935971923786],[11.329607963562012,44.49191346683554]]]}},{"type":"Feature","properties":{"name":"AreaIrnerio"},"geometry":{"type":"Polygon","coordinates":[[[11.347332000732422,44.50069891786176],[11.355915069580078,44.498250144708834],[11.3558292388916,44.50045404517453],[11.348791122436523,44.50323941130474],[11.347332000732422,44.50069891786176]]]}}]}';

  $data = json_decode($geof_walk_data, true); //con true la funzione ritorna un array invece di un oggetto

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
    $insert_query = "INSERT INTO geofence_vietate(nome, geometry) VALUES ('$name', '$coord');";

    echo $insert_query."<br><br>";

    $res = pg_query($db_connection, $insert_query);

    if ($res){
      echo "DB popolato <br>";
    }
  }
?>

<script>
  let data = '<?php echo $geof_walk_data;?>'
  console.log(JSON.parse(data).features)
</script>
