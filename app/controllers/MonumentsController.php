<?php

class MonumentsController extends BaseController
{
    public function getAll($collectionId)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($collectionId);
        if(!$collection){
            return Response::json(array('flash'=>'Collection not found'), 404);
        }
        if($collection->user_id != Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        return Response::json(Monument::where('collection_id', '=', $collectionId)->get());
    }

    public function create($collectionId)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($collectionId);
        if(!$collection){
            return Response::json(array('flash'=>'Collection not found'), 404);
        }
        if($collection->user_id != Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        $name = trim(Input::get('name'));
        $description = Input::get('description');
        $categoryId = Input::get('category_id');
        if(!$name){
            return Response::json(array('flash'=>'Name is required'), 400);
        }
        $monument = new Monument();
        $monument->collection_id = $collectionId;
        $monument->category_id = $categoryId;
        $monument->name = $name;
        $monument->description = $description;
        if ($monument->save()) {
            return Response::json($monument);
        } else {
            return Response::json(array('error'=>'Something went wrong'), 500);
        }
    }

    public function getOne($collectionId, $id)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($collectionId);
        if(!$collection){
            return Response::json(array('flash'=>'Collection not found'), 404);
        }
        if($collection->user_id != Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        $monument = Monument::where('id', '=', $id)->where('collection_id', '=', $collectionId)->first();

        return ($monument) ?
            Response::json($monument) :
            Response::json(array('Not found'), 404);
    }


    public function delete($collectionId, $id)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($collectionId);
        if(!$collection){
            return Response::json(array('flash'=>'Collection not found'), 404);
        }
        if($collection->user_id != Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        $monument = Monument::where('id', '=', $id)->where('collection_id', '=', $collectionId)->first();
        if(!$monument){
            return Response::json(array('Not found'), 404);
        }
        if($monument->delete()){
            return Response::json(array(), 204);
        }
        return Response::json(array('flash'=>'Something went wrong'), 500);
    }

    public function update($collectionId, $id)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($collectionId);
        if(!$collection){
            return Response::json(array('flash'=>'Collection not found'), 404);
        }
        if($collection->user_id != Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        $monument = Monument::where('id', '=', $id)->where('collection_id', '=', $collectionId)->first();
        if(!$monument){
            return Response::json(array('Not found'), 404);
        }
        $name = trim(Input::get('name'));
        $description = Input::get('description');
        $categoryId = Input::get('category_id');
        if(!$name){
            return Response::json(array('flash'=>'Name is required'), 400);
        }
        $monument->collection_id = $collectionId;
        $monument->category_id = $categoryId;
        $monument->name = $name;
        $monument->description = $description;
        if($monument->save()){
            return Response::json($collection, 200);
        }
        return Response::json(array('flash'=>'Something went wrong'), 500);
    }

}
