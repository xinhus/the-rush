defmodule TheRush.PlayerData.Repository.PlayerDataRepository do

  def getRecords(filename, playerName, page, recordsPerPage) do
    initial = (page - 1) * recordsPerPage;
    max = initial + recordsPerPage - 1;

    filename
    |> File.read!
    |> Jason.decode!
    |> Enum.filter(fn %{"Player" => currentPlayerName} -> String.contains?(currentPlayerName, playerName) end)
    |> Enum.slice(initial..max)
  end

  def getRecords(filename, playerName, page, recordsPerPage, order) do
    initial = (page - 1) * recordsPerPage
    max = initial + recordsPerPage - 1


    filename
    |> File.read!
    |> Jason.decode!
    |> Enum.filter(fn %{"Player" => currentPlayerName} -> String.contains?(currentPlayerName, playerName) end)
    |> sortRecords(order)
    |> Enum.slice(initial..max)
  end

  defp sortRecords(records, order) do
    order
    |> Enum.map( &sortByField(&1, records))
    |> List.last
  end

  defp sortByField(:TotalRushingTouchdownDesc, records ), do: Enum.sort_by(records, &{sortByTd(&1)}, :desc)
  defp sortByField(:TotalRushingTouchdownAsc, records ), do: Enum.sort_by(records, &{sortByTd(&1)})
  defp sortByField(:LongestRushDesc, records ), do: Enum.sort_by(records, &{sortByLng(&1)}, :desc)
  defp sortByField(:LongestRushAsc, records ), do: Enum.sort_by(records, &{sortByLng(&1)})
  defp sortByField(:TotalRushingYardsDesc, records ), do: Enum.sort_by(records, &{sortByYds(&1)}, :desc)
  defp sortByField(:TotalRushingYardsAsc, records ), do: Enum.sort_by(records, &{sortByYds(&1)})

  defp sortByLng(%{"Lng"=> field}), do: forceToInteger(field)
  defp sortByTd(%{"TD"=> field}), do: forceToInteger(field)
  defp sortByYds(%{"Yds"=> field}), do: forceToInteger(field)


  defp forceToInteger(field) when is_integer(field), do: field
  defp forceToInteger(field) when is_float(field), do: field
  defp forceToInteger(field) do
    field
    |> String.replace("T", "")
    |> String.replace(",", "")
    |> String.to_integer
  end

end
