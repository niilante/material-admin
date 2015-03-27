<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use IgetMaster\MaterialAdmin\Models\User;
use IgetMaster\MaterialAdmin\Models\PermissionGroup;

class UserController extends RestController {
	/**
	 * The model class name used by the controller.
	 *
	 * @var string
	 */
	public $model = "IgetMaster\MaterialAdmin\Models\User";

	/**
	 * The resource name used in routes
	 *
	 * @var string
	 */
	public $resource = "user";

	public function __construct()
    {
        $this->beforeFilter('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::with('permission_group')->paginate(15);
		return \View::make('materialadmin::user.index')->with('users', $users);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return \View::make('materialadmin::user.create')->with('permission_groups', PermissionGroup::getSelectOptions());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make(
			\Input::all(), 
			Array(
				'name' => 'required',
				'surname' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required|confirmed|min:6',
				'permission_group_id' => 'required|integer',
				'dob' => 'date_format:d/m/Y',
				'language' => 'required'
			)
		);


		if ($validator->fails())
		{
			return \Redirect::back()->withInput()->withErrors($validator);
		}

		$user = User::create(
			Array(
				'name' => \Input::get('name'),
				'surname' => \Input::get('surname'),
				'email' => \Input::get('email'),
				'permission_group_id' => \Input::get('permission_group_id'),
				'password' => \Hash::make(\Input::get('password')),
				'dob' => \Input::get('dob'),
				'language' => \Input::get('language'),
			)
		);

		return \Redirect::route('user.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::with('permission_group')->findOrFail($id);
		$response = \View::make('materialadmin::user.edit')->with('user', $user)->with('permission_groups', PermissionGroup::getSelectOptions());
		return $response; 

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$validator = \Validator::make(
			\Input::all(), 
			Array(
				'name' => 'required',
				'surname' => 'required',
				'password' => 'confirmed|min:6',
				'permission_group_id' => 'required|integer',
				'dob' => 'date_format:d/m/Y',
				'language' => 'required'
			)
		);

		if ($validator->fails())
		{
			return \Redirect::back()->withInput()->withErrors($validator);
		}

		$user->name = \Input::get('name');
		$user->surname = \Input::get('surname');
		$user->permission_group_id = \Input::get('permission_group_id');
		$user->dob = \Input::get('dob');
		$user->language = \Input::get('language');

		if (strlen(\Input::get('password'))) {
			$user->password = \Hash::make(\Input::get('password'));
		}

		$user->save();

		$messages = with(new MessageBag())->add('success', 'Usuário modificado com sucesso!');

		return \Redirect::route('user.index')->with('messages', $messages);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::findOrFail($id);
		$messages = new MessageBag();

		if (\Auth::user()->id == $user->id) {
			$messages->add('danger', 'Você não pode excluir o próprio usuário.');
		} else {
			if (\Auth::user()->level >= $user->level) {
				if ($user->delete()) {
					$messages->add('success', 'Usuário excluído com sucesso!');
					return \Redirect::route('user.index')->with('messages', $messages);
				} else {
					$messages->add('danger', 'Não foi possível excluir usuário!');
				}
			} else {
				$messages->add('danger', 'Você não possui permissão para excluir esse usuário.');
			}
		}

		return \Redirect::back()->withInput()->with('messages', $messages);
	}
}
