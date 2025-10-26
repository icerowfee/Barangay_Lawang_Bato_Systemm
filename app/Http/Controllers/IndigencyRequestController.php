<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\IndigencyRequest;

class IndigencyRequestController extends Controller
{
    public function documentRequest(Request $request){
        $userInput = $request->validate([
            'recipient_firstname' => ['required', 'string', 'max:255'],
            'recipient_middlename' => ['nullable', 'string', 'max:255'],
            'recipient_lastname' => ['required', 'string', 'max:255'],
            'representative_firstname' => ['required', 'string', 'max:255'],
            'representative_middlename' => ['nullable', 'string', 'max:255'],
            'representative_lastname' => ['required', 'string', 'max:255'],
            'house_number' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province'=> ['required', 'string', 'max:255'],  
            'email' => [
                'required', 
                'email', 
                'max:255',
                Rule::unique('indigency_requests', 'email')->where(function ($query) {
                    return $query->where('status', 'Pending')->orWhere('status', 'Approved'); 
                }),
            ],
            'contact_number' => ['required', 'numeric', 'digits:11'],
            'user_purpose' => ['required', 'string', 'max:255'],
            'valid_id' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'data_privacy_agreement' => 'accepted',
        ],
        [
            'recipient_firstname.required' => 'Recipient first name is required.',
            'recipient_lastname.required' => 'Recipient last name is required.',
            'representative_firstname.required' => 'Representative first name is required.',
            'representative_lastname.required' => 'Representative last name is required.',
            'house_number.required' => 'House number is required.',
            'barangay.required' => 'Barangay is required.',
            'city.required' => 'City is required.',
            'province.required' => 'Province is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'This email is already associated with a pending or approved Indigency request.',
            'contact_number.required' => 'Contact number is required.',
            'user_purpose.required' => 'Purpose of request is required.',
            'valid_id.required' => 'Valid ID is required.',
            'valid_id.image' => 'The valid ID must be an image file.',
            'valid_id.mimes' => 'The valid ID must be a file of type: jpeg, png, or jpg.',
            'valid_id.size' => 'The valid ID must not exceed 2MB.',
            'data_privacy_agreement.accepted' => 'You must accept the data privacy agreement.'
        ]);

        // // Custom logic to enforce cedula_photo must be uploaded if cedula_number is given
        // if ($request->filled('cedula_number') && !$request->hasFile('cedula_photo')) {
        //     return back()->withErrors(['cedula_photo' => 'You must upload the cedula photo before entering a cedula number.'])->withInput();
        // }
        
        $userInput['recipient_firstname'] = ucfirst(strtolower($userInput['recipient_firstname']));
        $userInput['recipient_middlename'] = ucfirst(strtolower($userInput['recipient_middlename']));
        $userInput['recipient_lastname'] = ucfirst(strtolower($userInput['recipient_lastname']));

        $userInput['representative_firstname'] = ucfirst(strtolower($userInput['representative_firstname']));
        $userInput['representative_middlename'] = ucfirst(strtolower($userInput['representative_middlename']));
        $userInput['representative_lastname'] = ucfirst(strtolower($userInput['representative_lastname']));

        $userInput['valid_id'] = $request->file('valid_id')->store('document_requests/indigency/valid_ids', 'public');

        $userInput['data_privacy_agreement'] = $request->has('data_privacy_agreement') ? true : false;

        if ($request->hasFile('cedula_photo')) {
            $userInput['cedula_photo'] = $request->file('cedula_photo')->store('document_requests/indigency/cedula_photos', 'public');
        } else {
            $userInput['cedula_photo'] = null;
        }


        IndigencyRequest::create($userInput);

        return redirect()->back()->with('success', 'Indigency Request has been sent successfully');
    }
}
