<?php
 /**
 * Template Name: contactus
 *
 * @package WordPress
 */
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

 ?>  
 <?php
 get_header();
 ?>   
 
 <!--Connect to the google maps api using your api key-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSa4sPxyqZcHOTyAshg3iwF10-Bcfhf3Q&sensor=true"></script>

<script src="infobox/infobox.js" type="text/javascript"></script>


<!--Main chunk of javascript that creates and controls the map.-->
<script type="text/javascript">

//Create the variables that will be used within the map configuration options.
//The latitude and longitude of the center of the map.
var cardiganMapCenter = new google.maps.LatLng(52.082816, -4.66125);
//The degree to which the map is zoomed in. This can range from 0 (least zoomed) to 21 and above (most zoomed).
var cardiganMapZoom = 16;
//The max and min zoom levels that are allowed.
var cardiganMapZoomMax = 20;
var cardiganMapZoomMin = 14;


//These options configure the setup of the map. 
var cardiganMapOptions = { 
		  center: cardiganMapCenter, 
          zoom: cardiganMapZoom,
		  //The type of map. In addition to ROADMAP, the other 'premade' map styles are SATELLITE, TERRAIN and HYBRID. 
          mapTypeId: google.maps.MapTypeId.ROADMAP,
		  maxZoom:cardiganMapZoomMax,
		  minZoom:cardiganMapZoomMin,
		  //Turn off the map controls as we will be adding our own later.
		  panControl: false,
		  mapTypeControl: false,
		  
		//turn off the mouse scroll for zoom in/out when a user scrolls up and down the web page 
		scrollwheel: false,
		navigationControl: true,
		mapTypeControl: false,
		scaleControl: false,
		draggable: true,



    styles: [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}]


		    
			
		  
};

//Create the variable for the main map itself.
var cardiganMap;

//When the page loads, the line below calls the function below called 'loadCardiganMap' to load up the map.
google.maps.event.addDomListener(window, 'load', loadCardiganMap);


 //Variable containing the style for the pop-up infobox.
var pop_up_info = "border: 0px solid black; background-color: #ffffff; padding:15px; margin-top: 8px; border-radius:10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; box-shadow: 1px 1px #888;";




//THE MAIN FUNCTION THAT IS CALLED WHEN THE WEB PAGE LOADS --------------------------------------------------------------------------------
function loadCardiganMap() {
	
//The empty map variable ('cariganMap') was created above. The line below creates the map, assigning it to this variable. The line below also loads the map into the div with the id 'cardigan-map' (see code within the 'body' tags below), and applies the 'cardiganMapOptions' (above) to configure this map. 
cardiganMap = new google.maps.Map(document.getElementById("cardigan-map"), cardiganMapOptions);	


//Calls the function below to load up all the map markers.
loadMapMarkers();



}



//Function that loads the map markers.
function loadMapMarkers (){

//Shop -----------------

//Setting the position of the Shop map marker.
var markerPositionShop1 = new google.maps.LatLng(52.083278, -4.661128);

//Creating the shop marker.
markerShop1 = new google.maps.Marker({
//uses the position set above.
position: markerPositionShop1,
//adds the marker to the map.
map: cardiganMap,
title: 'Good Bakers',
//sets the z-index of the map marker.
zIndex:107 });



//Setting the position of the Shop2 map marker.
var markerPositionShop2 = new google.maps.LatLng(52.082534, -4.661230);

//Creating the shop marker.
markerShop2 = new google.maps.Marker({
//uses the position set above.
position: markerPositionShop2,
//adds the marker to the map.
map: cardiganMap,
title: 'Fresh Produce',
//sets the z-index of the map marker.
zIndex:107




});


//SHOP1
//Creates the information to go in the pop-up info box.
var boxTextShop1 = document.createElement("div");
boxTextShop1.style.cssText = pop_up_info;
boxTextShop1.innerHTML = '<span class="pop_up_box_text"><a href="http://cardiganbasket.co.uk/goodbakers" target="_BLANK"><img src="content/goodbakers-logo.png" width="150" height="50" border="0" /></a></span>';
 
//Sets up the configuration options of the pop-up info box.
var infoboxOptionsShop1 = {
 content: boxTextShop1
 ,disableAutoPan: false
 ,maxWidth: 0
 ,pixelOffset: new google.maps.Size(20, -150)
 ,zIndex: null
 ,boxStyle: {
 background: "url('infobox/pop_up_box_top_arrow.png') no-repeat"
 ,opacity: 1
 ,width: "190px"
 }
 ,closeBoxMargin: "10px 2px 2px 2px"
 ,closeBoxURL: "icons/button_close.png"
 ,infoBoxClearance: new google.maps.Size(1, 1)
 ,isHidden: false
 ,pane: "floatPane"
 ,enableEventPropagation: false
};
 

//Creates the pop-up infobox for Cardigan, adding the configuration options set above.
infoboxShop1 = new InfoBox(infoboxOptionsShop1);
 
//Add an 'event listener' to the Shop map marker to listen out for when it is clicked.
google.maps.event.addListener(markerShop1, "click", function (e) {
 //Open the Cardigan info box.
 infoboxShop1.open(cardiganMap, this);
 //Changes the z-index property of the marker to make the marker appear on top of other markers.
 this.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
 //Zooms the map.
 setZoomWhenMarkerClicked();
 //Sets the Shop marker to be the center of the map.
 cardiganMap.setCenter(markerShop1.getPosition());
 
 

});

//SHOP2
//Creates the information to go in the pop-up info box.
var boxTextShop2 = document.createElement("div");
boxTextShop2.style.cssText = pop_up_info;
boxTextShop2.innerHTML = '<span class="pop_up_box_text"><a href="http://cardiganbasket.co.uk/freshproduce" target="_BLANK"><img src="content/freshproduce-logo.png" width="150" height="50" border="0" /></a></span>';
 
//Sets up the configuration options of the pop-up info box.
var infoboxOptionsShop2 = {
 content: boxTextShop2
 ,disableAutoPan: false
 ,maxWidth: 0
 ,pixelOffset: new google.maps.Size(20, -150)
 ,zIndex: null
 ,boxStyle: {
 background: "url('infobox/pop_up_box_top_arrow.png') no-repeat"
 ,opacity: 1
 ,width: "190px"
 }
 ,closeBoxMargin: "10px 2px 2px 2px"
 ,closeBoxURL: "icons/button_close.png"
 ,infoBoxClearance: new google.maps.Size(1, 1)
 ,isHidden: false
 ,pane: "floatPane"
 ,enableEventPropagation: false
};
 

//Creates the pop-up infobox for Cardigan, adding the configuration options set above.
infoboxShop2 = new InfoBox(infoboxOptionsShop2);
 
//Add an 'event listener' to the Shop map marker to listen out for when it is clicked.
google.maps.event.addListener(markerShop2, "click", function (e) {
 //Open the Cardigan info box.
 infoboxShop2.open(cardiganMap, this);
 //Changes the z-index property of the marker to make the marker appear on top of other markers.
 this.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
 //Zooms the map.
 setZoomWhenMarkerClicked();
 //Sets the Shop marker to be the center of the map.
 cardiganMap.setCenter(markerShop2.getPosition());
 
 
 

});




}



</script>

<div id="content">


    <p>Test</p>
      <!--Div to hold the map.-->
    		<div id="cardigan-map"></div>    
         

</div>

<?php
    get_footer();
 ?>   





