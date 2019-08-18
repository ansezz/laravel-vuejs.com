<?php

namespace Ansezz\CategoriesField\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelVueJs\Models\Category;

class CategoriesFieldController extends Controller
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('filter.containing')) {
            $query->where('name', 'like', '%' . $request['filter']['containing'] . '%');
        }

        if ($request->has('filter.type')) {
            $query->where('type', $request['filter']['type']);
        }

        if ($request->has('limit')) {
            $query->limit($request['limit']);
        }

        return $query->get()->map(function (Category $category) {
            return $category->name;
        });
    }
}
