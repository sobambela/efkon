# Efkon Assessment

## Built in:
- PHP 8
- MySql
- Bootstrap
- VueJS
- Axios

- The app PHP code is located /app
- The app Templates are located /templates
- The VueJS code is located in /js/custom.js
## Usage

- Clone the project repo 
```
$ git clone https://github.com/sobambela/efkon.git
```
- Go into the project Directory, and run subsequent commands
```
$ cd efkon
```
- Copy the .env.example file to .env and add your database information as below:
- The SMPT details are required for PhpMailer
```
APP_ENV=local
DATABASE_HOST=localhost
DATABASE_NAME=
DATABASE_USER=
DATABASE_PASSWORD=

SMTP_HOST=
SMTP_USERNAME=
SMTP_PASSWORD=
EMAIL_FROM=
```
- Run the following sql in order to create the uses table in your database
```
CREATE TABLE `users` (
  `name` varchar(60) NOT NULL,
  `surname` varchar(60) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `contact_number` varchar(10) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `id` int NOT NULL,
  `reset_token` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```
- You are ready to serve.