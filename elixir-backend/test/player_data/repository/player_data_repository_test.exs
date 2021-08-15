defmodule TheRush.PlayerData.Repository.PlayerDataRepositoryTest do
  use TheRush.PlayerDataCase

  test "can open the file and parse" do
    expected = File.read!("../data/rushing.json")
      |> Jason.decode!()
    assert TheRush.PlayerData.Repository.PlayerDataRepository.getRecords("../data/rushing.json") == expected
  end
end
