<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AxiosVideoController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Search;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VotesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// -------------------------------------------------Verification Emails Routes------------------------------------------------

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// ----------------------------------------------------End Email Verification Routes------------------------------------------

Auth::routes();
Route::post('get-states-by-country',[RegisterController::class,'getState']);
Route::post('get-cities-by-state',[RegisterController::class,'getCity']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * this route is for the Axios Interval which we define in Channel-uploads.js 
 * to get the video form the Server after every 3 seconds
 */
Route::get('videos/{video}',[AxiosVideoController::class, 'show']);
Route::put('videos/{video}',[AxiosVideoController::class, 'updateviews']);
Route::put('videos/{video}/update',[AxiosVideoController::class, 'update'])->middleware(['auth'])->name('videos.update');

/**
 * Route to get the Comments of specific video this will be general route 
 * we are not assign middleware Auth for it because anyone can view this these comments
 */
Route::get('videos/{video}/comments',[CommentController::class,'index']);
/**
 * replies Route to get the Replies of specific Comment
 */
Route::get('comments/{comment}/replies',[CommentController::class,'show']);



/**
 * Laravel route model binding is used in this controller
 */
// Route::resource('channels', ChannelController::class)->middleware('admin'); this url will be used for only admin due to middleware below can be used for Auth users
Route::resource('channels', ChannelController::class);
/**
 * here we define resource for Subscription controller and model 
 * as we see the url channels/{channel}/subscriptions
 * bc the it has a relation to channels .. so every channel has a id 
 * through which we subscribe and unsubscribe the specific channel 
 *  we only need store and delete method for subscriptions
 * as we can see only store and delete will be used it this controller 
 * bc we can only subscribe and unsubscribe the channel 
 * nd we will define Resource Route only to get Store and Destroy method
 */
Route::get('/dashboard',[Admin::class,'index'])->middleware('admin')->name('dashboard');

/**
 * Adding midleware Auth to these routes which will make these routes unaccessable for 
 * unregisterd users
 */
Route::get('/search',[Search::class, 'search']);
Route::middleware(['auth'])->group(function () {


   /**
   * these Routes are for Video uploading to corresponding channels
   */
  Route::post('channels/{channel}/videos',[VideoController::class, 'store']); // Since this route is going to use ajax so dont use its name 
  Route::get('channels/{channel}/videos',[VideoController::class, 'index'])->name('channel.upload');

  /**
   * this route is for Dynamic Votes type which are comming from vue votes component in their methods 
   */
  Route::post('votes/{entity_id}/{type}',[VotesController::class, 'vote']);

  /**
   * we have registed a Vue js Component for Subscribe button used in Show.balde as a plain Javascript file
   * by the name of subscribe-button.js
   * which we will change it to Vue component for its re-useablity
   * to use power of both blade and vue template here
   */
  Route::resource('channels/{channel}/subscriptions', SubscriptionController::class)->only(['store','destroy']);

  /**
 * this route is for adding a Comment to specific Comment of User
 */
Route::post('comments/{video}',[CommentController::class,'store']);
});


/**
 * we have made Ques for data converting in the background.. which is also called Ques ..
 *  php artisan make:job Videos/ConvertForStreaming comand
 * the the env file we will change QUEUE_CONNECTION to databse insted of sync
 * to run the ques in the background to the database
 * we will make migrations for ques and faild ques table
 * wich php artisan queue:table and queue:failed-table
 * to save all the jobs in the table
 */