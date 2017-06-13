<?php
/**
 * Class FilesTest
 *
 * @package Advanced_Cron_Manager
 */

namespace underDEV\AdvancedCronManager\Utils;

/**
 * Files test case.
 */
class FilesTest extends \PHPUnit_Framework_TestCase  {

	public function setUp() {

		\WP_Mock::setUp();

		\WP_Mock::userFunction( 'trailingslashit', array(
            'return' => function( $s ) {
                return $s . '/';
            }
        ) );

		$this->files = new Files();

	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}

	public function test_build_dir_from_array() {

		$dir = $this->files->build_dir_from_array( array(
			'example', 'test', 'string'
		) );

		$this->assertEquals( 'example/test/string/', $dir );


	}

	public function test_resolve_file_path() {

		$dir1 = $this->files->resolve_file_path( array(
			'example', 'test', 'string', 'file.php'
		) );

		$this->assertEquals( 'example/test/string/file.php', $dir1 );

		$dir2 = $this->files->resolve_file_path( 'file.php' );

		$this->assertEquals( 'file.php', $dir2 );

	}

	public function test_asset_url() {

		\WP_Mock::userFunction( 'plugin_dir_url', array(
            'return' => ''
        ) );

		$asset_url = $this->files->asset_url( 'type', 'file.type' );

		$this->assertEquals( 'assets/dist/type/file.type', $asset_url );

	}

}
