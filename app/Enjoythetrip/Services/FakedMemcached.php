<?php

namespace App\Enjoythetrip\Services;

class FakedMemcached implements FakedMemcachedInterface {


    public function get($key)
    {
        if(file_exists("$key.fakedmemcached"))
        {
            return file_get_contents("$key.fakedmemcached");
        }
        else
        {
            file_put_contents("$key.fakedmemcached", 0);
        }

    }


    public function set($key,$value)
    {
        file_put_contents("$key.fakedmemcached", $value);
    }


    public function addServer($host, $port)
    {
        return "Thank you for $host and $port port number. But I'm not going to do anything with it.";
    }


}
