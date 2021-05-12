
var $ = jQuery;
var adforest_map_type = jQuery('#adforest_map_type').val();
var leaf_left_map = false;
var ad_google_map = false;

if (typeof adforest_map_type !== 'undefined' && adforest_map_type == 'leafletjs_map') {
    leaf_left_map = true;
} else {
    ad_google_map = true;
}

var isIE = false;
var map;
var circle = null;
var geocoder = new google.maps.Geocoder();
var iw = new google.maps.InfoWindow();
//var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(30, 30));
//var marker = new google.maps.Marker({
//    'icon': markerImage,
//    'optimized': false
//});







var check_rand = 0;
var max_zoom = 10;
var min_zoom = 11;

var mapLibsReady = 0;
function element_map(map_id = 'map') {

    map_id = typeof map_id !== 'undefined' ? map_id : 'map';
    var adforest_map_type = $('#adforest_map_type').val();

    var myString1 = String(map_id);
    var myString2 = document.getElementById(myString1);

    if (myString2 === null)
    {
        myString2 = "";
    }
    //var mapZoomAttr = $("#" + myString1+"").length > 0 ? $("#" + myString1).attr('data-map-zoom') : '';
    //var mapScrollAttr = $("#" + myString1+"").length > 0 ? $("#" + myString1).attr('data-map-scroll') : '';

    if (typeof mapZoomAttr !== 'undefined' && mapZoomAttr !== false) {
        var zoomLevel = parseInt(mapZoomAttr);
    } else {
        var zoomLevel = search_map_zoom;
    }
    if (typeof mapScrollAttr !== typeof undefined && mapScrollAttr !== false) {
        var scrollEnabled = parseInt(mapScrollAttr);
    } else {
        var scrollEnabled = false;
    }
    var currentInfobox;
    var ad_country = adforest_getUrlVars()['ad_country'];
    var country_id = adforest_getUrlVars()['country_id'];
    var cat_id = adforest_getUrlVars()['cat_id'];
    var ad_title = adforest_getUrlVars()['ad_title'];
    var loc_vars = false;
    loc_vars = typeof ad_country !== 'undefined' && ad_country != '' ? true : loc_vars;
    loc_vars = typeof country_id !== 'undefined' && country_id != '' ? true : loc_vars;
    loc_vars = typeof cat_id !== 'undefined' && cat_id != '' ? true : loc_vars;
    loc_vars = typeof ad_title !== 'undefined' && ad_title != '' ? true : loc_vars;

    if (loc_vars && typeof locations !== 'undefined' && locations != '') {
        search_map_lat = locations[0][1];
        search_map_long = locations[0][2];
    }
    var mapOptions;
    mapOptions = {
        zoom: zoomLevel,
        scrollwheel: scrollEnabled,
        center: new google.maps.LatLng(search_map_lat, search_map_long),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        panControl: false,
        navigationControl: false,
        streetViewControl: false,
        styles: [{"featureType": "administrative.land_parcel", "elementType": "all", "stylers": [{"visibility": "off"}]}, {"featureType": "landscape.man_made", "elementType": "all", "stylers": [{"visibility": "off"}]}, {"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "off"}]}, {"featureType": "road", "elementType": "labels", "stylers": [{"visibility": "simplified"}, {"lightness": 20}]}, {"featureType": "road.highway", "elementType": "geometry", "stylers": [{"hue": "#f49935"}]}, {"featureType": "road.highway", "elementType": "labels", "stylers": [{"visibility": "simplified"}]}, {"featureType": "road.arterial", "elementType": "geometry", "stylers": [{"hue": "#fad959"}]}, {"featureType": "road.arterial", "elementType": "labels", "stylers": [{"visibility": "off"}]}, {"featureType": "road.local", "elementType": "geometry", "stylers": [{"visibility": "simplified"}]}, {"featureType": "road.local", "elementType": "labels", "stylers": [{"visibility": "simplified"}]}, {"featureType": "transit", "elementType": "all", "stylers": [{"visibility": "off"}]}, {"featureType": "water", "elementType": "all", "stylers": [{"hue": "#a1cdfc"}, {"saturation": 30}, {"lightness": 49}]}]

    };
    map = new google.maps.Map(myString2, mapOptions);
    var markerCluster, marker, i;
    var allMarkers = [];
    var infoWindow = new google.maps.InfoWindow();
    for (var i = 0, len = locations.length; i < len; i++) {
        var markerData = {lat: parseFloat(locations[i][1]), lng: parseFloat(locations[i][2])};  // e.g. { lat: 50.123, lng: 0.123, text: 'XYZ' }

        var icon_cus = {
            url: imageUrl, // url
            scaledSize: new google.maps.Size(28, 43), // scaled size
        };
        var marker = new google.maps.Marker({
            position: markerData,
            id: i,
            icon: icon_cus,
            optimized: !isIE, // makes SVG icons work in IE
            map: map,
            draggable: false,
            animation: google.maps.Animation.DROP
        });

        allMarkers.push(marker);
        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infoWindow.setContent(locations[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));
    }



    var clusterStyles = [{
            textColor: '#ffffff',
            height: 43,
            width: 28,
            url: imageUrl_more,
            BackgroundSize: 'contain',
            anchor: [50, 0],
        },
    ];
    var cluster_options = {
        imagePath: imageUrl_more,
        gridSize: 50,
        styles: clusterStyles,
        maxZoom: 15
    };
    markerCluster = new MarkerClusterer(map, allMarkers, cluster_options);
    
    markerCluster.setMap(map);
    
    //markerCluster.setStyles(clusterStyles);
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        map.setOptions({
            draggable: false
        });
    }
    var zoomControlDiv = document.createElement('div');
    var zoomControl = new ZoomControl(zoomControlDiv, map);

    function ZoomControl(controlDiv, map) {
        zoomControlDiv.index = 1;
        map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(zoomControlDiv);
        controlDiv.style.padding = '5px';
        var controlWrapper = document.createElement('div');
        controlDiv.appendChild(controlWrapper);
        var zoomInButton = document.createElement('div');
        zoomInButton.className = "custom-zoom-in";
        controlWrapper.appendChild(zoomInButton);
        var zoomOutButton = document.createElement('div');
        zoomOutButton.className = "custom-zoom-out";
        controlWrapper.appendChild(zoomOutButton);
        google.maps.event.addDomListener(zoomInButton, 'click', function () {
            map.setZoom(map.getZoom() + 1);
        });
        google.maps.event.addDomListener(zoomOutButton, 'click', function () {
            map.setZoom(map.getZoom() - 1);
        });


}



}

function adforest_getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value;
    });
    return vars;
}


jQuery(document).ready(function ($) {

    $("#reset_state").click(function () {
        map.setCenter(new google.maps.LatLng(search_map_lat, search_map_long));
        map.setZoom(search_map_zoom);
    });

    // You current location 
    $("#you_current_location").click(function () {
        $.ajax({
            url: "https://geoip-db.com/jsonp",
            jsonpCallback: "callback",
            dataType: "jsonp",
            success: function (location) {
                //$('#country').html(location.country_name);
                //$('#state').html(location.state);
                //$('#city').html(location.city);
                //$('#latitude').html(location.latitude);
                //$('#longitude').html(location.longitude);
                //$('#ip').html(location.IPv4);
                var pos = new google.maps.LatLng(location.latitude, location.longitude);
                map.setCenter(pos);
                map.setZoom(search_map_zoom);
            }
        });
    });

});