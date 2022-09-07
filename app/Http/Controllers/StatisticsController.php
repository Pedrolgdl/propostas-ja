<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    private $user;
    private $property;

    public function __construct(Property $property, User $user)
    {
        $this->property = $property;
        $this->user = $user;
    }

    public function usersCount() {
        $users = $this->user->all();

        return response()->json(count($users), 200);
    }

    public function propertiesCount() {
        $properties = $this->property->all();

        return response()->json(count($properties), 200);
    }
}
