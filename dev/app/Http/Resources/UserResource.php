<?php
namespace App\Http\Resources;

class UserResource extends Resource
{
    public function toArray($request)
    {
        return [
            'user_name' => $this->user_name,
            'user_email' => $this->user_email,
        ];
    }
}