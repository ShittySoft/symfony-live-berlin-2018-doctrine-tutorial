# Basic Doctrine ORM tutorial

This tutorial will introduce you to using Doctrine ORM.

Specifically, following sections will be covered:

 1. Installation
 2. Basic concepts:
     a. Entities
     b. ORM components
     c. Entity states
     d. Transactions
 3. Creating an entity
 4. Saving and loading an entity
 5. API interactions with entities
 6. Association mapping
 7. Lazy loading

## The domain

The logic inside this domain will represent a simple authentication
layer, as well as a simple blog-post/blog-post commenting platform.

See the [feature](feature) directory for requirements.

## Installation

First, [install composer](https://getcomposer.org/download/).

After that, you can run:

```sh
composer require doctrine/orm
```
