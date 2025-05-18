<?php
namespace  App\Repositories;

use App\DataTables\Dashboard\General\OrderDataTable;
use App\Models\{Branch, Category, Order, Product, Size, Type, Extra, Setting, User};
use App\Services\Contracts\OrderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{OrderProductDetail, OrderProductExtra};
#use Barryvdh\DomPDF\Facade\Pdf;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use App\Enums\Order\OrderStatus;
use Illuminate\Validation\Rule;
class OrderRepository implements OrderInterface
{
    public function index(OrderDataTable $orderDataTable)
    {
        $branches = Branch::select('id', 'name')->get();
        return $orderDataTable->render('dashboard.general.orders.index', [
            'pageTitle' => 'الطلبات',
            'branches' => $branches
        ]);
    }

    public function show(Order $order)
    {
        $order = Order::with(['products', 'details', 'extras'])->findOrFail($order->id);

        // Eager load pivot-related relationships manually
        foreach ($order->products as $product) {
            $pivot = $product->pivot;

            // Load pivot detail with size and type
            if ($pivot) {
                $pivot->loadMissing(['detail.size', 'detail.type', 'extras.extra']);
            }
        }

        return view('dashboard.general.orders.show', ['pageTitle' => 'اظهار طلب', 'order' => $order]);
    }

    public function downloadOrderInvoice(Order $order) {
        $order->load(['products', 'user', 'branch']);
        $order->products->each(function ($product) {
            $product->pivot->load([
                'detail.size',
                'detail.type',
                'extras.extra',
            ]);
        });
        $data = [
            'order_id' => $order->id,
            'total_price' => $order->total_price,
            'payment_type' => optional($order->payment_type)->label() ?? 'غير محدد',
            'order_location' => $order?->order_location,
            'user' => [
                'name' => $order->user->name,
            ],
            'branch' => [
                'name' => $order->branch->name,
                'address' => $order->branch->address,
            ],
            'products' => $order->products->map(function ($product) {
                $detail = $product->pivot->detail;
                return [
                    'name' => $product->name,
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->pivot->price,
                    'size' => $detail && $detail->size ? [
                        'name' => $detail->size->name,
                        'price' => $detail->size_price,
                    ] : null,
                    'type' => $detail && $detail->type ? [
                        'name' => $detail->type->name,
                        'price' => $detail->type->type_price,
                    ] : null,
                    'extras' => $product->pivot->extras->map(function ($extra) {
                        return [
                            'name' => $extra->extra->name ?? '',
                            'price' => $extra->price,
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];
        $pdf = Pdf::loadView('dashboard.layouts.invoice', compact('order', 'data'));
        return $pdf->download('invoice_' . $order->order_number . '.pdf');
    }
    /*public function viewPdf(Order $order) {
            $order = Order::with(['products', 'details', 'extras'])->findOrFail($order->id);
            // Eager load pivot-related relationships manually
            foreach ($order->products as $product) {
                $pivot = $product->pivot;

                // Load pivot detail with size and type
                if ($pivot) {
                    $pivot->loadMissing(['detail.size', 'detail.type', 'extras.extra']);
                }
            }
        PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'defaultFont' => 'Amiri']);
        // return view('dashboard.general.orders.view-pdf', ['pageTitle' => 'اظهار طلب', 'order' => $order]);
        return  PDF::loadView('dashboard.general.orders.view-pdf', compact('    '))->stream();
    }*/

    public function create()
    {
        $branches = Branch::all();
        $products = Product::with(['sizes', 'extras'])->get();
        $sizes = Size::all();
        $types = Type::all();
        $extras = Extra::all();
        $users = User::all();

        return view('dashboard.general.orders.create', [
            'pageTitle' => 'إنشاء طلب جديد',
            'branches' => $branches,
            'products' => $products,
            'sizes' => $sizes,
            'types' => $types,
            'extras' => $extras,
            'users' => $users

        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'is_delivery' => 'required|boolean',
            'order_location' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.size_id' => 'nullable|exists:sizes,id',
            'products.*.size_price' => 'nullable|numeric|min:0',
            'products.*.type_id' => 'nullable|exists:types,id',
            'products.*.type_price' => 'nullable|numeric|min:0',
            'products.*.extras' => 'nullable|array',
            'products.*.extras.*.extra_id' => 'nullable|exists:extras,id',
            'products.*.extras.*.quantity' => 'nullable|integer|min:1',
            'products.*.extras.*.price' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => $request->user_id,
                'branch_id' => $request->branch_id,
                'order_number' => rand(1000, 9999),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'is_delivery' => $request->is_delivery,
                'order_location' => $request->order_location,
                'total_price' => $request->total_price,
            ]);

            foreach ($request->products as $productData) {
                // Attach product to order
                $order->products()->attach($productData['product_id'], [
                    'quantity' => $productData['quantity'],
                    'price' => $productData['price'],
                ]);

                $orderProduct = $order->products()->where('product_id', $productData['product_id'])->first()->pivot;

                // Create product details
                $detail = OrderProductDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productData['product_id'],
                    'order_product_id' => $orderProduct->id,
                    'size_id' => $productData['size_id'] ?? null,
                    'type_id' => $productData['type_id'] ?? null,
                    'size_price' => $productData['size_price'] ?? 0,
                    'type_price' => $productData['type_price'] ?? 0,
                ]);

                // Add extras if any
                if (!empty($productData['extras'])) {
                    foreach ($productData['extras'] as $extra) {
                        OrderProductExtra::create([
                            'order_product_id' => $orderProduct->id,
                            'extra_id' => $extra['extra_id'],
                            'quantity' => $extra['quantity'],
                            'price' => $extra['price'],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('general.orders.index')->with('success', 'تم إنشاء الطلب بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء إنشاء الطلب: ' . $e->getMessage());
        }
    }
    public function edit(Order $order)
    {
        $products = Product::with(['sizes', 'extras'])->get();
        $sizes = Size::all();
        $types = Type::all();
        $extras = Extra::all();
        $settings = Setting::first();

        return view('dashboard.general.orders.edit', [
            'pageTitle' => 'تعديل طلب',
            'order' => $order,
            'products' => $products,
            'sizes' => $sizes,
            'types' => $types,
            'extras' => $extras,
            'settings' => $settings,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
            'payment_status' => 'required|string|max:255',
            'total_price' => 'required|numeric',
            'order_location' => 'nullable|string|max:255',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'total_price' => $request->total_price,
            'order_location' => $request->order_location,
        ]);

        // Sync order products
        $order->products()->detach();

        foreach ($request->products as $product) {
            $order->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        return redirect()->route('general.orders.index')->with('success', 'تم تحديث الطلب بنجاح');
    }

    public function destroy(Order $order){
        $order->products()->detach();
        $order->delete();
        return redirect()->route('general.orders.index')->with('success', 'تم الحذف بنجاح!');
    }

    public function updateStatus(Request $request, Order $order) {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_column(OrderStatus::cases(), 'value'))],
        ]);
        $order->status = $validated['status'];
        $order->save();
        $statusEnum = OrderStatus::from($validated['status']);
        return [
            'badgeColor' => $statusEnum->badgeColor(),
            'label' => $statusEnum->label(),
        ];
    }
}
