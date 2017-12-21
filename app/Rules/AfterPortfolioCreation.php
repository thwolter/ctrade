<?php

namespace App\Rules;

use App\Entities\Portfolio;
use Illuminate\Contracts\Validation\Rule;

class AfterPortfolioCreation implements Rule
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
        if ($date = $this->portfolio->opened_at) {
            return $value >= $date->toDateString();
        } else {
            return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Transaktion darf nicht vor der Erstellung des Portfolios liegen.';
    }
}
