<?php

namespace App\Http\Resources\Inbound;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexItrInResource extends JsonResource
{
    //define properti
  public $status;
  public $message;
  public $resource;

  /**
   * _construct
   *
   * @param mixed $status
   * @param mixed $missage
   * @param mixed resource
   * @return void
   */
  public function __construct($status, $message, $resource)
  {
      parent::__construct($resource);
      $this->status = $status;
      $this->message = $message;
  }
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
      return [
          'success' => $this->status,
          'message' => $this->message,
          'data' => $this->resource
      ];
  }
}
