defmodule TheRushWeb.PlayersDataController do
  use TheRushWeb, :controller

  def getPlayers(conn, params) do
    conn = conn
      |> put_resp_header("Access-Control-Allow-Origin", "*")
    render conn, "content_raw.json", response: TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("./data/rushing.json", getPlayerNameParam(params), getPageParam(params), getRecordsPerPageParam(params), getOrderParam(params))
  end

  def exportPlayers(conn, params) do
  conn
  |> put_resp_header("Access-Control-Allow-Origin", "*")
  |> put_resp_content_type("text/csv, application/force-download, application/octet-stream, application/download")
  |> put_resp_header("content-disposition", ~s[attachment; filename="players_data.csv"])
  |> resp(200,TheRush.PlayerData.UseCase.PlayerDataUseCase.getRecordsAsCsv(TheRush.PlayerData.Repository.PlayerDataRepository, "./data/rushing.json", getPlayerNameParam(params), getPageParam(params), getRecordsPerPageParam(params), getOrderParam(params)))
  end


  defp getPageParam(map) when :erlang.is_map_key("page", map) == false, do: 1
  defp getPageParam(%{"page" => page}), do: String.to_integer(page)

  defp getPlayerNameParam(map) when :erlang.is_map_key("playerName", map) == false, do: ""
  defp getPlayerNameParam(%{"playerName" => playerName}), do: playerName

  defp getRecordsPerPageParam(map) when :erlang.is_map_key("recordsPerPage", map) == false, do: 1
  defp getRecordsPerPageParam(%{"recordsPerPage" => recordsPerPage}), do: String.to_integer(recordsPerPage)

  defp getOrderParam(map) when :erlang.is_map_key("order", map) == false, do: []
  defp getOrderParam(%{"order" => order}), do: Enum.map(order, &translateOrderToAtom(&1))

  defp translateOrderToAtom({"Total Rushing Touchdowns", "Desc"}), do: :TotalRushingTouchdownDesc
  defp translateOrderToAtom({"Total Rushing Touchdowns", "Asc"}), do: :TotalRushingTouchdownAsc
  defp translateOrderToAtom({"Longest Rush", "Desc"}), do: :LongestRushDesc
  defp translateOrderToAtom({"Longest Rush", "Asc"}), do: :LongestRushAsc
  defp translateOrderToAtom({"Total Rushing Yards", "Desc"}), do: :TotalRushingYardsDesc
  defp translateOrderToAtom({"Total Rushing Yards", "Asc"}), do: :TotalRushingYardsAsc

end
