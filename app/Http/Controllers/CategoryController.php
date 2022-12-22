<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function categories(Request $request)
    {
        $categories = Category::latest()->get();
        $data = $categories->map(function ($category) {
            return [
                'name' => $category->name,
                'key' => $category->slug,
                'link' => [
                    'self' => env('BASE_API') . '/recipes/category/' . $category->slug
                ]
            ];
        });
        return response()->json([
            'status' => true,
            'code' => 200,
            'total' => $categories->count(),
            'data' => $data
        ], 200);
    }
    public function category($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return response()->json([
                'status' => false,
                'error' => 'Category Not Found',
                'code' => 404,
            ], 404);
        }

        if ($request->search && $request->paginate && is_numeric($request->paginate)) {
            $recipes = Recipe::where('category_id', $category->id)->with('category')->where('title', 'like', '%' . $request->search . '%')->latest()->paginate($request->paginate);
            return $this->responseData($recipes, $request->paginate, $request->page, $request->search);
        }
        if ($request->search) {
            $recipes = Recipe::where('category_id', $category->id)->with('category')->where('title', 'like', '%' . $request->search . '%')->latest()->get();
            return $this->responseData($recipes);
        }
        if ($request->paginate && is_numeric($request->paginate)) {
            $recipes = Recipe::where('category_id', $category->id)->with('category')->latest()->paginate($request->paginate);
            return $this->responseData($recipes, $request->paginate, $request->page);
        }
        $recipes = Recipe::where('category_id', $category->id)->with('category')->latest()->get();
        return $this->responseData($recipes);
    }

    public function responseData($recipes, $paginate = null, $page = null, $search = null)
    {
        // dd($recipes);
        $paginate = $paginate ? floor($paginate) : null;
        $data = $recipes->map(function ($recipe) {
            return [
                'title' => $recipe->title,
                'key' => $recipe->slug,
                'image' => $recipe->image_url,
                'times' => $recipe->times,
                'servings' => $recipe->servings,
                'publishedDate' => $recipe->published,
                'author' => [
                    'name' => $recipe->author_name,
                    'avatar' => $recipe->author_avatar,
                ],
                'category' => [
                    'name' => $recipe->category->name,
                    'key' => $recipe->category->slug,
                ],
                'links' => [
                    'self' => env('BASE_API') . '/recipe/' . $recipe->slug,
                    'category' => env('BASE_API') . '/recipes/category/' . $recipe->category->slug,
                ],
            ];
        });
        return response()->json([
            'status' => true,
            'code' => 200,
            'total' => $paginate ? $recipes->total() : $data->count(),
            'pagination' => $paginate && $recipes->total() !== 0 && $page <= $recipes->lastPage() ? [
                'perPage' => $paginate,
                'currentPage' => $recipes->currentPage(),
                'lastPage' => $recipes->lastPage(),
                'firstPageUrl' =>  $search ? $recipes->path() . '?search=' . $search . '&paginate=' . $paginate : $recipes->path() . '?paginate=' . $paginate,
                'currentPageUrl' => $search ? $recipes->path() . '?search=' . $search . '&paginate=' . $paginate . '&page=' . $recipes->currentPage() : $recipes->path() . '?paginate=' . $paginate . '&page=' . $recipes->currentPage(),
                'lastPageUrl' => $search ? $recipes->path() . '?search=' . $search . '&paginate=' . $paginate . '&page=' . $recipes->lastPage() : $recipes->path() . '?paginate=' . $paginate . '&page=' . $recipes->lastPage(),
                'nextPageUrl' => ($recipes->currentPage() == $recipes->lastPage()) ? null : ($search ? $recipes->path() . '?search=' . $search . '&paginate=' . $paginate . '&page=' . $recipes->currentPage() + 1 : $recipes->path() . '?paginate=' . $paginate . '&page=' . $recipes->currentPage() + 1),
                'prevPageUrl' => ($recipes->currentPage() == 1) ? null : ($search ? $recipes->path() . '?search=' . $search . '&paginate=' . $paginate . '&page=' . $recipes->currentPage() - 1 : $recipes->path() . '?paginate=' . $paginate . '&page=' . $recipes->currentPage() - 1),

            ] : [],
            'data' => $data,
        ], 200);
    }
}
