<?php


namespace ArtsAndHumanities\Http\Transformers;

use ArtsAndHumanities\Models as Models;
use League\Fractal\TransformerAbstract;

class EventTypeTransformer extends TransformerAbstract
{

    public function transform(Models\Type $type)
    {
        return [
            'id' => (int)$type->id,
            'description' => $type->description

        ];
    }

}