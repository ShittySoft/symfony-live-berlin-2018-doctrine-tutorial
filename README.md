# Doctrine ORM and tactical DDD concepts

This tutorial will introduce you to using Doctrine ORM together
with tactical DDD concepts.

Our approximate plan of operation:

 1. Installation and hoping that it will go smoothly :-)
 2. Getting started with a simplistic "already known" 
    `Authentication` domain, *without* ORM
 3. Discussion of the first implementations popping up
 4. Introducing some DDD concepts:
     * Domain and Infrastructure
     * Value Object
     * Aggregate Root
     * Entity
     * Repository
     * Read Model
 5. Looking at how to improve our `Authentication` code
 6. Wiring the ORM into our `Authentication` code
 7. Exploration and discussion of a new domain, one of either:
     * Blog Post
     * Hotel Booking

## Installation

First, [install composer](https://getcomposer.org/download/).

After that, you can run:

```sh
composer require doctrine/orm
```
