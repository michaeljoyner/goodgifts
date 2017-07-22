<?php

Route::get('/', 'PagesController@home');
Route::get('/articles/{slug}', 'PagesController@article');
Route::get('/articles/{slug}/plain-text', 'ArticleTextController@show')->middleware('auth.basic');



Route::get('recommendations/signup', 'RecommendationRequestsController@show')->middleware('auth');
Route::post('recommendations/request', 'RecommendationRequestsController@store');
Route::get('recommendations/thanks', 'RecommendationRequestsController@thanks');


Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index');




Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'DashboardController@show');

    Route::delete('products/{product}', 'ProductsController@delete');

    Route::get('products/{product}/similar', 'SimilarProductsController@show');

    Route::get('articles', 'ArticlesController@index');
    Route::get('articles/{article}', 'ArticlesController@show');
    Route::get('articles/{article}/edit', 'ArticlesController@edit');
    Route::get('articles/{article}/preview', 'ArticlesPreviewController@show');
    Route::get('articles/{article}/body/edit', 'ArticleBodyController@edit');
    Route::patch('articles/{article}/body', 'ArticleBodyController@update');
    Route::post('articles', 'ArticlesController@store');
    Route::post('articles/{article}', 'ArticlesController@update');

    Route::post('articles/{article}/publish', 'ArticlePublishingController@update');
    Route::post('articles/{article}/images', 'ArticleImagesController@store');
    Route::post('articles/{article}/titleimage', 'ArticleTitleImageController@update');
    Route::get('articles/{article}/poster', 'ArticlePosterController@show');

    Route::get('articles/{article}/products/app', 'ArticlesProductsController@show');
    Route::get('articles/{article}/products', 'ArticlesProductsController@index');
    Route::post('articles/{article}/products', 'ArticlesProductsController@store');
    Route::delete('articles/{article}/products/{product}', 'ArticlesProductsController@remove');

    Route::get('articles/{article}/interests', 'ArticleInterestsController@index');
    Route::put('articles/{article}/interests', 'ArticleInterestsController@store');

    Route::post('articles/{article}/products/{product}/reasons', 'ProductReasonsController@update');

    Route::get('interests', 'InterestsController@index');

    Route::put('products/{product}/tags', 'ProductTagsController@store');

    Route::get('tags', 'TagsController@index');

    Route::post('issues/batchupdate/{issue}/resolve', 'BatchUpdateIssueResolvingController@handle');
    Route::post('issues/incompleteupdate/{issue}/resolve', 'IncompleteUpdateIssueResolvingController@handle');

    Route::get('issues', 'IssuesController@index');
    Route::get('issues/{issue}', 'IssuesController@show');
    Route::delete('issues/{issue}', 'IssuesController@delete');

    Route::get('cards/search', 'CardsSearchController@show');
    Route::get('cards', 'CardsController@index');
    Route::post('cards', 'CardsController@store');
    Route::delete('cards/{card}', 'CardsController@delete');

    Route::get('recommendations/requests', 'RecommendationRequestsController@index');

    Route::post('services/products/lookup', 'ProductLookupController@show');
    Route::get('services/products/similar/{itemid}', 'SimilarProductsController@index');

    Route::get('services/articles/{article}/products', 'ArticleMentionedProductsController@index');

    Route::get('services/cards/search', 'CardsSearchController@index');
    Route::get('services/cards/index', 'CardsIndexController@index');

    Route::get('services/analytics/visitors', 'AnalyticsController@visitors');

});
