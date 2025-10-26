<?php

use App\Models\Announcement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\CedulaRequestController;
use App\Http\Controllers\UserNavigationController;
use App\Http\Controllers\AdminNavigationController;
use App\Http\Controllers\ClearanceRequestController;
use App\Http\Controllers\IndigencyRequestController;
use App\Http\Controllers\CompanyNavigationController;
use App\Http\Controllers\SuperAdminNavigationController;

Route::get('/', function () {
    $announcements = Announcement::all();
    return view('user/user-home-page', ['announcements' => $announcements]);
});

//Super Admin Navigation
Route::get('super-admin-login', [SuperAdminNavigationController::class, 'goToLoginPage']);
Route::get('super-admin-dashboard', [SuperAdminNavigationController::class, 'goToDashboard']);
Route::get('super-admin-account-management', [SuperAdminNavigationController::class, 'goToAccountManagement'])->name('super.admin.account.management');
Route::get('super-admin-announcement-management', [SuperAdminNavigationController::class, 'goToAnnouncementManagement']);
Route::get('super-admin-barangay-official-management', [SuperAdminNavigationController::class, 'goToBarangayOfficialManagement']);
Route::get('super-admin-sk-official-management', [SuperAdminNavigationController::class, 'goToSkOfficialManagement']);
Route::get('super-admin-report', [SuperAdminNavigationController::class, 'goToReport']);
Route::get('super-admin-generated-report', [SuperAdminNavigationController::class, 'goToGeneratedReport'])->name('go.to.super.admin.generated.report');
Route::get('super-admin-log', [SuperAdminNavigationController::class, 'goToLog'])->name('go.to.super.admin.log');


//Super Admin Actions
Route::post('/super-admin-login', [SuperAdminController::class, 'superAdminLogin'])->name('super.admin.login');
Route::post('/super-admin-logout', [SuperAdminController::class, 'superAdminLogout'])->name('super.admin.logout');
Route::post('/super-admin-generate-report', [SuperAdminController::class, 'generateReport'])->name('super.admin.generate.report');


Route::post('/super-admin-create-account', [SuperAdminController::class, 'createAccount'])->name('create.admin.account');
Route::put('/edit-admin-account', [SuperAdminController::class, 'editAdminAccount'])->name('edit.admin.account');
Route::delete('/delete-admin-account', [SuperAdminController::class, 'deleteAdminAccount'])->name('delete.admin.account');
Route::get('/sort-admin-account/{sort_by},{sort_dir}', [SuperAdminController::class, 'sortAdminAccount'])->name('sort.admin.account');


Route::post('/super-admin-add-announcement', [SuperAdminController::class, 'addAnnouncement'])->name('add.announcement');
Route::put('/edit-announcement', [SuperAdminController::class, 'editAnnouncement'])->name('edit.announcement');
Route::delete('/delete-announcement', [SuperAdminController::class, 'deleteAnnouncement'])->name('delete.announcement');


Route::put('/update-barangay-official-list', [SuperAdminController::class, 'updateBarangayOfficialList'])->name('update.barangay.official.list');
Route::put('/update-sk-official-list', [SuperAdminController::class, 'updateSkOfficialList'])->name('update.sk.official.list');



//Company Navigation
Route::get('/company-login', [CompanyNavigationController::class, 'goToLoginPage']);
Route::get('/company-dashboard', [CompanyNavigationController::class, 'goToDashboard']);
Route::get('/company-job-management', [CompanyNavigationController::class, 'goToJobManagement']);
Route::get('/company-applicant-management', [CompanyNavigationController::class, 'goToApplicantManagement']);
Route::get('/company-processed-applicants', [CompanyNavigationController::class, 'goToProcessedApplicants']);
Route::get('/company-account-registration', [CompanyNavigationController::class, 'goToAccountRegistration']);



//Company Actions
Route::post('/company-register', [CompanyController::class, 'registerCompany'])->name('company.register');
Route::post('/company-login', [CompanyController::class, 'companyLogin'])->name('company.login');
Route::post('/company-logout', [CompanyController::class, 'companyLogout'])->name('company.logout');
Route::post('/post-job-listing', [CompanyController::class, 'postJobListing'])->name('post.job.listing');
Route::delete('/delete-job-listing', [CompanyController::class, 'deleteJobListing'])->name('delete.job.listing');
Route::put('/close-job-listing', [CompanyController::class, 'closeJobListing'])->name('close.job.listing');
Route::put('/company-applicant-management/application.request.approved', [CompanyController::class, 'approveApplicationRequest'])->name('approve.applicant');
Route::put('/company-applicant-management/application.request.rejected', [CompanyController::class, 'rejectApplicationRequest'])->name('reject.applicant');




