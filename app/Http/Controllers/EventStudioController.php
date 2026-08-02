<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\Category;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\EventImage;
use App\Models\OrganisationMember;
use Illuminate\Support\Facades\DB;
use App\Models\CustomForm;
use App\Models\EventCategory;
use Illuminate\Support\Facades\Validator;

class EventStudioController extends Controller
{
    public function basic($event_id)
    {
        $event = Event::with('images')->where('event_id', $event_id)->firstOrFail();
        $myOrg = OrganisationMember::with('org')
            ->where('user_id', auth()->id())
            ->whereIn('position', ['Owner', 'Member'])
            ->get();
            

        return view('event-studio.basic', [
            'event'    => $event,
            'organizations' => $myOrg,
            'categories' => EventCategory::all(),
            'theme'    => Theme::all(),
        ]);
    }

    public function detail($event_id)
	{

    $event = Event::with('images')->where('event_id', $event_id)->firstOrFail();
		return view('event-studio.detail', [
            'event'    => $event,
			'categories' => EventCategory::all(),
			'theme' => Theme::all(),
		]);
	}

    public function ticket($event_id)
	{
        $event = Event::with('tickets')->where('event_id', $event_id)->firstOrFail();
        
            return view('event-studio.ticket', [
                'event'    => $event,
                'tickets'  => $event->tickets,
            ]);
	}
    public function form($event_id)
    {
        $event = Event::where('event_id', $event_id)->firstOrFail();

        $forms = CustomForm::where('event_id', $event->id)
            ->orderBy('sort_order')
            ->get();

        return view('event-studio.form', [

            'event' => $event,

            'forms' => $forms

        ]);
    }

