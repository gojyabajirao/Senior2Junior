function $_kav(element) {
    return document.getElementById(element);
}

var speedTest = {};
speedTest.pics = null;
speedTest.map = null;
speedTest.markers = [];
speedTest.infoWindow = null;

speedTest.init = function () {
    var infoboxOptions = {
        content: document.createElement("div"),
        disableAutoPan: false,
        boxClass: "asadInfomob",
		pixelOffset: new google.maps.Size(-160, -382),
        zIndex: null,
        closeBoxMargin: "-13px 0px 0px 0px",
        infoBoxClearance: new google.maps.Size(1, 1),
        closeBoxURL: document.getElementById('theme_path').value + "images/close.gif",
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: false
    };

    var latlng = new google.maps.LatLng(map_lat,  map_lon);
    var styles = [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"administrative","elementType":"labels","stylers":[{"saturation":"-100"}]},{"featureType":"administrative","elementType":"labels.text","stylers":[{"gamma":"0.75"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"lightness":"-37"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f9f9f9"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"saturation":"-100"},{"lightness":"40"},{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"labels.text.fill","stylers":[{"saturation":"-100"},{"lightness":"-37"}]},{"featureType":"landscape.natural","elementType":"labels.text.stroke","stylers":[{"saturation":"-100"},{"lightness":"100"},{"weight":"2"}]},{"featureType":"landscape.natural","elementType":"labels.icon","stylers":[{"saturation":"-100"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"saturation":"-100"},{"lightness":"80"}]},{"featureType":"poi","elementType":"labels","stylers":[{"saturation":"-100"},{"lightness":"0"}]},{"featureType":"poi.attraction","elementType":"geometry","stylers":[{"lightness":"-4"},{"saturation":"-100"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"},{"visibility":"on"},{"saturation":"-95"},{"lightness":"62"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},{"featureType":"road","elementType":"labels","stylers":[{"saturation":"-100"},{"gamma":"1.00"}]},{"featureType":"road","elementType":"labels.text","stylers":[{"gamma":"0.50"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"saturation":"-100"},{"gamma":"0.50"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"},{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"lightness":"-13"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"lightness":"0"},{"gamma":"1.09"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"},{"saturation":"-100"},{"lightness":"47"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"lightness":"-12"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"saturation":"-100"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"},{"lightness":"77"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"lightness":"-5"},{"saturation":"-100"}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"saturation":"-100"},{"lightness":"-15"}]},{"featureType":"transit.station.airport","elementType":"geometry","stylers":[{"lightness":"47"},{"saturation":"-100"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"water","elementType":"geometry","stylers":[{"saturation":"53"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"lightness":"-42"},{"saturation":"17"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"lightness":"61"}]}];
    var options = {
        zoom: zoom_option,
        scrollwheel: false,
        styles: styles,
		center: new google.maps.LatLng(map_lat,map_lon),
        'mapTypeId': google.maps.MapTypeId.ROADMAP
    };
    speedTest.map = new google.maps.Map($_kav('map'), options);
	speedTest.map.setCenter(new google.maps.LatLng(map_lat,map_lon));
    speedTest.pics = data.listings;
    speedTest.infoWindow = new InfoBox(infoboxOptions); 

    speedTest.showMarkers();

   
    var myoverlay = new google.maps.OverlayView();
    myoverlay.draw = function () {
        this.getPanes().markerLayer.id = 'markerLayer';
    };
    myoverlay.setMap(speedTest.map);
};

speedTest.showMarkers = function () {
    speedTest.markers = [];
    if (speedTest.markerClusterer) {
        speedTest.markerClusterer.clearMarkers();
    }
    var numMarkers = data.listings.length; 
    for (var i = 0; i < numMarkers; i++) {
        var titleText = speedTest.pics[i].listings_title;
        if (titleText === '') {
            titleText = '';
        }
        
        var item = document.createElement('DIV');
        var title = document.createElement('A');
        title.href = '#';
        title.className = 'title';
        title.innerHTML = titleText;

        var latLng = new google.maps.LatLng(speedTest.pics[i].latitude,
                speedTest.pics[i].longitude);

        var imageUrl = speedTest.pics[i].marker;

        var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(45, 75));

        var marker = new google.maps.Marker({
            'position': latLng,
            'icon': markerImage,
            'optimized': false

        });

        var fn = speedTest.markerClickFunction(speedTest.pics[i], latLng);
        google.maps.event.addListener(marker, 'click', fn);
        google.maps.event.addDomListener(title, 'click', fn);
        speedTest.markers.push(marker);



    }

    window.setTimeout(speedTest.time, 0);
};

speedTest.markerClickFunction = function (pic, latlng) {
    return function (e) {
        e.cancelBubble = true;
        e.returnValue = false;
        if (e.stopPropagation) {
            e.stopPropagation();
            e.preventDefault();
        }
        var title = pic.listings_title;
        var listings_url = pic.listings_url;
        var currency = pic.currency;
        var price = pic.price;
        var listings_cover = pic.listings_cover;
        var category = pic.cat;
        var category_url = pic.cat_url;
        var location = pic.location;
        var time = pic.time;
        var price_on_map = '';
        if( price != "" )
		{
        	var price_on_map	=	' <div class="price"><span>'+ price + ' ' + currency +'</span></div> ';
		}
        var html_listings = '<div class="category-grid-box-1" style="max-width: 360px ! important;width: 360px ! important; overflow: hidden;z-index: 1;"> ' +
            '<div class="image">' +
                '<img alt="" src="' + listings_cover + '" class="img-responsive" style="width: 100%;">' +
             '</div><div class="short-description-1 clearfix"> ' +
			' <div class="price-tag"> ' +
                    price_on_map +
                    ' </div> ' +
            '<div class="category-title"> <span><a href="' + category_url +'">' + category +'</a></span> </div> ' +
            ' <h3><a title="" href="' + listings_url +'">' + title +'</a></h3> ' +
			'<i class="fa fa-clock-o"></i> ' + time +
            ' </div> ' +
            ' <div class="ad-info-1"> ' +
            '<ul>' +
            '<li> <i class="fa fa-map-marker"></i><a href="#">' + location +'</a> </li>' +
            '</ul>' +
            '</div>' +
            '</div>';
        speedTest.infoWindow.setContent(html_listings);
        speedTest.infoWindow.setPosition(latlng);
        speedTest.infoWindow.open(speedTest.map);
    };
};



speedTest.clear = function () {
    for (var i = 0, marker; marker = speedTest.markers[i]; i++) {
        marker.setMap(null);
    }
};

speedTest.change = function () {
    speedTest.clear();
    speedTest.showMarkers();
};

speedTest.time = function () {

    var start = new Date();

    for (var i = 0, marker; marker = speedTest.markers[i]; i++) {
        marker.setMap(speedTest.map);
    }
    var end = new Date();
};




 