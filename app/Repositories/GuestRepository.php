<?php

namespace App\Repositories;

use App\Guest;

class GuestRepository extends Repository
{
    /**
     * Create new instance of guest repository.
     *
     * @param Guest $guest Guest model
     */
    public function __construct(Guest $guest)
    {
        parent::__construct($guest);
        $this->guest = $guest;
    }

    /**
     * Find the resource using the specified id or else fail.
     *
     * @param  int $id
     * @return json object
     */
    public function findOrFail($id)
    {
        return $this->guest->with('user')->findOrFail($id);
    }
}
