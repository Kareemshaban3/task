<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'sub_category_ids' => 'sometimes|array',
            'sub_category_ids.*' => 'sometimes|exists:sub_categories,id',
            'tag_ids' => 'sometimes|array',
            'tag_ids.*' => 'sometimes|exists:tags,id',


            'discount_value' => 'sometimes|numeric|min:0',
            'discount_type'  => 'sometimes|in:percentage,fixed',


            'main_image' => 'sometimes|image|mimes:jpeg,png,jpg|max:5048',

            'other_images' => 'sometimes|array',
            'other_images.*' => 'sometimes|file|mimes:jpeg,png,jpg,mp4,mov,pdf|max:20480',
        ];
    }
}
