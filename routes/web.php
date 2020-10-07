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
Auth::routes(['verify'=> true ]);

############################   Common files   ####################################
Route::get('/','CommonController@Index');
Route::get('/Home','CommonController@Index')->name('home');
Route::get('About','CommonController@About');
Route::get('Support','CommonController@Support');
Route::get('Contact','CommonController@Contact');
Route::get('/Login','CommonController@ViewLogin')->name('login');
Route::post('/Login','CommonController@login')->name('check_login');
Route::get('/logout','CommonController@logout')->name('logout');


#############################   End Common files   ###############################
#############################  Sign Up pages       ###############################

Route::group(['prefix' => 'SignUp'],function (){
    Route::get('Student','Student_Operations@Sign_Up_Student');
    Route::get('School','School_Operations@Sign_Up_School');
    Route::get('Parent','Parent_Operations@Sign_Up_Parent');
    Route::get('Teacher','Teacher_Operations@Sign_Up_Teacher');
});
#############################  End Sign Up pages   ###############################
#############################   Registration operations  ###############################

Route::post('/School_Registration', 'School_Operations@Register')->name('Create_School');
Route::post('/Student_Registration', 'Student_Operations@Register')->name('Create_Student');
Route::post('/Teacher_Registration', 'Teacher_Operations@Register')->name('Create_Teacher');
Route::post('/Parent_Registration', 'Parent_Operations@Register')->name('Create_Parent');

#############################  End Registration operations  ############################
#############################  All Mail Message   #######################################
Route::group(['middleware' => ['auth:student,school,teacher,parents']],function(){
    Route::get('/Send_Email_Verification','SendEmailToVerifyAccount@SendEmail')->name('SendEmail');
    Route::get('/Check_Email_Verification','SendEmailToVerifyAccount@Check_Verified_Email')->name('CheckEmail');
    Route::get('/Verify_Email','VerifyEmail@verifyEmail')->name('VerifyEmail');
});
#############################  End Mail Message   #######################################
#############################   Set subjects      #######################################
Route::group(['middleware' => ['checkVerified']],function() {
    Route::get('/Set_Subjects', 'School_Operations@View_Set_Subjects')->name('View_Set_Subjects')->middleware('auth:school');
    Route::post('/Set_Subjects', 'School_Operations@Set_Subjects')->name('Set_Subjects')->middleware('auth:school');
    Route::get('/Choose_Subject', 'Student_Operations@View_Choose_Subject')->name('View_Choose_Subject')->middleware('auth:student');
    Route::post('/Choose_Subject', 'Student_Operations@Choose_Subject')->name('Choose_Subject')->middleware('auth:student');
    Route::get('/Choose_Your_Subject', 'Teacher_Operations@View_Choose_Subject')->name('View_Choose_Your_Subject')->middleware('auth:teacher');
    Route::post('/Choose_Your_Subject', 'Teacher_Operations@Choose_Your_Subject')->name('Choose_Your_Subject')->middleware('auth:teacher');
});
#############################  End Set subjects  #######################################


############################   Common files after logged  ####################################
Route::group(['middleware' => ['checkVerified','auth:school,parents,student,teacher','checkSubject']],function(){
    Route::get('/home','CommonLoggedController@ViewHome')->name('home_logged');
    Route::get('/Profile/{type}/{id}','CommonLoggedController@ViewProfile')->name('profile');
    Route::get('/Search','CommonLoggedController@SearchResult')->name('SearchResult');
    Route::get('/Events','CommonLoggedController@ViewEvents')->name('ViewEvents');
    Route::get('/Events/DeleteEvent/{name}/{id}/{image}','School_Operations@DeleteEvent')->name('DeleteEvent');
    Route::post('/Events/SetEvent','School_Operations@SetEvent')->name('SetEvent');
    Route::post('/home/SetPost','CommonLoggedController@SetPost')->name('SetPost');
    Route::get('/home/DeletePost/{number}/{id}/{type}','CommonLoggedController@DeletePost')->name('DeletePost');


    /*^^^^^^^^^^^^^^^^^^ Edit ^^^^^^^^^^^^^^^^^^^^^^^^^^^^*/
    Route::group(['prefix' => 'Edit'],function(){
        Route::get('/','EditController@ViewEdit')->name('Edit');
        Route::post('/UploadImage','EditController@EditImage')->name('EditImage');
        Route::post('/ChangeName','EditController@EditName')->name('EditName');
        Route::post('/ChangePassword','EditController@ChangePassword')->name('ChangePassword');
        Route::post('/ChangeEmail','EditController@ChangeEmail')->name('ChangeEmail');
        Route::get('/ConfirmEmail','EditController@ConfirmEmail')->name('ConfirmEmail');
        Route::post('/ChangePhone','EditController@ChangePhone')->name('ChangePhone');
        Route::post('/BIO','EditController@BIO')->name('BIO');
        Route::post('/ChangeLocalAddress','EditController@ChangeLocalAddress')->name('ChangeLocalAddress');
        Route::post('/ChangeBirthDay','EditController@ChangeBirthDay')->name('ChangeBirthDay');
        Route::post('/addNewMaterial','EditController@addMaterial')->name('addMaterial');
        Route::post('/DeleteAccount','EditController@DeleteAccount')->name('DeleteAccount');
        Route::post('/AddChild','EditController@AddChild')->name('AddChild');
        Route::post('/ChangeGrade','EditController@ChangeGrade')->name('ChangeGrade');
        Route::post('/ChangeSubject','EditController@ChangeSubject')->name('ChangeSubject');
    });
    /*^^^^^^^^^^^^^^^^^^  End edit  ^^^^^^^^^^^^^^^*/
});


############################   End Common files after logged  ####################################








