<?php

namespace App\Http\Controllers;

use App\Models\ContactInformation;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Interests;
use App\Models\Languages;
use App\Models\PersonalInformation;
use App\Models\Projects;
use App\Models\Skills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Userprofile extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user->isAdmin()) {
        $resumes = PersonalInformation::with([
            'user.contactInformation',
            'user.education',
            'user.experiences',
            'user.projects',
            'user.skills',
            'user.languages',
            'user.interests'
        ])->paginate(10);
        Log::info('Resumes Data: ' . json_encode($resumes, JSON_PRETTY_PRINT));

        return view('index', [
            'resumes' => $resumes,
            'is_admin' => true,
            'has_resume' => true 
        ]);

    } else {
        $data = [
            'users_data' => [],
            'has_resume' => false,
            'is_admin' => false
        ];

        if ($personalInfo = PersonalInformation::where('user_id', $user->id)->first()) {
            $data['users_data'][] = [
                'personal_info' => $personalInfo->toArray(),
                'contact_info' => ContactInformation::where('user_id', $user->id)->first(),
                'education_info' => $personalInfo->user->education->toArray(),
                'experience_info' => $personalInfo->user->experiences->toArray(), // Changed to plural
                'project_info' => $personalInfo->user->projects->toArray(),
                'skill_info' => $personalInfo->user->skills->toArray(),
                'language_info' => $personalInfo->user->languages->toArray(),
                'interest_info' => $personalInfo->user->interests->toArray()
            ];
            $data['has_resume'] = true;

            Log::info('Data: ' . json_encode($data, JSON_PRETTY_PRINT));

        }

        return view('index', $data);
    }
}
    /**
     * Display the specified user's profile data.
     */
    public function view($id)
    {
        $personal_info = PersonalInformation::where('user_id', $id)->firstOrFail();
        $user_id = $personal_info['user_id'];
        
        $info = [
            'personal_info' => $personal_info,
            'contact_info' => ContactInformation::where('user_id', $user_id)->first()->toArray() ?? [],
            'education_info' => Education::where('user_id', $user_id)->get()->toArray(),
            'experience_info' => Experience::where('user_id', $user_id)->get()->toArray(),
            'project_info' => Projects::where('user_id', $user_id)->get()->toArray(),
            'skill_info' => Skills::where('user_id', $user_id)->get()->toArray(),
            'language_info' => Languages::where('user_id', $user_id)->get()->toArray(),
            'interest_info' => Interests::where('user_id', $user_id)->get()->toArray(),
        ];
        
        return view('view', ['information' => $info]);
    }

  
    public function create()
    {
        return view('create');
    }

  
    public function store(Request $request)
    {
        $user = Auth::user();

        $personal_info = new PersonalInformation();
        $personal_info->user_id = $user->id;
        $personal_info->first_name = $request->first_name;
        $personal_info->last_name = $request->last_name;
        $personal_info->profile_title = $request->profile_title;
        $personal_info->about_me = $request->about_me;
        if ($request->hasFile('image_path')) {
            $picture = $request->file('image_path')->getClientOriginalName();
            $request->file('image_path')->move(public_path('assets/images/'), $picture);
            $personal_info->image_path = $picture;
        }
        $personal_info->save();

        $contact_info = new ContactInformation();
        $contact_info->user_id = $user->id;
        $contact_info->email = $request->email;
        $contact_info->phone_number = $request->phone_number;
        $contact_info->website = $request->website;
        $contact_info->linkedin_link = $request->linkedin_link;
        $contact_info->github_link = $request->github_link;
        $contact_info->twitter = $request->twitter;
        $contact_info->save();

        $edu_count = count($request->degree_title ?? []);
        for ($i = 0; $i < $edu_count; $i++) {
            $education_info = new Education();
            $education_info->user_id = $user->id;
            $education_info->degree_title = $request->degree_title[$i];
            $education_info->institute = $request->institute[$i];
            $education_info->edu_start_date = $request->edu_start_date[$i];
            $education_info->edu_end_date = $request->edu_end_date[$i];
            $education_info->education_description = $request->education_description[$i];
            $education_info->save();
        }

        $exp_count = count($request->job_title ?? []);
        for ($i = 0; $i < $exp_count; $i++) {
            $experience_info = new Experience();
            $experience_info->user_id = $user->id;
            $experience_info->job_title = $request->job_title[$i];
            $experience_info->organization = $request->organization[$i];
            $experience_info->job_start_date = $request->job_start_date[$i];
            $experience_info->job_end_date = $request->job_end_date[$i];
            $experience_info->job_description = $request->job_description[$i];
            $experience_info->save();
        }

        $project_count = count($request->project_title ?? []);
        for ($i = 0; $i < $project_count; $i++) {
            $project_info = new Projects();
            $project_info->user_id = $user->id;
            $project_info->project_title = $request->project_title[$i];
            $project_info->project_description = $request->project_description[$i];
            $project_info->save();
        }

        $skill_count = count($request->skill_name ?? []);
        for ($i = 0; $i < $skill_count; $i++) {
            $skill_info = new Skills();
            $skill_info->user_id = $user->id;
            $skill_info->skill_name = $request->skill_name[$i];
            $skill_info->skill_percentage = $request->skill_percentage[$i];
            $skill_info->save();
        }

        $lang_count = count($request->language ?? []);
        for ($i = 0; $i < $lang_count; $i++) {
            $language_info = new Languages();
            $language_info->user_id = $user->id;
            $language_info->language = $request->language[$i];
            $language_info->language_level = $request->language_level[$i];
            $language_info->save();
        }

        $interest_count = count($request->interest ?? []);
        for ($i = 0; $i < $interest_count; $i++) {
            $interest_info = new Interests();
            $interest_info->user_id = $user->id;
            $interest_info->interest = $request->interest[$i];
            $interest_info->save();
        }

        return redirect()->route('index')->withSuccess("User Profile created successfully");
    }

  
    public function edit($id)
{
    $user = Auth::user();

    $personal_information = PersonalInformation::where('user_id', $id)->firstOrFail();

    if (!$user->isAdmin() && $personal_information->user_id !== $user->id) {
        abort(403, 'Unauthorized action.');
    }

    $info = [
        'personal_info' => $personal_information->toArray(),
        'contact_info' => ContactInformation::where('user_id', $id)->get()->toArray(),
        'education_info' => Education::where('user_id', $id)->get()->toArray(),
        'experience_info' => Experience::where('user_id', $id)->get()->toArray(),
        'project_info' => Projects::where('user_id', $id)->get()->toArray(),
        'skill_info' => Skills::where('user_id', $id)->get()->toArray(),
        'language_info' => Languages::where('user_id', $id)->get()->toArray(),
        'interest_info' => Interests::where('user_id', $id)->get()->toArray(),
    ];

    return view('edit', [
        'information' => $info,
        'user_id' => $id
    ]);
}
   
    public function update(Request $request)
    {
        if ($request->verify != 1) {
            return redirect()->back()->withErrors("Verification failed");
        }
    
        $user_id = $request->user_id;    
        PersonalInformation::updateOrCreate(
            ['user_id' => $user_id],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'profile_title' => $request->profile_title,
                'about_me' => $request->about_me,
                'image_path' => $request->hasFile('image_path') 
                    ? $this->handleImageUpload($request->file('image_path')) 
                    : PersonalInformation::where('user_id', $user_id)->value('image_path')
            ]
        );

        ContactInformation::updateOrCreate(
            ['user_id' => $user_id],
            [
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'website' => $request->website,
                'linkedin_link' => $request->linkedin_link,
                'github_link' => $request->github_link,
                'twitter' => $request->twitter
            ]
        );
    
        $updateSection = function ($model, $fields, $requestValues) use ($user_id) {
            $existing = $model::where('user_id', $user_id)->get();
            $localCount = count($requestValues[array_key_first($requestValues)] ?? []); // e.g., degree_title array count
            $existingCount = $existing->count();
            $max = max($localCount, $existingCount);
    
            for ($i = 0; $i < $max; $i++) {
                if ($i < $localCount && $i < $existingCount) {
                    $data = ['user_id' => $user_id];
                    foreach ($fields as $field) {
                        $data[$field] = $requestValues[$field][$i] ?? null;
                    }
                    $existing[$i]->update($data);
                } elseif ($i < $localCount && $i >= $existingCount) {
                    $data = ['user_id' => $user_id];
                    foreach ($fields as $field) {
                        $data[$field] = $requestValues[$field][$i] ?? null;
                    }
                    $model::create($data);
                } elseif ($i >= $localCount && $i < $existingCount) {
                    $existing[$i]->delete();
                }
            }
        };
    
        $updateSection(
            Education::class,
            ['degree_title', 'institute', 'edu_start_date', 'edu_end_date', 'education_description'],
            [
                'degree_title'          => $request->degree_title,
                'institute'             => $request->institute,
                'edu_start_date'        => $request->edu_start_date,
                'edu_end_date'          => $request->edu_end_date,
                'education_description' => $request->education_description,
            ]
        );
    
        $updateSection(
            Experience::class,
            ['job_title', 'organization', 'job_start_date', 'job_end_date', 'job_description'],
            [
                'job_title'       => $request->job_title,
                'organization'    => $request->organization,
                'job_start_date'  => $request->job_start_date,
                'job_end_date'    => $request->job_end_date,
                'job_description' => $request->job_description,
            ]
        );
    
        $updateSection(
            Projects::class,
            ['project_title', 'project_description'],
            [
                'project_title'       => $request->project_title,
                'project_description' => $request->project_description,
            ]
        );
    
        $updateSection(
            Skills::class,
            ['skill_name', 'skill_percentage'],
            [
                'skill_name'       => $request->skill_name,
                'skill_percentage' => $request->skill_percentage,
            ]
        );
    
        $updateSection(
            Languages::class,
            ['language', 'language_level'],
            [
                'language'       => $request->language,
                'language_level' => $request->language_level,
            ]
        );
    
        $updateSection(
            Interests::class,
            ['interest'],
            [
                'interest' => $request->interest,
            ]
        );
    
        return redirect()->back()->withSuccess("User Profile updated successfully");
    }
    

   
    public function destroy($id)
    {

        Log::info('ID: ' . json_encode($id, JSON_PRETTY_PRINT));

        $personal_info = PersonalInformation::where('user_id', $id)->firstOrFail();
    
        $personal_info->delete();
        ContactInformation::where('user_id', $id)->delete();
        Education::where('user_id', $id)->delete();
        Experience::where('user_id', $id)->delete();
        Projects::where('user_id', $id)->delete();
        Skills::where('user_id', $id)->delete();
        Languages::where('user_id', $id)->delete();
        Interests::where('user_id', $id)->delete();
    
        return redirect()->route('index')->with('success', 'Your profile was successfully deleted.');
    }
    
    private function handleImageUpload($file)
    {
        $picture = $file->getClientOriginalName();
        $file->move(public_path('assets/images/'), $picture);
        return $picture;
    }
}