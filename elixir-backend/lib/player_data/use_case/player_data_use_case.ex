defmodule TheRush.PlayerData.UseCase.PlayerDataUseCase do

  def getRecordsAsJson(repository, filename, playerName, page, recordsPerPage, order) do
    repository.getRecords(filename, playerName, page, recordsPerPage, order)
    |>Jason.encode!
  end

  def getRecordsAsCsv(repository, filename, playerName, page, recordsPerPage, order) do
    records = repository.getRecords(filename, playerName, page, recordsPerPage, order)

    records
    |> Enum.at(0)
    |> Enum.to_list
    |> Enum.map_join(",", fn ({header, _}) -> header end)
    |> Kernel.<>("\n")
    |> Kernel.<>(Enum.map_join(records, "\n", &mapToCsvFormat(&1)))
    |> Kernel.<>("\n")
  end

  defp mapToCsvFormat(map) do
    map
    |> Enum.to_list
    |> Enum.map_join(",", fn ({_, value}) -> value end)
  end
end
