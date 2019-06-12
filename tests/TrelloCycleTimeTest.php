<?php

namespace Tests;


use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Client\Client;
use TrelloCycleTime\TrelloCycleTime;

class TrelloCycleTimeTest extends TestCase
{
    public function testGetAllWithoutCards()
    {
        $client = $this->prophesize(Client::class);

        $client->findAllCards()->willReturn([]);

        $trelloCycleTime = new TrelloCycleTime($client->reveal());

        $cycleTimes = $trelloCycleTime->getAll();

        $this->assertEquals([], $cycleTimes);
    }

    public function testGetAll()
    {
        $client = $this->prophesize(Client::class);

        $cardId = '5cdfb33499236c320e7d772c';
        $cards = [
            0 =>
                [
                    'id' => $cardId,
                    'checkItemStates' => NULL,
                    'closed' => false,
                    'dateLastActivity' => '2019-05-24T09:14:46.660Z',
                    'desc' => '',
                    'descData' => NULL,
                    'dueReminder' => NULL,
                    'idBoard' => '5cdfb328cc5d0542a9bc5ce0',
                    'idList' => '5cdfb33181899386ced12d14',
                    'idMembersVoted' => [],
                    'idShort' => 1,
                    'idAttachmentCover' => NULL,
                    'idLabels' => [],
                    'manualCoverAttachment' => false,
                    'name' => 'prima',
                    'pos' => 196607,
                    'shortLink' => 'jV1haDyb',
                    'badges' =>
                        [
                            'attachmentsByType' =>
                                [
                                    'trello' =>
                                        [
                                            'board' => 0,
                                            'card' => 0,
                                        ],
                                ],
                            'location' => false,
                            'votes' => 0,
                            'viewingMemberVoted' => false,
                            'subscribed' => false,
                            'fogbugz' => '',
                            'checkItems' => 0,
                            'checkItemsChecked' => 0,
                            'comments' => 0,
                            'attachments' => 0,
                            'description' => false,
                            'due' => NULL,
                            'dueComplete' => false,
                        ],
                    'dueComplete' => false,
                    'due' => NULL,
                    'idChecklists' => [],
                    'idMembers' => [],
                    'labels' => [],
                    'shortUrl' => 'https://trello.com/c/jV1haDyb',
                    'subscribed' => false,
                    'url' => 'https://trello.com/c/jV1haDyb/1-prima',
                ]
        ];

        $creationCard = [
            0 => [
                'id' => $cardId,
                'idMemberCreator' => '521dbcdd68ba6dec350040ff',
                'data' => [
                    'board' => [
                        'shortLink' => 'ZctgODOd',
                        'name' => 'TEST',
                        'id' => '5cdfb328cc5d0542a9bc5ce0'
                    ],

                    'list' => [
                        'name' => 'ToDo',
                        'id' => '5cdfb32f696b0a36d3186758'
                    ],
                    'card' => [
                        'shortLink' => 'tZEJWg0V',
                        'idShort' => '1',
                        'name' => 'prima',
                        'id' => $cardId
                    ]
                ],
                'type' => 'createCard',
                'date' => '2019-05-17T06:45:04.392Z',
                'limits' => [],
                'memberCreator' => [
                    'id' => '521dbcdd68ba6dec350040ff',
                    'avatarHash' => '3fab266d04a3f6f570b6a46606e133c0',
                    'avatarUrl' => 'https://trello-avatars.s3.amazonaws.com/3fab266d04a3f6f570b6a46606e133c0',
                    'fullName' => 'Alessandro Minoccheri',
                    'idMemberReferrer' => '516a8b285b342af34f003c96',
                    'initials' => 'AM'
                ]
            ]
        ];

        $cardHistory = json_decode('[
    {
        "id": "5ce7b60627e1bb5e0a8c60d1",
        "idMemberCreator": "521dbcdd68ba6dec350040ff",
        "data": {
            "listAfter": {
                "name": "DOne",
                "id": "5cdfb33181899386ced12d14"
            },
            "listBefore": {
                "name": "Doing",
                "id": "5cdfb3302e078d53fd5c01f8"
            },
            "board": {
                "shortLink": "ZctgODOd",
                "name": "TEST",
                "id": "5cdfb328cc5d0542a9bc5ce0"
            },
            "card": {
                "shortLink": "jV1haDyb",
                "idShort": 1,
                "name": "prima",
                "id": "5cdfb33499236c320e7d772c",
                "idList": "5cdfb33181899386ced12d14"
            },
            "old": {
                "idList": "5cdfb3302e078d53fd5c01f8"
            }
        },
        "type": "updateCard",
        "date": "2019-05-24T09:14:46.642Z",
        "limits": {},
        "memberCreator": {
            "id": "521dbcdd68ba6dec350040ff",
            "avatarHash": "3fab266d04a3f6f570b6a46606e133c0",
            "avatarUrl": "https://trello-avatars.s3.amazonaws.com/3fab266d04a3f6f570b6a46606e133c0",
            "fullName": "Alessandro Minoccheri",
            "idMemberReferrer": "516a8b285b342af34f003c96",
            "initials": "AM",
            "nonPublic": {},
            "nonPublicAvailable": false,
            "username": "alessandrominoccheri1"
        }
    },
    {
        "id": "5cdfb33a2d9abb38dcaedbd8",
        "idMemberCreator": "521dbcdd68ba6dec350040ff",
        "data": {
            "listAfter": {
                "name": "Doing",
                "id": "5cdfb3302e078d53fd5c01f8"
            },
            "listBefore": {
                "name": "ToDo",
                "id": "5cdfb32f696b0a36d3186758"
            },
            "board": {
                "shortLink": "ZctgODOd",
                "name": "TEST",
                "id": "5cdfb328cc5d0542a9bc5ce0"
            },
            "card": {
                "shortLink": "jV1haDyb",
                "idShort": 1,
                "name": "prima",
                "id": "5cdfb33499236c320e7d772c",
                "idList": "5cdfb3302e078d53fd5c01f8"
            },
            "old": {
                "idList": "5cdfb32f696b0a36d3186758"
            }
        },
        "type": "updateCard",
        "date": "2019-05-18T07:24:42.415Z",
        "limits": {},
        "memberCreator": {
            "id": "521dbcdd68ba6dec350040ff",
            "avatarHash": "3fab266d04a3f6f570b6a46606e133c0",
            "avatarUrl": "https://trello-avatars.s3.amazonaws.com/3fab266d04a3f6f570b6a46606e133c0",
            "fullName": "Alessandro Minoccheri",
            "idMemberReferrer": "516a8b285b342af34f003c96",
            "initials": "AM",
            "nonPublic": {},
            "nonPublicAvailable": false,
            "username": "alessandrominoccheri1"
        }
    }
]', true);

        $client->findAllCards()->willReturn($cards);

        $client->findCreationCard($cardId)->willReturn($creationCard);

        $client->findAllCardHistory($cardId)->willReturn($cardHistory);

        $trelloCycleTime = new TrelloCycleTime($client->reveal());

        $cycleTimes = $trelloCycleTime->getAll();

        $expected = [0 => [
            'id' => '5cdfb33499236c320e7d772c',
            'title' => 'prima',
            'cycleTimes' => [
                0 => [
                    'from' => 'Doing',
                    'to' => 'DOne',
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

        $this->assertEquals($expected, $cycleTimes);
    }
}