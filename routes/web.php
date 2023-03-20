<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Models\UserNarrative;
use App\Models\UserFormCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\Paginator;
use App\Models\ThinkTank;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/redis-test', function () {
    Cache::flush();
    dd('flush cache');

    $userFormCount = DB::table('user_form_count')->get();

    Cache::put('userformcount', $userFormCount, 5 * 60);

    $userFormCount = Cache::get('userformcount');

    if ($userFormCount === null) {
        // Cache miss, retrieve the data from the database
        $userFormCount = DB::table('user_form_count')->get();

        // Store the user form count data in Redis for 5 minutes
        Cache::put('userformcount', $userFormCount, 5 * 60);
    } else {
        dd('coming from cach',$userFormCount);
    }

//
//    $perPage = 1000;
//    $page = request()->get('page', 1);
//    $users = Cache::remember("user_narrative_page_{$page}", 1440, function () use ($perPage) {
//        return UserNarrative::paginate($perPage);
//    });
//
//    Paginator::currentPageResolver(function () use ($page) {
//        return $page;
//    });
//
//    foreach ($users as $user) {
//        echo $user->narrative;
//    }
    ini_set('memory_limit', '5G');
    $success = Cache::flush();
    $startTime = microtime(true);
    $users = Cache::remember('narrative_count_038sdf8sdf', 1440, function () {

        return  UserNarrative::take(1000000)->get();

    });
    $endTime = microtime(true);
    $timeTaken = round(($endTime - $startTime) * 1000, 2);
    dd($timeTaken);
//    foreach ($users as ){
//        echo $user->id;
//    }
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\Dashboard::class,'show_post'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/post',[\App\Http\Controllers\PostController::class,'index'])->name('post_index');
Route::post('/post',[\App\Http\Controllers\PostController::class,'create'])->name('post_create');
Route::get('/post/edit/{id}',[\App\Http\Controllers\PostController::class,'edit'])->name('post_edit');
Route::post('/post/edit/{id}',[\App\Http\Controllers\PostController::class,'update'])->name('post_update');
Route::get('/post/delete/{id}',[\App\Http\Controllers\PostController::class,'destroy'])->name('post_delete');

Route::get('/add-narrative',[\App\Http\Controllers\NarrativeController::class,'show_form'])->name('show_form');
Route::post('/add-narrative',[\App\Http\Controllers\NarrativeController::class,'get_narrative_data'])->name('get_narrative_data');
Route::get('/add-count',[\App\Http\Controllers\NarrativeController::class,'Add_count_to_narrative'])->name('add_count');
Route::get('/add-thinktank',[\App\Http\Controllers\ThinkTankController::class,'show_form'])->name('show_thinktank_form');
Route::post('/add-thinktank',[\App\Http\Controllers\ThinkTankController::class,'get_thinktank_data'])->name('get_thinktank_data');
Route::get('/add-thinktankcount',[\App\Http\Controllers\ThinkTankController::class,'Add_count_to_thinktank'])->name('add_count_thinktank');
Route::get('/add-digdeaper',[\App\Http\Controllers\DIgDeaperController::class,'show_form'])->name('show_digdeaper_form');
Route::post('/add-digdeaper',[\App\Http\Controllers\DIgDeaperController::class,'get_digdeaper_data'])->name('get_digdeaper_data');
Route::get('/add-digcount',[\App\Http\Controllers\DIgDeaperController::class,'Add_count_to_digdeaper'])->name('add_count_digdeaper');


