<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    public function data()
    {
        $user = User::all();
        $user = $user->map(function($user){
            $user->getRoleNames();
            return $user;
        });
        // return \jsonResponse($user);

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('user.update', $user->id) .'`, `'.route('user.edit', $user->id).'`)" class="btn btn-xs btn-info btn-flat btn_user_edit"><i class="fa fa-pencil"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $role = Role::orderBy('id')->get(['id','name']);
            if ($role == null) {
                throw new NotFoundHttpException("Role tidak ditemukan");
            }
            return jsonResponse($role);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request->filled('password')) {
                $hash_password = bcrypt($request->password);
                $request->merge(["password"=>$hash_password]);
            }
            $user = User::create(
                $request->only(['name','email','password'])
            );

            $user->assignRole($request->role);
            DB::commit();
            return jsonResponse($user);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [];
        try {
            $user = User::where('id',$id)->get();
            $user->map(function($user){
                $user->getRoleNames();
            })->collect();
            $role = Role::all();
            if ($user == null) {
                throw new NotFoundHttpException("User tidak ditemukan");
            }
            $data['user'] = $user;
            $data['roles'] = $role;
            return jsonResponse($data);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            if ($user == null) {
                throw new NotFoundHttpException("User tidak ditemukan");
            }
            $user->update($request->only(['name', 'email']));
            $user->syncRoles($request->only('role'));
            DB::commit();
            return jsonResponse($user);
        } catch (NotFoundHttpException $th) {
            DB::rollback();
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            DB::rollback();
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if ($user == null) {
                throw new NotFoundHttpException("User tidak ditemukan");
            }
            $user->delete();
            return jsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (NotFoundHttpException $th) {
            return jsonResponse($th->getMessage(), $th->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return jsonResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
