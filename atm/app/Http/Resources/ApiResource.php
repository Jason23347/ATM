<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
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
            // TODO 使用_()函数进行本地化
            "message"   => $this->message ?? "操作成功",
            "errcode"   => $this->errcode ?? 0,
            "data"      => $this->data ?? null,
        ];
    }
}
