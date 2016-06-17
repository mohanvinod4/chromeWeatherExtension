//Web site url
var main_url = "http://localhost/projects";

//function to return url
function getUrl(location) {
	var url = main_url + "/weather.php?location=" + location;
		
	return url;
}

