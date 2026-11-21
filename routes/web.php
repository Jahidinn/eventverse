<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EventStudioController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FileController;
use App\Models\Event;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;

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

# LOMBAESAI
// Route::get('/essay-announcement-2024', [ScoreController::class, 'index']);
// Route::get('/essay-announcement-2024/score', [ScoreController::class, 'score']);
// Route::get('/essay-announcement-2024/check-score', [ScoreController::class, 'getData']);

# DOWNLOAD SERTIFIKAT
// Route::get('/essay-announcement-2024/certificate', [ScoreController::class, 'certificate']);
// Route::get('/essay-announcement-2024/check-file', [ScoreController::class, 'checkFile']);
// Route::get('/essay-announcement-2024/download', [ScoreController::class, 'downloadFile']);
// Route::redirect('/certificate-change-request', 'https://docs.google.com/spreadsheets/d/1B2IsxtTm92lD42ukBoQCzwUurHfN7ILrmsJ456csaOg/edit?usp=sharing', 301);

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'autenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'storeRegister']);

# Subscribe
Route::post('/subscribe', [HomeController::class, 'subscribe']);
# Contact us
Route::post('/send-message', [HomeController::class, 'sendMessage']);
Route::post('/logout', [AuthController::class, 'logout']);

//email verification handle
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerify'])->middleware(['auth', 'signed'])->name('verification.verify');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/search', [HomeController::class, 'searchEvent']);
// Route::redirect('/ec-esai2024', '/ec-esai24');
// Route::redirect('/EC-ESAI2024', '/ec-esai24');

