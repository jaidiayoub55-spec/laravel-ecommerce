<?php 
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($product_id)
    {
        return Review::with('user')
            ->where('product_id', $product_id)
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required'
        ]);

        return Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);
    }
}
