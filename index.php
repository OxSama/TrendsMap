<?php
require_once('TrendsMap.php');
?>
<?php
    $woeid;
    $latLong;
    $coordinates;
    $trends;
    $trendMap =new TrendsMap;
    if(isset($_POST['search'])){
        $woeid = $trendMap->getWOEID($_POST['country']);
        // if(strcmp($woeid ,"There is no WOEID for this country.") !== 0){
        //     $trendMap->setStatus('Bad Name Search Again');
        // }else{
        $trendMap->setStatus('Good Name');
        $latLong = $trendMap->getLatLong();
        $coordinates = $trendMap->split();
        $trends = $trendMap->getTrends();
        // }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <title>TrendsMap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        div{
            width: 100%;
        }
        #map{
            width: 100%;
            height: 100%;
        }
        .height{
            height: 420px;
        }
        .flex{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .input{
            width: 500px;
        }
    </style>
</head>
<body>
    <!-- search  -->
    <div class="flex">
        <form action="" method="post">
            <div class="field">
              <label class="label"><?php echo $trendMap->SearchStatus; ?></label>
              <div class="control">
                <input class="input" type="text" placeholder="Search City Name" name="country">
              </div>
            </div>
            <div class="field is-grouped">
              <div class="control">
                <button class="button is-link" name="search">Search</button>
              </div>
            </div>
        </form>
    </div>

    <!-- map -->
    <div class="box height">
        <div id='map'>
            <script async
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiKfb1br1kFR3htMqM_jXD1tPIP2EhLmA&callback=initMap">
            </script>
            <script>
                // window.onload = function(){
                //     initMap();
                // };
                function initMap(){
                    const uluru = {
                        lat: <?php echo (isset($trendMap->latitude))? $trendMap->latitude : '0' ; ?>,
                        lng: <?php echo (isset($trendMap->longitude))? $trendMap->longitude : '0' ; ?>
                    }
                    const message = '<?php echo (isset($trends))? $trends : 'coordinate 0 , 0'; ?>';
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: uluru,
                        zoom: <?php echo isset($trendMap->lattLong)? '10' : '1'; ?>,
                        styles:[
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "elementType": "labels.icon",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#bdbdbd"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ffffff"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dadada"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#c9c9c9"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  }
]

                    });
                    const contentString =
                      '<div id="content">' +
                      '<div id="siteNotice">' +
                      "</div>" +
                      '<h1 id="firstHeading" class="firstHeading">Trending in <?php echo isset($trendMap->country)? $trendMap->country:'0,0'; ?></h1>' +
                      '<div id="bodyContent">' +
                      "<p>  "+ message+ "</p>" +
                      "</div>" +
                      "</div>";
                    const infowindow = new google.maps.InfoWindow({
                      content: contentString,
                    });
                    const marker = new google.maps.Marker({
                      position: uluru,
                      map,
                      title: "Uluru (Ayers Rock)",
                    });
                
                    marker.addListener("click", () => {
                      infowindow.open({
                        anchor: marker,
                        map,
                        shouldFocus: false,
                      });
                    });
                }
                function setMarker(message){
                    
                }
                
            </script>
        </div>
    </div>
    <!-- facebook -->
    <div class="columns">
        <div class="column is-2 is-offset-5">
            <!-- <div class="button is-dark"> -->
            <a 
                id="share-btn" 
                target="_blank"
                class="button is-fullwidth is-dark"
                href="https://www.facebook.com/dialog/share?app_id=393847578197746&display=popup&href=http%3A%2F%2F127.0.0.1%2F">
                  <i class="fab fa-facebook-f"></i>
                </a>
            <!-- </div> -->
        </div>
    </div>
</body>
</html>
