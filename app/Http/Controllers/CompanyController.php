<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function registerCompany(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'company_name' => ['required', 'string', 'max:150'],
            'business_type' =>  ['required', 'string', 'max:100'],
            'street_address' =>  ['required', 'string', 'max:150'],
            'barangay' =>  ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'contact_person_name' => ['required', 'string', 'max:100'],
            'contact_person_position' => ['required', 'string', 'max:100'],
            'contact_person_email' => ['required', 'string', 'max:100'],
            'contact_person_contact_number' => ['required', 'numeric', 'digits:11'],
            'account_email' => ['required', 'email', 'max:100', Rule::unique('companies', 'account_email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'description' => ['nullable', 'string'],
            'website' => ['nullable', 'string', 'max:150'],
            'logo' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'registration_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // Max 5MB
            'contact_person_valid_id' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2MB
        ]);

        
        $validatedData['registration_document'] = $request->file('registration_document')->store('company_documents', 'public');
        $validatedData['contact_person_valid_id'] = $request->file('contact_person_valid_id')->store('company_valid_ids', 'public');

        // Hash the password before saving
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Create the company record
        $company = Company::create($validatedData);

        // Redirect or return response
        return redirect()->route('company.login')->with('success', 'Company registered successfully. Please wait for verification.');
    }

    public function companyLogin(Request $request)
    {
        $credentials = $request->validate([
            'account_email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (auth()->guard('company')->attempt(['account_email' => $credentials['account_email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/company-dashboard')->with('');
        }

        return back()->withErrors([
            'account_email' => 'The provided credentials do not match our records.',
        ])->onlyInput('account_email');
    }

    public function companyLogout(Request $request)
    {
        auth()->guard('company')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/company-login');
    }

    public function postJobListing(Request $request)
    {
        $validatedData = $request->validate([
            'job_title' => ['required', 'string', 'max:150'],
            'job_category' => ['required', 'string', 'max:100'],
            'job_description' => ['required', 'string'],
            'job_location' => ['required', 'string', 'max:150'],
            'min_salary' => ['nullable', 'numeric', 'min:0'],
            'max_salary' => ['nullable', 'numeric', 'min:0', 'gte:min_salary'],
            'employment_type' => ['required', 'string', 'max:50'],
            'application_deadline_date' => ['required', 'date'],
            'application_deadline_time' => ['required', 'date_format:H:i'],
            'min_age' => ['nullable', 'integer', 'min:0'],
            'max_age' => ['nullable', 'integer', 'min:0', 'gte:min_age'],
            'min_height' => ['nullable', 'numeric', 'min:0'],
            'max_height' => ['nullable', 'numeric', 'min:0', 'gte:min_height'],
            'min_weight' => ['nullable', 'numeric', 'min:0'],
            'max_weight' => ['nullable', 'numeric', 'min:0', 'gte:min_weight'],
            'educational_attainment' => ['nullable', 'string', 'max:255'],
            'special_program' => ['nullable', 'string', 'max:255'],
            'certificate_number' => ['nullable', 'string', 'max:255'],
            'is_special_program_optional' => ['nullable', 'string', 'max:10'],
        ]);

        // Combine date and time into a single datetime field
        $validatedData['application_deadline'] = Carbon::parse($validatedData['application_deadline_date'].' '.$validatedData['application_deadline_time']);        
        unset($validatedData['application_deadline_date'], $validatedData['application_deadline_time']);

        $validatedData['posted_by'] = auth()->guard('company')->id();
        $validatedData['status'] = 'Pending'; // New listings are pending by default

        // // Generate a custom Job ID (JP001, JP002, etc.)
        // $lastJob = JobListing::latest()->first();
        // $newJobId = 'JP' . str_pad($lastJob ? $lastJob->id + 1 : 1, 4, '0', STR_PAD_LEFT);
        // $validatedData['job_id'] = $newJobId;


        JobListing::create($validatedData);

        return redirect()->back()->with('success', 'Job listing added successfully and is pending approval.');
    }

    public function deleteJobListing(Request $request)
    {
        $validatedData = $request->validate([
            'job_id' => ['required', 'string', Rule::exists('job_listings', 'job_id')],
        ]);

        $jobListing = JobListing::where('job_id', $validatedData['job_id'])->first();

        if ($jobListing && $jobListing->posted_by == auth()->guard('company')->id()) {
            $jobListing->delete();
            return redirect()->back()->with('success', 'Job has been deleted successfully.');
        }

        return redirect()->back()->with('error', 'You are not authorized to delete this job listing.');
    }

    public function closeJobListing(Request $request)
    {
        $validatedData = $request->validate([
            'job_id' => ['required', 'string', Rule::exists('job_listings', 'job_id')],
        ]);

        $jobListing = JobListing::where('job_id', $validatedData['job_id'])->first();

        if ($jobListing && $jobListing->posted_by == auth()->guard('company')->id()) {
            $jobListing->status = 'Closed';
            $jobListing->save();
            return redirect()->back()->with('success', 'Job has been closed successfully.');
        }

        return redirect()->back()->with('error', 'You are not authorized to close this job listing.');
    }

    public function approveApplicationRequest(Request $request)
    {
        $validatedData = $request->validate([
            'applicant_id' => ['required', 'integer', Rule::exists('applicants', 'id')],
        ]);

        $application = Applicant::find($validatedData['applicant_id']);

        if ($application) {
            $application->status = 'Accepted by Company';
            $application->save();
            return redirect()->back()->with('success', 'Application has been approved successfully.');
        }

        return redirect()->back()->with('error', 'Application not found.');
    }

    public function rejectApplicationRequest(Request $request)
    {
        $validatedData = $request->validate([
            'applicant_id' => ['required', 'integer', Rule::exists('applicants', 'id')],
        ]);

        $application = Applicant::find($validatedData['applicant_id']);

        if ($application) {
            $application->status = 'Rejected by Company';
            $application->save();
            return redirect()->back()->with('success', 'Application has been rejected successfully.');
        }

        return redirect()->back()->with('error', 'Application not found.');
    }
}
