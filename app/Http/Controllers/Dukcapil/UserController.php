<?php

namespace App\Http\Controllers\Dukcapil;

use App\Helpers\RequestHandler;
use App\Http\Controllers\Controller;
use App\Models\Citizen;
use App\Models\ClaimCitizenRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function accept($id)
    {
        return RequestHandler::handle(function() use($id) {
            $claimRequest = ClaimCitizenRequest::find($id);
            if($claimRequest == null)
            {
                throw new Exception("Claim request not found");
                return;
            }
            $citizen = Citizen::whereHas('user')->find($claimRequest->citizen_id);
            if($citizen != null)
            {
                throw new Exception("Citizen already has an user");
                return;
            }
            $includedFields = ['username', 'email', 'mobile', 'password', 'userable_type', 'userable_id'];

            $userData = $claimRequest->toArray();
            $userData['userable_type'] = 'citizen';
            $userData['password'] = bcrypt($userData['password']);
            $userData['userable_id'] = $userData['citizen_id'];
            $userData = Arr::only($userData, $includedFields);

            DB::beginTransaction();
            try
            {
                User::create($userData);
                $claimRequest->status = 'accepted';
                $claimRequest->save();
                DB::commit();
            }
            catch(\Throwable $e)
            {
                DB::rollBack();
                throw new Exception($e->getMessage());
            }
            return back()->with('success', 'User accepted');
        });
    }
    public function deny($id)
    {
        return RequestHandler::handle(function() use($id) {
            $claimRequest = ClaimCitizenRequest::find($id);
            if($claimRequest == null)
            {
                throw new Exception("Claim request not found");
                return;
            }
            $claimRequest->status = 'denied';
            $claimRequest->save();

            return back()->with('success', 'User denied');
        });
    }
    public function destroy($id)
    {
        return RequestHandler::handle(function() use($id) {
            $user = User::find($id);
            if($user == null || $user->userable_type == 'dukcapil')
            {
                throw new Exception("User not found");
                return;
            }
            $user->delete();
            return back()->with('success', 'user deleted successfully');
        });
    }
}
