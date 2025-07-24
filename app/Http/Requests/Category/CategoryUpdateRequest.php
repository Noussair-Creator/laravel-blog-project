<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <-- Import this

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // For now this is okay, but later you will secure it
        return true;
    }

    public function rules(): array
    {
        // Get the category ID from the route
        $categoryId = $this->route('category')->id;

        return [
            // This special syntax tells the validator to ignore the current category ID
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,

            // Change 'text' to 'string'
            'description' => 'nullable|string|max:1000',
        ];
    }
}