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

You can install this package via composer like this:

```
composer require alessandrominoccheri/trello-cycle-time
``` 

## How to use it?

To use this library you need to have: 
* Trello apikey
* Trello token
* Trello boardId to analyze

### All Cards

To get all cards transitions column you can use this code for example


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

### Specific card transition

To get only a specific card transition you can obtain it using its id like this:


```
use TrelloCycleTime\Client\TrelloApiClient;

$client = new TrelloApiClient('apikey', 'token');
$board = new TrelloBoard($client, 'board-id');

$transitions = $board->getCardTransitions('cardId');

var_dump($transitions);

```

The response of ```getTransitions``` is an array that contains some information only of that card for example:

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


### Filters

You can filter column cards with some parameters.
 Here are some possible filters
 

#### From column to column 
if you want to know only how much time alla cards or a single card passed from a column to column,
 
To do this you can use this code:

```
$transitions = $board->getTransitions(['fromColumn' => 'todo', 'toColumn' => 'done']);
```

or for a specific card:

```
$transitions = $board->getCardTransitions('cardId', ['fromColumn' => 'todo', 'toColumn' => 'done']);
```

#### From date to date 
if you want to know only how much time alla cards or a single card passed filtered by from a date or to a date or together,
 
To do this you can use this code:

```
$transitions = $board->getTransitions(['fromDate' => '2019-01-01', 'toDate' => '2019-12-31']);
$transitions = $board->getTransitions(['fromDate' => '2019-01-01']);
$transitions = $board->getTransitions(['toDate' => '2019-12-31']);

```

or for a specific card:

```
$transitions = $board->getCardTransitions(['fromDate' => '2019-01-01', 'toDate' => '2019-12-31']);
```

## Contributing

Every contribution is welcome, remember to add tests and use psalm and phpstan:

```
./vendor/bin/phpunit
./vendor/bin/psalm
./vendor/bin/phpstan analyse
```
