<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Resources\LogCollection;
use App\Parsers\ParserStrategy;
use Illuminate\Http\Request;

class Controller extends BaseController
{

    private $parserStratagy;

    public function __construct(ParserStrategy $parserStratagy)
    {
        $this->parserStratagy = $parserStratagy;
    }

    /**
     *
     * @param string $name
     *            Name
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $file = $request->get("file", "");
        $type = $request->get("type", "");
        $field = $request->get("field", "");
        $trim = (int) $request->get("trim", "");
        $count = (int) $request->get("count", "");

        $parser = $this->parserStratagy->getParser($type, [
            "trim" => $trim,
            "count" => $count
        ]);

        $logs = $parser->parse($file);

        $collection = $field ? collect($logs[$field]) : collect($logs);

        return new LogCollection($collection);
    }
}
