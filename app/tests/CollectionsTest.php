<?php

class CollectionsTest extends TestCase {
    private $_currentUserId = 1;

	private function _testAuthAndLogin(){
        $this->assertResponseStatus(401);

        $user = new User();
        $user->id = $this->_currentUserId;
        $user->email = 'test@test.com';
        $this->be($user);
    }

    public function testGetAll()
	{
        $this->action('GET', 'CollectionsController@getAll');

        $this->_testAuthAndLogin();

        $response = $this->action('GET', 'CollectionsController@getAll');
        $this->assertResponseOk();
        $this->assertEquals('[]', $response->getContent());

        $collection = new Collection();
        $collection->name = 'Test collection';
        $collection->user_id = $this->_currentUserId;
        $collection->save();

        $collection = new Collection();
        $collection->name = 'Test collection2';
        $collection->user_id = 2;
        $collection->save();

        $response = $this->action('GET', 'CollectionsController@getAll');
        $this->assertResponseOk();
        $collections = json_decode($response->getContent());
        $this->assertCount(1, $collections);
        $this->assertEquals('Test collection', $collections[0]->name);
	}

    public function testCreate()
    {
        $postData = array('name' => 'Test collection');
        $this->action('POST', 'CollectionsController@create', array(), $postData);

        $this->_testAuthAndLogin();
        $response = $this->action('POST', 'CollectionsController@create', array(), $postData);

        $this->assertResponseOk();
        $collection = json_decode($response->getContent());
        $this->assertEquals('Test collection', $collection->name);

        $collections = Collection::where('user_id', '=', $this->_currentUserId)->get();
        $this->assertCount(1, $collections);
        $this->assertEquals('Test collection', $collections[0]->name);
    }

    public function testGetOne()
    {
        $this->action('GET', 'CollectionsController@getOne', array('id'=>1));
        $this->_testAuthAndLogin();

        $collection = new Collection();
        $collection->name = 'Test collection';
        $collection->user_id = $this->_currentUserId;
        $collection->save();

        $response = $this->action('GET', 'CollectionsController@getOne', array('id'=>1));
        $this->assertResponseOk();
        $collection = json_decode($response->getContent());
        $this->assertEquals('Test collection', $collection->name);
    }

    public function testDelete()
    {
        $this->action('DELETE', 'CollectionsController@delete', array('id'=>1));
        $this->_testAuthAndLogin();

        $collection = new Collection();
        $collection->name = 'Test collection';
        $collection->user_id = $this->_currentUserId;
        $collection->save();

        $collection = new Collection();
        $collection->name = 'Test collectio2';
        $collection->user_id = 2;
        $collection->save();

        $response = $this->action('DELETE', 'CollectionsController@delete', array('id' => 1));
        $this->assertResponseStatus(204);

        $response = $this->action('DELETE', 'CollectionsController@delete', array('id' => 2));
        $this->assertResponseStatus(403);

        $collections = Collection::all();
        $this->assertCount(1, $collections);
        $this->assertEquals(2, $collections[0]->id);
    }

    public function testUpdate()
    {
        $this->action('PUT', 'CollectionsController@update', array('id'=>1));
        $this->_testAuthAndLogin();

        $collection = new Collection();
        $collection->name = 'Test collection';
        $collection->user_id = $this->_currentUserId;
        $collection->save();

        $response = $this->action('PUT', 'CollectionsController@update', array('id' => 1), array('name'=>'Test collection2'));
        $this->assertResponseOk();
        $collection = Collection::find(1);
        $this->assertEquals('Test collection2', $collection->name);
    }

}