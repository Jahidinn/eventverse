<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserProfileController;
use GuzzleHttp\Promise\Create;

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


Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'autenticate']);

Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'storeRegister']);

# Subscribe
Route::post('/subscribe', [HomeController::class, 'subscribe']);

Route::post('/logout', [AuthController::class, 'logout']);

//email verification handle
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerify'])->middleware(['auth', 'signed'])->name('verification.verify');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/search', [HomeController::class, 'searchEvent']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/dashboard/myevent', [DashboardController::class, 'myEvent'])->middleware('auth');
Route::get('/dashboard/get-myevent', [DashboardController::class, 'getMyEvent'])->middleware('auth');
Route::get('/dashboard/manajemen-event', [DashboardController::class, 'manajemenEvent'])->middleware('auth');
Route::get('/dashboard/get-customform', [DashboardController::class, 'getCustomformParticipant'])->middleware('auth');
Route::post('/dashboard/delete-myevent', [DashboardController::class, 'deleteMyevent'])->middleware('auth');

Route::get('/dashboard/participant-data', [DashboardController::class, 'participant'])->middleware('auth');
Route::get('/dashboard/get-participant', [DashboardController::class, 'getParticipant'])->middleware('auth');
Route::get('/dashboard/participant-download-excel/{id}', [DashboardController::class, 'downloadExcel'])->middleware('auth');

Route::get('/dashboard/event-checkin', [DashboardController::class, 'eventCheckin'])->middleware('auth');
Route::get('/dashboard/get-participan-checkin', [DashboardController::class, 'getParticipantCheckin'])->middleware('auth');
Route::post('/dashboard/participant-checkin', [DashboardController::class, 'checkinProcess'])->middleware('auth');

Route::get('/dashboard/transaction-report', [DashboardController::class, 'transactionReport'])->middleware('auth');
Route::get('/dashboard/get-transaction-report', [DashboardController::class, 'getTransactionReport'])->middleware('auth');
Route::get('/dashboard/check-event-date', [DashboardController::class, 'checkEventDate'])->middleware('auth');
Route::post('/dashboard/withdraw-process', [DashboardController::class, 'withdraw'])->middleware('auth');
Route::get('/dashboard/withdraw-history', [DashboardController::class, 'withdrawHistory'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
	// Rute-rute yang akan terkena middleware auth
	// LIST ROUTE ......

	Route::middleware(['admin'])->group(function () {
		// Rute-rute yang akan terkena middleware administrator
		Route::get('/administrator', [AdminDashboardController::class, 'index']);
		Route::get('/dashboard/admin', [AdminDashboardController::class, 'index']);

		Route::get('/administrator/wd-request', [AdminDashboardController::class, 'withdrawRequest']);
		Route::get('/administrator/wd-request/get-data', [AdminDashboardController::class, 'withdrawRequestData']);
		Route::get('/administrator/wd-history/get-data', [AdminDashboardController::class, 'withdrawHistoryData']);
		Route::post('/administrator/wd-request/tolak', [AdminDashboardController::class, 'tolakWithdraw']);
		Route::post('/administrator/wd-request/accept', [AdminDashboardController::class, 'accepWithdraw']);

		Route::get('/administrator/transaction-check', [AdminDashboardController::class, 'adminTransactionCheck']);
		Route::get('/administrator/transaction-check/get-event', [AdminDashboardController::class, 'adminGetEvent']);
		Route::get('/administrator/transaction-check/get-transaction', [AdminDashboardController::class, 'adminGetTransaction']);
		Route::post('/administrator/transaction-check/check', [AdminDashboardController::class, 'checktTransaction']);

		Route::get('/administrator/article', [AdminDashboardController::class, 'article']);
		Route::get('/administrator/blog-category', [AdminDashboardController::class, 'articleCategories']);
		Route::get('/administrator/event-management/selected', [AdminDashboardController::class, 'selectedEventManagement']);
		Route::get('/administrator/event-management/promotion', [AdminDashboardController::class, 'promotionEventManagement']);

		# Management event
		Route::get('/administrator/event-management/get-selected', [AdminDashboardController::class, 'getSelectedEvent']);
		Route::get('/administrator/event-management/get-event', [AdminDashboardController::class, 'getDataEvent']);
		Route::post('/administrator/event-management/select-event', [AdminDashboardController::class, 'selectEvent']);
		Route::post('/administrator/event-management/unselect-event', [AdminDashboardController::class, 'unselectEvent']);

		Route::get('/administrator/event-management/get-promotion', [AdminDashboardController::class, 'getPromotionEvent']);
		Route::get('/administrator/event-management/get-event-for-promotion', [AdminDashboardController::class, 'getEventForPromotion']);
		Route::post('/administrator/event-management/promote-event', [AdminDashboardController::class, 'promoteEvent']);
		Route::post('/administrator/event-management/unpromote-event', [AdminDashboardController::class, 'unpromoteEvent']);

		# Artikel
		Route::post('/administrator/article/post', [ArticleController::class, 'create']);
		Route::get('/administrator/article/get', [ArticleController::class, 'getArticle']);
		Route::post('/administrator/article/edit', [ArticleController::class, 'editArticle']);
		Route::post('/administrator/article/delete', [ArticleController::class, 'deleteArticle']);

		# Kategori artikel/blog
		Route::get('/administrator/blog-category/get', [ArticleController::class, 'getCategory']);
		Route::post('/administrator/blog-category/submit', [ArticleController::class, 'submitCategory']);
		Route::post('/administrator/blog-category/edit', [ArticleController::class, 'editCategory']);
		Route::post('/administrator/blog-category/delete', [ArticleController::class, 'deleteCategory']);

		# Jenis artikel
		Route::get('/administrator/blog-type/get', [ArticleController::class, 'getType']);
		Route::post('/administrator/blog-type/submit', [ArticleController::class, 'submitType']);
		Route::post('/administrator/blog-type/edit', [ArticleController::class, 'editType']);
		Route::post('/administrator/blog-type/delete', [ArticleController::class, 'deleteType']);
	});
});

