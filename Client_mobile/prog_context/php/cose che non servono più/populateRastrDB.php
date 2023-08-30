<?php
  include "db_conn.php";

  $path_walk_data = '{
     "type": "FeatureCollection",
     "features": [
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.344264,44.48761 ]
      },
      "properties": {
      "Nome":"12 giugno 3"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.344435,44.503567 ]
      },
      "properties": {
      "Nome":"20 Settembre 126 e 7"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.341356,44.493782 ]
      },
      "properties": {
      "Nome":"4 Novembre 10"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.341034,44.49382 ]
      },
      "properties": {
      "Nome":"4 Novembre 16"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.334211,44.497208 ]
      },
      "properties": {
      "Nome":"Abbadia 6"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.344698,44.495796 ]
      },
      "properties": {
      "Nome":"Albari 5"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.351701,44.493195 ]
      },
      "properties": {
      "Nome":"Aldrovandi 4 e 6C 10 e 12"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.341408,44.505165 ]
      },
      "properties": {
      "Nome":"Amendola 14"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.345283,44.487728 ]
      },
      "properties": {
      "Nome":"Arienti angolo via Rubbiani"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.344556,44.494251 ]
      },
      "properties": {
      "Nome":"Artieri 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.332961,44.498821 ]
      },
      "properties": {
      "Nome":"Azzarita 7/g"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.334457,44.50206 ]
      },
      "properties": {
      "Nome":"Azzo Gardino 65"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.330085,44.49966 ]
      },
      "properties": {
      "Nome":"Battistelli 2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.349051,44.497646 ]
      },
      "properties": {
      "Nome":"Belle arti 11/13"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.353324,44.497662 ]
      },
      "properties": {
      "Nome":"Belle arti 56"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.338052,44.496407 ]
      },
      "properties": {
      "Nome":"Belvedere 6"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.35095,44.496094 ]
      },
      "properties": {
      "Nome":"Bibiena 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.338481,44.5051 ]
      },
      "properties": {
      "Nome":"Boldrini 13 (ang. Pietramellara)"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.334887,44.498493 ]
      },
      "properties": {
      "Nome":"Brugnoli 6"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.328768,44.494785 ]
      },
      "properties": {
      "Nome":"Calari 4"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.344883,44.491341 ]
      },
      "properties": {
      "Nome":"Calderini 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.331067000000001,44.500408 ]
      },
      "properties": {
      "Nome":"Calori 8"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.336217,44.489449 ]
      },
      "properties": {
      "Nome":"Capramozza 15"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.356905,44.487801 ]
      },
      "properties": {
      "Nome":"Carducci 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.349092,44.489605 ]
      },
      "properties": {
      "Nome":"Cartoleria 20"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.337751,44.488598 ]
      },
      "properties": {
      "Nome":"Castelfidardo 8"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.347887,44.488289 ]
      },
      "properties": {
      "Nome":"Castiglione 40"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.344092,44.491268 ]
      },
      "properties": {
      "Nome":"Cavour 1 e 4"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.341648,44.492268 ]
      },
      "properties": {
      "Nome":"Celestini 2 e 4"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.339747,44.488567 ]
      },
      "properties": {
      "Nome":"DAzeglio 53 (ang. Castelfidardo)"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.343759,44.501419 ]
      },
      "properties": {
      "Nome":"Dei Mille 5"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.351087,44.496513 ]
      },
      "properties": {
      "Nome":"Del Guasto 7"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.339715,44.501335 ]
      },
      "properties": {
      "Nome":"Del Porto 5/4 (ang. Marconi)"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.336732,44.502796 ]
      },
      "properties": {
      "Nome":"Don Minzoni 14 (MamBO)"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.337086,44.50285 ]
      },
      "properties": {
      "Nome":"Don Minzoni 15 (Ipsia Fioravanti)"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.335279,44.503296 ]
      },
      "properties": {
      "Nome":"Don Minzoni 17 ang. Pietramellara"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.34421,44.492638 ]
      },
      "properties": {
      "Nome":"Foscherari 2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.331099,44.49176 ]
      },
      "properties": {
      "Nome":"Foscolo 2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.33001,44.491932 ]
      },
      "properties": {
      "Nome":"Foscolo 7"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.344532,44.503952 ]
      },
      "properties": {
      "Nome":"Galliera 93"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.343177,44.492126 ]
      },
      "properties": {
      "Nome":"Galvani 5 (Piazza)"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.345111,44.496819 ]
      },
      "properties": {
      "Nome":"Goito 13"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.343223,44.497101 ]
      },
      "properties": {
      "Nome":"Goito 2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.344199,44.503952 ]
      },
      "properties": {
      "Nome":"Gramsci 12"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.340626,44.502491 ]
      },
      "properties": {
      "Nome":"Gramsci 4 (ang. Milazzo)"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.343266,44.497356 ]
      },
      "properties": {
      "Nome":"Indipendenza 22"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.343663,44.498917 ]
      },
      "properties": {
      "Nome":"Indipendenza 40"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.355186,44.49852 ]
      },
      "properties": {
      "Nome":"Irnerio 48 e 57"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.336335,44.497738 ]
      },
      "properties": {
      "Nome":"Lame 33"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.335745,44.498482 ]
      },
      "properties": {
      "Nome":"Lame 50 (ang. Riva di Reno)"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.335316,44.499115 ]
      },
      "properties": {
      "Nome":"Lame 59"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.338808,44.500072 ]
      },
      "properties": {
      "Nome":"Largo Caduti del Lavoro 2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.350454,44.496498 ]
      },
      "properties": {
      "Nome":"Largo Respighi 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.33611,44.494011 ]
      },
      "properties": {
      "Nome":"Malpighi 17-19"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.336786,44.495327 ]
      },
      "properties": {
      "Nome":"Malpighi 6"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.34289,44.496323 ]
      },
      "properties": {
      "Nome":"Manzoni angolo Indipendenza"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.339371,44.500687 ]
      },
      "properties": {
      "Nome":"Marconi 67 e 69"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.340551,44.502163 ]
      },
      "properties": {
      "Nome":"Martiri 1943-45 (P.za) 11"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.3504,44.499626 ]
      },
      "properties": {
      "Nome":"Mascarella 45 (ang. Irnerio)"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.343856,44.492626 ]
      },
      "properties": {
      "Nome":"Massei 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.347568,44.497932 ]
      },
      "properties": {
      "Nome":"Mentana 10"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.340331,44.503532 ]
      },
      "properties": {
      "Nome":"Milazzo 8"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.342107,44.487 ]
      },
      "properties": {
      "Nome":"Miramonte 17"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.340987,44.487392 ]
      },
      "properties": {
      "Nome":"Mirasole 11"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.341876,44.495537 ]
      },
      "properties": {
      "Nome":"Monte Grappa 3"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.340798,44.495686 ]
      },
      "properties": {
      "Nome":"Monte Grappa 8 9 e 10"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.342453,44.501972 ]
      },
      "properties": {
      "Nome":"Montebello 6"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.349789,44.503101 ]
      },
      "properties": {
      "Nome":"Mura di Porta Galliera 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.344136,44.493153 ]
      },
      "properties": {
      "Nome":"Musei 8"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.334672,44.491089 ]
      },
      "properties": {
      "Nome":"Nosadella 49/2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.346004,44.496849 ]
      },
      "properties": {
      "Nome":"Oberdan 24/h"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.346176,44.497463 ]
      },
      "properties": {
      "Nome":"Oberdan 7 e 9"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.345173,44.498035 ]
      },
      "properties": {
      "Nome":"Oche 2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.34112,44.495544 ]
      },
      "properties": {
      "Nome":"Oleari 4"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.346525,44.486423 ]
      },
      "properties": {
      "Nome":"Oro ang. Chiudare"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.341254,44.494781 ]
      },
      "properties": {
      "Nome":"Palazzo dAccursio"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.341324,44.494087 ]
      },
      "properties": {
      "Nome":"Palazzo dAccursio cortile interno"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.346066,44.492172 ]
      },
      "properties": {
      "Nome":"Piazza del Francia 3"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.340541,44.493114 ]
      },
      "properties": {
      "Nome":"piazza Galileo 6"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.345401,44.491661 ]
      },
      "properties": {
      "Nome":"Piazza Minghetti"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.348802,44.484909 ]
      },
      "properties": {
      "Nome":"Piazza Porta Castiglione 14"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.356189,44.498455 ]
      },
      "properties": {
      "Nome":"Piazza Porta S. Donato 2 e 5"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.342703,44.493252 ]
      },
      "properties": {
      "Nome":"Pignattari 3"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.33357,44.502216 ]
      },
      "properties": {
      "Nome":"Porta Lame presso l edicola"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.346946,44.494175 ]
      },
      "properties": {
      "Nome":"Porta Ravegnana fianco chiesa"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.327341,44.499012 ]
      },
      "properties": {
      "Nome":"Porta S. Felice 3"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.32802,44.494972 ]
      },
      "properties": {
      "Nome":"Porta S. Isaia (V.le Vicini 2)"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.33981,44.486614 ]
      },
      "properties": {
      "Nome":"Porta S. Mamolo 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.356063,44.484741 ]
      },
      "properties": {
      "Nome":"Porta S. Stefano 4"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.356734,44.493786 ]
      },
      "properties": {
      "Nome":"Porta S. Vitale 3"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.328935,44.495399 ]
      },
      "properties": {
      "Nome":"Pratello 100"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.334904,44.495579 ]
      },
      "properties": {
      "Nome":"Pratello 19"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.333103,44.495537 ]
      },
      "properties": {
      "Nome":"Pratello 25 e 35"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.329871,44.495464 ]
      },
      "properties": {
      "Nome":"Pratello 90/a e 96/f"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.353278,44.497173 ]
      },
      "properties": {
      "Nome":"Puntoni 2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.343899,44.494469 ]
      },
      "properties": {
      "Nome":"Re Enzo 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.352505,44.488178 ]
      },
      "properties": {
      "Nome":"Remorsella 15"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.350468,44.497093 ]
      },
      "properties": {
      "Nome":"Respighi 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.370423,44.499908 ]
      },
      "properties": {
      "Nome":"Riccio 2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.344783,44.499054 ]
      },
      "properties": {
      "Nome":"Righi 10"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.342045,44.498878 ]
      },
      "properties": {
      "Nome":"Riva Reno 126"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.332403,44.49839 ]
      },
      "properties": {
      "Nome":"Riva Reno 13"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.346179,44.494297 ]
      },
      "properties": {
      "Nome":"Rizzoli 38-40"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.348665,44.495338 ]
      },
      "properties": {
      "Nome":"Rossini Piazza 4"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.33689,44.495907 ]
      },
      "properties": {
      "Nome":"S. Felice 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.335994,44.496212 ]
      },
      "properties": {
      "Nome":"S. Felice 11"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.334237,44.496807 ]
      },
      "properties": {
      "Nome":"S. Felice 26"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.331212,44.497887 ]
      },
      "properties": {
      "Nome":"S. Felice 39 angolo via Riva Reno"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.348,44.490833 ]
      },
      "properties": {
      "Nome":"S. Giovanni in Monte 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.343153,44.500156 ]
      },
      "properties": {
      "Nome":"S. Giuseppe 5"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.35332,44.486923 ]
      },
      "properties": {
      "Nome":"S. Stefano 100/2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.354618,44.485813 ]
      },
      "properties": {
      "Nome":"S. Stefano 119 e 119/2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.349357,44.491009 ]
      },
      "properties": {
      "Nome":"S. Stefano 30"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.343773,44.490032 ]
      },
      "properties": {
      "Nome":"S.Domenico 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.346171,44.496639 ]
      },
      "properties": {
      "Nome":"S.Martino 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.351388,44.490459 ]
      },
      "properties": {
      "Nome":"S.Petronio Vecchio 1/2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.353901,44.494045 ]
      },
      "properties": {
      "Nome":"S.Vitale 59"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.354625,44.494011 ]
      },
      "properties": {
      "Nome":"S.Vitale 63"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.354842,44.494087 ]
      },
      "properties": {
      "Nome":"S.Vitale 67"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.356233,44.494068 ]
      },
      "properties": {
      "Nome":"S.Vitale 83"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.335061,44.490063 ]
      },
      "properties": {
      "Nome":"Saragozza 24"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.336936,44.490383 ]
      },
      "properties": {
      "Nome":"Saragozza 7"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.352316,44.49712 ]
      },
      "properties": {
      "Nome":"Scaravilli 2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.353858,44.495697 ]
      },
      "properties": {
      "Nome":"Selmi 3"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.335882,44.491699 ]
      },
      "properties": {
      "Nome":"Senzanome 3"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.340573,44.494606 ]
      },
      "properties": {
      "Nome":"Terribilia 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.355668,44.491714 ]
      },
      "properties": {
      "Nome":"Torleone 11"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.343785,44.488361 ]
      },
      "properties": {
      "Nome":"Tribunali (Piazza) 2 e 6"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.351696,44.496338 ]
      },
      "properties": {
      "Nome":"Trombetti 1"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.352782,44.49604 ]
      },
      "properties": {
      "Nome":"Trombetti 4"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.341796,44.4949 ]
      },
      "properties": {
      "Nome":"Ugo Bassi 2 10"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.337365,44.49564 ]
      },
      "properties": {
      "Nome":"Ugo Bassi 14"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.334364,44.499184 ]
      },
      "properties": {
      "Nome":"Via Brugnoli 6"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.33126,44.496105 ]
      },
      "properties": {
      "Nome":"via Pietralata 55/2"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.352868,44.496811 ]
      },
      "properties": {
      "Nome":"Zamboni 35"
      }
    },
    {
      "type": "Feature",
      "geometry": {
         "type": "Point",
         "coordinates":  [ 11.358495,44.495327 ]
      },
      "properties": {
      "Nome":"Zanolini 2"
      }
    }
  ]
  }';

  $data = json_decode($path_walk_data, true); //con true la funzione ritorna un array invece di un oggetto

  foreach ($data['features'] as $item) {
    $shape = $item['geometry'];
    $type = $item['geometry']['type'];
    $long = $item['geometry']['coordinates'][0];
    $lat = $item['geometry']['coordinates'][1];
    $geom1 = "POINT(".$long." ".$lat.")";
    $geom2 = "ST_GeomFromText(".$geom1.")";
    $name = $item['properties']['Nome'];

    //echo $coord." coordinate";
    /*echo "shape: ".json_encode($shape)."<br>";
    echo "type: ".$type."<br>";*/
    //echo "coord: ".json_encode($coord)."<br>";
    /*echo "mes: ".$mes."<br>";*/

    //$to_json_coord = array();
    //$to_json_coord[] = array('type' => $type, 'coordinates' => array($coord));
    //$coord = json_encode($coord);

    //$coord = trim($coord, '[]');
    $insert_query = "INSERT INTO rastrelliere(nome, bici_disp, lat, long, geom1, geom2) VALUES ('$name', '0', '$lat', '$long', '$geom1', '$geom2');";

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