Route::middleware(['auth'])->group(function () {

	Route::get('/url-check', [EventStudioController::class, 'urlCheck']);
	Route::prefix('event-studio')->name('event-studio.')->middleware(['event-studio.owner', 'permission:event-studio.access'])->group(function () {
		Route::post('/store', [EventStudioController::class, 'store'])->name('store');
		Route::post('/{event_id}/autosave', [EventStudioController::class, 'autosave'])->name('autosave');

		# Banner
		Route::post('/{event_id}/banner', [EventStudioController::class, 'uploadBanner'])->name('banner');
		Route::delete('/{event_id}/banner', [EventStudioController::class, 'deleteBanner'])->name('banner.delete');

		# Gallery
		Route::post('/{event_id}/gallery', [EventStudioController::class, 'uploadGallery'])->name('gallery');
		Route::delete('/{event_id}/gallery/{image}', [EventStudioController::class, 'deleteGallery'])->name('gallery.delete');
		Route::post('/{event_id}/gallery/sort', [EventStudioController::class, 'sortGallery'])->name('gallery.sort');

		# Ticket
    	Route::post('/{event_id}/ticket', [EventStudioController::class, 'storeTicket'])->name('ticket.store');
		Route::put('/{event_id}/ticket/{ticket_id}', [EventStudioController::class, 'updateTicket'])->name('ticket.update');
		Route::delete('/{event_id}/ticket/{ticket_id}', [EventStudioController::class, 'deleteTicket'])->name('ticket.delete');

		Route::post('/{event_id}/form', [EventStudioController::class, 'storeForm'])->name('form.store');
		Route::put('/{event_id}/form/{form_id}', [EventStudioController::class, 'updateForm'])->name('form.update');
		Route::delete('/{event_id}/form/{form_id}', [EventStudioController::class, 'deleteForm'])->name('form.delete');

		// Facility
		Route::post('/{event_id}/facility', [EventStudioController::class, 'storeFacility'])->name('facility.store');
		Route::put('/{event_id}/facility/{facility_id}', [EventStudioController::class, 'updateFacility'])->name('facility.update');
		Route::delete('/{event_id}/facility/{facility_id}', [EventStudioController::class, 'deleteFacility'])->name('facility.delete');

		// Line-up
		Route::post('/{event_id}/line-up', [EventStudioController::class, 'storeLineUp'])->name('line-up.store');
		Route::put('/{event_id}/line-up/{lineup_id}', [EventStudioController::class, 'updateLineUp'])->name('line-up.update');
		Route::delete('/{event_id}/line-up/{lineup_id}', [EventStudioController::class, 'deleteLineUp'])->name('line-up.delete');

		Route::get('/{event_id}/basic', [EventStudioController::class, 'basic'])->name('basic');
		Route::get('/{event_id}/detail', [EventStudioController::class, 'detail'])->name('detail');
		Route::get('/{event_id}/facilities', [EventStudioController::class, 'facilites'])->name('facilities');
		Route::get('/{event_id}/line-up', [EventStudioController::class, 'lineUp'])->name('line-up');
		Route::get('/{event_id}/ticket', [EventStudioController::class, 'ticket'])->name('ticket');
		Route::get('/{event_id}/form', [EventStudioController::class, 'form'])->name('form');
		Route::get('/{event_id}/preview', [EventStudioController::class, 'preview'])->name('preview');
		Route::post('/{event}/publish', [EventStudioController::class, 'publish'])->name('publish');
	});

	Route::prefix('locations')->name('locations.')->group(function () {
		Route::get('/provinces', [LocationController::class, 'provinces'])->name('provinces');
		Route::get('/cities/{province}', [LocationController::class, 'cities'])->name('cities');

	});

	


	// Rute-rute yang akan terkena middleware auth
	// LIST ROUTE ......

	# ROUTE LAMA
	# event
	Route::post('/event-edit-image', [EventController::class, 'editImage']);
	Route::post('/event-edit', [EventController::class, 'editProcess']);
	Route::resource('/event', EventController::class, ['except' => ['show']]);

	Route::get('/get-cities/{code}', [EventController::class, 'getCities']);
	Route::get('/check-url', [EventController::class, 'cekUrl']);
	Route::get('/get-my-org', [EventController::class, 'getMyOrg']);

	Route::get('/get-ticket', [EventController::class, 'getTicket']);
	Route::get('/get-formulir', [EventController::class, 'getFormulir']);

	Route::post('/add-ticket', [EventController::class, 'addTicket']);
	Route::post('/add-formulir', [EventController::class, 'addFormulir']);

	//Route::get('/check-ticket-participant', [EventController::class, 'checkTicketParticipant']);
	Route::post('/edit-ticket', [EventController::class, 'editTicket']);
	Route::post('/edit-formulir', [EventController::class, 'editFormulir']);

	Route::post('/delete-ticket', [EventController::class, 'deleteTicket']);
	Route::post('/delete-formulir', [EventController::class, 'deleteFormulir']);


	# Dashboard
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	Route::get('/dashboard/myevent', [DashboardController::class, 'myEvent'])->middleware('permission:my-event.view');
	Route::get('/dashboard/get-myevent', [DashboardController::class, 'getMyEvent']);
	Route::get('/dashboard/manajemen-event', [DashboardController::class, 'manajemenEvent'])->middleware(['role:organizer', 'permission:event-studio.access']);
	Route::get('/dashboard/get-customform', [DashboardController::class, 'getCustomformParticipant'])->middleware('role:organizer');
	Route::post('/dashboard/delete-myevent', [DashboardController::class, 'deleteMyevent']);

	# Detail mytransaction
	Route::get('/dashboard/get-detail-transaction', [DashboardController::class, 'detailTransaction']);
	Route::post('/dashboard/edit-form-transaction', [DashboardController::class, 'editFormTransaction']);

	Route::get('/dashboard/participant-data', [DashboardController::class, 'participant'])->middleware(['role:organizer', 'permission:participants.manage']);
	Route::get('/dashboard/participant-data/{event_id}', [DashboardController::class, 'participantEvent'])->middleware(['role:organizer', 'permission:participants.manage']);
	Route::get('/dashboard/get-participant', [DashboardController::class, 'getParticipant'])->middleware(['role:organizer', 'permission:participants.manage']);
	Route::get('/dashboard/participant-detail', [DashboardController::class, 'participantDetail'])->middleware(['role:organizer', 'permission:participants.manage']);
	Route::get('/dashboard/participant-download-excel/{id}', [DashboardController::class, 'downloadExcel'])->middleware(['role:organizer', 'permission:participants.manage']);

	Route::get('/dashboard/event-checkin', [DashboardController::class, 'eventCheckin'])->middleware(['role:organizer', 'permission:checkin.manage']);
	Route::get('/dashboard/event-checkin/{event_id}', [DashboardController::class, 'eventCheckinEvent'])->middleware(['role:organizer', 'permission:checkin.manage']);
	Route::get('/dashboard/get-participan-checkin', [DashboardController::class, 'getParticipantCheckin'])->middleware(['role:organizer', 'permission:checkin.manage']);
	Route::post('/dashboard/participant-checkin', [DashboardController::class, 'checkinProcess'])->middleware(['role:organizer', 'permission:checkin.manage']);

	Route::get('/dashboard/transaction-report', [DashboardController::class, 'transactionReport'])->middleware(['role:organizer', 'permission:finance.view']);
	Route::get('/dashboard/get-transaction-report', [DashboardController::class, 'getTransactionReport'])->middleware(['role:organizer', 'permission:finance.view']);
	Route::get('/dashboard/check-event-date', [DashboardController::class, 'checkEventDate'])->middleware(['role:organizer', 'permission:finance.view']);
	Route::post('/dashboard/withdraw-process', [DashboardController::class, 'withdraw'])->middleware(['role:organizer', 'permission:finance.view']);
	Route::get('/dashboard/withdraw-history', [DashboardController::class, 'withdrawHistory'])->middleware(['role:organizer', 'permission:finance.view']);

	Route::get('/dashboard/article', [DashboardController::class, 'article'])->middleware('permission:articles.create');
	Route::get('/dashboard/article/get', [DashboardController::class, 'getArticle'])->middleware('permission:articles.create');

	Route::get('/dashboard/my-profile', [UserProfileController::class, 'index'])->middleware('permission:profile.manage');
	Route::post('/dashboard/edit-profile-image', [UserProfileController::class, 'editImage'])->middleware('permission:profile.manage');
	Route::post('/dashboard/edit-password', [UserProfileController::class, 'editPassword'])->middleware('permission:profile.manage');
	Route::get('/dashboard/get-data-profile', [UserProfileController::class, 'getMyProfile'])->middleware('permission:profile.manage');
	Route::post('/dashboard/edit-profile-process', [UserProfileController::class, 'editProfile'])->middleware('permission:profile.manage');
	Route::post('/dashboard/account-mode', [UserProfileController::class, 'updateMode'])->middleware('permission:profile.manage');

	Route::get('/dashboard/organization', [OrganizationController::class, 'index'])->middleware('permission:organization.manage');
	Route::post('/dashboard/add-organization', [OrganizationController::class, 'createOrg'])->middleware('permission:organization.manage');
	Route::post('/dashboard/edit-organization', [OrganizationController::class, 'editOrg'])->middleware('permission:organization.manage');
	Route::get('/dashboard/get-myorganization', [OrganizationController::class, 'getMyOrg'])->middleware('permission:organization.manage');
	Route::get('/dashboard/detail-organization', [OrganizationController::class, 'detailOrg'])->middleware('permission:organization.manage');
	Route::post('/dashboard/delete-organization', [OrganizationController::class, 'deleteOrg'])->middleware('permission:organization.manage');
	Route::get('/dashboard/get-organization', [OrganizationController::class, 'getOrg'])->middleware('permission:organization.manage');

	Route::post('/dashboard/follow-organization', [OrganizationController::class, 'followOrg'])->middleware('permission:organization.manage');
	Route::post('/dashboard/unfollow-organization', [OrganizationController::class, 'unfollowOrg'])->middleware('permission:organization.manage');
	Route::post('/dashboard/accept-follow', [OrganizationController::class, 'AcceptFollow'])->middleware('permission:organization.manage');
	Route::post('/dashboard/remove-member', [OrganizationController::class, 'removeMember'])->middleware('permission:organization.manage');
	Route::get('/dashboard/get-foll-organization', [OrganizationController::class, 'myFollowingOrg'])->middleware('permission:organization.manage');

	Route::get('/dashboard/get-organization-member', [OrganizationController::class, 'getOrgMember'])->middleware('permission:organization.manage');
	Route::get('/dashboard/get-organization-request', [OrganizationController::class, 'getOrgMemberReequest'])->middleware('permission:organization.manage');

	# Artikel
	Route::post('/administrator/article/post', [ArticleController::class, 'create'])->middleware('permission:articles.create');
	Route::get('/administrator/article/get', [ArticleController::class, 'getArticle'])->middleware(['admin', 'permission:articles.manage']);
	Route::post('/administrator/article/edit', [ArticleController::class, 'editArticle']);
	Route::post('/administrator/article/delete', [ArticleController::class, 'deleteArticle']);

	Route::middleware(['admin'])->group(function () {
		// Rute-rute yang akan terkena middleware administrator
		Route::get('/administrator', [AdminDashboardController::class, 'index'])->middleware('permission:platform.view');
		Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->middleware('permission:platform.view');

		Route::get('/administrator/payments', [AdminDashboardController::class, 'payments'])->middleware('permission:payments.view');
		Route::get('/administrator/users', [AdminUserController::class, 'index'])->middleware('permission:users.manage')->name('administrator.users');
		Route::get('/administrator/users/{user}/edit', [AdminUserController::class, 'edit'])->middleware('permission:users.manage')->name('administrator.users.edit');
		Route::put('/administrator/users/{user}', [AdminUserController::class, 'update'])->middleware('permission:users.manage')->name('administrator.users.update');
		Route::get('/administrator/roles', [AdminUserController::class, 'roles'])->middleware('permission:roles.manage')->name('administrator.roles');
		Route::get('/administrator/audit-logs', [AdminUserController::class, 'auditLogs'])->middleware('permission:audit.view')->name('administrator.audit-logs');
		Route::get('/administrator/roles/{role}/permissions', [AdminUserController::class, 'editPermissions'])->middleware('permission:roles.manage')->name('administrator.roles.permissions');
		Route::put('/administrator/roles/{role}/permissions', [AdminUserController::class, 'updatePermissions'])->middleware('permission:roles.manage')->name('administrator.roles.permissions.update');

		Route::get('/administrator/wd-request', [AdminDashboardController::class, 'withdrawRequest'])->middleware('permission:withdrawals.manage');
		Route::get('/administrator/wd-request/get-data', [AdminDashboardController::class, 'withdrawRequestData'])->middleware('permission:withdrawals.manage');
		Route::get('/administrator/wd-history/get-data', [AdminDashboardController::class, 'withdrawHistoryData'])->middleware('permission:withdrawals.manage');
		Route::post('/administrator/wd-request/tolak', [AdminDashboardController::class, 'tolakWithdraw'])->middleware('permission:withdrawals.manage');
		Route::post('/administrator/wd-request/accept', [AdminDashboardController::class, 'accepWithdraw'])->middleware('permission:withdrawals.manage');

		Route::get('/administrator/transaction-check', [AdminDashboardController::class, 'adminTransactionCheck'])->middleware('permission:payments.view');
		Route::get('/administrator/transaction-check/get-event', [AdminDashboardController::class, 'adminGetEvent'])->middleware('permission:payments.view');
		Route::get('/administrator/transaction-check/get-transaction', [AdminDashboardController::class, 'adminGetTransaction'])->middleware('permission:payments.view');
		Route::post('/administrator/transaction-check/check', [AdminDashboardController::class, 'checktTransaction'])->middleware('permission:payments.view');

		Route::get('/administrator/article', [AdminDashboardController::class, 'article'])->middleware('permission:articles.manage');
		Route::get('/administrator/blog-category', [AdminDashboardController::class, 'articleCategories'])->middleware('permission:articles.manage');
		Route::get('/administrator/event-management/selected', [AdminDashboardController::class, 'selectedEventManagement'])->middleware('permission:events.manage');
		Route::get('/administrator/event-management/promotion', [AdminDashboardController::class, 'promotionEventManagement'])->middleware('permission:events.manage');

		# Management event
		Route::get('/administrator/event-management/get-selected', [AdminDashboardController::class, 'getSelectedEvent'])->middleware('permission:events.manage');
		Route::get('/administrator/event-management/get-event', [AdminDashboardController::class, 'getDataEvent'])->middleware('permission:events.manage');
		Route::post('/administrator/event-management/select-event', [AdminDashboardController::class, 'selectEvent'])->middleware('permission:events.manage');
		Route::post('/administrator/event-management/unselect-event', [AdminDashboardController::class, 'unselectEvent'])->middleware('permission:events.manage');

		Route::get('/administrator/event-management/get-promotion', [AdminDashboardController::class, 'getPromotionEvent'])->middleware('permission:events.manage');
		Route::get('/administrator/event-management/get-event-for-promotion', [AdminDashboardController::class, 'getEventForPromotion'])->middleware('permission:events.manage');
		Route::post('/administrator/event-management/promote-event', [AdminDashboardController::class, 'promoteEvent'])->middleware('permission:events.manage');
		Route::post('/administrator/event-management/unpromote-event', [AdminDashboardController::class, 'unpromoteEvent'])->middleware('permission:events.manage');

		# Kategori artikel/blog
		Route::get('/administrator/blog-category/get', [ArticleController::class, 'getCategory'])->middleware('permission:articles.manage');
		Route::post('/administrator/blog-category/submit', [ArticleController::class, 'submitCategory'])->middleware('permission:articles.manage');
		Route::post('/administrator/blog-category/edit', [ArticleController::class, 'editCategory'])->middleware('permission:articles.manage');
		Route::post('/administrator/blog-category/delete', [ArticleController::class, 'deleteCategory'])->middleware('permission:articles.manage');

		# Jenis artikel
		Route::get('/administrator/blog-type/get', [ArticleController::class, 'getType'])->middleware('permission:articles.manage');
		Route::post('/administrator/blog-type/submit', [ArticleController::class, 'submitType'])->middleware('permission:articles.manage');
		Route::post('/administrator/blog-type/edit', [ArticleController::class, 'editType'])->middleware('permission:articles.manage');
		Route::post('/administrator/blog-type/delete', [ArticleController::class, 'deleteType'])->middleware('permission:articles.manage');
	});
});

