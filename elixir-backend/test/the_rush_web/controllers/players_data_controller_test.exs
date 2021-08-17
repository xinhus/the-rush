defmodule TheRushWeb.PlayersDataControllerTest do
  use TheRushWeb.ConnCase, async: true

  @moduletag :controllers_test

  setup %{conn: conn} do
    {:ok, conn: put_req_header(conn, "accept", "application/json")}
  end

  test "render fist result", %{conn: conn}  do
    conn = get conn, "/playersData?recordsPerPage=1&playerName="
    assert json_response(conn, 200) == [%{
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
  end

  test "render second result", %{conn: conn}  do
    conn = get conn, "/playersData?page=2&recordsPerPage=1"
    assert json_response(conn, 200) == [ %{
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
  end

  test "render first and second result", %{conn: conn}  do
    conn = get conn, "/playersData?page=1&recordsPerPage=2"
    assert json_response(conn, 200) == [ %{
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
              }, %{
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
  end

  test "render filter result", %{conn: conn}  do
    conn = get conn, "/playersData?page=1&recordsPerPage=1&playerName=Shaun+Hill"
    assert json_response(conn, 200) == [ %{
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
  end

  test "render sort by total rushing touchdown desc", %{conn: conn} do
    conn = get conn, "/playersData?page=1&recordsPerPage=1&order[Total%20Rushing%20Touchdowns]=Desc"
    assert json_response(conn, 200) == [ %{
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
  end

  test "render sort by total rushing touchdown asc", %{conn: conn} do
    conn = get conn, "/playersData?page=1&recordsPerPage=1&order[Total%20Rushing%20Touchdowns]=Asc"
    assert json_response(conn, 200) == [ %{
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
  end

  test "render sort by longest rush desc", %{conn: conn} do
    conn = get conn, "/playersData?page=1&recordsPerPage=1&order[Longest%20Rush]=Desc"
    assert json_response(conn, 200) == [%{
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
  end

  test "render sort by longest rush asc", %{conn: conn} do
    conn = get conn, "/playersData?page=1&recordsPerPage=1&order[Longest%20Rush]=Asc"
    assert json_response(conn, 200) == [ %{
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
  end

  test "render sort by total rushing yards desc", %{conn: conn} do
    conn = get conn, "/playersData?page=1&recordsPerPage=1&order[Total%20Rushing%20Yards]=Desc"
    assert json_response(conn, 200) ==  [ %{
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
  end

  test "render sort by total rushing yards asc", %{conn: conn} do
    conn = get conn, "/playersData?page=1&recordsPerPage=1&order[Total%20Rushing%20Yards]=Asc"
    assert json_response(conn, 200) == [ %{
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
  end

end
