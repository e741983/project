<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class ToDo extends JsonResource
{
    /**
     * Transform the resource into an array.
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
            'complete' => $this->complete,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
?>