// Route::get('/check-url', function () {
//     return config('app.url');
// });

# Tanpa middleware

Route::get('/pricing', [ArticleController::class, 'pricingInfo']);
Route::get('/about-us', [ArticleController::class, 'aboutUs']);
Route::get('/contact-us', [ArticleController::class, 'contactUs']);
Route::get('/terms-and-condition', [ArticleController::class, 'terms']);
Route::get('/privacy-policy', [ArticleController::class, 'privacyPolicy']);
Route::get('/frequently-asked-questions', [ArticleController::class, 'faq']);
Route::get('/faq', [ArticleController::class, 'faq']);
Route::get('/creator-guide', [ArticleController::class, 'guide']);

Route::get('/blog/pricing', [ArticleController::class, 'pricingInfo']);
Route::get('/blog/about-us', [ArticleController::class, 'aboutUs']);
Route::get('/blog/contact-us', [ArticleController::class, 'contactUs']);
Route::get('/blog/terms-and-condition', [ArticleController::class, 'terms']);
Route::get('/blog/privacy-policy', [ArticleController::class, 'privacyPolicy']);
Route::get('/blog/frequently-asked-questions', [ArticleController::class, 'faq']);
Route::get('/blog/faq', [ArticleController::class, 'faq']);
Route::get('/blog/creator-guide', [ArticleController::class, 'guide']);

