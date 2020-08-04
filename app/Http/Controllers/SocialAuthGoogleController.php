<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialGoogleAccountService;

class SocialAuthGoogleController extends Controller
{
  /**
   * Create a redirect method to twitter api.
   *
   * @return void
   */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();          
    }
    
    /**
     * Return a callback method from twitter api.
     *
     * @return callback URL from twitter
     */
    public function callback(SocialGoogleAccountService $service, Request $request)
    {
      
      $user = $service->createOrGetUser(Socialite::driver('google')->user());              
     // dd($user);
      auth()->login($user);
      return redirect()->to('/');
    }
}
