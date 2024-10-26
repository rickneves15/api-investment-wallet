<?php


namespace App\Http\Resources\Helper;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaginatedJsonResourceCollection extends AnonymousResourceCollection
{
  /**
   * Adjust pagination data format
   *
   * @param Request $request
   * @param array $paginated
   * @param array $default
   * @return array
   */
  public function paginationInformation(Request $request, array $paginated, array $default)
  {
    $default = [
      'currentPage' => $default['meta']['current_page'],
      'lastPage' => $default['meta']['last_page'],
      'perPage' => $default['meta']['per_page'],
      'total' => $default['meta']['total'],
      "prev" => $default['links']['prev'],
      "next" => $default['links']['next'],
    ];
    unset($default['links']);

    return $default;
  }
}
