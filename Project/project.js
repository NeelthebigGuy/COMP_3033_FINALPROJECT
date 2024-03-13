//API key for RIOT, modify when expired
let api_key = "RGAPI-c87f1658-3b9d-40ae-969e-52bd11291f43";

//Function to pull puuid from summoner name
async function getSummonerInfo(summonerName) {
  try {
    //replace spaces for DOM manipulation
    const truesummoner = summonerName.replace(" ", "%20");
    let htmlString = "https://na1.api.riotgames.com/lol/summoner/v4/summoners/by-name/";
        htmlString += truesummoner + "?api_key=" + api_key;
    //Await fetch from API
    const response = await fetch(htmlString);

    //Response to bad connection, with status response
    if (!response.ok) {
      let errorString = "Error getting summoner info. Status Code: " + response.status;
      console.error(errorString);
      return null;
    }

    //return of summer info as .json file
    return await response.json();

  //Error catching protocol
  } catch (error) {
    console.error("Error:", error);
    return null;
  }
}

//Function to get matchlist ids from puuid
async function getMatchList(puuid) {
  try {
    let htmlString = "https://americas.api.riotgames.com/lol/match/v5/matches/by-puuid/";
        htmlString += puuid + "/ids?api_key=" + api_key;
    //Await fetch from API
    const match_ids = await fetch(htmlString);

    //Response to bad connection, with status response
    if (!match_ids.ok) {
      let errorString = "Error getting matchlist. Status Code: " + response.status;
      console.error(errorString);
      return null;
    }

    //return of matchlist as .json file
    return await match_ids.json();

  //Error catching protocol
  } catch (error) {
    console.error("Error:", error);
    return null;
  }
}

//Function to get match details from match ids
async function getMatchDetails(matchId) {
  try {
    let htmlString = "https://americas.api.riotgames.com/lol/match/v5/matches/";
        htmlString += matchId + "?api_key=" + api_key;
    //Await fetch from API
    const response = await fetch(htmlString);

    //Response to bad connection, with status response
    if (!response.ok) {
      let errorString = "Error getting match details. Status Code: " + response.status;
      console.error(errorString);
      return null;
    }

    //return of match details as .json file
    return await response.json();
  
  //Error catching protocol
  } catch (error) {
    console.error("Error:", error);
    return null;
  }
}

//Main function to get match details from summoner name
async function getMatchHistory() {
  try {
    //Define summoner name from value entered by user
    const summonerName = $("#summoner").val();
    //Get puuid from summoner name
    const summonerInfo = await getSummonerInfo(summonerName);

    //Error handling for null entry
    if (summonerInfo === null) {
      let htmlString = "<p>Account not found</p>";
      $("#data_container").html(htmlString);
      return null;
    }

    //define puuid within function
    const puuid = summonerInfo.puuid;

    //define match ids from function
    const matchIds = await getMatchList(puuid);
    
    //Error handling for null value
    if (matchIds === null) {
      return null;
    }

    //Response for no matches found on account
    if (matchIds.length === 0) {
      let htmlString = "<p>No matches tracked on account</p>";
      $("#data_container").html(htmlString);
    }
    else {
      //Define indivdual matches from individual requests
      const matchDetailsPromises = matchIds.map(matchId => getMatchDetails(matchId));

      //Await returning of all asynch functions
      const matches = await Promise.all(matchDetailsPromises);

      // Display the match data in the HTML
      let htmlString = "<ul>";

      //Define variables for total stats and winrates
      let totalkills = 0;
      let totaldeaths = 0;
      let totalassists = 0;
      let winrate=0;

      //Loop for each match id
      matches.forEach(match => {
        //Define individual participate from match
        const participant = match.info.participants.find(participant => participant.puuid === puuid);
        //Define statline as string
        const kda = participant.kills+"/"+participant.deaths+"/"+participant.assists;
        //sum stats for total averages
        totalkills += participant.kills;
        totaldeaths += participant.deaths;
        totalassists += participant.assists;
        //Define champion name
        const championId = participant.championName;
        //API request for champion image
        const championImage = `<img src="https://ddragon.leagueoflegends.com/cdn/12.2.1/img/champion/${championId}.png" alt="${championId}" />`;
        htmlString += "<li>KDA: " + kda +", Champion: "+ championId;
        //Victory/Defeat message and tracking
        if(participant.win == true) {
          winrate++;
          htmlString += " Victory!" + championImage + "</li>";
        }
        else {
          htmlString += " Defeat" + championImage + "</li>";
        }
      });
      //round numbers to 1 decimal place
      totalkills = Math.round((totalkills / 20) * 10) / 10;
      totaldeaths = Math.round((totaldeaths / 20) * 10) / 10;
      totalassists = Math.round((totalassists / 20) * 10) / 10;

      //Display average KDA and Winrate in percentage form
      let avrKDA = (totalkills)+"/"+(totaldeaths)+"/"+(totalassists);
      winrate = (winrate / 20) * 100;
      htmlString += "</ul><br><p>Average KDA = "+avrKDA+" winrate = " + winrate + "%</p>";

      //Display as hmtl string within data container
      $("#data_container").html(htmlString);
    }

  //Error catching protocol
  } catch (error) {
    console.error("Error:", error);
    return null;
  }
}

//goClick function for hmtl functionality
async function goclick() {
  // Clear previous search results on button press
  $("#data_container").html("");
  console.log("The Go button was clicked!");

  // Display a loading indicator
  $("#data_container").html("<p>Loading...</p>");

  //Initiate main function
  try {
    await getMatchHistory();
  } 
  //Error catching protocol
  catch (error) {
    console.error("An error occurred:", error);
    $("#data_container").html("<p>Error retrieving match history</p>");
  }
}
