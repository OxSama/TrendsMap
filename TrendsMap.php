<?php

/**
 * TrendsMap
 * 
 */
class TrendsMap
{
    
    public $SearchStatus = 'Search';
    public $woeid;
    public $lattLong;
    public $latitude;
    public $longitude;
    public $trends;
    public $country;
    
    /**
     * WOEID
     *
     * @return void
     * "There is no WOEID for this country."1
     */
    public function getWOEID($country)
    {
        $this->country = $country;
        $ch = curl_init('twitterapi.pharma.com.sd?country='.$country);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $this->woeid = curl_exec($ch);
        curl_close($ch);
        return $this->woeid;
    }
    public function setStatus($status){
        $this->SearchStatus = $status;
    }
    public function getLatLong(){
        // if($this->SearchStatus === "Good Name"){
            echo $this->SearchStatus;
            $url = 'https://www.metaweather.com/api/location/search/?query='.$this->country;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            // print_r($response);
            curl_close($ch);
            $response = json_decode($response,false);
            $this->lattLong = $response[0]->latt_long;
            $this->woeid = $response[0]->woeid;
            // print_r($this->woeid);
            // print_r($this->lattLong);
            return $this->lattLong;
        // }else{
        //     return $this->lattLong = '0,0';
        // }
    }
    public function split(){
        $coordinates = explode(',',$this->lattLong);
        $this->latitude = $coordinates[0];
        $this->longitude = $coordinates[1];
        return explode(',',$this->lattLong); 
    }
    public function getTrends()
    {
        if(isset($this->woeid)){
        $url = 'https://twitterapi.pharma.com.sd/?woeid='.$this->woeid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);
        $this->trends = '';
        $counter =1;
        foreach($response as $trend){
            $this->trends .= "<b>".$counter .'.</b><u> ' .$trend['name']."</u> ";
            $counter++;
        }
        return $this->trends;
    }
    else {
        $this->country = 'wrong country name';
        return 'nowehere';
    }
    }
    
}

?>