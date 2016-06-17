//Add click function on page load
$(document).ready(function(){
	$("#errorMsg").empty();
	$("#getWeather").click(function(){
		var location = $("#location").val();
		if(location.length>2) {
			$(".loader").show();
			getWeatherData(location);
		} else {
			showErrorMsg("Location must be greater than two characters");
		}
	});
});

//Show error message
function showErrorMsg(msg) {
	$("#errorMsg").empty();
	$("#errorMsg").append(msg);
}

//Get data from host
function getWeatherData(location) {
	$.getJSON(getUrl(location), {}, parseWeatherData);
}

//parse weather response and show respective details
function parseWeatherData(data) {

	//Check for error
	if(data.error) {
		showErrorMsg(data.errorMessage);
	} else {
		$("#errorMsg, #weatherDetails").empty();
		var details = "<br>Location: " + data.location.city + "<br/>Region: " + data.location.region;
		details = details + "<br/>Country: " + data.location.country + "<br/>";
		details = details + "Temperature: " + data.currentStatus.temp + " &#8451; (" + data.currentStatus.text + ")<br/>";
		details = details + "Wind: " + data.currentStatus.wind + " km/h<br/>Humidity: " + data.currentStatus.humidity + " %<br/>";
		$("#weatherDetails").append(details);
	}
	$(".loader").hide();
}
