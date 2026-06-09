
<?php



use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('name', 'like', "%{$search}%")->get();

        return view('users.index', compact('users'));
    }
}