Route::get('/run', function ( ) {
    $user = auth()->user();
    $membership_data = \App\Models\MembershipForUser::where('user_id',$user->id)->get();
    $membership_type = $membership_data[0]->membership_type;

    if( $membership_type == 'free' ) {

        $narrative_key = md5('narrative'.$user->id);
        $thinktank_key = md5('thinktank'.$user->id);
        $digdeaper_key = md5('digdeaper'.$user->id);
        $check_user = UserFormCount::where('user_id',$user->id)->count();
        if ( $check_user == 0 ) {

            $temp = ['user_id' => $user->id,'count'=>2,'key'=>'narrative','hash_key'=>$narrative_key];
            $data =  UserFormCount::create($temp);
            $temp = ['user_id' => $user->id,'count'=>3,'key'=>'thinktank','hash_key'=>$thinktank_key];
            $data =  UserFormCount::create($temp);
            $temp = ['user_id' => $user->id,'count'=>4,'key'=>'digdeaper','hash_key'=>$digdeaper_key];
            $data =  UserFormCount::create($temp);

        } else {
            $get_narrative_data = UserFormCount::where('hash_key',$narrative_key)->count();
            if($get_narrative_data == 0){
                $temp = ['user_id' => $user->id,'count'=>2,'key'=>'narrative','hash_key'=>$narrative_key];
                $data =  UserFormCount::create($temp);
            } else {

                $get_count = UserFormCount::where('hash_key',$narrative_key)->get();
                $count = $get_count[0]->count +1;
                $get_count[0]->count = $count;
                $get_count[0]->save();
            }
            $get_thinktank_data = UserFormCount::where('hash_key',$thinktank_key)->count();
            if($get_thinktank_data == 0){
                $temp = ['user_id' => $user->id,'count'=>3,'key'=>'thinktank','hash_key'=>$thinktank_key];
                $data =  UserFormCount::create($temp);
            } else {

                $get_count = UserFormCount::where('hash_key',$thinktank_key)->get();
                $count = $get_count[0]->count +1;
                $get_count[0]->count = $count;
                $get_count[0]->save();
            }
            $get_digdeaper_data = UserFormCount::where('hash_key',$digdeaper_key)->count();
            if($get_digdeaper_data == 0){
                $temp = ['user_id' => $user->id,'count'=>4,'key'=>'digdeaper','hash_key'=>$digdeaper_key];
                $data =  UserFormCount::create($temp);
            } else {

                $get_count = UserFormCount::where('hash_key',$digdeaper_key)->get();
                $count = $get_count[0]->count +1;
                $get_count[0]->count = $count;
                $get_count[0]->save();
            }
        }

    } else if ( $membership_type == 'yearly' ) {

        $narrative_key = md5('narrative'.$user->id);
        $thinktank_key = md5('thinktank'.$user->id);
        $digdeaper_key = md5('digdeaper'.$user->id);
        $check_user = UserFormCount::where('user_id',$user->id)->count();
        if ( $check_user == 0 ) {

            $temp = ['user_id' => $user->id,'count'=>3,'key'=>'narrative','hash_key'=>$narrative_key];
            $data =  UserFormCount::create($temp);
            $temp = ['user_id' => $user->id,'count'=>5,'key'=>'thinktank','hash_key'=>$thinktank_key];
            $data =  UserFormCount::create($temp);
            $temp = ['user_id' => $user->id,'count'=>5,'key'=>'digdeaper','hash_key'=>$digdeaper_key];
            $data =  UserFormCount::create($temp);

        } else {
            $get_narrative_data = UserFormCount::where('hash_key',$narrative_key)->count();
            if($get_narrative_data == 0){
                $temp = ['user_id' => $user->id,'count'=>3,'key'=>'narrative','hash_key'=>$narrative_key];
                $data =  UserFormCount::create($temp);
            } else {

                $get_count = UserFormCount::where('hash_key',$narrative_key)->get();
                $count = $get_count[0]->count +1;
                $get_count[0]->count = $count;
                $get_count[0]->save();
            }
            $get_thinktank_data = UserFormCount::where('hash_key',$thinktank_key)->count();
            if($get_thinktank_data == 0){
                $temp = ['user_id' => $user->id,'count'=>5,'key'=>'thinktank','hash_key'=>$thinktank_key];
                $data =  UserFormCount::create($temp);
            } else {

                $get_count = UserFormCount::where('hash_key',$thinktank_key)->get();
                $count = $get_count[0]->count +1;
                $get_count[0]->count = $count;
                $get_count[0]->save();
            }
            $get_digdeaper_data = UserFormCount::where('hash_key',$digdeaper_key)->count();
            if($get_digdeaper_data == 0){
                $temp = ['user_id' => $user->id,'count'=>7,'key'=>'digdeaper','hash_key'=>$digdeaper_key];
                $data =  UserFormCount::create($temp);
            } else {

                $get_count = UserFormCount::where('hash_key',$digdeaper_key)->get();
                $count = $get_count[0]->count +1;
                $get_count[0]->count = $count;
                $get_count[0]->save();
            }
        }
    }
    dd('function run successfully');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
