<?php

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

Route::get('/', 'Website\WebsiteController@welcome')->name('welcome');

Route::get('/questions', 'Website\WebsiteController@questions')->name('questions');

Route::get('/search', 'Search\SearchController@questions')->name('search.questions');

Route::get('/w/{page}', function($page) {
	if ($page == 'faq') {
		$page = strtoupper($page);
	} else {
		$page = ucwords(str_ireplace('-', ' ', $page));
	}

	return view('page', [
		'page' => $page,
	]);
})->name('page');

Auth::routes();


// Auth middleware
Route::group(['middleware' => 'auth'], function() {
	
	Route::group(['middleware' => 'role:admin'], function() {

		// Admin panel
		Route::group(['prefix' => 'admin'], function() {

			// Index
			Route::get('/dashboard', 'Admin\AdminController@index')
				->name('admin.dashboard');

			// Reports
			Route::group(['prefix' => 'reports'], function() {

				// Question
				Route::get('/question/{question}', 'Admin\ReportController@question')
					->name('admin.reports.question');

				// Multiple Questions
				Route::get('/questions', 'Admin\ReportController@questions')
					->name('admin.reports.questions');

				// Answer
				Route::get('/answer/{answer}', 'Admin\ReportController@answer')
					->name('admin.reports.answer');

				// Multiple Answers
				Route::get('/answers', 'Admin\ReportController@answers')
					->name('admin.reports.answers');

				// Moderate question
				Route::post('/moderate/question', 'Admin\ReportController@moderateQuestion')
					->name('admin.moderate.question');

				// Moderate answer
				Route::post('/moderate/answer', 'Admin\ReportController@moderateAnswer')
					->name('admin.moderate.answer');

			});

		});

	});

	// User role
	Route::group(['middleware' => 'role:user'], function() {

		// Home page
		Route::get('/home', 'Website\WebsiteController@home')->name('home');
		
		// Follow
		Route::group(['prefix' => 'follow'], function() {

			// Question
			Route::post('/question', 'Follow\FollowController@question')
				->name('follow.question');

			// Topic
			Route::post('/topic', 'Follow\FollowController@topic')
				->name('follow.topic');

			// User
			Route::post('/user', 'Follow\FollowController@user')
				->name('follow.user');

		});

		// Report
		Route::group(['prefix' => 'reports'], function() {

			// Question
			Route::post('/question', 'Report\ReportController@question')
				->name('reports.question');

			// Topic
			Route::post('/topic', 'Report\ReportController@topic')
				->name('reports.topic');

			// Report an answer
			Route::post('/answer', 'Report\ReportController@answer')
				->name('reports.answer');

		});

		// Questions
		Route::group(['prefix' => 'questions'], function() {

			// Add a question
			Route::get('/add', 'Question\QuestionController@add')
				->name('questions.add');

			// Store a question
			Route::post('/store', 'Question\QuestionController@store')
				->name('questions.store');

			// Edit a question
			Route::get('/edit/{question}', 'Question\QuestionController@edit')
				->name('questions.edit');

			// Update a question
			Route::post('/update', 'Question\QuestionController@update')
				->name('questions.update');

			// Show a question
			Route::get('/show/{question}/{answer?}', 'Question\QuestionController@show')
				->name('questions.show');

		});

		// Answers
		Route::group(['prefix' => 'answers'], function() {

			// Add a answer
			Route::get('/add', 'Answer\AnswerController@add')
				->name('answers.add');

			// Store a answer
			Route::post('/store', 'Answer\AnswerController@store')
				->name('answers.store');

			// Edit a answer
			Route::get('/edit/{answer}', 'Answer\AnswerController@edit')
				->name('answers.edit');

			// Update a answer
			Route::post('/update', 'Answer\AnswerController@update')
				->name('answers.update');

			// Pick a best answer
			Route::post('/best', 'Answer\AnswerController@best')
				->name('answers.best');

			// Upvote an answer
			Route::post('/upvote', 'Answer\AnswerController@upvote')
				->name('answers.upvote');

			// Downvote an answer
			Route::post('/downvote', 'Answer\AnswerController@downvote')
				->name('answers.downvote');

			// Log a view
			Route::post('/view', 'Answer\AnswerController@view')
				->name('answers.view');

		});

		// Topics
		Route::group(['prefix' => 'topics'], function() {

			// Add a topic
			Route::get('/add', 'Topic\TopicController@add')
				->name('topics.add');

			// Add a question to the topic
			Route::get('/{topic}/question', 'Topic\TopicController@question')
				->name('topics.question');

			// Add a question to the topic
			Route::post('/question/store', 'Topic\TopicController@storeQuestion')
				->name('topics.storeQuestion');

			// Store a topic
			Route::post('/store', 'Topic\TopicController@store')
				->name('topics.store');

			// Edit a topic
			Route::get('/edit', 'Topic\TopicController@edit')
				->name('topics.edit');

			// Update a topic
			Route::post('/update', 'Topic\TopicController@update')
				->name('topics.update');

			// Show a topic
			Route::get('/show/{topic}', 'Topic\TopicController@show')
				->name('topics.show');

		});

		// User
		Route::group(['prefix' => 'users'], function() {

			// Show
			Route::get('/show/{user}', 'User\UserController@show')
				->name('users.show');

			// Edit
			Route::get('/edit', 'User\UserController@edit')
				->name('users.edit');

			// Update
			Route::post('/update', 'User\UserController@update')
				->name('users.update');

			// Avatar
			Route::get('/avatar', 'User\AvatarController@avatar')
				->name('users.avatar');

			// Store avatar
			Route::post('/avatar/store', 'User\AvatarController@store')
				->name('users.avatar.store');

			Route::get('/get/avatar/{filename}', 'User\AvatarController@image')
				->name('users.avatar.get');

		});
		
	});


});

