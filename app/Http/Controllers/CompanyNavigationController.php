<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\JobListing;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyNavigationController extends Controller
{
    public function goToLoginPage()
    {
        return view('company/company-login');
    }

    public function goToDashboard()
    {
        $companyId = auth()->guard('company')->id();

        $jobListings = JobListing::with('applicants')
            ->where('posted_by', $companyId)
            ->get();

        $recentJobListings = JobListing::with('applicants')
            ->where('posted_by', $companyId)
            ->latest() // orders by created_at descending
            ->take(5)  // limits to 5 results
            ->get();

        $applicants = Applicant::whereHas('jobListing', function ($query) use ($companyId) {
            $query->where('posted_by', $companyId);
        })->get();

        $shortlistedApplicantsCount = Applicant::where('status', 'Shortlisted')
            ->whereHas('jobListing', function ($query) use ($companyId) {
                $query->where('posted_by', $companyId)
                    ->where('status', 'Active');
            })
            ->count();

        // ✅ Get latest 5 job listings (with applicants grouped by status)
        $latestJobs = JobListing::where('posted_by', $companyId)
            ->where('status', 'Active')
            ->latest()
            ->take(5)
            ->with(['applicants' => function ($query) {
                $query->select('id', 'job_listing_id', 'status');
            }])
            ->get(['id', 'job_title']);

        // Prepare chart data
        $jobTitles = [];
        $pendingCounts = [];
        $acceptedCounts = [];
        $rejectedCounts = [];

        foreach ($latestJobs as $job) {
            $jobTitles[] = $job->job_title;
            $pendingCounts[] = $job->applicants->where('status', 'Shortlisted')->count();
            $acceptedCounts[] = $job->applicants->whereIn('status', 'Accepted by Company')->count();
            $rejectedCounts[] = $job->applicants->whereIn('status', 'Rejected by Company')->count();
        }

        $pendingTotal = array_sum($pendingCounts);
        $acceptedTotal = array_sum($acceptedCounts);
        $rejectedTotal = array_sum($rejectedCounts);

        return view('company/company-dashboard', [
            'jobListings' => $jobListings,
            'applicants' => $applicants,
            'recentJobListings' => $recentJobListings,
            'shortlistedApplicantsCount' => $shortlistedApplicantsCount,
            'jobTitles' => $jobTitles,
            'pendingCounts' => $pendingCounts,
            'acceptedCounts' => $acceptedCounts,
            'rejectedCounts' => $rejectedCounts,
            'pendingTotal' => $pendingTotal,
            'acceptedTotal' => $acceptedTotal,
            'rejectedTotal' => $rejectedTotal,
        ]);
    }

    public function goToJobManagement(){
        // Get all job listings posted by the company
        $jobListings = JobListing::where('posted_by', auth()->guard('company')->id())->get();

        // Initialize an array to hold the number of applicants for each job listing
        $jobApplicantsCount = $jobListings->map(function ($jobListing) {
            // Count the number of applicants for each job listing
            return [
                'job' => $jobListing,
                'numberOfApplicants' => $jobListing->applicants()->count()
            ];
        });

        return view('company/company-job-management', [
            'jobListings' => $jobListings, // Pass the job listings with applicant count
            'jobApplicantsCount' => $jobApplicantsCount
        ]);
    }


    public function goToApplicantManagement(){
        $activeJobs = JobListing::where('posted_by', auth()->guard('company')->id())->where('status', 'Active')->get();

        return view('company/company-applicant-management', [
            'activeJobs' => $activeJobs
        ]);
    }

    public function goToAccountRegistration(){
        return view('company/company-account-registration');
    }

    public function goToProcessedApplicants(){
        $processedApplicants = Applicant::whereIn('status', ['Rejected by Company', 'Accepted by Company'])
            ->whereHas('jobListing', function ($query) {
            $query->where('posted_by', auth()->guard('company')->id())
                    ->whereIn('status', ['Active', 'Closed']);
            })
            ->with(['user', 'jobListing'])
            ->oldest()
            ->paginate(10, ['*'], 'processed_applicant_page');

        return view('company/company-processed-applicants', [
            'processedApplicants' => $processedApplicants
        ]);
    }

}
