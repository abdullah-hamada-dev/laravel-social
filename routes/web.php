<?php

use Illuminate\Support\Facades\Route;

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
//
Route::get('/', function () {
    return view('welcome');
});
//
//// في حالة وضع جميع المسارات في ملف واحد نستخدم هذه الطريقة
//Route::get('/users', function () {
//    return view('users');
//});
//
//Route::get('/users/{id}', function ($id) {
//    return 'welcome to us '.$id;
//});

//Route::get('/test',function (){
//    return 'test page';
//});
//
//Route::get('/posts/{post}/comments/{comment}', function ($post,$comment) {
//    return 'you are looking for the comment number '.$comment.' for the post number '.$post;
//})->name('comment');
//
Route::get('/user/account/profile', function () {
    return view('profile');
})->name('profile');
////
//Route::get('/post/{title}/{id}', function () {
//    return 'the route is correct';
//})->where(['title'=>'[A-Za-z]+', 'id'=>'[0-9]+']);
//
//Route::get('/post/{title}', function () {
//    return 'the route is correct';
//})->where('title', '[A-za-z]+');
//
////في حال استخدام المسار مع المتحكم نستخدم هذه الطريقة مع التعديل في ملف المتحكم
//Route::get('/posts','PostController@index');
//this first method to show post by id
//Route::get('/posts/{post}','PostController@show');

//this is second method to show post by id
//في هذي الطريقة نضع اسم مختصر للمسار والذي هو posts.show ثم نستخدمه في صفحة المقال بنفس الاسم
//Route::get('/posts/{post}', 'PostController@show')->name('posts.show');


//من خلال هذا الأمر نقوم بإنشاء جميع المسارات بصورة تلقائية للمتحكم المذكور
// ويمكن استعراضها من خلال الشاشة الطرفية
Route::resource('/posts','PostController');

//من خلال استخدام هذا المتحكم نقوم بجلب المقالات بحسب العام والشهر
Route::get('/posts/{year}/{month}','PostController@archive');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
