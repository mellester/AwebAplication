<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Resources\Json\ResourceCollection;

class apiResourcCollection extends ResourceCollection
{

    public $model;
    public function __construct($user, $requestData)
    {
        $ModelName = $requestData['resourceName'];
        $ids = json_decode($requestData['resourceIds']);
        $models = apiResource::getModels();
        $model = false;
        foreach ($models as $itter) {
            // dd($itter);
            $path = str_replace('\\', '/', $itter);
            $basename = strtolower(pathinfo($path)['basename']);
            if ($basename == strtolower($ModelName))
                $model = $itter;
        }
        // dump($model);
        if (!$model) {
            throw new Exception("A resource with resourceName: {{$ModelName}} is not found");
        }
        $this->model = $model;
        $resource = $model::whereIn('id', $ids);
        parent::__construct($resource->get());
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
