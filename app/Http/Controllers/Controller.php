<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Resources\LogCollection;
use App\Parsers\ParserStrategy;
use Illuminate\Http\Request;
use App\LogChart;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{

    private $parserStratagy;

    /**
     *
     * @var LogChart
     */
    private $logChart;

    public function __construct(ParserStrategy $parserStratagy, LogChart $logChart)
    {
        $this->parserStratagy = $parserStratagy;
        $this->logChart = $logChart;
    }

    /**
     *
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

    /**
     *
     * @param string $name
     *            Name
     * @return \Illuminate\Http\JsonResponse
     */
    public function chart(Request $request)
    {
        $file = $request->get("file", "");
        $type = $request->get("type", "");
        $field = $request->get("field", "");

        if (! $field) {
            return Response::make("Field is missing", 404);
        }

        $parser = $this->parserStratagy->getParser($type, []);

        $logs = $parser->parse($file);

        if (isset($logs[$field])) {
            $this->logChart->getChart($logs[$field], 5, LogChart::TYPE_IMAGE_RENDER);
        } else {
            return Response::make("No data found for field - " . $field, 404);
        }
    }
}
