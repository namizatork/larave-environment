<?php declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    /**
     * @param int $id
     *
     * @return int
     */
    public function index(string $id): int
    {
        echo $test;
        $array = array();
        return $id;
    }
}