Route::get('/blog', [ArticleController::class, 'blogMain']);
Route::get('/blog/search', [ArticleController::class, 'blogSearch']);
Route::get('/blog/{slug}', [ArticleController::class, 'viewArticle']);

Route::get('/organisasi/{organisasi}', [OrganizationController::class, 'detailOrganisasi']);
Route::get('/user/{username}', [UserProfileController::class, 'userPublicInfo']);

# SEMENTARA HARUS LOGIN UNTUK MENDAFTAR
Route::middleware(['auth'])->group(function () {
	# Checkout
	Route::get('/event/checkout', [TransactionController::class, 'checkoutPreview']);
	Route::get('/event/invoice/{hash}', [TransactionController::class, 'invoice']);
	Route::get('/event/ticket/{hash}', [TransactionController::class, 'ticket']);
	Route::post('/event/checkout-proccess', [TransactionController::class, 'transaction']);
	Route::post('/event/continue-transaction', [TransactionController::class, 'continueTransaction']);
	Route::post('/event/transaction-delete', [TransactionController::class, 'deleteTransaction']);
	Route::get('/event/send-email/{transaction_code}', [TransactionController::class, 'sendEmail']);
	Route::get('/event/redirect-invoice/{hash}', [TransactionController::class, 'redirectInvoice']);
	Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);
});

