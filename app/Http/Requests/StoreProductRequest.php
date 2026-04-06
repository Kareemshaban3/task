<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',

            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',

            'price' => 'required|numeric|min:0',
            'sub_category_ids' => 'required|array',
            'sub_category_ids.*' => 'exists:sub_categories,id',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',

            'discount_value' => 'nullable|numeric|min:0',
            'discount_type'  => 'nullable|in:percentage,fixed',


            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:11048',

            'other_images' => 'nullable|array',
            'other_images.*' => 'file|mimes:jpeg,png,jpg,mp4,mov,pdf|max:20480',
        ];
    }
}
