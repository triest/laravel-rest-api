<?php

    namespace App\Http\Controllers;

    use App\Order;
    use App\OrderBuilder;
    use App\OrderRequest;
    use App\OrderRequestBuilder;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Response;

    class OrderController extends Controller
    {
        //

        public function createOrder(Request $request)
        {
            if (!isset($request->title)) {
                return Response::json(["not order title"], 400);
            }

            $orderBuilder = new OrderBuilder();
            $orderBuilder->setTitle($request->title);
            if (isset($request->description)) {
                $orderBuilder->setDescription($request->description);
            }
            if (isset($request->complited)) {
                $orderBuilder->setComplited($request->complited);
            }


            if (isset($request->intermediary_percentage)) {

                $percent = intval($request->intermediary_percentage);

                if ($percent == false || $percent > 100 || $percent<0) {
                    return Response::json(["not correct percent"], 400);
                }


                $orderBuilder->setIntermediaryPercentage($request->intermediary_percentage);
            }

            $item = $orderBuilder->createItem();

            if ($item != null) {
                return Response::json([$item], 201);
            } else {
                return Response::json([$orderBuilder], 400);
            }

        }

        public function createOrderRequwest(Request $request)
        {
            if (isset($request->order_id)) {
                $order_id = $request->order_id;
            } else {
                return Response::json(["not order_id"], 400);
            }

            if (isset($request->user_id)) {

                $user = User::getItem(intval($request->user_id));
            } else {
                $user = Auth::user();
            }

            if ($user == null) {
                return Response::json(["not auth"], 403);
            }

            $order = Order::getItem($order_id);
            if ($order == null) {
                return Response::json(["order not found"], 422);

            }

            $orderRequwest = $order->requwest()->first();

            if ($orderRequwest != null) {
                return Response::json(["order request already set"], 422);
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
            $user = Auth::user();
            if ($user == null) {
                return Response::json(["not auth"], 403);
            }


            if ($order_id == false) {
                return Response::json(["wrong id"], 422);
            }


            $order = Order::getItem($order_id);

            if ($order == null) {
                return Response::json(["order not found"], 422);
            }

            $order->markCompleted();

            return \response()->json([$order]);;

        }

        public function cancelOrderRequwest(Request $request, $id)
        {
            $order_id = intval($id);
            if ($order_id == false) {
                return Response::json(["wrong id"], 422);
            }

            $orderRequwest = OrderRequest::getItem($id);
            if ($orderRequwest == null) {
                return Response::json(["wrong id"], 422);
            }


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
                return Response::json(["not auth"], 403);
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
