[![Codacy Badge](https://app.codacy.com/project/badge/Grade/193480146a2b4e1885d932682d99f507)](https://www.codacy.com/gh/MytiX/Blog/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=MytiX/Blog&amp;utm_campaign=Badge_Grade)

# About my Blog

The project number 5 of Openclassroom consists in making a Blog, coded only in PHP

# Server configuration

To install the Blog, you need a web server running PHP 8 and MySQL 5.0+

# Installation

Clone repository
```
git clone https://github.com/MytiX/Blog
```
Install dependency
```
composer install
```

Restore the database using the SQL file present in the dump/ folder

# RUN

## Docker

If you used Docker, you can launch the image with
```
cd docker/
```
```
docker-compose up -d
```

## Other Solution

It's a standard application you just need a web server and a database
