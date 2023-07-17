

window.onload = getData();


/**
 *  Get location data from API
 */

async function getData() {

  const apiURL =  "https://ipapi.co/json/"
    
  try {
      const response = await fetch(apiURL, {cache: "no-cache"});
      const result = await response.json();
  
      if (response.ok) {
          console.log("the IP API result is: " , result);
         
          let ipAdress = result.ip;
          
          let countryCode = result.country_code;
          getFlagEmoji(countryCode);
          
          console.log(ipAdress);          
          getWeatherData(ipAdress);

          
      }

  } catch (error) {
      if (error) throw error;
      console.log("IP address API error ", error);
  
  }
}


/**
 * Get the weather data from API
 * @param {*} ipAddressInput
 * 
 */

async function getWeatherData(ipAddressInput) {

   const weatherUrl = "https://api.weatherapi.com/v1/current.json?key=" + weatherAPIKey + "&q=" + ipAddressInput + "&aqi=no";
   
  try {
      const weatherResponse = await fetch(weatherUrl, {cache: "no-cache"});
      const weatherResult = await weatherResponse.json();


      if (weatherResponse.ok) {
          console.log("the Weather API result is: " , weatherResult);

          let theWeather = weatherResult.current.temp_f;
          
          let theWeatherIcon = weatherResult.current.condition["icon"];
          let theDateTime = weatherResult.location.localtime;
          
          console.log("The weather is: " + theWeather);
          console.log("The weather icon is: " + theWeatherIcon);
          console.log("The date/time is: " + theDateTime);


         outPutWeather(theWeather);
         outputDateTime(theDateTime);
         outputWeahterIcon(theWeatherIcon);
      }

     

  } catch (error) {
      if (error) throw error;
      console.log("Weather API error: ", error);
  
  }
}

/**
 * Output the weather from API
 * @param {*} e 
 */

let outPutWeather = (e) => {
  weatherTemp.innerHTML = e;
}

/**
 * Output the date/time from API
 * @param {*} e 
 */

let outputDateTime = (e) => {
  
  let dateTime = document.getElementById("localTime");
  dateTime.innerHTML = e;
}

/**
 * Output the weather icon from API
 * @param {*} e 
 */

let outputWeahterIcon = (e) => {
  weatherIcon.innerHTML = "<img class='weather-icon' src='https:" + e +  "'>";
  
}

/**
 * Output the country emoji from API
 * @param {*} e 
 * @returns the country emoji
 */
let getFlagEmoji = (e) => {
  
  let countryIcon = document.getElementById("countryEmoji");
  

  let countryEmoji =  e.toUpperCase().replace(/./g, char => 
        String.fromCodePoint(127397 + char.charCodeAt())
    );
    console.log(countryEmoji);
    countryIcon.innerHTML = countryEmoji;
  }
