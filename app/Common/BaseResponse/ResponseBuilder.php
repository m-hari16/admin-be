<?php

namespace App\Common\BaseResponse;

class ResponseBuilder {
  protected $code, $data, $message, $success;
  
  public static function build($code = null, $success = null, $message = null, $data = null, $isPaging = false)
  {
    $pagination = [
      "page" => null, 
      "size" => null,
      "totalPage" => null,
      "totalData" => null,
    ];

    if($isPaging){
      $pagination["page"] = $data->currentPage();
      $pagination["size"] = $data->count();
      $pagination["totalPage"] = $data->lastPage();
      $pagination["totalData"] = $data->total();
    }

    return [
      "code" => $code ?? 500,
      "success" => $success ?? false ,
      "message" => $message ?? "Something wrong",
      "data" => $data ?? null,
      "pagination" => $pagination,
    ];
  }
}