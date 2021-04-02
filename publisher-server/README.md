# PANGAEA TAKE HOME ASSIGNMENT

## Description
For this challenge we'll be creating a HTTP notification system. A server (or set of servers) will keep track of topics ->
subscribers where a topic is a string and a subscriber is an HTTP endpoint. When a message is published on a topic, it
should be forwarded to all subscriber endpoints.
The backend teams at Pangaea currently use PHP Laravel) and NodeJS. Your take home must use either PHP or
Node. The tools and frameworks within these languages are up to you.

# Install Dependencies
composer install

# Run Migrations
php artisan migrate

## APi Rest Endpoints

- http://127.0.0.1:8000/api/subscribe/topic/     //POST
- http://127.0.0.1:8000/api/publish/topic/     //POST


## Running tests

* To Test subscribe endpoint:   run php artisan test tests/Feature/Http/Controllers/Api/SubcriptionControllerTest.php
* To Test publish endpoint:   run php artisan test tests/Feature/Http/Controllers/Api/PublisherControllerTest.php


##  TEST WITH POSTMAN

* To Test subscriber: |POST|  http://127.0.0.1:8000/api/subscribe/topic

* To Test publisher: |POST|  http://127.0.0.1:8000/api/publish/topic

## Running unit tests with Jinkings
I developed a simple Jenkins file to run the unit tests:

```sh
   
    pipeline {
        agent any
            stages {
                stage(“Build”) {
                    steps {
                        sh "php — version"
                        sh "composer install"
                        sh "composer — version"
                        sh "cp .env.example .env"
                        sh "php artisan key:generate"
                    }
                }
                stage(“Unit test”) {
                steps {
                    sh "php artisan test"
                }
            }
        }
    }
    
```
The code builds the project and runs the “PHP artisan test” command which executes all the unit tests inside the PHPUnit framework that is already included in Laravel.


### Improved CI/CD pipeline setup with jenkins credentials and acceptenace testing

```sh
    pipeline {

        agent { docker { image 'php' } }
            stages {

              stage("Build") {
                environment {
                    DB_HOST = credentials("laravel-host")
                    DB_DATABASE = credentials("laravel-database")
                    DB_USERNAME = credentials("laravel-user")
                    DB_PASSWORD = credentials("laravel-password")
                }
                steps {
                    sh 'composer install'
                    sh 'cp .env.example .env'
                    sh 'echo DB_HOST=${DB_HOST} >> .env'
                    sh 'echo DB_USERNAME=${DB_USERNAME} >> .env'
                    sh 'echo DB_DATABASE=${DB_DATABASE} >> .env'
                    sh 'echo DB_PASSWORD=${DB_PASSWORD} >> .env'
                    sh 'php artisan key:generate'
                    sh 'cp .env .env.testing'
                    sh 'php artisan migrate'
                }
            }
            stage("Unit test") {
                steps {
                    sh 'php artisan test'
                }
            }
            stage("Acceptance test codeception") {
                    steps {
                        sh "vendor/bin/codecept run"
                    }
                    post {
                        always {
                            sh "docker stop laravel8cd"
                        }
                    }
                }
        }
    }

    
```


