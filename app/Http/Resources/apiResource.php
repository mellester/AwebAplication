<?php

namespace App\Http\Resources;

use App\Models\User;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class apiResource extends InternalApiResource
{
    static function getModels()
    {

        $basePath = app_path() . "/Models";
        $out = [];
        $results = scandir($basePath);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $basePath . '/' . $result;
            if (is_dir($filename)) {
                $out = array_merge($out, Self::getModels($filename));
            } else {
                $out[] = substr($filename, 0, -4);
            }
        }
        $models = [];

        foreach ($out as $path) {
            $basename = pathinfo($path)['basename'];
            if (count(explode('/', $path)) == 7) // lets not get Models in sub dirs
                array_push($models, 'App\\Models\\' . $basename);
            else {
            }
        }
        return $models;
    }
    public $model;
    public function __construct($user, $requestData)
    {
        $ModelName = $requestData['resourceName'];
        $id = $requestData['resourceId'];
        $models = Self::getModels();
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
        $resource = $model::find($id);
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function itsData($request)
    {
        return $this->resource;
    }
}
