<?php

declare(strict_types=1);

use Tnt\DataList\Input\GetParams;

it('reads values from the current GET parameters', function (): void {
    $previousGet = $_GET;
    $_GET = ['page' => '3', 'search' => 'boots'];

    try {
        $input = new GetParams();

        expect($input->has('page'))->toBeTrue();
        expect($input->get('page'))->toBe('3');
        expect($input->has('missing'))->toBeFalse();
    } finally {
        $_GET = $previousGet;
    }
});
