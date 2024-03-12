let api_key = "RGAPI-241bb55d-ac28-4b88-a3c7-8ca18e5a118b";

async function getSummonerInfo(summonerName) {
  try {
    const truesummoner = summonerName.replace(" ", "%20");
    let htmlString = "https://na1.api.riotgames.com/lol/summoner/v4/summoners/by-name/";
        htmlString += truesummoner + "?api_key=" + api_key;
    const response = await fetch(htmlString);

    if (!response.ok) {
      let errorString = "Error getting summoner info. Status Code: " + response.status;
      console.error(errorString);
      return null;
    }

    return await response.json();
  } catch (error) {
    console.error("Error:", error);
    return null;
  }
}

async function getMatchList(puuid) {
  try {
    let htmlString = "https://americas.api.riotgames.com/lol/match/v5/matches/by-puuid/";
        htmlString += puuid + "/ids?api_key=" + api_key;
    const match_ids = await fetch(htmlString);

    if (!match_ids.ok) {
      let errorString = "Error getting matchlist. Status Code: " + response.status;
      console.error(errorString);
      return null;
    }

    return await match_ids.json();
  } catch (error) {
    console.error("Error:", error);
    return null;
  }
}

async function getMatchDetails(matchId) {
  try {
    let htmlString = "https://americas.api.riotgames.com/lol/match/v5/matches/";
        htmlString += matchId + "?api_key=" + api_key;
    const response = await fetch(htmlString);

    if (!response.ok) {
      let errorString = "Error getting match details. Status Code: " + response.status;
      console.error(errorString);
      return null;
    }

    return await response.json();
  } catch (error) {
    console.error("Error:", error);
    return null;
  }
}

async function getMatchHistory() {
  try {
    const summonerName = $("#summoner").val();
    const summonerInfo = await getSummonerInfo(summonerName);

    if (summonerInfo === null) {
      // Handle error
      let htmlString = "<p>Account not found</p>";
      $("#data_container").html(htmlString);
      return null;
    }

    const puuid = summonerInfo.puuid;
    const matchIds = await getMatchList(puuid);
    if (matchIds === null) {
      // Handle error
      return null;
    }
    if (matchIds.length === 0) {
      let htmlString = "<p>No matches tracked on account</p>";
      $("#data_container").html(htmlString);
    }
    else {
      const matchDetailsPromises = matchIds.map(matchId => getMatchDetails(matchId));
      const matches = await Promise.all(matchDetailsPromises);

      // Display the match data in the HTML
      let htmlString = "<ul>";
      matches.forEach(match => {
        const participant = match.info.participants.find(participant => participant.puuid === puuid);
        const kda = participant.kills+"/"+participant.deaths+"/"+participant.assists;
        const championId = participant.championName;
        const champImage = "C://Users//User//Desktop//Winter 2024 Semester//Full-Stack Cloud Computing//Project//Data//";
              champImage +=
        htmlString += "<li>KDA: " + kda +", Champion: "+ championId + "</li>";
      });
      htmlString += "</ul>";

      $("#data_container").html(htmlString);
    }

  } catch (error) {
    console.error("Error:", error);
    return null;
  }
}

async function goclick() {
  // Clear previous search results on button press
  $("#data_container").html("");
  console.log("The Go button was clicked!");

  // Display a loading indicator
  $("#data_container").html("<p>Loading...</p>");

  try {
    await getMatchHistory();
  } catch (error) {
    console.error("An error occurred:", error);
    $("#data_container").html("<p>Error retrieving match history</p>");
  }
}
