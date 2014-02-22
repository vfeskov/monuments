<?php

class PicturesController extends BaseController
{
    public function getAll($collectionId, $monumentId)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($collectionId);
        if(!$collection){
            return Response::json(array('flash'=>'Collection not found'), 404);
        }
        if($collection->user_id !== Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }

        return Response::json(Picture::where('collection_id', '=', $collectionId)->where('monument_id', '=', $monumentId)->get());
    }

    public function create($collectionId, $monumentId)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        if(!Input::hasFile('image')){
            return Response::json(array('flash'=>'Image is required'), 400);
        }
        $imageFile = Input::file('image');
        $image = 'data:image/'.Input::file('image')->getClientOriginalExtension().';base64,'.base64_encode(File::get($imageFile->getPathname()));
        $collection = Collection::find($collectionId);
        if(!$collection){
            return Response::json(array('flash'=>'Collection not found'), 404);
        }
        if($collection->user_id !== Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        $name = trim(Input::get('name'));
        $description = Input::get('description');
        $date = Input::get('date');
        if(!$name){
            return Response::json(array('flash'=>'Name is required'), 400);
        }
        $picture = new Picture();
        $picture->image = $image;
        $picture->collection_id = $collectionId;
        $picture->date = $date;
        $picture->monument_id = $monumentId;
        $picture->name = $name;
        $picture->description = $description;
        if ($picture->save()) {
            return Response::json($picture);
        } else {
            return Response::json(array('error'=>'Something went wrong'), 500);
        }
    }

    public function getOne($collectionId, $monumentId, $id)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($collectionId);
        if(!$collection){
            return Response::json(array('flash'=>'Collection not found'), 404);
        }
        if($collection->user_id !== Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        $picture = Picture::where('id', '=', $id)
            ->where('collection_id', '=', $collectionId)
            ->where('monument_id', '=', $monumentId)
            ->first();

        return ($picture) ?
            Response::json($picture) :
            Response::json(array('Not found'), 404);
    }


    public function delete($collectionId, $monumentId, $id)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($collectionId);
        if(!$collection){
            return Response::json(array('flash'=>'Collection not found'), 404);
        }
        if($collection->user_id !== Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        $picture = Picture::where('id', '=', $id)
            ->where('collection_id', '=', $collectionId)
            ->where('monument_id', '=', $monumentId)
            ->first();
        if(!$picture){
            return Response::json(array('Not found'), 404);
        }
        if($picture->delete()){
            return Response::json(array(), 204);
        }
        return Response::json(array('flash'=>'Something went wrong'), 500);
    }

    public function update($collectionId, $monumentId, $id)
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $collection = Collection::find($collectionId);
        if(!$collection){
            return Response::json(array('flash'=>'Collection not found'), 404);
        }
        if($collection->user_id !== Auth::user()->id){
            return Response::json(array('Forbidden'), 403);
        }
        $picture = Picture::where('id', '=', $id)
            ->where('collection_id', '=', $collectionId)
            ->where('monument_id', '=', $monumentId)
            ->first();
        if(!$picture){
            return Response::json(array('Not found'), 404);
        }
        $name = trim(Input::json('name'));
        $description = Input::json('description');
        $date = Input::json('date');
        if(!$name){
            return Response::json(array('flash'=>'Name is required'), 400);
        }
        $picture->date = $date;
        $picture->name = $name;
        $picture->description = $description;
        if($picture->save()){
            return Response::json($collection, 200);
        }
        return Response::json(array('flash'=>'Something went wrong'), 500);
    }

}
