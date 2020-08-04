<?php
namespace App\Services;
use App\SocialGoogleAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\Mail;


class SocialGoogleAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialGoogleAccount::whereProvider('google')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {
            $account = new SocialGoogleAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'google'
            ]);
            $user = User::whereEmail($providerUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(uniqid()), // we use md5 where user will not able to use this as normal login :)
                    'role'=>'customer',
                ]);

                if($user){
                    $data = [];
                    $data['email'] = $providerUser->getEmail();
                    $data['name'] = $providerUser->getName();                     
                }
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}