# Tanpa middleware
Route::get('/blog/pricing', [ArticleController::class, 'pricingInfo']);
Route::get('/blog/about-us', [ArticleController::class, 'aboutUs']);
Route::get('/blog/terms-and-condition', [ArticleController::class, 'terms']);
Route::get('/blog/privacy-policy', [ArticleController::class, 'privacyPolicy']);
Route::get('/blog/frequently-asked-questions', [ArticleController::class, 'faq']);
Route::get('/blog/faq', [ArticleController::class, 'faq']);
Route::get('/blog/creator-guide', [ArticleController::class, 'guide']);

Route::get('/blog', [ArticleController::class, 'blogMain']);
Route::get('/blog/search', [ArticleController::class, 'blogSearch']);
Route::get('/blog/{slug}', [ArticleController::class, 'viewArticle']);


Route::get('/dashboard/my-profile', [UserProfileController::class, 'index'])->middleware('auth');
Route::post('/dashboard/edit-profile-image', [UserProfileController::class, 'editImage'])->middleware('auth');
Route::post('/dashboard/edit-password', [UserProfileController::class, 'editPassword'])->middleware('auth');
Route::get('/dashboard/get-data-profile', [UserProfileController::class, 'getMyProfile'])->middleware('auth');
Route::post('/dashboard/edit-profile-process', [UserProfileController::class, 'editProfile'])->middleware('auth');

Route::get('/dashboard/organization', [OrganizationController::class, 'index'])->middleware('auth');
Route::post('/dashboard/add-organization', [OrganizationController::class, 'createOrg'])->middleware('auth');
Route::post('/dashboard/edit-organization', [OrganizationController::class, 'editOrg'])->middleware('auth');
Route::get('/dashboard/get-myorganization', [OrganizationController::class, 'getMyOrg'])->middleware('auth');
Route::get('/dashboard/detail-organization', [OrganizationController::class, 'detailOrg'])->middleware('auth');
Route::post('/dashboard/delete-organization', [OrganizationController::class, 'deleteOrg'])->middleware('auth');
Route::get('/dashboard/get-organization', [OrganizationController::class, 'getOrg'])->middleware('auth');

Route::post('/dashboard/follow-organization', [OrganizationController::class, 'followOrg'])->middleware('auth');
Route::post('/dashboard/unfollow-organization', [OrganizationController::class, 'unfollowOrg'])->middleware('auth');
Route::post('/dashboard/accept-follow', [OrganizationController::class, 'AcceptFollow'])->middleware('auth');
Route::post('/dashboard/remove-member', [OrganizationController::class, 'removeMember'])->middleware('auth');
Route::get('/dashboard/get-foll-organization', [OrganizationController::class, 'myFollowingOrg'])->middleware('auth');

Route::get('/dashboard/get-organization-member', [OrganizationController::class, 'getOrgMember'])->middleware('auth');
Route::get('/dashboard/get-organization-request', [OrganizationController::class, 'getOrgMemberReequest'])->middleware('auth');

Route::get('/organisasi/{organisasi}', [OrganizationController::class, 'detailOrganisasi']);
Route::get('/user/{username}', [UserProfileController::class, 'userPublicInfo']);

Route::get('/get-cities/{code}', [EventController::class, 'getCities']);
Route::get('/check-url', [EventController::class, 'cekUrl']);
Route::get('/get-my-org', [EventController::class, 'getMyOrg']);

Route::get('/get-ticket', [EventController::class, 'getTicket']);
Route::get('/get-formulir', [EventController::class, 'getFormulir']);

Route::post('/add-ticket', [EventController::class, 'addTicket']);
Route::post('/add-formulir', [EventController::class, 'addFormulir']);

Route::get('/check-ticket-participant', [EventController::class, 'checkTicketParticipant']);
Route::post('/edit-ticket', [EventController::class, 'editTicket']);
Route::post('/edit-formulir', [EventController::class, 'editFormulir']);

Route::post('/delete-ticket', [EventController::class, 'deleteTicket']);
Route::post('/delete-formulir', [EventController::class, 'deleteFormulir']);

Route::post('/event-edit-image', [EventController::class, 'editImage']);

Route::post('/event-edit', [EventController::class, 'editProcess'])->middleware('auth');
//detail event
Route::resource('/event', EventController::class, ['except' => ['show']])->middleware('auth');


//Checkout
Route::get('/event/checkout', [TransactionController::class, 'checkoutPreview']);
Route::get('/event/invoice/{id}', [TransactionController::class, 'invoice']);
Route::post('/event/checkout-proccess', [TransactionController::class, 'transaction']);
Route::post('/event/continue-transaction', [TransactionController::class, 'continueTransaction']);
Route::post('/event/transaction-delete', [TransactionController::class, 'deleteTransaction']);
Route::get('/event/send-email/{transaction_code}', [TransactionController::class, 'sendEmail']);
Route::get('/event/redirect-invoice/{id}', [TransactionController::class, 'redirectInvoice']);
Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);

Route::get('/{event}', [EventController::class, 'show']);
Route::get('/event/{event}', [EventController::class, 'show']);


//Resend email
Route::post('/email/verification-notification', [AuthController::class, 'resendEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//forgot password
Route::get('/auth/forgot-password', [AuthController::class, 'forgotPasswordView'])->middleware('guest')->name('password.request');
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
Route::get('/auth/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->middleware('guest')->name('password.reset');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
