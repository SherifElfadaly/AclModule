<?php namespace App\Modules\Acl\Http\Controllers;

use App\Modules\Acl\Http\Controllers\AclBaseController;
use App\Modules\Acl\Repositories\AclRepository;
use Illuminate\Http\Request;

class ProfileController extends AclBaseController {

	/**
	 * Create new ProfileController instance.
	 * @param AclRepository
	 */
	public function __construct(AclRepository $acl)
	{
		parent::__construct($acl);

		//If the profile is admin.
		$this->middleware('App\Modules\Acl\Http\Middleware\AclAuthenticate');
	}

	/**
	 * Display the profile.
	 *
	 * @return Response
	 */
	public function getShow($userId)
	{
		$user = $this->acl->getUser($userId);
		return view('Acl::profile.profile', compact('user'));
	}

	/**
	 * Show the form for creating a new profile.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return view('Acl::profile.addprofile');
	}

	/**
	 * Store a newly created profile in storage.
	 *
	 * @return Response
	 */
	public function postCreate(Request $request, $id)
	{
		foreach ($request->input('key') as $key) 
		{
			if (strlen($key) == 0) 
			{
				return redirect()->back()->withErrors("Key Required");
			}
		}

		foreach ($request->input('value') as $value) 
		{
			if (strlen($value) == 0) 
			{
				return redirect()->back()->withErrors("Value Required");
			}
		}

		$data    = $this->acl->prepareProfileData($request->all());
		$profile = $this->acl->createProfile($data, $id);

		return 	redirect()->back()->with('message', 'Your profile had been created');
	}

	/**
	 * Remove the specified profile from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$this->acl->deleteProfile($id);
		return 	redirect()->back();
	}

}
