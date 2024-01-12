<?php

namespace App\DTO;

class AppUserDTO
{
    public int $id;
    public string $username;
    public string $email;
    public string $first_name;
    public string $last_name;

    public function __construct(int $id,string $username, string $email, string $first_name, string $last_name)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }
}
