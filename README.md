# Trello Cycle Time

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
use TrelloCycleTime\Client\Client;

$client = new Client('apikey', 'token', 'boardId');
$trelloCycleTime = new TrelloCycleTime($client);

$cycleTimes = $trelloCycleTime->getAll();
```

the response of ```getAll``` is an array that contains some information for example:

```
[0 => [
   'id' => 'cardId',
   'title' => 'cardName',
   'cycleTimes' => [
        0 => [
            'from' => 'Doing',
            'to' => 'Done',
            'value' => '6',
            'name' => 'Doing_DOne'
        ],
        1 => [
             'from' => 'ToDo',
             'to' => 'Doing',
             'value' => '1',
             'name' => 'ToDo_Doing'
        ]
   ]
]
];
```

In this case you can see that this card takes 1 day to pass from Todo to Doing and 6 days to pass from Doing to Done.




