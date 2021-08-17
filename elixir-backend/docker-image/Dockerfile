FROM elixir:latest


ENV APP_HOME /the-rush
RUN mkdir $APP_HOME
COPY ./../ $APP_HOME
WORKDIR $APP_HOME

RUN mix local.hex --force
CMD cd $APP_HOME && mix deps.get && mix do compile && mix phx.server
