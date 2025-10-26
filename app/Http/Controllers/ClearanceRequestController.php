<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ClearanceRequest;

class ClearanceRequestController extends Controller
{
    public function documentRequest(Request $request){
        $userInput = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'house_number' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],      
            'province'=> ['required', 'string', 'max:255'],  
            'civil_status' => 'required',
            'birthplace' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'age' => ['required', 'numeric', 'min:18', 'max:65'],
            'sex' => 'required',
            'email' => [
                'required', 
                'email', 
                'max:255',
                Rule::unique('clearance_requests', 'email')->where(function ($query) {
                    return $query->where('status', 'Pending')->orWhere('status', 'Approved'); 
                }),
            ],
            'contact_number' => ['required', 'numeric', 'digits:11'],
            'years_stay' => ['nullable', 'numeric', 'min:0'],
            'user_purpose' => ['required', 'string', 'max:255'],
            'valid_id' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'data_privacy_agreement' => 'accepted',
        ],
        [
            'firstname.required' => 'First name is required.',
            'lastname.required' => 'Last name is required.',
            'house_number.required' => 'House number is required.',
            'barangay.required' => 'Barangay is required.',
            'city.required' => 'City is required.',
            'province.required' => 'Province is required.',
            'civil_status.required' => 'Civil status is required.',
            'birthplace.required' => 'Birthplace is required.',
            'birthdate.required' => 'Birthdate is required.',
            'age.required' => 'Age is required.',
            'age.numeric' => 'Invalid age.',
            'age.min' => 'Age must be at least 18.', // clarify
            'age.max' => 'Age must not exceed 65.', // clarify
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'This email is already associated with a pending or approved Clearance request.',
            'contact_number.required' => 'Contact number is required.',
            'contact_number.numeric' => 'Contact number must be numeric.',
            'valid_id.required' => 'Valid ID is required.',
            'valid_id.image' => 'The valid ID must be an image file.',
            'valid_id.mimes' => 'The valid ID must be a file of type: jpeg, png, or jpg.',
            'valid_id.size' => 'The valid ID must not exceed 2MB.',
            'data_privacy_agreement.accepted' => 'You must accept the data privacy agreement.'
        ]);
        

        $userInput['firstname'] = ucfirst(strtolower($userInput['firstname']));
        $userInput['middlename'] = ucfirst(strtolower($userInput['middlename']));
        $userInput['lastname'] = ucfirst(strtolower($userInput['lastname']));

        $userInput['valid_id'] = $request->file('valid_id')->store('document_requests/clearance/valid_ids', 'public');

        $userInput['data_privacy_agreement'] = $request->has('data_privacy_agreement') ? true : false;


        ClearanceRequest::create($userInput);

        return redirect()->back()->with('success', 'Clearance Request has been sent successfully');
    }
}