    public function urlCheck(Request $request)
    {
        $slug = trim($request->url);

        if ($slug == '') {
            return response()->json([
                'result' => 'N'
            ]);
        }

        $exists = Event::where('slug', $slug)->exists();

        return response()->json([
            'result' => $exists ? 1 : 0
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([

            'name'        => 'required|max:255',

            'slug'        => 'required|unique:events,slug',

            'category_id' => 'required',

        ]);

        $event = DB::transaction(function () use ($request) {

            $event = Event::create([

                'event_id'      => 'evt_' . Str::ulid(),
                'user_id'       => auth()->id(),
                'organizer'     => 'individual',
                'title'         => $request->name,
                'slug'          => $request->slug,
                'category_id'      => $request->category_id,
                'event_status'  => 'draft',

            ]);

            CustomForm::insert([

                [
                    'event_id'          => $event->id,
                    'sort_order'        => 1,
                    'field_type'        => 'text',
                    'field_label'       => 'Full Name',
                    'field_key'         => 'full_name',
                    'field_placeholder' => 'Enter your full name',
                    'field_required'    => true,
                    'field_status'      => true,
                    'is_system'         => true,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ],

                [
                    'event_id'          => $event->id,
                    'sort_order'        => 2,
                    'field_type'        => 'email',
                    'field_label'       => 'Email',
                    'field_key'         => 'email',
                    'field_placeholder' => 'example@email.com',
                    'field_required'    => true,
                    'field_status'      => true,
                    'is_system'         => true,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ],

                [
                    'event_id'          => $event->id,
                    'sort_order'        => 3,
                    'field_type'        => 'phone',
                    'field_label'       => 'Phone Number',
                    'field_key'         => 'phone',
                    'field_placeholder' => '08xxxxxxxxxx',
                    'field_required'    => true,
                    'field_status'      => true,
                    'is_system'         => true,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ],

            ]);

            return $event;

        });

        return response()->json([

            'success'  => true,
            'event_id' => $event->event_id

        ]);
    }

    public function autosave(Request $request, $event_id)
    
    {
        $event = Event::where('event_id', $event_id)->firstOrFail();

        switch ($request->section) {

            case 'basic':

                // Validasi slug jika berubah
                if ($request->filled('slug')) {

                    $exists = Event::where('slug', $request->slug)
                        ->where('id', '!=', $event->id)
                        ->exists();

                    if ($exists) {

                        return response()->json([
                            'success' => false,
                            'field'   => 'slug',
                            'message' => 'URL sudah digunakan.'
                        ], 422);

                    }

                }

                $event->fill([
                    'title'       => $request->title,
                    'slug'        => $request->slug,
                    'category_id'    => $request->category_id,
                    'theme'       => $request->theme,
                ]);

                // Organizer
                if (
                    $request->organizer === 'org' &&
                    $request->filled('organization_id')
                ) {

                    $event->organizer = 'org';
                    $event->organizer_id = $request->organization_id;

                } else {

                    // Fallback ke akun pribadi
                    $event->organizer = 'individual';
                    $event->organizer_id = auth()->id();

                }

                $event->save();

                break;

            // nanti
            case 'detail':

                $rules = [
                    'theme'               => 'nullable|string|max:255',
                    'location_jenis'      => 'required|in:online,offline',
                    'location_online'     => 'nullable|string|max:500',
                    'location_province'   => 'nullable',
                    'location_city'       => 'nullable',
                    'location_detail'     => 'nullable|string|max:255',
                    'start_date'          => 'nullable|date',
                    'end_date'            => 'nullable|date|after_or_equal:start_date',
                    'description'         => 'nullable|string',
                ];

                $request->validate($rules);

                $event->theme = $request->theme;
                $event->location_jenis = $request->location_jenis;
                $event->start_date = $request->start_date;
                $event->end_date = $request->end_date;
                $event->description = $request->description;

                if ($request->location_jenis === 'online') {

                    // Simpan data online
                    $event->location_online = $request->location_online;

                    // Bersihkan data offline
                    $event->location_province = null;
                    $event->location_city = null;
                    $event->location_detail = null;

                } else {

                    // Simpan data offline
                    $event->location_province = $request->location_province;
                    $event->location_city = $request->location_city;
                    $event->location_detail = $request->location_detail;

                    // Bersihkan data online
                    $event->location_online = null;

                }

                $event->save();

                break;

            case 'ticket':
                break;

        }

        return response()->json([
            'success' => true,
            'message' => 'Saved'
        ]);
    }


    public function uploadBanner(Request $request, $event_id)
    {
        $request->validate([
            'banner' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $event = Event::where('event_id', $event_id)->firstOrFail();

        // Hapus banner lama
        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $extension = strtolower($request->file('banner')->getClientOriginalExtension());

        $filename = $event->event_id . '-banner.' . $extension;

        $path = $request->file('banner')->storeAs(
            'event-images',
            $filename,
            'public'
        );

        $event->image = $filename;
        $event->save();

        return response()->json([
            'success' => true,
            'message' => 'Banner uploaded successfully.',
            'image'   => asset('storage/' . $path),
        ]);
    }

    public function deleteBanner($event_id)
    {
        $event = Event::where('event_id', $event_id)->firstOrFail();

        if ($event->image) {

            Storage::disk('public')->delete(
                'event-images/'.$event->image
            );

            $event->image = null;

            $event->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Banner deleted successfully.'
        ]);
    }

    public function uploadGallery(Request $request, $event_id)
    {
        $request->validate([
            'images'   => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $event = Event::where('event_id', $event_id)->firstOrFail();

        $uploaded = [];

        $lastSort = EventImage::where('event_id', $event->event_id)
            ->max('sort_order') ?? 0;

        foreach ($request->file('images') as $file) {

            $extension = strtolower($file->getClientOriginalExtension());

            $filename = $event->event_id . '-' . Str::random(12) . '.' . $extension;

            $file->storeAs(
                'event-gallery',
                $filename,
                'public'
            );

            $image = EventImage::create([
                'event_id'  => $event->event_id,
                'image'     => $filename,
                'sort_order'=> ++$lastSort,
            ]);

            $uploaded[] = [
                'id'         => $image->id,
                'image'      => asset('storage/event-gallery/'.$filename),
                'filename'   => $filename,
                'sort_order' => $image->sort_order,
            ];
        }

        return response()->json([
            'success' => true,
            'images'  => $uploaded
        ]);
    }

    public function deleteGallery($event_id, $image)
    {
        $gallery = EventImage::where('event_id', $event_id)
            ->findOrFail($image);

        if ($gallery->image) {

            Storage::disk('public')->delete(
                'event-gallery/'.$gallery->image
            );

        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.'
        ]);
    }

    public function sortGallery(Request $request, $event_id)
    {
        $request->validate([
            'images' => 'required|array'
        ]);

        DB::transaction(function () use ($request, $event_id) {

            foreach ($request->images as $item) {

                EventImage::where('event_id', $event_id)
                    ->where('id', $item['id'])
                    ->update([
                        'sort_order' => $item['sort_order']
                    ]);

            }

        });

        return response()->json([
            'success' => true,
            'message' => 'Gallery updated.'
        ]);
    }


    public function storeTicket(Request $request, $event_id)
    {
        $request->merge([

            'ticket_price' => (int) ($request->ticket_price ?: 0),

        ]);
        $event = Event::where('event_id', $event_id)->firstOrFail();

        $validated = $request->validate([

            'ticket_name'        => 'required|string|max:255',

            'ticket_description' => 'nullable|string',

            'ticket_price'       => 'required|numeric|min:0',

            'ticket_quota'       => 'required|integer|min:1',

            'ticket_start'       => 'required|date',

            'ticket_end'         => 'required|date|after_or_equal:ticket_start',

            'ticket_button'      => 'required|string|max:50',

            'max_quantity'       => 'required|integer|min:1',

        ]);

        $validated['event_id'] = $event->id;

        $validated['sort_order'] = Ticket::where('event_id', $event->id)->max('sort_order') + 1;

        $ticket = Ticket::create($validated);

        $html = view(
            'event-studio.ticket-card',
            compact('ticket')
        )->render();

        return response()->json([
            'success' => true,
            'message' => 'Ticket created successfully.',
            'html' => $html

        ]);
    }

    public function updateTicket(Request $request, $event_id, $ticket_id)
    {
        $request->merge([

            'ticket_price' => (int) ($request->ticket_price ?: 0),

        ]);

        $event = Event::where('event_id', $event_id)->firstOrFail();

        $ticket = Ticket::where('id', $ticket_id)
            ->where('event_id', $event->id)
            ->firstOrFail();

        $validated = $request->validate([
            'ticket_name'        => 'required|string|max:255',
            'ticket_description' => 'nullable|string|max:1000',
            'ticket_price'       => 'required|numeric|min:0',
            'ticket_quota'       => 'required|integer|min:1',
            'max_quantity'       => 'required|integer|min:1',
            'ticket_start'       => 'required|date',
            'ticket_end'         => 'required|date|after_or_equal:ticket_start',
            'ticket_button'      => 'required|string|max:100',
        ]);

        $ticket->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ticket updated successfully.',
            'html' => view(
                'event-studio.ticket-card',
                compact('ticket')
            )->render()
        ]);
    }

    public function deleteTicket($event_id, $ticket_id)
    {
        $event = Event::where('event_id', $event_id)->firstOrFail();

        $ticket = Ticket::where('id', $ticket_id)
            ->where('event_id', $event->id)
            ->firstOrFail();

        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket deleted successfully.'
        ]);
    }

