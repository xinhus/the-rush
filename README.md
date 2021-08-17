# "the Rush"

## Installation and running this solution
This project is dockerized so to startup just run

```docker compose up``` (assuming you have docker & docker compose installed)

Wait until you see the message ```Access TheRushWeb.Endpoint at ...``` from `elixir-backend` and then access `http://localhost:8000`.
(The first time that run up, it will take more time than usual, downloading depencies, compiling etc...)

It will build the image and start three containers described as

```
elixir-backend
    - The elixir backend
    - It's exposed on port 8090
    - Dockerfile ./elixir-backend/docker-image/Dockerfile
php-backend
    - The PHP backend
    - It's exposed on port 8080
    - Dockerfile ./php-backend/docker-image/Dockerfile
frontend
    - the frontend running on nginx
    - It's exposed on port 8000
```

On to top-left, you can select which backend you want to use :) you can swap between PHP and Elixir.


## About the solution
- This project take into concern that we may or may not change the language and that we may or may not use a different format of repo.
- I've used PRs during the entire process, so you can check the closed the PR to see the development process.
- There are two github actions implemented. Elixir and PHP, so when you commit a `.php` file it will run the php action, and any `.ex` or `.exs` will run the elixir one
- I use a lot TDD, so I highly recommend you to take a look into my tests.
- There is one knowing bug on the elixir backend that I couldn't solve (Sorting by multiple fields)

### Backend
There are two backends available. Both are just an API described as:

`/playersData`

`/playersData/export`

Both endpoints have the same parameters, which are query string parameters described as
```
page=1 //The number of page that you want
recordsPerPage=10 //The number of records per page that you want
playerName= //The player's name to filter
order = is an array on the format Field => name ex
    order[Total Rushing Touchdowns]=Desc //Total Rushing Touchdowns Desc
    order[Longest Rush]=Asc //Longest Rush  Desc
    order[Total Rushing Yards]=Asc //Total Rushing Yards  Desc
```

#### Assumptions
- This API was designed as a simple and public api.
- We can expand it and implement authentication/authorization. (oAuth2 or something like that)

#### PHP Backend
- No Framework used
- One library added to use the PSR-7: HTTP message interfaces
#### Elixir Backend
- Used Phoenix as the base project

### Frontend
The frontend is using HTML/CSS. It was used bootstrap as base and icons.
