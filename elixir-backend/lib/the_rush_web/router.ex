defmodule TheRushWeb.Router do
  use TheRushWeb, :router

  pipeline :api do
    plug :accepts, ["json"]
  end

  scope "/", TheRushWeb do
    pipe_through :api
    get "/playersData", PlayersDataController, :getPlayers
  end
end
