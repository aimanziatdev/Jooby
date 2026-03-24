<?php
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

// Listings
Route::get('/', [ListingController::class, 'index']);
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Auth
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
Route::post('/users', [UserController::class, 'store']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// Profiles
Route::get('/profile/edit', [ProfileController::class, 'edit'])->middleware('auth');
Route::put('/profile', [ProfileController::class, 'update'])->middleware('auth');
Route::get('/profile/{user}', [ProfileController::class, 'show']);
Route::post('/projects', [ProfileController::class, 'storeProject'])->middleware('auth');
Route::delete('/projects/{project}', [ProfileController::class, 'destroyProject'])->middleware('auth');

// Applications
Route::post('/listings/{listing}/apply', [ApplicationController::class, 'store'])->middleware('auth');
Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->middleware('auth');
Route::get('/listings/{listing}/applicants', [ApplicationController::class, 'listingApplicants'])->middleware('auth');
Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->middleware('auth');

// Offers
Route::post('/offer/{user}', [OfferController::class, 'store'])->middleware('auth');
Route::get('/my-offers', [OfferController::class, 'myOffers'])->middleware('auth');
Route::get('/sent-offers', [OfferController::class, 'sentOffers'])->middleware('auth');
Route::put('/offers/{offer}/status', [OfferController::class, 'updateStatus'])->middleware('auth');
