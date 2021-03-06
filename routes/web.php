<?php

Route::get('/', 'PagesController@home');
Route::get('/articles/{slug}', 'PagesController@article');
Route::get('/articles/{slug}/plain-text', 'ArticleTextController@show')->middleware('auth.basic');

Route::get('lists/unsubscribe/{slug}', 'GiftListSubscriptionController@delete');
Route::get('lists/{slug}', 'GiftListsController@show');


Route::get('recommendations/signup', 'RecommendationRequestsController@show');
Route::post('recommendations/request', 'RecommendationRequestsController@store');
Route::get('recommendations/thanks', 'RecommendationRequestsController@thanks');


Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('playground', 'PagesController@playground')->middleware('auth');

// Registration Routes...
//$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index');

Route::get('guides', 'PagesController@guides');
Route::get('gifts', 'PagesController@gifts');

Route::get('services/products', 'ProductServiceController@index');

Route::get('tags', 'Admin\TagsController@index');




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

    Route::post('products/{product}', 'ProductsController@update');
    Route::put('products/{product}/tags', 'ProductTagsController@store');

    Route::get('products/{product}/swap', 'ProductSwapController@show');
    
    Route::delete('orphan-products', 'OrphanProductsController@delete');

    Route::get('featured-products', 'FeaturedProductsController@index');
    Route::post('featured-products', 'FeaturedProductsController@store');
    Route::delete('featured-products/{product}', 'FeaturedProductsController@delete');



    Route::get('tags/issues', 'TaggingIssuesController@show');
    Route::get('tags/manager', 'TagsManagerController@show');


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
    Route::post('recommendations/{request}/giftlists', 'GiftListsController@store');
    Route::get('giftlists', 'GiftListsController@index');
    Route::get('giftlists/{list}', 'GiftListsController@show');
    Route::post('giftlists/{list}', 'GiftListsController@update');


    Route::get('services/giftlists/{list}/suggestions', 'GiftListSuggestionsController@index');
    Route::post('giftlists/{list}/suggestions/{suggestion}', 'GiftListSuggestionsController@store');
    Route::delete('giftlists/{list}/suggestions/{suggestion}', 'GiftListSuggestionsController@delete');

    Route::get('giftlists/{list}/articles', 'GiftListArticlesController@index');
    Route::post('giftlists/{list}/articles/{article}', 'GiftListArticlesController@store');
    Route::delete('giftlists/{list}/articles/{article}', 'GiftListArticlesController@delete');

    Route::post('top-picks', 'TopPicksController@store');
    Route::delete('top-picks/{pick}', 'TopPicksController@delete');

    Route::post('giftlists/{list}/approved', 'ApprovedGiftListsController@store');

    Route::post('services/suggestions/search/tags', 'SuggestionsTagSearchController@index');
    Route::post('services/suggestions/search/name', 'SuggestionsNameSearchController@index');

    Route::post('services/products/lookup', 'ProductLookupController@show');
    Route::get('services/products/similar/{itemid}', 'SimilarProductsController@index');

    Route::get('services/articles/{article}/products', 'ArticleMentionedProductsController@index');

    Route::get('services/cards/search', 'CardsSearchController@index');
    Route::get('services/cards/index', 'CardsIndexController@index');

    Route::get('services/analytics/visitors', 'AnalyticsController@visitors');

    Route::post('services/tags/deleted', 'TagsController@delete');

    Route::get('services/giftlists/{list}/picks', 'GiftListPicksServiceController@index');

    Route::get('services/featured-products', 'FeaturedProductsServiceController@index');

});
