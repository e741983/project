<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\Resource;
class ToDoCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'date' => $this->date,
            'created_by' => $this->created_by,
            'complete' => $this->complete
        ];

    }

}

?>