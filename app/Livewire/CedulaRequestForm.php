<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CedulaRequest;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class CedulaRequestForm extends Component
{

    use WithFileUploads;

    // 🧩 Form properties
    public $firstname;
    public $middlename;
    public $lastname;
    public $house_number;
    public $barangay;
    public $city;
    public $province;
    public $civil_status = 'Single';
    public $birthdate;
    public $birthplace;
    public $age;
    public $sex = 'Male';
    public $email;
    public $contact_number;
    public $tin;
    public $gross_income;
    public $valid_id;
    public $data_privacy_agreement;

    public function documentRequest()
    {
        $userInput = $this->validate(
            [
                'firstname' => ['required', 'string', 'max:255'],
                'middlename' => ['nullable', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'house_number' => ['required', 'string', 'max:255'],
                'barangay' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'province' => ['required', 'string', 'max:255'],
                'civil_status' => ['required'],
                'birthdate' => ['required', 'date'],
                'birthplace' => ['required', 'string', 'max:255'],
                'age' => ['required', 'numeric', 'min:18', 'max:65'],
                'sex' => ['required'],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('cedula_requests', 'email')->where(function ($query) {
                        return $query->where('status', 'Pending')->orWhere('status', 'Approved');
                    }),
                ],
                'contact_number' => ['required', 'numeric', 'digits:11'],
                'tin' => ['nullable', 'numeric', 'digits_between:9,12'],
                'gross_income' => ['nullable', 'numeric', 'min:0'],
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
                'birthdate.required' => 'Birthdate is required.',
                'birthplace.required' => 'Birthplace is required.',
                'age.required' => 'Age is required.',
                'age.numeric' => 'Invalid.',
                'age.min' => 'Age must be at least 18.',
                'age.max' => 'Age must not exceed 65.',
                'email.required' => 'Email is required.',
                'email.email' => 'Invalid email format.',
                'email.max' => 'Email must not exceed 255 characters.',
                'email.unique' => 'This email is already associated with a pending or approved Cedula request.',
                'contact_number.required' => 'Contact number is required.',
                'contact_number.numeric' => 'Contact number must be numeric.',
                'tin.numeric' => 'TIN must be a numeric value.',
                'tin.digits_between' => 'TIN must be between 9 and 12 digits.',
                'gross_income.numeric' => 'Gross income must be a numeric value.',
                'gross_income.min' => 'Gross income must be at least 0.',
                'valid_id.required' => 'Valid ID is required.',
                'valid_id.image' => 'The valid ID must be an image file.',
                'valid_id.mimes' => 'The valid ID must be a file of type: jpeg, png, or jpg.',
                'valid_id.size' => 'The valid ID must not exceed 2MB.',
                'data_privacy_agreement.accepted' => 'You must accept the data privacy agreement.'
            ]
        );


        $userInput['firstname'] = ucfirst(strtolower($userInput['firstname']));
        $userInput['middlename'] = ucfirst(strtolower($userInput['middlename']));
        $userInput['lastname'] = ucfirst(strtolower($userInput['lastname']));

        $userInput['valid_id'] = $this->valid_id->store('document_requests/cedula/valid_ids', 'public');
        
        $userInput['data_privacy_agreement'] = $this->data_privacy_agreement ? true : false;



        CedulaRequest::create($userInput);

        // Dispatch the event to broadcast the new document request
        // event(new NewDocumentRequest($userInput['firstname'] . ' ' . $userInput['lastname'], 'Cedula') );

        // return redirect()->back()->with('success', 'Cedula Request has been sent successfully');

        $this->reset();
        $this->dispatch('show-success-toast', message: 'Cedula Request has been sent successfully.');

    }


    public function render()
    {
        return view('livewire.cedula-request-form');
    }
}
