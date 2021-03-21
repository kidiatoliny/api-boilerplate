<?php

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;


if (!function_exists('getAll')) {
  /**
   * get all data from specified Model
   *
   * @param Model $model
   * @param JsonResource $resource
   * @return \Illuminate\Http\Response
   */
  function getAll(Model $model, $resource)
  {
    $resourceNameSpace = 'App\Http\Resources\\' . $resource;
    try {
      $all = $model::all();
      $all = $resourceNameSpace::collection($all);
      return getData($all);
    } catch (\Throwable $th) {
      return error($th);
    }
  }
}



if (!function_exists('create')) {
  /**
   * Store a newly created resource
   *
   * @param Request $request
   * @param Model $model
   * @param JsonResource $resource
   * @param Array $rules
   * @return \Illuminate\Http\Response
   */
  function create(Request $request, Model $model, $resource, $rules)
  {
    $resourceNameSpace = 'App\Http\Resources\\' . $resource;
    if (!validJson($request)) {
      return badRequest("Erro no formato JSON !");
    }

    $validator = validateRequest($request, $rules);
    if ($validator->fails()) {
      return validationError($validator->messages());
    }
    try {

      $response = $model->create(validJson($request));
      return created(new  $resourceNameSpace($response));
    } catch (\Throwable $th) {
      return error($th);
    }
  }
}

if (!function_exists('getOne')) {
  /**
   * get a specified resource
   *
   * @param Model $model
   * @param JsonResource $resource
   * @param Integer $id
   * @param Array $relations
   * @return \Illuminate\Http\Response
   */
  function getOne(Model $model, $resource, $id, $relations = [])
  {
    $resourceNameSpace = 'App\Http\Resources\\' . $resource;
    try {
      $data = $model::find($id);
      if (!$data) return notFound();
      $data = new $resourceNameSpace($data->load($relations));
      return getData($data);
    } catch (\Throwable $th) {
      return error($th);
    }
  }
}

if (!function_exists('update')) {
  /**
   * Update specified resource
   *
   * @param Request $request
   * @param Model $model
   * @param JsonResoure $resource
   * @param Array $rules
   * @param Integer $id
   * @param Array $fieldsToUpdate
   * @return \Illuminate\Http\Response
   */
  function update($request, Model $model, $resource, $rules, $id, array $fieldsToUpdate = null)
  {
    $resourceNameSpace = 'App\Http\Resources\\' . $resource;

    $data = $model::find($id);
    if (!$data) return notFound();

    if (!validJson($request)) return badRequest("Erro no formato JSON !");

    $validator = validateRequest($request, $rules);

    if ($validator->fails()) {
      return validationError($validator->messages());
    }

    try {
      if (isset($fieldsToUpdate)) {
        $updatedData = $request->only($fieldsToUpdate);
      } else {
        $updatedData = validJson($request);
      }
      $data->update($updatedData);
      return updated(new $resourceNameSpace($data));
    } catch (\Throwable $th) {
      return error($th);
    }
  }
}
if (!function_exists('delete')) {

  /**
   * Delete a specified resource
   *
   * @param Model $model
   * @param Integer $id
   * @return \Illuminate\Http\Response
   */
  function delete(Model $model, $id)
  {
    $data = $model->find($id);
    if (!$data) return notFound();
    try {
      $data->delete($id);
      return deleted();
    } catch (\Throwable $th) {
      return error($th);
    }
  }
}
