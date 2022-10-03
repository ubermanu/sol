# sol

[![CI](https://github.com/ubermanu/sol/actions/workflows/ci.yml/badge.svg)](https://github.com/ubermanu/sol/actions/workflows/ci.yml)

This project is a simple implementation of a SOLID server.

It has the basic endpoints to create, fetch, update and delete resources.

## Usage

Run the server with your favorite web server (or the built-in one):

    php -S localhost:8000 -t pub

### PUT

Creates a new resource for the given URL.

    curl -X PUT -H "Content-Type: text/plain" \
         -d 'Hello world!' \
         http://localhost:8000/myfile.txt

### POST

Creates a new resource and generates a random URL.

    curl -X POST -H "Content-Type: text/plain" \
         -d 'Hello world!' \
         http://localhost:8000/

> The response's `Location` header will contain the URL of the created resource.

### GET

Fetches the resource for the given URL.

    curl -H "Accept: text/plain" \
         http://localhost:8000/myfile.txt

### DELETE

Deletes the resource for the given URL.

    curl -X DELETE http://localhost:8000/myfile.txt

## Configuration

Copy the `.env.dist` file to `.env` and fill in the values.

### Storage

The storage can be configured to use either files or a database.

See the [.env.dist](.env.dist) file for more information.
