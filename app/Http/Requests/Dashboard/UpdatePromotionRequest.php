<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\Dashboard\Concerns\ValidatesPromotionFields;
use App\Models\Promotion;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
{
    use ValidatesPromotionFields;

    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $promotion = $this->route('promotion');

        return $this->promotionRules(
            $this->slugUniqueRule($promotion instanceof Promotion ? $promotion : null),
        );
    }
}
