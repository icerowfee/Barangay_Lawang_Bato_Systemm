<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use App\Models\Applicant;
use App\Models\JobListing;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\JobReferralRequest;

class UserController extends Controller
{


    public function submitJobApplication(Request $request, Applicant $applicant)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'firstname' => ['required', 'string'],
            'middlename' => ['nullable', 'string'],
            'lastname' => ['required', 'string'],
            'contact_number' => ['required', 'string'],
            'email' => ['required', 'email'],
            'house_number' => ['required', 'string'],
            'barangay' => ['required', 'string'],
            'city' => ['required', 'string'],
            'province' => ['required', 'string'],
            'age' => ['nullable', 'numeric'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'educational_attainment' => ['nullable', 'string'],
            'special_program' => ['nullable', 'string'],
            'certificate_number' => ['nullable', 'string'],
            'resume' => ['nullable', 'mimes:pdf', 'max:2048'],
            // 'valid_id' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2MB
            // 'secondary_valid_id' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2MB
        ]);

        // Handle resume upload if provided
        $resumePath = $user->resume;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('user_accounts/resumes', 'public');
            $user->resume = $resumePath;
            $user->save();
        }

        // Update the user model with the provided data
        $user->update([
            'firstname' => $validated['firstname'],
            'middlename' => $validated['middlename'] ?? null,
            'lastname' => $validated['lastname'],
            'contact_number' => $validated['contact_number'],
            'email' => $validated['email'],
            'house_number' => $validated['house_number'],
            'barangay' => $validated['barangay'],
            'city' => $validated['city'],
            'province' => $validated['province'],
            'age' => $validated['age'],
            'valid_id' => $user->valid_id ?? null,  // Retain the existing value if not updated
        ]);

        

        // Create a new applicant record
        $applicant->create([
            'job_listing_id' => $request->input('job_listing_id'),
            'user_id' => $user->id,
            'resume' => $resumePath ?? $user->resume, // Save the updated resume path
            // 'valid_id' => $user->valid_id ?? null,
            // 'secondary_valid_id' => $user->secondary_valid_id ?? null,
            'height' => $validated['height'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'educational_attainment' => $validated['educational_attainment'] ?? null,
            'special_program' => $validated['special_program'] ?? null,
            'certificate_number' => $validated['certificate_number'] ?? null,
            'status' => 'Applied',
        ]);

        return redirect('user-job-seeking')->with('success', 'Job application submitted successfully!');
    }

    public function uploadResume(Request $request){
        $request->validate([
            'resume' => ['required', 'mimes:pdf', 'max:2048'], // Max 2MB
        ]);

        $user = auth()->user();

        $resumePath = $request->file('resume')->store('user_accounts/resumes', 'public');

        $user->resume = $resumePath;
        $user->save();

        return redirect()->back()->with('success', 'Resume uploaded successfully!');
    }

    public function uploadValidId(Request $request)
    {
        $request->validate([
            'valid_id' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2MB
        ]);

        $user = auth()->user();

        $validIdPath = $request->file('valid_id')->store('user_accounts/valid_ids', 'public');

        $user->valid_id = $validIdPath;
        $user->save();

        return redirect()->back()->with('success', 'Valid ID uploaded successfully!');
    }

    public function uploadSecondaryValidId(Request $request)
    {
        $request->validate([
            'secondary_valid_id' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2MB
        ]);

        $user = auth()->user();

        $secondaryValidIdPath = $request->file('secondary_valid_id')->store('user_accounts/valid_ids', 'public');

        $user->secondary_valid_id = $secondaryValidIdPath;
        $user->save();

        return redirect()->back()->with('success', 'Secondary Valid ID uploaded successfully!');
    }

    public function updateAccountInformation(Request $request){
        $user = auth()->user();

        $userData = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'house_number' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province'=> ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'contact_number' => ['required', 'numeric', 'digits:11'],
        ],
        [
            'firstname.required' => 'First name is required.',
            'lastname.required' => 'Last name is required.',
            'house_number.required' => 'House number is required.',
            'barangay.required' => 'Barangay is required.',
            'city.required' => 'City is required.',
            'province.required' => 'Province is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'This email is already taken.',
            'contact_number.required' => 'Contact number is required.',
            'contact_number.numeric' => 'Contact number must be numeric.',
            'contact_number.digits' => 'Contact number must be 11 digits.',
        ]);

        $userData['firstname'] = implode(" ", array_map('ucfirst', explode(" ", strtolower($userData['firstname']))));
        $userData['middlename'] = ucfirst(strtolower($userData['middlename']));
        $userData['lastname'] = ucfirst(strtolower($userData['lastname']));


        $user->update($userData);

        return redirect()->back()->with('success', 'Account information updated successfully!');
    }

    public function updateAccountPassword(Request $request){
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    public function sendJobReferralRequest(Request $request){
        $jobReferralData = $request->validate([
            'user_id' => ['required', Rule::exists('users', 'id')],
            'biodata' => 'required',
            'sss_id' => 'required',
            'tin_id' => 'required',
            'pagibig_id' => 'required',
            'police_clearance' => 'required',
            'nbi_clearance' => 'required',
            'cedula' => 'required',
            'barangay_clearance' => 'required',
            'status' => 'nullable',
        ]);

        $jobReferralData['user_id'] = auth()->id(); // Assuming the user is authenticated
        $jobReferralData['status'] = 'Pending'; // Default status

        // Store the files in the public disk

        $jobReferralData['biodata'] = $request->file('biodata')->store('job_referral/biodata', 'public');
        $jobReferralData['sss_id'] = $request->file('sss_id')->store('job_referral/sss_id', 'public');
        $jobReferralData['tin_id'] = $request->file('tin_id')->store('job_referral/tin_id', 'public');
        $jobReferralData['pagibig_id'] = $request->file('pagibig_id')->store('job_referral/pagibig_id', 'public');
        $jobReferralData['police_clearance'] = $request->file('police_clearance')->store('job_referral/police_clearance', 'public');
        $jobReferralData['nbi_clearance'] = $request->file('nbi_clearance')->store('job_referral/nbi_clearance', 'public');
        $jobReferralData['cedula'] = $request->file('cedula')->store('job_referral/cedula', 'public');
        $jobReferralData['barangay_clearance'] = $request->file('barangay_clearance')->store('job_referral/barangay_clearance', 'public');
        
        // Create the job referral request
        JobReferralRequest::create($jobReferralData);    
        // Redirect or return a response
        return redirect('user-job-seeking')->with('success', 'Job referral request submitted successfully!');
    }

    public function registerAccount(Request $request){
        $userData = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'house_number' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province'=> ['required', 'string', 'max:255'],
            'civil_status' => ['required'],
            'sex' => ['required'],
            'birthdate' => ['required', 'date'],
            'age' => ['required', 'numeric', 'min:18', 'max:65'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'contact_number' => ['required', 'numeric', 'digits:11'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'valid_id' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2MB
            'status' => ['required'],
        ],
        [
            'firstname.required' => 'First name is required.',
            'lastname.required' => 'Last name is required.',
            'house_number.required' => 'House number is required.',
            'barangay.required' => 'Barangay is required.',
            'city.required' => 'City is required.',
            'province.required' => 'Province is required.',
            'civil_status.required' => 'Civil status is required.',
            'birthdate.required' => 'Birthdate is required.',
            'age.required' => 'Age is required.',
            'age.numeric' => 'Invalid.',
            'age.min' => 'Age must be at least 18.',
            'age.max' => 'Age must not exceed 65.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'This email is already taken.',
            'contact_number.required' => 'Contact number is required.',
            'contact_number.numeric' => 'Contact number must be numeric.',
            'contact_number.digits' => 'Contact number must be 11 digits.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'valid_id.required' => 'Valid ID is required.',
            'valid_id.image' => 'The valid ID must be an image file.',
            'valid_id.mimes' => 'The valid ID must be a file of type: jpeg, png, or jpg.',
            'valid_id.size' => 'The valid ID must not exceed 2MB.',
            'status.required' => 'Status is required.'
        ]);

        $userData['firstname'] = implode(" ", array_map('ucfirst', explode(" ", strtolower($userData['firstname']))));
        $userData['middlename'] = ucfirst(strtolower($userData['middlename']));
        $userData['lastname'] = ucfirst(strtolower($userData['lastname']));

        $userData['password'] = bcrypt($userData['password']);

        if (isset($userData['valid_id'])) {
            $userData['valid_id'] = $request->file('valid_id')->store('user_accounts/valid_ids', 'public');
        } else {
            $userData['valid_id'] = null;
        }

        
    
        $user = User::create($userData);

        

        return redirect('user-job-seeking')->with('success', 'Account created successfully! Please log in.');
    }


    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', Rule::exists('users', 'email')],
            'password' => ['required'],
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.exists' => 'No account found with this email.',
            'password.required' => 'Password is required.',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            // Email not found (though validation should already catch this)
            return back()->withErrors(['email' => 'No account found with this email.'])->withInput();
        }

        // Check if password matches
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['password' => 'The password you entered is incorrect.'])->withInput();
        }

        // Attempt to login
        auth()->login($user);

        return redirect('user-job-seeking');
    }

    public function logout(){
        auth()->logout();
        return redirect('user-job-seeking');
    }


    public function viewAnnouncement(Announcement $announcement){
        return view('user/view-announcement', ['announcement' => $announcement]);
    }

    public function applyToJob(JobListing $jobListing){
        $jobListing = JobListing::with('company')->find($jobListing->id);
        $user = auth()->user();
        return view('user.user-job-application', [
            'jobListing' => $jobListing, 
            'user' => $user
        ]);
    }
}
