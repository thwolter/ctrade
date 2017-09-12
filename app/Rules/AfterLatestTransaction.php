<?php

namespace App\Rules;

use App\Entities\Portfolio;
use Illuminate\Contracts\Validation\Rule;

class AfterLatestTransaction implements Rule
{

    protected $portfolio;

    /**
     * Create a new rule instance.
     *
     * @param Portfolio $portfolio
     * @return void
     */
    public function __construct($portfolio)
    {
        $this->portfolio = $portfolio;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value >= $this->portfolio->latestTransactionDate()->toDateString();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.transaction.after');
    }
}
