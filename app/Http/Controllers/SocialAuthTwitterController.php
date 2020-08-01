<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialTwitterAccountService;

class SocialAuthTwitterController extends Controller
{
  /**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
    public function redirect(Request $request)
    {
        return Socialite::driver('twitter')->redirect();          
    }
    
    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(SocialTwitterAccountService $service, Request $request)
    {
      
      $user = $service->createOrGetUser(Socialite::driver('twitter')->user());              
      auth()->login($user);
      return redirect()->to('/');
    }
}