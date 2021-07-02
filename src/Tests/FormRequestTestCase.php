<?php

namespace Papaedu\Extension\Tests;

use Tests\TestCase;

class FormRequestTestCase extends TestCase
{
    /**
     * @var mixed
     */
    protected $validator;

    /**
     * @var array
     */
    protected array $rules;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = $this->app['validator'];
//        $this->rules = (new SomeoneRequest())->rules();
    }

    /**
     * @param $field
     * @param $value
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    protected function getFieldValidator($field, $value)
    {
        return $this->validator->make(
            [$field => $value],
            [$field => $this->rules[$field]]
        );
    }

    /**
     * @param $field
     * @param $value
     * @return bool
     */
    protected function validateField($field, $value): bool
    {
        return $this->getFieldValidator($field, $value)->passes();
    }
}
