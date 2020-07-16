<?php

    namespace App\Http\Controllers;

    use App\Order;
    use App\OrderBuilder;
    use App\OrderRequest;
    use App\OrderRequestBuilder;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class OrderController extends Controller
    {
        //

        public function createOrder(Request $request)
        {
            if (!isset($request->title)) {
                return response()->setStatusCode(400)->json(["not order title"]);
            }

            $orderBuilder = new OrderBuilder();
            $orderBuilder->setTitle($request->title);
            $orderBuilder->setDescription($request->description);
            $orderBuilder->setComplited($request->complited);
            $item = $orderBuilder->createItem();
            if ($item != null) {
                return response()->json([$item]);
            } else {
                return response()->json([$orderBuilder]);
            }

        }

        public function createOrderRequwest(Request $request)
        {
            if (isset($request->order_id)) {
                $order_id = $request->order_id;
            } else {
                return response(400)->json(["not order_id"]);
            }

            if (isset($request->user_id)) {
                $user = User::getItem(intval($request->user_id));
            } else {
                $user = Auth::user();
            }

            if ($user == null) {
                return response(400)->json(["not auth"]);
            }

            $order = Order::getItem($order_id);
            if ($order == null) {
                return response(400)->json(["order not found"]);
            }

            $orderRequwest = $order->requwest()->first();

            if ($orderRequwest != null) {
                return response(400)->json(["order request already set"]);
            }

            $orderRequwestBuilder = new OrderRequestBuilder();

            $orderRequwestBuilder->setOrderId($order_id);

            $orderRequwestBuilder->setContractorId($user->id);

            $item = $orderRequwestBuilder->createItem();

            return \response()->json([$item]);

        }

        public function markCompleted(Request $request, $id)
        {


            $order_id = intval($id);

            if ($order_id == false) {
                return \response(400)->json(["wrong id"]);
            }

            $user = Auth::user();
            if ($user == null) {
                return \response(400)->json(["not auth"]);
            }


            $order = Order::getItem($order_id);

            if ($order == null) {
                return \response()->json("order not found");
            }

            $order->markCompleted();

            return \response()->json([$order]);;

        }

        public function cancalOrderRequwest(Request $request, $id)
        {
            $orderRequwest = OrderRequest::getItem($id);
            if ($orderRequwest == null) {
                return \response()->json(["wrong id"]);
            }

            $rezult = $orderRequwest->cancel();

            return \response()->json([$orderRequwest]);
        }

        public function getOrders(Request $request)
        {
            $ordersp = Order::select('*')->get();
            return response()->json($ordersp);
        }

        public function getMyOrderRequwest(Request $request)
        {
            $user = Auth::user();
            if ($user == null) {
                return \response()->json(["not auth"]);
            }

            $orderRequwest = $user->get_orders();
            return response()->json($orderRequwest);
        }

        public function acceptOrder(Request $request)
        {

            $id = $request->order_id;
            $orderRequwest = OrderRequest::getItem(intval($id));
            if ($orderRequwest == null) {
                return \response()->json(["wrong id"]);
            }


            if ($orderRequwest->setInWork()) {
                return response()->json($orderRequwest);
            } else {
                return \response()->json(["is not you order"]);
            }

        }

    }
