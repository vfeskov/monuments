<?php

class SearchController extends BaseController
{
    public function search()
    {
        if (!Auth::check()) {
            return Response::json(array('flash'=>'Authorization required'), 401);
        }
        $query = Input::json('query');
        if(!$query){
            return Response::json(array('flash'=>'Query string is required'), 400);
        }
        $collections = Collection::where('user_id','=',Auth::user()->id)->get();
        if(!$collections) {
            return Response::json(array('flash'=>'Not found'), 404);
        }
        $collections_ids = array();
        foreach($collections as $collection){
            $collections_ids[] = $collection->id;
        }
        $monuments = Monument::where('name', 'LIKE', '%'.$query.'%')->whereIn('collection_id', $collections_ids)->get();
        if(!$monuments){
            return Response::json(array('flash'=>'Not found'), 404);
        }
        return Response::json($monuments);
    }

}
