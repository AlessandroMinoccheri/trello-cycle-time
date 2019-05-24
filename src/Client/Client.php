<?php

namespace TrelloCycleTime\Client;


use TrelloCycleTime\Exception\RuntimeException;

class Client
{
    public function createRequest(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,5000);

        try {
            return curl_exec($ch);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}