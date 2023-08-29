<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LogWriter;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
class UserController extends Controller
{
    public function index()
    {
        abort_if_forbidden('user.show');
        $users = User::where('id', '!=', auth()->user()->id)->get();
        return view('pages.user.index', compact('users'));
    }

    public function add()
    {
        abort_if_forbidden('user.add');

        $roles = auth()->user()->hasRole('Super Admin')
            ? Role::all()
            : Role::where('name', '!=', 'Super Admin')->get();

        return view('pages.user.add', compact('roles'));
    }

    public function create(Request $request)
    {
        abort_if_forbidden('user.add');

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->assignRole($request->input('roles'));

        $activity = "\nCreated by: " . json_encode(auth()->user())
            . "\nNew User: " . json_encode($user)
            . "\nRoles: " . implode(", ", $request->input('roles') ?? []);

        LogWriter::user_activity($activity, 'AddingUsers');

        return redirect()->route('userIndex');
    }
    public function edit($id)
    {
        $user = User::find($id);
    
        if ($user->hasRole('Super Admin')) {
            if (auth()->user()->hasRole('Manager')) {
                return back()->withErrors("You don't have permission to edit a user with Super Admin role.");
            }
        }
    
        abort_if((!auth()->user()->can('user.edit') && auth()->id() != $id), 403);
    
        // Fetch roles for dropdown
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::all();
        } else {
            $roles = Role::where('name', '!=', 'Super Admin')->get();
        }
    
        return view('pages.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
{
    abort_if((!auth()->user()->can('user.edit') && auth()->id() != $id),403);

    $activity = "\nUpdated by: ".logObj(auth()->user());
    $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
        'password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ]);

    $user = User::find($id);

    if ($user->hasRole('Super Admin') && !auth()->user()->hasRole('Super Admin'))
    {
        message_set("У вас нет Permissions на редактирование администратора",'error',5);
        return redirect()->back();
    }

    if ($request->get('password') != null)
    {
        $user->password = Hash::make($request->get('password'));
    }

    unset($request['password']);
    $activity .="\nBefore updates User: ".logObj($user);
    $activity .=' Roles before: "'.implode(',',$user->getRoleNames()->toArray()).'"';

    $user->fill($request->all());
    $user->save();

    if (isset($request->roles)) $user->syncRoles($request->get('roles'));
    unset($user->roles);

    $activity .="\nAfter updates User: ".logObj($user);
    $activity .=' Roles after: "'.implode(',',$user->getRoleNames()->toArray()).'"';

    LogWriter::user_activity($activity,'EditingUsers');

    if (auth()->user()->can('userEdit'))
        return redirect()->route('userIndex'); // Change 'userIndex' to 'user.index' if needed
    else
        return redirect()->route('home');
}

    public function destroy($id)
    {
        abort_if_forbidden('user.delete');
    
        $userToDelete = User::find($id);
    
        if ($userToDelete->hasRole('Super Admin')) {
            return back()->withErrors("You can't delete a user with Super Admin role.");
        }
    
        if ($userToDelete->hasRole('Super Admin') && !auth()->user()->hasRole('Super Admin')) {
            return back()->withErrors("You don't have permission to delete a user with Super Admin role.");
        }
    
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        DB::table('model_has_permissions')->where('model_id', $id)->delete();
    
        $userToDelete->delete();
    
        $deletedBy = logObj(auth()->user());
        $userLog = logObj($userToDelete);
        $message = "\nDeleted By: $deletedBy\nDeleted user: $userLog";
        LogWriter::user_activity($message, 'DeletingUsers');
    
        return redirect()->route('userIndex');
    }

    // ... Rest of the methods ...

    public function setTheme(Request $request, $id)
    {
        $this->validate($request, [
            'theme' => 'required|in:default,dark,light',
        ]);

        $user = User::findOrFail($id);
        $user->setTheme($request->input('theme'));
        message_set("Theme `$request->theme` is installed!", 'success', 1);

        return redirect()->back();
    }

    // public function toggleStatus($status)
    // {
    //     $userId = auth()->user()->id;
    //     $statusID = $status == "online" ? 1 : 0;
    //     $user = User::find($userId);
    //     $user->status = $statusID;
    //     $user->save();
    //     return response()->json(['message' => ucfirst($status) . ' mode activated']);
    // }

    public function toggleStatus(Request $request)
    {
        $user = Auth::user();
        $newStatus = $user->status === 'offline' ? 'online' : 'offline';
        $user->update(['status' => $newStatus]);
    
        return redirect()->back()->with('status', 'Your status has been updated.');
    }
}
