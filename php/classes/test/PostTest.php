78
/**
 *test inserting a post, editing it, and then updating it
 */
public function TestUpdateValidPost() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->retRowCount ("post");

	// create a new Post and insert to into mySQL
	$post = new Post(null, $this->profile->getPostProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
	$post->insert($this->getPDO());

	//edit the Post and update it in mySQL
	$post->setPostContent ($this->profile->VALID_POSTCONTENT2);
	$post->update($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoPost = Post::getPostby ($this->getPDO(), $post->get());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
	$this->assertEquals($pdoPost-getpostProfileId(), $this->profile->getPostProfileId());
	$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT2);
	$this->assertEquals($pdoPost->getPostDate(), $this->VALID_POSTCREATEDDATE);
	$this->assertEquals($pdoPost->getPostDate(), $this->VALID_POSTEVENTDATE);
}

/**
 * test updating a post that does not exist
 *
 * @exceptedException PDoException
 */
public function testUpdateInvalidPost() {
	// create a post, try to update it without actually updating it and watch it fail
	$post = new Post(null, $this->profile-getPostProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTCREATEDDATE, $this->VALID_POSTEVENTDATE);
	$post->update($this->getPDO());
}

/**
 * test creating a post and then deleting it
 */
public function testDeleteValidPost() {
	 // count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("post");

	// create a new post and insert into mySQL
	$post = new Post(null, $this->profile->getProfileId, $this-> $this->getConnection()->getRowCount("post"));
	$post->insert($this->getPDO());

	// delete the Post from mySQL
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
	$post->delete($this->getPDO());

	// grab the data from mySQL and enforce the Post does not exist
	$pdoPost = Post::getPostProfilebyPostProfileId($this->getPDO(), $post->getPostProfileId());
	$this->assertNUll($pdoPost);
	$this->assertEquals($numRows, $this->getConnection()->getRowCount("post"));
}

