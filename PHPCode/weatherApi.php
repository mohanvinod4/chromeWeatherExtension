<?php
/*
  +--------------------------------------------------------------------
  |
  |	File	: weatherApi.php
  |	Purpose	: get Weather details using Yahoo api based on location
  |	Created	: 17-June-2016
  |	Author	: Vinod Mohan
  |	Comments:
  |
  +--------------------------------------------------------------------
*/ 

//Yahoo url
define("YAHOO_URL", "http://query.yahooapis.com/v1/public/yql?q=");
  
class weatherAPI
{
    protected $result;

	/**
	* Get location URL
	*
	* @param string $location
	* @return url
	*/
    function getLocationURL($location = "bangalore")
    {
        return YAHOO_URL . urlencode(sprintf("select * from geo.places where text = '%s'", $location)) . "&format=json";
    }
    
    /**
	* Get weather URL
	*
	* @param integer $locationID
	* @return url
	*/
    function getWeatherURL($locationID)
    {
        return YAHOO_URL . urlencode(sprintf("select * from weather.forecast where woeid=%d and u='C'", $locationID)) . "&format=json";
    }

	/**
	* Get data from url
	*
	* @param string $url
	* @return array
	*/
    function getContent($url)
    {
        return json_decode(file_get_contents($url));
    }

    /**
	* Constructor, gets weather details based on location
	*
	* @param string $location
	*/
    function __construct($location)
    {
		//Get locationID
        $locationObject = $this->getContent($this->getLocationURL($location));
        $locationID = 0;
        if ($locationObject->query->count > 0) {
            if (is_array($locationObject->query->results->place)) {
                $locationID = $locationObject->query->results->place[0]->woeid;
            } else {
                $locationID = $locationObject->query->results->place->woeid;
            }
        }

		//Check locationID presence and get weather details
        if ($locationID > 0) {
            $weatherObject = $this->getContent($this->getWeatherURL($locationID));
            $data = array();

            $data['location'] = $weatherObject->query->results->channel->location;
            $data['locationID'] = $locationID;
            $data['currentStatus'] = $weatherObject->query->results->channel->item->condition;
            $data['currentStatus']->wind = $weatherObject->query->results->channel->wind->speed;
            $data['currentStatus']->humidity = $weatherObject->query->results->channel->atmosphere->humidity;

            $this->result = $data;
        } else {
            $this->result = array("error" => true, "errorMessage" => "No Location found");
        }
    }

	/**
	* return result array
	*
	* @return json data
	*/
    function getResult()
    {
        return $this->result ? json_encode($this->result) : null;
    }

}
