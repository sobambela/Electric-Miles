<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class OrderStatusRequest extends FormRequest
{

    /**
     * Custom validate Order status.
     *
     * @return bool
     */
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'order_status',
            function ($attribute, $value, $parameters) {
                $statuses = config('orders.statuses');
                return in_array($value, $statuses);
            },
            'The Order Status must be PENDING, PROCCESSED or DELIVERED!'
        );
    }

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
            'order_status' => 'order_status'
        ];
    }
}
