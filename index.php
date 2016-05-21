<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta content="" name="description">
<meta content="" name="author">
<title>Trajectory finder</title>
<link href="css/bootstrap.min.css" rel="stylesheet" />
<link href="css/main.css" rel="stylesheet" />
<link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet" />
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jcarousel.min.js"></script>
<script src="js/jcarousel.ajax.js"></script>

<script type="text/javascript"
	src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false"></script>
<script src="js/main.js"></script>
<script src="js/gallery.js"></script>
<script src="js/ie-emulation-modes-warning.js"></script>
<script src="js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript">
                var map = null;
                var data = [];
                var gmarkers = [];
                var tmarkers = [];
                var trajectory = null;
                function loadMap() {
                  var latlng = new google.maps.LatLng(33.77229828866843 , -118.37871551513672);
                  
                  var myOptions = {
                    zoom: 10,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.Terrian
                  };
                  
                  map = new google.maps.Map(document.getElementById("map_container"),myOptions);
                  google.maps.event.addListener(map, 'click', function( event ){
                    //alert( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() );
                    data.push(event.latLng);
                    marker = new google.maps.Marker({
                            position: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()),
                            map: map
                    });
                    tmarkers.push(marker);
                    if(data.length > 1){
                        if(trajectory != null){
                            trajectory.setMap(null);
                        }
                        trajectory = new google.maps.Polyline({
                            path: data,
                            strokeColor: '#000000',
                            strokeOpacity: 1.0,
                            strokeWeight: 2,
                            editable: false
                        });
                        trajectory.setMap(map);
                    }
                    
                    $("#trajectory").append('<div class="bs-callout bs-callout-danger"><h6>Lat: '+event.latLng.lat()+' Lng: '+event.latLng.lng()+' <span id="remove" class="glyphicon glyphicon-remove pull-right"> </span></h6><input type="text" class="form-control input-sm" placeholder="Activity"> </div>')
                    var loc = $("#location").val();
                    $("#location").val(loc +event.latLng.lat()+','+event.latLng.lng()+';');
                  });          
                }
                
            </script>
<link rel="icon" type="image/x-icon" href="favicon.ico" />
</head>
<body onload="loadMap()">
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Trajectory Finder</a>
			</div>
	
	</nav>
	<div class="container">
		<div class="row">
			<div class="div_column1">
				<h5>Top visiting places</h5>
				<hr id="hr">
				<div id="top-k">
					<img src="images/2.jpg" class="img-thumbnail"> <img
						src="images/3.jpg" class="img-thumbnail"> <img src="images/4.jpg"
						class="img-thumbnail"> <img src="images/6.jpg"
						class="img-thumbnail">
				</div>
			</div>
			<div class="div_column2">

				<div id="map_container"></div>
			</div>
			<div class="div_column3">
				<div class="search-form">
					<label for="algorithm" class="col-sm-4 control-label">Semantic:</label>
					<div class="col-sm-8 indent">
						<label class="radio-inline"> <input type="radio" name="algorithm"
							value="BF" checked> TF-IDF
						</label> <label class="radio-inline"> <input type="radio"
							name="algorithm" value="ETQ"> Conjunc
						</label> <label class="radio-inline"> <input type="radio"
							name="algorithm" value="ETQ-O">Disjunc
						</label>
					</div>
					<div class="clearfix"></div>
					<label for="count" class="col-sm-4 control-label">Result Count:</label>
					<div class="col-sm-8">
						<select id="result" class="form-control input-sm">
							<option>10</option>
							<option>20</option>
							<option>30</option>
							<option>40</option>
							<option>50</option>
						</select>
					</div>
					</br>
					<div class="row1">
						<div id="info">
							<div id="marker"></div>
							<div id="trajectory"></div>
						</div>
					</div>
					<div class="col-sm-offset-4 col-sm-8">
						<input type="hidden" id="location" value="" />
						<button type="button" id="search" class="btn btn-sm btn-primary">Search</button>
					</div>
				</div>

			</div>
			<div class="row2" id="places">
				<h5>Places around trajectory</h5>
				<hr id="hr">
				<div class="jcarousel-wrapper">
					<div class="jcarousel" data-jcarousel="true">
						<ul style="left: 0px; top: 0px;" id="carousel-photo">
							<li><img alt="Image 1" src="images/slider/01.jpg"
								class="thumbnail"></li>
							<li><img alt="Image 2" src="images/slider/02.jpg"
								class="thumbnail"></li>
							<li><img alt="Image 3" src="images/slider/03.jpg"
								class="thumbnail"></li>
							<li><img alt="Image 4" src="images/slider/04.jpg"
								class="thumbnail"></li>
							<li><img alt="Image 5" src="images/slider/05.jpg"
								class="thumbnail"></li>
							<li><img alt="Image 6" src="images/slider/06.jpg"
								class="thumbnail"></li>
							<li><img alt="Image 7" src="images/slider/07.jpg"
								class="thumbnail"></li>
							<li><img alt="Image 8" src="images/slider/08.jpg"
								class="thumbnail"></li>
						</ul>
					</div>
					<a data-slide="prev" href="#carousel"
						class="jssora05l jcarousel-control-prev"
						data-jcarouselcontrol="true"
						style="top: 60px; left: 15px; width: 40px; height: 40px;"></a> <a
						data-slide="next" href="#carousel"
						class="jssora05r jcarousel-control-next"
						data-jcarouselcontrol="true"
						style="top: 60px; right: 15px; width: 40px; height: 40px;"></a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<button type="button" id="load" class="btn btn-default">Load more</button>
				<p id="points"></p>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body"></div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div style="display: none">
		<ul id="full-list">
			<li><img alt="Image 1" src="images/slider/01.jpg" class="thumbnail"></li>
			<li><img alt="Image 2" src="images/slider/02.jpg" class="thumbnail"></li>
			<li><img alt="Image 3" src="images/slider/03.jpg" class="thumbnail"></li>
			<li><img alt="Image 4" src="images/slider/04.jpg" class="thumbnail"></li>
			<li><img alt="Image 5" src="images/slider/05.jpg" class="thumbnail"></li>
			<li><img alt="Image 6" src="images/slider/06.jpg" class="thumbnail"></li>
			<li><img alt="Image 7" src="images/slider/07.jpg" class="thumbnail"></li>
			<li><img alt="Image 8" src="images/slider/08.jpg" class="thumbnail"></li>
		</ul>
	</div>
	<hr>
</body>
</html>