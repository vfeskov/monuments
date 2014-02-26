<?php

class MonumentsTest extends TestCase {
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

        $collection = new Collection();
        $collection->name = 'Test collection2';
        $collection->user_id = 2;
        $collection->save();
    }

    public function testGetAll()
	{
        $this->action('GET', 'MonumentsController@getAll', array('collection_id'=>1));

        $this->_testAuthAndLogin();

        $response = $this->action('GET', 'MonumentsController@getAll', array('collection_id'=>1));
        $this->assertResponseOk();
        $this->assertEquals('[]', $response->getContent());

        $monument = new Monument();
        $monument->name = 'Test monument';
        $monument->description = 'Test monument desc';
        $monument->category_id = 1;
        $monument->collection_id = 1;
        $monument->save();

        $monument = new Monument();
        $monument->name = 'Test monument2';
        $monument->description = 'Test monument desc2';
        $monument->category_id = 1;
        $monument->collection_id = 2;
        $monument->save();

        $response = $this->action('GET', 'MonumentsController@getAll', array('collection_id'=>1));
        $this->assertResponseOk();
        $monuments = json_decode($response->getContent());
        $this->assertCount(1, $monuments);
        $this->assertEquals('Test monument', $monuments[0]->name);
	}

    public function testCreate()
    {
        $postData = array(
            'name' => 'Test monument',
            'description' => 'Test monument desc',
            'category_id' => 1
        );
        $this->action('POST', 'MonumentsController@create', array('collection_id'=>1), $postData);

        $this->_testAuthAndLogin();
        $response = $this->action('POST', 'MonumentsController@create', array('collection_id'=>1), $postData);

        $this->assertResponseOk();
        $monument = json_decode($response->getContent());
        $this->assertEquals('Test monument', $monument->name);
        $this->assertEquals('Test monument desc', $monument->description);
        $this->assertEquals(1, $monument->category_id);

        $monuments = Monument::where('collection_id', '=', 1)->get();
        $this->assertCount(1, $monuments);
        $this->assertEquals('Test monument', $monuments[0]->name);
        $this->assertEquals('Test monument desc', $monuments[0]->description);
        $this->assertEquals(1, $monuments[0]->category_id);
    }

    public function testGetOne()
    {
        $this->action('GET', 'MonumentsController@getOne', array('collection_id'=>1, 'id'=>1));
        $this->_testAuthAndLogin();

        $monument = new Monument(array(
            'name'=>'Test monument',
            'description'=>'Test monument description',
            'category_id'=>1
        ));
        $monument->collection_id = 1;
        $monument->save();

        $response = $this->action('GET', 'MonumentsController@getOne', array('collection_id'=>1, 'id'=>1));
        $this->assertResponseOk();
        $monument = json_decode($response->getContent());
        $this->assertEquals('Test monument', $monument->name);
        $this->assertEquals('Test monument description', $monument->description);
        $this->assertEquals(1, $monument->category_id);
    }

    public function testDelete()
    {
        $this->action('DELETE', 'MonumentsController@delete', array('collection_id'=>1, 'id'=>1));
        $this->_testAuthAndLogin();

        $monument = new Monument(array(
            'name'=>'Test monument',
            'description'=>'Test monument description',
            'category_id'=>1
        ));
        $monument->collection_id = 1;
        $monument->save();

        $monument = new Monument(array(
            'name'=>'Test monument2',
            'description'=>'Test monument description2',
            'category_id'=>1
        ));
        $monument->collection_id = 2;
        $monument->save();

        $response = $this->action('DELETE', 'MonumentsController@delete', array('collection_id'=>1, 'id'=>1));
        $this->assertResponseStatus(204);

        $response = $this->action('DELETE', 'MonumentsController@delete', array('collection_id'=>2, 'id'=>2));
        $this->assertResponseStatus(403);

        $monuments = Monument::all();
        $this->assertCount(1, $monuments);
        $this->assertEquals(2, $monuments[0]->id);
    }

    public function testUpdate()
    {
        $this->action('PUT', 'MonumentsController@update', array('collection_id'=>1, 'id'=>1));
        $this->_testAuthAndLogin();

        $monument = new Monument(array(
            'name'=>'Test monument',
            'description'=>'Test monument description',
            'category_id'=>1
        ));
        $monument->collection_id = 1;
        $monument->save();

        $response = $this->action('PUT', 'MonumentsController@update', array('collection_id'=>1, 'id' => 1), array(
            'name'=>'Test monument2',
            'description'=>'Test monument description2',
            'category_id'=>2
        ));
        $this->assertResponseOk();
        $monument = Monument::find(1);
        $this->assertEquals('Test monument2', $monument->name);
        $this->assertEquals('Test monument description2', $monument->description);
        $this->assertEquals(2, $monument->category_id);
    }

}