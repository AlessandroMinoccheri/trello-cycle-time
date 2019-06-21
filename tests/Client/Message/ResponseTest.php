<?php


namespace Tests\Client\Message;


use PHPUnit\Framework\TestCase;
use TrelloCycleTime\Client\Message\Response;

class ResponseTest extends TestCase
{
    /**
     * @expectedException TrelloCycleTime\Exception\InvalidJsonException
     */
    public function testThrowExceptionIfIsNotAJson()
    {
        Response::validate('notAJsonString');
    }

    public function testReturnJsonDecoded()
    {
        $jsonString = '{"foo":"bar"}';
        $json = Response::validate($jsonString);

        $this->assertEquals(json_decode($jsonString, true), $json);
    }
}