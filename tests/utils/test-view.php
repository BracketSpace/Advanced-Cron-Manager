<?php
/**
 * Class FilesTest
 *
 * @package Advanced_Cron_Manager
 */

namespace underDEV\AdvancedCronManager\Utils;

/**
 * View test case.
 */
class ViewTest extends \PHPUnit_Framework_TestCase  {

	public function setUp() {

		\WP_Mock::setUp();

		$this->files = \Mockery::mock( __NAMESPACE__ . '\Files' );

		$this->view = new View( $this->files );

	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}

	public function test_set_var_null() {

		$this->assertInstanceOf( __NAMESPACE__ . '\View', $this->view->set_var() );

	}

	public function test_set_var_already_set() {

		$this->expectException( \PHPUnit_Framework_Error::class );

		$this->view->set_var( 'var', 'value' );

		$this->assertInstanceOf( __NAMESPACE__ . '\View', $this->view->set_var( 'var', 'value' ) );

	}

	public function test_set_var_override() {

		$this->view->set_var( 'var', 'value' );
		$this->view->set_var( 'var', 'new', true );

		$this->assertEquals( 'new', $this->view->get_var( 'var' ) );

	}

	public function test_set_var_get_var() {

		$this->view->set_var( 'var', 'value' );

		$this->assertEquals( 'value', $this->view->get_var( 'var' ) );

	}

	public function test_set_vars_not_array() {

		$this->expectException( \PHPUnit_Framework_Error::class );

		$this->assertInstanceOf( __NAMESPACE__ . '\View', $this->view->set_vars( new \stdClass ) );

	}

	public function test_set_vars() {

		$returned = $this->view->set_vars( array(
			'var1' => 'value1',
			'var2' => 'value2'
		) );

		$this->assertInstanceOf( __NAMESPACE__ . '\View', $returned );

		$this->assertEquals( 'value1' , $this->view->get_var( 'var1' ) );
		$this->assertEquals( 'value2' , $this->view->get_var( 'var2' ) );

	}

	public function test_get_var_null() {

		$this->assertNull( $this->view->get_var( 'var' ) );

	}

	public function test_remove_var() {

		$this->view->set_var( 'var', 'value' );
		$this->view->remove_var( 'var' );

		$this->assertNull( $this->view->get_var( 'var' ) );

	}

	public function test_get_view() {

		$this->expectException( \PHPUnit_Framework_Error::class );

		$this->files->shouldReceive( 'file_path' )
			->once()
			->andReturn( 'asd' );

		$returned = $this->view->get_view( 'view' );

		$this->assertInstanceOf( __NAMESPACE__ . '\View', $returned );

	}

}
