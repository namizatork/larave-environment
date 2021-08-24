# laravel-environment

## Introduction

Building Laravel environment

## Documents

- [コーディングルール](document/coding-standards.md)
- [ツールの説明](document/tools.md)

## Usage

```bash
$ git clone git@github.com:namizatork/laravel-environment.git
$ cd docker-laravel
$ make create-project
$ make install-recommend-packages
```

http://localhost

## Container structures

```bash
├── app
├── web
└── db
```

### app container

- Base image
  - [php](https://hub.docker.com/_/php):8.0-fpm
  - [composer](https://hub.docker.com/_/composer):2.0

### web container

- Base image
  - [nginx](https://hub.docker.com/_/nginx):1.20-alpine
  - [node](https://hub.docker.com/_/node):16-alpine

### db container

- Base image
  - [mysql/mysql-server](https://hub.docker.com/r/mysql/mysql-server):8.0
