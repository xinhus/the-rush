defmodule TheRush.PlayerData.Repository.PlayerDataRepositoryTest do
  use TheRush.PlayerDataCase

  test "can filter by Name" do
    expected = [ %{
      "Player" => "Joe Banyard",
      "1st" => 0,
      "1st%" => 0,
      "20+" => 0,
      "40+" => 0,
      "Att" => 2,
      "Att/G" => 2,
      "Avg" => 3.5,
      "FUM" => 0,
      "Lng" => "7",
      "Pos" => "RB",
      "TD" => 0,
      "Team" => "JAX",
      "Yds" => 7,
      "Yds/G" => 7
    }]
    assert TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("./data/rushing.json", "Banyard", 1, 1, []) == expected
  end

  test "can load just the fist record" do
    expected = [ %{
      "Player" => "Joe Banyard",
      "1st" => 0,
      "1st%" => 0,
      "20+" => 0,
      "40+" => 0,
      "Att" => 2,
      "Att/G" => 2,
      "Avg" => 3.5,
      "FUM" => 0,
      "Lng" => "7",
      "Pos" => "RB",
      "TD" => 0,
      "Team" => "JAX",
      "Yds" => 7,
      "Yds/G" => 7
    }]
    assert TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("./data/rushing.json", "", 1, 1, []) == expected
  end

  test "can load just the second record" do
    expected = [ %{
      "Player" => "Shaun Hill",
      "1st" => 0,
      "1st%" => 0,
      "20+" => 0,
      "40+" => 0,
      "Att" => 5,
      "Att/G" => 1.7,
      "Avg" => 1,
      "FUM" => 0,
      "Lng" => "9",
      "Pos" => "QB",
      "TD" => 0,
      "Team" => "MIN",
      "Yds" => 5,
      "Yds/G" => 1.7
    }]
    assert TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("./data/rushing.json", "", 2, 1, []) == expected
  end

  test "can sort by total rushing touchdown desc" do
    expected = [ %{
      "Player" => "LeGarrette Blount",
      "1st" => 67,
      "1st%" => 22.4,
      "20+" => 7,
      "40+" => 3,
      "Att" => 299,
      "Att/G" => 18.7,
      "Avg" => 3.9,
      "FUM" => 2,
      "Lng" => "44",
      "Pos" => "RB",
      "TD" => 18,
      "Team" => "NE",
      "Yds" => "1,161",
      "Yds/G" => 72.6
    }]
    assert TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("./data/rushing.json", "", 1, 1, [:TotalRushingTouchdownDesc]) == expected
  end

  test "can sort by total rushing touchdown asc" do
    expected = [ %{
      "Player" => "Joe Banyard",
      "1st" => 0,
      "1st%" => 0,
      "20+" => 0,
      "40+" => 0,
      "Att" => 2,
      "Att/G" => 2,
      "Avg" => 3.5,
      "FUM" => 0,
      "Lng" => "7",
      "Pos" => "RB",
      "TD" => 0,
      "Team" => "JAX",
      "Yds" => 7,
      "Yds/G" => 7
    }]
    assert TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("./data/rushing.json", "", 1, 1, [:TotalRushingTouchdownAsc]) == expected
  end

  test "can sort by longest rush desc" do
    expected = [ %{
      "Player" => "Isaiah Crowell",
      "1st" => 45,
      "1st%" => 22.7,
      "20+" => 8,
      "40+" => 3,
      "Att" => 198,
      "Att/G" => 12.4,
      "Avg" => 4.8,
      "FUM" => 2,
      "Lng" => "85T",
      "Pos" => "RB",
      "TD" => 7,
      "Team" => "CLE",
      "Yds" => "952",
      "Yds/G" => 59.5
    }]
    assert TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("./data/rushing.json", "", 1, 1, [:LongestRushDesc]) == expected
  end

  test "can sort by longest rush asc" do
    expected = [ %{
      "Player" => "Taiwan Jones",
      "1st" => 0,
      "1st%" => 0,
      "20+" => 0,
      "40+" => 0,
      "Att" => 1,
      "Att/G" => 0.1,
      "Avg" => -8,
      "FUM" => 0,
      "Lng" => -8,
      "Pos" => "RB",
      "TD" => 0,
      "Team" => "OAK",
      "Yds" => -8,
      "Yds/G" => -0.6
    }]
    assert TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("./data/rushing.json", "", 1, 1, [:LongestRushAsc]) == expected
  end

  test "can sort by total rushing yards desc" do
    expected = [ %{
      "Player" => "Ezekiel Elliott",
      "1st" => 91,
      "1st%" => 28.3,
      "20+" => 14,
      "40+" => 3,
      "Att" => 322,
      "Att/G" => 21.5,
      "Avg" => 5.1,
      "FUM" => 5,
      "Lng" => "60T",
      "Pos" => "RB",
      "TD" => 15,
      "Team" => "DAL",
      "Yds" => "1,631",
      "Yds/G" => 108.7
    }]
    assert TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("./data/rushing.json", "", 1, 1, [:TotalRushingYardsDesc]) == expected
  end

  test "can sort by total rushing yards asc" do
    expected = [ %{
      "Player" => "Sam Koch",
      "1st" => 0,
      "1st%" => 0,
      "20+" => 0,
      "40+" => 0,
      "Att" => 2,
      "Att/G" => 0.1,
      "Avg" => -11.5,
      "FUM" => 0,
      "Lng" => 0,
      "Pos" => "P",
      "TD" => 0,
      "Team" => "BAL",
      "Yds" => -23,
      "Yds/G" => -1.4
    }]
    assert TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("./data/rushing.json", "", 1, 1, [:TotalRushingYardsAsc]) == expected
  end

end
