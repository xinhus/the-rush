defmodule TheRush.PlayerData.UseCase.PlayerDataUseCaseTest do
  use TheRush.PlayerDataCase

  test "can retrieve records as JSON" do
    expectedJson = "[{\"1st\":0,\"1st%\":0,\"20+\":0,\"40+\":0,\"Att\":2,\"Att/G\":2,\"Avg\":3.5,\"FUM\":0,\"Lng\":\"7\",\"Player\":\"Joe Banyard\",\"Pos\":\"RB\",\"TD\":0,\"Team\":\"JAX\",\"Yds\":7,\"Yds/G\":7}]"
    assert TheRush.PlayerData.UseCase.PlayerDataUseCase.getRecordsAsJson(TheRush.PlayerData.Repository.PlayerDataRepository, "../data/rushing.json", "", 1, 1, []) == expectedJson
  end

  test "can retrieve records as CSV" do
    expectedCsv = "1st,1st%,20+,40+,Att,Att/G,Avg,FUM,Lng,Player,Pos,TD,Team,Yds,Yds/G\n0,0,0,0,2,2,3.5,0,7,Joe Banyard,RB,0,JAX,7,7\n"
    assert TheRush.PlayerData.UseCase.PlayerDataUseCase.getRecordsAsCsv(TheRush.PlayerData.Repository.PlayerDataRepository, "../data/rushing.json", "", 1, 1, []) == expectedCsv
  end
end