// Route::view('/email', 'apps.email-sandbox');

Route::get('/{event}', [EventController::class, 'show'])->name('event.show');
Route::get('/event/{event}', [EventController::class, 'show']);

# download file
Route::get('/download/sertifikat', [DownloadController::class, 'index']);
Route::get('/download/check-file', [DownloadController::class, 'checkFile']);
Route::get('/download-file/download', [DownloadController::class, 'downloadFile']);


# Resend email
Route::post('/email/verification-notification', [AuthController::class, 'resendEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

# forgot password
Route::get('/auth/forgot-password', [AuthController::class, 'forgotPasswordView'])->middleware('guest')->name('password.request');
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
Route::get('/auth/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->middleware('guest')->name('password.reset');
Route::post('/auth/send-reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');



Route::prefix('reservation')->name('reservation.')->group(function () {
		Route::post('/', [ReservationController::class, 'store'])->name('store');
		Route::patch('/{reservationCode}', [ReservationController::class, 'update'])->name('update');
		Route::post('/{reservationCode}/expire', [ReservationController::class, 'expire'])->name('expire');
	});

	# CHECKOUT
	Route::get('/checkout/{reservation_code}', [CheckoutController::class, 'create'])
		->name('checkout.show');

	Route::post('/checkout/validate', [CheckoutController::class, 'validateCheckout'])
		->name('checkout.validate');

	Route::post('/checkout/store', [CheckoutController::class, 'store'])
		->name('checkout.store');

	Route::get('/checkout/cleanup-sandbox', [CheckoutController::class, 'cleanupSandbox']);
	Route::prefix('transaction')->name('transaction.')->group(function () {

		// ─── Check Registration (path statis, tanpa binding) ───
		Route::post('/check-registration', [TransactionController::class, 'checkRegistration'])
			->name('check-registration');

		// ─── Semua route dengan binding transaction_code ───
		Route::prefix('{transaction:transaction_code}')->group(function () {

			// Edit & Update Participants — letakkan DI ATAS route '/'
			Route::get('/edit-participants', [TransactionController::class, 'editParticipants'])
				->name('edit-participants');

			Route::patch('/update-participants', [TransactionController::class, 'updateParticipants'])
				->name('update-participants');

			// ─── Existing routes ───
			Route::get('/', [TransactionController::class, 'show'])
				->name('show');

			Route::get('/check-status', [TransactionController::class, 'checkStatus'])
				->name('check-status');

			Route::post('/change-payment', [TransactionController::class, 'changePayment'])
				->name('change-payment');

			Route::get('/payment-methods', [TransactionController::class, 'paymentMethods'])
				->name('payment-methods');

			Route::get('/detail', [TransactionController::class, 'detail'])
				->name('detail');

			Route::get('/ticket', [TransactionController::class, 'ticket'])
				->name('ticket');

			Route::get('/ticket/download', [TransactionController::class, 'downloadTicket'])
				->name('ticket.download');

			Route::get('/invoice', [TransactionController::class, 'invoice'])
				->name('invoice');

			Route::get('/invoice/download', [TransactionController::class, 'downloadInvoice'])
				->name('invoice.download');
		});

	});

	# Handle file download dan view supaya tidak langsung ke storage
	Route::get('/file/view/{filename}', [FileController::class, 'view'])->name('file.view');
	Route::get('/file/download/{filename}', [FileController::class, 'download'])->name('file.download');


// Route::get('/test-event/{event:slug}', function (Event $event) {
//     return response()->json([
//         'id' => $event->id,
//         'slug' => $event->slug,
// 		'hh' => 'ss'
//     ]);
// });

// Route::get('/test-event2/{event}', function (Event $event) {
//     return response()->json([
//         'id' => $event->id,
//         'slug' => $event->slug,
//         'hh' => 'ss'
//     ]);
// });

// Route::get('/test-event3/{id}', function ($id) {
//     return response()->json([
//         'id' => $id,
//         'hh' => 'ss',
//     ]);
// });

// Route::get('/test-event4/{id}', function ($id) {
//     $start = microtime(true);

//     $event = Event::find($id);

//     $time = (microtime(true) - $start) * 1000;

//     return response()->json([
//         'id' => $event?->id,
//         'slug' => $event?->slug,
//         'query_ms' => round($time, 2),
//     ]);
// });

