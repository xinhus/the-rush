defmodule TheRushWeb.PlayersDataView do
  use TheRushWeb, :view

  def render("content_raw.json", %{:response => content}), do: content

end
