<?php defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

class Controller_Snippet extends Controller_System_Backend {

	public $auth_required = array( 'administrator', 'developer' );

	public function action_index()
	{
		$this->template->content = View::factory( 'snippet/index', array(
			'snippets' => Model_File_Snippet::find_all()
		) );
	}

	public function action_add()
	{
		// check if trying to save
		if ( Request::current()->method() == Request::POST )
		{
			return $this->_add();
		}
		
		$this->template->breadcrumbs = array(
			HTML::anchor( 'snippet', __('Snippets')),
			__('Add snippet')
		);

		// check if user have already enter something
		$snippet = Flash::get( 'post_data' );

		if ( empty( $snippet ) )
		{
			$snippet = new Model_File_Snippet;
		}

		$this->template->content = View::factory( 'snippet/edit', array(
			'action' => 'add',
			'filters' => Filter::findAll(),
			'snippet' => $snippet
		) );
	}

	private function _add()
	{
		$data = $_POST['snippet'];
		Flash::set( 'post_data', (object) $data );

		$snippet = new Model_File_Snippet( $data['name'] );
		$snippet->content = $data['content'];

		if ( !$snippet->save() )
		{
			Messages::errors( __( 'Snippet <b>:name</b> has not been added. Name must be unique!', array( ':name' => $snippet->name ) ) );
			$this->go( URL::site( 'snippet/add' ) );
		}
		else
		{
			Messages::success( __( 'Snippet <b>:name</b> has been added!', array( ':name' => $snippet->name ) ) );
			Observer::notify( 'snippet_after_add', array( $snippet ) );
		}
		
		Session::instance()->delete('post_data');

		// save and quit or save and continue editing?
		if ( isset( $_POST['commit'] ) )
		{
			$this->go( URL::site( 'snippet' ) );
		}
		else
		{
			$this->go( URL::site( 'snippet/edit/' . $snippet->name ) );
		}
	}

	public function action_edit( )
	{
		$snippet_name = $this->request->param('id');
		$snippet = new Model_File_Snippet( $snippet_name );

		if ( !$snippet->is_exists() )
		{
			Messages::errors( __( 'Snippet <b>:name</b> not found!', array( ':name' => $snippet->name ) ) );
			$this->go( URL::site( 'snippet' ) );
		}
		
		$this->template->breadcrumbs = array(
			HTML::anchor( 'snippet', __('Snippets')),
			__('Edit snippet :snippet', array(':snippet' => $snippet->name))
		);

		// check if trying to save
		if ( Request::current()->method() == Request::POST )
		{
			return $this->_edit( $snippet_name );
		}

		$this->template->content = View::factory( 'snippet/edit', array(
			'action' => 'edit',
			'filters' => Filter::findAll(),
			'snippet' => $snippet
		) );
	}

	private function _edit( $snippet_name )
	{
		$data = $_POST['snippet'];

		$snippet = new Model_File_Snippet( $snippet_name );
		$snippet->name = $data['name'];
		$snippet->content = $data['content'];

		if ( !$snippet->save() )
		{
			Messages::errors( __( 'Snippet <b>:name</b> has not been saved. Name must be unique!', array( ':name' => $snippet->name ) ) );
			$this->go( URL::site( 'snippet/edit/' . $snippet->name ) );
		}
		else
		{
			Messages::success( __( 'Snippet <b>:name</b> has been saved!', array( ':name' => $snippet->name ) ) );
			Observer::notify( 'snippet_after_edit', array( $snippet ) );
		}

		// save and quit or save and continue editing?
		if ( isset( $_POST['commit'] ) )
		{
			$this->go( URL::site( 'snippet' ) );
		}
		else
		{
			$this->go( URL::site( 'snippet/edit/' . $snippet->name ) );
		}
	}

	public function action_delete( )
	{
		$this->auto_render = FALSE;
		$snippet_name = $this->request->param('id');

		$snippet = new Model_File_Snippet( $snippet_name );

		// find the user to delete
		if ( $snippet->is_exists() )
		{
			if ( $snippet->delete() )
			{
				Messages::suceess( __( 'Snippet <b>:name</b> has been deleted!', array( ':name' => $snippet->name ) ) );
				Observer::notify( 'snippet_after_delete', array( $snippet ) );
			}
			else
			{
				Messages::errors( __( 'Snippet <b>:name</b> has not been deleted!', array( ':name' => $snippet->name ) ) );
			}
		}
		else
		{
			Messages::errors( __( 'Snippet not found!' ) );
		}

		$this->go( URL::site( 'snippet' ) );
	}

}

// end SnippetController class