//Admin Navigation
Route::get('/admin-dashboard', [AdminNavigationController::class, 'goToDashboard']);
Route::get('/admin-document-request', [AdminNavigationController::class, 'goToDocumentRequests'])->name('go.to.admin.document.requests');
Route::get('/admin-job-referral', [AdminNavigationController::class, 'goToJobReferrals']);
Route::get('/admin-announcement-section', [AdminNavigationController::class, 'goToAnnouncementSection']);
Route::get('/admin-login', [AdminNavigationController::class, 'goToLoginPage']);
Route::get('/admin-company-account-management', [AdminNavigationController::class, 'goToCompanyAccount']);
Route::get('/admin-user-account-management', [AdminNavigationController::class, 'goToUserAccount']);
Route::get('/admin-job-listing-management', [AdminNavigationController::class, 'goToJobListings']);
Route::get('/admin-report', [AdminNavigationController::class, 'goToReport']);
Route::get('/admin-generated-report', [AdminNavigationController::class, 'goToGeneratedReport'])->name('go.to.admin.generated.report');

Route::get('/admin-report-template', [AdminNavigationController::class, 'goToReportTemplate']);



//Admin Login/Logout
Route::post('/admin-login', [AdminController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin-logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
Route::post('/admin-generate-report', [AdminController::class, 'generateReport'])->name('admin.generate.report');


//Admin Document Request
Route::get('/admin-document-request', [AdminDocumentController::class, 'showDocumentRequests'])->name('admin.document.request');
Route::put('/admin-document-request/cedula.approved', [AdminDocumentController::class, 'approveCedulaRequest'])->name('approve.cedula.request');
Route::put('/admin-document-request/clearance.approve', [AdminDocumentController::class, 'approveClearanceRequest'])->name('approve.clearance.request');
Route::put('/admin-document-request/indigency.approve', [AdminDocumentController::class, 'approveIndigencyRequest'])->name('approve.indigency.request');
Route::put('/admin-document-request/cedula.reject', [AdminDocumentController::class, 'rejectCedulaRequest'])->name('reject.cedula.request');
Route::put('/admin-document-request/clearance.reject', [AdminDocumentController::class, 'rejectClearanceRequest'])->name('reject.clearance.request');
Route::put('/admin-document-request/indigency.reject', [AdminDocumentController::class, 'rejectIndigencyRequest'])->name('reject.indigency.request');
Route::put('/admin-document-request/update.cedula.number', [AdminDocumentController::class, 'updateCedulaNumber'])->name('update.cedula.number');
Route::get('/admin/print.cedula', [AdminDocumentController::class, 'printCedula'])->name('print.cedula');
Route::get('/admin/print.clearance', [AdminDocumentController::class, 'printClearance'])->name('print.clearance');
Route::get('/admin/print.indigency', [AdminDocumentController::class, 'printIndigency'])->name('print.indigency');
Route::put('/admin/claim.cedula', [AdminDocumentController::class, 'claimCedula'])->name('claim.cedula');



//Admin Job Referral
Route::get('/admin-user-account-management', [AdminController::class, 'showAccountRequests']);
Route::get('/admin-company-account-management', [AdminController::class, 'showCompanyAccountRequests']);
Route::get('/admin-job-listing-management', [AdminController::class, 'showJobListings']);
Route::get('/admin-job-referral', [AdminController::class, 'showApplicationRequests']);


Route::put('/admin-user-account-request/user.account.approved', [AdminController::class, 'approveAccountRequest'])->name('approve.user.account.request');
Route::put('/admin-user-account-request/user.account.rejected', [AdminController::class, 'rejectAccountRequest'])->name('reject.user.account.request');
Route::put('/admin-user-account-management/user.account.delete', [AdminController::class, 'deleteUserAccount'])->name('delete.user.account');
Route::put('/admin-user-account-management/user.account.deactivate', [AdminController::class, 'deactivateUserAccount'])->name('deactivate.user.account');
Route::put('/admin-user-account-management/user.account.reactivate', [AdminController::class, 'reactivateUserAccount'])->name('reactivate.user.account');

Route::put('/admin-company-account-request/company.account.approved', [AdminController::class, 'approveCompanyAccountRequest'])->name('approve.company.account.request');
Route::put('/admin-company-account-request/company.account.rejected', [AdminController::class, 'rejectCompanyAccountRequest'])->name('reject.company.account.request');
Route::put('/admin-company-account-management/company.account.delete', [AdminController::class, 'deleteCompanyAccount'])->name('delete.company.account');
Route::put('/admin-company-account-management/company.account.deactivate', [AdminController::class, 'deactivateCompanyAccount'])->name('deactivate.company.account');
Route::put('/admin-company-account-management/company.account.reactivate', [AdminController::class, 'reactivateCompanyAccount'])->name('reactivate.company.account');
Route::put('/admin-company-account-management/company.account.archive', [AdminController::class, 'archiveCompanyAccount'])->name('archive.company.account');


Route::put('/admin-job-referral-request/application.request.approved', [AdminController::class, 'approveApplicationRequest'])->name('approve.application.request');
Route::put('/admin-job-referral-request/application.request.rejected', [AdminController::class, 'rejectApplicationRequest'])->name('reject.application.request');
Route::put('/admin-job-referral-request/application.request.delete', [AdminController::class, 'deleteApplicationRequest'])->name('delete.application.request');
Route::put('/admin-job-referral-request/job.referral.request.schedule', [AdminController::class, 'scheduleJobReferralRequest'])->name('schedule.job.referral.request');
Route::put('/admin-job-referral-request/job.referral.request.referred', [AdminController::class, 'referredJobReferralRequest'])->name('referred.job.referral.request');

Route::put('/admin-job-listing-management/job.listing.approved', [AdminController::class, 'approveJobListing'])->name('approve.job.listing');
Route::put('/admin-job-listing-management/job.listing.rejected', [AdminController::class, 'rejectJobListing'])->name('reject.job.listing');
// Route::put('/admin-job-listing-management/job.listing.close', [AdminController::class, 'closeJobListing'])->name('close.job.listing');
// Route::put('/admin-job-listing-management/job.listing.delete', [AdminController::class, 'deleteJobListing'])->name('delete.job.listing');



//User Navigation
Route::get('/user-cedula-request', [UserNavigationController::class, 'goToCedulaRequest']);
Route::get('/user-clearance-request', [UserNavigationController::class, 'goToClearanceRequest']);
Route::get('/user-indigency-request', [UserNavigationController::class, 'goToIndigencyRequest']);
Route::get('/user-home-page', [UserNavigationController::class, 'goToHomePage']);
Route::get('/user-job-referral', [UserNavigationController::class, 'goToJobReferral']);
Route::get('/user-contact-page', [UserNavigationController::class, 'goToContactPage']);
Route::get('/user-announcement-section', [UserNavigationController::class, 'goToAnnouncementSection']);
Route::get('/user-barangay-official-section', [UserNavigationController::class, 'goToBarangayOfficialSection']);
Route::get('/user-sk-official-section', [UserNavigationController::class, 'goToSkOfficialSection']);
Route::get('/user-job-seeking', [UserNavigationController::class, 'goToJobSeeking'])->name('user.job.seeking');
Route::get('/user-account-registration', [UserNavigationController::class, 'goToAccountRegistration']);
Route::get('/user-job-reqeust-status', [UserNavigationController::class, 'goToJobRequestStatus']);
Route::get('/user-about-page', [UserNavigationController::class, 'goToAboutPage']);
Route::get('/user-contact-us-page', [UserNavigationController::class, 'goToContactUsPage']);
Route::get('/user-job-profile', [UserNavigationController::class, 'goToJobProfile']);
Route::get('/user-job-application', [UserNavigationController::class, 'goToJobApplication']);



//user Login/Logout
Route::post('/user-login', [UserController::class, 'login'])->name('user.login');
Route::post('/user-logout', [UserController::class, 'logout'])->name('user.logout');


//user Action
Route::post('/cedula-request', [CedulaRequestController::class, 'documentRequest'])->name('cedula.request');
Route::post('/clearance-request', [ClearanceRequestController::class, 'documentRequest'])->name('clearance.request');
Route::post('/indigency-request', [IndigencyRequestController::class, 'documentRequest'])->name('indigency.request');


Route::get('/view-announcement/{announcement}', [UserController::class, 'viewAnnouncement'])->name('display.announcement');
Route::post('/user-register-account', [UserController::class, 'registerAccount'])->name('user.register.account');
Route::post('/send-job-referral-request', [UserController::class, 'sendJobReferralRequest'])->name('send.job.referral.request');
Route::put('/user-update-account-information', [UserController::class, 'updateAccountInformation'])->name('update.account.information');
Route::put('/user-update-account-password', [UserController::class, 'updateAccountPassword'])->name('update.account.password');
Route::get('/apply-to-job/{jobListing}', [UserController::class, 'applyToJob'])->name('apply.to.job');
Route::put('/upload-resume', [UserController::class, 'uploadResume'])->name('upload.resume');
Route::put('/upload-valid-id', [UserController::class, 'uploadValidId'])->name('upload.valid.id');
Route::put('/upload-secondary-valid-id', [UserController::class, 'uploadSecondaryValidId'])->name('upload.secondary.valid.id');
Route::post('/submit-job-application/{jobListing}', [UserController::class, 'submitJobApplication'])->name('submit.job.application');




Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('send.email');
