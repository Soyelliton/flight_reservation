<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MailingAddress;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // GET /customers
    public function index()
    {
        $customers = Customer::with(['mailingAddress', 'contactInfos'])->get();
        return response()->json(['data' => $customers]);
    }

    // POST /customers
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',

            // Address
            'address.street' => 'required|string',
            'address.city' => 'required|string',
            'address.state_or_province' => 'required|string',
            'address.postal_code' => 'required|string',
            'address.country' => 'required|string',

            // Contact information arrays
            'emails' => 'array',
            'emails.*' => 'email|unique:contact_infos,value',
            'phones' => 'array',
            'phones.*.full_number' => 'string',
            'faxes' => 'array',
            'faxes.*.full_number' => 'string',
        ]);

        return DB::transaction(function () use ($validated) {
            // Create or find existing mailing address
            $address = MailingAddress::firstOrCreate($validated['address']);

            // Create customer
        $customer = Customer::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'mailing_address_id' => $address->id,
        ]);

            // Create email contacts
            if (isset($validated['emails'])) {
                foreach ($validated['emails'] as $email) {
                    if (!empty($email)) {
        ContactInfo::create([
            'customer_id' => $customer->id,
            'type' => 'email',
                            'value' => $email,
                        ]);
                    }
                }
            }

            // Create phone contacts
            if (isset($validated['phones'])) {
                foreach ($validated['phones'] as $phone) {
                    if (!empty($phone['full_number'])) {
                        $phoneData = $this->parsePhoneNumber($phone['full_number']);
                        if ($phoneData) {
                            ContactInfo::create([
                                'customer_id' => $customer->id,
                                'type' => 'phone',
                                'country_code' => $phoneData['country_code'],
                                'area_code' => $phoneData['area_code'],
                                'local_number' => $phoneData['local_number'],
                            ]);
                        }
                    }
                }
            }

            // Create fax contacts
            if (isset($validated['faxes'])) {
                foreach ($validated['faxes'] as $fax) {
                    if (!empty($fax['full_number'])) {
                        $faxData = $this->parsePhoneNumber($fax['full_number']);
                        if ($faxData) {
                            ContactInfo::create([
                                'customer_id' => $customer->id,
                                'type' => 'fax',
                                'country_code' => $faxData['country_code'],
                                'area_code' => $faxData['area_code'],
                                'local_number' => $faxData['local_number'],
                            ]);
                        }
                    }
                }
            }

            return response()->json($customer->load(['mailingAddress', 'contactInfos']), 201);
        });
    }

    // GET /customers/{id}
    public function show($id)
    {
        $customer = Customer::with(['mailingAddress', 'contactInfos'])->findOrFail($id);
        return response()->json($customer);
    }

    // PUT /customers/{id}
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',

            // Address
            'address.street' => 'required|string',
            'address.city' => 'required|string',
            'address.state_or_province' => 'required|string',
            'address.postal_code' => 'required|string',
            'address.country' => 'required|string',

            // Contact information arrays
            'emails' => 'array',
            'emails.*' => 'email|unique:contact_infos,value,' . $customer->id . ',customer_id',
            'phones' => 'array',
            'phones.*.country_code' => 'required_with:phones.*.area_code,phones.*.local_number|string',
            'phones.*.area_code' => 'required_with:phones.*.country_code,phones.*.local_number|string',
            'phones.*.local_number' => 'required_with:phones.*.country_code,phones.*.area_code|string',
            'faxes' => 'array',
            'faxes.*.country_code' => 'required_with:faxes.*.area_code,faxes.*.local_number|string',
            'faxes.*.area_code' => 'required_with:faxes.*.country_code,faxes.*.local_number|string',
            'faxes.*.local_number' => 'required_with:faxes.*.country_code,faxes.*.area_code|string',
        ]);

        return DB::transaction(function () use ($validated, $customer) {
            // Update customer basic info
            $customer->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
            ]);

            // Create or update mailing address
            $address = MailingAddress::firstOrCreate($validated['address']);
            $customer->update(['mailing_address_id' => $address->id]);

            // Delete existing contact info
            $customer->contactInfos()->delete();

            // Create email contacts
            if (isset($validated['emails'])) {
                foreach ($validated['emails'] as $email) {
                    if (!empty($email)) {
                        ContactInfo::create([
                            'customer_id' => $customer->id,
                            'type' => 'email',
                            'value' => $email,
                        ]);
                    }
                }
            }

            // Create phone contacts
            if (isset($validated['phones'])) {
                foreach ($validated['phones'] as $phone) {
                    if (!empty($phone['full_number'])) {
                        $phoneData = $this->parsePhoneNumber($phone['full_number']);
                        if ($phoneData) {
                            ContactInfo::create([
                                'customer_id' => $customer->id,
                                'type' => 'phone',
                                'country_code' => $phoneData['country_code'],
                                'area_code' => $phoneData['area_code'],
                                'local_number' => $phoneData['local_number'],
                            ]);
                        }
                    }
                }
            }

            // Create fax contacts
            if (isset($validated['faxes'])) {
                foreach ($validated['faxes'] as $fax) {
                    if (!empty($fax['full_number'])) {
                        $faxData = $this->parsePhoneNumber($fax['full_number']);
                        if ($faxData) {
                            ContactInfo::create([
                                'customer_id' => $customer->id,
                                'type' => 'fax',
                                'country_code' => $faxData['country_code'],
                                'area_code' => $faxData['area_code'],
                                'local_number' => $faxData['local_number'],
                            ]);
                        }
                    }
                }
            }

            return response()->json($customer->load(['mailingAddress', 'contactInfos']));
        });
    }

    // DELETE /customers/{id}
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully']);
    }
    
    /**
     * Parse phone number to extract country code, area code, and local number
     */
    private function parsePhoneNumber($fullNumber)
    {
        // Remove all non-digit characters except +
        $cleanNumber = preg_replace('/[^\d+]/', '', $fullNumber);
        
        // If the number starts with +, extract country code
        if (strpos($cleanNumber, '+') === 0) {
            $cleanNumber = substr($cleanNumber, 1); // Remove the +
        }
        
        // For now, we'll use a simple approach
        // You might want to use a more sophisticated phone number parsing library
        if (strlen($cleanNumber) >= 10) {
            // For Indian numbers (+91), country code is 91, area code is next 3-4 digits
            if (strlen($cleanNumber) >= 12 && substr($cleanNumber, 0, 2) === '91') {
                $countryCode = '91';
                $areaCode = substr($cleanNumber, 2, 3); // First 3 digits after country code
                $localNumber = substr($cleanNumber, 5);
            }
            // For US/Canada numbers (+1), country code is 1, area code is next 3 digits
            elseif (strlen($cleanNumber) >= 10 && substr($cleanNumber, 0, 1) === '1') {
                $countryCode = '1';
                $areaCode = substr($cleanNumber, 1, 3);
                $localNumber = substr($cleanNumber, 4);
            }
            // For other numbers, assume first 1-3 digits are country code
            else {
                $countryCode = substr($cleanNumber, 0, 1);
                $areaCode = substr($cleanNumber, 1, 3);
                $localNumber = substr($cleanNumber, 4);
            }
            
            $result = [
                'country_code' => '+' . $countryCode,
                'area_code' => $areaCode,
                'local_number' => $localNumber
            ];
            
            return $result;
        }
        
        return null;
    }
}
