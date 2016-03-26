<?php

namespace TestApp\Http\Controllers\Api;

use Auth;
use Carbon\Carbon;
use TestApp\Http\Controllers\Controller;
use TestApp\Http\Requests\ProductRequest;

/**
 * @author Adib Hanna <adibhanna@gmail.com>
 * Class ProductsController
 * @package TestApp\Http\Controllers\Api
 */
class ProductsController extends Controller
{
    /**
     * The authenticated user.
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->user = Auth::user();
    }

    /**
     * Return a paginated list of the product.
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function index()
    {
        return $this->user->products()->latest()->paginate(8);
    }

    /**
     * Return the total product values.
     *
     * @return float
     */
    public function total()
    {
        return (float)$this->user->products()->sum('total_value');
    }

    /**
     * Store a new Product.
     *
     * @param ProductRequest $request
     * @return Product
     */
    public function store(ProductRequest $request)
    {
        $date_added = new Carbon();

        return $this->user->products()->create([
            'product' => [
                'name' => $request->name,
                'price' => (float)$request->price,
                'quantity' => (int)$request->quantity,
                'date_added' => $date_added->now()->format("Y-m-d")
            ],
            'total_value' => (float)$request->price * (int)$request->quantity,
        ]);
    }

    /**
     * Remove a product.
     *
     * @param $id
     * @return json
     */
    public function destroy($id)
    {
        $product = $this->user->products()->findOrFail($id);
        if ($product->delete()) {
            return response('Product deleted.', 200);
        }

        return response('Something wrong happened.');
    }
}
