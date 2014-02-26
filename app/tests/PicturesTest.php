<?php

class PicturesTest extends TestCase {
    private $_currentUserId = 1;

	private function _testAuthAndLogin(){
        $this->assertResponseStatus(401);

        $user = new User();
        $user->id = $this->_currentUserId;
        $user->email = 'test@test.com';
        $this->be($user);

        $collection = new Collection();
        $collection->name = 'Test collection';
        $collection->user_id = $this->_currentUserId;
        $collection->save();

        $monument = new Monument(array(
            'name'=>'Test monument',
            'description'=>'Test monument description',
            'category_id'=>1
        ));
        $monument->collection_id = 1;
        $monument->save();
    }

    public function testGetAll()
	{
        $this->action('GET', 'PicturesController@getAll', array('monument_id'=>1, 'collection_id'=>1));

        $this->_testAuthAndLogin();

        $response = $this->action('GET', 'PicturesController@getAll', array('monument_id'=>1, 'collection_id'=>1));
        $this->assertResponseOk();
        $this->assertEquals('[]', $response->getContent());

        $picture = new Picture(array(
            'name'=>'Test picture',
            'description'=>'Test picture desc',
            'date'=>'12/12/12'
        ));
        $picture->monument_id = 1;
        $picture->collection_id = 1;
        $picture->save();

        $picture = new Picture(array(
            'name'=>'Test picture2',
            'description'=>'Test picture desc2',
            'date'=>'12/12/12'
        ));
        $picture->monument_id = 2;
        $picture->collection_id = 2;
        $picture->save();

        $response = $this->action('GET', 'PicturesController@getAll', array('monument_id'=>1, 'collection_id'=>1));
        $this->assertResponseOk();
        $pictures = json_decode($response->getContent());
        $this->assertCount(1, $pictures);
        $this->assertEquals('Test picture', $pictures[0]->name);
	}

    /*public function testCreate()
    {
        $postData = array(
            'name'=>'Test picture',
            'description'=>'Test picture desc',
            'date'=>'12/12/12'
        );
        $this->action('POST', 'PicturesController@create', array('monument_id'=>1, 'collection_id'=>1), $postData);

        $this->_testAuthAndLogin();
        $response = $this->action('POST', 'PicturesController@create', array('monument_id'=>1, 'collection_id'=>1), $postData);

        $this->assertResponseOk();
        $picture = json_decode($response->getContent());
        $this->assertEquals('Test picture', $picture->name);
        $this->assertEquals('Test picture desc', $picture->description);
        $this->assertEquals('12/12/12', $picture->date);

        $pictures = Picture::where('collection_id', '=', 1)->where('monument_id', '=', 1)->get();
        $this->assertCount(1, $pictures);
        $this->assertEquals('Test picture', $pictures[0]->name);
        $this->assertEquals('Test picture desc', $pictures[0]->description);
        $this->assertEquals('12/12/12', $pictures[0]->date);
    }

    public function testGetOne()
    {
        $this->action('GET', 'PicturesController@getOne', array('monument_id'=>1, 'collection_id'=>1, 'id'=>1));
        $this->_testAuthAndLogin();

        $picture = new Picture(array(
            'name'=>'Test picture',
            'description'=>'Test picture description',
            'category_id'=>1
        ));
        $picture->collection_id = 1;
        $picture->save();

        $response = $this->action('GET', 'PicturesController@getOne', array('monument_id'=>1, 'collection_id'=>1, 'id'=>1));
        $this->assertResponseOk();
        $picture = json_decode($response->getContent());
        $this->assertEquals('Test picture', $picture->name);
        $this->assertEquals('Test picture description', $picture->description);
        $this->assertEquals(1, $picture->category_id);
    }

    public function testDelete()
    {
        $this->action('DELETE', 'PicturesController@delete', array('monument_id'=>1, 'collection_id'=>1, 'id'=>1));
        $this->_testAuthAndLogin();

        $picture = new Picture(array(
            'name'=>'Test picture',
            'description'=>'Test picture description',
            'category_id'=>1
        ));
        $picture->collection_id = 1;
        $picture->save();

        $picture = new Picture(array(
            'name'=>'Test picture2',
            'description'=>'Test picture description2',
            'category_id'=>1
        ));
        $picture->collection_id = 2;
        $picture->save();

        $response = $this->action('DELETE', 'PicturesController@delete', array('monument_id'=>1, 'collection_id'=>1, 'id'=>1));
        $this->assertResponseStatus(204);

        $pictures = Picture::all();
        $this->assertCount(1, $pictures);
        $this->assertEquals(2, $pictures[0]->id);
    }

    public function testUpdate()
    {
        $this->action('PUT', 'PicturesController@update', array('monument_id'=>1, 'collection_id'=>1, 'id'=>1));
        $this->_testAuthAndLogin();

        $picture = new Picture(array(
            'name'=>'Test picture',
            'description'=>'Test picture description',
            'category_id'=>1
        ));
        $picture->collection_id = 1;
        $picture->save();

        $response = $this->action('PUT', 'PicturesController@update', array('monument_id'=>1, 'collection_id'=>1, 'id' => 1), array(
            'name'=>'Test picture2',
            'description'=>'Test picture description2',
            'category_id'=>2
        ));
        $this->assertResponseOk();
        $picture = Picture::find(1);
        $this->assertEquals('Test picture2', $picture->name);
        $this->assertEquals('Test picture description2', $picture->description);
        $this->assertEquals(2, $picture->category_id);
    }*/

}