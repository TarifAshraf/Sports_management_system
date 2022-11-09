<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

#------------------------ Player Routes -------------------------
Route::get('/player/dashboard', 'PlayerController@dashboard')->name('playerDashboard');
Route::post('/player/saveinfo', 'PlayerController@saveinfo')->name('playerSaveInfo');
Route::get('/player/agents', 'PlayerController@agentslist')->name('playerAgentsList');
Route::post('/player/agents/book', 'PlayerController@bookagent')->name('playerBookAgent');
Route::get('/player/requests', 'PlayerController@requestlist')->name('playerRequestList');
Route::post('/player/requests/accept', 'PlayerController@acceptrequest')->name('playerAcceptRequest');
Route::post('/player/requests/reject', 'PlayerController@rejectrequest')->name('playeRejectRequest');

#------------------------ Agent Routes -------------------------
Route::get('/agent/dashboard', 'AgentController@dashboard')->name('agentDashboard');
Route::post('/agent/saveinfo', 'AgentController@saveinfo')->name('agentSaveInfo');
Route::get('/agent/payrequests', 'AgentController@payrequests')->name('agentPayRequests');
Route::post('/agent/payrequests/accept', 'AgentController@acceptpayrequests')->name('agentAcceptPayRequests');
Route::post('/agent/payrequests/reject', 'AgentController@rejectpayrequests')->name('agentRejectPayRequests');
Route::get('/agent/approvalrequests', 'AgentController@approvalrequests')->name('agentApprovalRequests');
Route::post('/agent/approvalrequests/forward', 'AgentController@forwardapproval')->name('agentForwardRequests');
Route::post('/agent/approvalrequests/reject', 'AgentController@rejectapproval')->name('agentRejectRequests');
Route::post('/agent/acceptpayment', 'AgentController@acceptpayment')->name('agentAcceptPayment');

#------------------------ Club Routes -------------------------
Route::get('/club/dashboard', 'ClubController@dashboard')->name('clubDashboard');
Route::post('/club/saveinfo', 'ClubController@saveinfo')->name('clubSaveInfo');
Route::get('/club/players', 'ClubController@playerlist')->name('clubPlayerList');
Route::get('/club/players/current', 'ClubController@currentplayerlist')->name('clubCurrentPlayerList');
Route::post('/club/players/delete', 'ClubController@deleteplayer')->name('clubDeletePlayer');
Route::post('/club/players/buyrequest', 'ClubController@requestbuy')->name('clubRequestBuy');
Route::get('/club/addproduct', 'ClubController@addproduct')->name('clubAddProduct');
Route::post('/club/addproduct/save', 'ClubController@saveproduct')->name('clubSaveProduct');
Route::get('/club/addproduct/list', 'ClubController@productlist')->name('clubListProduct');
Route::get('/club/request/list', 'ClubController@requestlist')->name('clubRequestList');
Route::post('/club/request/confirmpayment', 'ClubController@confirmpayment')->name('clubConfirmpayment');
Route::get('/club/orders', 'ClubController@productorders')->name('clubProductOrders');
Route::post('/club/confirmdelivery', 'ClubController@confirmdelivery')->name('clubConfirmDelivery');
Route::post('/club/deleteproduct', 'ClubController@deleteproduct')->name('clubDeleteProduct');

#------------------------ Sponsor Routes -------------------------
Route::get('/sponsor/dashboard', 'SponsorController@dashboard')->name('sponsorDashboard');
Route::post('/sponsor/saveinfo', 'SponsorController@saveinfo')->name('sponsorSaveinfo');
Route::get('/sponsor/players', 'SponsorController@playerlist')->name('sponsorPlayerList');
Route::get('/sponsor/players/current', 'SponsorController@currentplayerlist')->name('sponsorCurrentPlayerList');
Route::post('/sponsor/players/buyrequest', 'SponsorController@requestbuy')->name('sponsorRequestBuy');
Route::get('/sponsor/request/list', 'SponsorController@requestlist')->name('sponsorRequestList');
Route::post('/sponsor/request/confirmpayment', 'SponsorController@confirmpayment')->name('sponsorConfirmPayment');

#------------------------ User Routes -------------------------
Route::get('/user/dashboard', 'UserController@dashboard')->name('userDashboard');
Route::post('/user/saveinfo', 'UserController@saveinfo')->name('userSaveInfo');
Route::get('/user/productlist', 'UserController@productlist')->name('userProductList');
Route::post('/user/makeorder', 'UserController@makeorder')->name('userMakeOrder');
Route::get('/user/pendingorder', 'UserController@pendingorder')->name('userPendingOrder');