    public function storeForm(Request $request, $event_id)
    {
        $rules = [
            'field_label'     => 'required|string|max:100',
            'field_type'      => 'required|string|max:50',
            'description'     => 'nullable|string|max:255',
            'placeholder'     => 'nullable|string|max:255',
            'is_required'     => 'nullable|boolean',

            'field_options'   => 'nullable|array',
            'field_options.*' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {

            $type = $request->field_type;

            /*
            |--------------------------------------------------------------------------
            | Select / Radio / Checkbox
            |--------------------------------------------------------------------------
            */

            if (in_array($type, ['select', 'radio', 'checkbox'])) {

                $options = collect($request->field_options ?? [])
                    ->map(fn($item) => trim($item))
                    ->filter();

                if ($options->count() < 1) {

                    $validator->errors()->add(
                        'field_options',
                        'Minimal harus memiliki satu pilihan.'
                    );

                }

            }

            /*
            |--------------------------------------------------------------------------
            | Text / Textarea
            |--------------------------------------------------------------------------
            */

            if (in_array($type, ['text', 'textarea'])) {

                $min = $request->field_min_length;
                $max = $request->field_max_length;

                if ($min === null || $min === '') {

                    $validator->errors()->add(
                        'field_min_length',
                        'Minimum length wajib diisi.'
                    );

                }

                if ($max === null || $max === '') {

                    $validator->errors()->add(
                        'field_max_length',
                        'Maximum length wajib diisi.'
                    );

                }

                if ($min !== null && $min !== '' && !is_numeric($min)) {

                    $validator->errors()->add(
                        'field_min_length',
                        'Minimum length harus berupa angka.'
                    );

                }

                if ($max !== null && $max !== '' && !is_numeric($max)) {

                    $validator->errors()->add(
                        'field_max_length',
                        'Maximum length harus berupa angka.'
                    );

                }

                if (
                    is_numeric($min) &&
                    is_numeric($max) &&
                    $min > $max
                ) {

                    $validator->errors()->add(
                        'field_max_length',
                        'Minimum length tidak boleh lebih besar dari maximum length.'
                    );

                }

            }

            /*
            |--------------------------------------------------------------------------
            | Number
            |--------------------------------------------------------------------------
            */

            if ($type === 'number') {

                $min = $request->field_min_value;
                $max = $request->field_max_value;

                if ($min === null || $min === '') {

                    $validator->errors()->add(
                        'field_min_value',
                        'Minimum value wajib diisi.'
                    );

                }

                if ($max === null || $max === '') {

                    $validator->errors()->add(
                        'field_max_value',
                        'Maximum value wajib diisi.'
                    );

                }

                if ($min !== null && $min !== '' && !is_numeric($min)) {

                    $validator->errors()->add(
                        'field_min_value',
                        'Minimum value harus berupa angka.'
                    );

                }

                if ($max !== null && $max !== '' && !is_numeric($max)) {

                    $validator->errors()->add(
                        'field_max_value',
                        'Maximum value harus berupa angka.'
                    );

                }

                if (
                    is_numeric($min) &&
                    is_numeric($max) &&
                    $min > $max
                ) {

                    $validator->errors()->add(
                        'field_max_value',
                        'Minimum value tidak boleh lebih besar dari maximum value.'
                    );

                }

            }

            /*
            |--------------------------------------------------------------------------
            | File / Image
            |--------------------------------------------------------------------------
            */

            if (in_array($type, ['file', 'image'])) {

                $extensions = $request->field_extensions ?? [];

                if (count($extensions) === 0) {

                    $validator->errors()->add(
                        'field_extensions',
                        'Pilih minimal satu format file.'
                    );

                }

            }

        });

        if ($validator->fails()) {

            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);

        }

