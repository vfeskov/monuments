<?php

class CollectionsController extends BaseController
{

    public function getAll()
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }

        return Response::json(Collection::where('user_id', '=', Auth::user()->id)->get());
    }

    public function create()
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $name = trim(Input::get('name'));
        if(!$name){
            return Response::json(array('flash'=>'Name is required'), 400);
        }
        $collection = new Collection();
        $collection->user_id = Auth::user()->id;
        $collection->name = $name;
        if ($collection->save()) {
            return Response::json($collection);
        } else {
            return Response::json(array('error'=>'Something went wrong'), 500);
        }
    }

    public function getOne($id)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();

        return ($collection) ?
            Response::json($collection) :
            Response::json(array('Not found'), 404);
    }


    public function delete($id)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($id);
        if(!$collection){
            return Response::json(array('Not found'), 404);
        }
        if($collection->user_id != Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        if($collection->delete()){
            return Response::json(array(), 204);
        }
        return Response::json(array('flash'=>'Something went wrong'), 500);
    }

    public function update($id)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($id);
        if(!$collection){
            return Response::json(array('Not found'), 404);
        }
        $name = trim(Input::get('name'));
        if(!$name){
            return Response::json(array('flash'=>'Name is required'), 400);
        }
        if($collection->user_id != Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        $collection->name = $name;
        if($collection->save()){
            return Response::json($collection, 200);
        }
        return Response::json(array('flash'=>'Something went wrong'), 500);
    }

}
