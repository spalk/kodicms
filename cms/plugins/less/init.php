<?php defined('SYSPATH') or die('No direct access allowed.');

Kohana::load(PLUGPATH.'/less/vendors/lessc.inc.php');

$plugin = Model_Plugin_Item::factory( array(
	'id' => 'less',
	'title' => 'LESS Compiler',
	'description' => 'LESS extends CSS with dynamic behavior such as variables, mixins, operations and functions.',
	'settings' => TRUE
) )->register();

if($plugin->enabled() AND AuthUser::isLoggedIn())
{	
	less_compile($plugin);
}


function less_compile($plugin) {
	try
	{
		$less_folder_path = trim( $plugin->get('less_folder_path'), '/');
		$css_folder_path = trim( $plugin->get('css_folder_path'), '/');
				
		$less_path = DOCROOT.$less_folder_path.DIRECTORY_SEPARATOR;
		$css_path = DOCROOT.$css_folder_path.DIRECTORY_SEPARATOR;
		
		
		if((!is_dir($less_path) AND !is_dir($css_path)) OR $plugin->get('enabled') == 'no')
		{
			return;
		}

		$files = new DirectoryIterator($less_path);

		$params = array();
		if( $plugin->get('format_css', 'no') == 'no' )
		{
			$params = array(
				'newlineChar' => '',
				'indentChar' => '',
			);
		}
		
		$less = new lessc;

		foreach ($files as $file)
		{
			if ($file->isDot() OR $file->isDir() OR $file->getFilename() !== 'common.less') continue;

			$pathinfo = pathinfo($file->getFilename() );

			if($pathinfo['extension'] == 'less')
			{
				$less->compileFile( $less_path.$file->getFilename(), $css_path.DIRECTORY_SEPARATOR.$pathinfo['filename'].'.css', $params);
			}
		}
	}
	catch ( Exception $e ) 
	{
		throw new Exception($e);
	}
}