        $event = Event::where('id', $event_id)->firstOrFail();
        
        $sortOrder = CustomForm::where('event_id', $event->id)->max('sort_order') ?? 0;

        $fieldOptions = collect($request->field_options ?? [])
            ->map(fn($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();

        $fieldValidation = null;

        if (in_array($request->field_type, ['text', 'textarea'])) {

            $fieldValidation = [
                'min_length' => (int) $request->field_min_length,
                'max_length' => (int) $request->field_max_length,
            ];

        } elseif ($request->field_type === 'number') {

            $fieldValidation = [
                'min' => $request->field_min_value,
                'max' => $request->field_max_value,
            ];

        } elseif (in_array($request->field_type, ['file', 'image'])) {

            $fieldValidation = [
                'extensions' => collect($request->field_extensions ?? [])
                    ->filter()
                    ->values()
                    ->toArray(),
            ];

        }

        $fieldKey = Str::snake($request->field_label);

        $count = CustomForm::where('event_id', $event->id)
            ->where('field_key', 'LIKE', "{$fieldKey}%")
            ->count();

        if ($count > 0) {

            $fieldKey .= '_' . ($count + 1);

        }

        $form_data = [
            'event_id'          => $event->id,
            'field_key'         => $fieldKey,
            'is_system'         => false,
            'field_label'       => $request->field_label,
            'field_type'        => $request->field_type,
            'field_help'        => $request->description,
            'field_placeholder' => $request->placeholder,
            'field_required'    => $request->boolean('is_required'),
            'field_options'     => $fieldOptions,
            'field_validation'  => $fieldValidation,
            'sort_order'        => $sortOrder + 1,
        ];

        $form = CustomForm::create($form_data);

        $html = view('event-studio.form-card', compact('form'))->render();

        return response()->json([
            'status'  => true,
            'message' => 'Field berhasil ditambahkan.',
            'html'    => $html,
        ]);
    }

    public function updateForm(Request $request, $event_id, $id)
    {
        $form = CustomForm::findOrFail($id);

        $rules = [
            'field_label'     => 'required|string|max:100',
            'field_type'      => 'required|string|max:50',
            'description'     => 'nullable|string|max:255',
            'placeholder'     => 'nullable|string|max:255',
            'is_required'     => 'nullable|boolean',

            'field_options'   => 'nullable|array',
            'field_options.*' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {

            $type = $request->field_type;

            /*
            |--------------------------------------------------------------------------
            | Select / Radio / Checkbox
            |--------------------------------------------------------------------------
            */

            if (in_array($type, ['select', 'radio', 'checkbox'])) {

                $options = collect($request->field_options ?? [])
                    ->map(fn($item) => trim($item))
                    ->filter();

                if ($options->count() < 1) {

                    $validator->errors()->add(
                        'field_options',
                        'Minimal harus memiliki satu pilihan.'
                    );

                }

            }

            /*
            |--------------------------------------------------------------------------
            | Text / Textarea
            |--------------------------------------------------------------------------
            */

            if (in_array($type, ['text', 'textarea'])) {

                $min = $request->field_min_length;
                $max = $request->field_max_length;

                if ($min === null || $min === '') {
                    $validator->errors()->add('field_min_length', 'Minimum length wajib diisi.');
                }

                if ($max === null || $max === '') {
                    $validator->errors()->add('field_max_length', 'Maximum length wajib diisi.');
                }

                if ($min !== null && $min !== '' && !is_numeric($min)) {
                    $validator->errors()->add('field_min_length', 'Minimum length harus berupa angka.');
                }

                if ($max !== null && $max !== '' && !is_numeric($max)) {
                    $validator->errors()->add('field_max_length', 'Maximum length harus berupa angka.');
                }

                if (is_numeric($min) && is_numeric($max) && $min > $max) {
                    $validator->errors()->add('field_max_length', 'Minimum length tidak boleh lebih besar dari maximum length.');
                }

            }

            /*
            |--------------------------------------------------------------------------
            | Number
            |--------------------------------------------------------------------------
            */

            if ($type === 'number') {

                $min = $request->field_min_value;
                $max = $request->field_max_value;

                if ($min === null || $min === '') {
                    $validator->errors()->add('field_min_value', 'Minimum value wajib diisi.');
                }

                if ($max === null || $max === '') {
                    $validator->errors()->add('field_max_value', 'Maximum value wajib diisi.');
                }

                if ($min !== null && $min !== '' && !is_numeric($min)) {
                    $validator->errors()->add('field_min_value', 'Minimum value harus berupa angka.');
                }

                if ($max !== null && $max !== '' && !is_numeric($max)) {
                    $validator->errors()->add('field_max_value', 'Maximum value harus berupa angka.');
                }

                if (is_numeric($min) && is_numeric($max) && $min > $max) {
                    $validator->errors()->add('field_max_value', 'Minimum value tidak boleh lebih besar dari maximum value.');
                }

            }

            /*
            |--------------------------------------------------------------------------
            | File / Image
            |--------------------------------------------------------------------------
            */

            if (in_array($type, ['file', 'image'])) {

                $extensions = $request->field_extensions ?? [];

                if (count($extensions) === 0) {
                    $validator->errors()->add('field_extensions', 'Pilih minimal satu format file.');
                }

            }

        });

        if ($validator->fails()) {

            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);

        }

        $fieldOptions = collect($request->field_options ?? [])
            ->map(fn($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();

        $fieldValidation = null;

        if (in_array($request->field_type, ['text', 'textarea'])) {

            $fieldValidation = [
                'min_length' => (int) $request->field_min_length,
                'max_length' => (int) $request->field_max_length,
            ];

        } elseif ($request->field_type === 'number') {

            $fieldValidation = [
                'min' => $request->field_min_value,
                'max' => $request->field_max_value,
            ];

        } elseif (in_array($request->field_type, ['file', 'image'])) {

            $fieldValidation = [
                'extensions' => collect($request->field_extensions ?? [])
                    ->filter()
                    ->values()
                    ->toArray(),
            ];

        }

        $form->update([
            'field_label'       => $request->field_label,
            'field_type'        => $request->field_type,
            'field_help'        => $request->description,
            'field_placeholder' => $request->placeholder,
            'field_required'    => $request->boolean('is_required'),
            'field_options'     => $fieldOptions,
            'field_validation'  => $fieldValidation,
        ]);

        $html = view('event-studio.form-card', [
            'form' => $form->fresh()
        ])->render();

        return response()->json([
            'status'  => true,
            'message' => 'Field berhasil diperbarui.',
            'html'    => $html,
        ]);
    }


    public function deleteForm($event_id, $form_id)
    {
        $form = CustomForm::where('event_id', $event_id)
            ->findOrFail($form_id);

        if ($form->is_system) {
            return response()->json([
                'status' => false,
                'message' => 'System fields cannot be deleted.'
            ], 422);
        }

        $form->delete();

        return response()->json([
            'status' => true,
            'message' => 'Field deleted successfully.'
        ]);
    }

    public function preview($event_id)
    {
        $event = Event::with([
            'tickets',
            'images',
        ])
        ->where('event_id', $event_id)
        ->firstOrFail();

        $forms = CustomForm::where('event_id', $event->id)
            ->orderBy('sort_order')
            ->get();

        return view('event-studio.preview', compact(
            'event',
            'forms'
        ));
    }

    public function publish(Request $request, Event $event)
    {
        abort_if($event->user_id !== auth()->id(), 403);

        /*
        |--------------------------------------------------------------------------
        | Already Published
        |--------------------------------------------------------------------------
        */

        if ($event->event_status !== 'draft') {

            return response()->json([
                'message' => 'This event has already been published.'
            ], 422);

        }

        /*
        |--------------------------------------------------------------------------
        | Basic Information
        |--------------------------------------------------------------------------
        */

        if (blank($event->title)) {

            return response()->json([
                'message' => 'Please complete the event title.'
            ], 422);

        }

        if (blank($event->slug)) {

            return response()->json([
                'message' => 'Please complete the event URL.'
            ], 422);

        }

        if (blank($event->category_id)) {

            return response()->json([
                'message' => 'Please select an event category.'
            ], 422);

        }

        /*
        |--------------------------------------------------------------------------
        | Event Detail
        |--------------------------------------------------------------------------
        */

        if (blank($event->start_date) || blank($event->end_date)) {

            return response()->json([
                'message' => 'Please complete the event schedule.'
            ], 422);

        }

        if (blank($event->description)) {

            return response()->json([
                'message' => 'Please complete the event description.'
            ], 422);

        }

        if (
            $event->location_jenis === 'online' &&
            blank($event->location_online)
        ) {

            return response()->json([
                'message' => 'Please complete the online event link.'
            ], 422);

        }

        if (
            $event->location_jenis === 'offline' &&
            (
                blank($event->location_province) ||
                blank($event->location_city) ||
                blank($event->location_detail)
            )
        ) {

            return response()->json([
                'message' => 'Please complete the event location.'
            ], 422);

        }

        /*
        |--------------------------------------------------------------------------
        | Banner
        |--------------------------------------------------------------------------
        */

        if (blank($event->image)) {

            return response()->json([
                'message' => 'Please upload an event banner.'
            ], 422);

        }

        /*
        |--------------------------------------------------------------------------
        | Ticket
        |--------------------------------------------------------------------------
        */

        if (!$event->tickets()->exists()) {

            return response()->json([
                'message' => 'Please create at least one ticket.'
            ], 422);

        }

        /*
        |--------------------------------------------------------------------------
        | Registration Form
        |--------------------------------------------------------------------------
        */

        if (!CustomForm::where('event_id', $event->id)->exists()) {

            return response()->json([
                'message' => 'Please create at least one registration field.'
            ], 422);

        }

        /*
        |--------------------------------------------------------------------------
        | Publish
        |--------------------------------------------------------------------------
        */

        $event->update([
            'event_status' => 'published',
            'published_at' => now(),
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Event published successfully.',
            'redirect' => route('events.show', $event->slug),
        ]);
    }
}
