<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <-- Import this

class CategoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // For now this is okay, but later you will secure it
        return true;
    }

    public function rules(): array
    {
        return [
            // Add the 'unique' rule to prevent duplicate names
            'name' => 'required|string|max:255|unique:categories,name',

            // Change 'text' to 'string'
            'description' => 'nullable|string|max:1000',
        ];
    }
}
