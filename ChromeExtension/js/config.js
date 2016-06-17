//Web site url
var main_url = "http://localhost/projects/weather.php";

//function to return url
function getUrl(location) {
	var url = main_url + "?location=" + location;
		
	return url;
}

