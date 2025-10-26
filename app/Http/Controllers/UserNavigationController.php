<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\SkOfficial;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\BarangayOfficial;
use App\Models\JobReferralRequest;

class UserNavigationController extends Controller
{
    public function goToHomePage(){
        $announcements = Announcement::all();
        
        return view('user/user-home-page',['announcements' => $announcements]);
    }

    public function goToCedulaRequest(){
        return view('user/user-cedula-request');
    }

    public function goToClearanceRequest(){
        return view('user/user-clearance-request');
    }

    public function goToIndigencyRequest(){
        return view('user/user-indigency-request');
    }

    public function goToJobSeeking(Request $request)
    {
        $user = auth()->user();

        // Get all applied job IDs by this user
        $appliedJobIds = JobListing::whereHas('applicants', function ($query) use ($user) {
            $query->where('user_id', $user?->id);
        })->pluck('id')->toArray();

        // Base query
        $query = JobListing::with('company');

        // 🔍 Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('job_title', 'like', "%{$searchTerm}%")
                ->orWhere('job_category', 'like', "%{$searchTerm}%")
                ->orWhere('educational_attainment', 'like', "%{$searchTerm}%")
                ->orWhereHas('company', function ($q2) use ($searchTerm) {
                    $q2->where('company_name', 'like', "%{$searchTerm}%");
                });
            });
        }

        // 📋 Additional filters
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->input('employment_type'));
        }

        if ($request->filled('educational_attainment')) {
            $query->where('educational_attainment', $request->input('educational_attainment'));
        }

        if ($request->filled('job_category')) {
            $query->where('job_category', $request->input('job_category'));
        }

        // Get filtered and searched results
        $jobListings = $query->get();

        // Return view
        return view('user.user-job-seeking', [
            'jobListings' => $jobListings,
            'appliedJobIds' => $appliedJobIds,
            'user' => $user,
        ]);
    }


    public function goToAccountRegistration(){
        return view('user/user-account-registration');
    }

    public function goToContactPage(){
        return view('user/user-contact-page');
    }

    public function goToAnnouncementSection(){
        return view('user/user-announcement-section');
    }

    public function goToBarangayOfficialSection(){
        $punongBarangay = BarangayOfficial::first(); // Get the first row (single object)
        $kagawadOfficials = BarangayOfficial::skip(1)->take(9)->get(); // Get remaining rows
        return view('user/user-barangay-official-section', ['kagawadOfficials' => $kagawadOfficials, 'punongBarangay' => $punongBarangay]);
    }

    public function goToSkOfficialSection(){
        $skChairman = SkOfficial::first(); // Get the first row (single object)
        $skOfficials = SkOfficial::skip(1)->take(9)->get(); // Get remaining rows
        return view('user/user-sk-official-section', ['skOfficials' => $skOfficials, 'skChairman' => $skChairman]);
    }
    
    public function goToAboutPage(){
        return view('user/user-about-lawang-bato');
    }

    public function goToContactUsPage(){
        return view('user/user-contact-us-page');
    }

    public function goToJobProfile(){
        $user = auth()->user();
        return view('user/user-job-profile', ['user' => $user]);
    }

    public function goToJobApplication(){
        
        return view('user/user-job-application');
    }
    
}
