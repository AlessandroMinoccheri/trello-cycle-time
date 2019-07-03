# Trello Cycle Time

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AlessandroMinoccheri/trello-cycle-time/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/AlessandroMinoccheri/trello-cycle-time/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/AlessandroMinoccheri/trello-cycle-time/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/AlessandroMinoccheri/trello-cycle-time/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alessandrominoccheri/trello-cycle-time/v/stable.svg)](https://packagist.org/packages/alessandrominoccheri/trello-cycle-time)
[![License](https://poser.pugx.org/alessandrominoccheri/trello-cycle-time/license.svg)](https://packagist.org/packages/alessandrominoccheri/trello-cycle-time)
[![Build Status](https://api.travis-ci.org/AlessandroMinoccheri/trello-cycle-time.png)](https://travis-ci.org/AlessandroMinoccheri/trello-cycle-time)
[![Total Downloads](https://poser.pugx.org/alessandrominoccheri/trello-cycle-time/d/total.png)](https://packagist.org/packages/alessandrominoccheri/trello-cycle-time)

This library is a PHP library to get cycle time of cards from a Trello board.
With this tool you can seen how many times a card take to pass from a state to another state into the board.

## Installation

```
composer require alessandrominoccheri/trello-cycle-time
``` 

## How to use it?

To use this library you need to have: 
* Trello apikey
* Trello token
* Trello boardId to analyze

```
use TrelloCycleTime\Client\TrelloApiClient;

$client = new TrelloApiClient('apikey', 'token');
$board = new TrelloBoard($client, 'board-id');

$transitions = $board->getTransitions();

var_dump($transitions);

```

The response of ```getTransitions``` is an array that contains some information for example:

```
[0 => [
   'id' => 'cardId',
   'title' => 'cardName',
   'cycleTimes' => [
        0 => [
            'from' => 'Doing',
            'to' => 'Done',
            'days' => '6',
            'name' => 'Doing_DOne'
        ],
        1 => [
             'from' => 'ToDo',
             'to' => 'Doing',
             'days' => '1',
             'name' => 'ToDo_Doing'
        ]
   ]
]
];
```

In this case you can see that this card takes 1 day to pass from Todo to Doing and 6 days to pass from Doing to Done.


## Contributing

Every contribution is welcome, remember to add tests and use psalm and phpstan:

````
./vendor/bin/phpunit
./vendor/bin/psalm
./vendor/bin/phpstan analyse
````
