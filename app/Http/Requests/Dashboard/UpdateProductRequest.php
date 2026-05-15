<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\Dashboard\Concerns\ValidatesProductFields;
use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    use ValidatesProductFields;

    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $product = $this->route('product');

        return $this->productRules(
            $this->slugUniqueRule($product instanceof Product ? $product : null),
        );
    }
}
