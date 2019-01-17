<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SortCompletedRounds extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'orderBy' => 'string|in:asc,desc',
            'sortBy' => 'string|in:id,win,chance,bet',
            'perPage' => 'required|numeric',
            'page' => 'required|numeric',
            'room_id' => 'required|exists:rooms,id'
        ];
    }
}
