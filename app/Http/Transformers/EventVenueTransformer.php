<?php


namespace ArtsAndHumanities\Http\Transformers;

use ArtsAndHumanities\Models as Models;
use League\Fractal\TransformerAbstract;

class EventVenueTransformer extends TransformerAbstract
{

    public function transform(Models\Venue $venue)
    {
        return [
            'id' => (int)$venue->id,
            'description' => $venue->description

        ];
    }
}