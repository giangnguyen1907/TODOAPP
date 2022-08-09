<?php

 
namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource;

class TodosCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id'=>$this->id,
            'text'=> $this->text,
            'isDone' => $this->isDone,
            'user_id'=> $this->user_id,
        ];
    }
}
