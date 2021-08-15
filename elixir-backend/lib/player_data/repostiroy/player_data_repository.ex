defmodule TheRush.PlayerData.Repository.PlayerDataRepository do

  def getRecords(filename) do
    filename
    |> File.read!
    |> Jason.decode!
  end

end
