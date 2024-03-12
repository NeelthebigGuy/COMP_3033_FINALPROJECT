let api_key = "RGAPI-241bb55d-ac28-4b88-a3c7-8ca18e5a118b";

async function getSummonerInfo(summonerName) {
  try {
    const truesummoner = summonerName.replace(" ", "%20");
    const response = await fetch(
      `https://na1.api.riotgames.com/lol/summoner/v4/summoners/by-name/${truesummoner}?api_key=${api_key}`
    );

    if (!response.ok) {
      console.error(`Error getting summoner info. Status Code: ${response.status}`);
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
    const match_ids = await fetch(
      `https://americas.api.riotgames.com/lol/match/v5/matches/by-puuid/${puuid}/ids?api_key=${api_key}`
    );

    if (!match_ids.ok) {
      console.error(`Error getting matchlist. Status Code: ${response.status}`);
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
    const response = await fetch(
      `https://americas.api.riotgames.com/lol/match/v5/matches/${matchId}?api_key=${api_key}`
    );

    if (!response.ok) {
      console.error(`Error getting match details. Status Code: ${response.status}`);
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
      return null;
    }

    const puuid = summonerInfo.puuid;
    console.log(puuid);
    const matchIds = await getMatchList(puuid);
    console.log(matchIds);
    if (matchIds === null) {
      // Handle error
      return null;
    }

    const matchDetailsPromises = matchIds.map(matchId => getMatchDetails(matchId));
    const matches = await Promise.all(matchDetailsPromises);

    // Display the match data in the HTML
    let HTMLString = "<ul>";
    matches.forEach(match => {
      const participant = match.info.participants.find(participant => participant.puuid === puuid);
      const kda = `${participant.kills}/${participant.deaths}/${participant.assists}`;
      const championId = participant.championName;
      HTMLString += `<li>KDA: ${kda}, Champion ID: ${championId}</li>`;
    });
    HTMLString += "</ul>";

    $("#data_container").html(HTMLString);

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
